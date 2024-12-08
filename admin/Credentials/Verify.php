<?php 
include('../dbcheck/dbCheck.php');
$errorMessage = array('username' => '', 'firstName' => '', 'lastName' => '', 'activeEmail' => '', 'newPassword' => '', 'confirmPassword' => '', 'position' => '', 'pin' => '' );
$newUsername = $firstName = $lastName = $name = $activeEmail = $newPassword = $confirmPassword = $position = '';
$safeNewUsername = $safeNewPass = $safeActiveEmail = $safeLastName = $safeFirstName = '';
    if (isset($_POST['add'])) {

        //User Name
        if(empty($_POST['newUsername'])) {
            echo "<script>visible()</script>";
        }else {
            $newUsername = htmlspecialchars($_POST['newUsername']);
        }
    
        //First Name
        if (empty($_POST['firstName'])) {
            echo "<script>visible()</script>";
        }else {
            $firstName = htmlspecialchars($_POST['firstName']);
        }
        //Last Name
        if (empty($_POST['lastName'])) {
            echo "<script>visible()</script>";
        }else {
            $lastName = htmlspecialchars($_POST['lastName']);
        }
    
        //E-mail
        if (empty($_POST['activeEmail'])) {
            echo "<script>visible()</script>";
        }else {
            $activeEmail = htmlspecialchars($_POST['activeEmail']);
        }
    
        //New Password
        if (empty($_POST['newPassword'])) {
            echo "<script>visible()</script>";
        }else {
            $newPassword = htmlspecialchars($_POST['newPassword']);
        }
    
        //Confirm Password
        if (empty($_POST['confirmPassword'])) {
            echo "<script>visible()</script>";
        }else {
            $confirmPassword = htmlspecialchars($_POST['confirmPassword']);
        }
    
        //Position
        if($_POST['position'] == 'selectPosition') {
            echo "<script>visible()</script>";
            $errorMessage['position'] = 'Don\'t leave this blank';
        } else {
            $position = htmlspecialchars($_POST['position']);
        }

        
        
    
    
        if (!empty($firstName) || !empty($lastName) || !empty($activeEmail) || !empty($newPassword) || !empty($confirmPassword)) {
            if (!preg_match('/^[A-Za-z0-9_-]{3,20}$/', htmlspecialchars($newUsername))) {
                echo "<script>visible()</script>";
                $errorMessage['username'] = 'Enter a proper username';
            }
            if (!preg_match('/^[A-Za-z]+([ \'-][A-Za-z]+)*$/', htmlspecialchars($firstName))) {
                echo "<script>visible()</script>";
                $errorMessage['firstName'] = 'Enter a proper name';
            }
    
            if (!preg_match('/^[A-Za-z]+([ \'-][A-Za-z]+)*$/', htmlspecialchars($lastName))) {
                echo "<script>visible()</script>";
                $errorMessage['lastName'] = 'Enter a proper name';
            }
    
            if(!filter_var(htmlspecialchars($activeEmail), FILTER_VALIDATE_EMAIL)) {
                echo "<script>visible()</script>";
                $errorMessage['activeEmail'] = 'Enter a valid email address';
            }
    
            $passwordPattern ="/^[A-Za-z0-9!@#$%^&*()_+={}[\]|\\:;\"'<>,.?-]{8,}$/";
            if(!preg_match($passwordPattern, htmlspecialchars($newPassword))) {
                echo "<script>visible()</script>";
                $errorMessage['newPassword'] = 'Must be at least 8 Characters';
            }
            if($confirmPassword != $newPassword) {
                echo "<script>visible()</script>";
                $errorMessage['confirmPassword'] = 'Password Incorrect';
            }
        }
        
    
        if(array_filter($errorMessage)) {
            echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")</script>';
            echo "<script>visible()</script>";
        }else {
            #Filtration of data using mysqli filter syntax and password hashing
    
            //Password Hashing
            $safeNewPass = mysqli_real_escape_string($connect, $newPassword);
            $encPassword = password_hash($safeNewPass,PASSWORD_DEFAULT);
    
            //Data Filtration
                //Username
            $safeNewUsername = mysqli_real_escape_string($connect, $newUsername);
                
                //First Name
            $safeFirstName = mysqli_real_escape_string($connect, $firstName);
    
                //Last Name
            $safeLastName = mysqli_real_escape_string($connect, $lastName);
    
                //Combining the First name and Last name
            $name = $safeFirstName. " " .$safeLastName;
    
                //E mail
            $safeActiveEmail = mysqli_real_escape_string($connect, $activeEmail);
    
                //Position
            $safePosition = mysqli_real_escape_string($connect, $position);

            
            if ($position == 'admin') {

                //storing the value of four input tag for pin to a single variable
                $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
                //executes if empty
                if(empty(htmlspecialchars($pin))) {
                    $errorMessage['pin'] = "Don't leave this empty";
                }elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {    //check if the pin is four numbers only
                    $errorMessage['pin'] = "Pin must be a 4-digit Number";
                } else {
                    $sql = $connect->prepare("INSERT INTO accounts(name, username, e_mail, password, position, pin) VALUES (?, ?, ?, ?, ?, ?)");
                    $sql->bind_param("sssssi", $name, $safeNewUsername, $safeActiveEmail, $encPassword, $safePosition, $pin);
                    $sql->execute();
                    
                    if(mysqli_query($connect,$sql)) {
                    header("Location: accountPage.php");
                    exit();
                    } else {
                    echo "query_error:".mysqli_error($connect);
                    }
                }  
            }
            else {
                $sql = $connect->prepare("INSERT INTO accounts(name, username, e_mail, password, position) VALUES (?, ? ,?, ?, ?)");
                $sql->bind_param("sssss", $name, $safeNewUsername, $safeActiveEmail, $encPassword, $safePosition);
                $sql->execute();
                
                if(mysqli_query($connect,$sql)) {
                    header("Location: accountPage.php");
                    exit();
                }
                else {
                    echo "query_error:".mysqli_error($connect);
                }
                $sql->close();
                $connect->close();
            }
        }
     }
        

