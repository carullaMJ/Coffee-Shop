<?php
include ('Credentials/Verify.php')
?>
<!-- PRODUCTS -->


<!-- ADD NEW PRODUCT -->
<div class="product-overlay" id="prodOverlay">
    <div class="floating-form" id="floatingForm" style="width: 50rem; margin: auto;">
        <h3 class="card-title">New Product</h3>
       
        <form action="tables.php" method="post">

            <!-- Product name -->
            <input type="text" name="newProduct" placeholder="Product Name" value="<?php echo $newProduct; ?>" style="display: block; width: 96.5%;" required>
            <div style="display: block; width: 96.5%;">
                <p class="warning"><?php echo $errorProd['productName']; ?></p>
            </div>
            
            <!-- Price -->
            <input type="number" name="newPrice" placeholder="Price" value="<?php echo $newPrice ?>" required>

            <!-- availability -->
            <select name="availability" id="productAvailability">
                <option value="available">Available</option>
                <option value="not-available">Not-available</option>
            </select>
            <div>
                <p class="warning"><?php echo $errorProd['price'];?></p><!--Last Name-->
            </div>
            <div>
                <p class="warning"><?php echo $errorProd['availability'];?></p><!--position-->
            </div>
            
            <!-- Pin -->
            <div class="pin" style="width: 96.5%; height: 120px;" id="pin">
                <p class="label">Enter your pin here</p>
                <p class="info">(confirm your pin to add product)</p>
                <input type="password" class="pin-confirm" name="pin1" maxlength="1" autofocus>
                <input type="password" class="pin-confirm" name="pin2" maxlength="1">
                <input type="password" class="pin-confirm" name="pin3" maxlength="1">
                <input type="password" class="pin-confirm" name="pin4" maxlength="1">
                <div style="display: block; width: 96.5%; text-align: center;">
                <p class="warning"><?php echo $errorProd['pin']; ?></p>
            </div>
            </div>
            <button type="submit" name="addProd">Add</button>
            <button name="cancel" onclick="toggleProd()">Cancel</button>
        </form> 
    </div>
</div>


<!-- EDIT -->
<div class="sliding-navbar products">
        <form action="tables.php" method="post">
    <div class="nav-input">
        <p style="text-align: center;"><i>--Leaving the area blank means no changes will be made and will retain it's original value--</i></p>
        <div>
            <h4 style="font-weight: bolder;">UPDATE <i>table_name</i></h4>
        </div>
        
        <div class="selectColumn">
        <h4 style="margin-right: 40px; font-weight: bolder;">SET</h4>
            <div class="tableColumn"><h4 for="checkboxName">Name = </h4><input type="text" name="updateProduct" class="changeVal" value="<?php echo $productName ?>"></div>
            <div class="tableColumn"><h4 for="checkboxUsername">Price = </h4><input type="text" name="updatePrice" class="changeVal" value="<?php echo $prodPrice ?>"></div>
            <div class="tableColumn"><h4 for="checkboxEmail">Available = </h4><select name="updateAvail" id="" class="changeVal" value="<?php echo $prodAvail ?>">
                <option value="available">Available</option>
                <option value="not_available">Not available</option>
            </select></div>
            
        </div>
        <div class="errors">
            <div>
                <p><?php echo $errorUpdateProd['updateProd'] ?></p>
            </div>
            <div>
                <p><?php echo $errorUpdateProd['updatePrice'] ?></p>
            </div>
            <div>
                <p><?php echo $errorUpdateProd['updateAvail'] ?></p>
            </div>
        </div>
        <div class="selectId">
        <h4 style="margin-right: 40px; font-weight: bolder;">WHERE</h4>
        <h4>Product ID =</h4>
        <select class="idSelector" name="updateId">
            <option value="noId"></option>
            <?php 
                //traversing to all data/rows inside the table
                $sql = "SELECT * FROM products";
                $query = mysqli_query($connect,$sql);
                $res = mysqli_num_rows($query);

                //checking if the table is not empty
                if($res > 0) {

                    //Loops through the rows of the table
                    while ($data = mysqli_fetch_assoc($query)) : ?>
                <option value="<?php echo $data['productID'] ?>"><?php echo $data['productID'] ?></option>  
            <?php
            endwhile;  // end of while loop
                }
            ?>  
            </select>
            <div>
                <p><?php echo $errorUpdateProd['prodID'] ?></p>
            </div>
        </div>
        <div class="admin-pin" id="pinAdmin">
                    <p><i>--Enter your pin to confirm changes--</i></p>
                    <!-- 4-Digit Pin -->
                        <input type="password" class="pin-confirm" name="pin1" maxlength="1" autofocus>
                        <input type="password" class="pin-confirm" name="pin2" maxlength="1" >
                        <input type="password" class="pin-confirm" name="pin3" maxlength="1" >
                        <input type="password" class="pin-confirm" name="pin4" maxlength="1">
                    </div>
                    <div>
                        <p><?php echo $errorUpdateProd['pin'] ?></p>
                    </div>
        <div class="submitUpdate">
            <button type="submit" name="updateProducts">UPDATE</button>
        </div>
        
    </div>
        <button class="close-btn" onclick="closeButton()">&#10005;</button>
        </form>
</div>

<!-- DELETE -->
<div class="productDel-overlay" id="prodDelOverlay">
    <div class="floating-form" id="floatingForm" style="width: 50rem; margin: auto;">
        <h3 class="card-title">Delete Product</h3>
       
        <form action="tables.php" method="post">
            
            <select name="delRow" id="productAvailability" style="width: 96.5%;">
                <option value="blank">Select Row</option>
                <?php 
                    //traversing to all data/rows inside the table
                    $sql = "SELECT * FROM products";
                    $query = mysqli_query($connect,$sql);
                    $res = mysqli_num_rows($query);

                    //checking if the table is not empty
                    if($res > 0) {

                        //Loops through the rows of the table
                        while ($data = mysqli_fetch_assoc($query)) : ?>
                    <option value="<?php echo $data['productID'] ?>"><?php echo $data['productID']." ".$data['ProductName']." ".$data['price']." ".$data['availability'] ?></option>  
                <?php
                endwhile;
                    }
                ?> 
            </select>
            <div style="width: 96.5%;">
                <p class="warning"><?php echo $errorProd['availability'];?></p><!--position-->
            </div>
            
            <div class="pin" style="width: 96.5%; height: 120px;" id="pin">
                <p class="label">Enter your pin here</p>
                <p class="info">(confirm your pin to add product)</p>
                <input type="password" class="pin-confirm" name="pin1" maxlength="1" autofocus>
                <input type="password" class="pin-confirm" name="pin2" maxlength="1">
                <input type="password" class="pin-confirm" name="pin3" maxlength="1">
                <input type="password" class="pin-confirm" name="pin4" maxlength="1">
                <div style="display: block; width: 96.5%; text-align: center;">
                <p class="warning"><?php echo $errorProd['pin']; ?></p>
            </div>
            </div>
            <button type="submit" name="delProd">DELETE</button>
            <button name="cancel" onclick="toggleDelProd()">Cancel</button>
        </form> 
    </div>
</div>

<script>
    const inputPin = document.querySelectorAll('.pin-confirm');

    inputPin.forEach((input, index) => {
        input.addEventListener('input', (e) => {
                if (input.value.length === 1 && index < inputPin.length - 1) {
                    inputPin[index + 1].focus(); // Move to the next input
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && index > 0 && !input.value) {
                    inputPin[index - 1].focus(); // Move back to the previous input
                    }
                });
        });
</script>






