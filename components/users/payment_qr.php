<?php
$billId = isset($_GET['bill']) ? (int)$_GET['bill'] : 0;
$method = isset($_GET['method']) ? trim($_GET['method']) : 'momo';
$allowedMethods = ['momo', 'vnpay', 'banking'];
if (!in_array($method, $allowedMethods, true)) {
    $method = 'momo';
}
$userId = (int)($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0);
$orderRows = [];
$orderItems = [];
$totalAmount = (int)($_SESSION['last_bill_amount'] ?? 0);
if ($billId > 0 && $userId > 0) {
    $orderRows = DP::run_query("select * from hoadons where id = ? and user_id = ? limit 1", [$billId, $userId], 2);
    if (is_array($orderRows) && count($orderRows) > 0) {
        $orderItems = DP::run_query(
            "select s.ten_san_pham, c.so_luong, c.don_gia from chitiethoadons c join sanphams s on c.san_pham_id = s.id where c.hoa_don_id = ?",
            [$billId], 2
        );
        $calcAmount = 0;
        foreach (($orderItems ?: []) as $it) {
            $calcAmount += ((int)$it['so_luong'] * (int)$it['don_gia']);
        }
        if ($calcAmount > 0) { $totalAmount = $calcAmount; }
    }
}
$labels = [
  'momo' => ['name' => 'MoMo', 'desc' => 'Quét mã QR MoMo để thanh toán đơn hàng.', 'image' => 'img/payment/momo-qr-demo.jpg'],
  'vnpay' => ['name' => 'VNPay', 'desc' => 'Quét mã QR VNPay để thanh toán đơn hàng.', 'image' => 'img/payment/vnpay-qr-demo.jpg'],
  'banking' => ['name' => 'Chuyển khoản', 'desc' => 'Quét mã QR chuyển khoản (dùng QR VNPay để demo đồ án).', 'image' => 'img/payment/vnpay-qr-demo.jpg'],
];
$info = $labels[$method];
$order = (is_array($orderRows) && count($orderRows) > 0) ? $orderRows[0] : null;
?>
<section class="payment-qr-area section_padding_100_70 clearfix">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="payment-qr-hero mb-4">
          <div>
            <span class="payment-badge">Thanh toán đơn hàng</span>
            <h2><?php echo $info['name']; ?> QR</h2>
            <p><?php echo $info['desc']; ?> Vui lòng kiểm tra đúng tên người nhận, số điện thoại, địa chỉ và tổng tiền trước khi chuyển khoản.</p>
          </div>
          <div class="payment-method-tabs">
            <a class="<?php echo $method === 'momo' ? 'active' : ''; ?>" href="user_payment_qr.php?bill=<?php echo $billId; ?>&method=momo">MoMo</a>
            <a class="<?php echo $method === 'vnpay' ? 'active' : ''; ?>" href="user_payment_qr.php?bill=<?php echo $billId; ?>&method=vnpay">VNPay</a>
            <a class="<?php echo $method === 'banking' ? 'active' : ''; ?>" href="user_payment_qr.php?bill=<?php echo $billId; ?>&method=banking">Chuyển khoản</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-5 mb-4">
        <div class="payment-qr-card <?php echo htmlspecialchars($method); ?> text-center">
          <div class="payment-qr-card-head d-block text-center">
            <h4>Đơn hàng #<?php echo $billId ?: '---'; ?></h4>
            <p class="mb-2">Số tiền cần thanh toán</p>
            <div class="payment-price d-inline-block"><?php echo number_format($totalAmount,0,',','.'); ?> VNĐ</div>
          </div>
          <div class="payment-qr-preview">
            <img src="<?php echo $info['image']; ?>" alt="QR <?php echo $info['name']; ?>">
          </div>
          <div class="payment-qr-note text-left">
            <h6>Hướng dẫn nhanh</h6>
            <ul>
              <li>Mở ứng dụng <?php echo $info['name']; ?> hoặc app ngân hàng.</li>
              <li>Quét mã QR và nhập đúng số tiền hiển thị ở trên.</li>
              <li>Nội dung chuyển khoản: <strong>DH<?php echo $billId; ?></strong>.</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-5 mb-4">
        <div class="payment-summary-card">
          <h5>Thông tin đơn hàng</h5>
          <?php if ($order) { ?>
            <p class="mb-2"><strong>Người nhận:</strong> <?php echo htmlspecialchars($order['ten_nguoi_nhan'] ?? ''); ?></p>
            <p class="mb-2"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['so_dien_thoai_nhan'] ?? ''); ?></p>
            <p class="mb-2"><strong>Địa chỉ nhận:</strong> <?php echo htmlspecialchars($order['dia_chi_nhan_hang']); ?></p>
            <p class="mb-2"><strong>Số tiền cần thanh toán:</strong> <?php echo number_format($totalAmount,0,',','.'); ?> VNĐ</p>
            <p class="mb-3"><strong>Phương thức:</strong> <?php echo htmlspecialchars($info['name']); ?></p>
            <div class="payment-summary-list">
              <?php foreach (($orderItems ?: []) as $item) { ?>
                <div class="payment-summary-item">
                  <div>
                    <strong><?php echo htmlspecialchars($item['ten_san_pham']); ?></strong>
                    <span>x<?php echo (int)$item['so_luong']; ?></span>
                  </div>
                  <span><?php echo number_format($item['so_luong'] * $item['don_gia'],0,',','.'); ?> VNĐ</span>
                </div>
              <?php } ?>
            </div>
            <div class="payment-summary-total"><span>Tổng thanh toán</span><strong><?php echo number_format($totalAmount,0,',','.'); ?> VNĐ</strong></div>
          <?php } else { ?>
            <p>Không tìm thấy đơn hàng phù hợp. Bạn hãy quay lại giỏ hàng để tạo đơn mới.</p>
          <?php } ?>
          <div class="payment-summary-actions">
            <a href="user_cart.php" class="btn btn-outline-primary">Quay lại giỏ hàng</a>
            <a href="user_info.php" class="btn btn-primary">Theo dõi đơn hàng</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
