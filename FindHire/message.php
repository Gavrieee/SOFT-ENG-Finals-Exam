<?php

require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if (!isset($_SESSION['id'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}
$sender_id = $_SESSION['id'];
$sender_username = $_SESSION['username'];
$receiver_id = $_GET['receiver_id'];

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button onclick="history.back()">Back</button>
    <h1>Message</h1>
    <p>This is the Message page.</p>
    <?php echo $_SESSION['username']; ?>

    <?php $showMessages = showMessages($pdo, $sender_id, $receiver_id); { ?>

        <?php foreach ($showMessages as $message) { ?>
            <?php if ($message['sender_name'] == $_SESSION['username']) { ?>
                <?php echo "<p style='text-align: right;'> {$message['content']} :<strong>{$message['sender_name']}</strong> (You)</p>"; ?>
            <?php } else { ?>
                <?php echo "<p><strong>{$message['sender_name']}:</strong> {$message['content']}</p>"; ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="action" value="send_message">
        <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
        <input type="hidden" name="job_post_id" value="<?php echo $job_post_id; ?>">
        <input type="hidden" name="sender_username" value="<?php echo $sender_username; ?>">
        <input type="text" name="content" placeholder="Type your message here..." required>
        <!-- <textarea name="content" placeholder="Type your message here..." required></textarea> -->
        <button type="submit" name="submit_message">Send</button>
    </form>



</body>

</html>