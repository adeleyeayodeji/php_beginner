<?php
//check if search is set
if (isset($_GET['action']) && $_GET['action'] == 'get_products') {
    //check if product is found in base
    $sql = "SELECT * FROM products WHERE status = 1 ORDER BY id DESC";
    $query = mysqli_query($connection, $sql);
    $products = array();
    while ($result = mysqli_fetch_assoc($query)) {
        $products[] = [
            "product_id" => $result['id'],
            "title" => $result['title'],
            "price" => $result['price'],
            "content" => $result['content'],
            "date" => date("F j, Y", strtotime($result['timestamp'])),
            "category" => getCategoryName($result['category_id']),
            "image" => BASE_URL . $result['image'],
            "author" => "Admin",
            "comments" => getComments($result['id']),
            "link" => LINK . "store_product/" . $result["id"] . "/" . str_replace(" ", "-", str_replace("%", "", strtolower($result["title"])))
        ];
    }
    //return json response
    echo json_encode($products);
    exit;
}
