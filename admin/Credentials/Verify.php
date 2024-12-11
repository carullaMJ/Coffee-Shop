<?php 
include('../dbcheck/dbCheck.php');

//array for storing errors
$errorMessage = array('username' => '', 'firstName' => '', 'lastName' => '', 'activeEmail' => '', 'newPassword' => '', 'confirmPassword' => '', 'position' => '', 'pin' => '' );

//variables for storing the input data
$newUsername = $firstName = $lastName = $name = $activeEmail = $newPassword = $confirmPassword = $position = '';
$safeNewUsername = $safeNewPass = $safeActiveEmail = $safeLastName = $safeFirstName = '';

    // Verification for adding the data inside the accounts table
    if (isset($_POST['add'])) {

        //if any input field is blank it will call again the floating form and spit out error informing that the input field should be filled
        //else the values in the input field will be transferred to the designated variables

        //Username
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

        //if the position selected is admin, it will traverse through all the data inside accounts table
        } elseif ($_POST['position'] == 'admin') {
                $position = htmlspecialchars($_POST['position']);
                $sql = "SELECT * FROM accounts WHERE position = ?";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("s", $position);
                $stmt->execute();
                $query = $stmt->get_result();
                $res = $query->num_rows;

                //when the traversal is done and founds a data, it will provide an error, stating that there is existing admin account hence can't create more
                if($res > 0) {
                    $errorMessage['position'] = "There is already an admin account, can't create another";
                } 
        }else {
                $position = htmlspecialchars($_POST['position']);
        }
            
        /*now if the the input fields are not empty it will enter another validation on which it will be tested on the regex combination
      if it does not match the combinations of letters, numbers, symbols, or whitespaces. it will produce some error message/s   */
        if (!empty($firstName) || !empty($lastName) || !empty($activeEmail) || !empty($newPassword) || !empty($confirmPassword)) {
            if (!preg_match('/^[A-Za-z0-9_-]{3,20}$/', htmlspecialchars($newUsername))) {
                $errorMessage['username'] = 'Enter a proper username';
            }
            if (!preg_match('/^[A-Za-z]+([ \'-][A-Za-z]+)*$/', htmlspecialchars($firstName))) {
                $errorMessage['firstName'] = 'Enter a proper name';
            }
    
            if (!preg_match('/^[A-Za-z]+([ \'-][A-Za-z]+)*$/', htmlspecialchars($lastName))) {
                $errorMessage['lastName'] = 'Enter a proper name';
            }
    
            if(!filter_var(htmlspecialchars($activeEmail), FILTER_VALIDATE_EMAIL)) {
                $errorMessage['activeEmail'] = 'Enter a valid email address';
            }
    
            $passwordPattern ="/^[A-Za-z0-9!@#$%^&*()_+={}[\]|\\:;\"'<>,.?-]{8,}$/";
            if(!preg_match($passwordPattern, htmlspecialchars($newPassword))) {
                $errorMessage['newPassword'] = 'Must be at least 8 Characters';
            }
            if($confirmPassword != $newPassword) {
                $errorMessage['confirmPassword'] = 'Password Incorrect';
            }
        }
        
        // Checks if there are values stored in the array $errorMessage
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

            // if the selected position is 'admin'
            if ($position == 'admin') {

                //storing the value of four input tag for pin to a single variable
                $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
                //executes if $pin is empty
                if(empty(htmlspecialchars($pin))) {
                    $errorMessage['pin'] = "Don't leave this empty";
                }elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {    //check if the pin is four numbers only
                    $errorMessage['pin'] = "Pin must be a 4-digit Number";
                } else {
                    // if pin is successfully filtered, inserting data in the table accounts using prepared statement
                    $sql = "INSERT INTO accounts(name, username, e_mail, password, position, pin) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $connect->prepare();
                    $stmt->bind_param("sssssi", $name, $safeNewUsername, $safeActiveEmail, $encPassword, $safePosition, $pin);
                    
                    //executes the codes above
                    if($stmt->execute()) {
                    header("Location: accountPage.php"); // goes to accountPage
                    exit();
                    } else {
                    echo "query_error:".mysqli_error($connect);   //display error
                    }
                }  
            
            // if the selected position is 'cashier'
            } else {
                // inserting data in the table accounts using prepared statement
                $sql = $connect->prepare("INSERT INTO accounts(name, username, e_mail, password, position) VALUES (?, ? ,?, ?, ?)");
                $sql->bind_param("sssss", $name, $safeNewUsername, $safeActiveEmail, $encPassword, $safePosition);
                
                
                //executes the codes above
                if($sql->execute()) {
                    header("Location: accountPage.php");   // goes to accountPage
                    exit();
                }
                else {
                    echo "query_error:".mysqli_error($connect);   //display error
                }
                $sql->close();
                $connect->close();
            }
        }
    } 



    /* DELETE DATA FROM THE ACCOUNTS TABLE */

