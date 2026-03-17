    <!--Core JavaScript file  -->
    <script src=<?php echo _DIR_['PLUGINS']['USERS'].'jquery/jquery.min.js'?>></script>
    <!--bootstrap JavaScript file  -->
    <!-- jQuery UI 1.11.4 -->
    <script src=<?php echo _DIR_['PLUGINS']['USERS'].'jquery-ui/jquery-ui.min.js';?>></script>
    <script src=<?php echo _DIR_['PLUGINS']['USERS'].'bootstrap/js/bootstrap.js'?>></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'></script>
    <script src=<?php echo _DIR_['JS']['USERS'].'main.js'?>></script>
    
    <script src=<?php echo _DIR_['JS']['USERS'].'popper.min.js'?>></script>
    <script src=<?php echo _DIR_['JS']['USERS'].'bootstrap.min.js'?>></script>
    <script src=<?php echo _DIR_['JS']['USERS'].'custom_image.js'?>></script>
    <script src=<?php echo _DIR_['JS']['USERS'].'user.js'?>></script>
    <script src=<?php echo _DIR_['JS']['USERS'].'cart.js'?>></script>
<<<<<<< HEAD
    <script src=<?php echo _DIR_['JS']['USERS'].'chat-aibox.js'?>></script>
=======
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda

    
    
    
<<<<<<< HEAD

<?php if(!empty($_enableChatAiBox)) { ?>
<div class="chat-aibox" data-endpoint="chat_ai_box.php">
    <div class="chat-aibox-panel">
        <div class="chat-aibox-header">
            <h6>ChatAiBox hỗ trợ mua sắm</h6>
            <p>Nhấn câu hỏi nhanh hoặc nhập nhu cầu để được gợi ý sản phẩm và hướng dẫn thanh toán.</p>
        </div>
        <div class="chat-aibox-messages">
            <div class="chat-msg bot"><div class="bubble">Xin chào! Mình là ChatAiBox. Bạn có thể hỏi: <strong>tìm sản phẩm</strong>, <strong>hướng dẫn thanh toán</strong>, <strong>liên hệ quản lý viên</strong>, hoặc <strong>theo dõi đơn hàng</strong>.</div></div>
        </div>
        <div class="chat-aibox-quick">
            <button type="button" data-text="Tìm laptop gaming">Laptop gaming</button>
            <button type="button" data-text="Màn hình 2K">Màn hình 2K</button>
            <button type="button" data-text="Thanh toán MoMo">Thanh toán MoMo</button>
            <button type="button" data-text="Liên hệ quản lý viên">Quản lý viên</button>
        </div>
        <form class="chat-aibox-form">
            <input type="text" name="message" placeholder="Ví dụ: tìm RAM 16GB hoặc hỏi thanh toán VNPay...">
            <button type="submit">Gửi</button>
        </form>
    </div>
    <button class="chat-aibox-toggle" type="button" title="Mở ChatAiBox"><i class="fa fa-comments"></i></button>
</div>
<?php } ?>

=======
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
</body>
</html>