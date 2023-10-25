<!-- <input type="hidden" name="my-id" id="my-id" value="<?=$_SESSION["user_code"]?>"> -->
<input type="hidden" name="my-id" id="my-id" value="1">
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal"
                    class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
                <button type="button" class="btn btn-secondary" data-toggle="modal"
                    data-target="#draft-modal">แบบร่าง</button>
            </div>
            <div class="col-8">
                <input type="hidden" name="hidden_dates" id="hidden_dates">
                <input type="hidden" name="hidden_datee" id="hidden_datee">
                <input type="hidden" name="hidden_times" id="hidden_times">
                <input type="hidden" name="hidden_timee" id="hidden_timee">
                <input type="hidden" name="hidden_user" id="hidden_user">
                <input type="hidden" name="hidden_permit" id="hidden_permit">
                <input type="hidden" name="hidden_status" id="hidden_status">
                <input type="hidden" name="hidden_type" id="hidden_type">

                <div class="filter-card">
                    <div class="d-flex flex-row justify-content-end">
                        <div class="pl-1">
                            <select class="form-control form-white select2" data-toggle="select2" name="type">
                                <option>ประเภท</option>
                                <option value="1">นัดหมาย/จองห้องประชุม</option>
                                <option value="2">จองรถ</option>
                                <!-- <option value="3">แบบร่างการนัดหมาย/จองห้องประชุม</option>
                                <option value="4">แบบร่างการจองรถ</option> -->
                            </select>
                        </div>

                        <div class="pl-1">
                            <select class="form-control form-white select2" data-toggle="select2" name="user">
                                <option>จัดการ</option>
                                <?php
