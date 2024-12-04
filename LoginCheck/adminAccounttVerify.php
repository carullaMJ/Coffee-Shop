<form action="index.php" method="post">
    <div class="input">
        <input type="password" class="pin-input" name="pin1" maxlength="1">
        <input type="password" class="pin-input" name="pin2" maxlength="1">
        <input type="password" class="pin-input" name="pin3" maxlength="1">
        <input type="password" class="pin-input" name="pin4" maxlength="1">
    </div>
    <button type="submit" name="confirm">Add</button>
    <button name="cancel" onclick="toggleForm()">Cancel</button>
</form>

<?php 
include('../dbcheck/dbCheck.php');
$errorMsg = array ('pin' => '');
if(isset($_POST['confirm'])) {
    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
    if (!preg_match('^\d{4}$', htmlspecialchars($pin))) {
        $errorMsg['pin'] = "Pin is a 4-digit NUMBER";
    } else {
        $safeUsername = $_SESSION['username'];
        $safePosition = $_SESSION['position'];
        $sql = "SELECT * FROM accounts WHERE username = '$safeUsername' AND position = '$safePosition'";
        $query = $connect->query($sql) or die($connect->error);
        $res =$query->fetch_assoc();
        if($res['pin'] != $pin) {
            $errorMsg['pin'] = "Incorrect PIN";
        }
        else {
            $_SESSION['login'] = $res['accountId'];
            echo "Logged In";

        }
    }
    
}
?>