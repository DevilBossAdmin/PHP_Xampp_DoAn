<?php
<<<<<<< HEAD
    require_once('admin_auth.php');
    require_admin_login();
=======
    session_start();
    if(!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true){
       header("location:admin_login.php");
       exit();
    }
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
    include_once('config_admin.php');
    $_isIndexPage = true;
    include_once($level_config_layout.'layout.php');
    
?>