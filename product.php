<?php 
session_start();
require "inc/process.php"; 
require "inc/header.php"; 
if(isset($_GET["product_id"]) && !empty($_GET["product_id"])){
    $id = $_GET["product_id"];
    //SQL
    $sql = "SELECT * FROM products WHERE id = '$id'";
    //Query
    $query = mysqli_query($connection, $sql);
    //result
    $result = mysqli_fetch_assoc($query);
}else{
    header("location: index.php");
}
$_SESSION["url"] = $_GET["product_id"];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
    integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
    integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="container">
    <?php require './pages/header-home.php'; ?>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-8">
                <?php
            if(isset($error)){
                ?>
                <div class="alert alert-danger">
                    <strong><?php echo $error; ?></strong>
                </div>
                <?php
            }elseif(isset($success)){
                ?>
                <div class="alert alert-success">
                    <strong><?php echo $success; ?></strong>
                </div>
                <?php
            }
            ?>
                <div
                    style="background: url('<?php echo $result["image"] ?>');background-position: center;background-size:cover;background-repeat: no-repeat;">
                    <div style="background:#0000007a;padding: 40px;text-align:center;">
                        <h2 class="text-white"><?php echo $result["title"] ?></h2>
                    </div>
                </div>
                <hr>
                <div class="row bg-dark mb-2">
                    <div class="col-6 text-white">
                        Date Published: <?php echo date("F j, Y", strtotime($result["timestamp"])); ?>
                    </div>
                    <div class="col-6 text-end text-white">
                        Category: <?php 
                        $cid = $result["category_id"];
                        $sql2 = "SELECT * FROM category WHERE id = '$cid'";
                        $query2 = mysqli_query($connection, $sql2);
                        $result2 = mysqli_fetch_assoc($query2);
                        echo $result2["name"];
                        ?>
                    </div>
                </div>
                <div class="text-center">
                    <img style="width:200px;height:200px;" src="<?php echo $result["image"] ?>" alt="" srcset="">
                </div>
                <div class="content">
                    <p>
                        <?php echo $result["content"]?>
                    </p>
                </div>
                <hr>
                <div>
                    <form id="submitform" action="" method="post">
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control w-25" name="quantity" value="1" id="">
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $id ?>" id="">
                        <input type="hidden" name="addtocart" value="1">
                        <button class="btn btn-primary mt-2">Add to cart</button>
                    </form>
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
<script>
$(document).ready(function() {
    $("#submitform").submit(function(e) {
        e.preventDefault();
        let form = $(this);
        let formdata = form.serialize();
        //Making my first Jquery ajax
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: formdata,
            success: function(response) {
                form.prepend(`
                    <div class="alert alert-success">
                        <strong>${response}</strong>
                    </div>
                `);
                //Izitoast Notification
                iziToast.success({
                    title: 'Info',
                    message: 'Successfully added to cart',
                });
            }
        });
    });
});
</script>
<?php
require "inc/footer.php";

?>