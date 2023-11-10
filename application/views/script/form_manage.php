<script>
/**@function
 *
 * form_rooms_manage(data = [])
 * form_car_manage(data = [])
 * form_meeting_manage(data = [])
 *
 * @array data
 * ข้อมูลดิบจาก database ยังไม่ได้จำแนก
 *
 * ################################
 *
 * @function
 *
 * form_manage(data = [])
 *
 * @array data
 * ข้อมูลที่จำแนกแล้ว โดยที่
 * index = ชื่อ field ภายใน form
 * item = ข้อมูลของ field ภายใน form
 * exp.
 * data.forEach(function(item , index) {
 *      $(index).val(item)
 * })
 * ################################
 */

function form_displayed(data) {
    let modal_detail, modal_update, status_head

    if (data.TYPE_ID == 1 || data.TYPE_ID == 3) {
        modal_detail = '#detail-modal-meeting'
        modal_update = '#update-modal-meeting'
        if (data.TYPE_ID == 1) {
            $(modal_detail).find('div.rooms-line').removeClass('d-none')
            $(modal_detail).find('div.meeting-line').addClass('d-none')

            $(modal_update).find('div.update-rooms').removeClass('d-none')
            $(modal_update).find('div.update-meeting').addClass('d-none')

        } else if (data.TYPE_ID == 3) {
            $(modal_detail).find('div.rooms-line').addClass('d-none')
            $(modal_detail).find('div.meeting-line').removeClass('d-none')

            $(modal_update).find('div.update-rooms').addClass('d-none')
            $(modal_update).find('div.update-meeting').removeClass('d-none')

        }
    } else {
        modal_detail = '#detail-modal-car'
        modal_update = '#update-modal-car'
    }

    $(modal_detail).modal('show')

    // form_displayed_body()
    form_displayed_layouts(data.STATUS_COMPLETE, data.class, modal_detail)
    form_displayed_data(data, modal_detail, modal_update)
    form_displayed_header(data.STATUS_COMPLETE, data.STATUS_COMPLETE_NAME)

    /********************************************* Form Data *********************************************/
    if (!data.APPROVE_DATE && !data.DISAPPROVE_DATE && !data.CANCLE_DATE) {
        $(modal_detail).find('[name=status-inline-text]').val('รออนุมัติ')
    } else if (data.APPROVE_DATE) {
        $(modal_detail).find('[name=status-inline-text]').val('อนุมัติ')
    } else if (data.DISAPPROVE_DATE) {
        $(modal_detail).find('[name=status-inline-text]').val('ไม่อนุมัติ')
    }

    /********************************************* Form Layouts *********************************************/


}

