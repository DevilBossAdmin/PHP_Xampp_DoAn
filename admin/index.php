<?php
    require_once('admin_auth.php');
    require_admin_login();
    include_once('config_admin.php');
    $_isIndexPage = true;
    include_once($level_config_layout.'layout.php');
    
?>