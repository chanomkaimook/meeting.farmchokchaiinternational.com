<script>
$(document).ready(function() {

    /**
     *
     * ADDITIONAL FUNCTIONS
     *
     */

    $('body').on('hidden.bs.modal', function() {
        if ($('.modal[aria-hidden=true]').length > 0) {
            $('body').addClass('modal-open');
        }
    })

})

/* ********** EVENT CHANGE ********** */
$('select[name=insert-rooms-id]').change(function() {
    let id = $(this).val()
    let name = $(this).find('option[value=' + id + ']').attr('data-rooms-name')
    $("input[name=insert-rooms-name]").val(name)
})

$('select[name=update-rooms-id]').change(function() {
    let id = $(this).val()
    let name = $(this).find('option[value=' + id + ']').attr('data-rooms-name')
    $("input[name=update-rooms-name]").val(name)
})

/* ********** EVENT CLICK ********** */
$('.insert-car').click(function() {
    $("#insert-modal-car").find("#insert-car").trigger("reset")
    $("#insert-modal-car").find('.modal').attr('aria-hidden', true)
    $("#insert-modal-car").modal("show")
    $("#insert-modal").modal("hide")
})

$('.insert-meeting').click(function() {
    $("#insert-modal-meeting").find("#insert-meeting").trigger("reset")
    $("#insert-modal-meeting").find('.modal').attr('aria-hidden', true)
    $("#insert-modal-meeting").modal("show")
    $("#insert-modal").modal("hide")
})

$('.update-meeting').click(function() {
    $("#update-modal-meeting").find('.modal').attr('aria-hidden', true)
    $("#update-modal-meeting").modal("show")
    $("#detail-modal-meeting").modal("hide")
})

/* ********** ADDITIONAL FUNCTION ********** */

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

function button_action(modal, entitled, status, event_id, event_code, vid) {
    let html = ''

    $(modal).find('.action-header').removeClass('d-none')
    if (modal && entitled) {
        if (status == 1) {
            if (entitled == 'me' || entitled == 'owner') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-cancle" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-finish" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">สำเร็จ</button>`;

            } else if (entitled == 'other') {
                $(modal).find('.action-header').addClass('d-none')
                html = ``
            } else if (entitled == 'vis') {
                $(modal).find('.action-header').addClass('d-none')
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-refuse" data-id="${vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่เข้าร่วม</button>
                    <button type="button" class="btn btn-success waves-effect waves-light btn-accept" data-id="${vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">เข้าร่วม</button>`
            } else if (entitled == 'child') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-disapprove" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่อนุมัติ</button>
                    <button type="button" class="btn btn-success waves-effect waves-light btn-approve" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">อนุมัติ</button>`
            }
        } else if (status == 2) {
            $(modal).find('.action-header').addClass('d-none')
            html = ``
        } else if (status == 3 || status == 4) {
            if (entitled == 'me' || entitled == 'owner') {
                html =
                    `<button type="button" class="btn btn-success waves-effect waves-light btn-restore" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">นำกลับมาใช้</button>`;
            }
        } else if (status == 5) {
            if (entitled == 'me' || entitled == 'owner') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-cancle" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-finish" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">สำเร็จ</button>`;
            }
        }
    } else {
        html =
            ``;
    }
    $(modal).find('.action-footer').html(html)
}

