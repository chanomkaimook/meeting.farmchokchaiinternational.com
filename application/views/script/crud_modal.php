<script>
function modal_chaeck(modal_fogus, modal_hide) {
    $(modal_fogus).on('show.bs.modal', function() {
        $(modal_fogus).trigger('focus')
    })
    $(modal_hide).modal('toggle')
        // $('#myModal').modal('toggle')
    // $(modal_fogus).on('shown.bs.modal', function () {
// })
}

$('.btn_save').click(function() {
    $("#exampleModal2").modal("show")
    $("#exampleModal").modal("hide")/* .trigger('focus')
    modal_chaeck("#insert-modal-car","#insert-modal") */
})

$('.insert-car').click(function() {
    $("#insert-modal-car").modal("show").trigger('focus')
    modal_chaeck("#insert-modal-car","#insert-modal")
})

$('.insert-meeting').click(function() {
    // $(".modal").modal("hide")
    $("#insert-modal-meeting").modal("show").trigger('focus')
    // modal_chaeck("#insert-modal-meeting","#insert-modal")
})

function detail_meeting(calEvent, jsEvent, view) {
    // console.log(calEvent.VISITOR)
    if (calEvent.TYPE_ID == 1) {
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
    } else {
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

function update_meeting(calEvent, jsEvent, view) {
    if (calEvent.TYPE_ID == 1) {
        $("#update-modal-meeting").modal("show")
        $('#update-modal-meeting').find('select[name=update-type]').val(calEvent.TYPE_ID)
        $('#update-modal-meeting').find('[name=update-name]').val(calEvent.EVENT_NAME)
        $('#update-modal-meeting').find('[name=update-head]').val(calEvent.STAFF_ID)
        $('#update-modal-meeting').find('[name=update-description]').val(calEvent.EVENT_DESCRIPTION)
        $('#update-modal-meeting').find('[name=update-dates]').val(calEvent.DATE_BEGIN)
        $('#update-modal-meeting').find('[name=update-datee]').val(calEvent.DATE_END)
        $('#update-modal-meeting').find('[name=update-times]').val(calEvent.TIME_BEGIN)
        $('#update-modal-meeting').find('[name=update-timee]').val(calEvent.TIME_END)
        if (calEvent.VISITOR) {
            $('#update-modal-meeting').find('[name=update-visitor]').val(calEvent.VISITOR)
        }
    } else {
        $("#update-modal-car").modal("show")
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
    // console.log(calEvent)
}
</script>