foreach ($staff as $data) {
    ?>
                                <option value="<?=$data->ID?>"><?=$data->NAME . " " . $data->LASTNAME?></option>
                                <?php
}
?>
                            </select>
                        </div>

                        <div class="pl-1">
                            <select class="form-control form-white" data-toggle="select2" name="status">
                                <option value="">สถานะ</option>
                                <option value="1">รออนุมัติ,รอตอบรับ,รอดำเนินการ</option>
                                <option value="2">อนุมัติ,เข้าร่วม,ดำเนินการสำเร็จ</option>
                                <option value="3">ไม่อนุมัติ,ปฏิเสธมดำเนินการไม่สำเร็จ</option>
                                <option value="4">ยกเลิก</option>
                                <option value="5">กำลังดำเนินการ</option>
                            </select>
                        </div>
                        <div class="pl-1">
                            <select class="form-control form-white" data-toggle="select2" name="permit">
                                <option value="0">ทั้งหมด</option>
                                <option value="1">เฉพาะที่มีสิทธิ์จัดการ</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-end">

                        <div class="pl-1">
                            <input type="text" class="form-control datepicker-autoclose" name="dates"
                                placeholder="ตั้งแต่วันที่">
                        </div>
                        <div class="pl-1">
                            <input type="text" class="form-control datepicker-autoclose" name="datee"
                                placeholder="ถึงวันที่">
                        </div>

                        </div>
                    <div class="d-flex flex-row justify-content-end">
                        <div class="pl-1">
                            <select class="form-control form-white" name="times">
                                <option selected disabled>ตั้งแต่เวลา</option>
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
                                <option value="<?=date('H:i:s', strtotime($times))?>">
                                    <?=date('H:i', strtotime($times))?>
                                </option>
                                <?php
}
?>
                            </select>
                        </div>
                        <div class="pl-1">
                            <select class="form-control form-white" name="timee">
                                <option selected disabled>ถึงเวลา</option>
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
                                <option value="<?=date('H:i:s', strtotime($times))?>">
                                    <?=date('H:i', strtotime($times))?>
                                </option>
                                <?php
}
?>
                            </select>
                        </div>

                        <button type="button" class="btn btn-secondary btn-search"><i class="fa fa-search"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
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
    let my_id = $('#my-id').val();

    /**
     * Button modal
     *
     * #
     * # Properties Button
     * 1. btn_insert = button insert event
     * 2. btn_update = button update event
     * 3. btn_draft_insert = button insert draft
     * 4. btn_draft_update = button update draft
     * 5. btn_delete = button delete event,draft
     * 6. btn_approve = button approve event when creater is entitled person
     * 7. btn_disapprove = button disapprove event when creater is entitled person
     * 8. btn_accept = button accept event when imma visitor
     * 9. btn_refuse = button refuse event when imma visitor
     * 10. btn_success = button success when event is done
     * 11. btn_cancle = button cancle when event is done
     * 12. btn_defer = button accept when imma creater
     * 13. btn_deny = button refuse when imma creater
     * 14. btn_reject = button delete visitor when imma creater
     * 15. btn_restore = button restore event when event is cancle
     * 16. btn_search = button submit filter
     *
     *
     */

    let btn_insert = '.btn-save-insert'
    let btn_update = '.btn-save-update'
    let btn_draft_insert = '.btn-draft-insert'
    let btn_draft_update = '.btn-draft-update'
    let btn_delete = '.delete-meeting'
    let btn_approve = '.btn-approve'
    let btn_disapprove = '.btn-disapprove'
    let btn_accept = '.btn-accept'
    let btn_refuse = '.btn-refuse'
    let btn_success = '.btn-finish'
    let btn_cancle = '.btn-cancle'
    let btn_defer = '.defer'
    let btn_deny = '.deny'
    let btn_reject = '.reject'
    let btn_restore = '.btn-restore'
    let btn_search = '.btn-search'

    /**
     *
     * EVENT CHANGE
     *
     */

    $('[name=dates]').change(function() {
        let data = $(this).val()
        $('#hidden_dates').val(data)
        // console.log($('#hidden_dates').val())
    })

    $('[name=datee]').change(function() {
        let data = $(this).val()
        $('#hidden_datee').val(data)
        // console.log($('#hidden_datee').val())
    })

    $('[name=times]').change(function() {
        let data = $(this).val()
        $('#hidden_times').val(data)
        // console.log($('#hidden_times').val())
    })

    $('[name=timee]').change(function() {
        let data = $(this).val()
        $('#hidden_timee').val(data)
        // console.log($('#hidden_timee').val())
    })

    $('[name=user]').change(function() {
        let data = $(this).val()
        $('#hidden_user').val(data)
        // console.log($('#hidden_user').val())
    })

    $('[name=permit]').change(function() {
        let data = $(this).val()
        $('#hidden_permit').val(data)
        // console.log($('#hidden_permit').val())
    })

    $('[name=status]').change(function() {
        let data = $(this).val()
        $('#hidden_status').val(data)
        // console.log($('#hidden_status').val())
    })

    $('[name=type]').change(function() {
        let data = $(this).val()
        $('#hidden_type').val(data)
        // console.log($('#hidden_type').val())
    })

    /**
     *
     * EVENT CLICK
     *
     */

    $(btn_search).click(function() {
        
        $('#data_table').DataTable().ajax.reload()

        // createDatatable()
    })

    $(document).on('click', 'a.btn-detail-meeting', function() {
        let id = $(this).attr('data-id')
        get_data_draft(id)
            .then((data) => {
                let dataDefault;
                if (data.length) {
                    data.forEach(function(item, index) {
                        dataDefault = item
                    })
                    detail(dataDefault, '', '')
                }
            })
    })

    $(document).on('click', 'a.btn-draft-meeting', function() {
        let id = $(this).attr('data-id')
        get_data_draft(id)
            .then((data) => {
                // console.log(data)
                let dataDefault;
                if (data.length) {
                    data.forEach(function(item, index) {
                        dataDefault = item
                    })
                    type = "draft"
                    draft_to_use(dataDefault,type)
                }
            })
    })

    $(document).on('click', 'a.btn-update-meeting', function() {
        let id = $(this).attr('data-id')
        get_data_draft(id)
            .then((data) => {
                // console.log(data)
                let dataDefault;
                if (data.length) {
                    data.forEach(function(item, index) {
                        dataDefault = item
                    })
                    type = "use"
                    draft_to_use(dataDefault,type)
                }
            })
    })

    /**
     *
     * EVENT CHANGE
     *
     */

    $('#user').change(function() {
        let id = $(this).val()
        // console.log(id)
    })

    /* $(document).on('change', '[name=sid_create]', function() {
            let sid = $('[name=sid_create]').val()
            $('#modal_create').find('[name=period_create]').attr('data-sid', sid)
            $('#modal_create').find('[name=sid]').val(sid)
            get_data_hld_dom(sid)
        }) */

    /**
     *
     */

    /**
     * CRUD
     *
     * #
     * # FUNCTION INSERT
     *
     *
     */
    $(btn_insert).click(function(e) {
        e.preventDefault()
        let visitor = [],
            data = new FormData(),
            dataArray = $('#insert-meeting').serializeArray()

        for (var i = 0; i < dataArray.length; i++) {
            data.append(dataArray[i].name, dataArray[i].value)

            if (dataArray[i].name == "insert-type") {
                data.append("insert-type-id", dataArray[i].value)
                data.append("insert-type-name", "นัดหมาย/จองห้องประชุม")
            }
            if (dataArray[i].name == "insert-visitor") {
                visitor.push(dataArray[i].value)
            }
        }
        data.append("visitor", visitor)
        insert_meeting(data, "calendar")
    })

    /**
     *
     *
     * #
     * # FUNCTION DRAFT INSERT
     *
     *
     */
    $(btn_draft_insert).click(function(e) {
        e.preventDefault()
        let visitor = [],
            data = new FormData(),
            dataArray = $('#insert-meeting').serializeArray()

        for (var i = 0; i < dataArray.length; i++) {
            data.append(dataArray[i].name, dataArray[i].value)

            if (dataArray[i].name == "insert-type") {
                data.append("insert-type-id", Number.parseInt(dataArray[i].value) + 2)
                data.append("insert-type-name", "แบบร่างนัดหมาย/จองห้องประชุม")
            }
            if (dataArray[i].name == "insert-visitor") {
                visitor.push(dataArray[i].value)
            }
        }
        data.append("visitor", visitor)
        // console.log(data)
        insert_meeting(data, "calendar")
    })

    /**
     *
     *
     * #
     * # FUNCTION UPDATE
     *
     *
     */

    $(btn_update).click(function(e) {
        e.preventDefault()
        let visitor = [],
            data = new FormData(),
            dataArray = $('#update-meeting').serializeArray()

        for (var i = 0; i < dataArray.length; i++) {
            if (dataArray[i].name == "update-visitor") {
                visitor.push(dataArray[i].value)
            } else {

            }
            data.append(dataArray[i].name, dataArray[i].value)
        }
        data.append("visitor", visitor)
        update_meeting(data, "calendar")
    })

    /**
     *
     *
     * #
     * # FUNCTION DELETE
     *
     *
     */

    $(btn_delete).click(function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code')

        data.append('item_id', id)
        data.append('item_code', code)

        swal_delete(data)
        // $("#detail-modal-meeting").modal("hide")
    })

    $(document).on('click', btn_reject, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            vid = $(this).attr('data-id')

        data.append('item_id', id)
        data.append('item_code', code)
        // data.append('item_data', '2')
        data.append('vid', vid)

        swal_delete(data)
    })

    /**
     *
     *
     * #
     * # FUNCTION APPROVE
     *
     *
     */

    $(document).on('click', btn_approve, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            text = "อนุมัติ",
            func = "approval",
            color = '#04d66a'

        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '2')

        swal_confirm(text, color, func, data)
    })

    /**
     *
     *
     * #
     * # FUNCTION DISAPPROVE
     *
     *
     */

    $(document).on('click', btn_disapprove, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            text = "ไม่อนุมัติ",
            func = "approval",
            color = '#d33'

        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '3')

        swal_confirm(text, color, func, data)
    })

    /**
     *
     *
     * #
     * # FUNCTION ACCEPT
     *
     *
     */

    $(document).on('click', btn_accept, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            vid = $(this).attr('data-id'),
            text = "ตอบรับ",
            func = "invitation",
            color = '#04d66a'

        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '2')
        data.append('vid', vid)

        swal_confirm(text, color, func, data)
    })

    $(document).on('click', btn_defer, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            vid = $(this).attr('data-id'),
            text = "ตอบรับ",
            func = "invitation",
            color = '#04d66a'

        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '2')
        data.append('vid', vid)

        swal_confirm(text, color, func, data)
    })

    /**
     *
     *
     * #
     * # FUNCTION REFUSE
     *
     *
     */

    $(document).on('click', btn_refuse, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            vid = $(this).attr('data-id'),
            text = "ปฏิเสธ",
            func = "invitation",
            color = '#d33'

        data.append('vid', vid)
        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '3')

        swal_confirm(text, color, func, data)
    })

    $(document).on('click', btn_deny, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            vid = $(this).attr('data-id'),
            text = "ปฏิเสธ",
            func = "invitation",
            color = '#d33'

        data.append('vid', vid)
        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '3')

        swal_confirm(text, color, func, data)
    })

    /**
     *
     *
     * #
     * # FUNCTION SUCCESS
     *
     *
     */

    $(document).on('click', btn_success, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            text = "สิ้นสุดกระบวนการ",
            func = "processing",
            color = '#04d66a'

        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '2')

        swal_confirm(text, color, func, data)
    })

    /**
     *
     *
     * #
     * # FUNCTION CANCLE
     *
     *
     */

    $(document).on('click', btn_cancle, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            text = "ยกเลิก",
            func = "processing",
            color = '#d33'

        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '4')

        swal_confirm(text, color, func, data)
    })

    /**
     *
     *
     * #
     * # FUNCTION RESTORE
     *
     *
     */

    $(document).on('click', btn_restore, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code'),
            text = "กู้คืน",
            func = "restore",
            color = '#04d66a'

        data.append('item_id', id)
        data.append('item_code', code)
        data.append('item_data', '1')

        swal_confirm(text, color, func, data)
    })

    /**
     * #
     * #
     */


    /**
     *
     *
     * #
     * # FIXED
     *
     *
     */

    // select2
    $('[data-toggle=select2]').select2({
        theme: "bootstrap"
    });

    // inisialize datepicker
    $('.datepicker-autoclose').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
    });

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

    function createDatatable(data = []) {

        let url_datatable = new URL('appointment/ctl_datatable/get_data', domain);
        url_datatable.searchParams.append('id', my_id)

        // console.log('appointment/ctl_datatable/get_data?id=' + my_id, domain)
        // console.log(url_datatable)
        $('#data_table').DataTable({
            ajax: {
                url: url_datatable,
                type: "post",
                dataType: "json",
                data: function(d) {
                    d.dates = $('#hidden_dates').val();
                    d.datee = $('#hidden_datee').val();
                    d.times = $('#hidden_times').val();
                    d.timee = $('#hidden_timee').val();
                    d.user = $('#hidden_user').val();
                    d.permit = $('#hidden_permit').val();
                    d.status = $('#hidden_status').val();
                    d.type = $('#hidden_type').val();
                }
            },
            autoWidth: false,
            // "order": [],
            columns: [{
                    "data": "HEAD_FULLNAME"
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
                    "data": "USER_START_FULLNAME"
                },
                {
                    "data": "STATUS_SHOW"
                },
                {
                    "data": "ID"
                },
            ],
            "createdRow": function(row, data, index) {
                let table_btn_name =
                /* <li class="dropdown d-none d-lg-block">
                                            <a class="text-primary nav-link dropdown-toggle mr-0" data-toggle="dropdown"
                                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                                <!-- item-->
                                                <a href="#" data-toggle="modal" data-target="#detail-modal-meeting"
                                                    class="dropdown-item notify-item">
                                                    <span class="align-middle">รายละเอียด</span>
                                                </a>

                                                <!-- item-->
                                                <a href="#" data-toggle="modal" data-target="#update-modal-meeting"
                                                    class="dropdown-item notify-item">
                                                    <span class="align-middle">แก้ไข</span>
                                                </a>

                                                <!-- item-->
                                                <a href="#" class="dropdown-item notify-item btn-delete" data-id="3">
                                                    <span class="align-middle">ลบ</span>
                                                </a>

                                            </div>
                                        </li>
                 */
                    `
                    <div class="btn-group dropdown">
                    <a class="text-primary dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="" data-id="${data['ID']}" class="dropdown-item btn-detail-meeting" data-dismiss="modal">
                                <span class="align-middle">รายละเอียด</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${data['ID']}" class="dropdown-item btn-draft-meeting" data-toggle="modal" data-dismiss="modal">
                                <span class="align-middle">แก้ไข</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${data['ID']}" class="dropdown-item btn-delete" >
                                <span class="align-middle">ลบ</span>
                            </a>
                        </div>

                </div>

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
})
</script>

<?php
include APPPATH . "views/script/crud_modal.php";
?>