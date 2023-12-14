<div class="row" align="left">
    <?php
$default_month = date("n");
$default_year = date("Y");
$month = array(
    '1' => 'มกราคม',
    '2' => 'กุมภาพันธ์',
    '3' => 'มีนาคม',
    '4' => 'เมษายน',
    '5' => 'พฤษภาคม',
    '6' => 'มิถุนายน',
    '7' => 'กรกฎาคม',
    '8' => 'สิงหาคม',
    '9' => 'กันยายน',
    '10' => 'ตุลาคม',
    '11' => 'พฤศจิกายน',
    '12' => 'ธันวาคม',
);
?>
    <div class="col-5">
        <select class="form-control" name="month">
            <option selected>เดือน</option>
            <?php
for ($i = 1; $i <= count($month); $i++) {
    $m = '';
    $i < 10 ? $m = "0" . $i : $m = $i;

    $date_begin = date("m-01", mktime(0, 0, 0, $m));
    $date_end = date("m-t", mktime(0, 0, 0, $m));
    ?>
            <option value="<?=$i?>" data-dates="<?=$date_begin;?>" data-datee="<?=$date_end;?>"
                <?=$default_month == $i ? "selected" : ""?>><?=$month[$i]?></option>
            <?php
}
?>
        </select>
    </div>

    <div class="col-5">
        <select class="form-control" name="year">
            <?php
foreach ($year as $key => $value) {
    $years = "";
    $value->YEARS == $value->YEARE ? $years = $value->YEARS : $years = $value->YEARE
    ?>
            <option value="<?=$years?>" <?=$default_year == $years ? "selected" : ""?>><?=$years?></option>
            <?php
}
?>
        </select>
    </div>
    <div class="col-2">
        <button type="button" class="btn btn-primary btn-search"><i class="fa fa-search"
                aria-hidden="true"></i></button>
    </div>
</div>
<div class="row">
    <div class="col-12" align="left">
        <button type="button" data-dates="<?=$btndate["day"]?>" data-datee="<?=$btndate["day"]?>"
            class="btn btn-primary btn-today">today</button>
        <button type="button" data-dates="<?=$btndate["weekds"]?>" data-datee="<?=$btndate["weekde"]?>"
            class="btn btn-primary btn-week">week</button>
        <button type="button" data-dates="<?=$btndate["monthds"]?>" data-datee="<?=$btndate["monthde"]?>"
            class="btn btn-primary btn-month">month</button>
    </div>
</div>
<!-- INPUT HIDDEN FOR FILTER -->
<input type="hidden" name="sid">
<input type="hidden" name="dates">
<input type="hidden" name="datee">
<!-- INPUT HIDDEN FOR FILTER -->
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="header-title mb-3"><?php echo $month[$default_month]; ?></h4>
            <h5 class="event-null"></h5>

            <div class="event-content">
                <div class="list-group head"></div>
                <div style="border-bottom-style: groove; padding: 1rem;"></div>
                <div class="list-group visitor"></div>
            </div>

        </div>
    </div>
    <!-- end col -->