//array to store the errors when inserting data from the input field
$errorDelAcct = array ('pin' => '','acctId' => '' );
//variable to store the product id
$delAcctId = 0;

//check if submit button to delete data is clicked
if(isset($_POST['delAcct'])) {

    //if the input field to find the id is empty, it will spit an error
    if(empty($_POST['delRow'])) {
        $errorDelAcct['pin'] = "Enter a row";
    }
    else {
        
        //if there is a selected id it will traverse to the data inside the table to find the specific id
        $delAcctId = mysqli_real_escape_string($connect, $_POST['delRow']);
        echo $delAcctId;

        $sql = "SELECT * FROM accounts WHERE accountId = '$delAcctId'";
        $query = mysqli_query($connect, $sql);
        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        }else {
            //if the id isn't found it will spit an error that the id doesn't exist in the table
            $errorDelAcct['acctId'] = "Row does not exists";
        }
       
    }

    //The confirmation pin will be concatinated into one value of course it will be filtered
    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);

    //checks if the pin is empty
    if(empty(htmlspecialchars($pin))) {
        $errorDelAcct['pin'] = "Don't leave this empty";

    //Pin must be composed of combination of 4-digit number
    } elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {
        $errorDelAcct['pin'] = "Pin must be a 4-digit number";
    } else {
        $safePin = mysqli_real_escape_string($connect, $pin);
    }

    //if the array $errorDelProd have some values stored, it will alert that there are error/s still left and must be fixed to proceed
    if(array_filter($errorDelAcct)) {
        echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")
             delAcct();
             </script>';
    } else {

        /*$_SESSION['adminPin'] is the pin of the admin logged in and if it matches the the pin entered for confirmation
        it will finally update the data in the table with the data entered by the user */
        if ($_SESSION['adminPin'] == $pin) {

            //PHP prepared statement to pass the data to prevent from sql injection
            $sql = "DELETE FROM accounts WHERE accountId = ?";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("i", $delAcctId);

            //executes the codes above
            if ($stmt->execute()) {
                echo header('Location: tables.php');   // goes to tables.php
                exit();
            } else {
                echo "Error: " . $stmt->error;    //display error
            }
            $stmt->close();
            $connect->close();
        } else {
            $errorDelAcct['pin'] = "Incorrect Pin";    //display an error if pin is incorrect
        }
    }


}




    /* UPDATES ACCOUNTS TABLE */
//array of error message on updating new product
$errorUpdateAcct = array('updateAcctName' => '', 'updateAcctUsername' => '', 'updateAcctEmail' => '', 'updateAcctPass' => '', 'pin' => '', 'acctID' => '');

//variables for adding and updating products
$pin = $acctID = $updateAcctName = $updateAcctUsername = $updateEmail = $updateAcctPass = '';

