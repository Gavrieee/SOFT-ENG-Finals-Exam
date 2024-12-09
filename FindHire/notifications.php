<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['username'];

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button onclick="history.back()">Back</button>

    <h1>Notifications</h1>
    <p>This is the Notifications page.</p>

    <?php $showNotificationByID = showNotificationByID($pdo, $user_id); { ?>
        <?php foreach ($showNotificationByID as $row) { ?>

            <p>

                <a href="<?php echo $row['notification_link']; ?>">
                    <?php echo $row['message'] . ' (<span style="font-size: smaller;">Date: ' . $row['created_at'] . '</span>).'; ?>
                </a>

                <?php if (isset($row['notification_id'])) { ?>
                    <?php $status = 'Read';
                    $notification_id = $row['notification_id'];
                    seenNotification($pdo, $status, $notification_id); ?>
                <?php } ?>

            </p>
        <?php } ?>
    <?php } ?>


</body>

</html>