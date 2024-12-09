<?php
require_once 'core/models.php';
require_once 'core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="loginNregister.css">

    <script>
        setTimeout(() => {
            const notification = document.getElementById('notification');
            notification.style.display = 'none'; // Hides the div
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>


</head>

<body>


    <div class="outsideContainer">
        <!-- <div class="imageContainer">
            <p>Hunting for a job? Let’s make sure you find the right one.</p>
            <img class="imageEdit" src="website_images/Cartoon_LookingJobSVG.svg" alt="">

        </div> -->
        <div class="mainContainer">
            <!-- <h1>FindHire</h1> -->
            <img class="logo_name" src="website_images/FindHire_BETTER.svg" alt="FindHire_BETTER">

            <div class="mainForm">
                <div class="actionFeedback" id="notification">
                    <?php
                    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

                        if ($_SESSION['status'] == "200") {
                            echo "<p style='color: green;'>{$_SESSION['message']}</p>";
                        } else {
                            echo "<p style='color: red;'>{$_SESSION['message']}</p>";
                        }

                    }
                    unset($_SESSION['message']);
                    unset($_SESSION['status']);

                    // echo $_SESSION['role'];
                    ?>
                </div>
                <form action="core/handleForms.php" method="POST">
                    <p>
                        <label for="username">Username</label>
                        <input type="text" name="username">
                    </p>
                    <p>
                        <label for="username">Password</label>
                        <input type="password" name="password">

                    </p>
                    <p>
                        <input type="submit" name="loginUserBtn" value="Log In" class="submit-button">
                    </p>
                </form>
                <hr>

            </div>
            <div class="asking">
                <p>Don't have an account? You may register <a href="register.php">here</a>.</p>
            </div>


        </div>
    </div>





</body>

</html>