<?php
    include_once('config_user.php');
    session_start();

    if(isset($_SESSION["isUserLoggedIn"]) && $_SESSION["isUserLoggedIn"] === true){
        header("location:index.php");
        exit();
    }
    $login_err = "";
    $email = $pass = "";
    $email_err = $pass_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(empty(trim($_POST["email"]))){
            $email_err = "Vui lòng không để trống email";
        } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $email_err = "Vui lòng nhập đúng định dạng email.";
        } else {
            $email = trim($_POST["email"]);
        }

        // kiem tra mat khau
        if(empty(trim($_POST["pass"]))){
            $pass_err = "Vui lòng không để trống mật khẩu.";
        } else {
            $pass = trim($_POST["pass"]);
        }
        
        if(empty($pass_err) && empty($email_err)){
            $row = DP::run_query("select id,name,email,password,address,photo from users where email = ?",[$email],2);
            if(count($row) > 0){
                if(password_verify($pass,$row[0]["password"])){
                        $_SESSION["isUserLoggedIn"] = true;
                        $_SESSION["user_id"] = (int)$row[0]["id"];
                        $_SESSION["user_name"] = $row[0]["name"];
                        $_SESSION["user_email"] = $row[0]["email"];
                        $_SESSION["user_address"] = $row[0]["address"];
                        $_SESSION["user_photo"] = $row[0]["photo"];
                        // giữ tương thích cũ cho phần user
                        $_SESSION["id"] = (int)$row[0]["id"];
                        $_SESSION["name"] = $row[0]["name"];
                        $_SESSION["email"] = $row[0]["email"];
                        $_SESSION["address"] = $row[0]["address"];
                        $_SESSION["photo"] = $row[0]["photo"];
                        if(!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])){
                            $_SESSION["cart"] = array();
                        }
                        header("location:user_info.php");
                } else {
                        $login_err = "Tài khoản hoặc mật khẩu bạn đăng nhập không chính xác";
                }
            } else {
                $login_err = "Email này chưa được đăng ký";
            }
        }
    }
    $_isUserLoginPage = true;
    include_once($level_config_layout.'layout.php');
?>