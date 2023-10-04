<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="section-tool d-flex gap-2">
            <!-- Button trigger modal  -->
            <button type="button" id="register" class="btn btn-primary" data-id="" data-toggle="modal" data-target="#btn_register_user_modal">เพิ่ม user</button>
        </div>

        <div class="">
            <div class="card-box table-responsive">
                <table id="datatable_users" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>role</th>
                            <th>level</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>username</th>
                            <th>วันที่สมัคร</th>
                            <th>วันอัพเดต</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- end row -->

    </div> <!-- end container-fluid -->

</div> <!-- end content -->

<!-- Modal -->
<?php require_once('modal.php'); ?>


<script>
    $(document).ready(function() {
        let frm = $('#dataform')
        let method = $('#dataform input#method')

        //  fetch data
        //
        let url_user = new URL('admin/ctl_user/fetch_data', domain);

        $('#datatable_users').DataTable({
            ajax: {
                url: url_user,
                type: 'get',
                dataType: 'json'
            },
            order: [
                [5, 'desc']
            ],
            "createdRow": function(row, data, index) {
                let table_btn_edit_user =
                    `
                <button type="button" class="btn btn-warning btn_edit_user btn-sm" data-id="${data['ID']}" data-toggle="modal" data-target="#btn_register_user_modal">แก้ไข</button>
                <button type="button" class="btn btn-danger btn_delete_user btn-sm" data-id="${data['ID']}">ลบ</button>
                `
                $('td', row).eq(7).html(table_btn_edit_user)
            },


            dom: datatable_dom,
            buttons: datatable_button,
        })


        $(document).on('submit', '#dataform', function() {

            if (method.val() == 'insert') {
                register()
            } else {
                update_userdata()
            }

            return false;

        })

        //
        // button add
        $(document).on('click', '#register', function() {

            method.val('insert')
            frm.find('#btn_register').text('ลงทะเบียน')
        })

        //
        // button edit
        $(document).on('click', '.btn_edit_user', function() {

            let url_get_user = new URL('admin/ctl_user/get_user?id=' + $(this).attr('data-id'), domain);
            fetch(url_get_user)
                .then(res => res.json())
                .then((resp) => {

                    if (resp.data_role_focus) {
                        resp.data.role_focus = resp.data_role_focus
                    }
                    modal_input_data(resp.data)

                    method.val('edit')
                    frm.find('#btn_register').text('บันทึก')

                    $("#hidden_id").val($(this).attr('data-id'))
                });
        })

        //
        // reset form
        $('#btn_register_user_modal').on('hidden.bs.modal', function(e) {
            // do something...
            frm.trigger('reset')

            $(this).find(".userfocus").addClass('d-none')
            $('[data-toggle=select2]').val(null).trigger('change')

            $(this).find("#input_username").removeAttr('disabled')
            $(this).find("#input_password").removeAttr('disabled')
        })


        function register() {
            var dataArray = $("#dataform").serializeArray(),
                len = dataArray.length,
                dataObj = {};


            let url = new URL('register/ctl_register/insert_data_staff', domain);

            let data = new FormData();
            for (i = 0; i < len; i++) {
                data.append(dataArray[i].name, dataArray[i].value);
            }

            data.append('userfocus', $('[data-toggle=select2]').val())

            fetch(url, {
                    method: 'POST',
                    body: data
                })
                .then(res => res.json())
                .then((resp) => {

                    if (resp.error == 1) {
                        Swal.fire('ผิดพลาด', resp.txt, 'warning')
                    } else {

                        Swal.fire({
                            title: 'สำเร็จ',
                            html: 'รหัสพร้อมใช้งาน',
                            timer: 2000,
                            timerProgressBar: true,
                        }).then((result) => {
                            update_verify(resp.data.ID, resp.data.USERNAME)
                            window.location.reload();
                        })
                    }

                });

        }

        function update_verify(id = null, username = null) {

            if (id) {
                let data_vf = new FormData()
                data_vf.append('id', id)
                data_vf.append('username', username)

                let url_verify = new URL('admin/ctl_register/update_verify', domain);
                fetch(url_verify, {
                        method: 'POST',
                        body: data_vf,
                    })
                    .then(res => res.json())
                    .then((resp) => {

                    });

            }

        }

        function modal_input_data(data = []) {

            let modal_name = $("#btn_register_user_modal")

            /**
             * for role foucs
             * 8 == role id (helpdesk)
             */
            if (data.ROLES_ID == 8) {
                $('.userfocus').removeClass('d-none')
            }

            /**
             * for role foucs
             */
            if (data.role_focus.length) {
                let a = ''
                a = data.role_focus.map((item, index) => {
                    // console.log(item,index)
                    return item.STAFF_CHILD
                })
                $('.userfocus').removeClass('d-none')
                $('[data-toggle=select2]').val(a).trigger('change')
            }

            modal_name.find("#role").val(data.ROLES_ID)
            modal_name.find("#level").val(data.LEVEL_ID)
            modal_name.find("#name").val(data.NAME)
            modal_name.find("#lastname").val(data.LASTNAME)
            modal_name.find("#input_username").attr('disabled', 'disabled')
            modal_name.find("#input_password").attr('disabled', 'disabled')

        }

        function update_userdata() {

            let data_hidden_id = $("#hidden_id").val();

            let url_update_user = new URL('admin/ctl_user/update_user', domain)

            var data = new FormData()
            data.append('id', data_hidden_id)
            data.append('role', $("#role").val())
            data.append('name', $("#name").val())
            data.append('lastname', $("#lastname").val())
            data.append('userfocus', $('[data-toggle=select2]').val())

            let option = {
                method: 'POST',
                body: data,
            }

            fetch(url_update_user, option)
                .then(res => res.json())
                .then((resp) => {

                    $('#datatable_users').DataTable().ajax.reload();

                    $('#btn_register_user_modal').modal('hide')

                })
        }


        $(document).on('click', '.btn_delete_user', function() {
            $("#hidden_id").val($(this).attr('data-id'))
            let hidden_id = $("#hidden_id").val();

            let table_tr = $('.btn_edit_user[data-id=' + hidden_id + ']').parents('tr');
            let user_name = table_tr.children('td').eq(1).text() + ' ' + table_tr.children('td').eq(2).text()

            Swal.fire({
                title: 'ยืนยันการลบ',
                text: "คุณต้องการลบข้อมูลนี้ " + user_name,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#64c5b1',
                cancelButtonColor: '#f96a74',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.value) {
                    confirm_delete(hidden_id)
                }
            })
        })

        function confirm_delete(id = null) {

            if (id) {
                let url_delete_user = new URL('admin/ctl_user/delete_user', domain);

                var delete_data = new FormData();
                delete_data.append('id', id);
                fetch(url_delete_user, {
                        method: 'POST',
                        body: delete_data
                    })
                    .then(res => res.json())
                    .then((resp) => {
                        if (resp.data.error == 0) {
                            $('#datatable_users').DataTable().ajax.reload(null, false);

                            Swal.fire(
                                'สำเร็จ',
                                resp.data.text,
                                'success'
                            )
                        } else {
                            Swal.fire(
                                'ผิดพลาด',
                                resp.data.text,
                                'warning'
                            )
                        }

                        //window.location.reload()
                    });
            }

        }


    })
</script>