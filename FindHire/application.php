<?php

require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SESSION['role'] !== 'Applicant') {
    header("Location: login.php");
    exit();
}

checkRole('Applicant');

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

        .checkStatusMessage {
            text-align: center;
            background-color: black;
            color: white;
            padding: 0.5px;
            margin: 10px 0px;
            border-radius: 15px;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="outerOuterContainer">
        <div class="normalContainer">
            <button class="backButton" onclick="history.back()">Back</button>
            <h1 style="text-align: center;">Job Post</h1>

            <?php $job_posts_id = intval($_GET['job_post_id']); ?>

            <!-- <?php echo $_SESSION['id']; ?> -->

            <?php $checkStatus = getApplicationStatus($pdo, $_SESSION['id'], $job_posts_id); ?>


            <!-- <p><?php echo $checkStatus; ?></p> -->


            <?php $checkStatus = getApplicationStatus($pdo, $_SESSION['id'], $job_posts_id); { ?>
                <!-- <?php echo $checkStatus; ?> -->

                <!-- will check the STATUS from applications ONLY -->



                <?php if ($checkStatus == 'Accepted') { ?>
                    <div class="checkStatusMessage">
                        <p>Your application as been reviewed!</p>
                    </div>
                <?php } else if ($checkStatus == 'Pending') { ?>
                        <div class="checkStatusMessage">
                            <p>Your application is still awaiting approval.</p>
                        </div>

                <?php } else if ($checkStatus == 'Rejected') { ?>
                        <div class="checkStatusMessage">
                            <p>We're sorry, but your application has been <span style="color: rgb(255, 88, 88);">rejected</span>...
                            </p>
                        </div>
                <?php } ?>

                <?php if ($checkStatus == 'Accepted') { ?>

                    <?php $job = getJobDetails($pdo, $_GET['job_post_id']); ?>

                    <div class="jobPosts">
                        <img src="job_posts/<?php echo $job['title']; ?>" alt="">
                        <div class="jobPostDescriptionParent">

                            <div class="jobPostNameDate">
                                <h3><b>HR. <?php echo htmlspecialchars($job['created_by_name']); ?></b></h3>
                                <p><?php echo htmlspecialchars($job['created_at']); ?></p>
                            </div>

                            <div class="jobPostDescription">
                                <p><?php echo htmlspecialchars($job['description']); ?></p>
                            </div>
                            <div>
                                <hr>
                                <p><b>System replied:</b></p>
                                <p style="text-align: justify">
                                    Congratulations! Your resume has been reviewed and approved by
                                    <b><?php echo $job['created_by_name']; ?></b> for this position. Our team will contact you
                                    shortly with the next steps in the
                                    recruitment process in your email.
                                </p>
                            </div>
                        </div>
                    </div>

                <?php } else { ?>

                    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                        <?php $job = getJobDetails($pdo, $_GET['job_post_id']); { ?>
                            <?php $job_post_id = intval($_GET['job_post_id']); ?>
                            <input type="hidden" name="job_post_id" value="<?php echo $job_post_id; ?>">

                            <div class="jobPosts">
                                <img src="job_posts/<?php echo $job['title']; ?>" alt="">
                                <div class="jobPostDescriptionParent">

                                    <div class="jobPostNameDate">
                                        <h3><b>HR. <?php echo htmlspecialchars($job['created_by_name']); ?></b></h3>
                                        <p><?php echo htmlspecialchars($job['created_at']); ?></p>
                                    </div>

                                    <div class="jobPostDescription">
                                        <p><?php echo htmlspecialchars($job['description']); ?></p>
                                    </div>
                                </div>

                                <div class="writePostSection" style="border: none;">
                                    <div style="width: 100%; padding-left: 15px;">
                                        <input type="text"
                                            style="width: 100%; height: 30px; border: 2px solid black; border-radius: 15px; padding-left: 10px;"
                                            name="message" placeholder="Write something here..." required></input>
                                    </div>
                                    <div
                                        style="background-color: none; width: 10%; display: flex; justify-content: center; align-items: center;">
                                        <label class="chooseFileLabel">
                                            <p>
                                                <img style="width: 35px; height: 35px;" src="website_images/fileSVG.svg"
                                                    alt="Upload a File" title="Choose a File to send.">

                                                <input type="file" title="HII" name="resume" class="chooseFile"
                                                    accept="application/pdf" required>
                                            </p>
                                        </label>

                                    </div>

                                    <div
                                        style="background-color: none; width: 10%; display: flex; justify-content: center; align-items: center;">
                                        <p>
                                            <input type="submit" title="Post it!" name="submitApplicationBttn"
                                                class="writePostButton" value="">
                                        </p>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </form>
                <?php } ?>
            <?php } ?>
        </div>
    </div>













</body>

</html>
