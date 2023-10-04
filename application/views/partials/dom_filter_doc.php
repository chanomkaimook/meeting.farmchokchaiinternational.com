<input type="hidden" id="hidden_statusbill" name="hidden_statusbill">
<div class="form-inline flex-fill">
    <div class="form-group w-100">

        <label class="d-none d-sm-block">สถานะ </label>
        <select class="form-control form-control-sm" id="item_statusbill">
            <option value="" selected>สถานะ</option>

            <option value="1">รอ</option>
            <option value="2">กำลังทำ</option>
            <option value="3">ปิดงานสำเร็จ</option>
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('change', '#item_statusbill', function() {
            $('#hidden_statusbill').val($(this).val())
        })
    })
</script>