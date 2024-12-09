<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php
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
    <h1>View Accounts Page</h1>
    <p>This is the View Accounts Page.</p>

    <?php $getAllUsers = getAllUsers($pdo) ?>
    <p>
        <!-- <?php echo $_SESSION['role']; ?> -->
    </p>

    <?php foreach ($getAllUsers as $user) { ?>
        <p> 
            <a href="profile.php?username=<?php echo $user['username']; ?>"><?php echo $user['username'] ?></a>
            (<?php echo $user['role']; ?>)
        </p>
    <?php } ?>
</body>

</html>