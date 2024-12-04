<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="adminStyle.css">
    <title>Document</title>
</head>
<body style="background-color: #ECB176;">
    <nav class="navbar navbar-expand-lg navbar-dark" id="navigation">
            <div class="container-fluid">
                <a href="#"><img id="logo" src="../images/Coffee Logo.png" alt=""></a>
                <div id="dropdown">
                    <button class="btn" style="" id="myDropdown"><img src="../images/AdminLogo.png" alt="" id="logo"></button>
                    <div id="dropdown-content">
                        <a href="accountPage.php">Accounts</a>
                        <a href="#link2">Tables</a>
                    </div>
                </div>
            </div>
    </nav>
    <div class="container-xxl ">
        <div style="width: 50rem; background-color: #FED8B1; margin: auto; margin-top: 30px; border-radius: 10px;">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <p class="display-5">Account</p>
                    <button class="btn btn-lg" onclick="toggleForm()">New</button>
                </div>
            </nav>
            <div>
                    <table class="table border border-1 border-light">
                        <thead>
                            <tr>
                                <th class="text-white" scope="col">Unique ID</th>
                                <th class="text-white" scope="col">Name</th>
                                <th class="text-white" scope="col">Username</th>
                                <th class="text-white" scope="col">Position</th>
                                <th class="text-white" scope="col">Date Created</th>
                                <th class="text-white" scope="col" colspan="2"></th>
                                </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-muted" scope="row">cas001</th>
                                <td class="text-muted">Mario</td>
                                <td class="text-muted">It'sAMeMario</td>
                                <td class="text-muted">Cashier</td>
                                <td class="text-muted">11/18/24</td>
                                <td class="text-white"><button class="btn btn-primary font-weight-bold mx-0 px-5 rounded">Edit</button></td>
                                <td class="text-white"><button class="btn btn-danger font-weight-bold mx-0 px-5 rounded">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
            
        </div>
            <div class="form-overlay" id="formOverlay">
                <div class="floating-form" id="floatingForm" style="width: 50rem; margin: auto;">
                    <h3 class="card-title">New Account</h3>

                    <?php include('newAccount.php'); // Include the floating form from form.php ?>
        
                </div>
            </div>
    </div>
    <script src="../JS/script.js"></script>
    <?php 
        include('Credentials/newAcctVerify.php');
?>
</body>
</html>