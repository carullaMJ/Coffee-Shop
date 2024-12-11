<?php
    session_start();
    include('../dbcheck/dbCheck.php');
    include('customerVerify.php');
    if(isset($_SESSION['orderID'])) {
        header('Location: customerPage.php');
    }
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
    <style>
        
    </style>
</head>
<body>
    <!-- Navigation bar start -->
    <nav class="navbar navbar-expand-lg navbar-dark" id="navigation">
        <div class="container-fluid">
            <a href="#"><img id="logo" src="../images/Coffee Logo.png" alt=""></a>
        </div>
    </nav>
    <!-- Navigation bar end -->
    
    <div class="container">
        <div class="header">
            <h2>Welcome to</h2>
            <h1>Caffeine Oasis</h1>
            <h3>Place your order:</h3>
        </div>
        <form action="orderPage.php" method="POST">
            <div class="form-group">
                <label for="userInput">Customer Name:</label>
                <input type="text" id="userInput" name="customerName" placeholder="Enter your name">
                <div style="display: block; width: 96.5%;">
                    <p class="text-danger"><?php echo $errorMessage['customerName']; ?></p>
                </div>
                <div class="orderQuantity">
                <select name="customerOrder" class="order">
                    <option value="none">Tap me to select your order</option>
                <?php 
                    $availability = 'available';
                    $sql = "SELECT * FROM products WHERE availability = ?";
                    $stmt = $connect->prepare($sql);
                    $stmt->bind_param("s", $availability);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $rows = $result->num_rows;
                    while($data = $result->fetch_assoc()) :
                ?>
                    <option class="option" value="<?php echo $data['productID'] ?>"><span><?php echo $data['ProductName'] ?></span>     <span><?php echo 'P'.$data['price'] ?></span></option>
                <?php
                    endwhile;
                ?>
                </select>
                <label for="quantity">How many?</label>
                <input type="number" id="quantity" name="orderQuantity">
                </div>
                <div style="display: block; width: 96.5%;">
                    <p class="text-danger"><?php echo $errorMessage['customerOrder']; ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="customerDescription" maxlength="100" placeholder="Enter description..."></textarea>
                <div style="display: block; width: 96.5%;">
                    <p class="text-danger"><?php echo $errorMessage['customerDescription']; ?></p>
                </div>
            </div>
            <button type="submit" class="submit-button" name="orderNow">Submit Order</button>
        </form>
    </div>
</body>
</html>