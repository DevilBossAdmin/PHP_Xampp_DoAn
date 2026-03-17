<<<<<<< HEAD
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
=======
$(document).ready(function(event){

    // kích hoạt datepicker của jquery ui
    $( "#ngay_sinh_admin" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
    // reset lỗi cập nhật thông tin
    $(document).on('click','#btn-cap-nhat-admin,#btn-doi-mat-khau-admin',function(event){
        // cap nhat mat khau
        $("#old_pass_err").text("");
        $("#new_pass_err").text("");
        $("#confirm_pass_err").text("");

        // cap nhat thong tin
        $("#name_err").text("");
        $("#phone_err").text("");
        $("#birth_err").text("");
        $("#address_err").text("");


    })
    // cập nhật thông tin admin
    $(document).on('click','#btn-cap-nhat-admin',function(event){
        event.preventDefault();
        let name = $('input[name=name]').val();
        let old_pass = $('input[name=old_pass]').val();
        let email = $('input[name=email]').val();
        let phone = $('input[name=phone]').val();
        let birth = $('input[name=birth]').val();
        let address = $('input[name=address]').val();
        let img = $('#display-image').attr('data-img');

        if(old_pass == ""){
            alert("Vui lòng không để trống mật khẩu xác thực.");
            return;
        } 

        var formData = new FormData($('#form-admin')[0]);
       

        // xu ly du lieu
        formData.append('name',name);
        formData.append('email',email);
        formData.append('phone',phone);
        formData.append('birth',birth);
        formData.append('address',address);
        formData.append('old_pass',old_pass);

        let url = window.location.href;

        // xu ly anh
        let file = $('input[name=img_admin_file]')[0].files;
        if(file.length == 0){
        formData.append('img_admin',img);
        } else {
        formData.append('img_admin_file',file[0]);
        }
        // xử lý ajax
        $.ajax({
            url:url,
            type:"POST",
            cache:false,
            dataType:"json",
            contentType: false,
            processData: false,
            data:formData,
            success:function(res_json){
                if(res_json.statusCode == 200){
                    alert("Cập nhật dữ liệu thành công.");
                } else if(res_json.statusCode == 201){
                    alert("Đã xảy ra lỗi, vui lòng reload lại trang web");
                } else if(res_json.statusCode == 202) {
                    $("#name_err").text(res_json.name_err);
                    $("#old_pass_err").text(res_json.old_pass_err);
                    $("#phone_err").text(res_json.phone_err);
                    $("#birth_err").text(res_json.birth_err);
                    $("#address_err").text(res_json.address_err);
                    $("#email_err").text(res_json.email_err);
                    $("#image_err").text(res_json.image_err);
                } else {
                    alert(res_json.auth);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    // cập nhật mật khẩu admin
    $(document).on('click','#btn-doi-mat-khau-admin',function(event){
        event.preventDefault();

        let old_pass = $('input[name=old_pass]').val();
        let new_pass = $('input[name=new_pass]').val();
        let confirm_new_pass = $('input[name=confirm_new_pass]').val();
        let url = "admin_change_pass.php";

        $.ajax({
            url:url,
            type:"POST",
            data:{
                old_pass: old_pass,
                new_pass: new_pass,
                confirm_new_pass: confirm_new_pass,
            },
            success:function(res_json){
                res_json = JSON.parse(res_json);
                if(res_json.statusCode == 200){
                    alert("Cập nhật dữ liệu thành công.");
                } else if(res_json.statusCode == 201){
                    alert("Đã xảy ra lỗi, vui lòng reload lại trang web");
                } else if(res_json.statusCode == 202) {
                    $("#old_pass_err").text(res_json.old_pass_err);
                    $("#new_pass_err").text(res_json.new_pass_err);
                    $("#confirm_new_pass_err").text(res_json.confirm_new_pass_err);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    /* -1: xem chi tiết hoá đơn
     * 0: xem thông tin người dùng
     * 1: cập nhật trạng thái đã thanh toán.
     */
    // hiển thị thông tin chi tiết đơn hàng khi admin click vào button "Xem chi tiết đơn hàng."
    $(document).on('click','.btn-xem-chi-tiet-hoa-don',function(event){
        let func = -1;
        let id = $(this).attr('data-bill_id');
        let url = window.location.href;
        $.ajax({
            url:url,
            type:"POST",
            data: {
                id: id,
                func: func,
            },
            success:function(data){
                data = JSON.parse(data);
                let len = data.length;

                $('#modal-xl').modal('show');
                $('.modal-title').text("Thông tin hoá đơn");
                if($('th').parents('#t_head').length > 0) {
                    $('#t_head').empty();
                }
                if($('tr > td').parents('#t_body').length > 0) {
                    $('#t_body').empty();
                }
                $('#t_head').append('<th>Tên sản phẩm</th>');
                $('#t_head').append('<th>Hình ảnh</th>');
                $('#t_head').append('<th>Đơn giá</th>');
                $('#t_head').append('<th>Số lượng</th>');
                $('#t_head').append('<th>Số tiền</th>');
                let tr = "";
                for(let i = 0 ; i < len ; i++) {
                    tr = "<tr id='cthd"+i+"'>";
                    $('#t_body').append(tr);
                    $('#t_body > #cthd' + i).append('<td>' + data[i].name + '</td>');
                    $('#t_body > #cthd' + i).append('<td><img width="120" height="120" src="../img/img-admin/product/' + data[i].image + '"></td>');
                    $('#t_body > #cthd' + i).append('<td>' + data[i].price + '</td>');
                    $('#t_body > #cthd' + i).append('<td>' + data[i].count + '</td>');
                    let total = data[i].count * data[i].price;
                    $('#t_body > #cthd' + i).append('<td>' + total+ '</td>');
                    $('#t_body').append("</tr>");
                }

            },
            error:function(data){
                console.log('Error:', data);
            }
        })
    })


    // hiển thị thông tin người dùng đặt hàng khi admin click vào button "Xem thông tin người dùng."
    $(document).on('click','.btn-xem-thong-tin-nguoi-dung',function(event){
        let func = 0;
        let id = $(this).attr('data-user_id');
        let url = window.location.href;
        $.ajax({
            url:url,
            type:"POST",
            data:{
               id: id, 
               func: func,
            },
            success:function(data){
                data = JSON.parse(data);
                $('#modal-xl').modal('show');
                $('.modal-title').text("Thông tin người dùng");
                if($('th').parents('#t_head').length > 0) {
                    $('#t_head').empty();
                }
                if($('tr > td').parents('#t_body').length > 0) {
                    $('#t_body').empty();
                }
                $('#t_head').append('<th>Tên</th>');
                $('#t_head').append('<th>Ảnh đại diện</th>');
                $('#t_head').append('<th>Email</th>');
                $('#t_head').append('<th>Ngày sinh</th>');
                $('#t_head').append('<th>Số điện thoại</th>');
                $('#t_head').append('<th>Địa chỉ</th>');
                $('#t_body').append("<tr>");
                $('#t_body > tr').append('<td>' + data.name + '</td>');
                $('#t_body > tr').append('<td><img width="120" height="120" src="../img/img-user/info/' + data.image + '"></td>');
                $('#t_body > tr').append('<td>' + data.email + '</td>');
                $('#t_body > tr').append('<td>' + data.birth + '</td>');
                $('#t_body > tr').append('<td>' + data.phone+ '</td>');
                $('#t_body > tr').append('<td>' + data.address+ '</td>');
                $('#t_body').append("</tr>");
            },
            error:function(data){
                console.log('Error:', data);
            }
        })
    })

    /*
     *
     */
    // Cập nhật trạng thái đã thanh toán khi admin click vào button "Cập nhật đã thanh toán hoá đơn."
    $(document).on('click','.btn-cap-nhat-thanh-toan',function(event){
        let func = 1;
        let id = $(this).attr('data-id');
        let pos = $(this).attr('data-pos');
        let url = window.location.href;
        $.ajax({
            url:url,
            type:"POST",
            data: {
                func: func,
                id: id,
            },
            success:function(data){
                data = JSON.parse(data);
                if(data.statusCode == 200) {
                    alert("Cập nhật dữ liệu thành công.");
                    $("#status-payment"+pos).text("Đã thanh toán");

                } else {
                    alert("Đã có lỗi xảy ra.");
                }
            },
            error:function(data){
                console.log('Error:', data);
            }
        })
    })
});
>>>>>>> 9757977c83c8138327f5b9488c8231c3618aafda