function form_displayed_layouts(status, role, modal_detail) {
    /* if (type == 1) {
        $(modal_detail).find('div.meeting-line').addClass('d-none')
        $(modal_detail).find('div.rooms-line').removeClass('d-none')
    } else if (type == 3) {
        $(modal_detail).find('div.rooms-line').addClass('d-none')
        $(modal_detail).find('div.meeting-line').removeClass('d-none')
    } */

    let addClass = {
            1: { // สถานะ pending
                me: '', // role 'me' ประธานสร้างวาระเอง ไม่มีสถานะ pending
                owner: {
                    'div.status-inline': 'col-md-3'
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำได้ทุกอย่าง
                child: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    '': '',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน อนุมัติ/ไม่อนุมัติเท่านั้น
                vis: '' // role 'vis' เป็นผู้เข้าร่วม ไม่มีสถานะ pending
            },
            2: { // สถานะ success
                me: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                vis: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
            },
            3: { // สถานะ failure
                me: '', // role 'me' ประธานสร้างวาระเอง ไม่มีสถานะ failure
                owner: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ย้อนกลับสถานะได้
                child: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ย้อนกลับสถานะได้
                vis: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม จะเห็นก็ต่อเมื่อ APPROVE_DATE !== null
            },
            4: { // สถานะ canceled
                me: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ย้อนกลับสถานะได้
                owner: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ย้อนกลับสถานะได้
                child: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ย้อนกลับสถานะได้
                vis: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม จะเห็นก็ต่อเมื่อ APPROVE_DATE !== null
            },
            5: { // สถานะ doing
                me: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ทำได้ทุกอย่างยกเว้นอนุมัติซ้ำ เพราะอนุมัติไปแล้ว
                owner: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำได้ทุกอย่างยกเว้นอนุมัติซ้ำ เพราะอนุมัติไปแล้ว
                child: {
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ปิดงานได้เท่านั้น (สำเร็จ/ยกเลิก)
                vis: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม ตอบรับได้เท่านั้น (เข้าร่วม/ไม่เข้าร่วม)
            },

        },
        removeClass = {
            1: { // สถานะ pending
                me: '', // role 'me' ประธานสร้างวาระเอง ไม่มีสถานะ pending
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-6',
                    'div.status-inline': 'd-none',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำได้ทุกอย่าง
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน อนุมัติ/ไม่อนุมัติเท่านั้น
                vis: '', // role 'vis' เป็นผู้เข้าร่วม ไม่มีสถานะ pending
            },
            2: { // สถานะ success
                me: {
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                owner: {
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                child: {
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                vis: {
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div[data-visitor=true]': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
            },
            3: { // สถานะ failure
                me: '', // role 'me' ประธานสร้างวาระเอง ย้อนกลับสถานะได้
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ย้อนกลับสถานะได้
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ย้อนกลับสถานะได้
                vis: {
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div[data-visitor=true]': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม จะเห็นก็ต่อเมื่อ APPROVE_DATE !== null
            },
            4: { // สถานะ canceled
                me: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ย้อนกลับสถานะได้
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ย้อนกลับสถานะได้
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ย้อนกลับสถานะได้
                vis: {
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div[data-visitor=true]': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม จะเห็นก็ต่อเมื่อ APPROVE_DATE !== null
            },
            5: { // สถานะ doing
                me: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ทำได้ทุกอย่างยกเว้นอนุมัติซ้ำ เพราะอนุมัติไปแล้ว
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำได้ทุกอย่างยกเว้นอนุมัติซ้ำ เพราะอนุมัติไปแล้ว
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ปิดงานได้เท่านั้น (สำเร็จ/ยกเลิก)
                vis: {
                    'div.status-inline': 'col-md-3',
                    'div.status-inline': 'd-none',
                    'div[data-visitor=true]': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม ตอบรับได้เท่านั้น (เข้าร่วม/ไม่เข้าร่วม)
            },
        }

    $.each(addClass[status][role], function(tagname, class_val) {

        $(modal_detail).find(tagname).addClass(class_val)
    });

    $.each(removeClass[status][role], function(tagname, class_val) {

        $(modal_detail).find(tagname).removeClass(class_val)
    });

}

function form_displayed_header(status, status_text) {
    if (status == 1 || status == 5) {
        $('.modal-header').find('.text-warning').removeClass('d-none').html(status_text)
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
    } else if (status == 2) {
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').removeClass('d-none').html(status_text)
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
    } else if (status == 3) {
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').removeClass('d-none').html(status_text)
        $('.modal-header').find('.text-secondary').addClass('d-none')
        $('.modal-header').find('.text-orange').addClass('d-none')
    } else if (status == 4) {
        $('.modal-header').find('.text-warning').addClass('d-none')
        $('.modal-header').find('.text-success').addClass('d-none')
        $('.modal-header').find('.text-danger').addClass('d-none')
        $('.modal-header').find('.text-secondary').removeClass('d-none').html(status_text)
        $('.modal-header').find('.text-orange').addClass('d-none')
    }

}

function form_displayed_data(data, modal_detail, modal_update) {
    // console.log(data.class)

    let form_update = {
            '[name=item_id]': data.ID,
            '[name=code]': data.CODE,
            '[name=update-type-id]': data.TYPE_ID,
            '[name=update-type-name]': data.TYPE_NAME,
            '[name=update-name]': data.EVENT_NAME,
            '[name=update-head]': data.STAFF_ID,
            '[name=update-rooms-id]': data.ROOMS_ID,
            '[name=update-rooms-name]': data.ROOMS_NAME,
            '[name=update-description]': data.EVENT_DESCRIPTION,
            '[name=update-dates]': data.DATE_BEGIN,
            '[name=update-datee]': data.DATE_END,
            'select[name=update-times]': data.TIME_BEGIN,
            'select[name=update-timee]': data.TIME_END,
            '[name=update-visitor]': data.VISITOR
        },
        form_detail = {
            '[name=type-id]': data.TYPE_ID,
            '[name=detail-type]': data.TYPE_NAME,
            '[name=detail-name]': data.EVENT_NAME,
            '[name=detail-head]': data.STAFF_ID,
            '[name=detail-rooms-id]': data.ROOMS_ID,
            '[name=detail-rooms-name]': data.ROOMS_NAME,
            '[name=detail-description]': data.EVENT_DESCRIPTION,
            '[name=detail-dates]': data.DATE_BEGIN,
            '[name=detail-datee]': data.DATE_END,
            '[name=detail-times]': data.TIME_BEGIN_SHOW,
            '[name=detail-timee]': data.TIME_END_SHOW,
            'user-start-name': data.USER_START_FULLNAME,
            'detail-visitor': data.VISITOR,
        },
        vid = [],
        visitor_name = [],
        status, role, event_id, event_code
// console.log(data.VISITOR)
    if (data.VISITOR) {
        let status_vis = "",
            vis_html = "",
            btn_action;
        for (let i = 0; i < data.VISITOR.length; i++) {
            //             btn_vis_action = `
            //             <button type='button' class='btn btn-icon waves-effect waves-light btn-secondary reject text-lg-center' data-id='${data.VISITOR[i].EID}' data-event-id='${data.ID}' data-event-code='${data.CODE}'> <i class='fa fa-trash-alt'></i> </button>
            //             <button type='button' class='btn btn-icon waves-effect waves-light btn-danger deny text-lg-center' data-id='${data.VISITOR[i].EID}' data-event-id='${data.ID}' data-event-code='${data.CODE}'> <i class='mdi mdi-account-remove'></i> </button>
            //             <button type='button' class='btn btn-icon waves-effect btn-success defer text-lg-center'  data-id='${data.VISITOR[i].EID}' data-event-id='${data.ID}' data-event-code='${data.CODE}'> <i class='mdi mdi-account-check'></i> </button>
            // `
            btn_action = `
            <div class="action-respond" data-row-id="${data.VISITOR[i].VID}"></div>
            `
            if (data.VISITOR[i].VSTATUS == 1) {
                status_vis =
                    `<span>รอตอบรับ</span>`
            } else if (data.VISITOR[i].VSTATUS == 2) {
                status_vis =
                    `<span>เข้าร่วม</span>`
            } else if (data.VISITOR[i].VSTATUS == 3) {
                status_vis =
                    `<span>ปฏิเสธ</span>`
            }
            if (data.class == 'me' || data.class == 'owner') { // my_id = session('user_emp') อยู่ใน views หลัก
                status_vis = status_vis + `<div class="action-respond" data-row-id="${data.VISITOR[i].EID}"></div>`
            }

            vis_html = vis_html + data.VISITOR[i].VNAME + ' ' + data.VISITOR[i].VLNAME + ' ' + status_vis +
                '<br>'

            // vid[i] = data.VISITOR[i].EID
            
        }

        user_visitor = data.VISITOR.map((item, index) => {
            return item.EID
        })
        $(modal_detail).find('select[name=update-visitor]').val(user_visitor).trigger('change')

        $(modal_detail).find('[data-visitor=true]').removeClass('d-none')
        $(modal_detail).find('h5.visitor-name').html(vis_html)

        // $(modal_update).find('[data-visitor=true]').removeClass('d-none')
    }

    $.each(form_detail, function(key, value) {
        if (key == 'user-start-name') {
            $(modal_detail).find('p.' + key).html(value)
        } else {
            $(modal_detail).find(key).val(value)
        }
    });

    $.each(form_update, function(key, value) {
        // console.log(key + ": " + value);

        $(modal_update).find(key).val(value)
    });
    btn_manage(data.STATUS_COMPLETE, data.class, data.ID, data.CODE, user_visitor)
    // return arrayReturn

}

// function form_meeting_manage(data = []) {
//     item = ['item_id',
//         'code',
//         'update-type-id',
//         'update-type-name',
//         'update-name',
//         'update-head',
//         'update-rooms-id',
//         'update-rooms-name',
//         'update-description',
//         'update-dates',
//         'update-datee',
//         'update-times',
//         'update-timee'
//     ]
// }

// function form_rooms_manage(data = []) {
//     let updateForm = {
//             'item_id': data.ID,
//             'code': data.CODE,
//             'update-type-id': data.TYPE_ID,
//             'update-type-name': data.TYPE_NAME,
//             'update-name': data.EVENT_NAME,
//             'update-head': data.STAFF_ID,
//             'update-rooms-id': data.ROOMS_ID,
//             'update-rooms-name': data.ROOMS_NAME,
//             'update-description': data.EVENT_DESCRIPTION,
//             'update-dates': data.DATE_BEGIN,
//             'update-datee': data.DATE_END,
//             'update-times': data.TIME_BEGIN_SHOW,
//             'update-timee': data.TIME_END_SHOW,
//             'update-visitor': data.VISITOR
//         },
//         detailForm = {
//             'type-id': data.TYPE_ID,
//             'detail-type': data.TYPE_NAME,
//             'detail-name': data.EVENT_NAME,
//             'detail-head': data.STAFF_ID,
//             'detail-rooms-id': data.ROOMS_ID,
//             'detail-rooms-name': data.ROOMS_NAME,
//             'detail-description': data.EVENT_DESCRIPTION,
//             'detail-dates': data.DATE_BEGIN,
//             'detail-datee': data.DATE_END,
//             'detail-times': data.TIME_BEGIN_SHOW,
//             'detail-timee': data.TIME_END_SHOW,
//             'detail-visitor': data.VISITOR,
//             'visitor-name': '',
//             'user-start-name': data.USER_START_FULLNAME
//         },
//         role = data.class,
//         status = data.STATUS_COMPLETE
//     /*
//         console.log(detailForm);
//         console.log(updateForm);
//      */

//     form_manage(detailForm, updateForm, status, role)
// }

// function form_car_manage(data = []) {

// }
// function form_manage(data = []) {
//     $('.action-header').empty()
//     $('.action-respond').empty()
//     $('.action-approval').addClass('d-none').empty()
//     $('.action-footer').empty()

//     let btn = btn_displayed(status)
//     // console.log(btn[status][role])
//     btn_all_in_modal(btn[status][role], 1, 'M2310001', 1)
// }

// function form_detail_displayed(data = []) {

//     /*********** ALL BUTTON IN 'DETAIL-MODAL' ***********/
//     /**
//      *
//      * action_header(me(!pending),owner,child (pending,failure,canceled,doing))
//      *  - ['header_update', 'header_delete']
//      *
//      * action_respond(me,owner (doing))
//      *  - ['body_reject', 'body_refuse', 'body_accept']
//      *
//      * action_approval(owner (pending))
//      *  - ['body_disapprove', 'body_approve']
//      *
//      * action_footer(child (doing))
//      *  - ['footer_disapprove', 'footer_approve']
//      *
//      * action_footer(vis (doing))
//      *  - ['footer_refuse', 'footer_accept']
//      *
//      * action_footer(me(doing),owner(pending,doing),child(doing))
//      *  - ['footer_cancel', 'footer_success']
//      *
//      * action_footer(me,owner,child (failure,canceled))
//      *  - ['footer_restore']
//      *
//      *
//      */

//     /*********** BUTTON TO BE DISPLAYED ON 'DETAIL-MODAL' ***********/
//     /********* BASED ON PERMISSION AND STATUS OF THIS EVENT *********/
//     let pending: {
//             me: '',
//             owner: {
//                 header: '.action-header',
//                 body: ['.action-respond', 'respond', '.action-approval', '.approval'],
//                 footer: ['.action-footer', 'operation']
//             },
//             child: {
//                 header: '.action-header',
//                 body: '',
//                 footer: ['.action-footer', 'approval']
//             },
//             vis: {
//                 header: '',
//                 body: '',
//                 footer: ''
//             }

//         },
//         success: {
//             me: {
//                 header: '',
//                 body: '',
//                 footer: ''
//             },
//             owner: {
//                 header: '',
//                 body: '',
//                 footer: ''
//             },
//             child: {
//                 header: '',
//                 body: '',
//                 footer: ''
//             },
//             vis: {
//                 header: '',
//                 body: '',
//                 footer: ''
//             }

//         },
//         failure: {
//             me: {
//                 header: '.action-header',
//                 body: '',
//                 footer: ['.action-footer', 'restore']
//             },
//             owner: {
//                 header: '.action-header',
//                 body: '',
//                 footer: ['.action-footer', 'restore']
//             },
//             child: {
//                 header: '.action-header',
//                 body: '',
//                 footer: ['.action-footer', 'restore']
//             },
//             vis: {
//                 header: '',
//                 body: '',
//                 footer: ''
//             }

//         },
//         canceled: {
//             me: {
//                 header: '.action-header',
//                 body: '',
//                 footer: ['.action-footer', 'restore']
//             },
//             owner: {
//                 header: '.action-header',
//                 body: '',
//                 footer: ['.action-footer', 'restore']
//             },
//             child: {
//                 header: '.action-header',
//                 body: '',
//                 footer: ['.action-footer', 'restore']
//             },
//             vis: {
//                 header: '',
//                 body: '',
//                 footer: ''
//             }

//         },
//         doing: {
//             me: {
//                 header: '.action-header',
//                 body: ['.action-respond', 'respond'],
//                 footer: ['.action-footer', 'operation']
//             },
//             owner: {
//                 header: '.action-header',
//                 body: ['.action-respond', 'respond'],
//                 footer: ['.action-footer', 'operation']
//             },
//             child: {
//                 header: '.action-header',
//                 body: '',
//                 footer: ['.action-footer', 'operation']
//             },
//             vis: {
//                 header: '',
//                 body: '',
//                 footer: ['.action-footer', 'respond']
//             }

//         };

//     let array = []

//     array['pending'] = btn_pending,
//         array['success'] = btn_success,
//         array['failure'] = btn_failure,
//         array['canceled'] = btn_canceled,
//         array['doing'] = btn_doing

//     return array
// }

// function btn_all_in_modal(data = [], event_id, event_code, event_vid = null) {
//     let btn_header = `
//             <div class="col-6">
//                 <div class="cardbox text-center">
//                     <button type="button" class="btn btn-warning btn-rounded btn-lg width-md waves-effect waves-light update-meeting item-cardbox" data-dismiss="modal">แก้ไข</button>
//                 </div>
//             </div>

//             <div class="col-6">
//                 <div class="cardbox text-center">
//                     <button type="button" class="btn btn-danger btn-rounded btn-lg width-md waves-effect waves-light item-cardbox delete-meeting" data-dismiss="modal">ลบ</button>
//                 </div>
//             </div>
//             `
//     // $('.action-header').html();
//     btn_body = {
//             approval: `
//             <div class="col-md-3 action-approval">
//                 <label class="control-label">action</label>
//                         <div>
//                             <button type='button' class='btn btn-icon waves-effect waves-light btn-danger btn-disapprove text-lg-center' data-event-id="${event_id}" data-event-code="${event_code}"> <i class='mdi mdi-file-document-box-remove'></i> </button>
//                             <button type='button' class='btn btn-icon waves-effect btn-success btn-approve text-lg-center'  data-event-id="${event_id}" data-event-code="${event_code}"> <i class='mdi mdi-file-document-box-check'></i> </button>
//                         </div>
//             </div>
//             `, // $('.action-approval').html(btn_body[approval]);
//             respond: `
//                 <button type='button' class='btn btn-icon waves-effect waves-light btn-secondary reject text-lg-center' data-id='${event_vid}' data-event-id='${event_id}' data-event-code='${event_code}'> <i class='fa fa-trash-alt'></i> </button>
//                 <button type='button' class='btn btn-icon waves-effect waves-light btn-danger deny text-lg-center' data-id='${event_vid}' data-event-id='${event_id}' data-event-code='${event_code}'> <i class='mdi mdi-account-remove'></i> </button>
//                 <button type='button' class='btn btn-icon waves-effect btn-success defer text-lg-center'  data-id='${event_vid}' data-event-id='${event_id}' data-event-code='${event_code}'> <i class='mdi mdi-account-check'></i> </button>
//             ` // $('.action-respond[data-row-id=]').html(btn_body[respond]);
//         },
//         btn_footer = {
//             approval: `
//             <button type="button" class="btn btn-danger waves-effect waves-light btn-disapprove" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่อนุมัติ</button>
//             <button type="button" class="btn btn-success waves-effect waves-light btn-approve" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">อนุมัติ</button>
//             `,
//             respond: `
//             <button type="button" class="btn btn-danger waves-effect waves-light btn-refuse" data-id="${event_vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่เข้าร่วม</button>
//             <button type="button" class="btn btn-success waves-effect waves-light btn-accept" data-id="${event_vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">เข้าร่วม</button>
//             `,
//             operation: `
//             <button type="button" class="btn btn-danger waves-effect waves-light btn-cancle" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ยกเลิก</button>
//             <button type="button" class="btn btn-success waves-effect waves-light btn-finish" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">สำเร็จ</button>
//             `,
//             restore: `
//             <button type="button" class="btn btn-success waves-effect waves-light btn-restore" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">นำกลับมาใช้</button>
//             `
//         }, // $('.action-footer').html();
//         className = '',
//         html = ''

//     if (data['header']) {
//         $(data['header']).html(btn_header)
//     }
//     if (data['body']) {

//         for (let i = 0; i < data['body'].length; i += 2) {
//             className = data['body'][i],
//                 html = data['body'][i + 1]
//             $(className).removeClass('d-none').html(btn_body[html])
//         }
//     }
//     if (data['footer']) {
//         className = data['footer'][0],
//             html = data['footer'][1]
//         $(className).html(btn_footer[html])
//     }
// }










// /* ********** ADDITIONAL FUNCTION ********** */
// function component_show(modal, obj, val) {
//     let length = 0;
//     if (modal && obj.length && val.length) {
//         if (obj.length == val.length) {
//             length = obj.length
//         }
//         for (let i = 0; i < length; i++) {
//             $(modal).find(obj[i]).val(val[i])
//         }
//     }
// }

// function draft_to_use(data, type) {
//     let vis = '',
//         vis_html = '',
//         btn_html = '',
//         modal, obj = [],
//         val = [],
//         entitled = '',
//         status = '',
//         vid = '';

//     if (data.TYPE_ID == 4) {
//         modal = '#update-modal-meeting';
//         if (type == "use") {
//             $(modal).find("[name=update-type-id]").val(1)
//             $(modal).find("[name=update-type-name]").val("จองห้องประชุม")
//             $(modal).find("input[name=insert-rooms-id]").attr("disabled")
//             $(modal).find(".rooms-inline").removeClass("d-none")
//             $(modal).find(".meeting-inline").addClass("d-none")

//         } else {
//             $(modal).find("[name=update-type-id]").val(4)
//             $(modal).find("[name=update-type-name]").val("แบบร่างการจองห้องประชุม")
//             $(modal).find("input[name=insert-rooms-id]").removeAttr("disabled")
//             $(modal).find(".rooms-inline").addClass("d-none")
//             $(modal).find(".meeting-inline").removeClass("d-none")

//         }

//     } else if (data.TYPE_ID == 5) {
//         modal = '#update-modal-car'
//         if (type == "use") {
//             $(modal).find("[name=update-type-id]").val(2)
//             $(modal).find("[name=update-type-name]").val("จองรถ")

//         } else {
//             $(modal).find("[name=update-type-id]").val(5)
//             $(modal).find("[name=update-type-name]").val("แบบร่างการจองรถ")

//         }
//     } else if (data.TYPE_ID == 6) {
//         modal = '#update-modal-meeting'
//         if (type == "use") {
//             $(modal).find("[name=update-type-id]").val(3)
//             $(modal).find("[name=update-type-name]").val("นัดหมายกิจกรรม")
//             $(modal).find("input[name=insert-rooms-id]").attr("disabled")
//             $(modal).find(".rooms-inline").removeClass("d-none")
//             $(modal).find(".meeting-inline").addClass("d-none")

//         } else {
//             $(modal).find("[name=update-type-id]").val(6)
//             $(modal).find("[name=update-type-name]").val("แบบร่างการนัดหมายกิจกรรม")
//             $(modal).find("input[name=insert-rooms-id]").removeAttr("disabled")
//             $(modal).find(".rooms-inline").addClass("d-none")
//             $(modal).find(".meeting-inline").removeClass("d-none")

//         }
//     }

//     $(modal).modal("show")
//     $(modal).find(".delete-meeting").attr("data-event-id", data.ID)
//     $(modal).find(".delete-meeting").attr("data-event-code", data.CODE)

//     /* ************** UPDATE *************** */
//     obj.push('[name=item_id]', '[name=code]',
//         '[name=update-name]',
//         '[name=update-head]', '[name=update-description]', '[name=update-dates]', '[name=update-datee]',
//         'select[name=update-times]', 'select[name=update-timee]', '[name=update-rooms-id]')

//     val.push(data.ID, data.CODE, data.EVENT_NAME, data
//         .STAFF_ID, data
//         .EVENT_DESCRIPTION, data.DATE_BEGIN, data.DATE_END, data.TIME_BEGIN, data.TIME_END, data
//         .ROOMS_ID)

//     component_show(modal, obj, val)
//     /* ************** END UPDATE *************** */

//     /* ************** ADD VISITOR *************** */
//     if (data.VISITOR) {
//         user_visitor = data.VISITOR.map((item, index) => {
//             // console.log(item,index)
//             return item.VID
//         })
//         $('select[name=update-visitor]').val(user_visitor).trigger('change')

//         // $(modal).find('[data-visitor=true]').removeClass('d-none')
//     }

//     /* ************** END ADD VISITOR *************** */

//     user_start = data.USER_START_NAME + " " + data.USER_START_LNAME
//     $(modal).find('p.user-start-name').html(user_start)

//     /* ************** ACTION HEADER *************** */
//     $('.modal-header').find('.text-secondary').removeClass('d-none').text('นัดหมาย/จองห้องประชุม')
//     // $('.modal-header').find('h4.modal-title-status')
//     $('.modal-footer').find('.approve-footer').addClass('d-none')
//     /* ************** END ACTION HEADER *************** */
// }

// function detail(data) {
//     let vis = '',
//         status_header = '',
//         vis_html = '',
//         btn_html = '',
//         modal_detail, obj_detail = [],
//         val_detail = [],
//         modal_update, obj_update = [],
//         val_update = [],
//         entitled = '',
//         status = '',
//         status_approval = '',
//         attr_inline = [],
//         attr_line = [],
//         vid = '';

//     // console.log(data)
//     // console.log(123)
//     $('#detail-modal-car').find('[data-visitor=true]').addClass('d-none')
//     $('#detail-modal-meeting').find('[data-visitor=true]').addClass('d-none')

//     if (data.TYPE_ID == 1 || data.TYPE_ID == 4) {
//         /* ************* DETAIL **************** */
//         modal_detail = '#detail-modal-meeting'

//         attr_inline.push('.meeting-inline', '.rooms-inline')
//         attr_line.push('.meeting-line', '.rooms-line')

//         /* ************** UPDATE *************** */
//         modal_update = '#update-modal-meeting';
//         $(modal_update).find(".rooms-inline").removeClass("d-none")
//         $(modal_update).find(".meeting-inline").addClass("d-none")

//         status_header = 'แบบร่างการจองห้องประชุม'
//     } else if (data.TYPE_ID == 2 || data.TYPE_ID == 5) {
//         /* ************* DETAIL **************** */
//         modal_detail = '#detail-modal-car'

//         // inline = '.meeting-inline'

//         /* ************** UPDATE *************** */
//         modal_update = '#update-modal-car'
//         status_header = 'แบบร่างการจองรถ'
//     } else if (data.TYPE_ID == 3 || data.TYPE_ID == 6) {
//         /* ************* DETAIL **************** */
//         modal_detail = '#detail-modal-meeting'

//         attr_inline.push('.rooms-inline', '.meeting-inline')
//         attr_line.push('.rooms-line', '.meeting-line')

//         /* ************** UPDATE *************** */
//         modal_update = '#update-modal-meeting';
//         $(modal_update).find(".rooms-inline").addClass("d-none")
//         $(modal_update).find(".meeting-inline").removeClass("d-none")

//         status_header = 'แบบร่างการนัดหมายกิจกรรม'
//     }

//     $(modal_detail).modal("show")
//     $(modal_detail).find(".delete-meeting").attr("data-event-id", data.ID)
//     $(modal_detail).find(".delete-meeting").attr("data-event-code", data.CODE)

//     /* ************* DETAIL **************** */
//     obj_detail.push('[name=detail-type]', '[name=detail-name]', '[name=detail-head]', '[name=detail-description]',
//         '[name=detail-dates]', '[name=detail-datee]', '[name=detail-times]', '[name=detail-timee]',
//         '[name=detail-rooms-id]', '[name=detail-rooms-name]')
//     // obj_detail.push('.detail-type', '.detail-name', '.detail-head', '.detail-description',
//     //     '.detail-dates', '.detail-datee', '.detail-times', '.detail-timee',
//     //     '.detail-rooms')

//     val_detail.push(data.TYPE_NAME, data.EVENT_NAME, data.STAFF_ID, data.EVENT_DESCRIPTION,
//         data.DATE_BEGIN, data.DATE_END, data.TIME_BEGIN_SHOW, data.TIME_END_SHOW, data.ROOMS_ID, data
//         .ROOMS_NAME)

//     component_show(modal_detail, obj_detail, val_detail)
//     /* ************* END DETAIL **************** */

//     /* ************** UPDATE *************** */
//     obj_update.push('[name=item_id]', '[name=code]', '[name=update-type-id]', '[name=update-type-name]',
//         '[name=update-name]',
//         '[name=update-head]', '[name=update-description]', '[name=update-dates]', '[name=update-datee]',
//         'select[name=update-times]', 'select[name=update-timee]', '[name=update-rooms-id]',
//         '[name=update-rooms-name]')

//     val_update.push(data.ID, data.CODE, data.TYPE_ID, data.TYPE_NAME, data.EVENT_NAME, data
//         .STAFF_ID, data
//         .EVENT_DESCRIPTION, data.DATE_BEGIN, data.DATE_END, data.TIME_BEGIN, data.TIME_END, data
//         .ROOMS_ID, data.ROOMS_NAME)

//     component_show(modal_update, obj_update, val_update)
//     /* ************** END UPDATE *************** */

//     /* ************** ADD VISITOR *************** */
//     if (data.VISITOR) {
//         let status_vis = "",
//             vis_btn = "";
//         for (let i = 0; i < data.VISITOR.length; i++) {
//             btn_vis_action = `
//             <div class="action-respond" data-row-id="">
//             </div>`
//             if (data.VISITOR[i].VSTATUS == 1) {
//                 status_vis =
//                     `<span class='status_vis'>รอตอบรับ</span>`
//             } else if (data.VISITOR[i].VSTATUS == 2) {
//                 status_vis =
//                     `<span class='status_vis'>เข้าร่วม</span>`
//             } else if (data.VISITOR[i].VSTATUS == 3) {
//                 status_vis =
//                     `<span class='status_vis'>ปฏิเสธ</span>`
//             }
//             if (data.USER_START == my_id) { // my_id = session('user_emp') อยู่ใน views หลัก
//                 status_vis = status_vis + btn_vis_action
//             }

//             vis_html = vis_html + data.VISITOR[i].VNAME + ' ' + data.VISITOR[i].VLNAME + ' ' + status_vis +
//                 '<br>'

//             vid = data.VISITOR[i].EID
//         }

//         user_visitor = data.VISITOR.map((item, index) => {
//             return item.VID
//         })
//         $('select[name=update-visitor]').val(user_visitor).trigger('change')

//         $(modal_detail).find('[data-visitor=true]').removeClass('d-none')
//         $(modal_detail).find('h5.visitor-name').html(vis_html)

//         $(modal_update).find('[data-visitor=true]').removeClass('d-none')
//     }
//     /* ************** END ADD VISITOR *************** */

//     user_start = data.USER_START_NAME + " " + data.USER_START_LNAME
//     $(modal_detail).find('p.user-start-name').html(user_start)

//     /* ************** ACTION BUTTON *************** */
//     if (data.STATUS_COMPLETE == 1 || data.STATUS_COMPLETE == 5) {
//         if (!data.APPROVE_DATE && !data.DISAPPROVE_DATE) {
//             status_approval = 'รออนุมัติ'
//         } else if (data.APPROVE_DATE) {
//             status_approval = 'อนุมัติ'
//         } else if (data.DISAPPROVE_DATE) {
//             status_approval = 'ไม่อนุมัติ'
//         }
//     }


//     entitled = data.class
//     status = data.STATUS_COMPLETE
//     event_id = data.ID
//     event_code = data.CODE
//     button_action(modal_detail, entitled, status, status_approval, event_id, event_code, vid, attr_inline, attr_line)
//     /* ************** END ACTION BUTTON *************** */

//     /* ************** ACTION HEADER *************** */
//     // console.log(data)
//     $('.modal-header').find('h4.modal-title-status').text(data.STATUS_COMPLETE_NAME)
//     if (data.class == "draft") {
//         $('.modal-header').find('.text-secondary').removeClass('d-none').text(status_header)
//         $('.modal-footer').find('.approve-footer').addClass('d-none')
//         $('.modal-header').find('.text-warning').addClass('d-none')
//         $('.modal-header').find('.text-success').addClass('d-none')
//         $('.modal-header').find('.text-danger').addClass('d-none')
//         $('.modal-header').find('.text-orange').addClass('d-none')
//         // $('.modal-header').find('.text-warning').html(data.STATUS_COMPLETE_NAME)
//     } else if (data.STATUS_COMPLETE == 1 || data.STATUS_COMPLETE == 5) {
//         $('.modal-footer').find('.approve-footer').removeClass('d-none')
//         $('.modal-header').find('.text-warning').removeClass('d-none')
//         $('.modal-header').find('.text-success').addClass('d-none')
//         $('.modal-header').find('.text-danger').addClass('d-none')
//         $('.modal-header').find('.text-secondary').addClass('d-none')
//         $('.modal-header').find('.text-orange').addClass('d-none')
//         $('.modal-header').find('.text-warning').html(data.STATUS_COMPLETE_NAME)
//     } else if (data.STATUS_COMPLETE == 2) {
//         $('.modal-footer').find('.approve-footer').addClass('d-none')
//         $('.modal-header').find('.text-warning').addClass('d-none')
//         $('.modal-header').find('.text-success').removeClass('d-none')
//         $('.modal-header').find('.text-danger').addClass('d-none')
//         $('.modal-header').find('.text-secondary').addClass('d-none')
//         $('.modal-header').find('.text-orange').addClass('d-none')
//         $('.modal-header').find('.text-warning').html(data.STATUS_COMPLETE_NAME)
//     } else if (data.STATUS_COMPLETE == 3) {
//         $('.modal-footer').find('.approve-footer').addClass('d-none')
//         $('.modal-header').find('.text-warning').addClass('d-none')
//         $('.modal-header').find('.text-success').addClass('d-none')
//         $('.modal-header').find('.text-danger').removeClass('d-none')
//         $('.modal-header').find('.text-secondary').addClass('d-none')
//         $('.modal-header').find('.text-orange').addClass('d-none')
//         $('.modal-header').find('.text-danger').html(data.STATUS_COMPLETE_NAME)
//     } else if (data.STATUS_COMPLETE == 4) {
//         $('.modal-footer').find('.approve-footer').addClass('d-none')
//         $('.modal-header').find('.text-warning').addClass('d-none')
//         $('.modal-header').find('.text-success').addClass('d-none')
//         $('.modal-header').find('.text-danger').addClass('d-none')
//         $('.modal-header').find('.text-secondary').removeClass('d-none')
//         $('.modal-header').find('.text-orange').addClass('d-none')
//         $('.modal-header').find('.text-secondary').html(data.STATUS_COMPLETE_NAME)
//     }
//     /* else if () {
//            $('.modal-footer').find('.approve-footer').addClass('d-none')
//            $('.modal-header').find('.text-warning').addClass('d-none')
//            $('.modal-header').find('.text-success').addClass('d-none')
//            $('.modal-header').find('.text-danger').addClass('d-none')
//            $('.modal-header').find('.text-secondary').addClass('d-none')
//            $('.modal-header').find('.text-orange').removeClass('d-none')
//            $('.modal-header').find('.text-orange').html(data.STATUS_COMPLETE_NAME)
//        } */
//     /* ************** END ACTION HEADER *************** */
// }

// function detail_draft(data) {
//     // console.log(data)
//     let i = 0,
//         html_dom = []
//     data.forEach(function(item, index) {
//         i++
//         if (item.TYPE_ID == 4 || item.TYPE_ID == 6) {
//             html_dom[i] = `
//         <tr>
//             <th>${i}</th>
//             <td>${item.TYPE_NAME}</td>
//             <td>${item.EVENT_NAME}</td>
//             <td>
//                 <div class="btn-group dropdown">
//                     <a class="text-primary dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
//                         <i class="mdi mdi-dots-vertical"></i>
//                     </a>
//                         <div class="dropdown-menu dropdown-menu-right">
//                             <!-- item-->
//                             <a href="" data-id="${item.ID}" class="dropdown-item btn-detail-meeting" data-toggle="modal" data-dismiss="modal">
//                                 <span class="align-middle">รายละเอียด</span>
//                             </a>

//                             <!-- item-->
//                             <a href="" data-id="${item.ID}" class="dropdown-item btn-draft-meeting" data-toggle="modal" data-dismiss="modal">
//                                 <span class="align-middle">แก้ไข</span>
//                             </a>

//                             <!-- item-->
//                             <a href="" data-id="${item.ID}" class="dropdown-item btn-update-meeting" data-toggle="modal" data-dismiss="modal">
//                                 <span class="align-middle">นำไปใช้</span>
//                             </a>

//                             <!-- item-->
//                             <a href="" class="dropdown-item delete-meeting" data-event-id='${item.ID}' data-event-code='${item.CODE}'>
//                                 <span class="align-middle">ลบ</span>
//                             </a>
//                         </div>

//                 </div>
//             </td>
//         </tr>
//         `
//         } else if (item.TYPE_ID == 5) {
//             html_dom[i] = `
//         <tr>
//             <th>${i}</th>
//             <td>${item.TYPE_NAME}</td>
//             <td>${item.EVENT_NAME}</td>

//             <div class="btn-group dropdown">
//                     <a class="text-primary dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
//                         <i class="mdi mdi-dots-vertical"></i>
//                     </a>
//                         <div class="dropdown-menu dropdown-menu-right">
//                             <!-- item-->
//                             <a href="" data-id="${item.ID}" class="dropdown-item btn-detail-car" data-dismiss="modal">
//                                 <span class="align-middle">รายละเอียด</span>
//                             </a>

//                             <!-- item-->
//                             <a href="" data-id="${item.ID}" class="dropdown-item btn-update-car" data-toggle="modal" data-target="#update-modal-car" data-dismiss="modal">
//                                 <span class="align-middle">แก้ไข</span>
//                             </a>

//                             <!-- item-->
//                             <a href="" data-id="${item.ID}" class="dropdown-item btn-update-meeting" data-toggle="modal" data-dismiss="modal">
//                                 <span class="align-middle">นำไปใช้</span>
//                             </a>

//                             <!-- item-->
//                             <a class="dropdown-item delete-meeting" data-dismiss="modal" data-event-id='${item.ID}' data-event-code='${item.CODE}'>
//                                 <span class="align-middle">ลบ</span>
//                             </a>
//                         </div>

//                 </div>
//         </tr>
//         `
//         }

//     })
//     $('table#modal_draft').find('tbody').html(html_dom)
// }
</script>