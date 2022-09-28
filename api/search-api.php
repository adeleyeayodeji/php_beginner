<?php

//check if search is set
if (isset($_GET['action']) && $_GET['action'] == 'search') {
    $search_text = $_POST["search_text"];
    $type = $_POST["type"];
    //sanitize
    $search_text = mysqli_real_escape_string($connection, $search_text);
    $type = mysqli_real_escape_string($connection, $type);
    //check if type is post
    if ($type == "post") {
        //check if post is found in base
        $sql = "SELECT * FROM posts WHERE title LIKE '%$search_text%' OR content LIKE '%$search_text%'";
        $query = mysqli_query($connection, $sql);
        $posts = array();
        while ($result = mysqli_fetch_assoc($query)) {
            $posts[] = [
                "post_id" => $result['id'],
                "title" => $result['title'],
                "content" => $result['content'],
                "date" => date("F j, Y", strtotime($result['timestamp'])),
                "category" => getCategoryName($result['category_id']),
                "image" => BASE_URL . $result['thumbnail'],
                "author" => "Admin",
                "comments" => getComments($result['id']),
                "link" => LINK . "article/" . $result["id"] . "/" . str_replace(" ", "-", str_replace("%", "", strtolower($result["title"])))
            ];
        }
        if (count($posts) > 0) {
            //return json response
            echo json_encode(["code" => 200, "posts" => $posts]);
        } else {
            echo json_encode(["code" => 404, "message" => "No post found"]);
        }
        exit;
    } else {
        //check if product is found in base
        $sql = "SELECT * FROM products WHERE title LIKE '%$search_text%' OR content LIKE '%$search_text%'";
        $query = mysqli_query($connection, $sql);
        $products = array();
        while ($result = mysqli_fetch_assoc($query)) {
            $products[] = [
                "product_id" => $result['id'],
                "title" => $result['title'],
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
}
