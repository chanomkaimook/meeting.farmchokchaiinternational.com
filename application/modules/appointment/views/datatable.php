<style>
.bg-pending-soft {
    background-color: rgba(255, 176, 4, .5) !important;
}

.bg-pending {
    background-color: rgba(255, 176, 4, 1) !important;
}

.bg-success-soft {
    background-color: rgba(0, 194, 40, .5) !important
}

.bg-success {
    background-color: rgba(0, 194, 40, 1) !important
}

.bg-failure-soft {
    background-color: rgba(192, 10, 0, .5) !important;
}

.bg-failure {
    background-color: rgba(192, 10, 0, 1) !important;
}

.bg-other {
    background-color: rgba(135, 16, 214, .5) !important;
}

.bg-process {
    background-color: rgba(214, 106, 16, 1) !important;
}

.bg-cancle {
    background-color: rgba(115, 115, 115, .5) !important;
}

.text-orange {
    color: rgba(214, 106, 16, 1) !important;
}

#draft-modal .modal-body,
div.table-responsive {
    min-height: 30rem !important;
}
</style>

<input type="hidden" name="my-id" id="my-id" value="<?=$_SESSION["user_code"]?>">
<!-- <input type="hidden" name="my-id" id="my-id" value="1"> -->
<input type="hidden" name="event-id" id="event-id" value="">
<!-- Button trigger modal -->

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                <?//=print_r($_SESSION)?>
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal"
                    class="btn-lg btn-primary"><i class="fa fa-plus"></i> Booking</button>
                <button type="button" id="btn-tab-content" data-toggle="modal" data-target="#modal-tab-content"
                    class="btn-lg btn-primary"><i class="mdi mdi-inbox-multiple"></i> ตรวจสอบคิว</button>
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#draft-modal">แบบร่าง</button> -->
            </div>

            <div class="col-8">
                <div class="row justify-content-end">
                    <?php
                        include APPPATH . "views/partials/dom_filter_type.php";
                        include APPPATH . "views/partials/dom_filter_user.php";
                        include APPPATH . "views/partials/dom_filter_status.php";
                        include APPPATH . "views/partials/dom_filter_permit.php";
                        ?>
                </div>
                <div class="row justify-content-end">
                    <?php
                        include APPPATH . "views/partials/dom_filter_date.php";
                        ?>
                </div>
                <div class="row justify-content-end">
                    <?php
                        include APPPATH . "views/partials/dom_filter_time.php";
                        ?>
                    <button type="button" class="btn btn-secondary btn-search"><i class="fa fa-search"
                            aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <br>
                <style>
                @media print {
                    #data_table {
                        display: none;
                    }
                }
                </style>
                <div class="row">
                    <div class="col-md-12">
                        <table id="data_table" class="table table-hover w-100 dt-responsive nowrap">
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
let my_id = $('#my-id').val();
let url_main = new URL('appointment/ctl_datatable/get_data', domain);
url_main.searchParams.append('id', $('#my-id').val())

let url_draft = new URL('appointment/ctl_datatable/get_data_draft?id=' + my_id + '&event_id=', domain);

