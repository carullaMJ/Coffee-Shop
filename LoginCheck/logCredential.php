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
        
    }


}
?>