</div>
<!-- end row -->
<script>
$(document).ready(function() {
    let url_host = window.location.host;
    let url_current = window.location.href;
    let url_length = url_current.indexOf(url_host);
    let url_newCurrent = url_current.slice(url_length);
    let url_split = url_newCurrent.split("/");
    let url_moduleControl

    if (window.location.hostname == 'localhost' || window.location.hostname == '127.0.0.1') {
        url_moduleControl = window.location.pathname.split('/')[1]
    } else {
        url_moduleControl = `${url_split[1]}/${url_split[2]}`;
    }

    function path(name = null) {
        let pathname = window.location.origin;
        if (name) {
            pathname = pathname + '/' + name
        }

        return pathname
    }

    $('.btn-search').click(function(e) {
        let val = $('select[name=month]').val(),
            dates = $('select[name=month]').find('option[value=' + val + ']').attr('data-dates'),
            datee = $('select[name=month]').find('option[value=' + val + ']').attr('data-datee'),
            year = $('select[name=year]').val()

        $('input[name=dates]').val(year + '-' + dates)
        $('input[name=datee]').val(year + '-' + datee)

        filter()
        return false;
    })
    $('.btn-today').click(function(e) {
        let dates = $(this).attr('data-dates'),
            datee = $(this).attr('data-datee')

        $('input[name=dates]').val(dates)
        $('input[name=datee]').val(datee)
        filter()
        return false;
    })
    $('.btn-month').click(function(e) {
        let dates = $(this).attr('data-dates'),
            datee = $(this).attr('data-datee')

        $('input[name=dates]').val(dates)
        $('input[name=datee]').val(datee)
        filter()
        return false;
    })
    $('.btn-week').click(function(e) {
        let dates = $(this).attr('data-dates'),
            datee = $(this).attr('data-datee')

        $('input[name=dates]').val(dates)
        $('input[name=datee]').val(datee)
        filter()
        return false;
    })

    function filter() {
        let url = new URL('rich_menu/ctl_get_userId/get_data_filter', domain),
            data = new FormData()

        let sid = $('input[name=sid]').val(),
            dates = $('input[name=dates]').val(),
            datee = $('input[name=datee]').val()

        data.append("sid", sid)
        data.append("dates", dates)
        data.append("datee", datee)
        data.append("type_id", 1)

        fetch(url, {
                method: 'POST',
                body: data,
            })
            .then(res => res.json())
            .then((resp) => {
                dataShow(resp)
            })
    }

    function get_data(userId) {
        let url = new URL('rich_menu/ctl_get_userId/get_data', domain),
            data = new FormData()

        data.append("userId", userId)
        data.append("type_id", 1)

        fetch(url, {
                method: 'POST',
                body: data,
            })
            .then(res => res.json())
            .then((resp) => {
                dataShow(resp)
            })
    }

    function dataShow(eventData = []) {
        let html = '',
            html_head = '',
            html_visitor = '',
            head = 0,
            visitor = 0
        console.log(eventData)
        // return false
        if (!eventData.msg) {
            if (eventData.head) {
                head = 1;
                $.each(eventData.head, function(index, item) {
                    if (index != "sid") {
                        html_head += `
                        <a class="list-group-item list-group-item-action flex-column align-items-start detail" data-event-id="${item.ID}" data-event-code="${item.CODE}">
                    <div class="d-flex w-150 justify-content-between">
                        <h5 class="mb-1">การจองห้องประชุม #${item.CODE}</h5>
                        <small>(${item.STATUS_NAME})</small>
                    </div>
                    <p class="mb-1">
                            หัวข้อ ${item.TOPIC}<br>
                            วันที่ ${item.DATE_BEGIN_SHOW} - ${item.DATE_END_SHOW}<br>
                            เวลา ${item.TIME_BEGIN_SHOW} - ${item.TIME_END_SHOW}<br>
                    </p>
                </a>
                    `
                    }
                })
            } else {
                // head = 0;
                html_head = "<h5>ไม่มีข้อมูลการจองห้องประชุมที่คุณเป็นประธาน</h5>";
            }

            if (eventData.visitor) {
                visitor = 1
                $.each(eventData.visitor, function(index, item) {
                    if (index != "sid") {
                        html_visitor += `
                        <a class="list-group-item list-group-item-action flex-column align-items-start detail" data-event-id="${item.ID}" data-event-code="${item.CODE}">
                    <div class="d-flex w-150 justify-content-between">
                        <h5 class="mb-1">การจองห้องประชุม #${item.CODE}</h5>
                        <small>(${item.STATUS_NAME})</small>
                    </div>
                    <p class="mb-1">
                            หัวข้อ ${item.TOPIC}<br>
                            วันที่ ${item.DATE_BEGIN_SHOW} - ${item.DATE_END_SHOW}<br>
                            เวลา ${item.TIME_BEGIN_SHOW} - ${item.TIME_END_SHOW}<br>
                    </p>
                </a>
                    `
                    }
                })
            } else {
                html_visitor = "<h5>ไม่มีข้อมูลการจองห้องประชุมที่คุณเป็นผู้เข้าร่วม</h5>";
            }
        } else {
            html = "คุณยังไม่มีข้อมูลการจองห้องประชุม"
        }
        if (html) {

            $('h5.event-null').removeClass('d-none').html(html)
            $('div.event-content').addClass('d-none')
        } else {
            if (head) {
                html_head = `<h5>ข้อมูลการจองห้องประชุมที่คุณเป็นประธาน</h5>` + html_head
            }

            if (visitor) {
                html_visitor = `<h5>ข้อมูลการจองห้องประชุมที่คุณเป็นผู้เข้าร่วม</h5>` + html_visitor
            }

            $('h5.event-null').addClass('d-none')
            $('div.event-content').removeClass('d-none')
            $('div.head').html(html_head)
            $('div.visitor').html(html_visitor)
        }
        $('input[name=sid]').val(eventData.sid)
    }

    $(document).on('click', 'a.detail', function() {
        let id = $(this).attr('data-event-id'),
            code = $(this).attr('data-event-code');
        let url = new URL("appointment/ctl_line_data?id=" + id + "&code=" + code, domain);
        window.open(url)

    })


    // get_data("U985c5f9034f1055b1d05229589244b7b")


    function runApp() {
        liff.getProfile().then(profile => {
            console.log(profile)
            get_data(profile.userId)
        }).catch(err => console.error(err));
    }
    liff.init({
        liffId: "2000744935-EBn35GZ5" // room
    }, () => {
        if (liff.isLoggedIn()) {
            runApp()
        } else {
            liff.login();
        }
    }, err => console.error(err.code, error.message));
})
</script>