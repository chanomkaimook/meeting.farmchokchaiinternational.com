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
        <input type="hidden" name="icon" value="<?=$respond['icon']?>">
        <input type="hidden" name="msg" value="<?=$respond['msg']?>">
        <input type="hidden" name="title" value="<?=$respond['title']?>">
    </div>

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
        swal()

        function swal() {
            let icon = $('div.respond').find('input[name=icon]').val(),
                msg = $('div.respond').find('input[name=msg]').val(),
                title = $('div.respond').find('input[name=title]').val()

                Swal.fire(title, msg, icon);
        }
    })
    </script>
</body>