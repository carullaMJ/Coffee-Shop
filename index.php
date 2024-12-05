<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="loginStyle.css">
    <title>Log-In Page</title>
    
</head>
<body style="background-color: #ECB176;">
    <nav class="navbar navbar-expand-lg navbar-dark" id="navigation">
        <div class="container-fluid">
            <a href="#"><img id="logo" src="images/Coffee Logo.png" alt=""></a>
            <button style="background-color: #FED8B1; font-family: 'Arial black'; color: #53321C;" id="myAnchor" class="btn" onclick="signin()">Display</button>
        </div>
    </nav>
    <div class="container-xxl ">
        <div>
            <h1 class="text-center" id="title">Caffeine Oasis</h1>
        </div>
        <div class="logIn-overlay" id="logIn">
            <div class="floating-form" id="floatingForm" style="width: 30rem; margin: auto;">

                <?php include('loginPage.php'); // Include the floating form from login.php ?>
        
            </div>
        </div>
        <div class="display-overlay" id="display">

            <?php include('display.php'); // Include the floating form from login.php ?>
        </div>
        
    </div>
    <script src="JS/script.js"></script>
</body>
</html>