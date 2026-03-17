<?php
<<<<<<< HEAD
include_once('config_admin.php');
require_once('admin_auth.php');
require_once($level_config_layout . 'lib/GmailNotifier.php');
require_admin_login();

function vn_order_status_label($status) {
    $map = array(
        'pending_confirm' => 'Chờ xác nhận',
        'ready_to_pick' => 'Chờ lấy hàng',
        'shipping' => 'Chờ giao hàng',
        'delivered' => 'Đã giao',
        'returned' => 'Trả hàng'
    );
    return $map[$status] ?? 'Chờ xác nhận';
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["func"])) {
    header('Content-Type: application/json; charset=utf-8');
    $func = trim((string)$_POST["func"]);
    $id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

    if($id <= 0) {
        echo json_encode(array("statusCode"=>422,"message"=>"ID không hợp lệ."));
        exit();
    }

    if($func === "detail") {
        $orders = DP::run_query(
            "SELECT h.id, h.user_id, h.dia_chi_nhan_hang, h.tinh_trang_thanh_toan, h.phuong_thuc_thanh_toan, h.ghi_chu, h.ngay_tao,
                    COALESCE(h.trang_thai_don_hang,'pending_confirm') AS trang_thai_don_hang,
                    COALESCE(h.ten_nguoi_nhan, u.name) AS ten_nguoi_nhan,
                    COALESCE(h.so_dien_thoai_nhan, u.phone) AS so_dien_thoai_nhan,
                    u.name AS ten_nguoi_dat, u.email, u.phone, u.address, u.birth, u.photo
             FROM hoadons h
             LEFT JOIN users u ON u.id = h.user_id
             WHERE h.id = ? LIMIT 1",
            array($id), 2
        );
        if(!is_array($orders) || !count($orders)) {
            echo json_encode(array('statusCode'=>404,'message'=>'Không tìm thấy đơn hàng.'));
            exit();
        }
        $order = $orders[0];
        $items = DP::run_query(
            "SELECT sp.ten_san_pham AS name, sp.hinh_anh AS image, cthd.so_luong AS count, cthd.don_gia AS price
             FROM chitiethoadons cthd
             JOIN sanphams sp ON sp.id = cthd.san_pham_id
             WHERE cthd.hoa_don_id = ? ORDER BY sp.id DESC",
            array($id), 2
        );
        $total = 0;
        foreach(($items ?: array()) as $item) {
            $total += ((int)$item['count'] * (int)$item['price']);
        }
        echo json_encode(array(
            'statusCode' => 200,
            'order' => $order,
            'items' => is_array($items) ? $items : array(),
            'total' => $total,
            'order_status_label' => vn_order_status_label($order['trang_thai_don_hang'])
        ));
        exit();
    }

    if($func === "user") {
        $rows = DP::run_query("select name,email,birth,phone,address,photo from users where id = ? limit 1",array($id),2);
        if(is_array($rows) && count($rows)) {
            echo json_encode(array('statusCode'=>200,'user'=>$rows[0]));
        } else {
            echo json_encode(array('statusCode'=>404,'message'=>'Không tìm thấy người dùng.'));
        }
        exit();
    }

    if($func === "update_status") {
        $payment_status = isset($_POST['payment_status']) ? (int)$_POST['payment_status'] : 0;
        $order_status = trim((string)($_POST['order_status'] ?? 'pending_confirm'));
        $notify_email = isset($_POST['notify_email']) && $_POST['notify_email'] === '1';
        $allowed_status = array('pending_confirm','ready_to_pick','shipping','delivered','returned');
        if(!in_array($order_status, $allowed_status, true)) {
            $order_status = 'pending_confirm';
        }

        $updated = DP::run_query(
            "UPDATE hoadons SET tinh_trang_thanh_toan = ?, trang_thai_don_hang = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?",
            array($payment_status, $order_status, $id), 1
        );

        if(!$updated) {
            echo json_encode(array('statusCode'=>500,'message'=>'Không thể cập nhật trạng thái.'));
            exit();
        }

        $rows = DP::run_query(
            "SELECT h.id, h.ngay_tao, h.dia_chi_nhan_hang, h.phuong_thuc_thanh_toan, COALESCE(h.ten_nguoi_nhan,u.name) AS ten_nguoi_nhan,
                    COALESCE(h.so_dien_thoai_nhan,u.phone) AS so_dien_thoai_nhan, u.name, u.email
             FROM hoadons h LEFT JOIN users u ON u.id = h.user_id WHERE h.id = ? LIMIT 1",
            array($id), 2
        );
        $mailResult = array('ok'=>false,'message'=>'Không gửi email');
        if($notify_email && is_array($rows) && count($rows) && !empty($rows[0]['email'])) {
            $order = $rows[0];
            $subject = 'Cập nhật đơn hàng #' . $order['id'];
            $htmlBody = '<h3>Xin chào ' . htmlspecialchars($order['name']) . ',</h3>'
                . '<p>Đơn hàng <strong>#' . $order['id'] . '</strong> của bạn vừa được cập nhật.</p>'
                . '<ul>'
                . '<li>Trạng thái đơn hàng: <strong>' . vn_order_status_label($order_status) . '</strong></li>'
                . '<li>Thanh toán: <strong>' . ($payment_status ? 'Đã thanh toán' : 'Chưa thanh toán') . '</strong></li>'
                . '<li>Phương thức: <strong>' . strtoupper((string)$order['phuong_thuc_thanh_toan']) . '</strong></li>'
                . '<li>Người nhận: <strong>' . htmlspecialchars((string)$order['ten_nguoi_nhan']) . ' - ' . htmlspecialchars((string)$order['so_dien_thoai_nhan']) . '</strong></li>'
                . '<li>Địa chỉ giao hàng: <strong>' . htmlspecialchars((string)$order['dia_chi_nhan_hang']) . '</strong></li>'
                . '</ul>'
                . '<p>Kiểm soát bài thực hiện tại Trường Đại học Công Nghệ Đông Á.</p>';
            $mailResult = GmailNotifier::sendOrderUpdate($order['email'], $order['name'], $subject, $htmlBody);
        }

        echo json_encode(array(
            'statusCode' => 200,
            'payment_text' => $payment_status ? 'Đã thanh toán' : 'Chưa thanh toán',
            'order_status_text' => vn_order_status_label($order_status),
            'mail' => $mailResult,
            'message' => 'Cập nhật trạng thái đơn hàng thành công.'
        ));
        exit();
    }

    echo json_encode(array('statusCode'=>400,'message'=>'Yêu cầu không hợp lệ.'));
    exit();
}
$_isBillPage = true;
include_once($level_config_layout.'layout.php');
?>
=======
     include_once('config_admin.php');

     session_start();
     if(!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true){
        header("location:admin_login.php");
        exit();
     }
     $id = "";
     $id_err = "";
     if($_SERVER["REQUEST_METHOD"] == "POST") {
      if($_POST["func"] == "1") {
         if(empty(trim($_POST["id"]))){
            $id_err = "Error! Not empty id.";
         } else {
            $id = (int)$_POST["id"];
         }

         if(empty($id_err)) {
            $cap_nhat_tinh_trang_thanh_toan = DP::run_query("update hoadons set tinh_trang_thanh_toan = 1 where id = ?",[$id],1);
            if($cap_nhat_tinh_trang_thanh_toan) {
               echo json_encode(array("statusCode"=>200));
               exit();
            }
         }
         $id_err = "";
      } elseif($_POST["func"] == "-1") {
         if(empty(trim($_POST["id"]))){
            $id_err = "Error! Not empty id.";
         } else {
            $id = (int)$_POST["id"];
         }

         if(empty($id_err)) {
            $chi_tiet_hoa_dons = DP::run_query("select ten_san_pham as 'name', hinh_anh as 'image', chitiethoadons.so_luong as 'count',chitiethoadons.don_gia as 'price' from chitiethoadons,sanphams where chitiethoadons.hoa_don_id = ? and chitiethoadons.san_pham_id = sanphams.id",[(int)$id],2);
            $arr = array();
            if(count($chi_tiet_hoa_dons)) {
               foreach($chi_tiet_hoa_dons as $cthd) {
                  array_push($arr,
                     [
                        "name"=>$cthd["name"],
                        "count"=>$cthd["count"],
                        "price"=>$cthd["price"],
                        "image"=>$cthd["image"],
                     ]
                  );
               }
               echo json_encode($arr);
               exit();
            }
         }
         $id_err = "";
      } elseif($_POST["func"] == "0") {
         if(empty(trim($_POST["id"]))){
            $id_err = "Error! Not empty id.";
         } else {
            $id = (int)$_POST["id"];
         }

         if(empty($id_err)) {
            $thong_tin_nguoi_dung = DP::run_query("select name,email,birth,phone,address,photo from users where id = ?",[$id],2);
            if(count($thong_tin_nguoi_dung)) {
               echo json_encode(array(
                  "statusCode"=>200,
                  "name"=>$thong_tin_nguoi_dung[0]["name"],
                  "email"=>$thong_tin_nguoi_dung[0]["email"],
                  "birth"=>$thong_tin_nguoi_dung[0]["birth"],
                  "phone"=>$thong_tin_nguoi_dung[0]["phone"],
                  "address"=>$thong_tin_nguoi_dung[0]["address"],
                  "image"=>$thong_tin_nguoi_dung[0]["photo"],
               ));
               exit();
            }
         }
         $id_err = "";
      } else {
         $id_err = "";
      }
     }
     $_isBillPage = true;
     include_once($level_config_layout.'layout.php');
?>
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
