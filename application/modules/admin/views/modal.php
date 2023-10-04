<div id="btn_register_user_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal was-validated" autocomplete="off" id="dataform" action="" class="was-validated">
                    <input type="hidden" id="method" name="method" value="">
                    <input type="hidden" id="hidden_id" name="hidden_id" value="1"> <!-- set 1 for default value check -->

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="">สิทธิ์</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">ระบุสิทธิ์</option>
                                <?php
                                foreach ($role as $row_role) :
                                    $aria = strtoupper($row_role->NAME) . "---(" . $row_role->ARIA . ")";
                                ?>
                                    <option value="<?= $row_role->ID; ?>"><?= $aria; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row d-none userfocus">
                        <div class="col-12">
                            <label for="">ดูแลเฉพาะ</label>
                            <select id="userfocus" name="userfocus" class="form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                <?php
                                foreach ($operator as $row_operator) :
                                    $staffname = $row_operator->MEMBER_NAME." ".$row_operator->MEMBER_LASTNAME;
                                ?>
                                    <option value="<?= $row_operator->STAFF_ID; ?>"><?= $staffname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>

                    </div>

                    <!-- <div class="form-group row">
                        <div class="col-12">
                            <label for="">Level</label>
                            <select name="level" id="level" class="form-control">
                                <option value="">ระบุ Level</option>
                                <?php
                                foreach ($level as $row_level) :
                                ?>
                                <option value="<?= $row_level->ID; ?>"><?= $row_level->NAME; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="">ชื่อ</label>
                            <input class="form-control" type="text" id="name" name="name" placeholder="ชื่อภาษาไทย" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="">นามสกุล</label>
                            <input class="form-control" type="text" id="lastname" name="lastname" placeholder="นามสกุลภาษาไทย" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label for="">username</label>
                            <input type="text" id="input_username" name="input_username" class="form-control" placeholder="ชื่อผู้ใช้" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="">รหัสผ่าน</label>
                            <input type="password" id="input_password" name="input_password" class="form-control" placeholder="รหัสผ่าน" required>

                        </div>
                    </div>

                    <div class="form-group row text-center mt-2">
                        <div class="col-12">
                            <button class="btn btn-md btn-block btn-success waves-effect waves-light" id="btn_register" type="submit">ลงทะเบียน</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('[data-toggle=select2]').select2()

        $(document).on('change', '#role', function() {
            if ($(this).val() == 8) {
                $('.userfocus').removeClass('d-none')
            } else {
                $('.userfocus').addClass('d-none')
            }
        })
    })
</script>