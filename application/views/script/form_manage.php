<script>
/**
 * 
 * function
 * createDraftModal(url_draft)
 * function สำหรับติดต่อกับ controller เพื่อขอข้อมูลจาก database
 * url_draft รับค่ามาจาก script หลักของ view
 * และ processing data เพื่อส่งค่าไปที่ DataTable
 * 
 */

function createDraftModal(url_draft) {
    get_data_draft(url_draft)
        .then((data) => {
            let dataDefault = [];
            if (data) {
                data.forEach(function(item, index) {
                    dataDefault.push(item);
                })
                detail_drafts(dataDefault)
            }
        })
}

/**
 * 
 * 
 */

/**
 * 
 * function
 * detail_drafts(data)
 * function สำหรับสร้าง DataTable โดยที่
 * data รับค่ามาจาก function createDraftModal
 * แล้วนำข้อมูลมาแสดงใน DataTable
 * 
 */

function detail_drafts(data) {
    $('#modal_draft').DataTable().destroy();

    $('#modal_draft').DataTable({
        data: data,
        autoWidth: false,
        "order": [],
        columns: [{
                "data": "TYPE_NAME"
            },
            {
                "data": "EVENT_NAME"
            },
            {
                "data": "ID"
            },
        ],
        "createdRow": function(row, data, index) {
            let table_btn_name =
                `
                <div class="btn-group dropdown">
                    <a class="text-primary dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="" data-id="${data['ID']}" class="dropdown-item btn-detail-meeting" data-toggle="modal" data-dismiss="modal">
                                <span class="align-middle">รายละเอียด</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${data['ID']}" class="dropdown-item btn-draft-meeting" data-toggle="modal" data-dismiss="modal">
                                <span class="align-middle">แก้ไข</span>
                            </a>

                            <!-- item-->
                            <a href="" data-id="${data['ID']}" class="dropdown-item btn-update-meeting" data-toggle="modal" data-dismiss="modal">
                                <span class="align-middle">นำไปใช้</span>
                            </a>

                            <!-- item-->
                            <a href="" class="dropdown-item delete-meeting" data-event-id='${data['ID']}' data-event-code='${data['CODE']}'>
                                <span class="align-middle">ลบ</span>
                            </a>
                        </div>
                </div>
         `
            $('td', row).eq(2).html(table_btn_name)
        },

        // dom: datatable_dom,
        // buttons: datatable_button,
    });
}

/**
 * 
 * 
 */

/**
 * 
 * function
 * detail_drafts(data)
 * function สำหรับสร้าง DataTable โดยที่
 * data รับค่ามาจาก function createDraftModal
 * แล้วนำข้อมูลมาแสดงใน DataTable
 * 
 */

