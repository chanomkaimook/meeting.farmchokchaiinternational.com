<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-2">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#event-modal" class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
            </div>
            <div class="col-lg-10 text-right">
                <!-- <a id="btn-insert" href="#" data-toggle="modal" data-target="#event-modal" class="btn btn-lg btn-primary btn-block waves-effect mt-2 waves-light">
                            <i class="fa fa-plus"></i> Booking
                        </a> -->
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

            <!-- BEGIN MODAL -->
            <div class="modal fade none-border" id="detail-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <div class="d-flex">
                                <div>
                                    <h4 class="modal-title">Booking</h4>
                                </div>
                                <div id="action-header" class="pl-2">
                                    <button type="button" class="btn btn-icon waves-effect btn-warning btn-edit" data-edit="true"> <i class="fas fa-edit"></i> </button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-delete" data-dismiss="modal"> <i class="fas fa-trash-alt"></i> </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body pb-0">

                            <div class="detail-visitor">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ปิด</button>
                                <div class="approve-footer">
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-disapprove" data-event-id="" data-dismiss="modal">ไม่อนุมัติ</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light btn-approve" data-event-id="" data-dismiss="modal">อนุมัติ</button>
                                </div>
                                <div class="save-footer">
                                    <button type="button" class="btn btn-success save-event waves-effect waves-light unloading">บันทึก</button>
                                    <button type="button" class="btn btn-success save-event waves-effect waves-light loading d-none" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        กำลังบันทึก
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal Add Category -->
            <div class="modal fade none-border" id="event-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Booking</h4>
                        </div>
                        <div class="modal-body pb-0">
                            <form class="form" data-action="">
                                <div class="form-group">
                                    <label class="control-label">หัวข้อกิจกรรม/การประชุม</label>
                                    <input class="form-control form-white" placeholder="Enter name" type="text" name="event-name" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">โดย</label>
                                    <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="event-staff">
                                        <option value="1">นาย A</option>
                                        <option value="2">นาย B</option>
                                        <option value="3">นาย C</option>
                                        <option value="4">นาย D</option>
                                        <option value="5">นาย E</option>
                                        <option value="6">นาย F</option>
                                        <option value="7">นาย G</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">เนื้อหาการประชุม</label>
                                    <textarea placeholder="Enter name" class="form-control form-white" name="event-description" cols="30" rows="5"></textarea>
                                </div>
                                <div class="form-group mb-3 d-flex flex-row">
                                    <div class="col-md-6">
                                        <label class="control-label">วันที่</label>
                                        <input type="text" class="form-control datepicker-autoclose" placeholder="yyyy-mm-dd" name="event-date">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">เวลา</label>
                                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="event-time">
                                            <option selected disabled>กรุณาเลือก...</option>
                                            <?php
                                            foreach ($time as $val) {
                                                if (!$val["START"]) {
                                                    $time = $val["END"];
                                                } elseif (!$val["END"]) {
                                                    $time = $val["START"];
                                                } else {
                                                    $time = $val["START"];
                                                }
                                            ?>
                                                <option value="<?= date('H:i', strtotime($time)) ?>"><?= date('H:i', strtotime($time)) ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">ผู้เข้าร่วม</label>
                                    <select class="form-control form-white" name="select-visitor"><!--  data-role="tagsinput" multiple -->
                                        <option value="1">นาย A</option>
                                        <option value="2">นาย B</option>
                                        <option value="3">นาย C</option>
                                        <option value="4">นาย D</option>
                                        <option value="5">นาย E</option>
                                        <option value="6">นาย F</option>
                                        <option value="7">นาย G</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MODAL -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

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
        $(btn_insert).click(function() {
            $('#event-modal').find('.form').attr('data-action', 'insert')
        })

        // inisialize datepicker
        $('.datepicker-autoclose').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
        });

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            // events: dateDefault,
            timeFormat: "H:mm",
            droppable: true, // this allows things to be dropped onto the calendar !!!
            selectable: true,

            /* drop: function(date) {
                calendarDrop($(this), date);
            }, */
            select: function(start, end, allDay) {
                calendarSelect(start, end, allDay);
            },
            /* eventClick: function(calEvent, jsEvent, view) {
                calendarClick(calEvent, jsEvent, view);
            }, */
        });

        function calendarSelect(start, end, allDay) {
            $("#detail-modal").modal("show")
        }
    })
</script>