<?php 
session_start();
require "inc/process.php"; 
require "inc/header.php"; 
?>
<div class="container">
    <?php require './pages/header-home.php'; ?>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-8">
                <h2>Ecommerce Store</h2>
                <div class="row">
                    <?php
                        $sql = "SELECT * FROM products ORDER BY id DESC";
                        $query = mysqli_query($connection, $sql);
                        while($result = mysqli_fetch_assoc($query)){ 
                            ?>
                    <div class="col-4 mt-2">
                        <div class="card">
                            <img src="<?php echo $result["image"] ?>" style="    height: 200px;width: 100%;"
                                class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $result["title"] ?></h5>
                                <h5 class="card-title">₦<?php echo number_format($result["price"]) ?></h5>
                                <p class="card-text">Date: <?php echo date("F j, Y", strtotime($result["timestamp"])) ?>
                                </p>
                                <a href="store_product/<?php echo $result["id"] ?>/<?php echo str_replace(" ", "-", $result["title"]);  ?>/"
                                    class="btn btn-primary">View
                                    Product</a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="col-4">
                <!-- Sidebar -->
                <div class="border p-3">
                    <form action="search.php" method="post">
                        <div class="form-group">
                            <h4>Search</h4>
                            <input type="text" name="search" class="form-control" placeholder="Enter search term" id="">
                        </div>
                        <button type="submit" class="btn btn-dark mt-2">Search</button>
                    </form>
                </div>

                <div class="border p-3 mt-2">
                    <h4>Categories</h4>
                    <ul>
                        <?php
                            $sql_c = "SELECT * FROM category ORDER By id DESC";
                            $query_c = mysqli_query($connection, $sql_c);
                            while ($result_c = mysqli_fetch_assoc($query_c)) { 
                                ?>
                        <li>
                            <a
                                href="post-category.php?post_category_id=<?php echo $result_c["id"]; ?>"><?php echo $result_c["name"]; ?></a>
                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php require './pages/footer-home.php'; ?>
</div>
<?php
require "inc/footer.php";

?>