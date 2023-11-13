<script>
function btn_manage(status, role, event_id, event_code, event_vid) {
    $('.action-header').empty()
    $('.action-respond').empty()
    $('.action-approval').addClass('d-none').empty()
    $('.action-footer').empty()
    let btn
    if (role == "draft") {
        btn = btn_displayed(status, role)
    } else {
        btn = btn_displayed()

    }
    // console.log(btn[status][role])
    btn_all_in_modal(btn[status][role], event_id, event_code, event_vid)
}

function btn_displayed(status = null, role = null) {

    /*********** ALL BUTTON IN 'DETAIL-MODAL' ***********/
    /**
     * 
     * action_header(me(!pending),owner,child (pending,failure,canceled,doing))
     *  - ['header_update', 'header_delete']
     * 
     * action_respond(me,owner (doing))
     *  - ['body_reject', 'body_refuse', 'body_accept']
     * 
     * action_approval(owner (pending))
     *  - ['body_disapprove', 'body_approve']
     * 
     * action_footer(child (doing))
     *  - ['footer_disapprove', 'footer_approve']
     * 
     * action_footer(vis (doing))
     *  - ['footer_refuse', 'footer_accept']
     * 
     * action_footer(me(doing),owner(pending,doing),child(doing))
     *  - ['footer_cancel', 'footer_success']
     * 
     * action_footer(me,owner,child (failure,canceled))
     *  - ['footer_restore']
     * 
     * 
     */

    /*********** BUTTON TO BE DISPLAYED ON 'DETAIL-MODAL' ***********/
    /********* BASED ON PERMISSION AND STATUS OF THIS EVENT *********/
    let btn_pending = {
            me: '',
            owner: {
                header: '.action-header',
                body: ['.action-respond', 'respond', '.action-approval', 'approval'],
                footer: ['.action-footer', 'operation']
            },
            child: {
                header: '.action-header',
                body: '',
                footer: ['.action-footer', 'approval']
            },
            vis: {
                header: '',
                body: '',
                footer: ''
            }

        },
        btn_success = {
            me: {
                header: '',
                body: '',
                footer: ''
            },
            owner: {
                header: '',
                body: '',
                footer: ''
            },
            child: {
                header: '',
                body: '',
                footer: ''
            },
            vis: {
                header: '',
                body: '',
                footer: ''
            }

        },
        btn_failure = {
            me: {
                header: '.action-header',
                body: '',
                footer: ['.action-footer', 'restore']
            },
            owner: {
                header: '.action-header',
                body: '',
                footer: ['.action-footer', 'restore']
            },
            child: {
                header: '.action-header',
                body: '',
                footer: ['.action-footer', 'restore']
            },
            vis: {
                header: '',
                body: '',
                footer: ''
            }

        },
        btn_canceled = {
            me: {
                header: '.action-header',
                body: '',
                footer: ['.action-footer', 'restore']
            },
            owner: {
                header: '.action-header',
                body: '',
                footer: ['.action-footer', 'restore']
            },
            child: {
                header: '.action-header',
                body: '',
                footer: ['.action-footer', 'restore']
            },
            vis: {
                header: '',
                body: '',
                footer: ''
            }

        },
        btn_doing = {
            me: {
                header: '.action-header',
                body: ['.action-respond', 'respond'],
                footer: ['.action-footer', 'operation']
            },
            owner: {
                header: '.action-header',
                body: ['.action-respond', 'respond'],
                footer: ['.action-footer', 'operation']
            },
            child: {
                header: '.action-header',
                body: '',
                footer: ['.action-footer', 'operation']
            },
            vis: {
                header: '',
                body: '',
                footer: ['.action-footer', 'respond']
            }

        },
        btn_draft = {
            draft: {
                header: '.action-header',
                body: '',
                footer: ''
            },
        };

    let array = []
    if (!status && !role) {
        array[1] = btn_pending
        array[2] = btn_success
        array[3] = btn_failure
        array[4] = btn_canceled
        array[5] = btn_doing
    } else {
        array[status] = btn_draft
    }

    return array
}

