<?php

require_once('dbConfig.php');


function checkIfUserExists($pdo, $username)
{
    $response = array();
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username])) {

        $userInfoArray = $stmt->fetch();

        if ($stmt->rowCount() > 0) {
            $response = array(
                "result" => true,
                "status" => "200",
                "userInfoArray" => $userInfoArray
            );
        } else {
            $response = array(
                "result" => false,
                "status" => "400",
                "message" => "User doesn't exist from the database"
            );
        }
    }

    return $response;

}

function insertNewUser($pdo, $username, $first_name, $last_name, $email, $role, $password)
{
    $response = array();
    $checkIfUserExists = checkIfUserExists($pdo, $username);

    if (!$checkIfUserExists['result']) {

        $checkEmail = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($checkEmail);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $response = array(
                "status" => "400",
                "message" => "This email is already in use!"
            );

        } else {
            $sql = "INSERT INTO users (username, first_name, last_name, email, role, password) VALUES (?,?,?,?,?,?)";

            $stmt = $pdo->prepare($sql);
            $executeQuery = $stmt->execute([$username, $first_name, $last_name, $email, $role, $password]);

            if ($executeQuery) {
                $response = array(
                    "status" => "200",
                    "message" => "User successfully inserted!"
                );
            } else {
                $response = array(
                    "status" => "400",
                    "message" => "An error occured with the query!"
                );
            }
        }
    } else {
        $response = array(
            "status" => "400",
            "message" => "User already exists!"
        );
    }

    return $response;
}

function checkRole($requiredRole)
{
    if ($_SESSION['role'] !== $requiredRole) {
        header('Location: unauthorized.php'); // Redirect to a custom error page
        exit;
    }
}

function getAllUsers($pdo)
{
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getUserByID($pdo, $username)
{
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$username]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function writeJobPost($pdo, $imageName, $postDescription, $created_by, $job_posts_id = null)
{

    if (empty($job_posts_id)) {
        $sql = "INSERT INTO job_posts (title, description, created_by) VALUES(?,?,?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$imageName, $postDescription, $created_by]);

        if ($executeQuery) {
            return true;
        }
    } else {
        $sql = "UPDATE job_posts SET title = ?, description = ?, created_by = ? WHERE job_posts_id = ?";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$imageName, $postDescription, $created_by, $job_posts_id]);

        if ($executeQuery) {
            return true;
        }
    }
}

function insertResumeToDB($pdo, $job_post_id, $applicant_id, $messages, $resumePath, $applications_id = null)
{
    if (empty($applications_id)) {
        $sql = "INSERT INTO applications (job_post_id, applicant_id, messages, resume_path) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$job_post_id, $applicant_id, $messages, $resumePath]);

        if ($executeQuery) {
            return true;
        } else {
            $sql = "UPDATE applications SET job_post_id = ?, applicant_id = ?, messages = ?, resume_path = ? WHERE applications_id = ?";
            $stmt = $pdo->prepare($sql);
            $executeQuery = $stmt->execute([$job_post_id, $applicant_id, $messages, $resumePath, $applications_id]);

            if ($executeQuery) {
                return true;
            }
        }
    }
}

function showJobPosts($pdo, $created_by = null)
{
    if (empty($created_by)) {
        // Join job_posts with users to fetch the username of created_by
        $sql = "SELECT job_posts.*, users.username AS created_by_name 
            FROM job_posts 
            JOIN users ON job_posts.created_by = users.id
            ORDER BY job_posts.created_at DESC
        ";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute();

        if ($executeQuery) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        $sql = "SELECT job_posts.*, users.username AS created_by_name 
            FROM job_posts 
            JOIN users ON job_posts.created_by = users.id
            WHERE job_posts.created_by = ?
            ORDER BY job_posts.created_at DESC
        ";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$created_by]);

        if ($executeQuery) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}

function showJobPostsProfile($pdo, $username = null)
{
    if (empty($username)) {
        // Join job_posts with users to fetch the username of created_by
        $sql = "SELECT job_posts.*, users.username AS created_by_name 
                FROM job_posts 
                JOIN users ON job_posts.created_by = users.id
                ORDER BY job_posts.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute();

        if ($executeQuery) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        // Filter job posts by username
        $sql = "SELECT job_posts.*, users.username AS created_by_name 
                FROM job_posts 
                JOIN users ON job_posts.created_by = users.id
                WHERE users.username = ?
                ORDER BY job_posts.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username]);

        if ($executeQuery) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}

