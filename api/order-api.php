<?php
//check if search is set
if (isset($_GET['action']) && $_GET['action'] == 'create_order') {
    $user_id = $_POST['user_id'];
    $products = $_POST["products"];
    $tx_id = $_POST["tx_id"];
    $total = $_POST["total"];
    $payment_gateway = $_POST["payment_gateway"];
    $status = "Processing";
    $payment_status = "paid";
    $payment_method = $payment_gateway;
    //foreach
    foreach ($products as $product) {
        $product_id = $product["product_id"];
        $quantity = $product["quantity"];
        //process database query
        $order_id = $tx_id;
        $amount = $total;
        //Insert into orders table
        $sql = "INSERT INTO 
                orders(order_id, amount, user_id, product_id, quantity, status, payment_status, payment_method) 
                
                VALUES('$order_id', '$amount', '$user_id', '$product_id', '$quantity', '$status', '$payment_status', '$payment_method')";
        //Query
        $query = mysqli_query($connection, $sql);
    }
    //check if query is true
    if ($query) {
        echo json_encode([
            "code" => 200,
            "message" => "Order created successfully",
        ]);
    } else {
        echo json_encode(
            [
                "code" => 401,
                "message" => "Something went wrong!"
            ]
        );
    }
    exit;
}


//check if search is set
if (isset($_GET['user_action']) && $_GET['user_action'] == 'get_order') {
    $user_id = $_GET['user_id'];
    //check if user_id is empty
    if (empty($user_id)) {
        echo json_encode(["code" => 401, "message" => "User id is required"]);
        exit;
    } else {
        //get order
        $sql = "SELECT * FROM orders WHERE user_id = '$user_id' GROUP BY order_id ORDER BY id DESC";
        $query = mysqli_query($connection, $sql);
        $orders = array();
        while ($result = mysqli_fetch_assoc($query)) {
            $orders[] = [
                "order_id" => $result['order_id'],
                "amount" => $result['amount'],
                "product_id" => $result['product_id'],
                "quantity" => $result['quantity'],
                "status" => $result['status'],
                "payment_status" => $result['payment_status'],
                "date" => date("F j, Y", strtotime($result['timestamp'])),
            ];
        }
        //return json response
        echo json_encode($orders);
        exit;
    }
    exit;
}

//check if search is set
if (isset($_GET['user_action']) && $_GET['user_action'] == 'get_order') {
    $user_id = $_GET['user_id'];
    //check if user_id is empty
    if (empty($user_id)) {
        echo json_encode(["code" => 401, "message" => "User id is required"]);
        exit;
    } else {
        //get order
        $sql = "SELECT * FROM orders WHERE user_id = '$user_id' GROUP BY order_id ORDER BY id DESC";
        $query = mysqli_query($connection, $sql);
        $orders = array();
        while ($result = mysqli_fetch_assoc($query)) {
            $orders[] = [
                "order_id" => $result['order_id'],
                "amount" => $result['amount'],
                "product_id" => $result['product_id'],
                "quantity" => $result['quantity'],
                "status" => $result['status'],
                "payment_status" => $result['payment_status'],
                "date" => date("F j, Y", strtotime($result['timestamp'])),
            ];
        }
        //return json response
        echo json_encode($orders);
        exit;
    }
    exit;
}

//get single order
if (isset($_GET['user_action']) && $_GET['user_action'] == 'get_order_by_id') {
    $user_id = $_GET['user_id'];
    $order_id = $_GET['order_id'];
    //check if user_id is empty
    if (empty($user_id)) {
        echo json_encode(["code" => 401, "message" => "User id is required"]);
        exit;
    } else {
        //get order
        $sql = "SELECT * FROM orders WHERE user_id = '$user_id' AND order_id = '$order_id' ORDER BY id DESC";
        $query = mysqli_query($connection, $sql);
        $orders = array();
        while ($result = mysqli_fetch_assoc($query)) {
            $orders[] = [
                "order_id" => $result['order_id'],
                "amount" => $result['amount'],
                "product_id" => $result['product_id'],
                "quantity" => $result['quantity'],
                "status" => $result['status'],
                "payment_status" => $result['payment_status'],
                "date" => date("F j, Y", strtotime($result['timestamp'])),
                "product" => getProductById($result['product_id']),
            ];
        }
        //order
        $orderres = [
            "order_id" => $orders[0]['order_id'],
            "amount" => $orders[0]['amount'],
            "status" => $orders[0]['status'],
            "payment_status" => $orders[0]['payment_status'],
            "date" => $orders[0]['date'],
        ];
        //loop through orders
        foreach ($orders as $order) {
            $orderres['products'][] = [
                "quantity" => $order['quantity'],
                "product" => $order['product'],
            ];
        }
        //return json response
        echo json_encode($orderres);
        exit;
    }
    exit;
}
