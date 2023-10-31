<input type="hidden" name="hidden_permit" id="hidden_permit">
<div class="pl-1">
    <select class="form-control form-white" data-toggle="select2" name="permit">
        <option value="0">ทั้งหมด</option>
        <option value="1">เฉพาะที่มีสิทธิ์จัดการ</option>
    </select>
</div>

<script>
$(document).ready(function() {
    $('[name=permit]').change(function() {
        let data = $(this).val()
        $('#hidden_permit').val(data)
        // console.log($('#hidden_permit').val())
    })

})
</script>