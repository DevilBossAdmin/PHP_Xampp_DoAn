$(document).ready(function(){
    function numberFormatVn(value){
        const num = parseInt(value || 0, 10);
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' vnđ';
    }
    function orderBadge(status){
        const map = {
            pending_confirm: ['warning','Chờ xác nhận'],
            ready_to_pick: ['info','Chờ lấy hàng'],
            shipping: ['primary','Chờ giao hàng'],
            delivered: ['success','Đã giao'],
            returned: ['danger','Trả hàng']
        };
        const item = map[status] || map.pending_confirm;
        return `<span class="badge badge-${item[0]}">${item[1]}</span>`;
    }

    if ($("#ngay_sinh_admin").length) {
        $("#ngay_sinh_admin").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    }

    $(document).on('click','#btn-cap-nhat-admin,#btn-doi-mat-khau-admin',function(){
        $("#old_pass_err,#new_pass_err,#confirm_pass_err,#name_err,#phone_err,#birth_err,#address_err,#email_err,#image_err").text("");
    });

    $(document).on('click','#btn-cap-nhat-admin',function(event){
        event.preventDefault();
        let old_pass = $('input[name=old_pass]').val();
        if(old_pass === ""){
            alert("Vui lòng không để trống mật khẩu xác thực.");
            return;
        }
        var formData = new FormData($('#form-admin')[0]);
        let img = $('#display-image').attr('data-img');
        let file = $('input[name=img_admin_file]')[0].files;
        if(file.length === 0){
            formData.append('img_admin',img);
        } else {
            formData.append('img_admin_file',file[0]);
        }
        $.ajax({
            url: window.location.href,
            type: "POST",
            cache: false,
            dataType: "json",
            contentType: false,
            processData: false,
            data: formData,
            success:function(res_json){
                if(res_json.statusCode == 200){
                    alert("Cập nhật dữ liệu thành công.");
                    window.location.reload();
                } else if(res_json.statusCode == 202) {
                    $("#name_err").text(res_json.name_err || '');
                    $("#old_pass_err").text(res_json.old_pass_err || '');
                    $("#phone_err").text(res_json.phone_err || '');
                    $("#birth_err").text(res_json.birth_err || '');
                    $("#address_err").text(res_json.address_err || '');
                    $("#email_err").text(res_json.email_err || '');
                    $("#image_err").text(res_json.image_err || '');
                } else {
                    alert(res_json.auth || "Đã xảy ra lỗi, vui lòng thử lại.");
                }
            },
            error: function (data) { console.log('Error:', data); }
        });
    });

    $(document).on('click','#btn-doi-mat-khau-admin',function(event){
        event.preventDefault();
        $.ajax({
            url: "admin_change_pass.php",
            type: "POST",
            dataType: 'json',
            data: {
                old_pass: $('input[name=old_pass]').val(),
                new_pass: $('input[name=new_pass]').val(),
                confirm_new_pass: $('input[name=confirm_new_pass]').val(),
            },
            success:function(res_json){
                if(res_json.statusCode == 200){
                    alert("Cập nhật dữ liệu thành công.");
                } else if(res_json.statusCode == 202) {
                    $("#old_pass_err").text(res_json.old_pass_err || '');
                    $("#new_pass_err").text(res_json.new_pass_err || '');
                    $("#confirm_new_pass_err").text(res_json.confirm_new_pass_err || '');
                } else {
                    alert(res_json.auth || 'Đã có lỗi xảy ra.');
                }
            },
            error: function (data) { console.log('Error:', data); }
        });
    });

    $(document).on('click','.btn-xem-chi-tiet-hoa-don',function(){
        $.post(window.location.href, {func:'detail', id: $(this).data('bill_id')}, function(res){
            if(res.statusCode !== 200){ alert(res.message || 'Không thể tải chi tiết đơn hàng.'); return; }
            let itemsRows = '';
            (res.items || []).forEach(function(item, idx){
                const total = parseInt(item.count,10) * parseInt(item.price,10);
                itemsRows += `<tr>
                    <td>${idx+1}</td>
                    <td>${item.name}</td>
                    <td><img width="80" height="80" style="object-fit:cover" src="../img/img-admin/product/${item.image}"></td>
                    <td>${numberFormatVn(item.price)}</td>
                    <td>${item.count}</td>
                    <td>${numberFormatVn(total)}</td>
                </tr>`;
            });
            const o = res.order;
            const html = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-primary"><div class="card-header"><strong>Thông tin người đặt đơn</strong></div>
                            <div class="card-body">
                                <p><strong>Họ tên:</strong> ${o.ten_nguoi_dat || ''}</p>
                                <p><strong>Email:</strong> ${o.email || ''}</p>
                                <p><strong>Số điện thoại:</strong> ${o.phone || ''}</p>
                                <p><strong>Địa chỉ tài khoản:</strong> ${o.address || ''}</p>
                            </div></div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-success"><div class="card-header"><strong>Thông tin giao hàng</strong></div>
                            <div class="card-body">
                                <p><strong>Người nhận:</strong> ${o.ten_nguoi_nhan || ''}</p>
                                <p><strong>Số điện thoại nhận:</strong> ${o.so_dien_thoai_nhan || ''}</p>
                                <p><strong>Địa chỉ nhận:</strong> ${o.dia_chi_nhan_hang || ''}</p>
                                <p><strong>Phương thức:</strong> ${(o.phuong_thuc_thanh_toan || '').toUpperCase()}</p>
                                <p><strong>Thanh toán:</strong> ${parseInt(o.tinh_trang_thanh_toan,10) === 1 ? 'Đã thanh toán' : 'Chưa thanh toán'}</p>
                                <p><strong>Trạng thái đơn:</strong> ${res.order_status_label}</p>
                                <p><strong>Ghi chú:</strong> ${o.ghi_chu || 'Không có'}</p>
                            </div></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead><tr><th>#</th><th>Tên sản phẩm</th><th>Ảnh</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr></thead>
                        <tbody>${itemsRows || '<tr><td colspan="6" class="text-center">Không có sản phẩm.</td></tr>'}</tbody>
                        <tfoot><tr><th colspan="5" class="text-right">Tổng tiền</th><th>${numberFormatVn(res.total)}</th></tr></tfoot>
                    </table>
                </div>`;
            $('.modal-title').text('Chi tiết đơn hàng #' + o.id);
            $('#order-modal-body').html(html);
            $('#modal-xl').modal('show');
        }, 'json');
    });

    $(document).on('click','.btn-xem-thong-tin-nguoi-dung',function(){
        $.post(window.location.href, {func:'user', id: $(this).data('user_id')}, function(res){
            if(res.statusCode !== 200){ alert(res.message || 'Không tìm thấy người dùng.'); return; }
            const u = res.user;
            const img = !u.photo || u.photo === 'image.jpg' ? '../img/img-user/info/image.jpg' : '../img/img-user/info/' + u.photo;
            const html = `<div class="row align-items-center">
                <div class="col-md-4 text-center"><img src="${img}" class="img-fluid rounded" style="max-height:220px"></div>
                <div class="col-md-8">
                    <p><strong>Họ tên:</strong> ${u.name || ''}</p>
                    <p><strong>Email:</strong> ${u.email || ''}</p>
                    <p><strong>Ngày sinh:</strong> ${u.birth || ''}</p>
                    <p><strong>Số điện thoại:</strong> ${u.phone || ''}</p>
                    <p><strong>Địa chỉ:</strong> ${u.address || ''}</p>
                </div>
            </div>`;
            $('.modal-title').text('Thông tin người đặt đơn');
            $('#order-modal-body').html(html);
            $('#modal-xl').modal('show');
        }, 'json');
    });

    $(document).on('click','.btn-cap-nhat-trang-thai',function(){
        $('#update-order-id').val($(this).data('id'));
        $('#update-order-pos').val($(this).data('pos'));
        $('#update-payment-status').val($(this).data('payment'));
        $('#update-order-status').val($(this).data('order-status'));
        $('#notify-email').prop('checked', true);
        $('#modal-update-order').modal('show');
    });

    $(document).on('click','#btn-save-order-status',function(){
        const id = $('#update-order-id').val();
        const pos = $('#update-order-pos').val();
        const orderStatus = $('#update-order-status').val();
        const paymentVal = $('#update-payment-status').val();
        $.post(window.location.href, {
            func: 'update_status',
            id: id,
            payment_status: paymentVal,
            order_status: orderStatus,
            notify_email: $('#notify-email').is(':checked') ? '1' : '0'
        }, function(res){
            if(res.statusCode === 200){
                $('#status-payment' + pos).html(res.payment_text === 'Đã thanh toán' ? '<span class="badge badge-success">Đã thanh toán</span>' : '<span class="badge badge-warning">Chưa thanh toán</span>');
                $('#status-order' + pos).html(orderBadge(orderStatus));
                $('#modal-update-order').modal('hide');
                alert(res.message + (res.mail && res.mail.ok ? ' Email đã được gửi.' : (res.mail && res.mail.message ? ' ' + res.mail.message : '')));
            } else {
                alert(res.message || 'Đã có lỗi xảy ra.');
            }
        }, 'json');
    });
});
