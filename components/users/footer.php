<!-- ****** Footer Area Start ****** -->
<footer class="footer_area compact-footer" id="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-5 mb-4">
                <div class="single_footer_area">
                    <div class="footer-logo d-flex align-items-center mb-3">
                        <img src=<?php echo _DIR_['IMG']['USERS'].'core-img/'.'logo-2.jpg';?> alt="Logo" style="width:58px;height:58px;object-fit:cover;border-radius:12px;margin-right:12px;">
                        <div>
                            <h5 class="mb-1">Website linh kiện điện tử</h5>
                            <p class="mb-0">Đồ án website bán hàng với giao diện người dùng tối ưu, danh mục mở rộng và hỗ trợ ChatAiBox.</p>
                        </div>
                    </div>
                    <p><strong>Địa chỉ kiểm soát bài:</strong> Trường Đại học Công Nghệ Đông Á</p>
                    <p><strong>Hỗ trợ khách hàng:</strong> Đăng nhập tài khoản để theo dõi giỏ hàng, đơn hàng và phản hồi sản phẩm.</p>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-4">
                <div class="single_footer_area">
                    <h6>Điều hướng</h6>
                    <ul class="footer_widget_menu">
                        <li><a href="index.php">Trang chủ</a></li>
                        <li><a href="#danh-muc">Danh mục</a></li>
                        <li><a href="user_cart.php">Giỏ hàng</a></li>
                        <li><a href="user_info.php">Tài khoản</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-6 col-md-2 mb-4">
                <div class="single_footer_area">
                    <h6>Thanh toán</h6>
                    <ul class="footer_widget_menu">
                        <li><a href="#payment-methods">COD</a></li>
                        <li><a href="user_payment_qr.php?method=momo">MoMo QR</a></li>
                        <li><a href="user_payment_qr.php?method=vnpay">VNPay QR</a></li>
                        <li><a href="user_payment_qr.php?method=banking">Chuyển khoản</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-4">
                <div class="single_footer_area">
                    <h6>ChatAiBox</h6>
                    <p class="mb-2">Hỗ trợ tìm sản phẩm, gợi ý danh mục và hướng dẫn liên hệ quản lý viên.</p>
                    <?php if(!empty($_enableChatAiBox)) { ?><button type="button" class="btn btn-info btn-sm chat-launch-btn">Mở ChatAiBox</button><?php } ?>
                </div>
            </div>
        </div>
        <div class="footer-bottom-bar d-flex flex-wrap justify-content-between align-items-center">
            <p class="mb-0">© <script>document.write(new Date().getFullYear());</script> Website linh kiện điện tử.</p>
            <p class="mb-0">Thực hiện và kiểm soát tại Trường Đại học Công Nghệ Đông Á.</p>
        </div>
    </div>
</footer>
<!-- ****** Footer Area End ****** -->
</div>
