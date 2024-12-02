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
if(isset($_POST['confirm'])) {
    $pin = htmlspecialchars($_POST['pin1']) . htmlspecialchars($_POST['pin2']) . htmlspecialchars($_POST['pin3']) . htmlspecialchars($_POST['pin4']);
    $name = $_SESSION['name']; 
    $userName = $_SESSION['newUsername'];
    $activeEmail = $_SESSION['activeEmail']; 
    $newPassword = $_SESSION['newPassword'];
    $position = $_SESSION['position'];

    $sql= "INSERT INTO accounts(name, username, e_mail, password, position, pin) VALUES ('$name', '$userName', '$activeEmail', '$newPassword', '$position', '$pin')";
    if(mysqli_query($connect,$sql)) {
        //header("Location: accountPage.php");
        //exit();
    }
    else {
        echo "query_error:".mysqli_error($connect);
    }
}
?>