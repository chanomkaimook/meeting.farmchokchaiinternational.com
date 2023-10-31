<input type="hidden" name="hidden_status" id="hidden_status">
<input type="hidden" name="hidden_area" id="hidden_area">

<div class="pl-1">
    <select class="form-control form-white" data-toggle="select2" name="status">
        <option value="">สถานะ</option>
        <option value="1" data-area="event">รออนุมัติ,รอตอบรับ,รอดำเนินการ</option>
        <option value="2" data-area="event">อนุมัติ,เข้าร่วม,ดำเนินการสำเร็จ</option>
        <option value="3" data-area="event">ไม่อนุมัติ,ปฏิเสธมดำเนินการไม่สำเร็จ</option>
        <option value="4" data-area="event">ยกเลิก</option>
        <option value="5" data-area="event">กำลังดำเนินการ</option>
        <option value="1" data-area="approve">รออนุมัติ,รอตอบรับ,รอดำเนินการ</option>
        <option value="2" data-area="approve">อนุมัติ,เข้าร่วม,ดำเนินการสำเร็จ</option>
        <option value="3" data-area="approve">ไม่อนุมัติ,ปฏิเสธมดำเนินการไม่สำเร็จ</option>
        <option value="1" data-area="visitor">รออนุมัติ,รอตอบรับ,รอดำเนินการ</option>
        <option value="2" data-area="visitor">อนุมัติ,เข้าร่วม,ดำเนินการสำเร็จ</option>
        <option value="3" data-area="visitor">ไม่อนุมัติ,ปฏิเสธมดำเนินการไม่สำเร็จ</option>
    </select>
</div>
<script>
$(document).ready(function() {
    $('[name=status]').change(function() {
        let data = $(this).val(), area = $(this).attr('data-area')
        $('#hidden_status').val(data)
        $('#hidden_area').val(area)
        // console.log($('#hidden_status').val())
    })
})
</script>