<?php
include('dbcheck/dbCheck.php');
$errorMsg = array ('username' => '', 'password' => '', 'position' => '', 'alert' => '');
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
        $errorMsg['alert'] = "**There are still error/s in the form, try again**";
    } else {
        
        //Filtration of data before checking if there is an account existing in the table
        
        //Username
        $safeUsername = mysqli_real_escape_string($connect, $logInUsername);

        //Password
        $safePass = mysqli_real_escape_string($connect, $logInPassword);

        //Position
        $safePosition = mysqli_real_escape_string($connect, $logInPosition);

        //connecting to the table and finding the user
        $pos = "SELECT * FROM accounts WHERE username = '$safeUsername' AND position = '$safePosition'";
        $query = mysqli_query($connect, $pos);
        $hashed_password = mysqli_fetch_assoc($query);
        $searchResult = mysqli_num_rows($query);
        if ($searchResult > 0) {
            if(!password_verify($safePass, $hashed_password['password'])) {
                $errorMsg['password'] = "Incorrect Password!";
            } else {
                $sql = "SELECT * FROM accounts WHERE username = '$safeUsername' AND = '$safePosition'";
                $query = mysqli_query($connect, $pos);
                $res =mysqli_fetch_assoc($query);
                
                if($safePosition == 'Admin') {
                    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
                    if (!preg_match('/^\d{4}$/', htmlspecialchars($pin))) {
                        $errorMsg['pin'] = "Pin is a 4-digit NUMBER";
                    } else {
                        $sql = "SELECT * FROM accounts WHERE username = '$safeUsername' AND position = '$safePosition'";
                        $query = $connect->query($sql) or die($connect->error);
                        $res =$query->fetch_assoc();
                        if($res['pin'] != $pin) {
                            echo "<script>alert('Incorrect Pin')</script>";
                        }
                        else {
                            $sql = $connect->prepare("INSERT INTO account_logs(accountID, position, username) VALUES (?, ?, ?)");
                            $sql->bind_param("iss", $res['accountId'], $res['position'], $res['username']);
                            $sql->execute();
                            $_SESSION['adminLogin'] = $res['accountId'];
                            $_SESSION['adminPin'] = $res['pin'];
                            echo header('Location: index.php');
                            exit();
                
                        }
                    } 
                } else {
                    $_SESSION['cashierLogin'] = $res['accountId'];
                            $_SESSION['isLogged'] = true;
                            echo header('Location: index.php');
                            exit();
                    

                }
            }
        } else {
            $errorMsg['alert'] = "**User not Found!**";
        }
        
     }


}
?>