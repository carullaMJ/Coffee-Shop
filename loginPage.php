<?php 
include('LoginCheck/logCredential.php');
?>
            <form action="index.php" method="post" style="background-color: #FED8B1;">
                <p class="display-2 text-center fw-light card-title" id="signIn_title">Sign In</p>
                <div style="width: 100%; height: 10px;">
                    <p style="font-size: 15px; color: red; text-align: center;"><?php echo $errorMsg['alert'] ?></p>
                </div>

                <div id="firstForm">
                <div class="card-body mx-3">
                    <p class="fw-light card-text" id="label">Username</p>
                    <input class="px-3"  type="text" placeholder="Enter your username" name="logInUsername">
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['username'] ?></p>
                    </div>
                    <p class="fw-light card-text" id="label">Password</p>
                    <input class="px-3"  type="password" placeholder="Enter your password" name="logInPassword">
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['password'] ?></p>
                    </div>
                    <p class="fw-light card-text" id="label">Position</p>
                    <select class="px-3" id="positionInput" name="logInPosition">
                        <option value="SelectPosition">--Select Position--</option>
                        <option value="Cashier">Cashier</option>
                        <option value="Admin">Administration</option>
                    </select>
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['position'] ?></p>
                    </div>
                </div>
                </div>
                    <div class="admin-pin" id="pinAdmin">
                        <input type="password" class="pin-input" name="pin1" maxlength="1">
                        <input type="password" class="pin-input" name="pin2" maxlength="1">
                        <input type="password" class="pin-input" name="pin3" maxlength="1">
                        <input type="password" class="pin-input" name="pin4" maxlength="1">
                    </div>
                    <div class="card-text text-center">
                        <input class="btn btn-lg" id="logInButton" name="login" type="submit" value="Sign In">
                    </div>
                
            </form>
            <script>
                var signInPosition = document.getElementById('positionInput');

                signInPosition.addEventListener("change", function() {
                var pin = document.getElementById('pinAdmin');
                var input = document.getElementById('firstForm');
                if (signInPosition.value === 'Admin') {
                input.style.display = 'none';
                pin.style.display = 'block';
    }
})
            </script>