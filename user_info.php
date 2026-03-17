<?php
include_once('config_user.php');
session_start();

if(!isset($_SESSION["isUserLoggedIn"]) || $_SESSION["isUserLoggedIn"] !== true){
    header("location:user_login.php");
    exit();
}

$currentUserId = (int)($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0);
if($currentUserId <= 0){
    header("location:user_login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $func = $_POST['func'] ?? '';

    if($func == "-1"){
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $orderRows = DP::run_query(
            "select h.id, h.user_id, h.dia_chi_nhan_hang, coalesce(h.ten_nguoi_nhan, u.name) as ten_nguoi_nhan,
                    coalesce(h.so_dien_thoai_nhan, u.phone) as so_dien_thoai_nhan,
                    coalesce(h.phuong_thuc_thanh_toan,'cod') as phuong_thuc_thanh_toan,
                    coalesce(h.ghi_chu,'') as ghi_chu,
                    coalesce(h.trang_thai_don_hang,'pending_confirm') as trang_thai_don_hang,
                    h.tinh_trang_thanh_toan, h.ngay_tao,
                    u.name as ten_nguoi_dat, u.email, u.phone as phone, u.address
             from hoadons h
             left join users u on u.id = h.user_id
             where h.id = ? and h.user_id = ? limit 1",
            [$id, $currentUserId],2
        );
        if(!is_array($orderRows) || count($orderRows) === 0){
            echo json_encode(array('statusCode'=>404,'message'=>'Không tìm thấy đơn hàng.'));
            exit();
        }
        $chi_tiet_hoa_dons = DP::run_query(
            "select s.ten_san_pham as name, s.hinh_anh as image, c.so_luong as count, c.don_gia as price 
             from chitiethoadons c 
             join sanphams s on c.san_pham_id = s.id 
             join hoadons h on h.id = c.hoa_don_id 
             where c.hoa_don_id = ? and h.user_id = ?",
            [$id, $currentUserId],2
        );
        $items = is_array($chi_tiet_hoa_dons) ? $chi_tiet_hoa_dons : array();
        $total = 0;
        foreach($items as $it){
            $total += ((int)$it['count'] * (int)$it['price']);
        }
        echo json_encode(array(
            'statusCode'=>200,
            'order'=>$orderRows[0],
            'items'=>$items,
            'total'=>$total
        ));
        exit();
    }

    if($func == "1" || $func == "0"){
        $conf = DP::run_query("select password from users where id = ?",[$currentUserId],2);
        if(!is_array($conf) || !count($conf)){
            echo json_encode(array("statusCode"=>201));
            exit();
        }

        if($func == "1") {
            $auth = -1;
            $pass = trim($_POST['pass'] ?? '');
            if(!password_verify($pass, $conf[0]['password'])){
                echo json_encode(array("authenticate"=>$auth));
                exit();
            }
            $auth = 1;
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $birth = trim($_POST['birth'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $name_err = $email_err = $phone_err = $birth_err = $address_err = $image_err = '';

            if($name === '') $name_err = 'Vui lòng không để trống tên.';
            if($email === '') $email_err = 'Vui lòng không để trống email.';
            if($phone === '') $phone_err = 'Vui lòng không để trống số điện thoại.';
            if($birth === '') $birth_err = 'Vui lòng không để trống ngày sinh.';
            if($address === '') $address_err = 'Vui lòng không để trống địa chỉ.';

            $img_user = trim($_POST['img_user'] ?? 'image.jpg');
            $valid_extension = array('jpeg','jpg','png','JPG','PNG','JPEG');
            if(isset($_FILES['img_user_file']) && ($_FILES['img_user_file']['error'] ?? 4) === 0){
                $code = md5(mt_rand(10,1000));
                $size = (int)$_FILES['img_user_file']['size'];
                $ext = strtolower(pathinfo($_FILES['img_user_file']['name'], PATHINFO_EXTENSION));
                if($size > 2097152){
                    $image_err = 'Kích thước tập tin ảnh phải nhỏ hơn hoặc bằng 2mb.';
                } elseif(!in_array($ext, $valid_extension)) {
                    $image_err = 'Đuôi tệp không hợp lệ.';
                } else {
                    $old_image = DP::run_query("select photo from users where id = ?",[$currentUserId],2);
                    if(is_array($old_image) && count($old_image) > 0 && $old_image[0]['photo'] !== 'image.jpg'){
                        $oldPath = 'img/img-user/info/'.$old_image[0]['photo'];
                        if(file_exists($oldPath)) @unlink($oldPath);
                    }
                    if(move_uploaded_file($_FILES['img_user_file']['tmp_name'], 'img/img-user/info/' . $code.'.'.$ext)){
                        $img_user = $code.'.'.$ext;
                    }
                }
            }

            if($name_err || $email_err || $phone_err || $birth_err || $address_err || $image_err){
                echo json_encode(array(
                    "statusCode"=>202,
                    "name_err"=>$name_err,
                    "phone_err"=>$phone_err,
                    "address_err"=>$address_err,
                    "birth_err"=>$birth_err,
                    "email_err"=>$email_err,
                    "image_err"=>$image_err,
                ));
                exit();
            }

            $update = DP::run_query("Update users set name = ?, email = ?, birth = ?, phone = ?, address = ?, photo = ? where id = ?",[$name,$email,$birth,$phone,$address,$img_user,$currentUserId],1);
            if($update){
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_address'] = $address;
                $_SESSION['user_photo'] = $img_user;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['address'] = $address;
                $_SESSION['photo'] = $img_user;
                echo json_encode(array("statusCode"=>200,"authenticate"=>$auth));
                exit();
            }
            echo json_encode(array("statusCode"=>201));
            exit();
        }

        if($func == "0") {
            $auth = -1;
            $old_pass = trim($_POST['old_pass'] ?? '');
            $new_pass = trim($_POST['new_pass'] ?? '');
            $confirm_new_pass = trim($_POST['confirm_new_pass'] ?? '');
            $old_pass_err = $new_pass_err = $confirm_new_pass_err = '';
            if($old_pass === '') $old_pass_err = 'Vui lòng không để trống mật khẩu cũ';
            if($new_pass === '') $new_pass_err = 'Vui lòng không để trống mật khẩu mới';
            elseif(strlen($new_pass) < 6) $new_pass_err = 'Mật khẩu bạn cập nhật phải có 6 ký tự trở lên';
            if($confirm_new_pass === '') $confirm_new_pass_err = 'Vui lòng không để trống ô xác nhận mật khẩu.';
            elseif($confirm_new_pass !== $new_pass) $confirm_new_pass_err = 'Bạn xác nhận mật khẩu không khớp với mật khẩu bạn nhập.';

            if($old_pass_err || $new_pass_err || $confirm_new_pass_err){
                echo json_encode(array(
                    "statusCode"=>202,
                    "old_pass_err"=>$old_pass_err,
                    "new_pass_err"=>$new_pass_err,
                    "confirm_new_pass_err"=>$confirm_new_pass_err,
                ));
                exit();
            }
            if(!password_verify($old_pass, $conf[0]['password'])){
                echo json_encode(array("authenticate"=>$auth));
                exit();
            }
            $auth = 1;
            $new_pass_hash = password_hash($new_pass,PASSWORD_DEFAULT);
            $update = DP::run_query("update users set password = ? where id = ?",[$new_pass_hash,$currentUserId],1);
            if($update) {
                echo json_encode(array("statusCode"=>200,"authenticate"=>$auth));
                exit();
            }
            echo json_encode(array("statusCode"=>201));
            exit();
        }
    }

    echo json_encode(array("error"=>"Yêu cầu không hợp lệ."));
    exit();
}

$_isUserProfilePage = true;
include_once($level_config_layout.'layout.php');
?>
