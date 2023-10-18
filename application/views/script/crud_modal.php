<script>
$(document).ready(function() {
    $('body').on('hidden.bs.modal', function() {
        if ($('.modal[aria-hidden=true]').length > 0) {
            $('body').addClass('modal-open');
        }
    })
})
/* ********** EVENT CLICK ********** */
$('.insert-car').click(function() {
    $("#insert-modal-car").find('.modal').attr('aria-hidden', true)
    $("#insert-modal-car").modal("show")
    $("#insert-modal").modal("hide")
})

$('.insert-meeting').click(function() {
    $("#insert-modal-meeting").find('.modal').attr('aria-hidden', true)
    $("#insert-modal-meeting").modal("show")
    $("#insert-modal").modal("hide")
})

$('.update-meeting').click(function() {
    $("#update-modal-meeting").find('.modal').attr('aria-hidden', true)
    $("#update-modal-meeting").modal("show")
    $("#detail-modal-meeting").modal("hide")
})

/* ********** FUNCTION ********** */
function modalShow(modal, obj, val) {
    let length = 0;
    if (modal && obj.length && val.length) {
        if (obj.length == val.length) {
            length = obj.length
        }
        for (let i = 0; i < length; i++) {
            $(modal).find(obj[i]).val(val[i])
        }
    }
}

function actionFooter(modal, entitled, status, event_id, event_code) {
    let html = ''

    if (modal && entitled) {
        if (status == 1) {
            if (entitled == 'other') {
                html = ``
            } else if (entitled == 'vis') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-refuse" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่เข้าร่วม</button>
                    <button type="button" class="btn btn-success waves-effect waves-light btn-accept" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">เข้าร่วม</button>`
            } else if (entitled == 'child') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-disapprove" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่อนุมัติ</button>
                    <button type="button" class="btn btn-success waves-effect waves-light btn-approve" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">อนุมัติ</button>`
            }
        } else if (status != 1 && entitled) {
            html = ``
        }
    } else {
        html =
            `<button type="button" class="btn btn-danger waves-effect waves-light btn-cancle" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-success" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">สำเร็จ</button>`;
    }
    $(modal).find('.action-footer').html(html)
}