// Verification for updating the data inside the products table
if(isset($_POST['updateAccount'])) {

    //if there is no Id selected it spit an error to remind user to enter an id to proceed
    if($_POST['updateAcctId'] == 'noId') {
        $errorUpdateAcct['pin'] = "Enter ID";
    }
    else {
        //if there is a selected id it will traverse to the data inside the table to find the specific id
        $acctID = mysqli_real_escape_string($connect, $_POST['updateAcctId']);

        $sql = "SELECT * FROM accounts WHERE accountId = '$acctID'";
        $query = mysqli_query($connect, $sql);
        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        }else {
            //if the id isn't found it will spit an error that the id doesn't exist in the table
            $errorUpdateAcct['acctID'] = "ID does not exists";
        }
       
    }
    
    //if any input field is blank it will assign to the variables the original data that's inside the table
    //else the values in the input field will be transferred to the designated variables
    if(empty($_POST['accountName'])) {
        $updateAcctName = $data['name'];
    } else {
        $updateAcctName = htmlspecialchars($_POST['accountName']);
    }

    if(empty($_POST['accountUsername'])) {
        $updateAcctUsername = $data['username'];
    } else {
        $updateAcctUsername = htmlspecialchars($_POST['accountUsername']);
    }

    if(empty($_POST['accountEmail'])) {
        $updateEmail = $data['e_mail'];
    } else {
        $updateEmail = $_POST['accountEmail'];
    }

    if(!empty($_POST['accountPass'])) {
        $updateAcctPass = $_POST['accountPass'];
    }


    /*now if the the input fields are not empty it will enter another validation on which it will be tested on the regex combination
      if it does not match the combinations of letters, numbers, symbols, or whitespaces. it will produce some error message/s   */
    if(!empty($updateAcctName) || !empty($updateAcctUsername) || !empty($updateEmail)) {
        if(!preg_match('/(?:\s*\w+\s*)+/', $updateAcctName)) {
            echo "<script>newProd()</script>";
            $errorUpdateAcct['updateAcctName'] = "Enter a proper name";
        }
        if(!preg_match('/^[A-Za-z0-9_-]{3,20}$/', $updateAcctUsername)) {
            echo "<script>newProd()</script>";
            $errorUpdateAcct['updateAcctUsername'] = "Please specify you input";
        }

        if(!filter_var(htmlspecialchars($updateEmail), FILTER_VALIDATE_EMAIL)) {
            $errorUpdateAcct['updateAcctEmail'] = 'Enter a valid email address';
        }

        
    }
    if(!empty($updateAcctPass)) {
        if(!preg_match("/^[A-Za-z0-9!@#$%^&*()_+={}[\]|\\:;\"'<>,.?-]{8,}$/",$_POST['accountPass'])) {
            $errorUpdateAcct['updateAcctPass'] = "Enter a proper password";
        } else {
            $updateAcctPass = mysqli_real_escape_string($connect, $_POST['accountPass']);
        }
    }


    //The confirmation pin will be concatinated into one value of course it will be filtered
    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);

    //checks if the pin is empty
    if(empty(htmlspecialchars($pin))) {
        $errorUpdateAcct['pin'] = "Don't leave this empty";

    //Pin must be composed of combination of 4-digit number
    } elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {
        $errorUpdateAcct['pin'] = "Pin must be a 4-digit number";
    } else {
        $safePin = mysqli_real_escape_string($connect, $pin);
    }

    //if the array $errorUpdateProd have some values stored, it will alert that there are error/s still left and must be fixed to proceed
    if(array_filter($errorUpdateAcct)) {
        echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")
             </script>';
    } else {
        //if there aren't any errors left, it will be filtered again and will be passed to another variables
        if(!empty($_POST['accountPass'])) {
            $enc_password = password_hash($updateAcctPass,PASSWORD_DEFAULT);
        } else {
            $updateAcctPass = $data['password'];
        }

        $safeUpdateAcctName = mysqli_real_escape_string($connect, $updateAcctName);

        $safeUpdateAcctUsername = mysqli_real_escape_string($connect, $updateAcctUsername);

        $safeUpdateAcctEmail = mysqli_real_escape_string($connect, $updateEmail);

        

    /*$_SESSION['adminPin'] is the pin of the admin logged in and if it matches the the pin entered for confirmation
        it will finally update the data in the table with the data entered by the user */
    if ($_SESSION['adminPin'] == $pin) {

        //PHP prepared statement to pass the data to prevent from sql injection
        $sql = "UPDATE accounts SET name = ?, username = ?, e_mail = ?, password = ? WHERE accountId = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ssssi", $safeUpdateAcctName, $safeUpdateAcctUsername, $safeUpdateAcctEmail, $enc_password, $acctID);

        //executes the prepared statement
        if ($stmt->execute()) {
            echo header('Location: tables.php');  //goes to tables.php
            exit();
        } else {
            echo "Error: " . $stmt->error;  //display an error
        }
        $stmt->close();
        $connect->close();
    } else {
        $errorUpdateAcct['pin'] = "Incorrect Pin";  //display an error if pin is incorrect
    }
    }


}
    
    





//NEW PRODUCT VERIFICATION

//array of error message on adding new product
$errorProd = array ('productName' => '', 'price' => '', 'availability' => '', 'pin' => '');

//array of error message on updating new product
$errorUpdateProd = array('updateProd' => '', 'updatePrice' => '', 'updateAvail' => '', 'pin' => '', 'prodID' => '');

//variables for adding and updating products
$newProduct = $newPrice = $availability = $pin = $prodID = $productName = $prodPrice = $prodAvail = '';