function getJobDetails($pdo, $job_post_id)
{
    $sql = $pdo->prepare("
        SELECT job_posts.*, users.username AS created_by_name 
        FROM job_posts 
        JOIN users ON job_posts.created_by = users.id 
        WHERE job_posts.job_posts_id = ?
    ");
    $sql->execute([$job_post_id]);

    if ($sql) {
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}

function getPostByID($pdo, $job_posts_id)
{
    $sql = "SELECT job_posts.*, users.username AS created_by_name 
            FROM job_posts 
            JOIN users ON job_posts.created_by = users.id 
            WHERE job_posts.job_posts_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$job_posts_id]);

    if ($executeQuery) {
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch one record as an associative array
    } else {
        return null; // Return null if no record is found
    }
}

function deleteJobPost($pdo, $job_posts_id)
{
    $sql = "DELETE FROM job_posts WHERE job_posts_id  = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$job_posts_id]);

    if ($executeQuery) {
        return true;
    }

}

function getApplicationsByJobPost($pdo, $job_posts_id)
{
    $sql = "SELECT applications.*, users.username FROM applications JOIN users ON applications.applicant_id = users.id WHERE applications.job_post_id = ? ORDER BY applications.submitted_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$job_posts_id]);
    $executeQuery = $stmt->execute([$job_posts_id]);

    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function showMessages($pdo, $sender_id, $receiver_id)
{
    $sql = "SELECT messages.*, users.username AS sender_name 
            FROM messages
            JOIN users ON messages.sender_id = users.id
            WHERE (messages.sender_id = ? AND messages.receiver_id = ?)
               OR (messages.sender_id = ? AND messages.receiver_id = ?)
            ORDER BY messages.timestamp ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);

    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function sendMessage($pdo, $sender_id, $receiver_id, $content, $job_post_id = null)
{
    if (empty($content) || empty($receiver_id)) {
        return [
            'success' => false,
            'message' => 'Missing data'
        ];
    }

    try {
        $sql = "INSERT INTO messages (sender_id, receiver_id, content, job_post_id) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sender_id, $receiver_id, $content, $job_post_id]);

        return [
            'success' => true,
            'message' => 'Message sent successfully'
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Failed to send message: ' . $e->getMessage()
        ];
    }
}

function resumeAction($pdo, $newStatus, $applications_id)
{
    $sql = "UPDATE applications SET status = ? WHERE applications_id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$newStatus, $applications_id])) {
        return true;
    } else {
        // Debugging the issue
        $errorInfo = $stmt->errorInfo();
        die("SQL Error: " . $errorInfo[2]);
    }
}

function getApplicationIDByJobPost($pdo, $job_posts_id)
{
    $sql = "SELECT applications_id 
            FROM applications 
            WHERE job_post_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$job_posts_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['applications_id'];
    } else {
        return null; // Return null if no application is found
    }
}

function insertNotification($pdo, $user_id, $job_post_id, $message, $notification_link)
{

    $sql = "INSERT INTO notifications (user_id, job_post_id, message, notification_link) VALUES (?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$user_id, $job_post_id, $message, $notification_link]);

    if ($executeQuery) {
        return true;
    }

}

function showNotificationByID($pdo, $user_id)
{
    $sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$user_id]);

    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function truncateText($text, $maxLength = 65)
{ // To shorten text for notifications
    if (strlen($text) > $maxLength) {
        return substr($text, 0, $maxLength) . '...';
    }
    return $text;
}

function seenNotification($pdo, $status, $notification_id)
{
    $sql = "UPDATE notifications SET status = ? WHERE notification_id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$status, $notification_id])) {
        return true;
    }
}

function getApplicationStatus($pdo, $applicant_id, $job_post_id)
{
    $sql = "SELECT status FROM applications WHERE applicant_id = ? AND job_post_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$applicant_id, $job_post_id]);

    if ($executeQuery) {
        return $stmt->fetchColumn(); // Fetch only the status column value
    }

    return null; // Return null if the query fails
}

?>
