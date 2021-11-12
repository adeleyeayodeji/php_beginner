<?php
session_start();
if(!isset($_SESSION["user"])){
    header("location: login.php");
}
if($_SESSION["user"]["role"] == "user"){
    header("location: user.php");
}

//Script links
require "inc/header.php"; 

if(isset($_GET["order_id"]) && !empty($_GET["order_id"])){
    $order_id_data = $_GET["order_id"];
    $sql_get = "SELECT * FROM orders WHERE order_id = '$order_id_data'";
    $query_get = mysqli_query($connection, $sql_get);
    $result_get = mysqli_fetch_assoc($query_get);
}
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
<div class="container">
    <?php
//For header content
require './pages/header-home.php';
include "inc/process.php";
?>
    <div class="py-3">
        <h2>User Dashboard</h2>
        <hr>
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
        <div class="row">
            <h3>Order ID :: <?php echo $order_id_data; ?></h3>
            <h5>Order Status :: <?php echo $result_get["status"]; ?></h5>
            <div class="form-group">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Change Status</label>
                        <select name="order_status" class="form-control w-25" id="">
                            <option value="Processing"
                                <?php echo $result_get["status"] == "Processing" ? "selected" : ""; ?>>Processing
                            </option>
                            <option value="Completed"
                                <?php echo $result_get["status"] == "Completed" ? "selected" : ""; ?>>Completed</option>
                            <option value="Cancelled"
                                <?php echo $result_get["status"] == "Cancelled" ? "selected" : ""; ?>>Cancelled</option>
                        </select>
                    </div>
                    <button class="btn btn-primary my-2">Change Status</button>
                </form>
            </div>
            <table id="myorders" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM orders WHERE order_id = '$order_id_data' ORDER By id DESC";
                        $query = mysqli_query($connection, $sql);
                        while ($result = mysqli_fetch_assoc($query)) {
                            ?>
                    <tr>
                        <td><?php echo $result["order_id"] ?></td>
                        <td>#<?php echo number_format($result["amount"]) ?></td>
                        <td>
                            <?php echo $result["payment_method"] ?>
                        </td>
                        <td>
                            <?php
                            $pid = $result["product_id"];
                            //Fetch product from base
                            $sql2 = "SELECT * FROM products WHERE id = $pid";
                            $query2 = mysqli_query($connection, $sql2);
                            $result2 = mysqli_fetch_assoc($query2);
                        ?>
                            <img src="<?php echo $result2["image"]; ?>"
                                style="height: 25px;width: 25px;object-fit: cover;object-position: center;" alt="">
                            <?php echo $result2["title"]; ?>
                        </td>
                        <td><?php echo $result["quantity"] ?></td>
                        <td><?php echo $result["status"] ?></td>
                        <td><?php echo $result["timestamp"] ?></td>
                        <td>
                            <a href="vieworder.php?order_id=<?php echo $result["order_id"] ?>">View Order</a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Order Id</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <?php
//Footer content
require './pages/footer-home.php';
//Footer script links
?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#myorders').DataTable();
    });
    </script>
</div>
<?php
require "inc/footer.php";
?>