<input type="hidden" name="hidden_dates" id="hidden_dates">
<input type="hidden" name="hidden_datee" id="hidden_datee">

<div class="d-flex flex-row justify-content-end">
    <div class="pl-1">
        <input type="text" class="form-control datepicker-autoclose" name="dates" placeholder="ตั้งแต่วันที่" autocomplete="off">
    </div>
    <div class="pl-1">
        <input type="text" class="form-control datepicker-autoclose" name="datee" placeholder="ถึงวันที่" autocomplete="off">
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

})
</script>