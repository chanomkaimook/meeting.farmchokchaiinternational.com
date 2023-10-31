<div class="row">
    <div class="col-4">
        <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal" class="btn btn-primary"><i
                class="fa fa-plus"></i> Booking</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#draft-modal">แบบร่าง</button>
    </div>
    <div class="col-8">
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
                        <option value="3">แบบร่างการนัดหมาย/จองห้องประชุม</option>
                        <option value="4">แบบร่างการจองรถ</option>
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
                    <input type="text" class="form-control datepicker-autoclose" name="datee" placeholder="ถึงวันที่">
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
</div>

<script>
$(document).ready(function() {
        
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
    })
</script>