function detail(calEvent, jsEvent, view) {
    let vis = '',
        vis_html = '',
        btn_html = '',
        modal_detail, obj_detail = [],
        val_detail = [],
        modal_update, obj_update = [],
        val_update = [],
        entitled = '',
        status = '';


    $('#detail-modal-car').find('[data-visitor=true]').addClass('d-none')
    $('#detail-modal-meeting').find('[data-visitor=true]').addClass('d-none')

    if (calEvent.TYPE_ID == 1 || calEvent.TYPE_ID == 3) {
        /* ************* DETAIL **************** */
        modal_detail = '#detail-modal-meeting'

        /* ************** UPDATE *************** */
        modal_update = '#update-modal-meeting';


    } else if (calEvent.TYPE_ID == 2 || calEvent.TYPE_ID == 4) {
        /* ************* DETAIL **************** */
        modal_detail = '#detail-modal-car'

        /* ************** UPDATE *************** */
        modal_update = '#update-modal-car'

    }

    $(modal_detail).modal("show")

    /* ************* DETAIL **************** */
    obj_detail.push('[name=detail-type]', '[name=detail-name]', '[name=detail-head]', '[name=detail-description]',
        '[name=detail-dates]', '[name=detail-datee]', '[name=detail-times]', '[name=detail-timee]')

    val_detail.push(calEvent.TYPE_NAME, calEvent.EVENT_NAME, calEvent.STAFF_ID, calEvent.EVENT_DESCRIPTION,
        calEvent.DATE_BEGIN, calEvent.DATE_END, calEvent.TIME_BEGIN, calEvent.TIME_END)

    modalShow(modal_detail, obj_detail, val_detail)
    /* ************* END DETAIL **************** */

    /* ************** UPDATE *************** */
    obj_update.push('[name=item_id]', '[name=code]', 'select[name=update-type]', '[name=update-name]',
        '[name=update-head]', '[name=update-description]', '[name=update-dates]', '[name=update-datee]',
        'select[name=update-times]', 'select[name=update-timee]')

    val_update.push(calEvent.ID, calEvent.CODE, calEvent.TYPE_ID, calEvent.EVENT_NAME, calEvent.STAFF_ID, calEvent
        .EVENT_DESCRIPTION, calEvent.DATE_BEGIN, calEvent.DATE_END, calEvent.TIME_BEGIN, calEvent.TIME_END)

    modalShow(modal_update, obj_update, val_update)
    /* ************** END UPDATE *************** */

    /* ************** ADD VISITOR *************** */

    if (calEvent.VISITOR) {
        for (let i = 0; i < calEvent.VISITOR.length; i++) {
            vis_html = vis_html + calEvent.VISITOR[i].VNAME + ' ' + calEvent.VISITOR[i].VLNAME + ' ' + calEvent.VISITOR[
                i].VSTATUS + '<br>'
            $('select[name=update-visitor]').find('option[data-value=' + calEvent.VISITOR[i].VID + ']').attr('selected')
            // console.log($('select[name=update-visitor]'))
        }

        $(modal_detail).find('[data-visitor=true]').removeClass('d-none')
        $(modal_detail).find('p.visitor-name').html(vis_html)


        $(modal_update).find('[data-visitor=true]').removeClass('d-none')
    }
    /* ************** END ADD VISITOR *************** */

    /* ************** ACTION FOOTER *************** */
    entitled = calEvent.class
    status = calEvent.STATUS_COMPLETE
    event_id = calEvent.ID
    event_code = calEvent.CODE
    // console.log(entitled, status, event_id)
    actionFooter(modal_detail, entitled, status, event_id, event_code)
    if (!calEvent.class) {
        if (!calEvent.CANCLE_DATE, !calEvent.APPROVE_DATE, !calEvent.DISAPPROVE_DATE) {
            $('.modal-footer').find('.approve-footer').removeClass('d-none')
            $('.action-header').find('.text-warning').removeClass('d-none')
            $('.action-header').find('.text-warning').html(calEvent.STATUS_SHOW)
        } else if (calEvent.APPROVE_DATE) {
            $('.modal-footer').find('.approve-footer').addClass('d-none')
            $('.action-header').find('.text-warning').removeClass('d-none')
            $('.action-header').find('.text-warning').html(calEvent.STATUS_SHOW)
        } else if (calEvent.DISAPPROVE_DATE) {
            $('.modal-footer').find('.approve-footer').addClass('d-none')
            $('.action-header').find('.text-danger').removeClass('d-none')
            $('.action-header').find('.text-danger').html(calEvent.STATUS_SHOW)
        } else if (calEvent.CANCLE_DATE) {
            $('.modal-footer').find('.approve-footer').addClass('d-none')
            $('.action-header').find('.text-success').removeClass('d-none')
            $('.action-header').find('.text-success').html(calEvent.STATUS_SHOW)
        }
    }

    /* ************** END ACTION FOOTER *************** */
}

function detail_draft(data) {
    // console.log(data)
    let i = 0,
        html_dom = []
    data.forEach(function(item, index) {
        i++
        if (item.TYPE_ID == 3) {
            html_dom[i] = `
        <tr>
            <th>${i}</th>
            <td>${item.TYPE_NAME}</td>
            <td>${item.EVENT_NAME}</td>
            <td><li class="dropdown d-lg-block">
                    <a class="text-primary nav-link dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item notify-item btn-detail-meeting" data-dismiss="modal">
                                <span class="align-middle">รายละเอียด</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item notify-item btn-update-meeting" data-toggle="modal" data-target="#update-modal-meeting" data-dismiss="modal">
                                <span class="align-middle">แก้ไข</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item notify-item btn-update-meeting" data-toggle="modal" data-target="#update-modal-meeting" data-dismiss="modal">
                                <span class="align-middle">นำไปใช้</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item notify-item btn-delete" >
                                <span class="align-middle">ลบ</span>
                            </a>
                        </div>
                </li>
            </td>
        </tr>
        `
        } else if (item.TYPE_ID == 4) {
            html_dom[i] = `
        <tr>
            <th>${i}</th>
            <td>${item.TYPE_NAME}</td>
            <td>${item.EVENT_NAME}</td>
            <td><li class="dropdown d-lg-block">
                    <a class="text-primary nav-link dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <a href="#" data-id="${item.ID}" class="dropdown-item notify-item btn-detail-car">
                                <span class="align-middle">รายละเอียด</span>
                            </a>

                            <!-- item-->
                            <a href="#" data-id="${item.ID}" class="dropdown-item notify-item btn-update-car">
                                <span class="align-middle">แก้ไข</span>
                            </a>

                            <!-- item-->
                            <a href="#" data-id="${item.ID}" class="dropdown-item notify-item btn-update-car">
                                <span class="align-middle">นำไปใช้</span>
                            </a>

                            <!-- item-->
                            <a href="#" data-id="${item.ID}" class="dropdown-item notify-item btn-delete">
                                <span class="align-middle">ลบ</span>
                            </a>
                        </div>
                </li>
            </td>
        </tr>
        `
        }

    })
    $('table#modal_draft').find('tbody').html(html_dom)
}

