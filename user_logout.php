<?php
<<<<<<< HEAD
session_start();
unset($_SESSION['isUserLoggedIn'], $_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_address'], $_SESSION['user_photo']);
unset($_SESSION['id'], $_SESSION['name'], $_SESSION['email'], $_SESSION['address'], $_SESSION['photo']);
unset($_SESSION['cart']);
header("location: user_login.php");
exit();
?>
=======
     session_start();
 
     $_SESSION = array();

     session_destroy();
      
     header("location: user_login.php");
     exit();

?>
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