function draft_to_use(data, type) {
    let vis = '',
        vis_html = '',
        btn_html = '',
        modal, obj = [],
        val = [],
        entitled = '',
        status = '',
        vid = '';

    // console.log(data)
    // $('#detail-modal-car').find('[data-visitor=true]').addClass('d-none')
    // $('#detail-modal-meeting').find('[data-visitor=true]').addClass('d-none')

    if (data.TYPE_ID == 3) {
        modal = '#update-modal-meeting';
        if (type == "use") {
            $(modal).find("[name=update-type-id]").val(1)
            $(modal).find("[name=update-type-name]").val("นัดหมาย/จองห้องประชุม")

        } else {
            $(modal).find("[name=update-type-id]").val(3)
            $(modal).find("[name=update-type-name]").val("แบบร่างนัดหมาย/จองห้องประชุม")

        }

    } else if (data.TYPE_ID == 4) {
        modal = '#update-modal-car'
        if (type == "use") {
            $(modal).find("[name=update-type-id]").val(2)
            $(modal).find("[name=update-type-name]").val("จองรถ")

        } else {
            $(modal).find("[name=update-type-id]").val(4)
            $(modal).find("[name=update-type-name]").val("แบบร่างจองรถ")

        }
    }

    $(modal).modal("show")
    $(modal).find(".delete-meeting").attr("data-event-id", data.ID)
    $(modal).find(".delete-meeting").attr("data-event-code", data.CODE)

    /* ************** UPDATE *************** */
    obj.push('[name=item_id]', '[name=code]',
        '[name=update-name]',
        '[name=update-head]', '[name=update-description]', '[name=update-dates]', '[name=update-datee]',
        'select[name=update-times]', 'select[name=update-timee]', '[name=update-rooms-id]')

    val.push(data.ID, data.CODE, data.EVENT_NAME, data
        .STAFF_ID, data
        .EVENT_DESCRIPTION, data.DATE_BEGIN, data.DATE_END, data.TIME_BEGIN, data.TIME_END, data
        .ROOMS_ID)

    modalShow(modal, obj, val)
    /* ************** END UPDATE *************** */

    /* ************** ADD VISITOR *************** */
    if (data.VISITOR) {
        user_visitor = data.VISITOR.map((item, index) => {
            // console.log(item,index)
            return item.VID
        })
        $('select[name=update-visitor]').val(user_visitor).trigger('change')

        // $(modal).find('[data-visitor=true]').removeClass('d-none')
    }

    /* ************** END ADD VISITOR *************** */

    user_start = data.USER_START_NAME + " " + data.USER_START_LNAME
    $(modal).find('p.user-start-name').html(user_start)

    /* ************** ACTION HEADER *************** */
    $('.modal-header').find('.text-secondary').removeClass('d-none').text('นัดหมาย/จองห้องประชุม')
    // $('.modal-header').find('h4.modal-title-status')
    $('.modal-footer').find('.approve-footer').addClass('d-none')
    /* ************** END ACTION HEADER *************** */
}

