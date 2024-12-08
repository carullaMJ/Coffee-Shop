<?php
include('../dbcheck/dbCheck.php');
$message = array('username' => '', 'firstName' => '', 'lastName' => '', 'email' => '', 'oldPassword' => '', 'newPassword' => '', 'pin' => '', 'id' => '');
$updatedUser = $updatedName = $updatedEmail = $oldPass = $updatedPass = $updatedPin = $selectedId = '';
if(isset($_POST['update'])) {
    if ($_POST['updateId'] == 'noId') {
        $message['id'] = "Select an account ID you wish to edit";
    } else {
        $selectedId = htmlspecialchars($_POST['updateId']);

        $sql = "SELECT * FROM accounts WHERE accountId = '$selectedId'";
        $query = mysqli_query($connect,$sql);
        $result = mysqli_num_rows($query);
        if($result > 0) {
            $row = mysqli_fetch_assoc($query);
            $updatedName = htmlspecialchars($row['name']);
            $updatedUser = htmlspecialchars($row['username']);
            $updatedEmail = htmlspecialchars($row['e_mail']);
            $oldPass = htmlspecialchars($row['password']);
            
        }

    }
    

}
?>