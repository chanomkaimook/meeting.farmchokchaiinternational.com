<script>

/* ********** ADDITIONAL FUNCTION ********** */
function btn_pending() // รอดำเนินการ เกิดขึ้นได้กับ owner,child,other
{

}
function btn_success()
{

}
function btn_failure()
{

}
function btn_canceled()
{

}
function btn_doing()
{

}
function button_action(modal, entitled, status, status_approval, event_id, event_code, vid, attr_inline, attr_line) {
    let html = '',
        owner_action = ''
    // meeting-inline
    // meeting-line
    $(modal).find('.action-header').removeClass('d-none')
    $(modal).find('.rooms-inline').removeClass('d-none')
    $(modal).find('.meeting-inline').removeClass('d-none')
    $(modal).find('.approve-inline').removeClass('d-none')
    $(modal).find('.rooms-line').removeClass('d-none')
    $(modal).find('.meeting-line').removeClass('d-none')

    $(modal).find('.status-inline').removeClass('d-none')
    $(modal).find('.status-inline').removeClass('col-md-3')
    $(modal).find('.status-inline').removeClass('col-md-6')

    $(modal).find('[name=status-inline-text]').val(status_approval)
    // console.log(entitled)
    // console.log(status)
    // console.log(status_approval)
    /**
     * attr_line[0] , attr_inline[0] -> hide
     * attr_line[1] , attr_inline[1] -> show
     * .action-header - ปุ่มแก้ไข / ปุ่มลบ
     * .rooms-inline - ห้องประชุม col-md-6
     * .meeting-inline - สถานที่ col-md-6
     * .status-inline - input สถานะ disabled col-md-3
     * .approve-inline - btn-group อนุมัติ / ไม่อนุมัติ col-md-3
     * .rooms-line - ห้องประชุม form-group
     * .meeting-line - สถานที่ form-group
     */

    if (modal && entitled) {
        if (status == 1) {
            if (entitled == 'me' || entitled == 'owner') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-cancle" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-finish" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">สำเร็จ</button>`;

                $(modal).find('.action-header').removeClass('d-none')


                if (entitled == 'owner') {
                    owner_action = `
                        <label class="control-label">action</label>
                        <div>
                                <button type='button' class='btn btn-icon waves-effect waves-light btn-danger btn-disapprove text-lg-center' data-event-id="${event_id}" data-event-code="${event_code}"> <i class='mdi mdi-file-document-box-remove'></i> </button>
                                <button type='button' class='btn btn-icon waves-effect btn-success btn-approve text-lg-center'  data-event-id="${event_id}" data-event-code="${event_code}"> <i class='mdi mdi-file-document-box-check'></i> </button>

                        </div>`

                    $(modal).find(attr_line[0]).addClass('d-none')
                    $(modal).find(attr_line[1]).removeClass('d-none')
                    $(modal).find(attr_inline[0]).addClass('d-none')
                    $(modal).find(attr_inline[1]).addClass('d-none')

                    $(modal).find('.status-inline').addClass('col-md-3')

                    $(modal).find('.status-inline').removeClass('d-none')
                    $(modal).find('.status-inline').removeClass('col-md-6')
                    $(modal).find('.approve-inline').removeClass('d-none').html(owner_action)
                } else {
                    $(modal).find(attr_line[0]).addClass('d-none')
                    $(modal).find(attr_line[1]).addClass('d-none')
                    $(modal).find(attr_inline[0]).addClass('d-none')
                    $(modal).find(attr_inline[1]).removeClass('d-none')

                    $(modal).find('.status-inline').removeClass('col-md-3')
                    $(modal).find('.status-inline').removeClass('col-md-6')

                    $(modal).find('.status-inline').addClass('d-none')
                    $(modal).find('.approve-inline').addClass('d-none')
                }

            } else if (entitled == 'other') {
                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.action-header').addClass('d-none')
                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
                html = ``
            } else if (entitled == 'vis') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-refuse" data-id="${vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่เข้าร่วม</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-accept" data-id="${vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">เข้าร่วม</button>`
                $(modal).find('.action-header').addClass('d-none')

                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
            } else if (entitled == 'child') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-disapprove" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่อนุมัติ</button>
                    <button type="button" class="btn btn-success waves-effect waves-light btn-approve" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">อนุมัติ</button>`

                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.action-header').removeClass('d-none')
                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
            }
        } else if (status == 2) {
            html = ``
            $(modal).find(attr_line[0]).addClass('d-none')
            $(modal).find(attr_line[1]).addClass('d-none')
            $(modal).find(attr_inline[0]).addClass('d-none')
            $(modal).find(attr_inline[1]).removeClass('d-none')

            $(modal).find('.status-inline').removeClass('col-md-3')
            $(modal).find('.status-inline').removeClass('col-md-6')

            $(modal).find('.action-header').addClass('d-none')
            $(modal).find('.status-inline').addClass('d-none')
            $(modal).find('.approve-inline').addClass('d-none')
        } else if (status == 3 || status == 4) {
            if (entitled == 'me' || entitled == 'owner') {
                html =
                    `<button type="button" class="btn btn-success waves-effect waves-light btn-restore" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">นำกลับมาใช้</button>`;

                if (entitled == 'owner') {

                    $(modal).find(attr_line[0]).addClass('d-none')
                    $(modal).find(attr_line[1]).removeClass('d-none')
                    $(modal).find(attr_inline[0]).addClass('d-none')
                    $(modal).find(attr_inline[1]).addClass('d-none')

                    $(modal).find('.approve-inline').addClass('d-none')
                    $(modal).find('.status-inline').removeClass('col-md-3')

                    $(modal).find('.status-inline').addClass('col-md-6')
                    $(modal).find('.status-inline').removeClass('d-none')
                } else {
                    $(modal).find(attr_line[0]).addClass('d-none')
                    $(modal).find(attr_line[1]).addClass('d-none')
                    $(modal).find(attr_inline[0]).addClass('d-none')
                    $(modal).find(attr_inline[1]).removeClass('d-none')

                    $(modal).find('.status-inline').removeClass('col-md-3')
                    $(modal).find('.status-inline').removeClass('col-md-6')

                    $(modal).find('.status-inline').addClass('d-none')
                    $(modal).find('.approve-inline').addClass('d-none')
                }
            } else if (entitled == 'other') {
                html = ``
                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.action-header').addClass('d-none')
                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
                html = ``
            } else if (entitled == 'vis') {
                html = ``
                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.action-header').addClass('d-none')
                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
            } else if (entitled == 'child') {
                html =
                    `<button type="button" class="btn btn-success waves-effect waves-light btn-restore" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">นำกลับมาใช้</button>`;

                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.action-header').removeClass('d-none')

                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
            }
        } else if (status == 5) {
            if (entitled == 'me' || entitled == 'owner' || entitled == 'child') {
                html =
                    `<button type="button" class="btn btn-danger waves-effect waves-light btn-cancle" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-finish" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">สำเร็จ</button>`;

                $(modal).find('.action-header').removeClass('d-none')

                    $(modal).find(attr_line[0]).addClass('d-none')
                    $(modal).find(attr_line[1]).removeClass('d-none')
                    $(modal).find(attr_inline[0]).addClass('d-none')
                    $(modal).find(attr_inline[1]).addClass('d-none')

                    $(modal).find('.approve-inline').addClass('d-none')
                    $(modal).find('.status-inline').removeClass('col-md-3')
                    $(modal).find('.status-inline').addClass('col-md-6')

                    $(modal).find('.status-inline').removeClass('d-none')
                
            } else if (entitled == 'other') {
                html = ``

                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.action-header').addClass('d-none')
                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
                html = ``
            } else if (entitled == 'vis') {
                html = `<button type="button" class="btn btn-danger waves-effect waves-light btn-refuse" data-id="${vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่เข้าร่วม</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-accept" data-id="${vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">เข้าร่วม</button>`
                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.action-header').addClass('d-none')
                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
            }
            /*  else if (entitled == 'child') {
                html = ``
                $(modal).find(attr_line[0]).addClass('d-none')
                $(modal).find(attr_line[1]).addClass('d-none')
                $(modal).find(attr_inline[0]).addClass('d-none')
                $(modal).find(attr_inline[1]).removeClass('d-none')

                $(modal).find('.status-inline').removeClass('col-md-3')
                $(modal).find('.status-inline').removeClass('col-md-6')

                $(modal).find('.status-inline').addClass('d-none')
                $(modal).find('.approve-inline').addClass('d-none')
            } */
        }

    } else {
        html =
            ``;
        $(modal).find(attr_line[0]).addClass('d-none')
        $(modal).find(attr_line[1]).addClass('d-none')
        $(modal).find(attr_inline[0]).addClass('d-none')
        $(modal).find(attr_inline[1]).removeClass('d-none')

        $(modal).find('.status-inline').removeClass('col-md-3')
        $(modal).find('.status-inline').removeClass('col-md-6')

        $(modal).find('.action-header').addClass('d-none')
        $(modal).find('.status-inline').addClass('d-none')
        $(modal).find('.approve-inline').addClass('d-none')
    }

    $(modal).find('.approve-inline').html(owner_action)
    $(modal).find('.action-footer').html(html)
}

