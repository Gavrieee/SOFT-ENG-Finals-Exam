<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$job_posts_id = intval($_GET['job_posts_id']);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button onclick="history.back()">Back</button>
    <h1>Delete Post</h1>
    <p>This is the Delete Post page.</p>
    <?php echo $job_posts_id; ?>
    <?php echo $_SESSION['username']; ?>
    <?php $getPostByID = getPostByID($pdo, $job_posts_id); ?>

    <label for="">
        <h2>Are you sure you want to delete this Job Post below?</h2>
    </label>


    <p>
        <img src="job_posts/<?php echo $getPostByID['title']; ?>" alt="">
    </p>
    <p>
        <?php echo $getPostByID['description']; ?>
    </p>
    <p>
        <?php echo $getPostByID['created_at']; ?>
    </p>

    <form action="core/handleForms.php" method="POST">
        <p>

            <input type="hidden" name="job_post_name" value="<?php echo $getPostByID['title']; ?>">
            <input type="hidden" name="job_posts_id" value="<?php echo $_GET['job_posts_id']; ?>">
            <input type="submit" name="deletePhotoBtn" style="margin-top: 10px;" value="Delete">
        </p>
    </form>

</body>

</html>