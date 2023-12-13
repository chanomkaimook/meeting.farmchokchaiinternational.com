<!-- READ Modal -car- -->
<div class="modal fade none-border" id="detail-modal-car" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-modal-hide="#detail-modal-car" data-dismiss="modal"
                    aria-label="Close">&times;</button>
                <div class="d-flex">
                    <div>
                        <h4 class="modal-title">Booking</h4>
                    </div>
                    <div id="action-header" class="pl-4">
                        <h4 class="modal-title text-warning">รอดำเนินการ</h4>
                        <!-- <button type="button" class="btn btn-icon waves-effect btn-warning btn-edit" data-edit="true">
                            <i class="fas fa-edit"></i> </button>
                        <button type="button" class="btn btn-danger waves-effect waves-light btn-delete"
                            data-dismiss="modal"> <i class="fas fa-trash-alt"></i> </button> -->
                    </div>
                </div>
            </div>

            <div class="modal-body pb-0">
                <form class="form" id="detail-car">
                    <div class="form-group">
                        <label class="control-label">ประเภท</label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="detail-type"
                            disabled>
                            <option selected value="กิจกรรม">กิจกรรม</option>
                            <option value="ประชุม">ประชุม</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">หัวข้อ <span class="text-danger">*</span></label>
                        <input autocomplete="off" class="form-control form-white" placeholder="Enter name" type="text"
                            value="เก็บหิน สนง.ฟาร์ม" name="detail-name" disabled />
                    </div>
                    <div class="form-group">
                        <label class="control-label">นำโดย <span class="text-danger">*</span> </label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="detail-head"
                            disabled>
                            <option value="1">นาย A</option>
                            <option value="2">นาย B</option>
                            <option value="3">นาย C</option>
                            <option value="4">นาย D</option>
                            <option value="5">นาย E</option>
                            <option value="6">นาย F</option>
                            <option selected value="7">นาย G</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">เนื้อหาการประชุม</label>
                        <textarea maxlength="150" placeholder="Enter name" class="form-control form-white"
                            name="detail-description" cols="30" rows="5"
                            disabled>กิจกรรมเก็บหินที่สำนักงานฟาร์ม เดินทางนำโดยรถตู้บริษัท ทะเบียน กข1234 นำทีมนำโดย นาย G</textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="control-label">วันที่</label>
                            <input autocomplete="off" type="text" class="form-control datepicker-autoclose"
                                value="2023-10-02" placeholder="yyyy-mm-dd" name="detail-date" disabled>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="control-label">เวลา</label>
                            <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="detail-time"
                                disabled>
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
                                <option selected value="<?=date('H:i:s', strtotime($times))?>"
                                    data-tid="<?=$value["ID"]?>">
                                    <?=date('H:i', strtotime("7.00"))?></option>
                                <?php
}
?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group d-none" data-visitor="true">
                        <label class="control-label">ผู้เข้าร่วม</label>
                        <!-- <input autocomplete="off" type="text" value="" data-role="tagsinput" name="detail-visitor" disabled /> -->
                        <select class="form-control select2-multiple" data-toggle="select2" multiple="multiple"
                            name="update-visitor">
                            <option value="">ระบูรายชื่อ</option>
                            <?php foreach ($employee as $emp) {
    ?>
                            <option value="<?=$emp->ID?>"><?=$emp->NAME . " " . $emp->LASTNAME?></option>
                            <?php
}?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ปิด</button>
                <div class="approve-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light btn-disapprove"
                        data-event-id="" data-dismiss="modal">ไม่เข้าร่วม</button>
                    <button type="button" class="btn btn-success waves-effect waves-light btn-approve" data-event-id=""
                        data-dismiss="modal">เข้าร่วม</button>
                </div>
                <div class="save-footer">
                    <button type="button"
                        class="btn btn-success save-event waves-effect waves-light unloading">บันทึก</button>
                    <button type="button" class="btn btn-success save-event waves-effect waves-light loading d-none"
                        disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span>
                        กำลังบันทึก
                    </button>
                </div>
                <!-- <div class="action-footer">

                </div> -->
            </div>

        </div>
    </div>
</div>
<!-- END READ Modal -car- -->

