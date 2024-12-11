<?php

$coffeeQuote = array("Coffee is a hug in a mug.", "Coffee is a language in itself.", "Coffee is the best thing to douse the sunrise with.","I have measured out my life with coffee spoons.", "Life's too short to drink bad coffee.", "Behind every successful person is a substantial amount of coffee.", "A morning without coffee is like sleep.", "Coffee is always a good idea.", "I love the smell of fresh coffee in the morning.", "Coffee, the favorite drink of the civilized world.", "Coffee is the common man's gold, and like gold, it brings to every person the feeling of luxury and nobility.", "Coffee is a beverage that puts one to sleep when not drank.");

$errorMessage = array('customerName' => '', 'customerOrder' => '', 'customerDescription' => '', 'orderQuantity' => '');
$customerName = $customerOrder = $customerDescription = $orderQuantity = '';
if(isset($_POST['orderNow'])) {
    //Customer Name
    if(empty($_POST['customerName'])) {
        $errorMessage['customerName'] = "Please provide your name or we won't be able to call you";
    } else {
        $customerName = htmlspecialchars($_POST['customerName']);
    }

    //Customer Order
    if($_POST['customerOrder'] == 'none') {
        $errorMessage['customerOrder'] = "Please place your order";
    } else {
        $customerOrder = htmlspecialchars($_POST['customerOrder']);
    }

    //Quantity
    if(empty($_POST['orderQuantity'])) {
        $errorMessage['orderQuantity'] = "Please enter a quantity";
    } else {
        $orderQuantity = htmlspecialchars($_POST['orderQuantity']);
    }

    //Customer Description
    if(!empty($_POST['customerDescription'])) {
        $customerDescription = htmlspecialchars($_POST['customerDescription']);
    }

    if(!empty($customerName) || !empty($customerOrder) || !empty($orderQuantity)) {
        if(!preg_match('/(?:\s*\w+\s*)+/', $customerName)) {
            $errorMessage['customerName'] = "Simple name would be best";
        } else {
            $safeCustomerName = mysqli_real_escape_string($connect, $customerName);
        }

        if(!preg_match('/^[1-9]\d*$/', $customerOrder)) {
           $errorMessage['customerOrder'] = "Please do not tamper the order selection";
        } else {
            $safeCustomerOrder = mysqli_real_escape_string($connect, $customerOrder);
            $sql = "SELECT * FROM products WHERE productID = ?";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("i", $safeCustomerOrder);
            $stmt->execute();
            $query = $stmt->get_result();
            $res = $query->num_rows;
            if($res > 0) {
                $product = $query->fetch_assoc();
                $safeProductName = $product['ProductName'];
            }else {
                $errorMessage['customerOrder'] = "Please do not tamper the order selection";
            }
        }

        if(!preg_match('/^[1-9]\d*$/', $orderQuantity)) {
            $errorMessage['orderQuantity'] = "an appropriate quantity will suffice";
        } else {
            $safeCustomerQuantity = mysqli_real_escape_string($connect, $orderQuantity);
        }
    }
    
    if(!empty($customerDescription)) {
        if(!preg_match('/^[\w\s,.\'"\-]*(\d+)?[\w\s,.\'"\-]*$/', $customerDescription)) {
            $errorMessage['customerDescription'] = "Simple description will suffice";
        } else {
            $safeCustomerDescription = mysqli_real_escape_string($connect, $customerDescription);
        }
    }

    if(array_filter($errorMessage)) {
        echo "<script>alert('Oops there are some error on the order, please try again')</script>";
    } else {
        $isServed = false;
        $isCancelled = false;
        $sql = "INSERT INTO orders (customer_name, quantity, productID, productName, description, is_served, is_cancelled) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("siissii", $safeCustomerName, $safeCustomerQuantity, $safeCustomerOrder, $safeProductName, $safeCustomerDescription, $isServed, $isCancelled);
        
        if($stmt->execute()) {
            $sql = "SELECT * FROM orders WHERE customer_name = ? AND quantity = ? AND productID = ? AND productName = ? AND description = ?";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("siiss", $safeCustomerName, $safeCustomerQuantity, $safeCustomerOrder, $safeProductName, $safeCustomerDescription);
            $stmt->execute();
            $query = $stmt->get_result();
            $res = $query->num_rows;
            if($res > 0 && $res == 1) {
                $data = $query->fetch_assoc();
                $_SESSION['orderID'] = $data['orderID'];
                header('Location: orderPage.php');
                exit();
            }

        } else {
            echo "Error: " . $stmt->error;
        }
    }

}


if(isset($_POST['cancelOrder'])) {
    $isCancelled = true;
    $currentId = $_SESSION['orderID'];
    echo $currentId;
    $sql = "UPDATE orders SET is_cancelled = ? WHERE orderID = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $isCancelled, $currentId);
    if($stmt->execute()){
        header('Location: customerLogout.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $connect->close();
}
?>