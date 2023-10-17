<!-- <input type="hidden" name="my-id" id="my-id" value="<?=$_SESSION["user_code"]?>"> -->
<input type="hidden" name="my-id" id="my-id" value="1">
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6" align="left">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal"
                    class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
            </div>
            <div class="col-lg-6" align="right">
                <input type="hidden" name="hidden_date" id="hidden_date">
                <input type="hidden" name="hidden_time" id="hidden_time">
                <input type="hidden" name="hidden_visitor" id="hidden_visitor">
                <input type="hidden" name="hidden_status" id="hidden_status">

                <div class="d-flex flex-row">
                    <div class="p-2">
                        <input type="text" class="form-control datepicker-autoclose" name="date" placeholder="วันที่">
                    </div>

                    <div class="p-2">
                        <select class="form-control form-white" name="time">
                            <option selected disabled>เวลา</option>
                            <?php
foreach ($time as $val) {
    if (!$val["START"]) {
        $times = $val["END"];
    } elseif (!$val["END"]) {
        $times = $val["START"];
    } else {
        $times = $val["START"];
    }
    ?>
                            <option value="<?=date('H:i', strtotime($times))?>"><?=date('H:i', strtotime($times))?>
                            </option>
                            <?php
}
?>
                        </select>
                    </div>

                    <div class="p-2">
                        <select class="form-control form-white select2" data-toggle="select2" id="user_create"
                            name="user_create">
                            <option>ผู้สร้าง</option>
                            <?php
foreach ($staff as $data) {
    ?>
                            <option value="<?=$data->ID?>"><?=$data->NAME . " " . $data->LASTNAME?></option>
                            <?php
}
?>
                        </select>
                    </div>

                    <div class="p-2">
                        <select class="form-control form-white" data-toggle="select2" id="status_complete"
                            name="status_complete">
                            <option value="">สถานะ</option>
                            <option value="0">รอดำเนินการ</option>
                            <option value="1">นัดหมายสำเร็จ</option>
                            <option value="2">ยกเลิกการนัดหมาย</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary search"><i class="fa fa-search"
                            aria-hidden="true"></i></button>
                </div>
            </div>
            <!-- end col-lg-10 -->
        </div>
        <div class="card">
            <div class="card-body">

                <br>

                <div class="row">
                    <div class="col-md-12">
                        <table id="data_table" class="table table-hover w-100">
                            <thead>
                                <tr>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>เรื่อง</th>
                                    <th>วันที่</th>
                                    <th>เวลา</th>
                                    <th>ผู้สร้าง</th>
                                    <th>สถานะ</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>

<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
    <!-- item-->
    <a href="#" data-toggle="modal" data-target="#detail-modal" class="dropdown-item notify-item">
        <span class="align-middle">รายละเอียด</span>
    </a>

    <!-- item-->
    <a href="#" data-toggle="modal" data-target="#update-modal" class="dropdown-item notify-item">
        <span class="align-middle">แก้ไข</span>
    </a>

    <!-- item-->
    <a href="#" class="dropdown-item notify-item btn-delete" data-id="1">
        <span class="align-middle">ลบ</span>
    </a>

