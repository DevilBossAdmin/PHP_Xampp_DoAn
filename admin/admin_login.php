<?php
<<<<<<< HEAD
include_once('config_admin.php');
require_once('admin_auth.php');

admin_session_start_if_needed();
if(is_admin_logged_in()){
    header("location:index.php");
    exit();
}

$login_err = "";
$email = $pass = "";
$email_err = $pass_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["email"] ?? ""))){
        $email_err = "Vui lòng không để trống email";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Vui lòng nhập đúng định dạng email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"] ?? ""))){
        $pass_err = "Vui lòng không để trống mật khẩu.";
    } else {
        $pass = trim($_POST["password"]);
    }

    if(empty($pass_err) && empty($email_err)){
        $rows = DP::run_query("select id,name,email,password,photo,is_lock,is_delete from admins where email = ? limit 1",[$email],2);
        if(is_array($rows) && count($rows) > 0){
            $admin = $rows[0];
            if((int)$admin['is_delete'] === 1 || (int)$admin['is_lock'] === 1){
                $login_err = "Tài khoản quản trị này đã bị khóa hoặc ngừng sử dụng.";
            } elseif(password_verify($pass,$admin["password"])){
                set_admin_session($admin);
                header("location:admin_info.php");
                exit();
            } else {
                $login_err = "Tài khoản hoặc mật khẩu bạn đăng nhập không chính xác";
            }
        } else {
            $login_err = "Tài khoản hoặc mật khẩu bạn đăng nhập không chính xác";
        }
    }
}
$_isLoginPage = true;
include_once($level_config_layout.'layout.php');
=======
     include_once('config_admin.php');

     session_start();
     if(isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true){
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
          if(empty(trim($_POST["password"]))){
               $pass_err = "Vui lòng không để trống mật khẩu.";
          } else {
               $pass = trim($_POST["password"]);
          }
          
          if(empty($pass_err) && empty($email_err)){
               $row = DP::run_query("select id,name,email,password,photo from admins where email = ?",[$email],2);
               if(count($row) > 0){
                    if(password_verify($pass,$row[0]["password"])){

                         $_SESSION["isLoggedIn"] = true;
                         $_SESSION["id"] = $row[0]["id"];
                         $_SESSION["username"] = $row[0]["name"];
                         $_SESSION["email"] = $row[0]["email"];
                         $_SESSION["photo"] = $row[0]["photo"];
                         header("location:admin_info.php");
                    } else {
                         $login_err = "Tài khoản hoặc mật khẩu bạn đăng nhập không chính xác";
                    }
               }
          }
     }
     $_isLoginPage = true;
     include_once($level_config_layout.'layout.php');
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
?>