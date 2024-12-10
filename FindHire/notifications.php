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
    <link rel="stylesheet" href="index.css">
    <style>
        .backButton {
            all: unset;
            cursor: pointer;

            background-color: black;
            color: white;

            padding: 5px 20px 5px 20px;
            margin: 0px;
            border-radius: 15px;
        }

        .backButton:hover {
            background-color: rgb(44, 44, 44);
        }

        .backButton:focus {
            background-color: rgb(91, 91, 91);
        }

        .notification {
            background-color: red;
            border-radius: 10px;
        }

        .a-notification {
            display: inline-block;
            padding: 5px 20px;
            background-color: #007bff;
            /* Button color */
            color: inherit;
            /* Text color */
            text-decoration: none;
            /* Remove underline */
            border-radius: 10px;
            /* Rounded corners */
            font-size: 16px;
            text-align: center;
            /* Center the text */


        }

        .a-notification:hover {
            background-color: #0056b3;
        }
        .notificationParent {
            display: flex;
            align-items: center;
            justify-content: center;

            background-color: greenyellow;

            /* overflow-y: auto; */

            /* height: 400px; */
            
        }
    </style>

</head>

<body>

    <div class="outerOuterContainer">
        <div class="normalContainer" style="background-color: aqua;">
            <button class="backButton" onclick="history.back()">Back</button>

            <h1>Notifications</h1>
            <p>This is the Notifications page.</p>

            <div class="notificationParent">
                <div>
                    <?php $showNotificationByID = showNotificationByID($pdo, $user_id); { ?>
                        <?php foreach ($showNotificationByID as $row) { ?>
                            <div class="notification">
                                <p>
                                    <a class="a-notification" href="<?php echo $row['notification_link']; ?>">
                                        <?php echo truncateText($row['message']) . ' (<span style="font-size: smaller; text-align: right;">Date: ' . $row['created_at'] . '</span>).'; ?>
                                    </a>

                                    <?php if (isset($row['notification_id'])) { ?>
                                        <?php $status = 'Read';
                                        $notification_id = $row['notification_id'];
                                        seenNotification($pdo, $status, $notification_id); ?>
                                    <?php } ?>

                                </p>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>





        </div>
    </div>




</body>

</html>
