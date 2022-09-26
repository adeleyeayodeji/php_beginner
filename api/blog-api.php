<?php
//header
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//check if action is get_posts
if (isset($_GET['action']) && $_GET['action'] == 'get_posts') {
    //get all posts
    $sql = "SELECT * FROM posts ORDER BY id DESC";
    $query = mysqli_query($connection, $sql);
    $posts = array();
    while ($result = mysqli_fetch_assoc($query)) {
        $posts[] = [
            "title" => $result['title'],
            "content" => $result['content'],
            "date" => date("F j, Y", strtotime($result['timestamp'])),
            "category" => getCategoryName($result['category_id']),
            "image" => BASE_URL . $result['thumbnail'],
            "author" => "Admin",
            "comments" => getComments($result['id']),
        ];
    }
    //return json response
    echo json_encode($posts);
    exit;
}