// Verification for adding data inside the products table
if (isset($_POST['addProd'])) {

    //if any input field is blank it will call again the floating form and spit out error informing that the input field should be filled
    //else the values in the input field will be transferred to the designated variables

    //Product Name
    if(empty($_POST['newProduct'])) {
        $errorProd['productName'] = "Don't leave this empty";
    } else {
        $newProduct = htmlspecialchars($_POST['newProduct']);
    }

    //Price
    if(empty($_POST['newPrice'])) {
        $errorProd['price'] = "Don't leave this empty";
    } else {
        $newPrice = htmlspecialchars($_POST['newPrice']);
    }

    //Availability
    if($_POST['availability'] == 'available' xor $_POST['availability'] == 'not-available') {
        $availability = htmlspecialchars($_POST['availability']);
    } else {
        $errorProd['availability'] = "Error: Unidentified value detected";
    }


    /*now if the the input fields are not empty it will enter another validation on which it will be tested on the regex combination
      if it does not match the combinations of letters, numbers, symbols, or whitespaces. it will produce some error message/s   */
    if(!empty($newProduct) || !empty($newPrice) || !empty($availability)) {
        
        if(!preg_match('/(?:\s*\w+\s*)+/', $newProduct)) {
            echo "<script>newProd()</script>";
            $errorProd['productName'] = "Enter a proper name";
        }
        if(!preg_match('/^\d{1,3}(,\d{3})*(\.\d{2})?$/', $newPrice)) {
            echo "<script>newProd()</script>";
            $errorProd['price'] = "Please specify you input";
        }
    }

    //storing the value of four input tag for pin to a single variable
    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
    
    //executes if $pin is empty
    if(empty(htmlspecialchars($pin))) {
        $errorProd['pin'] = "Don't leave this empty";
    } elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {   //check if the pin is four numbers only
        $errorProd['pin'] = "Pin must be a 4-digit number";
    } else {
        $safePin = mysqli_real_escape_string($connect, $pin);  //safely storing the filtered pin to another variable
    }

    // Checks if there are values stored in the array $errorProd
    if(array_filter($errorProd)) {
        echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")
             newProd();
             </script>';
    } else {
        
        #Filtration of data using mysqli filter syntax 
        
        //product name
        $safeNewProd = mysqli_real_escape_string($connect, $newProduct);

        //price
        $safeNewPrice = mysqli_real_escape_string($connect, $newPrice);

        //availability
        $safeAvailability = mysqli_real_escape_string($connect, $availability);
        

        //checks if the provided pin the pin of the admin account signed in is the same 
        if ($_SESSION['adminPin'] == $pin) {


            //PHP prepared statement
            $sql = "INSERT INTO products (ProductName, price, availability) VALUE (?, ?, ?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("sds", $safeNewProd, $safeNewPrice, $safeAvailability);

            //executes the prepared statement
            if ($stmt->execute()) {
                header('Location: ../tables.php');  //goes to tables.php
                exit();
            } else {
                echo "Error: " . $stmt->error;   //display an error
            }

            $stmt->close();
            $connect->close();
        } else {
            $errorProd['pin'] = "Incorrect Pin";  //if pin is incorrect, displays an error
        }

    }
}

/* UPDATES PRODUCTS TABLE */

