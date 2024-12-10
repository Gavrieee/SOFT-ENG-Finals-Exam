<?php

require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .profileDetails {
            display: flex;
            justify-content: center;
            align-items: center;

            padding-bottom: 10px;

            text-align: center;
        }

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
        .messageButton {
            font-weight: bold;
            margin: 25px;
            /* background-color: blue; */            
        }
    </style>
</head>

<body>

    <div class="outerOuterContainer">
        <div class="normalContainer" style="width: 700px;">
            <button class="backButton" onclick="history.back()">Back</button>
            <!-- 
            <div class="">
                <h1>Profile page</h1>
                <p>This is <?php echo $_GET['username'] ?>'s profile page.</p>
            </div> -->

            <div style="display: flex; justify-content: center; alig-items: center;">
                <div class="circle-container" style="width: 200px; height: auto;">
                    <img src="website_images/derpy_cat_profile.jpg" alt="Circular Image" class="circle-img">
                </div>
            </div>

            <div class="profileDetails">
                <div style="width: 250px; background-color: inherit;">

                    <?php $getUserByID = getUserByID($pdo, $_GET['username']); { ?>
                        <div style="text-align: inherit;">
                            <h2><b>@<?php echo $getUserByID['username']; ?></b></h2>
                        </div>
                        <p><?php echo $getUserByID['first_name'] . ' ' . $getUserByID['last_name']; ?></p>
                        <p><?php echo $getUserByID['email']; ?></p>

                    <?php } ?>

                    <?php if ($_SESSION['id'] !== $getUserByID['id']) { ?>

                        <div class="messageButton">
                            <p>
                                <a class="backButton" style="padding: 5px 35px;" href="message.php?receiver_id=<?php echo $getUserByID['id']; ?>">Message</a>
                            </p>
                        </div>

                    <?php } else { ?>
                    <?php } ?>
                </div>
            </div>

            <hr>

            <?php if ($getUserByID['username'] == $_SESSION['username']) { ?>
                <h4 style="text-align: center; color: rgb(91, 91, 91);">All of your posts</h4>
            <?php } else { ?>
                <h3 style="text-align: center; color: rgb(91, 91, 91);">All posts of <?php echo $getUserByID['username']; ?></h3>
            <?php } ?>

            <?php $username = $_GET['username']; ?>

            <?php $showJobPostsProfile = showJobPostsProfile($pdo, $username); ?>
            <?php foreach ($showJobPostsProfile as $row) { ?>



                <div class="jobPosts">

                    <div class="image-container">


                        <img src="job_posts/<?php echo $row['title']; ?>" alt="Job_Post_Image">


                        <?php if ($_SESSION['username'] == $row['created_by_name']) { ?>
                            <div class="link-container">
                                <a style="margin-right: 55px;"
                                    href="editpost.php?job_posts_id=<?php echo $row['job_posts_id']; ?>"> <img
                                        style="width: 25px;" src="website_images/editButton2SVG.svg" alt="Edit">
                                </a>

                                <a href="deletepost.php?job_posts_id=<?php echo $row['job_posts_id']; ?>">
                                    <img style="width: 25px;" src="website_images/deleteButton2SVG.svg" alt="Delete"></a>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="jobPostDescriptionParent">

                        <div class="jobPostNameDate">
                            <a href="profile.php?username=<?php echo $row['created_by_name']; ?>">
                                <h2><?php echo $row['created_by_name']; ?></h2>
                            </a>
                            <p style="font-size: 12px;"><i><?php echo $row['created_at']; ?></i></p>
                        </div>
                        <div class="jobPostDescription">
                            <p><?php echo $row['description']; ?></p>
                        </div>

                    </div>



                    <div class="jobPostBelowButtons">
                        <?php if ($_SESSION['username'] == $row['created_by_name']) { ?>
                            <p>
                                <b>
                                    <a href="view_resumes.php?job_posts_id=<?php echo $row['job_posts_id']; ?>"
                                        class="a-jobPostBelowButtons">View
                                        Resumes</a>
                                </b>
                            </p>
                        <?php } ?>
                        <?php if ($_SESSION['role'] == 'Applicant') { ?>
                            <p style="font-size: 18px">
                                <b>
                                    <a href="application.php?job_post_id=<?php echo $row['job_posts_id']; ?>">Apply</a>
                                </b>
                            </p>
                            <p style="font-size: 18px">
                                <b>
                                    <a href="message.php?receiver_id=<?php echo $row['created_by']; ?>">Message</a>
                                </b>
                            </p>


                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>






</body>

</html>
