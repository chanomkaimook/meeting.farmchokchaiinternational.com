<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6" align="left">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal" class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
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
                                <option value="<?= date('H:i', strtotime($times)) ?>"><?= date('H:i', strtotime($times)) ?></option>
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

                <br>

                <div class="row">
                    <div class="col-md-12">
                        <table id="data_table" class="table table-hover w-100">
                            <thead>
                                <tr>
                                    <th scope="col">ชื่อ-นามสกุล</th>
                                    <th scope="col">รายละเอียด</th>
                                    <th scope="col">วันที่</th>
                                    <th scope="col">เวลา</th>
                                    <th scope="col">ผู้สร้าง</th>
                                    <th scope="col">สถานะ</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                    <td scope="col">ชื่อ-นามสกุล</td>
                                    <td scope="col">รายละเอียด</td>
                                    <td scope="col">วันที่</td>
                                    <td scope="col">เวลา</td>
                                    <td scope="col">ผู้สร้าง</td>
                                    <td scope="col">สถานะ</td>
                                    <td scope="col"><a href=""><i class="mdi mdi-dots-vertical"></i></a></td>
                                </tr>
                                <tr>
                                    <td scope="col">ชื่อ-นามสกุล</td>
                                    <td scope="col">รายละเอียด</td>
                                    <td scope="col">วันที่</td>
                                    <td scope="col">เวลา</td>
                                    <td scope="col">ผู้สร้าง</td>
                                    <td scope="col">สถานะ</td>
                                    <td scope="col"><a href=""><i class="mdi mdi-dots-vertical"></i></a></td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
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
                                            foreach ($time as $value) {
                                                if (!$value["START"]) {
                                                    $times = $value["END"];
                                                } elseif (!$value["END"]) {
                                                    $times = $value["START"];
                                                } else {
                                                    $times = $value["START"];
                                                }
                                            ?>
                                                <option value="<?= date('H:i', strtotime($times)) ?>"><?= date('H:i', strtotime($times)) ?></option>
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
            $('#event-modal').find('.form').attr('data-action', 'insert')
        })

        $(btn_edit).click(function() {
            $('#event-modal').find('.form').attr('data-action', 'update')
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

         function get_data()
         {
            
         }

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
        let url = new URL('demo_appointment/ctl_datatable/get_datatable', domain);
        $('#data_table').DataTable({
            ajax: {
                url: url,
                type: "get",
                dataType: "json",
                data: function(d) {
                    d.date = $('#hidden_date').val();
                    d.time = $('#hidden_time').val();
                    d.visitor = $('#hidden_visitor').val();
                    d.status = $('#hidden_status').val();
                }
            },
            autoWidth: false,
            "order": [],
            columns: [{
                    "data": "FULLNAME"
                },
                {
                    "data": "EVENT_DESCRIPTION"
                },
                {
                    "data": "DATE_START"
                },
                {
                    "data": "TIME_START"
                },
                {
                    "data": "USER_CREATE"
                },
                {
                    "data": "STATUS_COMPLETE"
                },
                {
                    "data": "ID"
                },
            ],
            "createdRow": function(row, data, index) {
                let table_btn_name =
                    `
                 <a id="btn_doc" data-id="${data['EMP_ID']}" class="text-purple waves-effect mt-2 waves-light">${data['FULLNAME']}</a>
                 `
                $('td', row).eq(1).html(table_btn_name)
            },

            //  dom: datatable_dom,
            //  buttons: datatable_button,

        });

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
        function insert() {

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
        }
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