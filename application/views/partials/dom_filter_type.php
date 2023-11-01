<input type="hidden" name="hidden_type" id="hidden_type">

<div class="pl-1">
    <select class="form-control form-white select2" data-toggle="select2" name="type">
        <option>ประเภท</option>
        <option value="2">จองรถ</option>
        <option value="1">จองห้องประชุม</option>
        <option value="3">นัดหมายกิจกรรม</option>
    </select>
</div>
<script>
$(document).ready(function() {
    $('[name=type]').change(function() {
        let data = $(this).val()
        $('#hidden_type').val(data)
        // console.log($('#hidden_type').val())
    })
})
</script>