<div id="wrapper">
 <!-- ****** Header Area Start ****** -->
 <?php
    $userLoggedIn = isset($_SESSION["isUserLoggedIn"]) && $_SESSION["isUserLoggedIn"] === true;
    $userName = $_SESSION["user_name"] ?? $_SESSION["name"] ?? 'Khách hàng';
    $userPhoto = $_SESSION["user_photo"] ?? $_SESSION["photo"] ?? 'image.jpg';
 ?>
 <header class="header_area compact-header bg-img background-overlay-white" style="background-image: url(<?php echo _DIR_['IMG']['USERS'].'bg-img/'.'bg-1.jpg';?>)">
    <div class="top_header_area compact-topbar">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-between">
                <div class="col-12 col-lg-4">
                    <div class="top_single_area d-flex align-items-center justify-content-start">
                        <div class="top_logo compact-logo-wrap">
                            <a href="index.php" class="compact-logo-link">
                                <img width="72" height="72" src=<?php echo _DIR_['IMG']['USERS'].'core-img/'.'logo-2.jpg';?> alt="Logo website">
                            </a>
                            <div class="compact-brand-text">
                                <span>Website linh kiện điện tử</span>
                                <small>Trường Đại học Công Nghệ Đông Á</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="compact-user-actions d-flex align-items-center justify-content-lg-end justify-content-start">
                        <?php if(!$userLoggedIn){ ?>
                            <a class="compact-link" href="user_login.php">Đăng nhập</a>
                            <a class="compact-link compact-link-primary" href="user_register.php">Đăng ký</a>
                        <?php } else { ?>
                            <a class="btn btn-info nav-link user-pill compact-user-pill" href="user_info.php">
                                <span>Xin chào:</span>
                                <?php if($userPhoto === 'image.jpg') { ?>
                                    <img width="30" height="30" class="rounded-circle" src=<?php echo _DIR_['IMG']['USERS'].'info/image.jpg';?> alt="Avatar">
                                <?php } else { ?>
                                    <img width="30" height="30" class="rounded-circle" src=<?php echo _DIR_['IMG']['USERS'].'info/'.htmlspecialchars($userPhoto);?> alt="Avatar">
                                <?php } ?>
                                <strong><?php echo htmlspecialchars($userName);?> </strong>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main_header_area compact-mainmenu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg compact-navbar">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#karl-navbar" aria-controls="karl-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i class="ti-menu"></i></span></button>
                        <div class="collapse navbar-collapse" id="karl-navbar">
                            <ul class="navbar-nav animated compact-nav-list" id="nav">
                                <li class="nav-item active"><a class="nav-link" href="index.php">Trang chủ</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="karlDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mục chọn</a>
                                    <div class="dropdown-menu" aria-labelledby="karlDropdown">
                                        <a class="dropdown-item" href="index.php">Menu</a>
                                        <a class="dropdown-item" href="user_info.php">Thông tin cá nhân</a>
                                        <a class="dropdown-item" href="user_cart.php">Giỏ hàng</a>
                                        <?php if($userLoggedIn){ ?>
                                        <a class="dropdown-item" href="user_logout.php">Đăng xuất</a>
                                        <?php } ?>
                                    </div>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#danh-muc">Danh mục</a></li>
                                <li class="nav-item"><a class="nav-link" href="user_cart.php">Giỏ hàng của bạn</a></li>
                                <li class="nav-item"><a class="nav-link" href="#payment-methods">Thanh toán</a></li>
                                <li class="nav-item"><a class="nav-link" href="#site-footer">Liên hệ</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
 </header>
 <!-- ****** Header Area End ****** -->
