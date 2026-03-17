<?php
<<<<<<< HEAD
include_once "config_user.php";
session_start();
if(!isset($_SESSION['isUserLoggedIn']) || $_SESSION['isUserLoggedIn'] !== true){
    echo json_encode(array('statusCode'=>401,'msg'=>'Bạn chưa đăng nhập.'));
    exit();
}
$currentUserId = (int)($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0);
$hoa_don_id = isset($_POST['hoa_don_id']) ? (int)$_POST['hoa_don_id'] : -1;
if($_SERVER["REQUEST_METHOD"] == "POST" && $hoa_don_id > 0) {
    $orderRows = DP::run_query("select id from hoadons where id = ? and user_id = ? and tinh_trang_thanh_toan = 0 and coalesce(trang_thai_don_hang,'pending_confirm') = 'pending_confirm' limit 1",[$hoa_don_id,$currentUserId],2);
    if(!is_array($orderRows) || !count($orderRows)){
        echo json_encode(array('statusCode'=>404,'msg'=>'Không tìm thấy đơn hàng phù hợp để hủy.'));
        exit();
    }
    $deleted = DP::run_query("delete from hoadons where id = ? and user_id = ?",[$hoa_don_id,$currentUserId],1);
    if($deleted){
        echo json_encode(array('statusCode'=>200,'msg'=>'Bạn đã huỷ đơn hàng thành công'));
    } else {
        echo json_encode(array('statusCode'=>202,'msg'=>'Đã có lỗi xảy ra, vui lòng reload lại trang.'));
    }
    exit();
}
echo json_encode(array('statusCode'=>201,'msg'=>'Dữ liệu id hoá đơn không hợp lệ.'));
?>
=======
    include_once "config_user.php";
    $hoa_don_id = -1;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["hoa_don_id"]) && is_numeric($_POST["hoa_don_id"])) {
            $hoa_don_id = (int)$_POST["hoa_don_id"];
            if($hoa_don_id > 0) {
                $xoa_cthd = DP::run_query("Delete from chitiethoadons where hoa_don_id = ?",[$hoa_don_id],1);
                if($xoa_cthd) {
                    $xoa_hd = DP::run_query("Delete from hoadons where id = ?",[$hoa_don_id],1);
                    if($xoa_hd){
                        echo json_encode(array(
                            "statusCode"=>200,
                            "msg"=>"Bạn đã huỷ đơn hàng thành công"
                        ));
                        exit();
                    } else {
                        echo json_encode(array(
                            "statusCode"=>202,
                            "msg"=>"Đã có lỗi xảy ra, vui lòng reload lại trang.",
                        ));
                        exit();
                    }
                } else {
                    echo json_encode(array(
                        "statusCode"=>202,
                        "msg"=>"Đã có lỗi xảy ra, vui lòng reload lại trang.",
                    ));
                    exit();
                }
            } else {
                echo json_encode(array(
                    "statusCode"=>201,
                    "msg"=>"Dữ liệu id hoá đơn không hợp lệ.",
                ));
                exit();
            }
        } else {
            echo json_encode(array(
                "statusCode"=>201,
                "msg"=>"Dữ liệu id hoá đơn không hợp lệ.",
            ));
            exit();
        }
    }
?>
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
