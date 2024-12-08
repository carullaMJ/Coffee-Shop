<?php 
//includes the checker of connection to the database
include('LoginCheck/logCredential.php');
?>
<!-- Log In Form Start -->
            <form action="index.php" method="post" style="background-color: #FED8B1;">
                <!-- Title -->
                <p class="display-2 text-center fw-light card-title" id="signIn_title">Sign In</p>
                <div style="width: 100%; height: 10px;">
                    <p style="font-size: 15px; color: red; text-align: center;"><?php echo $errorMsg['alert'] ?></p>
                </div>

                <!-- First stage form -->
                <div id="firstForm">
                <div class="card-body mx-3">

                    <!-- USERNAME -->
                    <p class="fw-light card-text" id="label">Username</p>
                    <input class="px-3" id="username" type="text" placeholder="Enter your username" name="logInUsername" value="<?php echo $logInUsername ?>">

                    <!-- username error message -->
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['username'] ?></p>
                    </div>

                    <!-- PASSWORD -->
                    <p class="fw-light card-text" id="label">Password</p>
                    <input class="px-3" id="password" type="password" placeholder="Enter your password" name="logInPassword" value="<?php echo $logInPassword ?>">

                    <!-- password error message -->
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['password'] ?></p>
                    </div>

                    <!-- POSITION -->
                    <p class="fw-light card-text" id="label">Position</p>
                    <select class="px-3" id="positionInput" name="logInPosition">
                        <option value="SelectPosition">--Select Position--</option>
                        <option value="Cashier">Cashier</option>
                        <option value="Admin">Administration</option>
                    </select>

                    <!-- position error message -->
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['position'] ?></p>
                    </div>
                </div>
                </div>

                <!-- Second stage form -->
                    <div class="admin-pin" id="pinAdmin">

                    <!-- 4-Digit Pin -->
                        <input type="password" class="pin-input" name="pin1" maxlength="1" autofocus>
                        <input type="password" class="pin-input" name="pin2" maxlength="1">
                        <input type="password" class="pin-input" name="pin3" maxlength="1" >
                        <input type="password" class="pin-input" name="pin4" maxlength="1">
                        
                        <button class="btn btn-lg" id="cancelButton">Back</button>
                    </div>

                    <!-- Submit Button -->
                    <div class="card-text text-center">
                        <input class="btn btn-lg" id="logInButton" name="login" type="submit" value="Sign In">
                    </div>
                
            </form>
<!-- Log In End -->


<!-- Javascript -->
            <script>
                var signInPosition = document.getElementById('positionInput');
                var back = document.getElementById('cancelButton');

                signInPosition.addEventListener("change", function() {
                var pin = document.getElementById('pinAdmin');
                var input = document.getElementById('firstForm');
                var username = document.getElementById('username');
                var password = document.getElementById('password');
                var userUsername = username.value.trim();
                var userPassword = password.value.trim();
                if (userUsername !== '' && userPassword !== '' && signInPosition.value === 'Admin') {
                input.style.display = 'none';
                pin.style.display = 'block';
                }
                })

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