$(document).ready(function() {
    // let my_id = $('#my-id').val();
    createDatatable(url_main)
    createDraftModal(url_draft)
    
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
     *
     * HEAD <> VISITOR
     */

     $("select[name=insert-head]").change(function() {
            $('select[name=insert-visitor]').empty()

        let sid = $(this).val(),
            eid = $(this).find('option[value=' + sid + ']').attr('data-employee-id');

            get_employee(eid).then((resp) => {
            let visitor = ''
            $.each(resp, function(index, item) {
                visitor +=
                    `<option value="${item.ID}">${item.NAME + " " + item.LASTNAME}</option>`
            })
            $('select[name=insert-visitor]').html(visitor)
        })
    })
    
    $("select[name=update-head]").change(function() {
            $('select[name=update-visitor]').empty()

        let sid = $(this).val(),
            eid = $(this).find('option[value=' + sid + ']').attr('data-employee-id');

        get_employee(eid).then((resp) => {
            let visitor = ''
            $.each(resp, function(index, item) {
                visitor +=
                    `<option value="${item.ID}">${item.NAME + " " + item.LASTNAME}</option>`
            })
            $('select[name=update-visitor]').html(visitor)
        })
    })

    /**
     *
     * EVENT CLICK
     *
     * 
     * BTN SEARCH
     */

    $(btn_search).click(function() {

        reloadData(url_main)
    })

    /**
     * 
     * 
     * BTN DETAIL DRAFT
     * 
     * 
     */

    $(document).on('click', 'a.btn-detail-meeting', function() {
        let id = $(this).attr('data-id')
        let url_draft = new URL('appointment/ctl_datatable/get_data_draft?id=' + my_id + '&event_id=' +
            id, domain);
        get_data_draft(url_draft)
            .then((data) => {
                let dataDefault;
                if (data.length) {
                    data.forEach(function(item, index) {
                        dataDefault = item
                    })
                    modal_show("#detail-modal-meeting")
                    form_displayed(dataDefault)
                }
            })
    })

    /**
     * 
     * 
     * BTN EDIT DRAFT
     * 
     * 
     */

    $(document).on('click', 'a.btn-draft-meeting', function() {
        let id = $(this).attr('data-id')
        let url_draft = new URL('appointment/ctl_datatable/get_data_draft?id=' + my_id + '&event_id=' +
            id, domain);
        get_data_draft(url_draft)
            .then((data) => {
                // console.log(data)
                let dataDefault;
                if (data.length) {
                    data.forEach(function(item, index) {
                        dataDefault = item
                    })
                    type = "draft"
                    form_displayed(dataDefault)
                    modal_show("#update-modal-meeting")
                }
            })
    })

    /**
     * 
     * 
     * BTN DRAFT TO USE
     * 
     * 
     */

    $(document).on('click', 'a.btn-update-meeting', function() {
        let id = $(this).attr('data-id')
        let url_draft = new URL('appointment/ctl_datatable/get_data_draft?id=' + my_id + '&event_id=' +
            id, domain);
        get_data_draft(url_draft)
            .then((data) => {
                // console.log(data)
                let dataDefault, type_name = '';
                if (data.length) {
                    data.forEach(function(item, index) {
                        for (let i = 10; i < item['TYPE_NAME'].length; i++) {
                            type_name += item['TYPE_NAME'][i]
                        }
                        item['STATUS_COMPLETE'] = 1
                        item['TYPE_ID'] -= 3
                        item['TYPE_NAME'] = type_name
                        item['class'] = 'me'

                        dataDefault = item
                        console.log(item)
                    })
                    type = "use"
                    form_displayed(dataDefault)
                    modal_show("#update-modal-meeting")
                }
            })
    })

    /**
     *
     */

    /**
     *
     * ADDITIONAL FUNCTIONS
     *
     *
     * # GET EMPLOYEE 
     * (HEAD <> VISITOR)
     * 
     *
     */

     async function get_employee(eid = null) {
        let url = new URL("appointment/ctl_calendar/get_employee", domain),
            data = new FormData();
        data.append('employee_id', eid)
        let respond = await fetch(url, {
            method: 'post',
            body: data
        })

        return respond.json();

    }

    /**
     *
     *
     * # VALIDATION FUNCTION
     *
     *
     */

     function valid(type = null, data = []) {
        let dataAppend = new FormData(),
            visitor = [],
            attr_error = [],
            error = 0,
            arrayLength = 0,
            countVal = 0;
        if (type == 'insert') {
            array = ['insert-name',
                'insert-head',
                'insert-rooms-name',
                'insert-description',
                'insert-dates',
                'insert-datee',
                'insert-times',
                'insert-timee'
            ]
            for (let i = 0; i < array.length; i++) {
                for (let s = 0; s < data.length; s++) {
                    if (data[s].name == array[i] && data[s].value != "") {
                        error[array[i]] = 0;
                        break;
                    }

                    if (data[s].name == array[i] && data[s].value == "" || data[s].name != array[i]) {
                        error[array[i]] = 1
                    }
                }
            }

            if (!error) {
                for (let i = 0; i < data.length; i++) {
                    if (data[i].name == "insert-visitor") {
                        visitor.push(data[i].value)
                    }
                    dataAppend.append(data[i].name, data[i].value)

                }
                dataAppend.append("visitor", visitor)
                insert_meeting(dataAppend, "ctl_datatable")
            }
        } else if (type == 'update') {
            array = ['item_id',
                'code',
                'update-type-id',
                'update-type-name',
                'update-name',
                'update-head',
                'update-rooms-id',
                'update-rooms-name',
                'update-meeting-id',
                'update-meeting-name',
                'update-description',
                'update-dates',
                'update-datee',
                'update-times',
                'update-timee'
            ]

            for (let i = 0; i < array.length; i++) {
                for (let s = 0; s < data.length; s++) {
                    if (data[s].name == array[i] && data[s].value != "") {
                        error[array[i]] = 0;
                        break;
                    }

                    if (data[s].name == array[i] && data[s].value == "" || data[s].name != array[i]) {
                        error[array[i]] = 1
                    }
                }
            }

            if (!error) {

                for (var i = 0; i < data.length; i++) {
                    $v = 0;
                    if (data[i].name == "update-visitor") {
                        let vis_data = [];
                        vis_data["id"] = data[i].value
                        vis_data["status"] = $('[name=' + data[i].name + ']').find('option[value=' + data[i]
                            .value + ']').attr('data-status')
                        visitor.push(vis_data["id"] + "-" + vis_data["status"])
                    } else {
                        dataAppend.append(data[i].name, data[i].value)
                    }
                }
                // console.log(visitor)
                dataAppend.append("visitor", visitor)
                update_meeting(dataAppend,"ctl_datatable")

            }
        }
        if (error) {
            Swal.fire('ไม่สำเร็จ', 'กรุณากรอกข้อมูลให้ครบก่อนบันทึก', 'error')
        }
    }

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
        dataDefault = [],
            data = new FormData(),

            dataArray = $('#insert-meeting').serializeArray()

        dataArray.forEach(function(item, index) {
            dataDefault.push(item);
        })
        valid("insert", dataDefault)
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

            if (dataArray[i].name == "insert-type-id") {
                data.append("insert-type-id", Number.parseInt(dataArray[i].value) + 3)
            }
            if (dataArray[i].name == "insert-type-name") {
                data.append("insert-type-name", "แบบร่างการ" + dataArray[i].value)
            }
            if (dataArray[i].name == "insert-visitor") {
                visitor.push(dataArray[i].value)
            }
        }
        data.append("visitor", visitor)
        // console.log(data)
        insert_meeting(data, "ctl_datatable")
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
            dataDefault = [],
            data = new FormData(),

            dataArray = $('#update-meeting').serializeArray()

        dataArray.forEach(function(item, index) {
            dataDefault.push(item);
        })
        valid("update", dataDefault)
    })

    /**
     *
     *
     * #
     * # FUNCTION DELETE
     *
     *
     */

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

        swal_delete(data,"ctl_datatable")
    })

    $(document).on('click', btn_delete, function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code');

        data.append('item_id', id)
        data.append('item_code', code)

        swal_delete(data,"ctl_datatable")
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

        swal_confirm(text, color, func, data,"ctl_datatable")
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

        swal_confirm(text, color, func, data,"ctl_datatable")
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

        swal_confirm(text, color, func, data,"ctl_datatable")
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

        swal_confirm(text, color, func, data,"ctl_datatable")
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

        swal_confirm(text, color, func, data,"ctl_datatable")
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

        swal_confirm(text, color, func, data,"ctl_datatable")
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

        swal_confirm(text, color, func, data,"ctl_datatable")
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

        swal_confirm(text, color, func, data,"ctl_datatable")
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

    // set Date End >= Date Start
    $(document).on('change', '[name=insert-datee]', function() {
        set_date('[name=insert-dates]', '[name=insert-datee]')
    })
    $(document).on('change', '[name=insert-dates]', function() {
        set_date('[name=insert-dates]', '[name=insert-datee]')
    })

    $(document).on('change', '[name=update-datee]', function() {
        set_date('[name=update-dates]', '[name=update-datee]')
    })
    $(document).on('change', '[name=update-dates]', function() {
        set_date('[name=update-dates]', '[name=update-datee]')
    })

    function set_date(dates, datee) {
        let date_start = $(dates).val()
        let date_end = $(datee).val()

        if (date_end < date_start) {
            $(datee).datepicker('setDate', new Date(date_start));
        }
    }

    // set Time End >= Time Start
    $(document).on('change', '[name=insert-timee]', function() {
        set_time('[name=insert-times]', '[name=insert-timee]')
    })
    $(document).on('change', '[name=insert-times]', function() {
        set_time('[name=insert-times]', '[name=insert-timee]')
    })

    $(document).on('change', '[name=update-timee]', function() {
        set_time('[name=update-times]', '[name=update-timee]')
    })
    $(document).on('change', '[name=update-times]', function() {
        set_time('[name=update-times]', '[name=update-timee]')
    })

    function set_time(times, timee) {
        let time_start = $(times).val()
        let time_end = $(timee).val()
        let time_start_option = $(times).find('option')
        let time_end_option = $(timee).find('option')
        let length = $(timee).find('option').length

        for (let i = 0; i < length; i++) {

            if (time_start) {
                if ($(timee).find('option[data-tid=' + i + ']').val() <= time_start) {
                    $(timee).find('option[data-tid=' + i + ']').addClass('d-none')
                }
            } else {
                $(timee).find('option[data-tid=' + i + ']').removeClass('d-none')
            }

        }

    }

    /**
     * #
     * #
     */
})
</script>
</script>

<?php
// include APPPATH . "views/script/crud_modal.php";
include APPPATH . "views/script/modal_manages.php";
include APPPATH . "views/script/form_manage.php";
include APPPATH . "views/script/btn_manage.php";
include APPPATH . "views/script/datatable.php";
include APPPATH . "views/script/sendMessage.php";
include APPPATH . "views/script/pushMessage.php";
?>