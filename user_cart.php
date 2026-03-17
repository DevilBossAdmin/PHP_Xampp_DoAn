<?php
    include_once('config_user.php');
    $_isUserCartPage = true;
    $_enableChatAiBox = true;

    session_start();

    if(!isset($_SESSION["isUserLoggedIn"]) || $_SESSION["isUserLoggedIn"] !== true){
        header("location:user_login.php");
        exit();
    }

    if(!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])){
        $_SESSION["cart"] = array();
    }

    $thao_tac ="";
    $count = $position = 0;
    $thao_tac_err = $count_err = $position_err ="";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST["bill"]) || $_POST["bill"] !== "1") {
            $thao_tac = isset($_POST["thao_tac"]) ? trim($_POST["thao_tac"]) : "";
            $count = isset($_POST["count"]) ? (int)trim($_POST["count"]) : 0;
            $position = isset($_POST["position"]) ? (int)$_POST["position"] : -1;

            if($thao_tac === ""){
                $thao_tac_err = "Vui lòng không để trống thao tác";
            }
            if($count <= 0){
                $count_err = "Số lượng phải lớn hơn 0";
            }
            if($position < 0 || !isset($_SESSION["cart"][$position])){
                $position_err = "Sản phẩm trong giỏ hàng không hợp lệ.";
            }

            if(empty($thao_tac_err) && empty($position_err) && empty($count_err)){
                if($thao_tac == "Sửa") {
                    $_SESSION["cart"][$position]["count"] = $count;
                    $_SESSION["cart"][$position]["money"] = $_SESSION["cart"][$position]["count"] * $_SESSION["cart"][$position]["price"];
                    $money = $_SESSION["cart"][$position]["money"];
                    echo json_encode(array(
                        "statusCode"=>200,
                        "position"=>$position,
                        "count"=>$count,
                        "money"=>$money,
                    ));
                } elseif($thao_tac == "Xoá") {
                    array_splice($_SESSION["cart"],$position,1);
                    echo json_encode(array(
                        "statusCode"=>200,
                        "position"=>$position,
                        "count"=>$count,
                    ));
                } else {
                    echo json_encode(array("statusCode"=>400,"message"=>"Thao tác không hợp lệ."));
                }
                exit();
            }
            echo json_encode(array(
                "statusCode"=>422,
                "thao_tac_err"=>$thao_tac_err,
                "count_err"=>$count_err,
                "position_err"=>$position_err,
            ));
            exit();
        } else {
            if(!isset($_SESSION["cart"]) || $_SESSION["cart"] === array()){
                $_SESSION['cart_error'] = 'Giỏ hàng đang trống, không thể tạo đơn hàng.';
                header("location:user_cart.php");
                exit();
            }

            $dia_chi_nhan_hang = trim($_POST["dia_chi_nhan_hang"] ?? '');
            $ten_nguoi_nhan = trim($_POST["ten_nguoi_nhan"] ?? '');
            $so_dien_thoai_nhan = trim($_POST["so_dien_thoai_nhan"] ?? '');
            $phuong_thuc_thanh_toan = trim($_POST["phuong_thuc_thanh_toan"] ?? 'cod');
            $ghi_chu = trim($_POST["ghi_chu"] ?? '');
            $trang_thai_don_hang = 'pending_confirm';
            $allowed_methods = array('cod','momo','vnpay','banking');
            if(!in_array($phuong_thuc_thanh_toan,$allowed_methods)) {
                $phuong_thuc_thanh_toan = 'cod';
            }

            if($ten_nguoi_nhan === '' || $so_dien_thoai_nhan === '' || $dia_chi_nhan_hang === ''){
                $_SESSION['cart_error'] = 'Vui lòng nhập đầy đủ tên người nhận, số điện thoại và địa chỉ nhận hàng.';
                header("location:user_cart.php");
                exit();
            }

            $currentUserId = (int)($_SESSION["user_id"] ?? $_SESSION["id"] ?? 0);
            if($currentUserId <= 0){
                header("location:user_login.php");
                exit();
            }

            $totalAmount = 0;
            foreach($_SESSION['cart'] as $cart) {
                $totalAmount += ((int)$cart['count'] * (int)$cart['price']);
            }

            $insert_bill = DP::run_query(
                "insert into hoadons(user_id,dia_chi_nhan_hang,ten_nguoi_nhan,so_dien_thoai_nhan,tinh_trang_thanh_toan,phuong_thuc_thanh_toan,ghi_chu,trang_thai_don_hang,ngay_tao) values(?,?,?,?,?,?,?,?,NOW())",
                [$currentUserId,$dia_chi_nhan_hang,$ten_nguoi_nhan,$so_dien_thoai_nhan,0,$phuong_thuc_thanh_toan,$ghi_chu,$trang_thai_don_hang],
                3
            );
            if($insert_bill) {
                foreach($_SESSION["cart"] as $cart) {
                    DP::run_query("insert into chitiethoadons(hoa_don_id,san_pham_id,so_luong,don_gia) values(?,?,?,?)",[$insert_bill,$cart["id_san_pham"],$cart["count"],$cart["price"]],1);
                    $get_count = DP::run_query("select so_luong from sanphams where id = ? limit 1",[$cart["id_san_pham"]],2);
                    if(is_array($get_count) && count($get_count) > 0) {
                        $new_count = max(0, (int)$get_count[0]["so_luong"] - (int)$cart["count"]);
                        DP::run_query("update sanphams set so_luong = ? where id = ?",[$new_count,$cart["id_san_pham"]],1);
                    }
                }
                $_SESSION['last_bill_id'] = $insert_bill;
                $_SESSION['last_bill_amount'] = $totalAmount;
                $_SESSION["cart"] = array();
                if($phuong_thuc_thanh_toan === 'cod') {
                    header("location:user_order_success.php?bill=".$insert_bill);
                    exit();
                }
                if(in_array($phuong_thuc_thanh_toan, array('momo','vnpay','banking'))) {
                    header("location:user_payment_qr.php?bill=".$insert_bill."&method=".urlencode($phuong_thuc_thanh_toan));
                    exit();
                }
            }

            $_SESSION['cart_error'] = 'Không thể tạo đơn hàng. Vui lòng kiểm tra lại cấu trúc database và thử lại.';
            header("location:user_cart.php");
            exit();
        }
    }

    include_once($level_config_layout.'layout.php');
?>
