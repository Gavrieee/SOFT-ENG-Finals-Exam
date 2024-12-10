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
    <link rel="stylesheet" href="index.css">

    <style>
        
    </style>
</head>

<body>

    <div class="outerOuterContainer">
        <div class="outerContainer">
            <div class="parentContainer">

                <div class="profileSection">

                    <div
                        style="display: flex; justify-content: space-between; flex-direction: column; align-items: left; background: none; width: 100%; padding: 20px;">
                        <div style="background: none;">

                            <div class="circle-container">
                                <img src="website_images/derpy_cat_profile.jpg" alt="Circular Image" class="circle-img">
                            </div>
                            <div class="accountInfo">
                                <?php if ($_SESSION['role'] == 'HR') { ?>
                                    <?php $session_role = 'HR' ?>
                                <?php } else if ($_SESSION['role'] == 'Applicant') { ?>
                                    <?php $session_role = 'Applicant' ?>
                                <?php } ?>
                                <?php $info = getUserByID($pdo, $_SESSION['username']); ?>
                                <h2><?php echo '@' . $_SESSION['username']; ?></h2>
                                <p><?php echo $info['first_name'] . ' ' . $info['last_name']; ?></p>
                                <p><?php echo $info['email'] ?></p>
                            </div>

                            <div class="notificationOptions">
                                <a class="a-notificationOptions"
                                    href="notifications.php?username=<?php echo $info['username'] ?>"><img class="icons"
                                        src="website_images/notification2SVG.svg" alt="Notifications">
                                    <span style="margin-left: 5px;">Notifications</span></a>
                            </div>

                            <div class="notificationOptions">
                                <a class="a-notificationOptions" href="view_accounts.php"><img class="icons"
                                        src="website_images/viewUsersSVG.svg" alt="View Users"> <span
                                        style="margin-left: 5px;">View Users</span></a>
                            </div>
                            <div>
                                <div class="notificationOptions">
                                    <a class="a-notificationOptions" href="logout.php"><img class="icons"
                                            src="website_images/logoutSVG.svg" alt="Log Out"><span
                                            style="margin-left: 5px;">Log
                                            Out</span></a>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>

                <div class="indexSection">

                    <div style="display: flex; justify-content: center; align-items;">

                        <div>
                            <div style="text-align: center;">
                                <img class="FindHireLogo" src="website_images/FindHire_BETTER.svg" alt="">
                            </div>


                            <div class="outerWritePost">

                                <div class="writePostSection">


                                    <?php if ($_SESSION['role'] == 'HR') { ?>
                                        <div
                                            style="background: none; width: 20%; display: flex; align-items: center; justify-content: center; padding: 10px;">


                                            <div class="small-circle-container">
                                                <img src="website_images/derpy_cat_profile.jpg"
                                                    title="This is your profile picture." alt="Circular Image"
                                                    class="circle-img">
                                            </div>

                                        </div>
                                    <?php } ?>
                                    <div style="background: none; width: 70%; padding: 0px 10px 0px 10px;">
                                        <?php if ($_SESSION['role'] == 'HR') { ?>
                                            <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                                                <p>
                                                <div style="padding-bottom: 5px;">
                                                    <label for="jobPost"><b>Write a job post.</b></label>
                                                </div>

                                                <input type="text" name="postDescription" id="postDescription"
                                                    placeholder="Type something here.." style="border: none;"
                                                    class="input-text" title="Write something here." required>
                                                </p>
                                        </div>

                                        <div
                                            style="background-color: none; width: 10%; display: flex; justify-content: center; align-items: center;">
                                            <label class="chooseFileLabel">
                                                <p>
                                                    <img style="width: 25px; height: 25px;"
                                                        src="website_images/imageSVG.svg" alt="Upload Image"
                                                        title="Choose an image to post.">

                                                    <!-- <label for="JobPost">Upload an image.</label> -->
                                                    <input type="file" title="HII" name="image" class="chooseFile"
                                                        accept="image/*" required>
                                                </p>
                                            </label>
                                        </div>

                                        <div
                                            style="background-color: none; width: 10%; display: flex; justify-content: center; align-items: center;">
                                            <p>
                                                <!-- <input type="image" src="website_images/sendButtonSVG.svg" alt="Submit"
                                                    style="height: 35px; width: 35px;" class="writePostButton" name="insertJobPost"> -->
                                                <input type="submit" title="Post it!" name="insertJobPost"
                                                    class="writePostButton" value="">
                                                <!-- <button type="submit" name="insertJobPost" class="writePostButton"><input
                                                        type='image' src='website_images/sendButtonSVG.svg' alt='Submit'
                                                        style='height: 25px; width: auto;' class="writePostButton"></button> -->
                                                <!-- <input type="image" src="website_images/sendButtonSVG.svg" alt="Submit"
                                                    style="height: 35px; width: 35px;" name="insertJobPost"> -->

                                            </p>
                                            </form>
                                        <?php } else { ?>
                                            <h5 style="text-align: center; padding-right: 50px;">"Your gateway to endless
                                                career opportunities. Start your job search here and find your next great
                                                role."</h5>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <h4 style="text-align: center;">All Job Posts</h4>


                            <p>
                                <?php $showJobPosts = showJobPosts($pdo); ?>
                                <?php foreach ($showJobPosts as $row) { ?>


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
                                                    <img style="width: 25px;" src="website_images/deleteButton2SVG.svg"
                                                        alt="Delete"></a>
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
                                                    <a href="view_resumes.php?job_posts_id=<?php echo $row['job_posts_id']; ?>" class="a-jobPostBelowButtons">View
                                                        Resumes</a>
                                                </b>
                                            </p>
                                        <?php } ?>
                                        <?php if ($_SESSION['role'] == 'Applicant') { ?>
                                            <p style="font-size: 18px">
                                                <b>
                                                    <a
                                                        href="application.php?job_post_id=<?php echo $row['job_posts_id']; ?>">Apply</a>
                                                </b>
                                            </p>
                                            <p style="font-size: 18px">
                                                <b>
                                                    <a
                                                        href="message.php?receiver_id=<?php echo $row['created_by']; ?>">Message</a>
                                                </b>
                                            </p>


                                        <?php } ?>
                                    </div>


                                </div>
                            <?php } ?>
                            </p>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>





</body>

</html>
