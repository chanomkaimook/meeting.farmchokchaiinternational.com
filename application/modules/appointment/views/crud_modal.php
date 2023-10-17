<!-- CREATE Modal -insert- -->
<div class="modal fade" id="insert-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Booking</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-0">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card text-center insert-car">
                            <div class="card-body">
                                <h2>จองรถ</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card text-center insert-meeting">
                            <h2>นัดหมาย/จองห้องประชุม</h2>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- CREATE Modal -insert- -->

<!-- CREATE Modal -car- -->
<div class="modal fade" id="insert-modal-car" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Booking</h4>
            </div>
            <div class="modal-body pb-0">
                <form class="form" id="insert-car">
                    <div class="form-group">
                        <label class="control-label">ประเภท</label>
                        <input class="form-control form-white" placeholder="Enter name" value="2" type="hidden"
                            name="insert-type" />
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." disabled>
                            <option value="2">จองรถ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">หัวข้อ</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text"
                            name="insert-name" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">โดย</label>
                        <select class="form-control form-white" name="insert-head">
                            <option disabled selected>กรุณาเลือก...</option>
                            <?php
                            foreach ($staff as $val) {
                            ?>
                            <option value="<?= $val->STAFF_CHILD; ?>"><?= $val->NAME . " " . $val->LASTNAME; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">เนื้อหาการประชุม</label>
                        <textarea placeholder="Enter name" class="form-control form-white" name="insert-description"
                            cols="30" rows="5"></textarea>
                    </div>
                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">วันที่</label>
                            <input type="text" class="form-control datepicker-autoclose" placeholder="yyyy-mm-dd"
                                name="insert-date">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">เวลา</label>
                            <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="insert-time">
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
                                <option value="<?= date('H:i', strtotime($times)) ?>">
                                    <?= date('H:i', strtotime($times)) ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ผู้เข้าร่วม</label>
                        <select class="form-control select2-multiple" data-toggle="select2" multiple="multiple"
                            name="insert-visitor">
                            <!--  data-role="tagsinput" multiple -->
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
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ปิด</button>
                <button type="button"
                    class="btn btn-warning waves-effect waves-light btn-save-draft">บันทึกเป็นแบบร่าง</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-save-insert">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<!-- END CREATE Modal -car- -->

<!-- UPDATE Modal -car- -->
<div class="modal fade none-border" id="update-modal-car" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Booking</h4>
            </div>
            <div class="modal-body pb-0">
                <form class="form" id="update-car">
                    <div class="form-group">
                        <label class="control-label">ประเภท</label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="update-type">
                            <option selected value="กิจกรรม">กิจกรรม</option>
                            <option value="ประชุม">ประชุม</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">หัวข้อ</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text"
                            value="เก็บหิน สนง.ฟาร์ม" name="update-name" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">โดย</label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="update-head">
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
                        <textarea placeholder="Enter name" class="form-control form-white" name="update-description"
                            cols="30"
                            rows="5">กิจกรรมเก็บหินที่สำนักงานฟาร์ม เดินทางโดยรถตู้บริษัท ทะเบียน กข1234 นำทีมโดย นาย G</textarea>
                    </div>
                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">วันที่</label>
                            <input type="text" class="form-control datepicker-autoclose" value="2023-10-02"
                                placeholder="yyyy-mm-dd" name="update-date">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">เวลา</label>
                            <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="update-time">
                                <!-- <option selected disabled>กรุณาเลือก...</option> -->
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
                                <option selected value="<?= date('H:i', strtotime($times)) ?>">
                                    <?= date('H:i', strtotime($times)) ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ผู้เข้าร่วม</label>
                        <!-- <input type="text" value="นาย A,นาย C,นาย E" data-role="tagsinput" name="detail-visitor"/> -->
                        <select class="form-control select2-multiple" data-toggle="select2" multiple="multiple"
                            name="update-visitor">
                            <option selected value="1">นาย A</option>
                            <option selected value="2">นาย B</option>
                            <option value="3">นาย C</option>
                            <option value="4">นาย D</option>
                            <option selected value="5">นาย E</option>
                            <option value="6">นาย F</option>
                            <option value="7">นาย G</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ปิด</button>
                <!-- <button type="button"
                    class="btn btn-warning waves-effect waves-light btn-save-draft">บันทึกเป็นแบบร่าง</button> -->
                <button type="button" class="btn btn-success waves-effect waves-light btn-save-update">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<!-- END UPDATE Modal -car- -->

<!-- READ Modal -car- -->
<div class="modal fade none-border" id="detail-modal-car" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                        <label class="control-label">หัวข้อ</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text"
                            value="เก็บหิน สนง.ฟาร์ม" name="detail-name" disabled />
                    </div>
                    <div class="form-group">
                        <label class="control-label">โดย</label>
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
                        <textarea placeholder="Enter name" class="form-control form-white" name="detail-description"
                            cols="30" rows="5"
                            disabled>กิจกรรมเก็บหินที่สำนักงานฟาร์ม เดินทางโดยรถตู้บริษัท ทะเบียน กข1234 นำทีมโดย นาย G</textarea>
                    </div>
                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">วันที่</label>
                            <input type="text" class="form-control datepicker-autoclose" value="2023-10-02"
                                placeholder="yyyy-mm-dd" name="detail-date" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">เวลา</label>
                            <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="detail-time"
                                disabled>
                                <!-- <option selected disabled>กรุณาเลือก...</option> -->
                                <?php
                                // foreach ($time as $value) {
                                //     if (!$value["START"]) {
                                //         $times = $value["END"];
                                //     } elseif (!$value["END"]) {
                                //         $times = $value["START"];
                                //     } else {
                                //         $times = $value["START"];
                                //     }
                                ?>
                                <option selected value="<?= date('H:i', strtotime($times)) ?>">
                                    <?= date('H:i', strtotime("7.00")) ?></option>
                                <?php
                                // }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ผู้เข้าร่วม</label>
                        <input type="text" value="นาย A,นาย C,นาย E" data-role="tagsinput" name="detail-visitor"
                            disabled />
                        <!-- <select class="form-control select2-multiple" data-toggle="select2" multiple="multiple"
                            name="update-visitor">
                            <option value="1">นาย A</option>
                            <option value="2">นาย B</option>
                            <option value="3">นาย C</option>
                            <option value="4">นาย D</option>
                            <option value="5">นาย E</option>
                            <option value="6">นาย F</option>
                            <option value="7">นาย G</option>
                        </select> -->
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
                <!-- <div class="save-footer">
                    <button type="button"
                        class="btn btn-success save-event waves-effect waves-light unloading">บันทึก</button>
                    <button type="button" class="btn btn-success save-event waves-effect waves-light loading d-none"
                        disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        กำลังบันทึก
                    </button>
                </div> -->
            </div>

        </div>
    </div>
</div>
<!-- END READ Modal -car- -->

<!-- CREATE Modal -meeting- -->
<div class="modal fade none-border" id="insert-modal-meeting" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Booking</h4>
            </div>
            <div class="modal-body pb-0">
                <form class="form" id="insert-meeting">

                    <div class="form-group">
                        <label class="control-label">ประเภท</label>
                        <input class="form-control form-white" placeholder="Enter name" value="1" type="hidden"
                            name="insert-type" />
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." disabled>
                            <option value="1">นัดหมาย/จองห้องประชุม</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">หัวข้อ</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text"
                            name="insert-name" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">โดย</label>

                        <select class="form-control form-white" name="insert-head">
                            <option disabled selected>กรุณาเลือก...</option>
                            <?php
                            foreach ($staff as $val) {
                            ?>
                            <option value="<?= $val->STAFF_CHILD; ?>"><?= $val->NAME . " " . $val->LASTNAME; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">เนื้อหาการประชุม</label>
                        <textarea placeholder="Enter name" class="form-control form-white" name="insert-description"
                            cols="30" rows="5"></textarea>
                    </div>

                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">ตั้งแต่วันที่</label>
                            <input type="text" class="form-control datepicker-autoclose"
                                data-placeholder="กรุณาระบุวันที่..." value="" placeholder="yyyy-mm-dd"
                                name="insert-dates">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">ถึงวันที่</label>
                            <input type="text" class="form-control datepicker-autoclose"
                                data-placeholder="กรุณาระบุวันที่..." value="" placeholder="yyyy-mm-dd"
                                name="insert-datee">
                        </div>

                    </div>
                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">ตั้งแต่เวลา</label>
                            <select class="form-control form-white" name="insert-times">
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
                                <option value="<?= date('H:i', strtotime($times)) ?>">
                                    <?= date('H:i', strtotime($times)) ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">ถึงเวลา</label>
                            <select class="form-control form-white" name="insert-timee">
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
                                <option value="<?= date('H:i', strtotime($times)) ?>">
                                    <?= date('H:i', strtotime($times)) ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ผู้เข้าร่วม</label>
                        <select class="form-control select2-multiple" data-toggle="select2" multiple="multiple"
                            name="insert-visitor">
                            <!--  data-role="tagsinput" multiple -->
                            <option value="1">นาย A</option>
                            <option value="2">นาย B</option>
                            <option value="3">นาย C</option>
                            <option value="4">นาย D</option>
                            <option value="5">นาย E</option>
                            <option value="6">นาย F</option>
                            <option value="7">นาย G</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ปิด</button>
                        <button type="button"
                            class="btn btn-warning waves-effect waves-light btn-save-draft">บันทึกเป็นแบบร่าง</button>
                        <button type="button"
                            class="btn btn-success waves-effect waves-light btn-save-insert">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- CREATE Modal -meeting- -->

<!-- UPDATE Modal -meeting- -->
<div class="modal fade none-border" id="update-modal-meeting" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Booking</h4>
            </div>
            <div class="modal-body pb-0">
                <form class="form" id="update-meeting">
                    <input class="form-control form-white" placeholder="Enter name" value="" type="hidden" name="item_id" />
                    <div class="form-group">
                        <label class="control-label">ประเภท</label>
                        <input class="form-control form-white" placeholder="Enter name" value="1" type="hidden" name="update-type" />
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." disabled>
                            <option value="1">นัดหมาย/จองห้องประชุม</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">หัวข้อ</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text"
                            value="เก็บหิน สนง.ฟาร์ม" name="update-name" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">โดย</label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="update-head">
                            <option disabled selected>กรุณาเลือก...</option>
                            <?php
                            foreach ($staff as $val) {
                            ?>
                            <option value="<?= $val->STAFF_CHILD; ?>"><?= $val->NAME . " " . $val->LASTNAME; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">เนื้อหาการประชุม</label>
                        <textarea placeholder="Enter name" class="form-control form-white" name="update-description"
                            cols="30"
                            rows="5">กิจกรรมเก็บหินที่สำนักงานฟาร์ม เดินทางโดยรถตู้บริษัท ทะเบียน กข1234 นำทีมโดย นาย G</textarea>
                    </div>
                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">ตั้งแต่วันที่</label>
                            <input type="text" class="form-control datepicker-autoclose" value="2023-10-02"
                                placeholder="yyyy-mm-dd" name="update-dates">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">ถึงวันที่</label>
                            <input type="text" class="form-control datepicker-autoclose" value="2023-10-02"
                                placeholder="yyyy-mm-dd" name="update-datee">
                        </div>

                    </div>
                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">ตั้งแต่เวลา</label>
                            <select class="form-control form-white" data-placeholder="กรุณาเลือก..."
                                name="update-times">
                                <!-- <option selected disabled>กรุณาเลือก...</option> -->
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
                                <option selected value="<?= date('H:i', strtotime($times)) ?>">
                                    <?= date('H:i', strtotime($times)) ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">ถึงเวลา</label>
                            <select class="form-control form-white" data-placeholder="กรุณาเลือก..."
                                name="update-timee">
                                <!-- <option selected disabled>กรุณาเลือก...</option> -->
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
                                <option selected value="<?= date('H:i', strtotime($times)) ?>">
                                    <?= date('H:i', strtotime($times)) ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ผู้เข้าร่วม</label>
                        <!-- <input type="text" value="นาย A,นาย C,นาย E" data-role="tagsinput" name="detail-visitor"/> -->
                        <select class="form-control select2-multiple" data-toggle="select2" multiple="multiple"
                            name="update-visitor">
                            <option selected value="1">นาย A</option>
                            <option selected value="2">นาย B</option>
                            <option value="3">นาย C</option>
                            <option value="4">นาย D</option>
                            <option selected value="5">นาย E</option>
                            <option value="6">นาย F</option>
                            <option value="7">นาย G</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ปิด</button>
                <!-- <button type="button" class="btn btn-warning waves-effect waves-light btn-save-draft">บันทึกเป็นแบบร่าง</button> -->
                <button type="button" class="btn btn-success waves-effect waves-light btn-save-update">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<!-- END UPDATE Modal -meeting- -->

<!-- READ Modal -meeting- -->
<div class="modal fade none-border" id="detail-modal-meeting" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="d-flex">
                    <div>
                        <h4 class="modal-title">จองห้อง/นัดหมายการประชุม</h4>
                    </div>
                    <div class="pl-4 action-header">
                        <h4 class="modal-title-status text-warning d-none"></h4>
                        <h4 class="modal-title-status text-danger d-none"></h4>
                        <h4 class="modal-title-status text-success d-none"></h4>
                    </div>
                </div>
            </div>

            <div class="modal-body pb-0">
                <form class="form" id="detail-meeting">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card text-center update-meeting">
                                <div class="card-body">
                                    <h4>แก้ไข</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card text-center delete-meeting">
                                <h4>ลบ</h4>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">ประเภท</label>
                        <input type="text" name="detail-type" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label class="control-label">หัวข้อ</label>
                        <input class="form-control form-white" placeholder="Enter topic" type="text"
                            value="เก็บหิน สนง.ฟาร์ม" name="detail-name" disabled />
                    </div>
                    <div class="form-group">
                        <label class="control-label">โดย</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text"
                            value="เก็บหิน สนง.ฟาร์ม" name="detail-head" disabled />
                    </div>
                    <div class="form-group">
                        <label class="control-label">เนื้อหาการประชุม</label>
                        <textarea placeholder="Enter name" class="form-control form-white" name="detail-description"
                            cols="30" rows="5"
                            disabled>กิจกรรมเก็บหินที่สำนักงานฟาร์ม เดินทางโดยรถตู้บริษัท ทะเบียน กข1234 นำทีมโดย นาย G</textarea>
                    </div>
                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">ตั้งแต่</label>
                            <input type="text" class="form-control datepicker-autoclose" value="2023-10-02"
                                placeholder="yyyy-mm-dd" name="detail-dates" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">ถึง</label>
                            <input type="text" class="form-control datepicker-autoclose" value="2023-10-02"
                                placeholder="yyyy-mm-dd" name="detail-datee" disabled>
                        </div>
                    </div>
                    <div class="form-group mb-3 d-flex flex-row">
                        <div class="col-md-6">
                            <label class="control-label">ตั้งแต่</label>
                            <input type="text" class="form-control" value="08:00" placeholder="08:00"
                                name="detail-times" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">ถึง</label>
                            <input type="text" class="form-control" value="17:30" placeholder="17:30"
                                name="detail-timee" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ผู้เข้าร่วม</label>
                        <input type="text" value="" data-role="tagsinput" name="detail-visitor" disabled />
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
            </div>

        </div>
    </div>
</div>
<!-- END READ Modal -meeting- -->