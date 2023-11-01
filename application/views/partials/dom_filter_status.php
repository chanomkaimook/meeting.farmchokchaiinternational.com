<input type="hidden" name="hidden_status" id="hidden_status">
<input type="hidden" name="hidden_area" id="hidden_area">

<div class="pl-1">
    <select class="form-control form-white" data-toggle="select2" name="status">
        <option value="">สถานะ</option>
        <option value="1e" data-val="1" data-area="event">รอดำเนินการ</option>
        <option value="2e" data-val="2" data-area="event">ดำเนินการสำเร็จ</option>
        <option value="3e" data-val="3" data-area="event">ดำเนินการไม่สำเร็จ</option>
        <option value="4e" data-val="4" data-area="event">ยกเลิกการจอง</option>
        <option value="5e" data-val="5" data-area="event">กำลังดำเนินการ</option>
        <option value="1a" data-val="1" data-area="approve">รออนุมัติ</option>
        <option value="2a" data-val="2" data-area="approve">อนุมัติ</option>
        <option value="3a" data-val="3" data-area="approve">ไม่อนุมัติ</option>
        <option value="1v" data-val="1" data-area="visitor">รอตอบรับ</option>
        <option value="2v" data-val="2" data-area="visitor">เข้าร่วม</option>
        <option value="3v" data-val="3" data-area="visitor">ปฏิเสธ</option>
    </select>
</div>
<script>
$(document).ready(function() {
    $('[name=status]').change(function() {
        let find = $(this).val(),
            data = $(this).find('option[value=' + find + ']').attr('data-val'),
            area = $(this).find('option[value=' + find + ']').attr('data-area')
        $('#hidden_status').val(data)
        $('#hidden_area').val(area)
        // console.log(area)
    })
})
</script>