<?php
    include_once('config_user.php');
    $_isUserOrderSuccessPage = true;
    $_enableChatAiBox = false;
    session_start();

    if(!isset($_SESSION["isUserLoggedIn"]) || $_SESSION["isUserLoggedIn"] !== true){
        header("location:user_login.php");
        exit();
    }

    include_once($level_config_layout.'layout.php');
?>
