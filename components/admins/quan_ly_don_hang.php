<<<<<<< HEAD
<section class="content">
  <div class="container-fluid" style="padding-left:265px; padding-right:20px;">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title mb-2 mb-md-0">Quản lý đơn hàng</h3>
            <div class="text-muted small">Theo dõi thanh toán, vận chuyển và gửi thông báo Gmail cho khách hàng</div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover mb-0">
                <thead>
                  <tr>
                    <th>Mã hoá đơn</th>
                    <th>Người đặt</th>
                    <th>Người nhận</th>
                    <th>Địa chỉ nhận hàng</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái đơn</th>
                    <th>Ngày tạo</th>
                    <th style="min-width:280px;">Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $page = isset($_GET["page"]) ? max(1, (int)$_GET["page"]) : 1;
                    $num_row = 5;
                    $offset = ($page - 1) * $num_row;

                    $count = DP::run_query("select count(*) as count from hoadons",[],2);
                    $len = (is_array($count) && count($count) > 0) ? (int)$count[0]['count'] : 0;
                    $paginate = max(1, (int)ceil($len / $num_row));
                    $min = $len > 0 ? $offset + 1 : 0;
                    $max = min($offset + $num_row, $len);

                    $query = "SELECT h.id AS id_hoa_don, u.id AS id_nguoi_dung, u.name AS ten_nguoi_dung, ";
                    $query .= "COALESCE(h.ten_nguoi_nhan, u.name) AS ten_nguoi_nhan, ";
                    $query .= "COALESCE(h.so_dien_thoai_nhan, u.phone) AS so_dien_thoai_nhan, ";
                    $query .= "h.dia_chi_nhan_hang, COALESCE(h.phuong_thuc_thanh_toan, 'cod') AS phuong_thuc_thanh_toan, ";
                    $query .= "COALESCE(h.ghi_chu, '') AS ghi_chu, COALESCE(h.trang_thai_don_hang, 'pending_confirm') AS trang_thai_don_hang, ";
                    $query .= "COALESCE(SUM(c.so_luong * c.don_gia),0) AS tong_tien, h.tinh_trang_thanh_toan, h.ngay_tao ";
                    $query .= "FROM hoadons h ";
                    $query .= "LEFT JOIN chitiethoadons c ON c.hoa_don_id = h.id ";
                    $query .= "LEFT JOIN users u ON h.user_id = u.id ";
                    $query .= "GROUP BY h.id, u.id, u.name, h.ten_nguoi_nhan, h.so_dien_thoai_nhan, h.dia_chi_nhan_hang, h.phuong_thuc_thanh_toan, h.ghi_chu, h.trang_thai_don_hang, h.tinh_trang_thanh_toan, h.ngay_tao ";
                    $query .= "ORDER BY h.id DESC LIMIT ?,?";
                    $hoadons = DP::run_query($query,[$offset,$num_row],2);

                    function orderStatusBadge($status) {
                      $map = [
                        'pending_confirm' => ['warning','Chờ xác nhận'],
                        'ready_to_pick' => ['info','Chờ lấy hàng'],
                        'shipping' => ['primary','Chờ giao hàng'],
                        'delivered' => ['success','Đã giao'],
                        'returned' => ['danger','Trả hàng'],
                      ];
                      $item = $map[$status] ?? $map['pending_confirm'];
                      return '<span class="badge badge-' . $item[0] . '">' . $item[1] . '</span>';
                    }

                    if(is_array($hoadons) && count($hoadons) > 0) {
                      foreach($hoadons as $i => $hoadon) {
                  ?>
                  <tr>
                    <td>#<?=$hoadon['id_hoa_don']?></td>
                    <td>
                      <strong><?=htmlspecialchars($hoadon['ten_nguoi_dung'])?></strong><br>
                      <small class="text-muted">ID: <?=$hoadon['id_nguoi_dung']?></small>
                    </td>
                    <td>
                      <strong><?=htmlspecialchars($hoadon['ten_nguoi_nhan'])?></strong><br>
                      <small class="text-muted"><?=htmlspecialchars($hoadon['so_dien_thoai_nhan'])?></small>
                    </td>
                    <td><?=nl2br(htmlspecialchars($hoadon['dia_chi_nhan_hang']))?></td>
                    <td><?=number_format((int)$hoadon['tong_tien'],0,',','.')?> vnđ</td>
                    <td><span class="badge badge-secondary"><?=strtoupper(htmlspecialchars($hoadon['phuong_thuc_thanh_toan']))?></span></td>
                    <td id="status-payment<?=$i?>"><?=((int)$hoadon['tinh_trang_thanh_toan'] === 1) ? '<span class="badge badge-success">Đã thanh toán</span>' : '<span class="badge badge-warning">Chưa thanh toán</span>'?></td>
                    <td id="status-order<?=$i?>"><?=orderStatusBadge($hoadon['trang_thai_don_hang'])?></td>
                    <td><?=htmlspecialchars($hoadon['ngay_tao'])?></td>
                    <td>
                      <div class="d-flex flex-column">
                        <button class="btn btn-dark btn-sm mb-2 btn-xem-chi-tiet-hoa-don" data-bill_id="<?=$hoadon['id_hoa_don']?>">Xem chi tiết hóa đơn</button>
                        <button class="btn btn-info btn-sm mb-2 btn-xem-thong-tin-nguoi-dung" data-user_id="<?=$hoadon['id_nguoi_dung']?>">Xem thông tin người đặt</button>
                        <button class="btn btn-success btn-sm btn-cap-nhat-trang-thai"
                          data-id="<?=$hoadon['id_hoa_don']?>"
                          data-pos="<?=$i?>"
                          data-payment="<?=$hoadon['tinh_trang_thanh_toan']?>"
                          data-order-status="<?=htmlspecialchars($hoadon['trang_thai_don_hang'])?>"
                        >Cập nhật trạng thái</button>
                      </div>
                    </td>
                  </tr>
                  <?php } } else { ?>
                  <tr><td colspan="10" class="text-center">Chưa có đơn hàng nào để hiển thị.</td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-sm-12 col-md-5">
        <div class="dataTables_info">Hiển thị <?php echo $len > 0 ? ($max - $min + 1) : 0;?> dòng (từ dòng <?php echo $min . ' - ' . $max;?>)</div>
      </div>
      <div class="col-sm-12 col-md-7">
        <ul class="pagination justify-content-md-end">
          <?php for($i = 1; $i <= $paginate; $i++) { ?>
          <li class="paginate_button page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
            <a href="admin_don_hang.php?page=<?php echo $i;?>" class="page-link"><?php echo $i;?></a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modal-xl">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thông tin đơn hàng</h4>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body" id="order-modal-body"></div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-update-order">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cập nhật trạng thái đơn hàng</h4>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="update-order-id">
        <input type="hidden" id="update-order-pos">
        <div class="form-group">
          <label>Trạng thái thanh toán</label>
          <select id="update-payment-status" class="form-control">
            <option value="0">Chưa thanh toán</option>
            <option value="1">Đã thanh toán</option>
          </select>
        </div>
        <div class="form-group">
          <label>Trạng thái đơn hàng</label>
          <select id="update-order-status" class="form-control">
            <option value="pending_confirm">Chờ xác nhận</option>
            <option value="ready_to_pick">Chờ lấy hàng</option>
            <option value="shipping">Chờ giao hàng</option>
            <option value="delivered">Đã giao</option>
            <option value="returned">Trả hàng</option>
          </select>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="notify-email" checked>
          <label class="form-check-label" for="notify-email">Gửi thông báo qua Gmail cho khách hàng (nếu đã cấu hình token Gmail API ở biến môi trường)</label>
        </div>
        <div class="alert alert-light small mb-0">Token Gmail không được nhúng sẵn vào source. Hãy tự cấu hình biến môi trường <code>GMAIL_BEARER_TOKEN</code> và <code>GMAIL_FROM_EMAIL</code> trên máy của bạn.</div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-success" id="btn-save-order-status">Lưu cập nhật</button>
      </div>
    </div>
  </div>
</div>
=======
<!-- Main content -->
<section class="content">
      
      <div class="container" style="margin-left:250px;">
        <div class="row" >
          
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Quản lý đơn hàng</h3>
               </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Mã hoá đơn</th>
                    <th>Mã người dùng</th>
                    <th>Địa chỉ nhận hàng</th>
                    <th>Tổng tiền</th>
                    <th>Tình trạng thanh toán</th>
                    <th>Ngày tạo kiện hàng</th>
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody id="list-san-pham">
                  <?php
                     $page = 1;
                     $num_row = 5;
                     $max = 5;
                     $min = 1;
 
                     $count = DP::run_query("select count(*) as 'count' from sanphams",[],2);
                     $len = $count[0]['count'];
                     $paginate = ceil($len / $num_row) + 1;
                     
                     
                     if(isset($_GET["page"])) {
                       $page = (int)$_GET["page"];
                       // xu ly pagination
                       $max = $page * $num_row;
                       $min = $max - ($num_row - 1);
 
                     }

                    $query = "select hoadons.id as 'id_hoa_don', users.id as 'id_nguoi_dung', dia_chi_nhan_hang,sum(chitiethoadons.so_luong * chitiethoadons.don_gia) as tong_tien ,tinh_trang_thanh_toan, ngay_tao";
                    $query.= " from hoadons,chitiethoadons,users";
                    $query.= " where chitiethoadons.hoa_don_id = hoadons.id and hoadons.user_id = users.id";
                    $query.= " group by chitiethoadons.hoa_don_id limit ?,?";
                    $hoadons = DP::run_query($query,[$min - 1,$num_row],2);
                    $i = 0;
                    foreach($hoadons as $hoadon) {
                  ?>
                    <tr>
                        <td><?=$hoadon['id_hoa_don']?></td>
                        <td><?=$hoadon['id_nguoi_dung']?></td>
                        <td><?=$hoadon['dia_chi_nhan_hang']?></td>
                        <td><?=number_format($hoadon['tong_tien'],0,',','.')?> vnđ</td>
                        <?php
                          if($hoadon['tinh_trang_thanh_toan'] == 1) {
                        ?>
                            <td id="status-payment<?php echo $i;?>">Đã thanh toán</td>
                        <?php 
                           } else {
                        ?>
                            <td id="status-payment<?php echo $i;?>">Chưa thanh toán</td>
                        <?php 
                          }
                        ?>
                        <td><?=$hoadon['ngay_tao']?></td>
                        <td>
                            <button class="btn btn-secondary btn-xem-chi-tiet-hoa-don"
                            data-bill_id="<?=$hoadon["id_hoa_don"];?>"
                            data-sum="<?=$hoadon["tong_tien"];?>"
                            data-pay-status="<?=$hoadon["tinh_trang_thanh_toan"];?>"
                            >
                            Xem chi tiết hoá đơn
                            </button><br>
                            <button class="btn btn-info btn-xem-thong-tin-nguoi-dung" data-user_id="<?=$hoadon["id_nguoi_dung"];?>" data-id="<?=$hoadon["id_hoa_don"];?>">
                            Xem thông tin người dùng
                            </button><br>
                            <button class="btn btn-success btn-cap-nhat-thanh-toan" data-pos="<?php echo $i;?>" data-user_id="<?=$hoadon["id_nguoi_dung"];?>" data-id="<?=$hoadon["id_hoa_don"];?>">
                            Cập nhật đã thanh toán
                            </button>
                      </td>
                    </tr>
                  <?php
                      $i++;
                    }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                Hiển thị <?php echo $num_row;?> dòng (từ dòng <?php echo $min." - ".$max;?>)
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                    <ul class="pagination">
                        <?php
                          for($i = 1 ; $i < $paginate ; $i++) {
                        ?>
                            <li class="paginate_button page-item 
                              <?php
                                if($i == $page) {
                                  echo 'active';
                                }
                              ?>
                            ">
                                <a href="admin_don_hang.php?page=<?php echo $i;?>" aria-controls="example1" data-dt-idx="<?php echo $i;?>" tabindex="0" class="page-link"><?php echo $i;?></a>
                            </li>
                        <?php
                          }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- /.modal -->
<div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Extra Large Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                  <thead id="t_head">
                  </thead>
                  <tbody id="t_body">
                  </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
