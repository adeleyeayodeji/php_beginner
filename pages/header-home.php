<nav class="navbar navbar-light bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php">
            <img src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24"
                class="d-inline-block align-text-top">
            Bootstrap
        </a>
        <div class="d-flex">
            <a href="store.php" class="nav-link text-white">Store</a>
            <a href="cart.php" class="nav-link text-white">Cart (<?php  if(isset($_SESSION["cart"])){
                    echo count($_SESSION["cart"]);
                }else{
                    echo 0;
                }
                ?>)</a>
            <?php
            if(isset($_SESSION["user"])){
                ?>
            <a href="dashboard.php" class="nav-link text-white">Dashboard</a>
            <a href="logout.php" class="nav-link text-danger">Logout</a>
            <?php
            }else{
                ?>
            <a href="login.php" class="nav-link text-white">Login</a>
            <a href="register.php" class="nav-link text-white">Register</a>
            <?php
            }
            ?>
        </div>
    </div>
</nav>