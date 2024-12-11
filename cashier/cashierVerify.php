<?php 
//served order

// Verification for updating the data inside the orders table
if(isset($_POST['nextOrder'])) {
    $isServed = true;
    $currentId = $_SESSION['currentId'];  //getting the id current id stored

    // updates the data and setting the is_served column to true
    $sql = "UPDATE orders SET is_served = ? WHERE orderID = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $isServed, $currentId);
    if($stmt->execute()){
        header('Location: cashierPage.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $connect->close();
}


//cancel order
// Verification for updating the data inside the orders table
if(isset($_POST['cancelOrder'])) {
    $isCancelled = true;
    $currentId = $_SESSION['orderID']; //getting the id current id stored

    // updates the data and setting the is_cancelled column to true
    $sql = "UPDATE orders SET is_served = ? WHERE orderID = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $isCancelled, $currentId);
    if($stmt->execute()){
        header('Location: cashierPage.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $connect->close();
}

?>