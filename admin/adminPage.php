<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="adminStyle.css">
    <title>Document</title>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark" id="navigation">
            <div class="container-fluid">
                <!-- navbar logo -->
                <a href="adminPage.php"><img id="logo" src="../images/Coffee Logo.png" alt=""></a> 
                <!-- dropdown -->
                <div id="dropdown">   
                    <button class="btn" id="myDropdown"><img src="../images/AdminLogo.png" alt="" id="logo"></button>
                    <div id="dropdown-content">
                        <a href="accountPage.php">Accounts</a>
                        <a href="tables.php">Tables</a>
                        <a href="../logout.php">LogOut</a>
                    </div>
                </div>
            </div>
    </nav>
</body>
</html>