function swal_alert(icon, title, text) {
    Swal.fire(title, text, icon)
    $('.modal').modal('hide')
}

function swal_delete(data) {
    Swal.fire({
        title: 'โปรดยืนยัน',
        text: "คุณต้องการลบข้อมูลนี้?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ใช่ ต้องการลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            delete_meeting(data)
        }
    })
    $('.modal').modal('hide')
}

function swal_confirm(text, color, func, data) {
    Swal.fire({
        title: 'โปรดยืนยัน',
        text: "คุณต้องการ" + text + "ข้อมูลนี้?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: color,
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ใช่ ' + text,
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            if (func == "approval") {
                approval(data)
            } else if (func == "invitation") {
                invitation(data)
            } else if (func == "processing") {
                processing(data)
            }
        }
    })
    $('.modal').modal('hide')
}

/* ********** CRUD FUNCTION ********** */
function insert_meeting(insert_data) {
    let url = "insert_data"
    fetch(url, {
            method: 'post',
            body: insert_data
        })
        .then(res => res.json())
        .then((resp) => {
            if (resp.error) {
                swal_alert('error', 'ไม่สำเร็จ', resp.txt)
            } else {
                swal_alert('success', 'สำเร็จ', '')
            }
        })
}

function update_meeting(update_data) {
    let url = "update_data"
    fetch(url, {
            method: 'post',
            body: update_data
        })
        .then(res => res.json())
        .then((resp) => {
            if (resp.error) {
                swal_alert('error', 'ไม่สำเร็จ', resp.txt)
            } else {
                swal_alert('success', 'สำเร็จ', '')
            }
        })
}

function delete_meeting(delete_data) {
    let url = "delete_data"
    fetch(url, {
            method: 'post',
            body: delete_data
        })
        .then(res => res.json())
        .then((resp) => {
            if (resp.error) {
                swal_alert('error', 'ไม่สำเร็จ', resp.txt)
            } else {
                swal_alert('success', 'สำเร็จ', '')
            }
        })
}

function approval(data) {
    let url = "approval"
    fetch(url, {
            method: 'post',
            body: data
        })
        .then(res => res.json())
        .then((resp) => {
            if (resp.error) {
                swal_alert('error', 'ไม่สำเร็จ', resp.txt)
            } else {
                swal_alert('success', 'สำเร็จ', '')
            }
        })
}

function invitation(data) {
    let url = "invitation"
    fetch(url, {
            method: 'post',
            body: data
        })
        .then(res => res.json())
        .then((resp) => {
            if (resp.error) {
                swal_alert('error', 'ไม่สำเร็จ', resp.txt)
            } else {
                swal_alert('success', 'สำเร็จ', '')
            }
        })
}

function processing(data) {
    let url = "processing"
    fetch(url, {
            method: 'post',
            body: data
        })
        .then(res => res.json())
        .then((resp) => {
            if (resp.error) {
                swal_alert('error', 'ไม่สำเร็จ', resp.txt)
            } else {
                swal_alert('success', 'สำเร็จ', '')
            }
        })
}
</script>