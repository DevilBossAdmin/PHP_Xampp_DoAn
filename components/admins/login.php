
<<<<<<< HEAD
<body class="hold-transition login-page admin-login-page">
    <div class="admin-login-wrap">
        <div class="admin-login-card">
            <div class="admin-login-brand">
                <div class="admin-login-badge"><i class="fas fa-shield-alt"></i> Khu vực quản trị</div>
                <img src="../img/img-user/core-img/logo.png" alt="Logo" class="brand-logo">
                <h1>Đăng nhập Admin để quản lý website bán hàng</h1>
                <p>Quản lý sản phẩm, danh mục, đơn hàng và phản hồi khách hàng trong một giao diện tập trung, hiện đại và dễ sử dụng.</p>
                <div class="admin-login-highlights">
                    <div class="item"><i class="fas fa-box-open"></i><span>Quản lý sản phẩm và danh mục nhanh hơn</span></div>
                    <div class="item"><i class="fas fa-receipt"></i><span>Theo dõi đơn hàng và xác nhận thanh toán tiện lợi</span></div>
                    <div class="item"><i class="fas fa-headset"></i><span>Hỗ trợ khách hàng và kiểm soát nội dung hiệu quả</span></div>
                </div>
            </div>
            <div class="admin-login-form-panel">
                <img src="../img/img-user/core-img/logo.png" alt="Logo" class="mini-logo">
                <div class="admin-login-title">Xin chào quản trị viên</div>
                <div class="admin-login-subtitle">Đăng nhập để truy cập khu vực điều hành hệ thống. Vui lòng nhập đúng email và mật khẩu admin.</div>

                <?php if(!empty($login_err)){ ?>
                    <div class="alert alert-danger alert-dismissible fade show admin-login-alert" role="alert">
                        <?php echo $login_err; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="admin-login-form">
                    <div class="form-group">
                        <label class="form-label">Email quản trị</label>
                        <div class="input-group">
                            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control <?php echo empty($email_err) ? '' : 'is-invalid'; ?>" placeholder="Nhập email admin">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <?php if(!empty($email_err)){ ?><div class="text-danger"><?php echo $email_err?></div><?php } ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mật khẩu</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control <?php echo empty($pass_err) ? '' : 'is-invalid'; ?>" placeholder="Nhập mật khẩu">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <?php if(!empty($pass_err)){ ?><div class="text-danger"><?php echo $pass_err?></div><?php } ?>
                    </div>

                    <div class="admin-login-actions">
                        <div class="admin-login-note"><i class="fas fa-user-shield mr-1"></i> Chỉ dành cho tài khoản quản trị hệ thống</div>
                        <button type="submit" class="btn btn-primary btn-admin-login">Đăng nhập</button>
                    </div>
                </form>

                <div class="admin-login-footer">
                    <strong>Website bán linh kiện điện tử</strong><br>
                    Kiểm soát bài thực hiện tại: <strong>Trường Đại học Công Nghệ Đông Á</strong>
                </div>
            </div>
=======

<body class="hold-transition login-page">
    
    <?php
        if(!empty($login_err)){
    ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $login_err; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    <?php
        }
    ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="index.php"><b>Website bán hàng</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
            <p class="login-box-msg">Đăng nhập</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <div class="input-group mb-3">
                    <div class="input-group">
                        <input type="email" name="email" class="form-control  <?php empty($email_err) ? 'has-error' :'' ;?>" placeholder="Email">
                        <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="text-danger"><?php echo $email_err?></div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group">
                        <input type="password" name="password" class="form-control <?php empty($pass_err) ? 'has-error' :'' ;?>" placeholder="Password">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="text-danger"><?php echo $pass_err?></div>
                </div>
                <div class="row">
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                </div>
                <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->
            <!-- /.login-card-body -->
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
        </div>
    </div>
