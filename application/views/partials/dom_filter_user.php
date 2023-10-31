<input type="hidden" name="hidden_user" id="hidden_user">
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

<script>
$(document).ready(function() {
    $('[name=user]').change(function() {
        let data = $(this).val()
        $('#hidden_user').val(data)
        // console.log($('#hidden_user').val())
    })

})
</script>