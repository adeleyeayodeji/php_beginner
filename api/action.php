<?php
//header
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//accept post and get
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initialize api
require '../inc/connection.php';
//check if the host is 10.0.2.2
if ($_SERVER['HTTP_HOST'] == '10.0.2.2:8888') {
    define('BASE_URL', 'http://10.0.2.2:8888/php_beginner/');
} else {
    define('BASE_URL', 'http://localhost:8888/php_beginner/');
}
//link constant
define('LINK', 'http://localhost:8888/php_beginner/');
//get category name
function getCategoryName($category_id)
{
    global $connection;
    $sql = "SELECT name FROM category WHERE id = $category_id";
    $query = mysqli_query($connection, $sql);
    $result = mysqli_fetch_assoc($query);
    return $result['name'];
}

//get comments 
function getComments($post_id)
{
    global $connection;
    $sql = "SELECT * FROM comments WHERE post_id = $post_id";
    $query = mysqli_query($connection, $sql);
    $comments = array();
    while ($result = mysqli_fetch_assoc($query)) {
        $comments[] = [
            "user_id" => $result['user_id'],
            "name" => getUserData($result['user_id']),
            "message" => $result['message'],
            "date" => date("F j, Y", strtotime($result['timestamp'])),
        ];
    }
    return $comments;
}

//get user data
function getUserData($user_id)
{
    global $connection;
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $query = mysqli_query($connection, $sql);
    $result = mysqli_fetch_assoc($query);
    return $result["name"];
}

function getProductById($product_id)
{
    global $connection;
    $sql = "SELECT * FROM products WHERE id = '$product_id' AND status = 1";
    $query = mysqli_query($connection, $sql);
    $result = mysqli_fetch_assoc($query);
    $product_res = [
        "product_id" => $result['id'],
        "title" => $result['title'],
        "price" => $result['price'],
        "image" => BASE_URL . $result['image'],
    ];
    return $product_res;
}

require_once 'blog-api.php';
require_once 'user-api.php';
require_once 'comment-api.php';
require_once 'search-api.php';
require_once 'product-api.php';
require_once 'order-api.php';
