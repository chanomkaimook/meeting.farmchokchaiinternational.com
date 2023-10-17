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
     */
    /**
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

    let btn_insert = '#btn-insert'
    let save_category = '.save-category'
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
    // console.log($('select[name=select-visitor]'))

    // select2
    $('[data-toggle=select2]').select2({
        theme: "bootstrap"
    });

    // inisialize datepicker
    $('.datepicker-autoclose').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
    });

    /*
    function createFullcalendar() {
        get_data()
            .then((data) => {
                let dateDefault = [];
                // console.log(data)
                test()
                async function test(userid) {
                    let doing1 = await new Promise((resolve, reject) => {
                        resolve(
                            let setArray = [];

                            setArray = {
                                id: item.ID,
                                sid: item.STAFF_ID,
                                title_id: item.DESCRIPTION_ID,
                                title: item.DESCRIPTION,
                                start: item.DATESTART,
                                end: item.DATE_END_FAKE,
                                end_real: item.DATEEND,
                                status: item.STATUS,
                                total: item.TOTAL,
                                name: item.NAME,
                                lastname: item.LASTNAME,
                                className: event_color,
                                owner1: item.OWNER1,
                                owner2: item.OWNER2,
                                owner3: item.OWNER3,
                                date1: item.DATE1,
                                date2: item.DATE2,
                                date3: item.DATE3,
                                child: item.CHILD,
                                approve: item.STATUS_APPROVE,
                                status: item.STATUS,
                                maxdate: item.MAXDATE,

                                hrs: item.HRS,
                                hre: item.HRE,
                                mins: item.MINS,
                                mine: item.MINE,
                                period: item.PERIOD,
                            }; dateDefault.push(setArray);
                        )
                    })
                    let doing2 = await new Promise((resolve, reject) => {
                        $('#calendar').fullCalendar({
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            editable: true,
                            eventLimit: true, // allow "more" link when too many events
                            events: dateDefault,
                            timeFormat: "H:mm",
                            droppable: true, // this allows things to be dropped onto the calendar !!!
                            selectable: true,

                            drop: function(date) {
                                calendarDrop($(this), date);
                            },
                            select: function(start, end, allDay) {
                                calendarSelect(start, end, allDay);
                            },
                            eventClick: function(calEvent, jsEvent, view) {
                                calendarClick(calEvent, jsEvent, view);
                            },
                        });
                    })
                }

            });
    } */

    createFullcalendar()
    /**
     * #
     * function get data
     * #
     */
    async function get_data() {
        let url_calendar = new URL('appointment/ctl_calendar/get_data?id=' + my_id, domain);
        const response = await fetch(url_calendar, {})

        return response.json()
    }
    /**
     * #
     * #
     */
    function createFullcalendar() {
        get_data()
            .then((data) => {
                let setArray = [],
                    dataDefault = [];
                // console.log(data)
                if (data.length) {
                    data.forEach(function(item, index) {
                        // console.log(item)
                        // console.log(index)
                        item.forEach(function(val, key) {
                            // console.log(val)
                            // console.log(key)

                            setArray = {
                                id: val.ID,
                                sid: val.STAFF_ID,
                                title_id: val.TYPE_ID,
                                title: val.TYPE_NAME,
                                topic: val.EVENT_NAME,
                                description: val.EVENT_DESCRIPTION,
                                start: val.DATE_BEGIN,
                                end: val.DATE_END,
                                status: val.STATUS_COMPLETE,
                                status_name: val.STATUS_COMPLETE_NAME,
                                approve_date: val.APPROVE_DATE,
                                disapprove_date: val.DISAPPROVE_DATE,
                                cancle_date: val.CANCLE_DATE,
                                action: val.USER_ACTION,
                            };
                            dataDefault.push(setArray);
                        })
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
                        calendarClick(calEvent, jsEvent, view);
                    },
                });
            })
    }

    function calendarClick(calEvent, jsEvent, view) {
        if (calEvent.title_id == 1) {
            $("#detail-modal-meeting").modal("show")

        } else {
            $("#detail-modal-car").modal("show")

        }
        console.log(calEvent)
    }

    /* function calendarSelect(start, end, allDay) {
        $("#detail-modal").modal("show")
    } */
})
</script>