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
let url_datatable = new URL('appointment/ctl_datatable/get_data', domain);
url_datatable.searchParams.append('id', $('#my-id').val())

var filterArray = []
filterArray.push({
    dates: null,
    datee: null,
    times: null,
    timee: null,
    user: null,
    permit: null,
    status: null,
    type: null,
})
$(document).ready(function() {
    // let my_id = $('#my-id').val();
    createDatatable(url_datatable, '#data_table', filterArray)
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
     * EVENT CLICK
     *
     */

    $(btn_search).click(function() {
        $('#data_table').DataTable().ajax.reload()
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
                    draft_to_use(dataDefault, type)
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
                    draft_to_use(dataDefault, type)
                }
            })
    })
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

})
</script>

<?php
include APPPATH . "views/script/crud_modal.php";
include APPPATH . "views/script/datatable.php";
?>