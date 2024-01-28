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
    if (isset($_SESSION["cart"])) {
        $total = 0;
        foreach ($_SESSION["cart"] as $key => $value) {
            $product_id = $key;
            //get product price
            $sql = "SELECT * FROM products WHERE id = '$product_id'";
            $query = mysqli_query($connection, $sql);
            $result = mysqli_fetch_assoc($query);
            //Spliting the details
            $price = intval($result["price"]);
            $quantity = intval($value["quantity"]);
            $total1 = $price * $quantity;
            $total += $total1;
        }
    }
    ?>
    <div class="py-3">
        <h2>Checkout</h2>
        <hr>
        <div class="row">
            <div class="col">
                <?php
                if (isset($_SESSION["user"])) {
                ?>
                    <h2 class="text-center">Make payment of #<?php echo number_format($total ?? 0) ?></h2>
                    <hr>
                    <div class="row">
                        <div class="col-12" id="message" style="display:none;">
                            <div class="alert alert-success">
                                <strong>Verifying payment please wait...</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Flutterwave payment -->
                            <h2>Pay with</h2>
                            <img src="assets/img/Flutterwave.png" id="flutterpay" onclick="makePayment()" style="height: 70px;" alt="">
                        </div>
                        <div class="col-6">
                            <!-- Paystack payment -->
                            <h2>Pay with</h2>
                            <img src="assets/img/1_nhszIhUonirsqTPGelkoFg.jpeg" style="height: 70px;" alt="" id="paystackpay" onclick="payWithPaystack()">
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <h2 class="text-center"><a href="login.php">Login</a> to Checkout</h2>
                <?php
                }
                ?>
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
if (isset($_SESSION["user"])) {
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
        function payWithPaystack() {
            let handler = PaystackPop.setup({
                key: 'pk_test_6f4b359d153b9ff2e31970e93cf5dd9054693d4e', // Replace with your public key
                email: "<?php echo $_SESSION["user"]["email"] ?>",
                amount: <?php echo $total ?? 0 ?> * 100,
                ref: '' + Math.floor((Math.random() * 1000000000) +
                    1
                ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                // label: "Optional string that replaces customer email"
                onClose: function() {
                    alert('Window closed.');
                },
                callback: function(response) {
                    let reference = response.reference;
                    //Ajax
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            "paystack": reference
                        },
                        beforeSend: function() {
                            $("#message").fadeIn();
                            $("#paystackpay").fadeOut();
                        },
                        success: function(response) {
                            if (response.code == 200) {
                                $("#message").find("strong").html(
                                    "Payment Successfully made! <br>Now redirecting to orders page..."
                                );
                                //Redirect to orders page
                                window.location.href = "user.php";
                            }
                        }
                    });
                }
            });
            handler.openIframe();
        }

        function makePayment() {
            var p = FlutterwaveCheckout({
                public_key: "FLWPUBK_TEST-308e76d9c3020abf4b61a148a86c1a06-X",
                tx_ref: "<?php echo "PHP_" . substr(rand(0, time()), 0, 6); ?>",
                amount: <?php echo $total ?? 0 ?>,
                currency: "NGN",
                country: "NG",
                payment_options: " ",
                customer: {
                    email: "<?php echo $_SESSION["user"]["email"] ?>",
                    phone_number: "",
                    name: "<?php echo $_SESSION["user"]["name"] ?>",
                },
                callback: function(data) {
                    console.log(data);
                    p.close();
                    //Make ajax request
                    var tx_id = data.transaction_id;
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            "tx_id": tx_id
                        },
                        beforeSend: function() {
                            $("#message").fadeIn();
                            $("#flutterpay").fadeOut();
                        },
                        success: function(response) {
                            if (response.code == 200) {
                                $("#message").find("strong").html(
                                    "Payment Successfully made! <br>Now redirecting to orders page..."
                                );
                                //Redirect to orders page
                                window.location.href = "user.php";
                            }
                        }
                    });
                },
                onclose: function() {
                    // close modal
                    alert("Payment cancelled");
                },
                customizations: {
                    title: "Product Checkout",
                    description: "Payment for items in cart",
                    // logo: "https://assets.piedpiper.com/logo.png",
                },
            });
        }
    </script>
<?php
}
require "inc/footer.php";
?>