//NEW PRODUCT VERIFICATION
$errorProd = array ('productName' => '', 'price' => '', 'availability' => '', 'pin' => '');
$errorUpdateProd = array('updateProd' => '', 'updatePrice' => '', 'updateAvail' => '', 'pin' => '', 'prodID' => '');
$newProduct = $newPrice = $availability = $pin = $prodID = $productName = $prodPrice = $prodAvail = '';
if (isset($_POST['addProd'])) {
    if(empty($_POST['newProduct'])) {
        $errorProd['productName'] = "Don't leave this empty";
    } else {
        $newProduct = htmlspecialchars($_POST['newProduct']);
    }

    if(empty($_POST['newPrice'])) {
        $errorProd['price'] = "Don't leave this empty";
    } else {
        $newPrice = htmlspecialchars($_POST['newPrice']);
    }

    if($_POST['availability'] == 'available' xor $_POST['availability'] == 'not-available') {
        $availability = htmlspecialchars($_POST['availability']);
    } else {
        $errorProd['availability'] = "Error: Unidentified value detected";
    }


    if(!empty($newProduct) || !empty($newPrice) || !empty($availability)) {
        
        if(!preg_match('/^[A-Za-z0-9_-]{3,20}$/', $newProduct)) {
            echo "<script>newProd()</script>";
            $errorProd['productName'] = "Enter a proper name";
        }
        if(!preg_match('/^\d{1,3}(,\d{3})*(\.\d{2})?$/', $newPrice)) {
            echo "<script>newProd()</script>";
            $errorProd['price'] = "Please specify you input";
        }
    }

    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
    if(empty(htmlspecialchars($pin))) {
        $errorProd['pin'] = "Don't leave this empty";
    } elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {
        $errorProd['pin'] = "Pin must be a 4-digit number";
    } else {
        $safePin = mysqli_real_escape_string($connect, $pin);
    }


    if(array_filter($errorProd)) {
        echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")
             newProd();
             </script>';
    } else {
        #Second stage filtering

        $safeNewProd = mysqli_real_escape_string($connect, $newProduct);

        $safeNewPrice = mysqli_real_escape_string($connect, $newPrice);

        $safeAvailability = mysqli_real_escape_string($connect, $availability);

        if ($_SESSION['adminPin'] == $pin) {
            $sql = $connect->prepare("INSERT INTO products (ProductName, price, availability) VALUE (?, ?, ?)");
            $sql->bind_param("sds", $safeNewProd, $safeNewPrice, $safeAvailability);
            $sql->execute();

            if ($sql->execute()) {
                header('Location: ../tables.php');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $sql->close();
            $connect->close();
        } else {
            $errorProd['pin'] = "Incorrect Pin";
        }

    }
}



if(isset($_POST['updateProducts'])) {

    if($_POST['updateId'] == 'noId') {
        $errorUpdateProd['pin'] = "Enter ID";
    }
    else {
        
        $prodID = mysqli_real_escape_string($connect, $_POST['updateId']);

        $sql = "SELECT * FROM products WHERE productID = '$prodID'";
        $query = mysqli_query($connect, $sql);
        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        }else {
            $errorUpdateProd['prodID'] = "Id does not exists";
        }
       
    }
    
    if(empty($_POST['updateProduct'])) {
        $productName = $data['ProductName'];
    } else {
        $productName = htmlspecialchars($_POST['updateProduct']);
    }

    if(empty($_POST['updatePrice'])) {
        $prodPrice = $data['price'];
    } else {
        $prodPrice = htmlspecialchars($_POST['updatePrice']);
    }

    if(empty($_POST['updateAvail'])) {
        $prodAvail = $data['availability'];
    } else {
        $prodAvail = $_POST['updateAvail'];
    }


    if(!empty($productName) || !empty($prodPrice) || !empty($prodAvail)) {
        if(!preg_match('/^[A-Za-z0-9_-]{3,20}$/', $productName)) {
            echo "<script>newProd()</script>";
            $errorUpdateProd['updateProd'] = "Enter a proper name";
        }
        if(!preg_match('/^\d{1,3}(,\d{3})*(\.\d{2})?$/', $prodPrice)) {
            echo "<script>newProd()</script>";
            $errorUpdateProd['updatePrice'] = "Please specify you input";
        }
    }

    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
    if(empty(htmlspecialchars($pin))) {
        $errorUpdateProd['pin'] = "Don't leave this empty";
    } elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {
        $errorUpdateProd['pin'] = "Pin must be a 4-digit number";
    } else {
        $safePin = mysqli_real_escape_string($connect, $pin);
    }

    if(array_filter($errorUpdateProd)) {
        echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")
             updateProducts();
             </script>';
    } else {
        $safeProdName = mysqli_real_escape_string($connect, $productName);

        $safeProdPrice = mysqli_real_escape_string($connect, $prodPrice);

        $safeProdAvail = mysqli_real_escape_string($connect, $prodAvail);


    if ($_SESSION['adminPin'] == $pin) {

        $sql = "UPDATE products SET ProductName = ?, price = ?, availability = ? WHERE productID = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sdsi", $safeProdName, $safeProdPrice, $safeProdAvail, $prodID);
        $stmt->execute();

        if ($stmt->execute()) {
            //header('Location: tables.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        $connect->close();
    } else {
        $errorUpdateProd['pin'] = "Incorrect Pin";
    }
    }


}



