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
    <a href="logout.php">Logout</a>
    <h1>Applicant Dashboard</h1>
    <p>This is the Applicant Dashboard.</p>
    <p><?php echo $_SESSION['username']; ?></p>
    <p>
        <?php $showJobPosts = showJobPosts($pdo); { ?>
            <?php foreach ($showJobPosts as $row) { ?>
            <div style="border: 3px solid black; margin: 10px;">
                <img src="job_posts/<?php echo $row['title']; ?>" alt="">
                <a href="profile.php?username=<?php echo $row['created_by_name']; ?>">
                    <h2><?php echo $row['created_by_name']; ?></h2>
                </a>
                <p><i><?php echo $row['created_at']; ?></i></p>
                <h4><?php echo $row['description']; ?></h4>

                <?php if ($_SESSION['role'] == 'Applicant') { ?>
                    <?php echo "Hi"; ?>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
    </p>


</body>

</html>