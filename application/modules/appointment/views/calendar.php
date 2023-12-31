<!-- <input type="hidden" name="my-id" id="my-id" value="<?= $_SESSION["user_code"] ?>"> -->
<input type="hidden" name="my-id" id="my-id" value="1">
<!-- Button trigger modal -->

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6" align="left">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal" class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#draft-modal">แบบร่าง</button>
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
                                <option value="<?= date('H:i', strtotime($times)) ?>"><?= date('H:i', strtotime($times)) ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="p-2">
                        <select class="form-control form-white select2" data-toggle="select2" id="user_create" name="user_create">
                            <option>ผู้สร้าง</option>
                            <?php
                            foreach ($staff as $data) {
                            ?>
                                <option value="<?= $data->ID ?>"><?= $data->NAME . " " . $data->LASTNAME ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="p-2">
                        <select class="form-control form-white" data-toggle="select2" id="status_complete" name="status_complete">
                            <option value="">สถานะ</option>
                            <option value="0">รอดำเนินการ</option>
                            <option value="1">นัดหมายสำเร็จ</option>
                            <option value="2">ยกเลิกการนัดหมาย</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary search"><i class="fa fa-search" aria-hidden="true"></i></button>
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
                if (dataArray[i].name == "insert-visitor") {
                    visitor.push(dataArray[i].value)
                } else {

                }
                data.append(dataArray[i].name, dataArray[i].value)
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

        async function get_data() {
            let url_calendar = new URL('appointment/ctl_calendar/get_data?id=' + my_id, domain);
            const response = await fetch(url_calendar, {})

            return response.json()
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
                        /* select: function(start, end, allDay) {
                            calendarSelect(start, end, allDay);
                        }, */
                        eventClick: function(calEvent, jsEvent, view) {
                            detail_meeting(calEvent, jsEvent, view);
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