</div>
<?php
include "crud_modal.php";
?>
<script>
$(document).ready(function() {

    // select2
    /* $('[data-toggle=select2]').select2({
        theme: "bootstrap"
    });

    // inisialize datepicker
    $('.datepicker-autoclose').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
    });

    $('#data_table').DataTable({
        autoWidth: false,
        "order": [],
        //  dom: datatable_dom,
        //  buttons: datatable_button,
    }) */
    $('.btn-delete').click(function() {
        Swal.fire({
            title: 'โปรดยืนยัน',
            text: "คุณต้องการลบข้อมูลนี้",
            // icon: "",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่ ต้องการลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.value) {
                $('#data_table').find('tr[data-id=' + $(this).attr('data-id') + ']').addClass(
                    'd-none')
                Swal.fire(
                    'สำเร็จ!',
                    '',
                    'success'
                )
            }
        })
    })
    // return false
    /**
     * Button modal
     */
    /**
     * #
     * # Properties Button
     * 1. btn_insert = button insert target #insert-modal
     * 2. btn_save_insert = button save in #insert-modal
     * 3. btn_save_update = button save in #update-modal
     * 4. approve_footer = button approve,button not approve in #detail-modal
     * 5. save_footer = button save,button close in #detail-modal
     * 6. btn_unloading = button save in #detail-modal
     * 7. btn_loading = button save (spinner) in #detail-modal
     * 8. btn_edit = button edit in #detail-modal target #update-modal
     * 9. btn_delete = button delete in #detail-modal
     *
     *
     */

    let btn_insert = '#btn-insert'
    let btn_save_insert = '.btn-save-insert'
    let btn_save_update = '.btn-save-update'
    let approve_footer = '.approve-footer'
    let save_footer = '.save-footer'
    let btn_edit = '.btn-edit'
    let btn_delete = '.btn-delete'
    let btn_unloading = '.unloading'
    let btn_loading = '.loading'

    /**
     * #
     * #
     */

    /**
     *
     * #
     * # FUNCTION
     *
     */

    // inisialize datepicker
    $('.datepicker-autoclose').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
    });

    // select2
    $('[data-toggle=select2]').select2({
        theme: "bootstrap"
    });

    /**
     * FUNCTION CLICK
     */
    $(btn_insert).click(function() {
        $('#insert-modal').find('.form').attr('data-action', 'insert')
    })

    $(btn_edit).click(function() {
        $('#update-modal').find('.form').attr('data-action', 'update')
    })

    /**
     * #
     * #
     */

    /**
     *
     * #
     * # FUNCTION GET DATA
     *
     * #######################
     * ###### GET DATA ######
     *
     */
    let my_id = $('#my-id').val();
    /* async function get_data() {
        let url_datatable = new URL('appointment/ctl_calendar/get_data?id=' + my_id, domain);
        const response = await fetch(url_calendar, {})

        return response.json()
    } */

    /**
     * #
     * #
     */

    /**
     *
     * #######################
     * ###### DATATABLE ######
     *
     */
    // let url = new URL('appointment/ctl_datatable/get_data', domain);
    createDatatable()

    function createDatatable() {

        let url_datatable = new URL('appointment/ctl_datatable/get_data', domain);
        url_datatable.searchParams.append('id', my_id)

        // console.log('appointment/ctl_datatable/get_data?id=' + my_id, domain)
        console.log(url_datatable)
        $('#data_table').DataTable({
            ajax: {
                url: url_datatable,
                type: "get",
                dataType: "json",
                // data: function(d) {
                //     d.date = $('#hidden_date').val();
                //     d.time = $('#hidden_time').val();
                //     d.visitor = $('#hidden_visitor').val();
                //     d.status = $('#hidden_status').val();
                // }
            },
            autoWidth: false,
            // "order": [],
            columns: [{
                    "data": "STAFF_ID"
                },
                {
                    "data": "EVENT_NAME"
                },
                {
                    "data": "DATE_BEGIN"
                },
                {
                    "data": "TIME_BEGIN"
                },
                {
                    "data": "USER_START"
                },
                {
                    "data": "STATUS_COMPLETE_NAME"
                },
                {
                    "data": "ID"
                },
            ],
            "createdRow": function(row, data, index) {
                let table_btn_name =
                    `
                    <li class="dropdown d-none d-lg-block">
                                            <a class="text-primary nav-link dropdown-toggle mr-0" data-toggle="dropdown"
                                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                                <!-- item-->
                                                <a href="#" data-toggle="modal" data-target="#detail-modal"
                                                    class="dropdown-item notify-item">
                                                    <span class="align-middle">รายละเอียด</span>
                                                </a>

                                                <!-- item-->
                                                <a href="#" data-toggle="modal" data-target="#update-modal"
                                                    class="dropdown-item notify-item">
                                                    <span class="align-middle">แก้ไข</span>
                                                </a>

                                                <!-- item-->
                                                <a href="#" class="dropdown-item notify-item btn-delete" data-id="3">
                                                    <span class="align-middle">ลบ</span>
                                                </a>

                                            </div>
                                        </li>

                 `
                $('td', row).eq(6).html(table_btn_name)
            },

            dom: datatable_dom,
            buttons: datatable_button,

        });

    }

    /**
     *
     *
     * #
     * # FUNCTION CRUD
     *
     *
     * #############################
     * ###### CREATE / UPDATE ######
     *
     *
     */
    /* function insert() {

        let dataArray = $('.form').serializeArray()

        let data = new FormData()
        for (var i = 0; i < dataArray.length; i++) {
            data.append(dataArray[i].name, dataArray[i].value)

        }

        fetch('event_calendars/insert_data', { //insert_data ชื่อ controller
                method: 'POST',
                body: data //ส่งข้อมูลที่ชื่อ data ไปยัง controller ที่ชื่อ Eleave ในชื่อ function insert_data
            })
            .then(res => res.json())
            .then((resp) => {
                if (resp.error) {
                    swal_error('ไม่สำเร็จ', resp.msg, 'warning')
                } else {
                    swal_success(resp.msg)
                }
            })
    } */
    /**
     *
     *
     * ####################
     * ###### READ ######
     *
     *
     */
})
</script>