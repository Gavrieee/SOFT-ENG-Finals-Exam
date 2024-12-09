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
    <link rel="stylesheet" href=".css">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .navDiv {

            /* background-color: green; */

            display: flex;
            align-items: center;
            justify-content: space-between;

            /* padding: 30px; */
            border: 2px solid black;

            border-radius: 35px;

        }

        .navigationBar {
            /* background-color: red; */

            display: flex;
            /* Make it a flex container */
            justify-content: space-between;
            /* Add space between items */
            gap: 20px;
            /* Optional: Adds uniform spacing between items */
            padding: 10px;
            margin: 10px;

            border-radius: 25px;
            border: 2px solid black;
        }

        .icons {
            width: 20px;
            height: auto;

        }

        .notificationOptions {
            background-color: white;

            /* padding: 10px; */
            margin-bottom: 10px;
            /* border-radius: 15px; */
            border-bottom: 1px solid black;

            width: auto;
            height: 30px;

            text-align: left;

        }

        .accountInfo {

            /* background-color: orange; */

            /* border-top: 1px solid black; */
            border-bottom: 1px solid black;
            margin: 20px 0px 20px 0px;

        }

        .FindHireLogo {
            width: 200px;
            margin: auto;

            padding: 10px;

            text-align: center;

            /* border-bottom: 1px solid black; */
        }

        .parentContainer {
            /* display: flex;
            align-items: top;
            justify-content: space-between;

            background-color: aqua;

            gap: 50px; */

            display: flex;
            justify-content: space-between;
            /* Ensures profileSection stays on the left */
            align-items: top;
            width: 100%;

            /* background-color: black; */

        }

        .circle-container {
            width: 100px;
            /* Set the container size */
            height: 100px;
            overflow: hidden;
            /* Ensures the image doesn't spill outside the container */
            border-radius: 50%;
            /* Makes the container a circle */
            display: flex;
            /* Centers the image if it's smaller */
            justify-content: center;
            align-items: center;
            border: 2px solid black;
        }

        .small-circle-container {
            /* max-width: 20%; */
            width: 55px;
            /* Ensures the image scales responsibly */
            /* max-height: 20%; */
            height: auto;
            /* Prevents the image from exceeding container size */
            overflow: hidden;
            /* Ensures the image doesn't spill outside the container */
            border-radius: 50%;
            /* Makes the container a circle */

            border: 2px solid black;
        }

        .circle-img {
            width: 100%;
            /* Ensures the image fits the container */
            height: 100%;
            /* Maintains the proportions inside */
            object-fit: cover;
            /* Ensures the image fills the circle without distortion */
        }

        .outerOuterContainer {
            display: flex;
            justify-content: center;
            /* Centers the content horizontally */
            width: 100%;

            /* background-color: aqua; */
        }

        .outerContainer {
            /* background-color: firebrick; */

            width: 100%;
            display: flex;
            justify-content: center;
            /* Centers the container horizontally */
        }

        .profileSection {
            /* background-color: tomato;

            width: 300px; */

            /* margin: 0px 30px 0px 30px; */

            /* background-color: rebeccapurple; */
            background-color: white;
            width: 20%;
            display: flex;
            flex-direction: left;
            justify-content: space-evenly;
            height: auto;


            padding: 20px;
            border-right: 1px solid black;
        }

        .indexSection {
            background-color: white;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            background-color: white;
            width: 80%;

            overflow: hidden;
            /* Will fix the wrapping kineme */
        }

        .profileSection>* {
            background-color: white;

        }

        .writePostSection {
            /* background-color: hotpink; */
            background-color: white;

            display: flex;
            justify-content: space-evenly;
            align-items: center;

            border: 2px solid black;
            border-radius: 15px;

        }

        .writePostSection input[type='text'],
        input[type='submit'] {
            width: 100%;
        }

        .input-text {
            width: 200px;
            /* Set the width of the input */
            white-space: nowrap;
            /* Prevent wrapping of text */
            overflow-x: auto;
            /* Enable horizontal scrolling when text overflows */
            text-overflow: ellipsis;
            /* Optionally show ellipsis for overflowed text */
        }

        .chooseFile {
            display: none;
        }

        .chooseFileLabel {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            /* background-color: #007bff; */
            /* padding: 10px 20px 10px 20px; */
            /* border-radius: 5px; */
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .writePostButton {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            /* padding: 10px 20px; */

            background-image: url('website_images/sendButtonSVG.svg');
            background-size: cover;
            object-fit: cover;
            border: none;
            background-color: transparent;

            width: 10px;
            /* Adjust the width of the button */
            height: 10px;
            /* Adjust the height of the button */
            font-size: 16px;
            /* Adjust the font size inside the button */
            padding: 17px;
            /* Optional: Add padding for more space inside */


            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .jobPosts {
            max-width: auto;
            max-height: auto;
            border: 2px solid black;
            border-radius: 15px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .jobPosts img {
            width: 100%;
            object-fit: cover;
        }

        .image-container {

            position: relative;
            /* Create a positioning context for the link */
        }

        .image-container img {
            display: block;
            /* Prevent any gaps around the image */
            width: 100%;
            /* Ensure the image is responsive */
            height: auto;
        }

        .image-container a {
            position: absolute;
            /* Position the link relative to the container */
            top: 10px;
            /* Adjust the vertical position */
            right: 10px;
            /* Adjust the horizontal position */
            text-decoration: none;
            /* Remove underline */
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background */
            color: white;
            /* Text color */
            padding: 5px 10px;
            /* Padding around the link */
            border-radius: 10px;
            /* Rounded corners */
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .image-container a:hover {
            background-color: rgba(0, 0, 0, 0.8);
            /* Darker background on hover */
        }

        .link-container {
            display: inline-block;
            gap: 10px;
        }

        .jobPostDescriptionParent {
            background-color: purple;

            display: flex;
            flex-direction: column;


        }

        .jobPostNameDate {
            background-color: pink;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .jobPostDescription {
            background-color: blue;


        }

        .jobPostBelowButtons {
            background-color: greenyellow;
        }
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

                            <div class="notificationOptions"><a
                                    href="notifications.php?username=<?php echo $info['username'] ?>"><img class="icons"
                                        src="website_images/notification2SVG.svg" alt="Notifications">
                                    Notifications</a>
                            </div>

                            <div class="notificationOptions"><a href="view_accounts.php"><img class="icons"
                                        src="website_images/viewUsersSVG.svg" alt="View Users"> View Users</a></div>
                            <div>
                                <div class="notificationOptions"><a href="logout.php"><img class="icons"
                                            src="website_images/logoutSVG.svg" alt="Log Out"> Log Out</a></div>
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
                                                <img src="website_images/derpy_cat_profile.jpg" alt="Circular Image"
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
                                                    class="input-text" required>
                                                </p>
                                        </div>

                                        <div
                                            style="background-color: none; width: 10%; display: flex; justify-content: center; align-items: center;">
                                            <label class="chooseFileLabel">
                                                <p>
                                                    <img style="width: 25px; height: 25px;"
                                                        src="website_images/imageSVG.svg" alt="Upload Image">

                                                    <!-- <label for="JobPost">Upload an image.</label> -->
                                                    <input type="file" name="image" class="chooseFile" accept="image/*"
                                                        required>
                                                </p>
                                            </label>
                                        </div>

                                        <div
                                            style="background-color: none; width: 10%; display: flex; justify-content: center; align-items: center;">
                                            <p>
                                                <!-- <input type="image" src="website_images/sendButtonSVG.svg" alt="Submit"
                                                    style="height: 35px; width: 35px;" class="writePostButton" name="insertJobPost"> -->
                                                <input type="submit" name="insertJobPost" class="writePostButton" value="">
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
                                            <p><i><?php echo $row['created_at']; ?></i></p>
                                        </div>
                                        <div class="jobPostDescription">
                                            <h4><?php echo $row['description']; ?></h4>
                                        </div>
                                        <div class="jobPostBelowButtons">
                                            <?php if ($_SESSION['username'] == $row['created_by_name']) { ?>
                                                <p>
                                                    <a href="view_resumes.php?job_posts_id=<?php echo $row['job_posts_id']; ?>">View
                                                        Resumes</a>
                                                </p>
                                            <?php } ?>
                                            <?php if ($_SESSION['role'] == 'Applicant') { ?>

                                                <a
                                                    href="application.php?job_post_id=<?php echo $row['job_posts_id']; ?>">Apply</a>
                                                <a href="message.php?receiver_id=<?php echo $row['created_by']; ?>">Message</a>
                                            <?php } ?>
                                        </div>
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