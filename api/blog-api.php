<?php

//check if action is get_posts
if (isset($_GET['action']) && $_GET['action'] == 'get_posts') {
    //get all posts
    $sql = "SELECT * FROM posts ORDER BY id DESC";
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
    //return json response
    echo json_encode($posts);
    exit;
}

//get single post
if (isset($_GET['action']) && $_GET['action'] == 'get_post') {
    //get post id
    $post_id = mysqli_real_escape_string($connection, $_GET['post_id']);
    //get post
    $sql = "SELECT * FROM posts WHERE id = '$post_id'";
    $query = mysqli_query($connection, $sql);
    $result = mysqli_fetch_assoc($query);
    $post = [
        "post_id" => $result['id'],
        "content" => $result['content']
    ];
    //return json response
    echo json_encode($post);
    exit;
}

//get comment for a post
if (isset($_GET['action']) && $_GET['action'] == 'get_comments') {
    //get post id
    $post_id = mysqli_real_escape_string($connection, $_GET['post_id']);
    //get comments
    $sql = "SELECT * FROM comments WHERE post_id = '$post_id' AND status = 1 ORDER BY id DESC";
    $query = mysqli_query($connection, $sql);
    $comments = array();
    while ($result = mysqli_fetch_assoc($query)) {
        $comments[] = [
            "comment_id" => $result['id'],
            "comment" => $result['message'],
            "date" => date("F j, Y", strtotime($result['timestamp'])),
            "user" => getUserData($result['user_id']) ?: "Anonymous",
        ];
    }
    //return json response
    echo json_encode($comments);
    exit;
}
