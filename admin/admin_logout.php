<?php
<<<<<<< HEAD
include_once('config_admin.php');
require_once('admin_auth.php');
admin_session_start_if_needed();
clear_admin_session();
header('location:admin_login.php');
exit();
?>
=======
    session_start();
 
    $_SESSION = array();
     
    session_destroy();
     
    header("location: admin_login.php");
    exit();
?>
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
