<script>
/* ********** ADDITIONAL FUNCTION ********** */
function component_show(modal, obj, val) {
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

function draft_to_use(data, type) {
    let vis = '',
        vis_html = '',
        btn_html = '',
        modal, obj = [],
        val = [],
        entitled = '',
        status = '',
        vid = '';

    if (data.TYPE_ID == 4) {
        modal = '#update-modal-meeting';
        if (type == "use") {
            $(modal).find("[name=update-type-id]").val(1)
            $(modal).find("[name=update-type-name]").val("จองห้องประชุม")
            $(modal).find("input[name=insert-rooms-id]").attr("disabled")
            $(modal).find(".rooms-inline").removeClass("d-none")
            $(modal).find(".meeting-inline").addClass("d-none")

        } else {
            $(modal).find("[name=update-type-id]").val(4)
            $(modal).find("[name=update-type-name]").val("แบบร่างการจองห้องประชุม")
            $(modal).find("input[name=insert-rooms-id]").removeAttr("disabled")
            $(modal).find(".rooms-inline").addClass("d-none")
            $(modal).find(".meeting-inline").removeClass("d-none")

        }

    } else if (data.TYPE_ID == 5) {
        modal = '#update-modal-car'
        if (type == "use") {
            $(modal).find("[name=update-type-id]").val(2)
            $(modal).find("[name=update-type-name]").val("จองรถ")

        } else {
            $(modal).find("[name=update-type-id]").val(5)
            $(modal).find("[name=update-type-name]").val("แบบร่างการจองรถ")

        }
    } else if (data.TYPE_ID == 6) {
        modal = '#update-modal-meeting'
        if (type == "use") {
            $(modal).find("[name=update-type-id]").val(3)
            $(modal).find("[name=update-type-name]").val("นัดหมายกิจกรรม")
            $(modal).find("input[name=insert-rooms-id]").attr("disabled")
            $(modal).find(".rooms-inline").removeClass("d-none")
            $(modal).find(".meeting-inline").addClass("d-none")

        } else {
            $(modal).find("[name=update-type-id]").val(6)
            $(modal).find("[name=update-type-name]").val("แบบร่างการนัดหมายกิจกรรม")
            $(modal).find("input[name=insert-rooms-id]").removeAttr("disabled")
            $(modal).find(".rooms-inline").addClass("d-none")
            $(modal).find(".meeting-inline").removeClass("d-none")

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

    component_show(modal, obj, val)
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

function detail(data) {
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
        status_approval = '',
        attr_inline = [],
        attr_line = [],
        vid = '';

    console.log(data)
    // console.log(123)
    $('#detail-modal-car').find('[data-visitor=true]').addClass('d-none')
    $('#detail-modal-meeting').find('[data-visitor=true]').addClass('d-none')

    if (data.TYPE_ID == 1 || data.TYPE_ID == 4) {
        /* ************* DETAIL **************** */
        modal_detail = '#detail-modal-meeting'

        attr_inline.push('.meeting-inline', '.rooms-inline')
        attr_line.push('.meeting-line', '.rooms-line')

        /* ************** UPDATE *************** */
        modal_update = '#update-modal-meeting';
        $(modal_update).find(".rooms-inline").removeClass("d-none")
        $(modal_update).find(".meeting-inline").addClass("d-none")

        status_header = 'แบบร่างการจองห้องประชุม'
    } else if (data.TYPE_ID == 2 || data.TYPE_ID == 5) {
        /* ************* DETAIL **************** */
        modal_detail = '#detail-modal-car'

        // inline = '.meeting-inline'

        /* ************** UPDATE *************** */
        modal_update = '#update-modal-car'
        status_header = 'แบบร่างการจองรถ'
    } else if (data.TYPE_ID == 3 || data.TYPE_ID == 6) {
        /* ************* DETAIL **************** */
        modal_detail = '#detail-modal-meeting'

        attr_inline.push('.rooms-inline', '.meeting-inline')
        attr_line.push('.rooms-line', '.meeting-line')

        /* ************** UPDATE *************** */
        modal_update = '#update-modal-meeting';
        $(modal_update).find(".rooms-inline").addClass("d-none")
        $(modal_update).find(".meeting-inline").removeClass("d-none")

        status_header = 'แบบร่างการนัดหมายกิจกรรม'
    }

    $(modal_detail).modal("show")
    $(modal_detail).find(".delete-meeting").attr("data-event-id", data.ID)
    $(modal_detail).find(".delete-meeting").attr("data-event-code", data.CODE)

    /* ************* DETAIL **************** */
    obj_detail.push('[name=detail-type]', '[name=detail-name]', '[name=detail-head]', '[name=detail-description]',
        '[name=detail-dates]', '[name=detail-datee]', '[name=detail-times]', '[name=detail-timee]',
        '[name=detail-rooms-id]', '[name=detail-rooms-name]')
    // obj_detail.push('.detail-type', '.detail-name', '.detail-head', '.detail-description',
    //     '.detail-dates', '.detail-datee', '.detail-times', '.detail-timee',
    //     '.detail-rooms')

    val_detail.push(data.TYPE_NAME, data.EVENT_NAME, data.STAFF_ID, data.EVENT_DESCRIPTION,
        data.DATE_BEGIN, data.DATE_END, data.TIME_BEGIN_SHOW, data.TIME_END_SHOW, data.ROOMS_ID, data
        .ROOMS_NAME)

    component_show(modal_detail, obj_detail, val_detail)
    /* ************* END DETAIL **************** */

    /* ************** UPDATE *************** */
    obj_update.push('[name=item_id]', '[name=code]', '[name=update-type-id]', '[name=update-type-name]',
        '[name=update-name]',
        '[name=update-head]', '[name=update-description]', '[name=update-dates]', '[name=update-datee]',
        'select[name=update-times]', 'select[name=update-timee]', '[name=update-rooms-id]',
        '[name=update-rooms-name]')

    val_update.push(data.ID, data.CODE, data.TYPE_ID, data.TYPE_NAME, data.EVENT_NAME, data
        .STAFF_ID, data
        .EVENT_DESCRIPTION, data.DATE_BEGIN, data.DATE_END, data.TIME_BEGIN, data.TIME_END, data
        .ROOMS_ID, data.ROOMS_NAME)

    component_show(modal_update, obj_update, val_update)
    /* ************** END UPDATE *************** */

    /* ************** ADD VISITOR *************** */
    if (data.VISITOR) {
        let status_vis = "",
            vis_btn = "";
        for (let i = 0; i < data.VISITOR.length; i++) {
            btn_vis_action = `
            <button type='button' class='btn btn-icon waves-effect waves-light btn-secondary reject text-lg-center' data-id='${data.VISITOR[i].EID}' data-event-id='${data.ID}' data-event-code='${data.CODE}'> <i class='fa fa-trash-alt'></i> </button>
            <button type='button' class='btn btn-icon waves-effect waves-light btn-danger deny text-lg-center' data-id='${data.VISITOR[i].EID}' data-event-id='${data.ID}' data-event-code='${data.CODE}'> <i class='mdi mdi-account-remove'></i> </button>
            <button type='button' class='btn btn-icon waves-effect btn-success defer text-lg-center'  data-id='${data.VISITOR[i].EID}' data-event-id='${data.ID}' data-event-code='${data.CODE}'> <i class='mdi mdi-account-check'></i> </button>
`
            if (data.VISITOR[i].VSTATUS == 1) {
                status_vis =
                    `<span class='status_vis'>รอตอบรับ</span>`
            } else if (data.VISITOR[i].VSTATUS == 2) {
                status_vis =
                    `<span class='status_vis'>เข้าร่วม</span>`
            } else if (data.VISITOR[i].VSTATUS == 3) {
                status_vis =
                    `<span class='status_vis'>ปฏิเสธ</span>`
            }
            if (data.USER_START == my_id) { // my_id = session('user_emp') อยู่ใน views หลัก
                status_vis = status_vis + btn_vis_action
            }

            vis_html = vis_html + data.VISITOR[i].VNAME + ' ' + data.VISITOR[i].VLNAME + ' ' + status_vis +
                '<br>'

            vid = data.VISITOR[i].EID
        }

        user_visitor = data.VISITOR.map((item, index) => {
            return item.VID
        })
        $('select[name=update-visitor]').val(user_visitor).trigger('change')

        $(modal_detail).find('[data-visitor=true]').removeClass('d-none')
        $(modal_detail).find('h5.visitor-name').html(vis_html)

        $(modal_update).find('[data-visitor=true]').removeClass('d-none')
    }
    /* ************** END ADD VISITOR *************** */

    user_start = data.USER_START_NAME + " " + data.USER_START_LNAME
    $(modal_detail).find('p.user-start-name').html(user_start)

    /* ************** ACTION BUTTON *************** */
    if (data.STATUS_COMPLETE == 1 || data.STATUS_COMPLETE == 5) {
        if (!data.APPROVE_DATE && !data.DISAPPROVE_DATE) {
            status_approval = 'รออนุมัติ'
        } else if (data.APPROVE_DATE) {
            status_approval = 'อนุมัติ'
        } else if (data.DISAPPROVE_DATE) {
            status_approval = 'ไม่อนุมัติ'
        }
    }


    entitled = data.class
    status = data.STATUS_COMPLETE
    event_id = data.ID
    event_code = data.CODE
    button_action(modal_detail, entitled, status, status_approval, event_id, event_code, vid, attr_inline, attr_line)
    /* ************** END ACTION BUTTON *************** */

    /* ************** ACTION HEADER *************** */
    // console.log(data)
    $('.modal-header').find('h4.modal-title-status').text(data.STATUS_COMPLETE_NAME)
    if (data.class == "draft") {
        $('.modal-header').find('.text-secondary').removeClass('d-none').text(status_header)
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        // $('.modal-header').find('.text-warning').html(data.STATUS_COMPLETE_NAME)
    } else if (data.STATUS_COMPLETE == 1 || data.STATUS_COMPLETE == 5) {
        $('.modal-footer').find('.approve-footer').removeClass('d-none')
        $('.modal-header').find('.text-warning').removeClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        $('.modal-header').find('.text-warning').html(data.STATUS_COMPLETE_NAME)
    } else if (data.STATUS_COMPLETE == 2) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').removeClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        $('.modal-header').find('.text-warning').html(data.STATUS_COMPLETE_NAME)
    } else if (data.STATUS_COMPLETE == 3) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').removeClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        $('.modal-header').find('.text-danger').html(data.STATUS_COMPLETE_NAME)
    } else if (data.STATUS_COMPLETE == 4) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').removeClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
        $('.modal-header').find('.text-secondary').html(data.STATUS_COMPLETE_NAME)
    }
    /* else if () {
           $('.modal-footer').find('.approve-footer').addClass('d-none')
           $('.modal-header').find('.text-warning').addClass('d-none')
           $('.modal-header').find('.text-success').addClass('d-none')
           $('.modal-header').find('.text-danger').addClass('d-none')
           $('.modal-header').find('.text-secondary').addClass('d-none')
           $('.modal-header').find('.text-orange').removeClass('d-none')
           $('.modal-header').find('.text-orange').html(data.STATUS_COMPLETE_NAME)
       } */
    /* ************** END ACTION HEADER *************** */
}

function detail_draft(data) {
    // console.log(data)
    let i = 0,
        html_dom = []
    data.forEach(function(item, index) {
        i++
        if (item.TYPE_ID == 4 || item.TYPE_ID == 6) {
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
                            <a href="" data-id="${item.ID}" class="dropdown-item btn-detail-meeting" data-toggle="modal" data-dismiss="modal">
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
        } else if (item.TYPE_ID == 5) {
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

</script>