<!-- READ Modal -meeting- -->
<div class="modal fade none-border" id="detail-modal-meeting" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-modal-hide="#detail-modal-meeting" data-dismiss="modal"
                    aria-label="Close">&times;</button>
                <h4 class="modal-title-status text-secondary test-center"> การนัดหมายกิจกรรม #<span
                        class="event_code"></span></h4>
                <div class="card_status">
                    <h5 class="modal-title-status text-warning test-center d-none" data-status="1"> รอดำเนินการ</span></h5>
                    <h5 class="modal-title-status text-success test-center d-none" data-status="2"> ดำเนินการสำเร็จ</span></h5>
                    <h5 class="modal-title-status text-danger test-center d-none" data-status="3"> ดำเนินการไม่สำเร็จ</span></h5>
                    <h5 class="modal-title-status text-secondary test-center d-none" data-status="4"> ยกเลิก</span></h5>
                    <h5 class="modal-title-status text-warning test-center d-none" data-status="5"> กำลังดำเนินการ</span></h5>
                </div>
            </div>

            <div class="modal-body pb-0">
                <form class="form" id="detail-meeting">
                    <div class="form-group">
                        <label class="control-label">หัวข้อ <span class="text-danger">*</span></label>
                        <!-- <p class="detail-name"></p> -->
                        <input autocomplete="off" class="form-control form-white" placeholder="Enter topic" type="text"
                            value="" name="detail-name" disabled />
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="control-label">นำโดย <span class="text-danger">*</span> </label>
                            <!-- <p class="detail-head" ></p> -->

                            <select class="form-control form-white" name="detail-head" disabled>
                                <?php
// print_r($employee);
foreach ($employee as $val) {
    ?>
                                <option value="<?=$val->ID;?>"><?=$val->NAME . " " . $val->LASTNAME;?>
                                </option>
                                <?php
}
?>
                            </select>
                        </div>

                        <div class="col-6 mb-2 status-inline d-none">
                            <label class="control-label invisible">status</label>
                            <input autocomplete="off" class="form-control" name="status-inline-text" value="" disabled>
                        </div>

                    </div>

                    <!-- ************************************************************************************** -->
                    <div class="form-group meeting-line d-none">
                        <label class="control-label">สถานที่</label>
                        <!-- <p class="detail-rooms"></p> -->
                        <input autocomplete="off" class="form-control form-white" placeholder="Enter topic" type="text"
                            value="" name="detail-rooms-name" disabled />
                    </div>
                    <!-- ************************************************************************************** -->

                    <div class="form-group">
                        <label class="control-label">เนื้อหาการนัดหมายกิจกรรม</label>
                        <!-- <p class="detail-description"></p> -->
                        <textarea maxlength="150" placeholder="Enter name" class="form-control form-white"
                            name="detail-description" cols="30" rows="5" disabled></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="control-label">ตั้งแต่</label>
                            <!-- <p class="detail-dates"></p> -->
                            <input autocomplete="off" type="text" class="form-control datepicker-autoclose" value=""
                                placeholder="yyyy-mm-dd" name="detail-dates" disabled>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="control-label">ถึง</label>
                            <!-- <p class="detail-datee"></p> -->
                            <input autocomplete="off" type="text" class="form-control datepicker-autoclose" value=""
                                placeholder="yyyy-mm-dd" name="detail-datee" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="control-label">ตั้งแต่</label>
                            <!-- <p class="detail-times"></p> -->
                            <input autocomplete="off" type="text" class="form-control" value="" placeholder="08:00"
                                name="detail-times" disabled>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="control-label">ถึง</label>
                            <!-- <p class="detail-timee"></p> -->
                            <input autocomplete="off" type="text" class="form-control" value="" placeholder="17:30"
                                name="detail-timee" disabled>
                        </div>
                    </div>
                    <div class="form-group d-none" data-visitor="true">
                        <h5 class="control-h5">ผู้เข้าร่วม</h5>
                        <h5 class="visitor-name">

                        </h5>
                    </div>
                    <div class="form-group" data-user-start="true">
                        <label class="control-label">ผู้สร้างแบบฟอร์ม</label>
                        <p class="user-start-name">

                        </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ปิด</button>
                <div class="action-footer">

                </div>
            </div>

        </div>
    </div>
</div>
<!-- END READ Modal -meeting- -->

