
        <input type="hidden" name="hidden_times" id="hidden_times">
        <input type="hidden" name="hidden_timee" id="hidden_timee">

                <div class="pl-1">
                    <select class="form-control form-white" name="times">
                        <option selected disabled>ตั้งแต่เวลา</option>
                        <?php
                                    foreach ($time as $val) {
                                        if (!$val["START"]) {
                                            $times = $val["END"];
                                        } elseif (!$val["END"]) {
                                            $times = $val["START"];
                                        } else {
                                            $times = $val["START"];
                                        }
                                        ?>
                        <option value="<?=date('H:i:s', strtotime($times))?>">
                            <?=date('H:i', strtotime($times))?>
                        </option>
                        <?php
                                    }
                                    ?>
                    </select>
                </div>
                <div class="pl-1">
                    <select class="form-control form-white" name="timee">
                        <option selected disabled>ถึงเวลา</option>
                        <?php
                                    foreach ($time as $val) {
                                        if (!$val["START"]) {
                                            $times = $val["END"];
                                        } elseif (!$val["END"]) {
                                            $times = $val["START"];
                                        } else {
                                            $times = $val["START"];
                                        }
                                        ?>
                        <option value="<?=date('H:i:s', strtotime($times))?>">
                            <?=date('H:i', strtotime($times))?>
                        </option>
                        <?php
                                    }
                                    ?>
                    </select>
                </div>
<script>
$(document).ready(function() {
    $('[name=times]').change(function() {
        let data = $(this).val()
        $('#hidden_times').val(data)
        // console.log($('#hidden_times').val())
    })

    $('[name=timee]').change(function() {
        let data = $(this).val()
        $('#hidden_timee').val(data)
        // console.log($('#hidden_timee').val())
    })

    })
</script>