//     /* ************** ADD VISITOR *************** */
//     if (calEvent.VISITOR) {
//         let status_vis = "",
//             vis_btn = "";
//         for (let i = 0; i < calEvent.VISITOR.length; i++) {
//             btn_vis_action = `
//             <button type='button' class='btn btn-icon waves-effect waves-light btn-secondary reject text-lg-center' data-id='${calEvent.VISITOR[i].EID}' data-event-id='${calEvent.ID}' data-event-code='${calEvent.CODE}'> <i class='fa fa-trash-alt'></i> </button>
//             <button type='button' class='btn btn-icon waves-effect waves-light btn-danger deny text-lg-center' data-id='${calEvent.VISITOR[i].EID}' data-event-id='${calEvent.ID}' data-event-code='${calEvent.CODE}'> <i class='mdi mdi-account-remove'></i> </button>
//             <button type='button' class='btn btn-icon waves-effect btn-success defer text-lg-center'  data-id='${calEvent.VISITOR[i].EID}' data-event-id='${calEvent.ID}' data-event-code='${calEvent.CODE}'> <i class='mdi mdi-account-check'></i> </button>
// `
//             if (calEvent.VISITOR[i].VSTATUS == 1) {
//                 status_vis =
//                     `<span class='status_vis'>รอตอบรับ</span>`
//             } else if (calEvent.VISITOR[i].VSTATUS == 2) {
//                 status_vis =
//                     `<span class='status_vis'>เข้าร่วม</span>`
//             } else if (calEvent.VISITOR[i].VSTATUS == 3) {
//                 status_vis =
//                     `<span class='status_vis'>ปฏิเสธ</span>`
//             }
//             if (calEvent.USER_START == my_id) { // my_id = session('user_emp') อยู่ใน views หลัก
//                 status_vis = status_vis + btn_vis_action
//             }

//             vis_html = vis_html + calEvent.VISITOR[i].VNAME + ' ' + calEvent.VISITOR[i].VLNAME + ' ' + status_vis +
//                 '<br>'

//             vid = calEvent.VISITOR[i].EID
//         }

//         user_visitor = calEvent.VISITOR.map((item, index) => {
//             return item.VID
//         })
//         $('select[name=update-visitor]').val(user_visitor).trigger('change')

//         $(modal_detail).find('[data-visitor=true]').removeClass('d-none')
//         $(modal_detail).find('h5.visitor-name').html(vis_html)

//         $(modal_update).find('[data-visitor=true]').removeClass('d-none')
//     }
    /* ************** END ADD VISITOR *************** */

</script>