function btn_all_in_modal(data = [], event_id, event_code, event_vid = []) {
    let btn_header = `
            <div class="col-6">
                <div class="cardbox text-center">
                    <button type="button" class="btn btn-warning btn-rounded btn-lg width-md waves-effect waves-light modal-update-meeting item-cardbox" data-dismiss="modal">แก้ไข</button>
                </div>
            </div>
            
            <div class="col-6">
                <div class="cardbox text-center">
                    <button type="button" class="btn btn-danger btn-rounded btn-lg width-md waves-effect waves-light item-cardbox delete-meeting" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ลบ</button>
                </div>
            </div>
            `
    // $('.action-header').html();
    btn_body = {
            approval: `
                <label class="control-label">action</label>
                        <div>
                            <button type='button' class='btn btn-icon waves-effect waves-light btn-danger btn-disapprove text-lg-center' data-event-id="${event_id}" data-event-code="${event_code}"> <i class='mdi mdi-file-document-box-remove'></i> </button>
                            <button type='button' class='btn btn-icon waves-effect btn-success btn-approve text-lg-center'  data-event-id="${event_id}" data-event-code="${event_code}"> <i class='mdi mdi-file-document-box-check'></i> </button>
                        </div>
            `, // $('.action-approval').html(btn_body[approval]);
        },
        btn_footer = {
            approval: `
            <button type="button" class="btn btn-danger waves-effect waves-light btn-disapprove" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่อนุมัติ</button>
            <button type="button" class="btn btn-success waves-effect waves-light btn-approve" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">อนุมัติ</button>
            `,
            respond: `
            <button type="button" class="btn btn-danger waves-effect waves-light btn-refuse" data-id="${event_vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ไม่เข้าร่วม</button>
            <button type="button" class="btn btn-success waves-effect waves-light btn-accept" data-id="${event_vid}"  data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">เข้าร่วม</button>
            `,
            operation: `
            <button type="button" class="btn btn-danger waves-effect waves-light btn-cancle" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">ยกเลิก</button>
            <button type="button" class="btn btn-success waves-effect waves-light btn-finish" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">สำเร็จ</button>
            `,
            restore: `
            <button type="button" class="btn btn-success waves-effect waves-light btn-restore" data-event-id="${event_id}" data-event-code="${event_code}" data-dismiss="modal">นำกลับมาใช้</button>
            `
        }, // $('.action-footer').html();
        className = '',
        html = '', vis_respond = []

    // console.log(event_vid)

    if (event_vid.length) {
        event_vid.forEach(function(item) {
            // console.log(item)
            vis_respond = `
                <button type='button' class='btn btn-icon waves-effect waves-light btn-secondary reject text-lg-center' data-id='${item}' data-event-id='${event_id}' data-event-code='${event_code}'> <i class='fa fa-trash-alt'></i> </button>
                <button type='button' class='btn btn-icon waves-effect waves-light btn-danger deny text-lg-center' data-id='${item}' data-event-id='${event_id}' data-event-code='${event_code}'> <i class='mdi mdi-account-remove'></i> </button>
                <button type='button' class='btn btn-icon waves-effect btn-success defer text-lg-center'  data-id='${item}' data-event-id='${event_id}' data-event-code='${event_code}'> <i class='mdi mdi-account-check'></i> </button>
            ` // $('.action-respond[data-row-id=]').html(btn_body[respond]);
            $('.action-respond[data-row-id=' + item + ']').html(vis_respond);
        })

    }

    if (data['header']) {
        $(data['header']).html(btn_header)
    }
    if (data['body']) {

        for (let i = 0; i < data['body'].length; i += 2) {
            className = data['body'][i],
                html = data['body'][i + 1]
            $(className).removeClass('d-none').html(btn_body[html])
        }
    }
    if (data['footer']) {
        className = data['footer'][0],
            html = data['footer'][1]
        $(className).html(btn_footer[html])
    }
}
</script>