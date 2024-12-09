<?php

require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SESSION['role'] !== 'Applicant') {
    header("Location: login.php");
    exit();
}

checkRole('Applicant');

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button onclick="history.back()">Back</button>
    <h1>Application</h1>
    <p>This is the Application page.</p>
    <p><?php echo $_GET['job_post_id']; ?></p>

    <!-- <?php $job_posts_id = intval($_GET['job_post_id']); ?>
    <?php echo $job_posts_id ?> -->
    <!-- <?php echo $job['status'] ?> -->


    <?php $checkApplication = checkApplication($pdo, $_SESSION['id']); { ?>
        <!-- <?php echo $checkApplication['status']; ?> -->
    <?php } ?>



    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
        <?php $job = getJobDetails($pdo, $_GET['job_post_id']); { ?>
            <img src="job_posts/<?php echo $job['title']; ?>" alt="">

            <?php $job_post_id = intval($_GET['job_post_id']); ?>

            <!-- DEGUGGING -->

            <input type="hidden" name="job_post_id" value="<?php echo $job_post_id; ?>">
            <!-- <input type="hidden" name="applications_id" value="<?php echo $applications_id; ?>"> -->

            <!-- DEBUGGING -->

            <p>Posted by: HR. <?php echo htmlspecialchars($job['created_by_name']); ?></p>
            <p>Description: <?php echo htmlspecialchars($job['description']); ?></p>

            <textarea name="message" placeholder="..." required></textarea>
            <br>
            <input type="file" name="resume" accept="application/pdf" required>
            <br>
            <button type="submit" name="submitApplicationBttn">Submit Application</button>
        <?php } ?>
    </form>




</body>

</html>