<?php
    include('../dbcheck/dbCheck.php');
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
<body style="background-color: #ECB176;">
    <div id="main">
    <nav class="navbar navbar-expand-lg navbar-dark" id="navigation">
            <div class="container-fluid">
                <a href="#"><img id="logo" src="../images/Coffee Logo.png" alt=""></a>
                <div id="dropdown">
                    <button class="btn" style="" id="myDropdown"><img src="../images/AdminLogo.png" alt="" id="logo"></button>
                    <div id="dropdown-content">
                        <a href="accountPage.php">Accounts</a>
                        <a href="tables.php">Tables</a>
                        <a href="../logout.php">LogOut</a>
                    </div>
                </div>
            </div>
    </nav>
    <div class="container-xxl ">
        <div id="tableAccount">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <p class="display-5">Account</p>
                    <button class="btn btn-lg" onclick="toggleForm()">New</button>
                </div>
            </nav>
            <div>
            <div class="update-delete">
                <button class="toggle-btn btn btn-primary font-weight-bold mx-0 px-5 rounded">Edit</button></td>
                <button class="btn btn-danger font-weight-bold mx-0 px-5 rounded">Delete</button></td>
            </div>
                    <table class="table border border-1 border-light">
                        <thead>
                            <tr>
                                <th class="text-white" scope="col">Account ID</th>
                                <th class="text-white" scope="col">Name</th>
                                <th class="text-white" scope="col">Username</th>
                                <th class="text-white" scope="col">Position</th>
                                <th class="text-white" scope="col">Date Created</th>
                                <th class="text-white" scope="col" colspan="2"></th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM accounts";
                            $query = mysqli_query($connect,$sql);
                            $res = mysqli_num_rows($query);
                            $i = 0;
                            if($res > 0) {
                                while($data = mysqli_fetch_assoc($query)) :
                                ?>
                                    <tr>
                                        <th class="text-muted" scope="row" id="<?php echo 'accountId'.$i?>"><?php echo $data['accountId'] ?></th>
                                        <td class="text-muted"><?php echo $data['name'] ?></td>
                                        <td class="text-muted"><?php echo $data['username'] ?></td>
                                        <td class="text-muted"><?php echo $data['position'] ?></td>
                                        <td class="text-muted"><?php echo $data['date_created'] ?></td>
                                        
                                    </tr>
                                <?php
                                ++$i;
                                endwhile;
                            }
                        ?>
                        </tbody>
                    </table>
            </div>
            <?php include('Credentials/updateAcct.php'); ?>

            
            
        </div>
            <div class="form-overlay" id="formOverlay">
                <div class="floating-form" id="floatingForm" style="width: 50rem; margin: auto;">
                    <h3 class="card-title">New Account</h3>

                    <?php include('newAccount.php'); // Include the floating form from form.php ?>
        
                </div>
            </div>
    </div>
    </div>

    <!-- The Sliding Navbar -->
    <div class="sliding-navbar">
        <form action="accountPage.php" method="post">
    <div class="nav-input">
        <div>
            <h4 style="font-weight: bolder;">UPDATE <i>table_name</i></h4>
        </div>
        
        <div class="selectColumn">
        <h4 style="margin-right: 40px; font-weight: bolder;">SET</h4>
            <div class="tableColumn"><h4 for="checkboxName">Name = </h4><input type="text" name="accountName" class="changeVal"></div>
            <div class="tableColumn"><h4 for="checkboxUsername">Username = </h4><input type="text" name="accountUsername" class="changeVal"></div>
            <div class="tableColumn"><h4 for="checkboxEmail">Email = </h4><input type="text" name="accountEmail" class="changeVal"></div>
            <div class="tableColumn"><h4 for="checkboxPass">Password = </h4><input type="text" name="accountPass" class="changeVal"></div>
            
        </div>
        <div class="selectId">
        <h4 style="margin-right: 40px; font-weight: bolder;">WHERE</h4>
        <h4>Account ID =</h4>
        <select class="idSelector" name="updateId">
            <option value="noId"></option>
            <?php 
                $sql = "SELECT * FROM accounts";
                $query = mysqli_query($connect,$sql);
                $res = mysqli_num_rows($query);
                
                if($res > 0) {
                    while ($data = mysqli_fetch_assoc($query)) : ?>
                <option value="<?php echo $data['accountId'] ?>"><?php echo $data['accountId'] ?></option>  
            <?php
            endwhile;
                }
            ?>  
            </select>
        </div>
        <div class="submitUpdate">
            <button type="submit" name="update">UPDATE</button>
        </div>
        
    </div>
        <button class="close-btn">Close</button>
    </div>
    </form>

    <script src="../JS/script.js"></script>

    <script>
        // Get elements by class
        var toggleBtn = document.querySelector('.toggle-btn');
        var navbar = document.querySelector('.sliding-navbar');
        var closeBtn = document.querySelector('.close-btn');
        
 
        // Toggle the navbar visibility
        toggleBtn.addEventListener('click', function() {
            navbar.style.bottom = '0'; // Slide navbar up
            var bottom = document.getElementById('main');
            bottom.style.marginBottom = '50%';

        });

        // Close the navbar
        closeBtn.addEventListener('click', function() {
            navbar.style.bottom = '-100%'; // Slide navbar down
            var bottom = document.getElementById('main');
            bottom.style.marginBottom = '-50%';
        });

    </script>
    <?php 
        include('Credentials/Verify.php');
        include('Credentials/updateAcct.php');
?>
</body>
</html>