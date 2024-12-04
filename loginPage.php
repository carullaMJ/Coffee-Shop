<?php 
include('LoginCheck/logCredential.php');
?>
            <form action="index.php" method="post" style="background-color: #FED8B1;">
                <p class="display-2 text-center fw-light card-title" id="signIn_title">Sign In</p>
                <div style="width: 100%; height: 10px;">
                    <p style="font-size: 15px; color: red; text-align: center;"><?php echo $errorMsg['alert'] ?></p>
                </div>
                <div class="card-body mx-3">
                    <p class="fw-light card-text" id="label">Username</p>
                    <input class="px-3" id="signIn_input" type="text" placeholder="Enter your username" name="logInUsername">
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['username'] ?></p>
                    </div>
                    <p class="fw-light card-text" id="label">Password</p>
                    <input class="px-3" id="signIn_input" type="password" placeholder="Enter your password" name="logInPassword">
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['password'] ?></p>
                    </div>
                    <p class="fw-light card-text" id="label">Position</p>
                    <select class="px-3" id="signIn_input" name="logInPosition">
                        <option value="SelectPosition">--Select Position--</option>
                        <option value="Cashier">Cashier</option>
                        <option value="Admin">Administration</option>
                    </select>
                    <div style="width: 100%; height: 10px;">
                        <p style="font-size: 10px; color: red;"><?php echo $errorMsg['position'] ?></p>
                    </div>
                    <div class="card-text text-center">
                        <input class="btn btn-lg" id="logInButton" name="login" type="submit" value="Sign In">
                    </div>
                </div>
            </form>