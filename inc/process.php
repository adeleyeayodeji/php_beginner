<?php
    require "connection.php";
    
    if(isset($_POST["register"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $encrypt_password = md5($password);
        //Check if user already exist
        $sql_check = "SELECT * FROM users WHERE email = '$email'";
        $query_check = mysqli_query($connection, $sql_check);
        if(mysqli_fetch_assoc($query_check)){
            //Already exist
            $error =  "User already exist";
        }else{
            //Insert data to base
            $sql = "INSERT INTO users(name, email, password) VALUES('$name', '$email', '$encrypt_password')";
            $query = mysqli_query($connection, $sql) or die("Cant save data");
            $success =  "Registration completed";
        }
    }

    if(isset($_POST["login"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $encrypt_password = md5($password);
        //Check if user already exist
        $sql_check2 = "SELECT * FROM users WHERE email = '$email'";
        $query_check2 = mysqli_query($connection, $sql_check2);
        if(mysqli_fetch_assoc($query_check2)){
            //Check if user email and password exist
            $sql_check = "SELECT * FROM users WHERE email = '$email' AND password = '$encrypt_password'";
            $query_check = mysqli_query($connection, $sql_check);
            if($result = mysqli_fetch_assoc($query_check)){
                //Login to dashboard
                $_SESSION["user"] = $result;
                if($result["role"] == "user"){
                    if(isset($_SESSION["url"])){
                        $post_id = $_SESSION["url"];
                        header("location: post.php?post_id=$post_id");
                    }else{
                        header("location: index.php");
                    }
                }else{
                    header("location: dashboard.php");
                }
                $success = "User logged in";
            }else{
                //User not found
                $error =  "User password error";
            }
        }else{
            //User not found
            $error =  "User email not found";
        }
        
    }

    if(isset($_POST["category"])){
        $name = $_POST["name"];
        //SQL
        $sql = "INSERT INTO category(name) VALUES('$name')";
        $query = mysqli_query($connection, $sql);
        if($query){
            $success = "Category added";
        }else{
            $error = "Unable to add category";
        }
    }

    if(isset($_GET["delete_category"]) && !empty($_GET["delete_category"])){
        $id = $_GET["delete_category"];
        //SQL
        $sql = "DELETE FROM category WHERE id = '$id'";
        $query = mysqli_query($connection, $sql);
         if($query){
            $success = "Category deleted";
        }else{
            $error = "Unable to delete category";
        }
    }

    if(isset($_POST["edit_category"])){
        $name = $_POST["name"];
        $edit_id = $_GET["edit_id"];
        //SQL
        $sql = "UPDATE category SET name = '$name' WHERE id = '$edit_id'";
        $query = mysqli_query($connection, $sql);
        if($query){
            $success = "Category updated";
        }else{
            $error = "Unable to update category";
        }
    }

    if(isset($_POST["new_post"])){
        //Uploading to upload folder
        $target_dir = "uploads/";
        $basename = basename($_FILES["thumbnail"]["name"]);
        $upload_file = $target_dir.$basename;
        //move uploaded file
        $move = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $upload_file);
        if($move){
            $url = $upload_file;
            $title = $_POST["title"];
            $content = $_POST["content"];
            $status = $_POST["status"];
            $category_id = $_POST["category_id"];
            $thumbnail = $url;
            //SQL
            $sql = "INSERT INTO posts(title, content, status, category_id, thumbnail	
) VALUES('$title', '$content', '$status', '$category_id', '$thumbnail')";
            //Query
            $query = mysqli_query($connection, $sql);
            //Check if is stored
            if($query){
                //Success message
                $success = "Post published";
            }else{
                $error = "Unable to post content";
            }
        }else{
            $error = "Unable to upload image";
        }
    }


    if(isset($_POST["update_post"])){
        $id = $_GET["edit_post_id"];
        if($_FILES["thumbnail"]["name"] != ""){
            //Update image
            $target_dir = "uploads/";
            $url = $target_dir.basename($_FILES["thumbnail"]["name"]);
            //Move to the directory
            if(move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $url)){
                //Update database
                //Parameter
                $title = $_POST["title"];
                $content = $_POST["content"];
                $status = $_POST["status"];
                $category_id = $_POST["category_id"];
                $thumbnail = $url; 
                //SQL
                $sql = "UPDATE posts SET title = '$title', content = '$content', status = '$status', category_id = '$category_id', thumbnail = '$thumbnail' WHERE id = '$id'";  
                //Query
                $query = mysqli_query($connection, $sql);
                //Check if
                if($query){
                    $success = "Post updated";
                }else{
                    $error = "Unable to update post";
                }
            }
        }else{
            //Leave image upload
            //Parameter
                $title = $_POST["title"];
                $content = $_POST["content"];
                $status = $_POST["status"];
                $category_id = $_POST["category_id"];
                //SQL
                $sql = "UPDATE posts SET title = '$title', content = '$content', status = '$status', category_id = '$category_id' WHERE id = '$id'";  
                //Query
                $query = mysqli_query($connection, $sql);
                //Check if
                if($query){
                    $success = "Post updated";
                }else{
                    $error = "Unable to update post";
                }
        }
    }

    if(isset($_GET["delete_post"]) && !empty($_GET["delete_post"])){
        $id = $_GET["delete_post"];
        //SQL
        $sql = "DELETE FROM posts WHERE id = '$id'";
        //Query
        $query = mysqli_query($connection, $sql);
        //Check if
        if($query){
            $success = "Post deleted successfully";
        }else{
            $error = "Unable to delete post";
        }
    }

    if(isset($_POST["comment_new"])){
        $comment = $_POST["comment_new"];
        $user_id = $_SESSION["user"]["id"];
        $post_id = $_GET["post_id"];
        //SQL
        $sql = "INSERT INTO comments(user_id, message, post_id) VALUES('$user_id', '$comment', '$post_id')";
        //Query
        $query = mysqli_query($connection, $sql);
        //Check if
        if($query){
            $success = "Comment added, waiting moderation.";
        }else{
            $error = "Unable to add comment";
        }
    }

    if(isset($_GET["approve_comment"]) && !empty($_GET["approve_comment"])){
        $comment_id = $_GET["approve_comment"];
        //SQL
        $sql = "UPDATE comments SET status = 1 WHERE id = '$comment_id'";
        $query = mysqli_query($connection, $sql);
         //Check if
        if($query){
            $success = "Comment approved";
        }else{
            $error = "Unable to approve comment";
        }
    }
    
    if(isset($_GET["delete_comment"]) && !empty($_GET["delete_comment"])){
        $comment_id = $_GET["delete_comment"];
        //SQL
        $sql = "DELETE FROM comments WHERE id = '$comment_id'";
        $query = mysqli_query($connection, $sql);
         //Check if
        if($query){
            $success = "Comment deleted";
        }else{
            $error = "Unable to delete comment";
        }
    }

    if(isset($_POST["edit_user"])){
        if(isset($_POST["change_password"]) && $_POST["change_password"] == "on"){
            //Change the password
            $id = $_GET["edit_user_id"];
            $name = $_POST["name"];
            $email = $_POST["email"];
            $role = $_POST["role"];
            $password = md5($_POST["password"]);
            //SQL
            $sql = "UPDATE users SET name = '$name', email = '$email', role = '$role', password = '$password' WHERE id = '$id'";
            //Query
            $query = mysqli_query($connection, $sql);
            //Check if
            if($query){
                $success = "User data updated";
            }else{
                $error = "Unable to update user";
            }
        }else{
            // Just update data 
            $id = $_GET["edit_user_id"];
            $name = $_POST["name"];
            $email = $_POST["email"];
            $role = $_POST["role"];
            //SQL
            $sql = "UPDATE users SET name = '$name', email = '$email', role = '$role' WHERE id = '$id'";
            //Query
            $query = mysqli_query($connection, $sql);
            //Check if
            if($query){
                $success = "User data updated";
            }else{
                $error = "Unable to update user";
            }
        }
    }

    if(isset($_POST["new_user_admin"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $role = $_POST["role"];
        $password = md5($_POST["password"]);
        //check if user already exist
        $sql_check = "SELECT * FROM users WHERE email = '$email'";
        $query_check = mysqli_query($connection, $sql_check);
        //Check if
        if(mysqli_fetch_assoc($query_check)){
            //Already exist
            $error = "User already exist";
        }else{
            //User not found
            $sql = "INSERT INTO users(name, email, password, role) VALUES('$name', '$email', '$password', '$role')";
            $query = mysqli_query($connection, $sql);
            //Check if is correct
            if($query){
                $success = "User added successfully";
            }else{
                $error = "Unable to add user";
            }
        }   
    }

    if(isset($_GET["delete_user"]) && !empty($_GET["delete_user"])){
        $id = $_GET["delete_user"];
        $sql = "DELETE FROM users WHERE id = '$id'";
        $query = mysqli_query($connection, $sql);
         //Check if is correct
        if($query){
            $success = "User deleted successfully";
        }else{
            $error = "Unable to delete user";
        }
    }

    if(isset($_POST["new_product"])){
          //Uploading to upload folder
        $target_dir = "uploads/";
        $basename = basename($_FILES["image"]["name"]);
        $upload_file = $target_dir.$basename;
        //move uploaded file
        $move = move_uploaded_file($_FILES["image"]["tmp_name"], $upload_file);
        if($move){
            $url = $upload_file;
            $title = $_POST["title"];
            $content = $_POST["content"];
            $price = $_POST["price"];
            $status = $_POST["status"];
            $category_id = $_POST["category_id"];
            $image = $url;
            //SQL
            $sql = "INSERT INTO products(title, content, status, category_id, image, price	
) VALUES('$title', '$content', '$status', '$category_id', '$image', '$price')";
            //Query
            $query = mysqli_query($connection, $sql);
            //Check if is stored
            if($query){
                //Success message
                $success = "Product published";
            }else{
                $error = "Unable to add product <br>".mysqli_error($connection);
            }
        }else{
            $error = "Unable to upload image";
        }
    }


    if(isset($_POST["edit_product"])){
        $id = $_GET["edit_product_id"];
        //Update image
        if($_FILES["image"]["name"] != ""){
            //Uploading to upload folder
            $target_dir = "uploads/";
            $basename = basename($_FILES["image"]["name"]);
            $upload_file = $target_dir.$basename;
            //move uploaded file
            $move = move_uploaded_file($_FILES["image"]["tmp_name"], $upload_file);
            if($move){
                $url = $upload_file;
                $title = $_POST["title"];
                $content = $_POST["content"];
                $price = $_POST["price"];
                $status = $_POST["status"];
                $category_id = $_POST["category_id"];
                $image = $url;
                //SQL
                $sql = "UPDATE products SET title = '$title', content = '$content', price = '$price', status = '$status', category_id = '$category_id', image = '$image' WHERE id = '$id'";
                //Query
                $query = mysqli_query($connection, $sql);
                //Check if is stored
                if($query){
                    //Success message
                    $success = "Product updated";
                }else{
                    $error = "Unable to update product <br>".mysqli_error($connection);
                }
            }else{
                $error = "Unable to upload a new image";
            }
        }else{
            //Do not update image
            $title = $_POST["title"];
            $content = $_POST["content"];
            $price = $_POST["price"];
            $status = $_POST["status"];
            $category_id = $_POST["category_id"];
            //SQL
            $sql = "UPDATE products SET title = '$title', content = '$content', price = '$price', status = '$status', category_id = '$category_id' WHERE id = '$id'";
            //Query
            $query = mysqli_query($connection, $sql);
            //Check if is stored
            if($query){
                //Success message
                $success = "Product updated";
            }else{
                $error = "Unable to update product <br>".mysqli_error($connection);
            }
        }
    }

     if(isset($_GET["delete_product"]) && !empty($_GET["delete_product"])){
        $id = $_GET["delete_product"];
        $sql = "DELETE FROM products WHERE id = '$id'";
        $query = mysqli_query($connection, $sql);
         //Check if is correct
        if($query){
            $success = "Product deleted successfully";
        }else{
            $error = "Unable to delete product";
        }
    }

    if(isset($_POST["addtocart"])){
        $pid = $_POST["product_id"];
        $quantity = $_POST["quantity"];
        //Add to cart
        $query = $_SESSION["cart"][$pid] = [
            "quantity" => $quantity
        ];
         //Check if is correct
        if($query){
           echo "Product added to cart <a href='cart.php'>Go to Cart</a>";
        }else{
            echo "Unable to add product";
        }
    }

    if(isset($_GET["product_id_remove"]) && !empty($_GET["product_id_remove"])){
        $pid = $_GET["product_id_remove"];
        //Remove from cart
        unset($_SESSION["cart"][$pid]);
        $success = "Product removed";
    }
?>