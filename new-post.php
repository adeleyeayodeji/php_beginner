<?php
session_start();
if(!isset($_SESSION["user"])){
    header("location: login.php");
}

if($_SESSION["user"]["role"] == "user"){
    header("location: index.php");
}
//Script links
require "inc/header.php"; 
?>
<div class="container">
    <?php
//For header content
require './pages/header-home.php';
include "inc/process.php";
?>
    <div class="container p-3">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <h4>Welcome <?php echo $_SESSION["user"]["name"]; ?></h4>
                    </div>
                    <div class="col-6">
                        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <h6>Navigations</h6>
                <ul>
                    <li>
                        <a href="posts.php">Posts</a>
                    </li>
                    <li>
                        <a href="comments.php">Comments</a>
                    </li>
                    <li>
                        <a href="new-post.php" class="text-danger">Add New Post</a>
                    </li>
                    <li>
                        <a href="category.php">Categories</a>
                    </li>
                    <li>
                        <a href="users.php">Users</a>
                    </li>
                    <li>
                        <a href="new-user.php">Add New User</a>
                    </li>
                    <li>
                        <a href="products.php">All Products</a>
                    </li>
                    <li>
                        <a href="new-product.php">New Product</a>
                    </li>
                </ul>
            </div>
            <div class="col-9">
                <div class="container">
                    <h6>Add new post</h6>
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
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Select Thumbnail</label>
                            <input type="file" name="thumbnail" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" placeholder="Enter title" class="form-control" id="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="1">Active</option>
                                        <option value="0">Not active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="category_id" class="form-control" id="">
                                        <?php
                                           $sql = "SELECT * FROM category ORDER BY id DESC"; 
                                           $query = mysqli_query($connection, $sql);
                                           //print down category
                                           while ($result = mysqli_fetch_assoc($query)) {
                                               ?>
                                        <option value="<?php echo $result["id"] ?>">
                                            <?php echo $result["name"] ?>
                                        </option>
                                        <?php
                                           }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" placeholder="Enter post content" id="" cols="30"
                                class="form-control" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary mt-2" name="new_post">Publish</button>
                        </div>
                    </form>
                </div>
            </div>
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