<!-- READ Modal -meeting- -->
<div class="modal fade none-border" id="detail-modal-room" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-modal-hide="#detail-modal-room" data-dismiss="modal"
                    aria-label="Close">&times;</button>
                <h4 class="modal-title-status text-secondary test-center"> การจองห้องประชุม #<span
                        class="event_code"></span></h4>
                <div class="card_status">
                    <h5 class="modal-title-status text-warning test-center d-none" data-status="1"> รอดำเนินการ</span></h5>
                    <h5 class="modal-title-status text-success test-center d-none" data-status="2"> ดำเนินการสำเร็จ</span></h5>
                    <h5 class="modal-title-status text-danger test-center d-none" data-status="3"> ดำเนินการไม่สำเร็จ</span></h5>
                    <h5 class="modal-title-status text-secondary test-center d-none" data-status="4"> ยกเลิก</span></h5>
                    <h5 class="modal-title-status text-warning test-center d-none" data-status="5"> กำลังดำเนินการ</span></h5>
                </div>
            </div>

            <div class="modal-body pb-0">
                <form class="form" id="detail-room">
                    <div class="form-group">
                        <label class="control-label">หัวข้อ <span class="text-danger">*</span></label>
                        <!-- <p class="detail-name"></p> -->
                        <input autocomplete="off" class="form-control form-white" placeholder="Enter topic" type="text"
                            value="" name="detail-name" disabled />
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="control-label">นำโดย <span class="text-danger">*</span> </label>
                            <!-- <p class="detail-head" ></p> -->

                            <select class="form-control form-white" name="detail-head" disabled>
                                <option disabled selected>กรุณาเลือก...</option>
                                <?php
// print_r($employee);
foreach ($employee as $val) {
    ?>
                                <option value="<?=$val->ID;?>"><?=$val->NAME . " " . $val->LASTNAME;?>
                                </option>
                                <?php
}
?>
                            </select>
                        </div>

                        <!-- ************************************************************************************** -->
                        <div class="col-6 mb-2 status-inline d-none">
                            <label class="control-label invisible">status</label>
                            <input autocomplete="off" class="form-control" name="status-inline-text" value="" disabled>
                        </div>
                        <!-- ************************************************************************************** -->

                    </div>

                    <!-- ************************************************************************************** -->
                    <div class="form-group rooms-line d-none">
                        <label class="control-label">ห้องประชุม</label>
                        <!-- <p class="detail-rooms"></p> -->
                        <select class="form-control form-white" name="detail-rooms-id" disabled>
                            <option selected disabled>กรุณาเลือก...</option>
                            <?php
foreach ($room as $value) {
    ?>
                            <option value="<?=$value->ID?>" data-rooms-name="<?=$value->ROOMS?>"
                                data-rooms-branch="<?=$value->BRANCH?>">
                                <?=$value->ROOMS?></option>
                            <?php
}
?>
                        </select>
                        <input autocomplete="off" class="form-control form-white" placeholder="Enter topic"
                            type="hidden" value="" name="detail-rooms-name" />
                    </div>
                    <!-- ************************************************************************************** -->

                    <div class="form-group">
                        <label class="control-label">เนื้อหาการประชุม</label>
                        <!-- <p class="detail-description"></p> -->
                        <textarea maxlength="150" placeholder="Enter name" class="form-control form-white"
                            name="detail-description" cols="30" rows="5" disabled></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="control-label">ตั้งแต่</label>
                            <!-- <p class="detail-dates"></p> -->
                            <input autocomplete="off" type="text" class="form-control datepicker-autoclose" value=""
                                placeholder="yyyy-mm-dd" name="detail-dates" disabled>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="control-label">ถึง</label>
                            <!-- <p class="detail-datee"></p> -->
                            <input autocomplete="off" type="text" class="form-control datepicker-autoclose" value=""
                                placeholder="yyyy-mm-dd" name="detail-datee" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="control-label">ตั้งแต่</label>
                            <!-- <p class="detail-times"></p> -->
                            <input autocomplete="off" type="text" class="form-control" value="" placeholder="08:00"
                                name="detail-times" disabled>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="control-label">ถึง</label>
                            <!-- <p class="detail-timee"></p> -->
                            <input autocomplete="off" type="text" class="form-control" value="" placeholder="17:30"
                                name="detail-timee" disabled>
                        </div>
                    </div>
                    <div class="form-group d-none" data-visitor="true">
                        <h5 class="control-h5">ผู้เข้าร่วม</h5>
                        <h5 class="visitor-name">

                        </h5>
                    </div>
                    <div class="form-group" data-user-start="true">
                        <label class="control-label">ผู้สร้างแบบฟอร์ม</label>
                        <p class="user-start-name">

                        </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ปิด</button>
                <div class="action-footer">

                </div>
            </div>

        </div>
    </div>
</div>
<!-- END READ Modal -meeting- -->