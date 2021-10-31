<?php 
session_start();
require "inc/process.php"; 
require "inc/header.php"; 
if(isset($_POST["search"])){
    $search = $_POST["search"];
}else{
    $search = '';
}
?>
<div class="container">
    <?php require './pages/header-home.php'; ?>
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border p-3">
                    <form action="" method="post">
                        <div class="form-group">
                            <h4>Search Result For: <?php echo $search; ?></h4>
                            <input type="text" name="search" class="form-control" placeholder="Enter search term" id="">
                        </div>
                        <button type="submit" class="btn btn-dark mt-2">Search</button>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="row justify-content-center">
                    <?php
                        $term = $search;
                        $sql = "SELECT * FROM posts WHERE title LIKE '%$term%' ORDER BY id DESC";
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