$errorDelProd = array ('pin' => '', );
$delProdId = 0;
if(isset($_POST['delProd'])) {

    if(empty($_POST['delRow'])) {
        $errorUpdateProd['pin'] = "Enter a row";
    }
    else {
        
        $delProdId = mysqli_real_escape_string($connect, $_POST['delRow']);
        echo $delProdId;

        $sql = "SELECT * FROM products WHERE productID = '$delProdId'";
        $query = mysqli_query($connect, $sql);
        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        }else {
            $errorDelProd['prodID'] = "Row does not exists";
        }
       
    }

    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
    if(empty(htmlspecialchars($pin))) {
        $errorDelProd['pin'] = "Don't leave this empty";
    } elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {
        $errorDelProd['pin'] = "Pin must be a 4-digit number";
    } else {
        $safePin = mysqli_real_escape_string($connect, $pin);
    }

    if(array_filter($errorDelProd)) {
        echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")
             delProd();
             </script>';
    } else {

        if ($_SESSION['adminPin'] == $pin) {

            $sql = "DELETE FROM products WHERE productID = ?";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("i", $delProdId);
            $stmt->execute();

            if ($stmt->execute()) {
                //header('Location: tables.php');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
            $connect->close();
        } else {
            $errorUpdateProd['pin'] = "Incorrect Pin";
        }
    }


}
?>