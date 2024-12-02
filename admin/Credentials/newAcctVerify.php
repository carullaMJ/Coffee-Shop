<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../dbcheck/dbCheck.php');
$errorMessage = array('username' => '', 'firstName' => '', 'lastName' => '', 'activeEmail' => '', 'newPassword' => '', 'confirmPassword' => '', 'position' => '');
$newUsername = $firstName = $lastName = $name = $activeEmail = $newPassword = $confirmPassword = $position = '';
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
        }
        
    
    
        if (!empty($firstName) || !empty($lastName) || !empty($activeEmail) || !empty($newPassword) || !empty($confirmPassword)) {
            if (!preg_match('/^[A-Za-z0-9_-]{3,20}$/', $newUsername)) {
                echo "<script>visible()</script>";
                $errorMessage['username'] = 'Enter a proper username';
            }
            if (!preg_match('/^[A-Za-z]+([ \'-][A-Za-z]+)*$/', $firstName)) {
                echo "<script>visible()</script>";
                $errorMessage['firstName'] = 'Enter a proper name';
            }
    
            if (!preg_match('/^[A-Za-z]+([ \'-][A-Za-z]+)*$/', $lastName)) {
                echo "<script>visible()</script>";
                $errorMessage['lastName'] = 'Enter a proper name';
            }
    
            if(!filter_var($activeEmail, FILTER_VALIDATE_EMAIL)) {
                echo "<script>visible()</script>";
                $errorMessage['activeEmail'] = 'Enter a valid email address';
            }
    
            $passwordPattern ="/^[A-Za-z0-9!@#$%^&*()_+={}[\]|\\:;\"'<>,.?-]{8,}$/";
            if(!preg_match($passwordPattern, $newPassword)) {
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
            $newPassword = mysqli_real_escape_string($connect, $_POST['newPassword']);
            $encPassword = password_hash($newPassword,PASSWORD_DEFAULT);
    
            //Data Filtration
                //Username
            $newUsername = mysqli_real_escape_string($connect, $_POST['newUsername']);
                
                //First Name
            $firstName = mysqli_real_escape_string($connect, $_POST['firstName']);
    
                //Last Name
            $lastName = mysqli_real_escape_string($connect, $_POST['lastName']);
    
                //Combining the First name and Last name
            $name = $firstName. " " .$lastName;
    
                //E mail
            $activeEmail = mysqli_real_escape_string($connect, $_POST['activeEmail']);
    
                //Position
            $position = mysqli_real_escape_string($connect, $_POST['position']);
            if ($position == 'admin') {
                $_SESSION['newUsername'] = $newUsername;
                $_SESSION['name'] = $name;
                $_SESSION['activeEmail'] = $activeEmail;
                $_SESSION['newPassword'] = $encPassword;
                $_SESSION['position'] = $position;
                echo '<script>secondForm()</script>';
                
            }
            else {
                $sql= "INSERT INTO accounts(name, username, e_mail, password, position) VALUES ('$name', '$newUsername', '$activeEmail', '$encPassword', '$position')";
                
                if(mysqli_query($connect,$sql)) {
                    header("Location: accountPage.php");
                    exit();
                }
                else {
                    echo "query_error:".mysqli_error($connect);
                }
            }
    
            // Inserting filtered data into the table
            /*$sql = "SELECT MAX(accountId) as highest FROM accounts WHERE position == '$position'";
                $result = mysqli_query($connect, $sql);
                $searchResult = mysqli_num_rows($result);
                    $row = $result->fetch_assoc();
                    if($row['highest'] > 9) {
                        $positionEXT = $positionEXT."0".$row['highest'];
                    } elseif ($row['highest'] == 0 || $row['highest'] < 10) {
                        $positionEXT = $positionEXT."00".$row['highest'];
                    }
                    $sql= "INSERT INTO accounts(acctUniqueID, name, username, e_mail, password, position) VALUES ($positionEXT, $name, $newUsername, $activeEmail, $encPassword, $position)"; */
    
    
    
        }
        
     }
        

?>