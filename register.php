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
    <div class="d-flex aligns-items-center justify-content-center py-3">
        <form action="" method="post">
            <h4 class="text-center">Register </h4>
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
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your name" id="">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" placeholder="Enter your email" class="form-control" id="">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" id="">
            </div>
            <hr>
            <p>
                If already registered <a href="login.php">Login</a>
            </p>
            <button type="submit" name="register" class="btn btn-primary my-3">Register</button>
        </form>
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