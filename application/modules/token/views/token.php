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

<?php
/* $this->session->sess_destroy();
if ($this->session->has_userdata('user_code')) {

    print_r($this->session->userdata());
}
 */
?>

<body>
    <div class="authentication-bg authentication-bg-pattern d-flex align-items-center pb-0 vh-100">

        <div class="account-pages w-100 mt-5 mb-5">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mb-0">

                            <div class="card-body p-4">

                                <div class="account-box">
                                    <div class="account-logo-box">
                                        <div class="text-center">
                                            <!-- <a href="index.html">
                                                <img src="<?=base_url('asset/images/logo-dark.png')?>" alt="" height="30">
                                            </a> -->
                                        </div>
                                        <div class="text-center">
                                            <h2 class="text-uppercase mb-1  text-center">ลงทะเบียน</h2>
                                            <!-- <div class="small text-center"></div> -->
                                        </div>
                                    </div>

                                    <div class="account-content mt-4">
                                        <form class="form-horizontal" id="login">
                                            <div id="userId"></div>
                                            <div class="form-group">
                                                <label class="control-label">ชื่อ-นามสกุล</label>
                                                <select class="form-control" data-toggle="select2" name="employee">
                                                    <option selected></option>
                                                    <?php foreach ($employee as $emp) {
    ?>
                                                    <option value="<?=$emp->ID?>"><?=$emp->NAME . " " . $emp->LASTNAME?>
                                                    </option>
                                                    <?php
}?>
                                                </select>
                                            </div>

                                            <div class="form-group row text-center mt-2">
                                                <div class="col-12">
                                                    <button
                                                        class="btn btn-md btn-block btn-primary waves-effect waves-light"
                                                        id="btn_login" type="button">ลงทะเบียน</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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

    <script src="<?=base_url('')?>asset/libs/select2/select2.min.js"></script>
    <!-- Sweet alert -->
    <script src="<?=base_url('')?>asset/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- D:\xampp\htdocs\datacenter.com\asset\js\jquery\jquery-3.5.1.min.js -->

    <script src="https://static.line-scdn.net/liff/edge/versions/2.9.1/sdk.js"></script>
    <script>
    let domain
    if (window.location.hostname == 'localhost' || window.location.hostname == '127.0.0.1') {
        domain = window.location.protocol + '//' + window.location.hostname + '/' + window.location.pathname.split('/')[
            1] + '/'
    } else {
        domain = window.location.protocol + '//' + window.location.hostname + '/'
    } // let domain = window.location.origin
    $(document).ready(function() {


        // select2
        $('[data-toggle=select2]').select2({
            theme: "bootstrap"
        });


        $(document).on('click', '#btn_login', function(e) {
            token()
            // e.preventDefault()
            return false;
        })
        /* $(document).on('submit', '#login', function() {
            // login()
            e.preventDefault()
            let dataDefault = [],
                data = new FormData(),
				dataArray = []

                dataArray = $('#login').serializeArray()

				console.log(dataArray)
            dataArray.forEach(function(item, index) {
                dataDefault.push(item);
            })

            return false;
        }) */

        function token() {
            let url_check_token = new URL('token/ctl_token/update_data', domain);

            let data = new FormData(),
                dataArray = $('#login').serializeArray()

            // dataArray = 

            console.log(dataArray)
            dataArray.forEach(function(item, index) {
                data.append(item.name, item.value)
            })


            fetch(url_check_token, {
                    method: 'POST',
                    body: data,
                })
                .then(res => res.json())
                .then((resp) => {
                    if (resp.error != 0) {
                        swal.fire('ผิดพลาด', resp.text, 'warning')
                    } else {
                        swal.fire('ลงทะเบียนสำเร็จ', "", 'success')
                            .then(() => {
                                location.href = domain;

                            })
                    }
                })
        }

        function runApp() {
            liff.getProfile().then(profile => {
                console.log(profile)
                document.getElementById("userId").innerHTML =
                    '<input type="text" name="userId" value="' +
                    profile
                    .userId + '" hidden>';
            }).catch(err => console.error(err));
        }
        liff.init({
            liffId: "2000744935-Y5OanZ8n"
        }, () => {
            if (liff.isLoggedIn()) {
                runApp()
            } else {
                liff.login();
            }
        }, err => console.error(err.code, error.message));
    })
    </script>