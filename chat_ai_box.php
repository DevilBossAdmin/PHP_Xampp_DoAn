<?php
include_once('config_user.php');
header('Content-Type: application/json; charset=utf-8');
$message = trim($_POST['message'] ?? '');
if ($message === '') {
    echo json_encode(['reply' => "Xin chào! Mình có thể hỗ trợ:\n- tìm sản phẩm theo tên hoặc danh mục\n- gợi ý phương thức thanh toán\n- hướng dẫn theo dõi đơn hàng\n- cung cấp thông tin liên hệ quản lý viên"]);
    exit();
}

$normalized = mb_strtolower($message, 'UTF-8');

if (strpos($normalized, 'quản lý') !== false || strpos($normalized, 'manager') !== false || strpos($normalized, 'liên hệ') !== false) {
    echo json_encode(['reply' => "Quản lý viên hỗ trợ tại khu vực kiểm soát bài - Trường Đại học Công Nghệ Đông Á.\nBạn có thể để lại nội dung theo mẫu: 'Cần hỗ trợ đơn hàng #mã_đơn' hoặc 'Cần tư vấn sản phẩm laptop gaming'."]);
    exit();
}

if (strpos($normalized, 'theo dõi') !== false || strpos($normalized, 'đơn hàng') !== false) {
    echo json_encode(['reply' => "Để theo dõi đơn hàng, bạn vào mục Tài khoản > Đơn hàng.\nTại đó có thể xem: mã đơn, tổng tiền, trạng thái thanh toán, trạng thái giao hàng và chi tiết sản phẩm trong đơn."]);
    exit();
}

if (strpos($normalized, 'momo') !== false || strpos($normalized, 'vnpay') !== false || strpos($normalized, 'cod') !== false || strpos($normalized, 'chuyển khoản') !== false || strpos($normalized, 'thanh toán') !== false || strpos($normalized, 'thanh toan') !== false) {
    echo json_encode(['reply' => "Website hiện hỗ trợ 4 phương thức thanh toán:\n1. COD - thanh toán khi nhận hàng\n2. MoMo - tạo đơn rồi quét mã QR\n3. VNPay - tạo đơn rồi quét mã QR\n4. Chuyển khoản - dùng cùng mã QR VNPay để demo đồ án\n\nBạn chỉ cần chọn phương thức tại giỏ hàng rồi bấm 'Thanh toán đơn hàng'."]);
    exit();
}

$query = "SELECT s.ten_san_pham, s.don_gia, l.ten_loai_san_pham FROM sanphams s JOIN loaisanphams l ON s.loai_san_pham_id = l.id WHERE s.da_xoa = 0 AND l.da_xoa = 0 AND (s.ten_san_pham LIKE ? OR l.ten_loai_san_pham LIKE ?) ORDER BY s.id DESC LIMIT 6";
$keyword = '%' . $message . '%';
$products = DP::run_query($query, [$keyword, $keyword], 2);

if (is_array($products) && count($products) > 0) {
    $lines = [];
    foreach ($products as $item) {
        $lines[] = $item['ten_san_pham'] . ' - ' . number_format((int)$item['don_gia'], 0, ',', '.') . ' VNĐ (' . $item['ten_loai_san_pham'] . ')';
    }
    echo json_encode(['reply' => "Mình tìm thấy các sản phẩm phù hợp:\n- " . implode("\n- ", $lines) . "\n\nBạn có thể mở trang chủ, kéo tới phần Danh mục và chọn sản phẩm để xem chi tiết."]);
    exit();
}

$categories = DP::run_query("SELECT ten_loai_san_pham FROM loaisanphams WHERE da_xoa = 0 ORDER BY id ASC LIMIT 12", [], 2);
$categoryNames = [];
if (is_array($categories)) {
    foreach ($categories as $row) {
        $categoryNames[] = $row['ten_loai_san_pham'];
    }
}
$categoryText = count($categoryNames) ? implode(', ', $categoryNames) : 'Điện thoại, Laptop, Gaming Gear';
echo json_encode(['reply' => 'Mình chưa tìm đúng từ khóa này. Bạn có thể thử theo danh mục như: ' . $categoryText . '.']);
