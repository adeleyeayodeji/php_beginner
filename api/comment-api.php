<?php
//check if comment is set
if (isset($_GET['action']) && $_GET['action'] == 'add_comment') {
    $user_id = $_POST["user_id"];
    $post_id = $_POST["post_id"];
    $message = $_POST["message"];
    //sanitize
    $user_id = mysqli_real_escape_string($connection, $user_id);
    $post_id = mysqli_real_escape_string($connection, $post_id);
    $message = mysqli_real_escape_string($connection, $message);
    //check if user_id, post_id and message is empty
    if (empty($user_id) || empty($post_id) || empty($message)) {
        echo json_encode(["error" => "All fields are required", "code" => 400]);
        exit;
    } else {
        //add comment
        $sql = "INSERT INTO comments (user_id, post_id, message) VALUES ('$user_id', '$post_id', '$message')";
        $query = mysqli_query($connection, $sql);
        if ($query) {
            echo json_encode(["message" => "Comment added successfully", "code" => 200]);
            exit;
        } else {
            echo json_encode(["error" => "Something went wrong", "code" => 500]);
            exit;
        }
    }
    exit;
}
