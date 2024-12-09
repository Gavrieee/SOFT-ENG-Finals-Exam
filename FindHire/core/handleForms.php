<?php

require_once('dbConfig.php');
require_once('models.php');

if (isset($_POST['loginUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $loginQuery = checkIfUserExists($pdo, $username);
        $userIDFromDB = $loginQuery['userInfoArray']['id'];
        $usernameFromDB = $loginQuery['userInfoArray']['username'];
        $first_nameFromDB = $loginQuery['userInfoArray']['first_name'];
        $passwordFromDB = $loginQuery['userInfoArray']['password'];
        $userRoleFromDB = $loginQuery['userInfoArray']['role'];

        if (password_verify($password, $passwordFromDB)) {
            $_SESSION['id'] = $userIDFromDB;
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['first_name'] = $first_nameFromDB;
            $_SESSION['role'] = $userRoleFromDB;
            header("Location: ../index.php");
        } else {
            $_SESSION['message'] = "Username/password invalid";
            $_SESSION['status'] = "400";
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../login.php");
    }

}

if (isset($_POST['insertNewUserBtn'])) {
    $username = trim($_POST['username']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($email) && !empty($role) && !empty($password) && !empty($confirm_password)) {

        if ($password == $confirm_password) {

            define('HR_CODE', 'admin123'); // HR Code

            // HR-specific validation
            if ($role === 'hr') {
                $hr_code = $_POST['hr_code'];
                if ($hr_code !== HR_CODE) {
                    header("Location: ../register.php");
                    $_SESSION['message'] = "Invalid HR Code. Please contact your administrator.";
                    $_SESSION['status'] = '400';
                    die();
                }
            }

            $insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, $email, $role, password_hash($password, PASSWORD_DEFAULT));
            $_SESSION['message'] = $insertQuery['message'];

            if ($insertQuery['status'] == '200') {
                $_SESSION['message'] = $insertQuery['message'];
                $_SESSION['status'] = $insertQuery['status'];
                header("Location: ../login.php");
            } else {
                $_SESSION['message'] = $insertQuery['message'];
                $_SESSION['status'] = $insertQuery['status'];
                header("Location: ../register.php");
            }

        } else {
            $_SESSION['message'] = "Please make sure both passwords are equal";
            $_SESSION['status'] = '400';
            header("Location: ../register.php");
        }

    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../register.php");
    }
}

if (isset($_GET['logoutButton'])) {
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['role']);
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['insertJobPost'])) {

    // $id = $_SESSION['id'];

    $postDescription = $_POST['postDescription'];
    $fileName = $_FILES['image']['name'];
    $tempFileName = $_FILES['image']['tmp_name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueID = sha1(md5(rand(1, 9999999)));
    $imageName = $uniqueID . "." . $fileExtension;

    // If we want edit a post
    if (isset($_POST['job_posts_id'])) {
        $job_posts_id = $_POST['job_posts_id'];
    } else {
        $job_posts_id = "";
    }

    $savePostToDB = writeJobPost($pdo, $imageName, $postDescription, $_SESSION['id'], $job_posts_id);

    if ($savePostToDB) {

        $folder = "../job_posts/" . $imageName;

        // Move file to the specified path 
        if (move_uploaded_file($tempFileName, $folder)) {
            header("Location: ../index.php");
        }
    } else {
        header("Location: index.php");
        echo "Something went wrong";
    }
}

if (isset($_POST['submitApplicationBttn'])) {

    $applicant_id = $_SESSION['id'];
    $job_post_id = intval($_POST['job_post_id']);

    $messages = $_POST['message'];
    $fileName = $_FILES['resume']['name'];
    $tempFileName = $_FILES['resume']['tmp_name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueID = sha1(md5(rand(1, 9999999)));
    $resumeName = $uniqueID . "." . $fileExtension;

    $insertResumeToDB = insertResumeToDB($pdo, $job_post_id, $applicant_id, $messages, $resumeName, $applications_id);

    if ($insertResumeToDB) {

        $folder = "../resumes/" . $resumeName;

        // Move file to the specified path 
        if (move_uploaded_file($tempFileName, $folder)) {
            header("Location: ../index.php");
        }
    } else {

        echo "<h1>Something went wrong<h1>";
    }
}

if (isset($_POST['deletePhotoBtn'])) {
    $title = $_POST['title'];
    $job_posts_id = $_POST['job_posts_id'];
    $deleteJobPost = deleteJobPost($pdo, $job_posts_id);

    if ($deleteJobPost) {
        unlink("../job_posts/" . $title);
        header("Location: ../index.php");
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'send_message') {
    $content = $_POST['content'];
    $receiver_id = $_POST['receiver_id'];
    $sender_id = $_SESSION['id']; // The logged-in user's ID stored in the session
    $job_post_id = isset($_POST['job_posts_id']) ? $_POST['job_posts_id'] : null; // Check if job_post_id is set
    $sender_username = $_SESSION['username'];
    $message = "You have received a new message from $sender_username.";

    $notification_link = "message.php?receiver_id=$sender_id";
    

    // Call the sendMessage function to handle inserting the message into the database
    $result = sendMessage($pdo, $sender_id, $receiver_id, $content);

    $insertNotification = insertNotification($pdo, $receiver_id, $job_post_id, $message, $notification_link);

    if ($insertNotification) {
        // Redirect based on the success of the message sending
        if ($result['success']) {
            header("Location: ../message.php?receiver_id=$receiver_id");
            exit;
        } else {
            header("Location: ../message.php?receiver_id=$receiver_id&error=" . urlencode($result['message']));
            exit;
        }
    }
}

if (isset($_POST['acceptButton']) || isset($_POST['rejectButton']) || isset($_POST['undoButton'])) {
    $job_posts_id = $_POST['job_posts_id'];
    // $applicant_id = $_POST['applicant_id'];
    $applications_id = $_POST['applications_id'];
    $HR_id = $_POST['user_id'];
    $applicant_id = $_POST['applicant_id'];
    $message = '';
    $notification_link = "application.php?job_post_id=$job_posts_id";

    if (isset($_POST['acceptButton'])) {
        $newStatus = 'Accepted';
        $jobPostDescription = $_POST['job_post_description']; // Assuming the title is also passed or fetched
        $message = "Congratulations! Your application for <i>$jobPostDescription</i> posted by <b>$HR_id</b> has been accepted.";
    } elseif (isset($_POST['rejectButton'])) {
        $newStatus = 'Rejected';
        $jobPostDescription = $_POST['job_post_description'];
        $message = "We're sorry. Your application for <i>$jobPostDescription</i> posted by <b>$HR_id</b> has been rejected.";
    } elseif (isset($_POST['undoButton'])) {
        $newStatus = 'Pending';
    }

    $resumeAction = resumeAction($pdo, $newStatus, $applications_id);

    if ($message) {
        $insertNotification = insertNotification($pdo, $applicant_id, $job_posts_id, $message, $notification_link);
    }

    if ($resumeAction && ($message ? $insertNotification : true)) {
        header("Location: ../view_resumes.php?job_posts_id=$job_posts_id");
    } else {
        header("Location: ../unauthorized.php");
    }
    exit();
}

if (isset($_GET['notification_id'])) {

    $status = 'Read';
    $notification_id = $_POST['notification_id'];

    $seenNotification = seenNotification($pdo, $status, $notification_id);

    if ($seenNotification) {
        exit();
    }

}

?>