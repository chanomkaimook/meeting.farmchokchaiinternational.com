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
<!-- Button trigger modal -->

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6" align="left">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal"
                    class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
                <button type="button" class="btn btn-secondary" data-toggle="modal"
                    data-target="#draft-modal">แบบร่าง</button>
            </div>
            <div class="col-lg-6" align="right">
                <input type="hidden" name="hidden_date" id="hidden_date">
                <input type="hidden" name="hidden_time" id="hidden_time">
                <input type="hidden" name="hidden_visitor" id="hidden_visitor">
                <input type="hidden" name="hidden_status" id="hidden_permit">

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
                        <select class="form-control form-white select2" data-toggle="select2" id="user" name="user">
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
                        <select class="form-control form-white" data-toggle="select2" id="permit" name="permit">
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
$(document).ready(function() {
    let my_id = $('#my-id').val();
    /**
     *
     * EVENT CLICK
     *
     */

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

    /**
     *
     * EVENT CHANGE
     *
     */

    $('#user').change(function() {
        let id = $(this).val()
        console.log(id)
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
     * Button modal
     *
     * #
     * # Properties Button
     * 1. btn_insert = button insert
     * 2. save_category = button save
     * 3. approve_footer = button approve,button not approve
     * 4. save_footer = button save,button close
     * 5. btn_unloading = button save in #detail-modal
     * 6. btn_loading = button save (spinner) in #detail-modal
     * 7. btn_edit = button edit in #detail-modal
     * 8. btn_delete = button delete in #detail-modal
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
    /* let save_category = '.save-category'
    let approve_footer = '.approve-footer'
    let save_footer = '.save-footer'
    let btn_edit = '.btn-edit'
    let btn_delete = '.btn-delete'
    let btn_unloading = '.unloading'
    let btn_loading = '.loading' */

    /**
     * CRUD
     *
     * #
     * # FUNCTION INSERT
     *
     *
     */
    $(btn_insert).click(function() {
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
    $(btn_draft_insert).click(function() {
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

    $(btn_update).click(function() {
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

    $(btn_delete).click(function() {
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code')

        data.append('item_id', id)
        data.append('item_code', code)

        swal_delete(data)
        // $("#detail-modal-meeting").modal("hide")
    })

    $(document).on('click', btn_reject, function() {
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

    $(document).on('click', btn_approve, function() {
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

    $(document).on('click', btn_disapprove, function() {
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

    $(document).on('click', btn_accept, function() {
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

        swal_confirm(text, color, func, data)
    })

    $(document).on('click', btn_defer, function() {
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

    $(document).on('click', btn_refuse, function() {
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

    $(document).on('click', btn_deny, function() {
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

    $(document).on('click', btn_success, function() {
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

    $(document).on('click', btn_cancle, function() {
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
     * function get data
     * #
     */

    createFullcalendar()
    createDraftModal()

    async function get_data() {
        let url_calendar = new URL('appointment/ctl_calendar/get_data?id=' + my_id, domain);
        let response = await fetch(url_calendar, {})

        return response.json()
    }

    async function get_data_draft(id = '') {
        let url_calendar = new URL('appointment/ctl_calendar/get_data_draft?id=' + my_id + '&event_id=' +
            id,
            domain);
        let response = await fetch(url_calendar, {})

        return response.json()
    }

    function createDraftModal(id) {
        get_data_draft(id)
            .then((data) => {
                let dataDefault = [];
                if (data.length) {
                    data.forEach(function(item, index) {
                        dataDefault.push(item);
                    })
                    detail_draft(dataDefault)
                }
            })
    }

    function createFullcalendar() {
        get_data()
            .then((data) => {
                let dataDefault = [];
                if (data.length) {
                    data.forEach(function(item, index) {
                        dataDefault.push(item);
                    })
                }
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    events: dataDefault,
                    timeFormat: "H:mm",
                    // droppable: true, // this allows things to be dropped onto the calendar !!!
                    // selectable: true,

                    /* drop: function(date) {
                        calendarDrop($(this), date);
                    }, */
                    // select: function(start, end, allDay) {
                    //     modal_insert(start, end, allDay);
                    // },
                    eventClick: function(calEvent, jsEvent, view) {
                        detail(calEvent, jsEvent, view);
                    },
                });
            })
    }
    /**
     * #
     * #
     */
})
</script>
<?php
include APPPATH . "views/script/crud_modal.php";
?>