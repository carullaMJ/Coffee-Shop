<?php 
//served order
if(isset($_POST['nextOrder'])) {
    $isServed = true;
    $currentId = $_SESSION['currentId'];
    echo $currentId;
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
if(isset($_POST['cancelOrder'])) {
    $isCancelled = true;
    $currentId = $_SESSION['orderID'];
    echo $currentId;
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