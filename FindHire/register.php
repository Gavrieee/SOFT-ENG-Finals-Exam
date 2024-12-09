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
</head>

<body>
    <div class="outsideContainer">
        <div class="mainContainer">
            <h3>Create an account</h3>

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
                unset($_SESSION['role']);
                // echo "MAY MALI DITO ". $_SESSION['role'];
                ?>

                <script>
                    setTimeout(() => {
                        const notification = document.getElementById('notification');
                        notification.style.display = 'none'; // Hides the div
                    }, 3000); // 3000 milliseconds = 3 seconds
                </script>

            </div>
            <div class="mainForm">
                <form action="core/handleForms.php" method="POST">
                    <p>
                        <label for="username">Username</label>
                        <input type="text" name="username" placeholder="Knight051904">
                    </p>
                    <p>
                        <label for="username">First Name</label>
                        <input type="text" name="first_name">
                    </p>
                    <p>
                        <label for="username">Last Name</label>
                        <input type="text" name="last_name">
                    </p>
                    <p>
                        <label for="username">Email</label>
                        <input type="email" name="email" id="email" placeholder="findhire@gmail.com">
                    </p>
                    <p>
                        <label for="role">Role:</label>
                        <input type="radio" name="role" value="applicant" id="applicant" checked>
                        <label for="applicant">Applicant</label>
                        <input type="radio" name="role" value="hr" id="hr">
                        <label for="hr">HR</label>
                    </p>
                    <p>
                    <div id="hrCodeSection" style="display: none;">
                        <label for="hr_code">HR Code:</label>
                        <input type="text" name="hr_code" id="hr_code">
                    </div>
                    </p>
                    <p>
                        <label for="username">Password</label>
                        <input type="password" name="password">
                    </p>
                    <p>
                        <label for="username">Confirm Password</label>
                        <input type="password" name="confirm_password">

                    </p>
                    <p>
                        <input type="submit" name="insertNewUserBtn" value="Create" class="submit-button">
                    </p>
                    <script>
                        // Toggle HR Code field visibility
                        document.getElementById('hr').addEventListener('click', () => {
                            document.getElementById('hrCodeSection').style.display = 'block';
                        });
                        document.getElementById('applicant').addEventListener('click', () => {
                            document.getElementById('hrCodeSection').style.display = 'none';
                        });
                    </script>
                </form>
                <hr>
            </div>
            
            <div class="asking">
                <p>Already have an account? Sign in <a href="login.php">here</a>.</p>
            </div>
        </div>
    </div>

</body>

</html>