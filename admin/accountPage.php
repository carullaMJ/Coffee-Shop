<?php
    session_start();
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
                <button class="btn btn-danger font-weight-bold mx-0 px-5 rounded" onclick="toggleDelAcct()">Delete</button></td>
            </div>
                    <table class="table border border-1 border-light">
                        <thead>
                            <tr>
                                <th class="text-white" scope="col">Account ID</th>
                                <th class="text-white" scope="col">Name</th>
                                <th class="text-white" scope="col">Username</th>
                                <th class="text-white" scope="col">E-mail</th>
                                <th class="text-white" scope="col">Position</th>
                                <th class="text-white" scope="col">Date Created</th>
                                <th class="text-white" scope="col" colspan="2"></th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            //traversing to all data/rows inside the table accounts
                            $sql = "SELECT * FROM accounts";
                            $stmt = $connect->prepare($sql);
                            $stmt->execute();
                            $query = $stmt->get_result();
                            $res = $query->num_rows;
                            $i = 0;

                            //checking if the table is not empty
                            if($res > 0) {

                                //Loops through the rows of the table
                                while($data = $query->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <th class="text-muted" scope="row" id="<?php echo 'accountId'.$i?>"><?php echo $data['accountId'] ?></th>
                                        <td class="text-muted"><?php echo $data['name'] ?></td>
                                        <td class="text-muted"><?php echo $data['username'] ?></td>
                                        <td class="text-muted"><?php echo $data['e_mail'] ?></td>
                                        <td class="text-muted"><?php echo $data['position'] ?></td>
                                        <td class="text-muted"><?php echo $data['date_created'] ?></td>
                                        
                                    </tr>
                                <?php
                                endwhile; // end of while loop
                            }
                        ?>
                        </tbody>
                    </table>
            </div>

            
            
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
        <p style="text-align: center;"><i>--Leaving the area blank means no changes will be made and will retain it's original value--</i></p>
        <div>
            <h4 style="font-weight: bolder;">UPDATE <i>table_name</i></h4>
        </div>
        <div class="errors">
            <div>
                <p><?php echo $errorUpdateAcct['updateAcctName'] ?></p>
            </div>
            <div>
                <p><?php echo $errorUpdateAcct['updateAcctUsername'] ?></p>
            </div>
            <div>
                <p><?php echo $errorUpdateAcct['updateAcctEmail'] ?></p>
            </div>
            <div>
                <p><?php echo $errorUpdateAcct['updateAcctPass'] ?></p>
            </div>
        </div>
        <div class="selectColumn">
        <h4 style="margin-right: 40px; font-weight: bolder;">SET</h4>
            <div class="tableColumn"><h4 for="checkboxName">Name = </h4><input type="text" name="accountName" class="changeVal"></div>
            <div class="tableColumn"><h4 for="checkboxUsername">Username = </h4><input type="text" name="accountUsername" class="changeVal"></div>
            <div class="tableColumn"><h4 for="checkboxEmail">Email = </h4><input type="text" name="accountEmail" class="changeVal"></div>
            <div class="tableColumn"><h4 for="checkboxPass">Password = </h4><input type="password" name="accountPass" class="changeVal"></div>
            
        </div>
        <div class="selectId">
        <h4 style="margin-right: 40px; font-weight: bolder;">WHERE</h4>
        <h4>Account ID =</h4>
        <select class="idSelector" name="updateAcctId">
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
            <div>
                <p><?php echo $errorUpdateAcct['acctID'] ?></p>
            </div>
        </div>
        <div class="admin-pin" id="pinAdmin">
                    <p><i>--Enter your pin to confirm changes--</i></p>
                    <!-- 4-Digit Pin -->
                        <input type="password" class="pin-confirm" name="pin1" maxlength="1" autofocus>
                        <input type="password" class="pin-confirm" name="pin2" maxlength="1" >
                        <input type="password" class="pin-confirm" name="pin3" maxlength="1" >
                        <input type="password" class="pin-confirm" name="pin4" maxlength="1">
                    </div>
                    <div>
                        <p><?php echo $errorUpdateAcct['pin'] ?></p>
                    </div>
        <div class="submitUpdate">
            <button type="submit" name="updateAccount">UPDATE</button>
        </div>
        
    </div>
        <button class="close-btn" onclick="closeButton()">&#10005;</button>
    </div>
    </form>

<!-- DELETE -->
<div class="accountDel-overlay" id="acctDelOverlay">
    <div class="floating-form" id="floatingForm" style="width: 50rem; margin: auto;">
        <h3 class="card-title">Delete Account</h3>
       
        <form action="accountPage.php" method="post">
            
            <select name="delRow" id="productAvailability" style="width: 96.5%;">
                <option value="blank">Select Row</option>
                <?php 
                    $position = 'cashier';
                    $sql = "SELECT * FROM accounts WHERE position = ?";
                    $stmt = $connect->prepare($sql);
                    $stmt->bind_param("s", $position);
                    $stmt->execute();
                    $query = $stmt->get_result();
                    $res = $query->num_rows;
                    
                    if($res > 0) {
                        while ($data = mysqli_fetch_assoc($query)) : ?>
                    <option value="<?php echo $data['accountId'] ?>"><?php echo $data['accountId']." ".$data['username']." ".$data['name'] ?></option>  
                <?php
                endwhile;
                    }
                ?> 
            </select>
            <div style="width: 96.5%;">
                <p class="warning"><?php echo $errorProd['availability'];?></p><!--position-->
            </div>
            
            <div class="pin" style="width: 96.5%; height: 120px;" id="pin">
                <p class="label">Enter your pin here</p>
                <p class="info">(confirm your pin to delete account)</p>
                <input type="password" class="pin-confirm" name="pin1" maxlength="1" autofocus>
                <input type="password" class="pin-confirm" name="pin2" maxlength="1">
                <input type="password" class="pin-confirm" name="pin3" maxlength="1">
                <input type="password" class="pin-confirm" name="pin4" maxlength="1">
                <div style="display: block; width: 96.5%; text-align: center;">
                <p class="warning"><?php echo $errorProd['pin']; ?></p>
            </div>
            </div>
            <button type="submit" name="delAcct">DELETE</button>
            <button name="cancel" onclick="toggleDelAcct()">Cancel</button>
        </form> 
    </div>
</div>


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

        const inputPin = document.querySelectorAll('.pin-confirm');

        inputPin.forEach((input, index) => {
        input.addEventListener('input', (e) => {
                if (input.value.length === 1 && index < inputPin.length - 1) {
                    inputPin[index + 1].focus(); // Move to the next input
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && index > 0 && !input.value) {
                    inputPin[index - 1].focus(); // Move back to the previous input
                    }
                });
        });

    </script>
    <?php 
        include('Credentials/Verify.php');
?>
</body>
</html>