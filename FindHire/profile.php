<?php

require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button onclick="history.back()">Back</button>
    <h1>Profile page</h1>
    <p>This is <?php echo $_GET['username'] ?>'s profile page.</p>


    <?php $getUserByID = getUserByID($pdo, $_GET['username']); { ?>

        <p><b>Username</b>: <?php echo $getUserByID['username']; ?></p>
        <p><b>Full Name</b>: <?php echo $getUserByID['first_name'] . ' ' . $getUserByID['last_name']; ?></p>
        <p><b>Email</b>: <?php echo $getUserByID['email']; ?></p>

        <!-- DEBUGGING -->
        <p><b>ID</b>: <?php echo $getUserByID['id']; ?></p>

    <?php } ?>

    <?php echo $_GET['username']; ?>
    <?php echo $getUserByID['username']; ?>


    <?php if ($_SESSION['id'] !== $getUserByID['id']) { ?>
        <p>
            <a href="message.php?receiver_id=<?php echo $getUserByID['id']; ?>">Message</a>
        </p>
    <?php } else { ?>
    <?php } ?>


    <?php $username = $_GET['username']; ?>

    <?php $showJobPostsProfile = showJobPostsProfile($pdo, $username); ?>
    <?php foreach ($showJobPostsProfile as $row) { ?>
        <div style="border: 3px solid black; margin: 10px;">
            <img src="job_posts/<?php echo $row['title']; ?>" alt="">


            <h2><?php echo $row['created_by_name']; ?></h2>

            <p><i><?php echo $row['created_at']; ?></i></p>
            <h4><?php echo $row['description']; ?></h4>

            <?php if ($_SESSION['id'] == $row['created_by_name']) { ?>
                <a href="editphoto.php?jobpost_id=<?php echo $row['job_posts_id']; ?>"> Edit </a>
                <br>
                <br>
                <a href="deletephoto.php?jobpost_id=<?php echo $row['job_posts_id']; ?>"> Delete</a>
                <br>
                <br>
            <?php } ?>
            <?php if ($_SESSION['role'] == 'Applicant') { ?>
                <?php echo "You, an applicant, should be able to message and apply directly in this post."; ?>
                <br>
                <a href="application.php?job_post_id=<?php echo $row['job_posts_id']; ?>">Apply Now</a>

            <?php } ?>
        </div>
    <?php } ?>


</body>

</html>