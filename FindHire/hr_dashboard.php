<?php

require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SESSION['role'] !== 'HR') {
    header("Location: login.php");
    exit();
}

checkRole('HR');

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="logout.php">Logout</a>
    <h1>HR Dashboard</h1>
    <p>This is the HR Dashboard.</p>
    <?php echo $_SESSION['username']; ?>
    <?php echo $_SESSION['id']; ?>

    <?php if ($_SESSION['role'] == 'HR') { ?>
        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="jobPost">Write a job post.</label>
            </p>
            <p>
                <input type="text" name="postDescription" id="postDescription">
            </p>

            <p>
                <label for="JobPost">Upload an image.</label>
                <input type="file" name="image">

            </p>
            <p>
                <input type="submit" name="insertJobPost">
            </p>
        </form>
    <?php } ?>

    <p>
        <?php $showJobPosts = showJobPosts($pdo); ?>
        <?php foreach ($showJobPosts as $row) { ?>
        <div style="border: 3px solid black; margin: 10px;">
            <img src="job_posts/<?php echo $row['title']; ?>" alt="">

            <a href="profile.php?username=<?php echo $row['created_by_name']; ?>">
                <h2><?php echo $row['created_by_name']; ?></h2>
            </a>
            <p><i><?php echo $row['created_at']; ?></i></p>
            <h4><?php echo $row['description']; ?></h4>

            <?php if ($_SESSION['username'] == $row['created_by_name']) { ?>
                <a href="editphoto.php?jobpost_id=<?php echo $row['job_posts_id']; ?>"> Edit </a>
                <br>
                <br>
                <a href="deletephoto.php?jobpost_id=<?php echo $row['job_posts_id']; ?>"> Delete</a>
                <br>
                <br>
            <?php } ?>
            <?php if ($_SESSION['role'] == 'Applicant') { ?>
                <?php echo "You should be able to message and apply directly in this post."; ?>
                <a href="">Apply</a>
            <?php } ?>
        </div>
    <?php } ?>
    </p>


</body>

</html>