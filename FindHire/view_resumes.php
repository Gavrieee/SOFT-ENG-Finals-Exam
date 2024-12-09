<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

// Check if user is logged in and is an HR
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'HR') {
    die("Unauthorized access.");
}

$job_posts_id = intval($_GET['job_posts_id']);
$applications_id = getApplicationIDByJobPost($pdo, $job_posts_id);

$user_id = $_SESSION['username'];


?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- <button onclick="history.back()">Back</button> -->

    <a href="index.php">Back</a>

    <h1>View Resume per Post</h1>
    <p>This is the View Resume per Post page.</p>
    <p>
        <?php echo $job_posts_id; ?>
        <?php echo $_SESSION['username']; ?>
    </p>
    <p>
        <?php $getPostByID = getPostByID($pdo, $job_posts_id); ?>
    <p>
        <img src="job_posts/<?php echo $getPostByID['title']; ?>" alt="">
    </p>
    <h3>
        <?php echo $getPostByID['created_by_name']; ?>
    </h3>
    <p>
        <?php echo $getPostByID['description']; ?>
    </p>
    <p>
        <i><?php echo $getPostByID['created_at']; ?></i>
    </p>
    <?php ?>
    </p>

    <?php var_dump($_POST); ?>


    <?php $applications = getApplicationsByJobPost($pdo, $job_posts_id); ?>

    <?php if (empty($applications)) { ?>
        <p>No applications found for this job post.</p>
    <?php } else { ?>
        <?php foreach ($applications as $application) { ?>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Submitted at</th>
                    <th>Message</th>
                    <th>Resume File</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><a
                            href="message.php?receiver_id=<?php echo $application['applicant_id']; ?>"><strong><?php echo htmlspecialchars($application['username']); ?></strong></a>
                    </td>
                    <td><?php echo htmlspecialchars($application['submitted_at']); ?></td>
                    <td><?php echo htmlspecialchars($application['messages']); ?></td>
                    <td><a href="resumes/<?php echo htmlspecialchars($application['resume_path']); ?>" target="_blank">View
                            Resume</a></td>
                    <td><?php echo htmlspecialchars($application['status']); ?></td>
                    <td>
                        <?php if ($application['status'] == 'Pending')
                            ; { ?>
                            <form action="core/handleForms.php" method="POST">

                                <?php $applicant_id = $application['applicant_id']; ?>
                                <input type="hidden" name="job_posts_id" value="<?php echo $job_posts_id; ?>">
                                <input type="hidden" name="applications_id" value="<?php echo $applications_id; ?>">

                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                                <input type="hidden" name="applicant_id" value="<?php echo $applicant_id; ?>">

                                <!-- DEBUGGING -->
                                <?php $job_post_description = $getPostByID['description']; ?>

                                <input type="hidden" name="job_post_description" value="<?php echo $job_post_description; ?>">
                                <!-- DEBUGGING -->


                                <?php if (in_array($application['status'], ['Accepted', 'Rejected'])) { ?>
                                    <input type="submit" name="undoButton" value="Undo">
                                <?php } else { ?>
                                    <input type="submit" name="acceptButton" value="Accept">
                                    <input type="submit" name="rejectButton" value="Reject">
                                <?php } ?>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        <?php } ?>

    <?php } ?>



</body>

</html>