<?php
//login user
if (isset($_GET['action']) && $_GET['action'] == 'user_login') {
    //get email and password
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    //check if email and password is empty
    if (empty($email) || empty($password)) {
        echo json_encode(["error" => "Email and password is required"]);
        exit;
    } else {
        //login user
        //check if email exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $query = mysqli_query($connection, $sql);
        if (mysqli_num_rows($query) > 0) {
            //check if password is correct
            $result = mysqli_fetch_assoc($query);
            //convert to md5
            $password = md5($password);
            if ($password === $result['password']) {
                //unset passoword
                unset($result['password']);
                //login user 
                echo json_encode(["message" => "Login successful", "code" => 200, "user_details" => $result]);
                exit;
            } else {
                echo json_encode(["error" => "Password is incorrect", "code" => 401]);
                exit;
            }
        } else {
            echo json_encode(["error" => "Email does not exists on the server", "code" => 404]);
            exit;
        }
    }
    exit;
}
