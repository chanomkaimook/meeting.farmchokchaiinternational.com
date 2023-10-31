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
            <div class="col-4">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal"
                    class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
                <button type="button" class="btn btn-secondary" data-toggle="modal"
                    data-target="#draft-modal">แบบร่าง</button>
            </div>

            <div class="col-8">
                <div class="filter-card">
                    <div class="d-flex flex-row justify-content-end">
                        <?php
                            include APPPATH . "views/partials/dom_filter_type.php";
                            include APPPATH . "views/partials/dom_filter_user.php";
                            include APPPATH . "views/partials/dom_filter_status.php";
                            include APPPATH . "views/partials/dom_filter_permit.php";
                        ?>
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                        <?php
                            include APPPATH . "views/partials/dom_filter_date.php";
                        ?>
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                        <?php
                            include APPPATH . "views/partials/dom_filter_time.php";
                        ?>
                        <button type="button" class="btn btn-secondary btn-search"><i class="fa fa-search"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
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

    /**
     *
     */

    /**
     *
     * EVENT CLICK
     *
     * 
     * BTN SEARCH
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
        
        calendarDestroy('#calendar', url_calendar, data)
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

    /**
     * 
     * 
     * BTN EDIT DRAFT
     * 
     * 
     */
    
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

    /**
     * 
     * 
     * BTN DRAFT TO USE
     * 
     * 
     */
    
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
     */

    /**
     *
     * ADDITIONAL FUNCTIONS
     *
     */

    function valid(type = null, data = []) {
        let dataAppend = new FormData(),
            visitor = [],
            countVal = 0;
        if (type == 'insert') {
            array = ['insert-name',
                'insert-head',
                'insert-rooms-id',
                'insert-description',
                'insert-dates',
                'insert-datee',
                'insert-times',
                'insert-timee'
            ]
            for (let i = 0; i < array.length; i++) {
                for (let s = 0; s < data.length; s++) {
                    if (data[s].name == array[i] && data[s].value != "") {
                        countVal++;
                    }
                }
            }
            if (countVal == array.length) {
                for (let i = 0; i < data.length; i++) {

                    if (data[i].name == "insert-type") {
                        dataAppend.append("insert-type-id", data[i].value)
                        dataAppend.append("insert-type-name", "นัดหมาย/จองห้องประชุม")
                    }
                    if (data[i].name == "insert-visitor") {
                        visitor.push(data[i].value)
                    }
                    dataAppend.append(data[i].name, data[i].value)

                }
                dataAppend.append("visitor", visitor)
                insert_meeting(dataAppend, "calendar")
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
                'update-description',
                'update-dates',
                'update-datee',
                'update-times',
                'update-timee'
            ]
            for (let i = 0; i < array.length; i++) {
                for (let s = 0; s < data.length; s++) {
                    if (data[s].name == array[i] && data[s].value != "") {
                        countVal++;
                    }
                }
            }
            if (countVal == array.length) {

                for (var i = 0; i < array.length; i++) {
                    if (data[i].name == "update-visitor") {
                        visitor.push(dataAppend[i].value)
                    }
                    dataAppend.append(data[i].name, data[i].value)
                }
                dataAppend.append("visitor", visitor)
                update_meeting(dataAppend, "calendar")

            }
        }
        if (countVal < array.length) {
            swal_alert('error', 'ไม่สำเร็จ', 'กรุณากรอกข้อมูลให้ครบก่อนบันทึก')
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
        let visitor = [],
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

    $(btn_delete).click(function(e) {
        e.preventDefault()
        let data = new FormData(),
            id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code')

        data.append('item_id', id)
        data.append('item_code', code)

        swal_delete(data)
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