<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            /* Ensures profileSection stays on the left */
            align-items: center;
            width: 100%;
        }

        .profileSection {
            background-color: rebeccapurple;
            width: 30%;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            height: 300px;
        }

        .index {
            background-color: greenyellow;
            width: 70%;
            display: flex;
            justify-content: center;
            /* Centers the content in the index section */
        }

        .outerOuterContainer {
            display: flex;
            justify-content: center;
            /* Centers the content horizontally */
            width: 100%;
        }

        .outerContainer {
            width: 100%;
            display: flex;
            justify-content: center;
            /* Centers the container horizontally */
        }

        .profileSectionSelection {
            display: grid;
        }

        .profileSectionLOGOUT {
            display: grid;
        }

        .profileSectionSelection>* {
            background-color: red;
        }
    </style>
</head>

<body>
    <div class="outerOuterContainer">
        <div class="outerContainer">
            <div class="container">
                <div class="profileSection">
                    <div class="profileSectionSelection">
                        <p>Image</p>
                        <p>Name</p>
                        <p>Notifications</p>
                        <p>Users</p>
                    </div>

                    <div class="profileSectionLOGOUT">
                        <p>Log Out</p>
                    </div>
                </div>
                <div class="index">
                    <h1>Index</h1>
                    <div style="width: 800px;"></div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>