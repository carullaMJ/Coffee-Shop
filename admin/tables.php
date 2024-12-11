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
    <div id="main-tables">
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

    <!-- ACCOUNT LOGS START -->
        <div id="tableAccountLogs">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <p class="display-5">Account Logs</p>
                </div>
            </nav>
            <div>
                    <table class="table border border-1 border-light">
                        <thead>
                            <tr>
                                <th class="text-white" scope="col">Log ID</th>
                                <th class="text-white" scope="col">Account ID</th>
                                <th class="text-white" scope="col">Position</th>
                                <th class="text-white" scope="col">Username</th>
                                <th class="text-white" scope="col">Date Logged</th>
                                <th class="text-white" scope="col" colspan="2"></th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            //traversing to all data/rows inside the table accounts
                            $sql = "SELECT * FROM account_logs";
                            $stmt = $connect->prepare($sql);
                            $stmt->execute();
                            $query = $stmt->get_result();
                            $res = $query->num_rows;
                            $i = 0;

                            //checking if the table is not empty
                            if($res > 0) {

                                //Loops through the rows of the table
                                while($data = $query->fetch_assoc()) :?>
                                    <tr>
                                        <th class="text-muted" scope="row"><?php echo $data['logID'] ?></th>
                                        <td class="text-muted"><?php echo $data['accountID']?></td>
                                        <td class="text-muted"><?php echo $data['username'] ?></td>
                                        <td class="text-muted"><?php echo $data['position'] ?></td>
                                        <td class="text-muted"><?php echo $data['login_date'] ?></td> 
                                    </tr>
                                <?php
                                endwhile;
                            } else {?>
                                <tr>
                                    <th class="text-muted" scope="row" colspan="5">THIS TABLE IS EMPTY</th>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
<!-- ACCOUNT LOGS END -->

<!-- PRODUCTS TABLE START -->
        <div id="tableProducts">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <p class="display-5">Products</p>
                    <button class="btn btn-lg" onclick="toggleProd()">New</button>
                </div>
            </nav>
            <div>
            <div class="update-delete">
                <button class="product-btn btn btn-primary font-weight-bold mx-0 px-5 rounded" onclick="updateProducts()">Edit</button></td>
                <button class="btn btn-danger font-weight-bold mx-0 px-5 rounded" onclick="toggleDelProd()">Delete</button></td>
            </div>
                    <table class="table border border-1 border-light">
                        <thead>
                            <tr>
                                <th class="text-white" scope="col">Product ID</th>
                                <th class="text-white" scope="col">Name</th>
                                <th class="text-white" scope="col">Price</th>
                                <th class="text-white" scope="col">Availability</th>
                                <th class="text-white" scope="col">Date Created</th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            //traversing to all data/rows inside the table accounts
                            $sql = "SELECT * FROM products";
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
                                        <th class="text-muted" scope="row"><?php echo $data['productID'] ?></th>
                                        <td class="text-muted"><?php echo $data['ProductName'] ?></td>
                                        <td class="text-muted"><?php echo $data['price'] ?></td>
                                        <td class="text-muted"><?php echo $data['availability'] ?></td>
                                        <td class="text-muted"><?php echo $data['date_created'] ?></td>
                                        
                                    </tr>
                                <?php
                                endwhile;
                            } else {
                                ?>
                                <tr>
                                    <th class="text-muted" scope="row" colspan="5">THIS TABLE IS EMPTY</th>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
<!-- PRODUCTS TABLE END -->


<!-- ORDERS TABLE START -->
<div id="tableOrders">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <p class="display-5">Orders</p>
                </div>
            </nav>
            <div>
                    <table class="table border border-1 border-light">
                        <thead>
                            <tr>
                                <th class="text-white" scope="col">Order ID</th>
                                <th class="text-white" scope="col">Customer Name</th>
                                <th class="text-white" scope="col">Quantity</th>
                                <th class="text-white" scope="col">Ordered</th>
                                <th class="text-white" scope="col">Status</th>
                                <th class="text-white" scope="col">Date Ordered</th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            //traversing to all data/rows inside the table accounts
                            $sql = "SELECT * FROM orders";
                            $stmt = $connect->prepare($sql);
                            $stmt->execute();
                            $query = $stmt->get_result();
                            $res = $query->num_rows;

                            //checking if the table is not empty
                            if($res > 0) {

                                //Loops through the rows of the table
                                while($data = $query->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <th class="text-muted" scope="row"><?php echo $data['orderID'] ?></th>
                                        <td class="text-muted"><?php echo $data['customer_name'] ?></td>
                                        <td class="text-muted"><?php echo $data['quantity'] ?></td>
                                        <td class="text-muted"><?php echo $data['productName'] ?></td>
                                        <td class="text-muted"><?php if($data['is_served']) {echo 'served';}elseif($data['is_cancelled']) {echo 'cancelled';}else {echo 'on CUE';} ?></td>
                                        <td class="text-muted"><?php echo $data['date_created'] ?></td>
                                        
                                    </tr>
                                <?php
                                endwhile;
                            } else {
                                ?>
                                <tr>
                                    <th class="text-muted" scope="row" colspan="6">THIS TABLE IS EMPTY</th>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
<!-- ORDERS TABLE END -->

        <div>
        <?php 
        include('floatingPages.php');
        include('Credentials/Verify.php');
        ?>
        </div>                    
    </div>
    </div>
    

    <script src="../JS/script.js"></script>
</body>
</html>