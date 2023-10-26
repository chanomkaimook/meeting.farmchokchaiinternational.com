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
<!-- <input type="hidden" name="my-id" id="my-id" value="<?=$_SESSION["user_code"]?>"> -->
<input type="hidden" name="my-id" id="my-id" value="1">
<input type="hidden" name="event-id" id="event-id" value="">
<!-- Button trigger modal -->

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-4">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal"
                    class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
                <button type="button" class="btn btn-secondary" data-toggle="modal"
                    data-target="#draft-modal">แบบร่าง</button>
            </div>
            <div class="col-lg-8">
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
            <!-- end col-lg-10 -->
        </div>
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div id="calendar"></div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>

        </div>
    </div>
</div>

<?php
include "crud_modal.php";
?>
<script>
let my_id = $('#my-id').val();

let url_calendar = new URL('appointment/ctl_calendar/get_data?id=' + my_id, domain);
let url_draft = new URL('appointment/ctl_calendar/get_data_draft?id=' + my_id + '&event_id=', domain);

$(document).ready(function() {
    /**
     * #
     * function get data
     * #
     */
    createFullcalendar(url_calendar)
    createDraftModal(url_draft)

    function createDraftModal(url_draft) {
        get_data_draft(url_draft)
            .then((data) => {
                let dataDefault = [];
                if (data) {
                    data.forEach(function(item, index) {
                        dataDefault.push(item);
                    })
                    detail_draft(dataDefault)
                }
            })
    }
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


    $('#user').change(function() {
        let id = $(this).val()
        // console.log(id)
    })

    /**
     *
     * EVENT CLICK
     *
     */

    $(btn_search).click(function() {

        let data = new FormData()

        data.append('dates', $('#hidden_dates').val())
        data.append('datee', $('#hidden_datee').val())
        data.append('times', $('#hidden_times').val())
        data.append('timee', $('#hidden_timee').val())
        data.append('user', $('#hidden_user').val())
        data.append('permit', $('#hidden_permit').val())
        data.append('status', $('#hidden_status').val())
        data.append('type', $('#hidden_type').val())
        // calendar, url, filter = null
        calendarDestroy('#calendar', url_calendar, data)
        // createFullcalendar(data)
    })

    $(document).on('click', 'a.btn-detail-meeting', function() {
        let id = $(this).attr('data-id')
        let url_draft = new URL('appointment/ctl_calendar/get_data_draft?id=' + my_id + '&event_id=' +
            id, domain);
        get_data_draft(url_draft)
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
        let url_draft = new URL('appointment/ctl_calendar/get_data_draft?id=' + my_id + '&event_id=' +
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
                    draft_to_use(dataDefault, type)
                }
            })
    })

    $(document).on('click', 'a.btn-update-meeting', function() {
        let id = $(this).attr('data-id')
        let url_draft = new URL('appointment/ctl_calendar/get_data_draft?id=' + my_id + '&event_id=' +
            id, domain);
        get_data_draft(url_draft)
            .then((data) => {
                // console.log(data)
                let dataDefault;
                if (data.length) {
                    data.forEach(function(item, index) {
                        dataDefault = item
                    })
                    type = "use"
                    draft_to_use(dataDefault, type)
                }
            })
    })

    /**
     *
     * ADDITIONAL FUNCTIONS
     *
     */


    /* function calendarDestroy(calendar, filter = null) {
        $(calendar).fullCalendar('destroy');
        $(calendar).empty();
        if (filter) {
            createFullcalendar(filter)
        } else {
            createFullcalendar()
        }
    } */


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
        let visitor = [],array=[],dataDefault=[],
            data = new FormData(),
            dataArray = $('#insert-meeting').serializeArray()

            dataArray.forEach(function(item, index) {
                    dataDefault.push(item);
                })
        for (var i = 0; i < dataArray.length; i++) {
            if (dataArray[i].name == "insert-type") {
                data.append("insert-type-id", dataArray[i].value)
                data.append("insert-type-name", "นัดหมาย/จองห้องประชุม")
            }
            if (dataArray[i].name == "insert-visitor") {
                visitor.push(dataArray[i].value)
            }
            array.push(dataArray[i].name, dataArray[i].value)
            // data.append(dataArray[i].name, dataArray[i].value)
        }
        // data.append(dataDefault)
        console.log(array)
        console.log(array.length)
        console.log(dataDefault)
        console.log(dataDefault.length)
        console.log(data)
        return false
        data.append("visitor", visitor)
        /* 
        $type_id = $data['insert-type-id'];
            $type_name = $data['insert-type-name'];
            $event_name = $data['insert-name'];
            $staff_id = $data['insert-head'];
            $event_description = $data['insert-description'];
            $date_begin = $data['insert-dates'];
            $date_end = $data['insert-datee'];
            $time_begin = $data['insert-times'];
            $time_end = $data['insert-timee'];
            $rooms_id = $data['insert-rooms-id'];
            $rooms_name = $data['insert-rooms-name'];
            $car_id = $data['insert-car-id'];
            $car_name = $data['insert-car-name'];
            $driver_id = $data['insert-driver-id'];
            $driver_name = $data['insert-driver-name'];
        */
        /* if (dataArray.length < 10) {
            swal_alert('error', 'ไม่สำเร็จ', 'กรุณากรอกข้อมูลให้ครบ')
        } else {

        insert_meeting(data, "calendar")
        } */
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
     * #
     * #
     */
})
</script>
<?php
include APPPATH . "views/script/crud_modal.php";
include APPPATH . "views/script/calendar.php";
?>