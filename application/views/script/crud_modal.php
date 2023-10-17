<script>
function modal_check(modal_fogus, modal_hide) {
    $(modal_hide).on('show.bs.modal', function() {
        $(modal_fogus).modal('show').trigger('focus')
        $('body').addClass('modal-open')
    })
    // $(modal_hide).modal('toggle')

}

$('.insert-car').click(function() {
    modal_check("#insert-modal-car", "#insert-modal")
    // $("#insert-modal").modal("hide")
})

$('.insert-meeting').click(function() {
    // modal_check("#insert-modal-meeting", "#insert-modal")
    // $("#insert-modal").modal("hide")
    // $(".modal").modal("hide")
    $("#insert-modal-meeting").modal("show").trigger('focus')
    modal_check("#insert-modal-meeting", "#insert-modal")
})

$('.update-meeting').click(function() {
    $("#update-modal-meeting").modal("show").trigger('focus')
    modal_check("#update-modal-meeting", "#detail-modal-meeting")
    $("#detail-modal-meeting").modal("hide")
})

function detail_meeting(calEvent, jsEvent, view) {
    // console.log(calEvent.VISITOR)
    if (calEvent.TYPE_ID == 1) {
        /* ************* DETAIL **************** */
        $("#detail-modal-meeting").modal("show")
        $('#detail-modal-meeting').find('[name=detail-type]').val('จองห้อง/นัดหมายการประชุม')
        $('#detail-modal-meeting').find('[name=detail-name]').val(calEvent.EVENT_NAME)
        $('#detail-modal-meeting').find('[name=detail-head]').val(calEvent.STAFF_ID)
        $('#detail-modal-meeting').find('[name=detail-description]').val(calEvent.EVENT_DESCRIPTION)
        $('#detail-modal-meeting').find('[name=detail-dates]').val(calEvent.DATE_BEGIN)
        $('#detail-modal-meeting').find('[name=detail-datee]').val(calEvent.DATE_END)
        $('#detail-modal-meeting').find('[name=detail-times]').val(calEvent.TIME_BEGIN)
        $('#detail-modal-meeting').find('[name=detail-timee]').val(calEvent.TIME_END)
        if (calEvent.VISITOR) {
            $('#detail-modal-meeting').find('[name=detail-visitor]').val(calEvent.VISITOR)
        }

        /* ************** UPDATE *************** */
        $("#update-modal-meeting").modal("show")
        $('#update-modal-meeting').find('[name=item_id]').val(calEvent.ID)
        $('#update-modal-meeting').find('select[name=update-type]').val(calEvent.TYPE_ID)
        $('#update-modal-meeting').find('[name=update-name]').val(calEvent.EVENT_NAME)
        $('#update-modal-meeting').find('[name=update-head]').val(calEvent.STAFF_ID)
        $('#update-modal-meeting').find('[name=update-description]').val(calEvent.EVENT_DESCRIPTION)
        $('#update-modal-meeting').find('[name=update-dates]').val(calEvent.DATE_BEGIN)
        $('#update-modal-meeting').find('[name=update-datee]').val(calEvent.DATE_END)
        $('#update-modal-meeting').find('select[name=update-times]').val(calEvent.TIME_BEGIN)
        $('#update-modal-meeting').find('select[name=update-timee]').val(calEvent.TIME_END)
        if (calEvent.VISITOR) {
            $('#update-modal-meeting').find('[name=update-visitor]').val(calEvent.VISITOR)
        }

    } else {
        /* ************* DETAIL **************** */
        $("#detail-modal-car").modal("show")
        $('#detail-modal-car').find('[name=detail-type]').val('จองรถ')
        $('#detail-modal-car').find('[name=detail-name]').val(calEvent.EVENT_NAME)
        $('#detail-modal-car').find('[name=detail-head]').val(calEvent.STAFF_ID)
        $('#detail-modal-car').find('[name=detail-description]').val(calEvent.EVENT_DESCRIPTION)
        $('#detail-modal-car').find('[name=detail-dates]').val(calEvent.DATE_BEGIN)
        $('#detail-modal-car').find('[name=detail-datee]').val(calEvent.DATE_END)
        $('#detail-modal-car').find('[name=detail-times]').val(calEvent.TIME_BEGIN)
        $('#detail-modal-car').find('[name=detail-timee]').val(calEvent.TIME_END)
        if (calEvent.VISITOR) {
            $('#detail-modal-car').find('[name=detail-visitor]').val(calEvent.VISITOR)
        }

        /* ************** UPDATE *************** */
        $("#update-modal-car").modal("show")
        $('#update-modal-car').find('[name=item_id]').val(calEvent.ID)
        $('#update-modal-car').find('[name=update-type]').val('จองรถ')
        $('#update-modal-car').find('[name=update-name]').val(calEvent.EVENT_NAME)
        $('#update-modal-car').find('[name=update-head]').val(calEvent.STAFF_ID)
        $('#update-modal-car').find('[name=update-description]').val(calEvent.EVENT_DESCRIPTION)
        $('#update-modal-car').find('[name=update-dates]').val(calEvent.DATE_BEGIN)
        $('#update-modal-car').find('[name=update-datee]').val(calEvent.DATE_END)
        $('#update-modal-car').find('[name=update-times]').val(calEvent.TIME_BEGIN)
        $('#update-modal-car').find('[name=update-timee]').val(calEvent.TIME_END)
        if (calEvent.VISITOR) {
            $('#update-modal-car').find('[name=update-visitor]').val(calEvent.VISITOR)
        }

    }

    if (!calEvent.CANCLE_DATE, !calEvent.APPROVE_DATE, !calEvent.DISAPPROVE_DATE) {
        $('.modal-footer').find('.approve-footer').removeClass('d-none')
        $('.action-header').find('.text-warning').removeClass('d-none')
        $('.action-header').find('.text-warning').html(calEvent.STATUS_COMPLETE_NAME)
    } else if (calEvent.APPROVE_DATE) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.action-header').find('.text-warning').removeClass('d-none')
        $('.action-header').find('.text-warning').html(calEvent.STATUS_COMPLETE_NAME)
    } else if (calEvent.DISAPPROVE_DATE) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.action-header').find('.text-danger').removeClass('d-none')
        $('.action-header').find('.text-danger').html(calEvent.STATUS_COMPLETE_NAME)
    } else if (calEvent.CANCLE_DATE) {
        $('.modal-footer').find('.approve-footer').addClass('d-none')
        $('.action-header').find('.text-success').removeClass('d-none')
        $('.action-header').find('.text-success').html(calEvent.STATUS_COMPLETE_NAME)
    }
    // console.log(calEvent)
}

function update_meeting(update_data, ctl) {
    // console.log(update_data)
    let url = "update_data"
    /* if (ctl == "calendar") {
        url = "ctl_calendar/update_data"
    } else if (ctl == "datatable") {
        url = "ctl_datatable/update_data"
    } */
    fetch(url, {
            method: 'post',
            body: update_data
        })
        .then(res => res.json())
        .then((resp) => {
            if (resp.error) {
                console.log(resp.message)
            } else {
                console.log(resp.message + '--' + resp.id)
            }
        })
}

function insert_meeting(insert_data, ctl) {
    // console.log(insert_data)
    let url = "insert_data"
    /* if (ctl == "calendar") {
        url
    } else if (ctl == "datatable") {
        url = "insert_data"
    } */
    fetch(url, {
            method: 'post',
            body: insert_data
        })
        .then(res => res.json())
        .then((resp) => {
            if (resp.error) {
                console.log(resp.message)
            } else {
                console.log(resp.message + '--' + resp.id)
            }
        })
}
</script>