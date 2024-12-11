<?php
session_start();
include('../dbcheck/dbCheck.php');
include('cashierVerify.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../loginStyle.css">
    <title>Cashier</title>
</head>
<body>
    <!-- Navigation bar start -->
    <nav class="navbar navbar-expand-lg navbar-dark" id="navigation">
        <div class="container-fluid">
            <a href="#"><img id="logo" src="../images/Coffee Logo.png" alt=""></a>
            <button style="background-color: #FED8B1; font-family: 'Arial black'; color: #53321C;" id="myAnchor" class="btn" onclick="gotoIndex()">Log Out</button>
        </div>
    </nav>
    <div class="main">
        <div class="currentOrder">
            <div class="cardOrder">
                <?php 
                    $isServed = false;
                    $isCancelled = false;
                    $sql = "SELECT * FROM orders WHERE is_served = ? AND is_cancelled = ? LIMIT 1";
                    $stmt = $connect->prepare($sql);
                    $stmt->bind_param("ii", $isServed, $isCancelled);
                    $stmt->execute();
                    $query = $stmt->get_result();
                    $res = $query->num_rows;
                    if($res > 0) {
                        $result = $query->fetch_assoc();
                        $_SESSION['currentId'] = $result['orderID'];
                        ?>
                        <img src="../images/Coffee Mug.png" alt="">
                        <h1><?php echo $result['productName'] ?></h1>
                        <h3>'<?php echo $result['customer_name'] ?>'</h3>
                        <div class="card-description">Description: <br><?php echo $result['description'] ?></div>
                <?php }?>
            </div>
            <form action="cashierPage.php" method="POST">
            <div class="button-div">
                
                <button type="submit" name="cancelOrder" class="btn">CANCEL</button>
                <button type="submit" name="nextOrder" class="btn">NEXT</button>
                
            </div>
            </form>
        </div>
            
        <div class="sideBar">
            <?php 
                $sql = "SELECT * FROM orders WHERE is_served = ? AND is_cancelled = ? LIMIT 1, 4";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("ii", $isServed, $isCancelled);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->num_rows;
                    
                if ($row > 0) {
                    while($data = $res->fetch_assoc()) :
                ?>
                        <div class="cardProceed">
                            <img src="../images/Coffee Mug.png" alt="">
                            <h2><?php echo $data['productName'] ?></h2>
                            <h4>'<?php echo $data['customer_name'] ?>'</h4>
                        </div>
                <?php 
                    endwhile;
                }
                ?>
        </div>
    </div>
    <!-- Navigation bar end -->
    <script src="../JS/script.js"></script>
</body>
</html>