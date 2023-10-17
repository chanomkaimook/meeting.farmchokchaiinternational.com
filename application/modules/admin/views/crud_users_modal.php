<!-- UPDATE Modal -->
<div class="modal fade none-border" id="update-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ข้อมูลผู้ใช้งาน</h4>
            </div>
            <div class="modal-body pb-0">
            <form class="form" data-action="">
                    <div class="form-group">
                        <label class="control-label">สิทธิ์การใช้งานภายในระบบ</label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="update-type">
                            <option selected value="user">ผู้ใช้งานทั่วไป (user)</option>
                            <option value="admin">ผู้ดูแลระบบ (admin)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ชื่อ</label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="update-staff">
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
                        <label class="control-label">ผู้มีสิทธิ์จัดการการนัดหมาย</label>
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
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light btn-save-update"
                    data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- END UPDATE Modal -->

<!-- READ Modal -->
<div class="modal fade none-border" id="detail-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="d-flex">
                    <div>
                        <h4 class="modal-title">Booking</h4>
                    </div>
                    <div id="action-header" class="pl-4">
                        <!-- <h4 class="modal-title text-warning">รอดำเนินการ</h4> -->
                        <!-- <button type="button" class="btn btn-icon waves-effect btn-warning btn-edit" data-edit="true">
                            <i class="fas fa-edit"></i> </button>
                        <button type="button" class="btn btn-danger waves-effect waves-light btn-delete"
                            data-dismiss="modal"> <i class="fas fa-trash-alt"></i> </button> -->
                    </div>
                </div>
            </div>

            <div class="modal-body pb-0">
            <form class="form" data-action="">
                    <div class="form-group">
                        <label class="control-label">สิทธิ์การใช้งานภายในระบบ</label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="detail-type" disabled>
                            <option selected value="user">ผู้ใช้งานทั่วไป (user)</option>
                            <option value="admin">ผู้ดูแลระบบ (admin)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ชื่อ</label>
                        <select class="form-control form-white" data-placeholder="กรุณาเลือก..." name="detail-staff" disabled>
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
                        <label class="control-label">ผู้มีสิทธิ์จัดการการนัดหมาย</label>
                        <!-- <input type="text" value="นาย A,นาย C,นาย E" data-role="tagsinput" name="detail-visitor"/> -->
                        <select class="form-control select2-multiple" data-toggle="select2" multiple="multiple"
                            name="detail-visitor" disabled>
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
        </div>
    </div>
</div>
<!-- END READ Modal -->