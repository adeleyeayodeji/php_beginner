<?php 
session_start();
require "inc/process.php"; 
require "inc/header.php"; 
if(isset($_GET["post_id"]) && !empty($_GET["post_id"])){
    $id = $_GET["post_id"];
    //SQL
    $sql = "SELECT * FROM posts WHERE id = '$id'";
    //Query
    $query = mysqli_query($connection, $sql);
    //result
    $result = mysqli_fetch_assoc($query);
}else{
    header("location: index.php");
}
$_SESSION["url"] = $_GET["post_id"];
?>
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
                    style="background: url('<?php echo $result["thumbnail"] ?>');background-position: center;background-size:cover;background-repeat: no-repeat;">
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
                    <img style="width:200px;height:200px;" src="<?php echo $result["thumbnail"] ?>" alt="" srcset="">
                </div>
                <div class="content">
                    <p>
                        <?php echo $result["content"]?>
                    </p>
                </div>
                <hr>
                <div>
                    <h5>Comments</h5>
                    <?php
                    $sql = "SELECT * FROM comments WHERE post_id = '$id' AND status = 1";
                    $query4 = mysqli_query($connection, $sql);
                    $result3 = mysqli_fetch_assoc($query4);
                    if($result3){
                    $query = mysqli_query($connection, $sql);
                    while ($result2 = mysqli_fetch_assoc($query)) {
                        ?>
                    <div class="row">
                        <div class="col-6">
                            <?php
                                $user_id = $result2["user_id"];
                                     $sql = "SELECT * FROM users WHERE id = '$user_id'";
                                      $query2 = mysqli_query($connection, $sql);
                                     $result3 = mysqli_fetch_assoc($query2);
                            ?>
                            <p>
                                <?php echo $result3["name"] ?> <br>
                                <small><?php echo date("F j, Y", strtotime($result2["timestamp"])) ?></small>
                            </p>
                        </div>
                        <div class="col-6">
                            <?php echo $result2["message"] ?>
                        </div>
                    </div>
                    <?php
                        }
                    }else{
                        echo "No comments yet!";
                    }
                    ?>
                    <hr>
                    <?php
                    if(isset($_SESSION["user"])){
                        ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">New Comment</label>
                            <textarea name="comment_new" id="" cols="30" class="form-control" rows="5"
                                placeholder="Enter comment here"></textarea>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">Submit Comment</button>
                        </div>
                    </form>
                    <?php
                    }else{
                        ?>
                    <a href="login.php">Login to comment</a>
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