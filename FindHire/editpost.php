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
    <h1>Edit Post</h1>
    <p>This is the Edit Post page.</p>
    <?php echo $job_posts_id; ?>
    <?php $getPostByID = getPostByID($pdo, $job_posts_id); ?>
    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
        <p>
            <img src="job_posts/<?php echo $getPostByID['title']; ?>" alt="">
        </p>
        <p>
            <label for="#">Edit the post's description:</label>
            <input type="hidden" name="job_posts_id" value="<?php echo $_GET['job_posts_id']; ?>">
            <input type="text" name="description" value="<?php echo $getPostByID['description']; ?>">
        </p>
        <p>
            <label for="#">Upload</label>
            <input type="file" name="image" accept="image/*">
        </p>
        <p>
            <input type="submit" name="insertJobPost">
        </p>
    </form>
</body>

</html>