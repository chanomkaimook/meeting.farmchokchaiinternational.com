<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('')?>asset/images/favicon-16x16.png">

    <link href="<?=base_url('')?>asset/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <link href="<?=base_url('')?>asset/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <script src="<?=base_url('asset/js/jquery/jquery-3.5.1.min.js')?>"></script>
    <!-- App css -->
    <link href="<?=base_url('asset/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css"
        id="bootstrap-stylesheet" />
    <link href="<?=base_url('asset/css/icons.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('asset/css/app.min.css')?>" rel="stylesheet" type="text/css" id="app-stylesheet" />

</head>
<style>
body {
    margin: 0px;
    padding: 0px;
}
</style>

<body>


    <div class="respond">
        <input type="hidden" name="id" value="<?=$_GET['id']?>">
        <input type="hidden" name="code" value="<?=$_GET['code']?>">
        <input type="hidden" name="data" value="<?=$_GET['data']?>">
        <input type="hidden" name="user_action" value="<?=$_GET['user_action']?>">
    </div>
    <!-- <div class="respond">
        <input type="hidden" name="icon" value="<?=$respond['icon']?>">
        <input type="hidden" name="msg" value="<?=$respond['msg']?>">
        <input type="hidden" name="title" value="<?=$respond['title']?>">
    </div> -->

    <script src="<?=base_url('')?>asset/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- D:\xampp\htdocs\datacenter.com\asset\js\jquery\jquery-3.5.1.min.js -->

    <script>
    let domain
    if (window.location.hostname == 'localhost' || window.location.hostname == '127.0.0.1') {
        domain = window.location.protocol + '//' + window.location.hostname + '/' + window.location.pathname.split('/')[
            1] + '/'
    } else {
        domain = window.location.protocol + '//' + window.location.hostname + '/'
    } // let domain = window.location.origin
    $(document).ready(function() {
        check_role()
        // window_close = "https://booking.chokchaiinternational.com/appointment/ctl_line?id="+$('input[name=id]').val()+"&code="+$('input[name=code]').val()+"&data="+$('input[name=data]').val()+"&user_action="+$('input[name=user_action]').val()
        // console.log(window_close)
        function check_role() {
            let id = $('div.respond').find('input[name=id]').val(),
                code = $('div.respond').find('input[name=code]').val(),
                data = $('div.respond').find('input[name=data]').val(),
                user_action = $('div.respond').find('input[name=user_action]').val(),
                dataArray = new FormData()

            dataArray.append('id', id),
                dataArray.append('code', code),
                dataArray.append('data', data),
                dataArray.append('user_action', user_action)


            // console.log(id,code,data,user_action)
            let url = new URL("appointment/ctl_line/check_role", domain);
            fetch(url, {
                    method: 'post',
                    body: dataArray
                }).then(res => res.json())
                .then((resp) => {
                    // console.log(resp)

                    if (resp.role == 'child') {
                        dataArray.append('status', resp.status)
                        dataArray.append('role', resp.role)
                    } else {
                        dataArray.append('role', resp.role)
                        dataArray.append('vid', resp.vid)
                    }

                    if (data == 3 && resp.role == 'vis') {
                        swal_reason(dataArray)
                    } else {
                        swal(dataArray)
                    }
                })
        }

        function swal_reason(data) {
            Swal.fire({
                title: "กรุณาระบุเหตุผลที่ไม่เข้าร่วม",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "ยืนยัน",
                showLoaderOnConfirm: true,
                preConfirm: async (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage(`กรุณาระบุ`);
                    } else {
                        return data.append('reason', reason)
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                swal(data)
            });
        }

        function swal(data) {
            let url = new URL("appointment/ctl_line/url_respond", domain);
            // console.log(data)
            fetch(url, {
                    method: 'post',
                    body: data
                }).then(res => res.json())
                .then((resp) => {
                        // console.log(resp)
                    if (resp.error) {
                        Swal.fire("ไม่สำเร็จ", resp.txt, "error")
                        // .then(() => {
                        //     window.close(window_close)
                        // });
                    } else {
                        Swal.fire("สำเร็จ", "", "success")
                        // .then(() => {
                        //     window.close(window_close)
                        // });
                    }
                    // Swal.fire(title, msg, icon);
                })
        }
    })
    </script>
</body>