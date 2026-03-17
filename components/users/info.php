<?php
$userId = (int)($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0);
$userRows = DP::run_query("select * from users where is_lock = 0 and id = ? and is_delete = 0",[$userId],2);
$user = (is_array($userRows) && count($userRows) > 0) ? $userRows[0] : array(
    'name' => $_SESSION['user_name'] ?? $_SESSION['name'] ?? 'Khách hàng',
    'email' => $_SESSION['user_email'] ?? $_SESSION['email'] ?? '',
    'birth' => '',
    'phone' => '',
    'address' => $_SESSION['user_address'] ?? $_SESSION['address'] ?? '',
    'photo' => $_SESSION['user_photo'] ?? $_SESSION['photo'] ?? 'image.jpg'
);
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$num_row = 5;
$offset = ($page - 1) * $num_row;
$countRows = DP::run_query("select count(*) as count from hoadons where user_id = ?",[$userId],2);
$len = (is_array($countRows) && count($countRows) > 0) ? (int)$countRows[0]['count'] : 0;
$paginate = max(1, (int)ceil($len / $num_row));
$bills = DP::run_query(
    "select h.id, h.tinh_trang_thanh_toan, h.ngay_tao, coalesce(h.trang_thai_don_hang,'pending_confirm') as trang_thai_don_hang,
            coalesce(h.phuong_thuc_thanh_toan,'cod') as phuong_thuc_thanh_toan,
            coalesce(sum(c.so_luong * c.don_gia),0) as tong_tien
     from hoadons h
     left join chitiethoadons c on h.id = c.hoa_don_id
     where h.user_id = ?
     group by h.id, h.tinh_trang_thanh_toan, h.ngay_tao, h.trang_thai_don_hang, h.phuong_thuc_thanh_toan
     order by h.id desc limit ?, ?",
    [$userId, $offset, $num_row],2
);
function userOrderStatusText($status){
    $map = array(
        'pending_confirm' => 'Chờ xác nhận',
        'ready_to_pick' => 'Chờ lấy hàng',
        'shipping' => 'Chờ giao hàng',
        'delivered' => 'Đã giao',
        'returned' => 'Trả hàng'
    );
    return $map[$status] ?? 'Chờ xác nhận';
}
function userOrderStatusClass($status){
    $map = array(
        'pending_confirm' => 'warning',
        'ready_to_pick' => 'info',
        'shipping' => 'primary',
        'delivered' => 'success',
        'returned' => 'danger'
    );
    return $map[$status] ?? 'warning';
}
function userPaymentMethodText($method){
    $map = array('cod'=>'COD','momo'=>'MoMo','vnpay'=>'VNPay','banking'=>'Chuyển khoản');
    return $map[$method] ?? strtoupper($method);
}
?>
<style>
.user-info-shell{background:linear-gradient(135deg,#8c52ff 0%,#b86fe0 100%);padding:42px 0 60px;min-height:calc(100vh - 120px)}
.user-dashboard{background:#fff;border-radius:26px;box-shadow:0 24px 70px rgba(31,41,55,.18);overflow:hidden}
.user-sidebar{background:linear-gradient(180deg,#172033 0%,#1f2e4f 100%);color:#fff;min-height:100%;padding:28px 22px}
.user-avatar{width:96px;height:96px;border-radius:50%;object-fit:cover;border:4px solid rgba(255,255,255,.18);box-shadow:0 14px 28px rgba(0,0,0,.18)}
.user-sidebar .nav-link{color:#cbd5e1;border-radius:14px;margin-bottom:10px;padding:12px 16px;font-weight:600}
.user-sidebar .nav-link.active,.user-sidebar .nav-link:hover{background:#fff;color:#173160}
.user-main{padding:28px 30px 34px;background:#f8fafc}
.user-toolbar{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:20px}
.user-panel{background:#fff;border:1px solid #e8eef6;border-radius:20px;box-shadow:0 10px 30px rgba(15,23,42,.06);padding:22px}
.user-stat-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-bottom:18px}
.user-stat-card{background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 100%);border:1px solid #dbeafe;border-radius:18px;padding:16px}
.user-stat-label{font-size:13px;color:#64748b;margin-bottom:8px}
.user-stat-value{font-size:24px;font-weight:800;color:#0f172a}
.user-bill-table thead th{background:#0f172a;color:#fff;border:none;vertical-align:middle}
.user-bill-table td{vertical-align:middle;border-color:#e2e8f0}
.user-pill{display:inline-flex;align-items:center;border-radius:999px;padding:6px 12px;font-size:12px;font-weight:700}
.user-pill.payment-done{background:#dcfce7;color:#166534}.user-pill.payment-wait{background:#fef3c7;color:#92400e}
.user-empty{padding:28px;text-align:center;border:1px dashed #cbd5e1;border-radius:18px;color:#64748b;background:#fff}
@media (max-width: 991px){.user-stat-grid{grid-template-columns:1fr}.user-main{padding:20px}.user-sidebar{border-radius:26px 26px 0 0}}
</style>
<div class="user-info-shell">
  <div class="container">
    <div class="user-dashboard">
      <div class="row no-gutters">
        <div class="col-lg-3 user-sidebar">
          <div class="text-center mb-4">
            <?php $avatar = (($user['photo'] ?? 'image.jpg') == 'image.jpg') ? _DIR_['IMG']['USERS'].'info/image.jpg' : _DIR_['IMG']['USERS'].'info/'.htmlspecialchars($user['photo']); ?>
            <img class="user-avatar" src="<?php echo $avatar; ?>" alt="avatar">
            <h5 class="font-weight-bold mt-3 mb-1"><?php echo htmlspecialchars($user['name'] ?? ''); ?></h5>
            <div class="text-light-50 small"><?php echo htmlspecialchars($user['email'] ?? ''); ?></div>
            <div class="small mt-2 text-light"><?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật số điện thoại'); ?></div>
          </div>
          <div class="user-panel" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.1);box-shadow:none;color:#fff;margin-bottom:18px;">
            <div class="small text-uppercase mb-2" style="letter-spacing:.08em;opacity:.8">Thông tin nhanh</div>
            <div class="mb-2"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['address'] ?? 'Chưa cập nhật'); ?></div>
            <div><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($user['birth'] ?? 'Chưa cập nhật'); ?></div>
          </div>
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link" id="form-user-tab" data-toggle="pill" href="#form-user" role="tab">Hồ sơ</a>
            <a class="nav-link active" id="list-don-hang-tab" data-toggle="pill" href="#list-don-hang" role="tab">Đơn hàng</a>
            <a class="nav-link" id="form-change-pass-tab" data-toggle="pill" href="#form-change-pass" role="tab">Đổi mật khẩu</a>
            <a class="nav-link" href="user_logout.php">Đăng xuất</a>
          </div>
        </div>
        <div class="col-lg-9 user-main">
          <div class="tab-content">
            <div class="user-toolbar">
              <a href="index.php" class="btn btn-primary px-4">Về trang chủ</a>
              <div class="text-right">
                <div class="font-weight-bold">Tài khoản cá nhân</div>
                <div class="text-muted small">Quản lý hồ sơ và theo dõi chi tiết từng đơn hàng của bạn</div>
              </div>
            </div>

            <form class="tab-pane fade" role="tabpanel" id="form-user" aria-labelledby="form-user-tab" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
              <div class="user-panel">
                <div class="row">
                  <div class="col-md-6 form-group"><label>Tên tài khoản</label><input type="text" name="name" class="form-control" placeholder="Họ tên..." value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"><div id="name_err" class="text-danger"></div></div>
                  <div class="col-md-6 form-group"><label>Email</label><input type="email" name="email" class="form-control" placeholder="Email..." value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"><div id="email_err" class="text-danger"></div></div>
                  <div class="col-md-6 form-group"><label>Ngày sinh</label><input type="text" name="birth" id="ngay_sinh_user" class="form-control" placeholder="Ngày sinh..." value="<?php echo htmlspecialchars($user['birth'] ?? ''); ?>"><div id="birth_err" class="text-danger"></div></div>
                  <div class="col-md-6 form-group"><label>Số điện thoại</label><input type="tel" name="phone" class="form-control" placeholder="Số điện thoại..." value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"><div id="phone_err" class="text-danger"></div></div>
                  <div class="col-12 form-group"><label>Địa chỉ</label><input type="text" name="address" class="form-control" placeholder="Địa chỉ..." value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>"><div id="address_err" class="text-danger"></div></div>
                  <div class="col-md-8 form-group"><label>Ảnh đại diện</label><div class="custom-file"><input id="fileInput" name="img_user" type="file" accept="image/*" class="custom-file-input"><label class="custom-file-label" for="fileInput">Upload ảnh đại diện</label></div><div id="image_err" class="text-danger"></div></div>
                  <div class="col-md-4 form-group text-center"><?php if(($user['photo'] ?? 'image.jpg') == 'image.jpg') { ?><div class="img-fluid" id="where-replace"></div><?php } else { ?><img width="120" height="120" src="img/img-user/info/<?php echo htmlspecialchars($user['photo']); ?>" data-img="<?php echo htmlspecialchars($user['photo']); ?>" class="img-fluid rounded-circle shadow-sm" id="display-image" alt="avatar"/><?php } ?></div>
                  <div class="col-12 form-group"><label>Mật khẩu xác thực</label><input type="password" name="pass" class="form-control" value="" placeholder="Mật khẩu"><div id="pass_auth_err" class="text-danger"></div></div>
                </div>
                <div class="text-right"><button id="btn-cap-nhat-user" class="btn btn-primary profile-button px-4" type="button">Cập nhật hồ sơ</button></div>
              </div>
            </form>

            <div class="tab-pane show active" id="list-don-hang" role="tabpanel" aria-labelledby="list-don-hang-tab">
              <div class="user-stat-grid">
                <div class="user-stat-card"><div class="user-stat-label">Tổng số đơn hàng</div><div class="user-stat-value"><?php echo $len; ?></div></div>
                <div class="user-stat-card"><div class="user-stat-label">Đơn đã thanh toán</div><div class="user-stat-value"><?php echo is_array($bills) ? count(array_filter($bills, fn($b)=>(int)$b['tinh_trang_thanh_toan']===1)) : 0; ?></div></div>
                <div class="user-stat-card"><div class="user-stat-label">Đang xử lý</div><div class="user-stat-value"><?php echo is_array($bills) ? count(array_filter($bills, fn($b)=>$b['trang_thai_don_hang'] !== 'delivered' && $b['trang_thai_don_hang'] !== 'returned')) : 0; ?></div></div>
              </div>
              <div class="user-panel">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                  <div>
                    <h5 class="mb-1">Đơn hàng của bạn</h5>
                    <div class="text-muted small">Xem phương thức thanh toán, trạng thái đơn và mở chi tiết hóa đơn với đầy đủ thông tin người đặt.</div>
                  </div>
                </div>
                <?php if(is_array($bills) && count($bills) > 0) { ?>
                <div class="table-responsive">
                  <table class="table user-bill-table mb-0">
                    <thead>
                      <tr>
                        <th>Mã đơn</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($bills as $bill) { ?>
                      <tr id="hoa-don-<?php echo $bill['id']?>">
                        <td><strong>#<?php echo $bill['id'];?></strong></td>
                        <td><?php echo number_format((int)$bill['tong_tien'],0,',','.');?> VNĐ</td>
                        <td><span class="badge badge-secondary"><?php echo userPaymentMethodText($bill['phuong_thuc_thanh_toan']);?></span></td>
                        <td><?php if((int)$bill['tinh_trang_thanh_toan'] === 1){ ?><span class="user-pill payment-done">Đã thanh toán</span><?php } else { ?><span class="user-pill payment-wait">Chưa thanh toán</span><?php } ?></td>
                        <td><span class="badge badge-<?php echo userOrderStatusClass($bill['trang_thai_don_hang']); ?>"><?php echo userOrderStatusText($bill['trang_thai_don_hang']);?></span></td>
                        <td><?php echo htmlspecialchars($bill['ngay_tao']);?></td>
                        <td>
                          <button data-bill_id="<?php echo $bill['id'];?>" class="btn btn-success btn-sm btn-xem-chi-tiet-hoa-don mb-2">Xem chi tiết</button>
                          <?php if((int)$bill['tinh_trang_thanh_toan'] === 0 && $bill['trang_thai_don_hang'] === 'pending_confirm') { ?>
                            <button data-bill_id="<?php echo $bill['id'];?>" class="btn btn-outline-danger btn-sm btn-order-cancel">Huỷ đơn</button>
                          <?php } ?>
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
                <?php } else { ?>
                  <div class="user-empty">Bạn chưa có đơn hàng nào. Hãy thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm.</div>
                <?php } ?>
                <nav class="mt-3" aria-label="Page navigation example">
                  <ul class="pagination mb-0">
                  <?php for($i = 1 ; $i <= $paginate ; $i++) { ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : '' ;?>"><a class="page-link" href="user_info.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                  <?php } ?>
                  </ul>
                </nav>
              </div>
            </div>

            <form class="tab-pane fade" id="form-change-pass" role="tabpanel" aria-labelledby="form-change-pass-tab" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
              <div class="user-panel">
                <div class="row">
                  <div class="col-12 form-group"><label>Mật khẩu xác thực (mật khẩu cũ)</label><input type="password" name="old_pass" class="form-control" value="" placeholder="Mật khẩu xác thực..."><div id="old_pass_err" class="text-danger"></div></div>
                  <div class="col-md-6 form-group"><label>Mật khẩu mới</label><input type="password" name="new_pass" class="form-control" value="" placeholder="Mật khẩu mới..."><div id="new_pass_err" class="text-danger"></div></div>
                  <div class="col-md-6 form-group"><label>Xác nhận mật khẩu mới</label><input type="password" name="confirm_new_pass" class="form-control" value="" placeholder="Xác nhận mật khẩu..."><div id="confirm_new_pass_err" class="text-danger"></div></div>
                </div>
                <div class="text-right"><button id="btn-doi-mat-khau-user" class="btn btn-primary profile-button px-4" type="button">Đổi mật khẩu</button></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-xl">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg" style="border-radius:22px;overflow:hidden">
      <div class="modal-header bg-dark text-white">
        <h4 class="modal-title">Chi tiết hoá đơn</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="user-order-detail-body"></div>
      <div class="modal-footer justify-content-between"><button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button></div>
    </div>
  </div>
</div>
