<?php 
session_start();
require "inc/process.php"; 
require "inc/header.php"; 
if(isset($_GET["post_category_id"]) && !empty($_GET["post_category_id"])){
    $id = $_GET["post_category_id"];
}else{
    header("location: index.php");
}
?>
<div class="container">
    <?php require './pages/header-home.php'; ?>
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border p-3">
                    <h4>Categories</h4>
                    <ul style="display:flex;list-style-type: none;">
                        <?php
                            $sql_c = "SELECT * FROM category ORDER By id DESC";
                            $query_c = mysqli_query($connection, $sql_c);
                            $count = 0;
                            while ($result_c = mysqli_fetch_assoc($query_c)) { 
                                ?>
                        <li style="<?php echo $count > 0 ? 'margin-left: 10px;' : '' ?>">
                            <a href="post-category.php?post_category_id=<?php echo $result_c["id"] ?>"
                                class="<?php echo $result_c["id"] == $id ? 'text-danger' : '' ?>"><?php echo $result_c["name"]; ?></a>
                        </li>
                        <?php
                        $count++;
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-8">
                <div class="row justify-content-center">
                    <?php
                        $sql = "SELECT * FROM posts WHERE category_id = '$id' ORDER BY id DESC";
                        $query = mysqli_query($connection, $sql);
                        while($result = mysqli_fetch_assoc($query)){ 
                            ?>
                    <div class="col-4 mt-2">
                        <div class="card">
                            <img src="<?php echo $result["thumbnail"] ?>" style="    height: 200px;width: 100%;"
                                class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $result["title"] ?></h5>
                                <p class="card-text">Date: <?php echo date("F j, Y", strtotime($result["timestamp"])) ?>
                                </p>
                                <a href="post.php?post_id=<?php echo $result["id"] ?>" class="btn btn-primary">Read</a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require './pages/footer-home.php'; ?>
</div>
<?php
require "inc/footer.php";

?>