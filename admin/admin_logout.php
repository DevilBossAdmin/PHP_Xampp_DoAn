<?php
include_once('config_admin.php');
require_once('admin_auth.php');
admin_session_start_if_needed();
clear_admin_session();
header('location:admin_login.php');
exit();
?>
