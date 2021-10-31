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
        <h2>Cart Page (<?php echo count($_SESSION["cart"]); ?>)</h2>
        <hr>
        <div class="row">
            <?php 
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