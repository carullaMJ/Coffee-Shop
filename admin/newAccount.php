<?php
include ('Credentials/Verify.php')
?>
<form action="AccountPage.php" method="post">

<input type="text" name="newUsername" placeholder="Username" value="<?php echo $newUsername; ?>" style="display: block; width: 96.5%;" required>
    <div style="display: block; width: 96.5%;">
        <p class="warning"><?php echo $errorMessage['username']; ?></p>
    </div>
    
    <!--First Name-->
    <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName ?>" required>
    <!--Last Name-->
    <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName ?>" required>
    <div>
        <p class="warning"><?php echo $errorMessage['firstName'];?></p>
    </div>
    <div>
        <p class="warning"><?php echo $errorMessage['lastName'];?></p>
    </div>
    <!-- E_mail -->
    <input type="email" name="activeEmail" placeholder="Your Active Email" value="<?php echo $activeEmail ?>" required>
    <!-- Password -->
    <input type="password" name="newPassword" placeholder="Password" value="<?php echo $newPassword ?>" required>
    <div>
        <p class="warning"><?php echo $errorMessage['activeEmail']; ?></p><!--Email-->
    </div>
    <div>
        <p class="warning"><?php echo $errorMessage['newPassword']; ?></p><!--new Password-->
    </div>
    <!-- position -->
    <select name="position" id="accountPosition">
        <option value="selectPosition">Position</option>
        <option value="cashier">Cashier</option>
        <option value="admin">Admin</option>
    </select>
    <!-- Password -->
    <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
    <div>
        <p class="warning"><?php echo $errorMessage['position'];?></p><!--position-->
    </div>
    <div>
        <p class="warning"><?php echo $errorMessage['confirmPassword']; ?></p><!--Confirm Pass-->
    </div>
    <!-- 4-digit pin -->
    <div class="pin" style="width: 96.5%; height: 120px; display:none;" id="pin">
        <p class="label">Enter a 4-digit Pin</p>
        <p class="info">(Only Admin account has a 4-digit Pin)</p>
        <input type="password" class="pin-input" name="pin1" maxlength="1" autofocus>
        <input type="password" class="pin-input" name="pin2" maxlength="1">
        <input type="password" class="pin-input" name="pin3" maxlength="1">
        <input type="password" class="pin-input" name="pin4" maxlength="1">
        <div style="display: block; width: 96.5%; text-align: center;">
        <p class="warning"><?php echo $errorMessage['username']; ?></p>
    </div>
    </div>
    <!-- Submit and Cancel Button -->
    <button type="submit" name="add">Add</button>
    <button name="cancel" onclick="toggleForm()">Cancel</button>
</form>

<script>
    
    const inputs = document.querySelectorAll('.pin-input');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
                if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus(); // Move to the next input
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && index > 0 && !input.value) {
            inputs[index - 1].focus(); // Move back to the previous input
            }
        });
    });
</script>