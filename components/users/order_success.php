<?php
$billId = isset($_GET['bill']) ? (int)$_GET['bill'] : 0;
$userId = (int)($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0);
$orderRows = [];
$orderItems = [];
$totalAmount = 0;
if ($billId > 0 && $userId > 0) {
    $orderRows = DP::run_query("select * from hoadons where id = ? and user_id = ? limit 1", [$billId, $userId], 2);
    if (is_array($orderRows) && count($orderRows) > 0) {
        $orderItems = DP::run_query(
            "select s.ten_san_pham, c.so_luong, c.don_gia from chitiethoadons c join sanphams s on c.san_pham_id = s.id where c.hoa_don_id = ?",
            [$billId], 2
        );
        foreach (($orderItems ?: []) as $it) {
            $totalAmount += ((int)$it['so_luong'] * (int)$it['don_gia']);
        }
    }
}
$order = (is_array($orderRows) && count($orderRows) > 0) ? $orderRows[0] : null;
?>
<section class="payment-qr-area section_padding_100_70 clearfix">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="payment-qr-hero mb-4">
          <div>
            <span class="payment-badge">Đặt hàng thành công</span>
            <h2>Cảm ơn quý khách đã đặt đơn hàng</h2>
            <p>Đơn hàng của bạn đã được ghi nhận. Chúng tôi sẽ sớm xác nhận và giao tới đúng địa chỉ đã cung cấp.</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-5 mb-4">
        <div class="payment-summary-card">
          <h5>Thông tin khách hàng</h5>
          <?php if ($order) { ?>
            <p class="mb-2"><strong>Mã đơn hàng:</strong> #<?php echo $billId; ?></p>
            <p class="mb-2"><strong>Người nhận:</strong> <?php echo htmlspecialchars($order['ten_nguoi_nhan'] ?? ''); ?></p>
            <p class="mb-2"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['so_dien_thoai_nhan'] ?? ''); ?></p>
            <p class="mb-2"><strong>Địa chỉ nhận:</strong> <?php echo htmlspecialchars($order['dia_chi_nhan_hang']); ?></p>
            <p class="mb-2"><strong>Phương thức thanh toán:</strong> Thanh toán khi nhận hàng (COD)</p>
            <p class="mb-3"><strong>Trạng thái:</strong> Chờ xác nhận</p>
            <div class="payment-summary-total"><span>Tổng tiền đơn hàng</span><strong><?php echo number_format($totalAmount,0,',','.'); ?> VNĐ</strong></div>
          <?php } else { ?>
            <p>Không tìm thấy thông tin đơn hàng. Bạn hãy quay lại theo dõi đơn hàng để kiểm tra.</p>
          <?php } ?>
        </div>
      </div>
      <div class="col-12 col-lg-5 mb-4">
        <div class="payment-summary-card">
          <h5>Sản phẩm trong đơn</h5>
          <?php if (!empty($orderItems)) { ?>
            <div class="payment-summary-list">
              <?php foreach ($orderItems as $item) { ?>
                <div class="payment-summary-item">
                  <div>
                    <strong><?php echo htmlspecialchars($item['ten_san_pham']); ?></strong>
                    <span>x<?php echo (int)$item['so_luong']; ?></span>
                  </div>
                  <span><?php echo number_format($item['so_luong'] * $item['don_gia'],0,',','.'); ?> VNĐ</span>
                </div>
              <?php } ?>
            </div>
          <?php } else { ?>
            <p>Chưa có chi tiết sản phẩm để hiển thị.</p>
          <?php } ?>
          <div class="payment-summary-actions">
            <a href="index.php" class="btn btn-outline-primary">Tiếp tục mua sắm</a>
            <a href="user_info.php" class="btn btn-primary">Theo dõi đơn hàng</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