// Verification for updating the data inside the products table
if(isset($_POST['updateProducts'])) {

    //if there is no Id selected it spit an error to remind user to enter an id to proceed
    if($_POST['updateId'] == 'noId') {
        $errorUpdateProd['pin'] = "Enter ID";
    }
    else {
        //if there is a selected id it will traverse to the data inside the table to find the specific id
        $prodID = mysqli_real_escape_string($connect, $_POST['updateId']);

        $sql = "SELECT * FROM products WHERE productID = '$prodID'";
        $query = mysqli_query($connect, $sql);
        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        }else {
            //if the id isn't found it will spit an error that the id doesn't exist in the table
            $errorUpdateProd['prodID'] = "Id does not exists";
        }
       
    }
    
    //if any input field is blank it will assign to the variables the original data that's inside the table
    //else the values in the input field will be transferred to the designated variables

    //product name
    if(empty($_POST['updateProduct'])) {
        $productName = $data['ProductName'];
    } else {
        $productName = htmlspecialchars($_POST['updateProduct']);
    }

    //price
    if(empty($_POST['updatePrice'])) {
        $prodPrice = $data['price'];
    } else {
        $prodPrice = htmlspecialchars($_POST['updatePrice']);
    }

    //availability
    if(empty($_POST['updateAvail'])) {
        $prodAvail = $data['availability'];
    } else {
        $prodAvail = $_POST['updateAvail'];
    }


    /*now if the the input fields are not empty it will enter another validation on which it will be tested on the regex combination
      if it does not match the combinations of letters, numbers, symbols, or whitespaces. it will produce some error message/s   */
    if(!empty($productName) || !empty($prodPrice) || !empty($prodAvail)) {
        if(!preg_match('/(?:\s*\w+\s*)+/', $productName)) {
            echo "<script>newProd()</script>";
            $errorUpdateProd['updateProd'] = "Enter a proper name";
        }
        if(!preg_match('/^\d{1,3}(,\d{3})*(\.\d{2})?$/', $prodPrice)) {
            echo "<script>newProd()</script>";
            $errorUpdateProd['updatePrice'] = "Please specify you input";
        }
    }


    //The confirmation pin will be concatinated into one value of course it will be filtered
    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);

    //checks if the pin is empty
    if(empty(htmlspecialchars($pin))) {
        $errorUpdateProd['pin'] = "Don't leave this empty";

    //Pin must be composed of combination of 4-digit number
    } elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {
        $errorUpdateProd['pin'] = "Pin must be a 4-digit number";
    } else {
        $safePin = mysqli_real_escape_string($connect, $pin);
    }

    //if the array $errorUpdateProd have some values stored, it will alert that there are error/s still left and must be fixed to proceed
    if(array_filter($errorUpdateProd)) {
        echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")
             updateProducts();
             </script>';
    } else {
        //if there aren't any errors left, it will be filtered again and will be passed to another variables
        $safeProdName = mysqli_real_escape_string($connect, $productName);

        $safeProdPrice = mysqli_real_escape_string($connect, $prodPrice);

        $safeProdAvail = mysqli_real_escape_string($connect, $prodAvail);

    /*$_SESSION['adminPin'] is the pin of the admin logged in and if it matches the the pin entered for confirmation
        it will finally update the data in the table with the data entered by the user */
    if ($_SESSION['adminPin'] == $pin) {

        //PHP prepared statement to pass the data to prevent from sql injection
        $sql = "UPDATE products SET ProductName = ?, price = ?, availability = ? WHERE productID = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sdsi", $safeProdName, $safeProdPrice, $safeProdAvail, $prodID);

        if ($stmt->execute()) {
            echo header('Location: tables.php');
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

/* DELETE DATA FROM THE PRODUCTS TABLE */

//array to store the errors when inserting data from the input field
$errorDelProd = array ('pin' => '', );
//variable to store the product id
$delProdId = 0;

//check if submit button to delete data is clicked
if(isset($_POST['delProd'])) {

    //if the input field to find the id is empty, it will spit an error
    if(empty($_POST['delRow'])) {
        $errorUpdateProd['pin'] = "Enter a row";
    }
    else {
        
        //if there is a selected id it will traverse to the data inside the table to find the specific id
        $delProdId = mysqli_real_escape_string($connect, $_POST['delRow']);
        echo $delProdId;

        $sql = "SELECT * FROM products WHERE productID = '$delProdId'";
        $query = mysqli_query($connect, $sql);
        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        }else {
            //if the id isn't found it will spit an error that the id doesn't exist in the table
            $errorDelProd['prodID'] = "Row does not exists";
        }
       
    }

    //The confirmation pin will be concatinated into one value of course it will be filtered
    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);

    //checks if the pin is empty
    if(empty(htmlspecialchars($pin))) {
        $errorDelProd['pin'] = "Don't leave this empty";

    //Pin must be composed of combination of 4-digit number
    } elseif (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {
        $errorDelProd['pin'] = "Pin must be a 4-digit number";
    } else {
        $safePin = mysqli_real_escape_string($connect, $pin);
    }

    //if the array $errorDelProd have some values stored, it will alert that there are error/s still left and must be fixed to proceed
    if(array_filter($errorDelProd)) {
        echo '<script> alert("There are some errors in the form, couldn\'t proceed if NOT fixed!")
             delProd();
             </script>';
    } else {

        /*$_SESSION['adminPin'] is the pin of the admin logged in and if it matches the the pin entered for confirmation
        it will finally update the data in the table with the data entered by the user */
        if ($_SESSION['adminPin'] == $pin) {

            //PHP prepared statement to pass the data to prevent from sql injection
            $sql = "DELETE FROM products WHERE productID = ?";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("i", $delProdId);

            //executes the codes above
            if ($stmt->execute()) {
                echo header('Location: tables.php');   // goes to tables.php
                exit();
            } else {
                echo "Error: " . $stmt->error;   //display error
            }
            $stmt->close();
            $connect->close();
        } else {
            $errorUpdateProd['pin'] = "Incorrect Pin";   //display an error if pin is incorrect
        }
    }


}
?>