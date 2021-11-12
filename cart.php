<?php
session_start();
//Script links
require "inc/header.php"; 
?>
<div class="container">
    <?php
//For header content
require './pages/header-home.php';
include "inc/process.php";
?>
    <div class="py-3">
        <div class="row">
            <div class="col-6">
                <h2>Cart Page (<?php echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : 0; ?>)</h2>
            </div>
            <div class="col-6 text-end">
                <a href="checkout.php" class="btn btn-primary ">Checkout</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <?php 
            if(isset($_SESSION["cart"])){
                foreach ($_SESSION["cart"] as $pid => $quantity) {
                    $quantity = $quantity["quantity"];
                    //GET Data
                    $SQL = "SELECT * FROM products WHERE id = '$pid'";
                    $query = mysqli_query($connection, $SQL);
                    $result = mysqli_fetch_assoc($query);
                    ?>
            <div class="col-3">
                <div class="card">
                    <img src="<?php echo $result["image"] ?>" style="    height: 200px;width: 100%;"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $result["title"] ?></h5>

                        <div class="d-flex">
                            <div class="w-100">
                                <p>
                                    Quantity: <?php echo $quantity ?>
                                </p>
                            </div>
                            <div class="w-100">
                                <p class="text-end">
                                    ₦<?php echo number_format($result["price"] * $quantity); ?>
                                </p>
                            </div>
                        </div>
                        <a href="?product_id_remove=<?php echo $result["id"] ?>" class="btn btn-primary">Remove
                            Product</a>
                    </div>
                </div>
            </div>

            <?php
                }

            }else{
                ?>
            <h2 class="text-center">Cart is not active</h2>
            <?php
            }
        ?>
        </div>
    </div>


    <?php
//Footer content
require './pages/footer-home.php';
//Footer script links
?>
</div>
<?php
require "inc/footer.php";
?>