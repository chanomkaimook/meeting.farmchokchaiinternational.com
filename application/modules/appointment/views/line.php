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

        <div class="authentication-bg authentication-bg-pattern d-flex align-items-center pb-0 vh-100">

            <div class="account-pages w-100 mt-5 mb-5">
                <div class="container">

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card mb-0">

                                <div class="card-body pt-20 form-container">

                                    <div class="account-box">
                                        <div class="account-logo-box">
                                            <div class="text-center">
                                            </div>
                                            <div class="text-center" style="padding-top:10rem;">
                                                <h2 class="text-uppercase mb-1 text-center title">type</h2>
                                                <h4 class="text-uppercase mb-1 text-center status-complete">status</h4>
                                            </div>
                                        </div>

                                        <div class="account-content mt-4">
                                            <form class="form" id="detail">
                                                <div class="form-group">
                                                    <h5 class="control-h5">หัวข้อ</h5>
                                                    <input autocomplete="off" class="form-control form-white"
                                                        placeholder="Enter topic" type="text" value="" name="name"
                                                        readonly />
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mb-2">
                                                        <h5 class="control-h5">นำโดย</h5>

                                                        <input type="text" class="form-control form-white" name="head"
                                                            placeholder="นำโดย" readonly>
                                                    </div>
                                                    <!-- ************************************************************************************** -->
                                                    <div class="col-6 mb-2">
                                                        <h5 class="control-h5 invisible">status</h5>
                                                        <input autocomplete="off" class="form-control"
                                                            name="status-inline-text" value="" readonly>
                                                    </div>
                                                    <!-- ************************************************************************************** -->
                                                </div>

                                                <!-- ************************************************************************************** -->
                                                <div class="form-group rooms-line d-none">
                                                    <h5 class="control-h5">ห้องประชุม</h5>
                                                    <input autocomplete="off" class="form-control form-white"
                                                        placeholder="Enter topic" type="text" value=""
                                                        name="rooms-name" />
                                                </div>
                                                <!-- ************************************************************************************** -->
                                                <!-- ************************************************************************************** -->
                                                <div class="form-group meeting-line d-none">
                                                    <h5 class="control-h5">สถานที่</h5>
                                                    <input autocomplete="off" class="form-control form-white"
                                                        placeholder="Enter topic" type="text" value="" name="rooms-name"
                                                        readonly />
                                                </div>
                                                <!-- ************************************************************************************** -->

                                                <div class="form-group">
                                                    <h5 class="control-h5">เนื้อหาการประชุม</h5>
                                                    <textarea maxlength="150" placeholder="Enter name"
                                                        class="form-control form-white" name="description" cols="30"
                                                        rows="5" readonly></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mb-2">
                                                        <h5 class="control-h5">ตั้งแต่</h5>
                                                        <input autocomplete="off" type="text" class="form-control"
                                                            value="" placeholder="yyyy-mm-dd" name="dates" readonly>
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <h5 class="control-h5">ถึง</h5>
                                                        <input autocomplete="off" type="text" class="form-control"
                                                            value="" placeholder="yyyy-mm-dd" name="datee" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mb-2">
                                                        <h5 class="control-h5">ตั้งแต่</h5>
                                                        <input autocomplete="off" type="text" class="form-control"
                                                            value="" placeholder="08:00" name="times" readonly>
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <h5 class="control-h5">ถึง</h5>
                                                        <input autocomplete="off" type="text" class="form-control"
                                                            value="" placeholder="17:30" name="timee" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group" data-visitor="true">
                                                    <h5 class="control-h5">ผู้เข้าร่วม</h5>
                                                    <p class="visitor-name">

                                                    </p>
                                                </div>
                                                <div class="form-group">
                                                    <h5 class="control-h5">ผู้สร้างแบบฟอร์ม</h5>
                                                    <h5 class="user-start-name">

                                                    </h5>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end container -->
                </div>
                <!-- end page -->
            </div>


            <input type="hidden" name="id" value="<?=$_GET['id']?>">
            <input type="hidden" name="code" value="<?=$_GET['code']?>">
            <input type="hidden" name="data" value="<?=$_GET['data']?>">
            <input type="hidden" name="user_action" value="<?=$_GET['user_action']?>">
        </div>

        <script src="<?=base_url('')?>asset/libs/sweetalert2/sweetalert2.min.js"></script>

        <script>
        let domain
        if (window.location.hostname == 'localhost' || window.location.hostname == '127.0.0.1') {
            domain = window.location.protocol + '//' + window.location.hostname + '/' + window.location.pathname.split(
                '/')[
                1] + '/'
        } else {
            domain = window.location.protocol + '//' + window.location.hostname + '/'
        } // let domain = window.location.origin
        $(document).ready(function() {
            $("form#detail").find('div[data-visitor=true]').addClass('d-none')
            $('.form-container').addClass('d-none')

            if ($('[name=data]').val()) {
                $('.form-container').addClass('d-none')
                check_role()
            } else {
                get_data()

            }

            function get_data() {
                $('.form-container').removeClass('d-none')
                let id = $('div.respond').find('input[name=id]').val(),
                    code = $('div.respond').find('input[name=code]').val(),
                    user_action = $('div.respond').find('input[name=user_action]').val(),
                    dataArray = new FormData()

                dataArray.append('id', id),
                    dataArray.append('code', code),
                    dataArray.append('user_action', user_action)


                let url = new URL("appointment/ctl_line_data/get_data", domain);
                fetch(url, {
                        method: 'post',
                        body: dataArray
                    }).then(res => res.json())
                    .then((resp) => {

                        $(".account-box").find('h2.title').text(resp.TYPE)
                        $(".account-box").find('h4.status-complete').text(resp.STATUS_COMPLETE_NAME)
                        $("form#detail").find('[name=name]').val(resp.EVENT_NAME)
                        $("form#detail").find('[name=head]').val(resp.HEAD_FULLNAME)
                        $("form#detail").find('[name=status-inline-text]').val(resp.STATUS_HEAD)
                        $("form#detail").find('[name=rooms-name]').val(resp.ROOMS_NAME)
                        $("form#detail").find('[name=description]').val(resp.EVENT_DESCRIPTION)
                        $("form#detail").find('[name=dates]').val(resp.DATE_BEGIN)
                        $("form#detail").find('[name=datee]').val(resp.DATE_END)
                        $("form#detail").find('[name=times]').val(resp.TIME_BEGIN)
                        $("form#detail").find('[name=timee]').val(resp.TIME_END)
                        $("form#detail").find('h5.user-start-name').text(resp.USER_START_FULLNAME)

                        if (resp.VISITOR) {
                            $("form#detail").find('div[data-visitor=true]').removeClass('d-none')

                            let vis_data = "",
                                vis_html = "",
                                btn_action;
                            
                            for (let i = 0; i < resp.VISITOR.length; i++) {
                                j = i + 1
                                if (resp.VISITOR[i].STATUS_COMPLETE == 1) {
                                    vis_data =
                                        `<p class="h5" style="color: #888;">${j+'. '+resp.VISITOR[i].VNAME + ' ' + resp.VISITOR[i].VLNAME} <span> รอตอบรับ</span></p>`
                                } else if (resp.VISITOR[i].STATUS_COMPLETE == 2) {
                                    vis_data =
                                        `<p class="h5">${j+'. '+resp.VISITOR[i].VNAME + ' ' + resp.VISITOR[i].VLNAME} <span> เข้าร่วม</span></p>`
                                } else if (resp.VISITOR[i].STATUS_COMPLETE == 3) {
                                    vis_data =
                                        `<p class="h5 text-danger">${j+'. '+resp.VISITOR[i].VNAME + ' ' + resp.VISITOR[i].VLNAME} <span>ปฏิเสธ เนื่องจาก ${resp.VISITOR[i].STATUS_REMARK}</span></p>`
                                }

                                vis_html = vis_html + vis_data
                            }

                            $("form#detail").find('p.visitor-name').html(vis_html)
                        }
                    })
            }

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


                let url = new URL("appointment/ctl_line_data/check_role", domain);
                fetch(url, {
                        method: 'post',
                        body: dataArray
                    })
                    .then(res => res.json())
                    .then((resp) => {
                        console.log(resp)
                        if (resp.role == 'head') {
                            dataArray.append('status', resp.status)
                            dataArray.append('role', resp.role)
                        } else {
                            dataArray.append('role', resp.role)
                            dataArray.append('vid', resp.vid)
                        }

                        if (data == 3 && resp.role == 'visitor') {
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
                            data.append('reason', reason)
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then(() => {
                    swal(data)
                });
            }

            function swal(data) {
                let url = new URL("appointment/ctl_line_data/url_respond", domain);
                // console.log(data)
                fetch(url, {
                        method: 'post',
                        body: data
                    }).then(res => res.json())
                    .then((resp) => {
                        console.log(resp)

                        if (resp.error != 0) {
                            Swal.fire("ไม่สำเร็จ", resp.txt, "error")
                                .then(() => {
                                    get_data()
                                });
                        } else {
                            Swal.fire("สำเร็จ", "", "success")
                                .then(() => {
                                    get_data()
                                });
                        }
                    })
            }
        })
        </script>
</body>