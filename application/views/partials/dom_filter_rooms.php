<input type="hidden" name="hidden_rooms" id="hidden_rooms">
<div class="pl-1 w-20">
    <select class="form-control form-white select2" data-toggle="select2" name="rooms">
        <option>ห้องประชุม</option>
        <?php
            foreach ($room as $value) {
        ?>
        <option value="<?=$value->ID?>" data-rooms-name="<?=$value->ROOMS?>" data-rooms-branch="<?=$value->BRANCH?>">
            <?=$value->ROOMS?></option>
        <?php
            }
        ?>
    </select>
</div>

<script>
$(document).ready(function() {
    $('[name=rooms]').change(function() {
        let data = $(this).val()
        $('#hidden_rooms').val(data)
        // console.log($('#hidden_user').val())
    })
    
    $('a.tabs-room').click(function() {
        console.log(123)
        $('select[name=rooms]').removeClass('d-none')
    })
    $('a.tabs-meeting').click(function() {
        console.log(456)
        $('select[name=rooms]').addClass('d-none')
    })

})
</script>