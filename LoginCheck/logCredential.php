<?php
include('dbcheck/dbCheck.php');
$errorMsg = array ('username' => '', 'password' => '', 'position' => '');
$logInUsername = $logInPassword = $logInPosition = '';
if (isset($_POST['login'])) {
    if(empty($_POST['logInUsername'])) {
        $errorMsg['username'] = 'Please don\'t leave this blank!';
    } else {
        $logInUsername = htmlspecialchars($_POST['logInUsername']);
    }

    if(empty($_POST['logInPassword'])) {
        $errorMsg['password'] = 'Please don\'t leave this blank!';
    } else {
        $logInPassword = htmlspecialchars($_POST['logInPassword']);
    }

    if($_POST['logInPosition'] == 'SelectPosition') {
        $errorMsg['position'] = 'Please don\'t leave this blank!';
    } else {
        $logInPosition = htmlspecialchars($_POST['logInPosition']);
    }

    if (!empty($logInUsername) || !empty($logInPassword) || !empty($logInPosition)) {
        if(!preg_match('/^[A-Za-z0-9_-]{3,20}$/', $logInUsername)) {
            $errorMsg['username'] = "Username is not accepted";
        }
        $passwordPattern = "/^[A-Za-z0-9!@#$%^&*()_+={}[\]|\\:;\"'<>,.?-]{8,}$/";
        if(!preg_match($passwordPattern, $logInPassword)) {
            $errorMsg['password'] = "Must be at least 8 characters";
        }
        
    }

    if(array_filter($errorMsg)) {

        //Alerts if there are error is the form and the errorMsg array has any values
        echo "<script>alert('There is still some error/s in the form, please try again!')</script>";
    } else {
        
        //Filtration of data before checking if there is an account existing in the table
        
        //Username
        $safeUsername = mysqli_real_escape_string($connect, $logInUsername);

        //Password
        $safePass = mysqli_real_escape_string($connect, $logInPassword);

        //Position
        $safePosition = mysqli_real_escape_string($connect, $logInPosition);

        $sql = "SELECT * FROM accounts WHERE ";
    }


}
?>