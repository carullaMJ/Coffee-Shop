<form action="AccountPage.php" method="post">
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
        $safePin = mysqli_real_escape_string($connect, $pin);
        $name = $_SESSION['name']; 
        $userName = $_SESSION['newUsername'];
        $activeEmail = $_SESSION['activeEmail']; 
        $newPassword = $_SESSION['newPassword'];
        $position = $_SESSION['position'];

        $sql= "INSERT INTO accounts(name, username, e_mail, password, position, pin) VALUES ('$name', '$userName', '$activeEmail', '$newPassword', '$position', '$safePin')";
        if(mysqli_query($connect,$sql)) {
        //header("Location: accountPage.php");
        //exit();
        } else {
        echo "query_error:".mysqli_error($connect);
        }
    }
    
}
?>