function form_displayed(data) {
    let modal_detail, modal_update, status_head

    modal_detail = '#detail-modal-meeting'
    modal_update = '#update-modal-meeting'

    if (data.TYPE_ID == 1) {
        $(modal_detail).find('div.rooms-line').removeClass('d-none')
        $(modal_detail).find('div.btn-notify').removeClass('d-none')
        $(modal_detail).find('div.meeting-line').addClass('d-none')
        $(modal_detail).find('div.meeting-inline').addClass('d-none')
        $(modal_detail).find('div.rooms-inline').addClass('d-none')

        $(modal_update).find('div.update-rooms').removeClass('d-none')
        $(modal_update).find('div.update-meeting-data').addClass('d-none')

    } else if (data.TYPE_ID == 3) {
        $(modal_detail).find('div.meeting-line').removeClass('d-none')
        $(modal_detail).find('div.btn-notify').removeClass('d-none')
        $(modal_detail).find('div.rooms-line').addClass('d-none')
        $(modal_detail).find('div.meeting-inline').addClass('d-none')
        $(modal_detail).find('div.rooms-inline').addClass('d-none')

        $(modal_update).find('div.update-rooms').addClass('d-none')
        $(modal_update).find('div.update-meeting-data').removeClass('d-none')

    } else if (data.TYPE_ID == 4) {
        $(modal_detail).find('div.rooms-inline').removeClass('d-none')
        $(modal_detail).find('div.rooms-line').addClass('d-none')
        $(modal_detail).find('div.meeting-inline').addClass('d-none')
        $(modal_detail).find('div.meeting-line').addClass('d-none')
        $(modal_detail).find('div.btn-notify').addClass('d-none')

        $(modal_update).find('div.update-rooms').removeClass('d-none')
        $(modal_update).find('div.update-meeting-data').addClass('d-none')

    } else if (data.TYPE_ID == 6) {
        $(modal_detail).find('div.meeting-inline').removeClass('d-none')
        $(modal_detail).find('div.meeting-line').addClass('d-none')
        $(modal_detail).find('div.rooms-inline').addClass('d-none')
        $(modal_detail).find('div.rooms-line').addClass('d-none')
        $(modal_detail).find('div.btn-notify').addClass('d-none')

        $(modal_update).find('div.update-rooms').addClass('d-none')
        $(modal_update).find('div.update-meeting-data').removeClass('d-none')

    } else {
        modal_detail = '#detail-modal-car'
        modal_update = '#update-modal-car'
    }

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

/**
 * 
 * 
 */

/**
 * 
 * function
 * detail_drafts(data)
 * function สำหรับสร้าง DataTable โดยที่
 * data รับค่ามาจาก function createDraftModal
 * แล้วนำข้อมูลมาแสดงใน DataTable
 * 
 */

function form_displayed_layouts(status, role, modal_detail) {

    let addClass = [],
        removeClass = []
    if (role != "draft" && role != "other") {
        addClass = {
            1: { // สถานะ pending
                me: '', // role 'me' ประธานสร้างวาระเอง ไม่มีสถานะ pending
                owner: {
                    'div.status-inline': 'col-3',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                    'div.action-respond': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำได้ทุกอย่าง
                child: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน อนุมัติ/ไม่อนุมัติเท่านั้น
                vis: '' // role 'vis' เป็นผู้เข้าร่วม ไม่มีสถานะ pending
            },
            2: { // สถานะ success
                me: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                vis: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
            },
            3: { // สถานะ failure
                me: '', // role 'me' ประธานสร้างวาระเอง ไม่มีสถานะ failure
                owner: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ย้อนกลับสถานะได้
                child: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ย้อนกลับสถานะได้
                vis: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม จะเห็นก็ต่อเมื่อ APPROVE_DATE !== null
            },
            4: { // สถานะ canceled
                me: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ย้อนกลับสถานะได้
                owner: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ย้อนกลับสถานะได้
                child: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ย้อนกลับสถานะได้
                vis: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม จะเห็นก็ต่อเมื่อ APPROVE_DATE !== null
            },
            5: { // สถานะ doing
                me: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ทำได้ทุกอย่างยกเว้นอนุมัติซ้ำ เพราะอนุมัติไปแล้ว
                owner: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    // 'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำได้ทุกอย่างยกเว้นอนุมัติซ้ำ เพราะอนุมัติไปแล้ว
                child: {
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ปิดงานได้เท่านั้น (สำเร็จ/ยกเลิก)
                vis: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-6',
                    'div.action-approval': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.rooms-inline': 'd-none',
                    'div.meeting-inline': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม ตอบรับได้เท่านั้น (เข้าร่วม/ไม่เข้าร่วม)
            },

        }
        removeClass = {
            1: { // สถานะ pending
                me: '', // role 'me' ประธานสร้างวาระเอง ไม่มีสถานะ pending
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-6',
                    '.status-inline': 'd-none',
                    'div.action-approval': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำได้ทุกอย่าง
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน อนุมัติ/ไม่อนุมัติเท่านั้น
                vis: '', // role 'vis' เป็นผู้เข้าร่วม ไม่มีสถานะ pending
            },
            2: { // สถานะ success
                me: {
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                owner: {
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                child: {
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
                vis: {
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div[data-visitor=true]': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม ทำอะไรไม่ได้เพราะดำเนินการสำเร็จแล้ว
            },
            3: { // สถานะ failure
                me: '', // role 'me' ประธานสร้างวาระเอง ย้อนกลับสถานะได้
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ย้อนกลับสถานะได้
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ย้อนกลับสถานะได้
                vis: {
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div[data-visitor=true]': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม จะเห็นก็ต่อเมื่อ APPROVE_DATE !== null
            },
            4: { // สถานะ canceled
                me: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ย้อนกลับสถานะได้
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ย้อนกลับสถานะได้
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ย้อนกลับสถานะได้
                vis: {
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div[data-visitor=true]': 'd-none',
                }, // role 'vis' เป็นผู้เข้าร่วม จะเห็นก็ต่อเมื่อ APPROVE_DATE !== null
            },
            5: { // สถานะ doing
                me: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'me' ประธานสร้างวาระเอง ทำได้ทุกอย่างยกเว้นอนุมัติซ้ำ เพราะอนุมัติไปแล้ว
                owner: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-respond': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'owner' สร้างให้ผู้อื่นเป็นประธาน ทำได้ทุกอย่างยกเว้นอนุมัติซ้ำ เพราะอนุมัติไปแล้ว
                child: {
                    'div.action-header': 'd-none',
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
                    'div.action-footer': 'd-none',
                }, // role 'child' ผู้อื่นสร้างให้เป็นประธาน ปิดงานได้เท่านั้น (สำเร็จ/ยกเลิก)
                vis: {
                    'div.status-inline': 'col-3',
                    '.status-inline': 'd-none',
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

    } else {
        if (role == "other") {
            addClass = {
                'div.action-approval': 'd-none',
                'div.action-respond': 'd-none',
                'div.rooms-inline': 'd-none',
                'div.meeting-inline': 'd-none',
                'div.status-inline': 'col-6',
            }

            removeClass = {
                'div.status-inline': 'col-3',
                '.status-inline': 'd-none',
                'div.action-header': 'd-none',
                'div.action-footer': 'd-none',
            }
        } else {
            addClass = {
                'div.action-approval': 'd-none',
                'div.action-respond': 'd-none',
                'div.rooms-line': 'd-none',
                'div.meeting-line': 'd-none',
                '.status-inline': 'd-none',
            }

            removeClass = {
                'div.action-header': 'd-none',
                'div.action-footer': 'd-none',
            }
        }

        $.each(addClass, function(tagname, class_val) {

            $(modal_detail).find(tagname).addClass(class_val)
        });

        $.each(removeClass, function(tagname, class_val) {

            $(modal_detail).find(tagname).removeClass(class_val)
        });

    }
}

/**
 * 
 * 
 */

/**
 * 
 * function
 * detail_drafts(data)
 * function สำหรับสร้าง DataTable โดยที่
 * data รับค่ามาจาก function createDraftModal
 * แล้วนำข้อมูลมาแสดงใน DataTable
 * 
 */

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

/**
 * 
 * 
 */

/**
 * 
 * function
 * detail_drafts(data)
 * function สำหรับสร้าง DataTable โดยที่
 * data รับค่ามาจาก function createDraftModal
 * แล้วนำข้อมูลมาแสดงใน DataTable
 * 
 */

function form_displayed_data(data, modal_detail, modal_update) {
    $(modal_update).find('select[name=update-visitor]').val()

    $(modal_detail).find('[data-visitor=true]').addClass('d-none')
    $(modal_detail).find('h5.visitor-name').empty()
    $(modal_detail).find('button.notify').attr('data-event-id',data.ID)
    $(modal_detail).find('button.notify').attr('data-event-code',data.CODE)
    $('select[name=update-visitor]').find('option').attr('data-status', 1)
    let form_update = {
            '[name=item_id]': data.ID,
            '[name=code]': data.CODE,
            '[name=update-type-id]': data.TYPE_ID,
            '[name=update-type-name]': data.TYPE_NAME,
            '[name=update-name]': data.EVENT_NAME,
            '[name=update-head]': data.STAFF_ID,
            '[name=update-meeting-id]': data.ROOMS_ID,
            '[name=update-meeting-name]': data.ROOMS_NAME,
            '[name=update-rooms-id]': data.ROOMS_ID,
            '[name=update-rooms-name]': data.ROOMS_NAME,
            '[name=update-description]': data.EVENT_DESCRIPTION,
            '[name=update-dates]': data.DATE_BEGIN,
            '[name=update-datee]': data.DATE_END,
            'select[name=update-times]': data.TIME_BEGIN,
            'select[name=update-timee]': data.TIME_END,
            '.modal-title': data.TYPE_NAME
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
        status, role, event_id, event_code, user_visitor = [],
        event_visitor = []

    if (data.VISITOR) {
        let status_vis = "",
            vis_html = "",
            vis_data = [],
            btn_action;
        for (let i = 0; i < data.VISITOR.length; i++) {
            btn_action = `
            <div class="action-respond" data-row-id="${data.VISITOR[i].EID}"></div>
            `
            if (data.VISITOR[i].VSTATUS == 1) {
                status_vis =
                    `<span>รอตอบรับ</span>`
            } else if (data.VISITOR[i].VSTATUS == 2) {
                status_vis =
                    `<span>เข้าร่วม</span>`
            } else if (data.VISITOR[i].VSTATUS == 3) {
                status_vis =
                    `<span>ปฏิเสธ เนื่องจาก ${data.VISITOR[i].VREMARK}</span>`
            }

            if (data.APPROVE_DATE && data.STATUS_COMPLETE == 5) {
                if (data.class == 'me' || data.class == 'owner') {
                    status_vis = status_vis + btn_action
                }
            }


            vis_html = vis_html + data.VISITOR[i].VNAME + ' ' + data.VISITOR[i].VLNAME + ' ' + status_vis +
                '<br>'

            $('select[name=update-visitor]').find('option[value=' + data.VISITOR[i].VID + ']').attr('data-status', data
                .VISITOR[i].VSTATUS)
        }

        user_visitor = data.VISITOR.map((item, index) => {
            return item.VID
        })
        event_visitor = data.VISITOR.map((item, index) => {
            return item.EID
        })

        $(modal_update).find('select[name=update-visitor]').val(user_visitor).trigger('change')
        user_visitor.forEach(element => {});

        $(modal_detail).find('[data-visitor=true]').removeClass('d-none')
        $(modal_detail).find('h5.visitor-name').html(vis_html)

    } else {
        $(modal_update).find("ul.select2-selection__rendered").empty()

    }

    $.each(form_detail, function(key, value) {
        if (key == 'user-start-name') {
            $(modal_detail).find('p.' + key).html(value)
        } else {
            $(modal_detail).find(key).val(value)
        }
    });

    $.each(form_update, function(key, value) {
        if (key == '.modal-title') {
            $(modal_update).find(key).html(value)
        } else {
            $(modal_update).find(key).val(value)
        }
    });
    btn_manage(data.STATUS_COMPLETE, data.class, data.ID, data.CODE, event_visitor)

}

/**
 * 
 * 
 */
</script>