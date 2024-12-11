<?php
session_start();
include('../dbcheck/dbCheck.php');
include('customerVerify.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="customerStyle.css">
    <title>Caffeine Oasis</title>
</head>
<body>
            <!-- Navigation bar start -->
            <nav class="navbar navbar-expand-lg navbar-dark" id="navigation">
                <div class="container-fluid">
                    <a href="customerPage.php"><img id="logo" src="../images/Coffee Logo.png" alt=""></a>
                    <form action="customerPage.php" method="post">
                    <button class="btn text-white" type="submit" name="cancelOrder">Cancel Order</button>
                    </form>
                </div>
            </nav>
            <!-- Navigation bar end -->
            <div class="container-xxl">
                <div class="orderTitle">
                    <h1>Caffeine Oasis</h1>
                    <h2>Your order has been placed!</h2>
                </div>
                <?php
                    $sql = "SELECT * FROM orders WHERE orderID = ?";
                    $stmt = $connect->prepare($sql);
                    $stmt->bind_param("i", $_SESSION['orderID']);
                    $stmt->execute();
                    $query = $stmt->get_result();
                    $res = $query->num_rows;
                    if($res > 0) {
                        $data = $query->fetch_assoc();
                    }
                ?>
                <div class="customerInfo">
                    <div class="orderInfo">
                        <img src="../images/Coffee Mug.png" alt="Cafe Con Leche">
                        <h3><?php echo $data['productName'] ?></h3>
                        <p><strong>'<?php echo $data['customer_name'] ?>'</strong></p>
                    </div>
                    <div class="order-box">Description: <br> <?php echo $data['description'] ?></div>
                    <div class="quote">"<?php echo $coffeeQuote[array_rand($coffeeQuote)]; ?>"</div>
                    <div class="footer">Thank you for choosing us!</div>
                </div>
            </div>
</body>
</html>
