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
                $_SESSION['newUsername'] = $safeNewUsername;
                $_SESSION['name'] = $name;
                $_SESSION['activeEmail'] = $safeActiveEmail;
                $_SESSION['newPassword'] = $encPassword;
                $_SESSION['position'] = $safePosition;
                echo '<script>secondForm()</script>';
                
            }
            else {
                $sql= "INSERT INTO accounts(name, username, e_mail, password, position) VALUES ('$name', '$safeNewUsername', '$safeActiveEmail', '$encPassword', '$safePosition')";
                
                if(mysqli_query($connect,$sql)) {
                    header("Location: accountPage.php");
                    exit();
                }
                else {
                    echo "query_error:".mysqli_error($connect);
                }
            }
        }
     }
        

?>