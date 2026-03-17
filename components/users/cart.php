<!-- ****** Cart Area Start ****** -->
<div class="cart_area section_padding_100 clearfix">
<<<<<<< HEAD
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cart-table clearfix">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Số tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="list-cart">
                        <?php $cartItems = (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) ? $_SESSION["cart"] : array(); ?>
                        <?php if(count($cartItems) === 0) { ?>
                            <tr><td colspan="5" class="text-center">Giỏ hàng của bạn đang trống.</td></tr>
                        <?php } ?>
                        <?php $i = 0; foreach($cartItems as $cart) { ?>
                            <tr id="cart-id<?php echo $i;?>">
                                <td class="cart_product_img d-flex align-items-center">
                                    <a href="#"><img src=<?php echo 'admin/'._DIR_['IMG']['ADMINS'].'product/'.$cart["image"];?> alt="Product"></a>
                                    <h6><?php echo $cart["name"]?></h6>
                                </td>
                                <td class="price"><span><?php echo $cart["price"]?></span></td>
                                <td class="qty">
                                    <div class="quantity">
                                        <span class="qty-minus" data-target="qty<?php echo $i;?>" role="button"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                        <input type="number" class="qty-text" id="qty<?php echo $i;?>" step="1" min="1" max="99" name="quantity" value="<?php echo $cart["count"]?>">
                                        <span class="qty-plus" data-target="qty<?php echo $i;?>" role="button"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                    </div>
                                </td>
                                <td class="total_price"><span><?php echo $cart["money"]?></span></td>
                                <td>
                                    <button data-id="<?php echo $i;?>" class="sua-pt-gio-hang btn btn-primary">Sửa</button>
                                    <button data-id="<?php echo $i;?>" class="xoa-pt-gio-hang btn btn-danger">Xoá</button>
                                </td>
                            </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>

                <div class="cart-footer d-block mt-30">
                    <div class="row align-items-start">
                        <div class="col-12 col-lg-5 mb-3">
                            <div class="checkout-option-card">
                                <?php if(isset($_SESSION['cart_error']) && $_SESSION['cart_error'] !== '') { ?><div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['cart_error']); unset($_SESSION['cart_error']); ?></div><?php } ?>
                                <h5>Thông tin thanh toán</h5>
                                <p class="mb-2">Chọn phương thức phù hợp trước khi tạo đơn hàng.</p>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                    <input type="hidden" name="bill" value="1">
                                    <div class="form-group">
                                        <label>Người nhận hàng</label>
                                        <input type="text" class="form-control" name="ten_nguoi_nhan" required value="<?php echo isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : ($_SESSION["name"] ?? ""); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Số điện thoại nhận hàng</label>
                                        <input type="text" class="form-control" name="so_dien_thoai_nhan" required value="<?php echo htmlspecialchars($_SESSION["user_phone"] ?? $_SESSION["phone"] ?? ""); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ nhận hàng</label>
                                        <input type="text" class="form-control" name="dia_chi_nhan_hang" required value="<?php echo isset($_SESSION["user_address"]) ? $_SESSION["user_address"] : ($_SESSION["address"] ?? ""); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Phương thức thanh toán</label>
                                        <select class="form-control" name="phuong_thuc_thanh_toan">
                                            <option value="cod">Thanh toán khi nhận hàng</option>
                                            <option value="momo">Ví MoMo</option>
                                            <option value="vnpay">VNPay</option>
                                            <option value="banking">Chuyển khoản ngân hàng</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Ghi chú</label>
                                        <textarea class="form-control" name="ghi_chu" rows="3" placeholder="Ví dụ: giao giờ hành chính, gọi trước khi giao..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">Thanh toán đơn hàng</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-lg-7 mb-3">
                            <div class="d-flex flex-wrap justify-content-lg-end compact-cart-actions">
                                <div class="back-to-shop mr-3 mb-2">
                                    <a href="index.php">Tiếp tục mua sắm</a>
                                </div>
                                <div class="update-checkout mb-2">
                                    <form action="<?php echo htmlspecialchars("user_cart_cancel.php");?>" method="post">
                                        <button class="btn btn-danger" type="submit" id="btn-cart-cancel">Huỷ giỏ hàng</button>
                                    </form>
                                </div>
                            </div>
                            <div class="payment-hint-card mt-3">
                                <h6>Hỗ trợ phương thức mới</h6>
                                <ul class="mb-0 pl-3">
                                    <li>COD: thanh toán sau khi nhận hàng.</li>
                                    <li>MoMo / VNPay: tạo đơn và chuyển sang trang QR để quét mã ngay.</li>
                                    <li>Chuyển khoản: thuận tiện với đơn hàng giá trị cao.</li>
                                </ul>
                                <div class="mt-3 d-flex flex-wrap">
                                    <a class="btn btn-outline-secondary btn-sm mr-2 mb-2" href="user_payment_qr.php?method=momo">Xem QR MoMo</a>
                                    <a class="btn btn-outline-secondary btn-sm mb-2" href="user_payment_qr.php?method=vnpay">Xem QR VNPay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ****** Cart Area End ****** -->
=======
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Số tiền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="list-cart">
                                <?php
                                    $i = 0;
                                    foreach($_SESSION["cart"] as $cart) {
                                ?>
                                    <tr id="cart-id<?php echo $i;?>">
                                        <td class="cart_product_img d-flex align-items-center">
                                            <a href="#"><img src=<?php echo 'admin/'._DIR_['IMG']['ADMINS'].'product/'.$cart["image"];?> alt="Product"></a>
                                            <h6><?php echo $cart["name"]?></h6>
                                        </td>
                                        <td class="price"><span><?php echo $cart["price"]?></span></td>
                                        <td class="qty">
                                            <div class="quantity">
                                                <span class="qty-minus" data-target="qty<?php echo $i;?>" role="button"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                                <input type="number" class="qty-text" id="qty<?php echo $i;?>" step="1" min="1" max="99" name="quantity" value="<?php echo $cart["count"]?>">
                                                <span class="qty-plus" data-target="qty<?php echo $i;?>" role="button"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                            </div>
                                        </td>
                                        <td class="total_price"><span><?php echo $cart["money"]?></span></td>
                                        <td>
                                            <button data-id="<?php echo $i;?>" class="sua-pt-gio-hang btn btn-primary">Sửa</button>  
                                            <button data-id="<?php echo $i;?>" class="xoa-pt-gio-hang btn btn-danger">Xoá</button>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="cart-footer d-flex mt-30">
                            <div class="back-to-shop w-50">
                                <a href="index.php">Tiếp tục mua sắm</a>
                            </div>
                            <div class="update-checkout w-50 text-right">
                                <form action="<?php echo htmlspecialchars("user_cart_cancel.php");?>" method="post">
                                    <button class="btn btn-danger" type="submit" id="btn-cart-cancel">Huỷ giỏ hàng</button>
                                </form> 
                            </div>
                            <div class="update-checkout w-50 text-right">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                <input type="hidden" name="bill" value="1">
                                <button type="submit" class="btn btn-success">Thanh toán đơn hàng</a>
                            </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- ****** Cart Area End ****** -->
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