function detail(calEvent, jsEvent, view) {
    let vis = '',
        status_header = '',
        vis_html = '',
        btn_html = '',
        modal_detail, obj_detail = [],
        val_detail = [],
        modal_update, obj_update = [],
        val_update = [],
        entitled = '',
        status = '',
        vid = '';

    // console.log(calEvent)
    $('#detail-modal-car').find('[data-visitor=true]').addClass('d-none')
    $('#detail-modal-meeting').find('[data-visitor=true]').addClass('d-none')

    if (calEvent.TYPE_ID == 1 || calEvent.TYPE_ID == 3) {
        /* ************* DETAIL **************** */
        modal_detail = '#detail-modal-meeting'

        /* ************** UPDATE *************** */
        modal_update = '#update-modal-meeting';

        status_header = 'แบบร่างการนัดหมาย/จองห้องประชุม'
    } else if (calEvent.TYPE_ID == 2 || calEvent.TYPE_ID == 4) {
        /* ************* DETAIL **************** */
        modal_detail = '#detail-modal-car'

        /* ************** UPDATE *************** */
        modal_update = '#update-modal-car'
        status_header = 'แบบร่างการจองรถ'
    }

    $(modal_detail).modal("show")
    $(modal_detail).find(".delete-meeting").attr("data-event-id", calEvent.ID)
    $(modal_detail).find(".delete-meeting").attr("data-event-code", calEvent.CODE)

    /* ************* DETAIL **************** */
    obj_detail.push('[name=detail-type]', '[name=detail-name]', '[name=detail-head]', '[name=detail-description]',
        '[name=detail-dates]', '[name=detail-datee]', '[name=detail-times]', '[name=detail-timee]',
        '[name=detail-rooms]')
    // obj_detail.push('.detail-type', '.detail-name', '.detail-head', '.detail-description',
    //     '.detail-dates', '.detail-datee', '.detail-times', '.detail-timee',
    //     '.detail-rooms')

    val_detail.push(calEvent.TYPE_NAME, calEvent.EVENT_NAME, calEvent.STAFF_ID, calEvent.EVENT_DESCRIPTION,
        calEvent.DATE_BEGIN, calEvent.DATE_END, calEvent.TIME_BEGIN, calEvent.TIME_END, calEvent.ROOMS_ID)

    modalShow(modal_detail, obj_detail, val_detail)
    /* ************* END DETAIL **************** */

    /* ************** UPDATE *************** */
    obj_update.push('[name=item_id]', '[name=code]', '[name=update-type-id]', '[name=update-type-name]',
        '[name=update-name]',
        '[name=update-head]', '[name=update-description]', '[name=update-dates]', '[name=update-datee]',
        'select[name=update-times]', 'select[name=update-timee]', '[name=update-rooms-id]')

    val_update.push(calEvent.ID, calEvent.CODE, calEvent.TYPE_ID, calEvent.TYPE_NAME, calEvent.EVENT_NAME, calEvent
        .STAFF_ID, calEvent
        .EVENT_DESCRIPTION, calEvent.DATE_BEGIN, calEvent.DATE_END, calEvent.TIME_BEGIN, calEvent.TIME_END, calEvent
        .ROOMS_ID)

    modalShow(modal_update, obj_update, val_update)
    /* ************** END UPDATE *************** */

    /* ************** ADD VISITOR *************** */
    if (calEvent.VISITOR) {
        let status_vis = "",
            vis_btn = "";
        for (let i = 0; i < calEvent.VISITOR.length; i++) {
            btn_vis_action = `
            <button type='button' class='btn btn-icon waves-effect waves-light btn-secondary reject' data-id='${calEvent.VISITOR[i].EID}' data-event-id='${calEvent.ID}' data-event-code='${calEvent.CODE}'> <i class='fa fa-trash-alt'></i> </button>
            <button type='button' class='btn btn-icon waves-effect waves-light btn-danger deny' data-id='${calEvent.VISITOR[i].EID}' data-event-id='${calEvent.ID}' data-event-code='${calEvent.CODE}'> <i class='fas fa-times'></i> </button>
            <button type='button' class='btn btn-icon waves-effect btn-success defer'  data-id='${calEvent.VISITOR[i].EID}' data-event-id='${calEvent.ID}' data-event-code='${calEvent.CODE}'> <i class='fas fa-check'></i> </button>
`
            if (calEvent.VISITOR[i].VSTATUS == 1) {
                status_vis =
                    `<span class='status_vis'>รอตอบรับ</span>`
            } else if (calEvent.VISITOR[i].VSTATUS == 2) {
                status_vis =
                    `<span class='status_vis'>เข้าร่วม</span>`
            } else if (calEvent.VISITOR[i].VSTATUS == 3) {
                status_vis =
                    `<span class='status_vis'>ปฏิเสธ</span>`
            }
            if (calEvent.USER_START == 1 && calEvent.VISITOR[i].VSTATUS == 1) {
                status_vis = status_vis + btn_vis_action
            }

            vis_html = vis_html + calEvent.VISITOR[i].VNAME + ' ' + calEvent.VISITOR[i].VLNAME + ' ' + status_vis +
                '<br>'

            vid = calEvent.VISITOR[i].EID
        }

        user_visitor = calEvent.VISITOR.map((item, index) => {
            return item.VID
        })
        $('select[name=update-visitor]').val(user_visitor).trigger('change')

        $(modal_detail).find('[data-visitor=true]').removeClass('d-none')
        $(modal_detail).find('h5.visitor-name').html(vis_html)

        $(modal_update).find('[data-visitor=true]').removeClass('d-none')
    }
    /* ************** END ADD VISITOR *************** */

    user_start = calEvent.USER_START_NAME + " " + calEvent.USER_START_LNAME
    $(modal_detail).find('p.user-start-name').html(user_start)

    /* ************** ACTION FOOTER *************** */
    entitled = calEvent.class
    status = calEvent.STATUS_COMPLETE
    event_id = calEvent.ID
    event_code = calEvent.CODE
    button_action(modal_detail, entitled, status, event_id, event_code, vid)
    /* ************** END ACTION FOOTER *************** */

    /* ************** ACTION HEADER *************** */
    // console.log(calEvent)
    $('.modal-header').find('h4.modal-title-status').text(calEvent.STATUS_COMPLETE_NAME)
    if (calEvent.class == "draft") {
        $('.modal-header').find('.text-secondary').removeClass('d-none').text(status_header)
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        // $('.modal-header').find('.text-warning').html(calEvent.STATUS_COMPLETE_NAME)
    } else if (calEvent.STATUS_COMPLETE == 1) {
        $('.modal-footer').find('.approve-footer').removeClass('d-none')
        $('.modal-header').find('.text-warning').removeClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        $('.modal-header').find('.text-warning').html(calEvent.STATUS_COMPLETE_NAME)
    } else if (calEvent.STATUS_COMPLETE == 2) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').removeClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        $('.modal-header').find('.text-warning').html(calEvent.STATUS_COMPLETE_NAME)
    } else if (calEvent.STATUS_COMPLETE == 3) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').removeClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        $('.modal-header').find('.text-danger').html(calEvent.STATUS_COMPLETE_NAME)
    } else if (calEvent.STATUS_COMPLETE == 4) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').removeClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        $('.modal-header').find('.text-secondary').html(calEvent.STATUS_COMPLETE_NAME)
    } else if (calEvent.STATUS_COMPLETE == 5) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').removeClass('d-none')
        $('.modal-header').find('.text-orange').html(calEvent.STATUS_COMPLETE_NAME)
    }
    /* ************** END ACTION HEADER *************** */
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
            <td>
                <div class="btn-group dropdown">
                    <a class="text-primary dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item btn-detail-meeting" data-dismiss="modal">
                                <span class="align-middle">รายละเอียด</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item btn-draft-meeting" data-toggle="modal" data-dismiss="modal">
                                <span class="align-middle">แก้ไข</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item btn-update-meeting" data-toggle="modal" data-dismiss="modal">
                                <span class="align-middle">นำไปใช้</span>
                            </a>

                            <!-- item-->
                            <a href="" class="dropdown-item delete-meeting" data-event-id='${item.ID}' data-event-code='${item.CODE}'>
                                <span class="align-middle">ลบ</span>
                            </a>
                        </div>

                </div>
            </td>
        </tr>
        `
        } else if (item.TYPE_ID == 4) {
            html_dom[i] = `
        <tr>
            <th>${i}</th>
            <td>${item.TYPE_NAME}</td>
            <td>${item.EVENT_NAME}</td>

            <div class="btn-group dropdown">
                    <a class="text-primary dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item btn-detail-car" data-dismiss="modal">
                                <span class="align-middle">รายละเอียด</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item btn-update-car" data-toggle="modal" data-target="#update-modal-car" data-dismiss="modal">
                                <span class="align-middle">แก้ไข</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${item.ID}" class="dropdown-item btn-update-meeting" data-toggle="modal" data-dismiss="modal">
                                <span class="align-middle">นำไปใช้</span>
                            </a>

                            <!-- item-->
                            <a class="dropdown-item delete-meeting" data-dismiss="modal" data-event-id='${item.ID}' data-event-code='${item.CODE}'>
                                <span class="align-middle">ลบ</span>
                            </a>
                        </div>

                </div>
        </tr>
        `
        }

    })
    $('table#modal_draft').find('tbody').html(html_dom)
}

function swal_alert(icon, title, text) {
    $('.modal').modal('hide')
    Swal.fire(title, text, icon).then((result) => {
        if (result.isConfirmed) {

            // calendarDestroy()
        }
        calendarDestroy('#calendar', url_calendar)
    })

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
            // calendarDestroy()
            delete_meeting(data)
            // if (data.vid) {
            //     reject_visitor(data)
            // } else {
            // }
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
            } else if (func == "restore") {
                restore(data)
            }

        }
    })
    // calendarDestroy('#calendar')

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

function restore(data) {
    let url = "restore"
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