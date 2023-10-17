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
function detail(calEvent, jsEvent, view) {
    let vis = '';
    if (calEvent.VISITOR.length) {
        for (let i = 0; i < calEvent.VISITOR.length; i++) {
            vis = vis + calEvent.VISITOR[i] + ','
        }
    }
    console.log(vis)
    if (calEvent.TYPE_ID == 1 || calEvent.TYPE_ID == 3) {
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
        if (vis) {
            $('#detail-modal-meeting').find('[name=detail-visitor]').val(vis)
        }

        /* ************** UPDATE *************** */
        // $("#update-modal-meeting").modal("show")
        $('#update-modal-meeting').find('[name=item_id]').val(calEvent.ID)
        $('#update-modal-meeting').find('[name=code]').val(calEvent.CODE)
        $('#update-modal-meeting').find('select[name=update-type]').val(calEvent.TYPE_ID)
        $('#update-modal-meeting').find('[name=update-name]').val(calEvent.EVENT_NAME)
        $('#update-modal-meeting').find('[name=update-head]').val(calEvent.STAFF_ID)
        $('#update-modal-meeting').find('[name=update-description]').val(calEvent.EVENT_DESCRIPTION)
        $('#update-modal-meeting').find('[name=update-dates]').val(calEvent.DATE_BEGIN)
        $('#update-modal-meeting').find('[name=update-datee]').val(calEvent.DATE_END)
        $('#update-modal-meeting').find('select[name=update-times]').val(calEvent.TIME_BEGIN)
        $('#update-modal-meeting').find('select[name=update-timee]').val(calEvent.TIME_END)
        if (vis) {
            $('#update-modal-meeting').find('[name=update-visitor]').val(vis)
        }

    } else if (calEvent.TYPE_ID == 2 || calEvent.TYPE_ID == 4) {
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
        if (vis) {
            $('#detail-modal-car').find('[name=detail-visitor]').val(vis)
        }

        /* ************** UPDATE *************** */
        // $("#update-modal-car").modal("show")
        $('#update-modal-car').find('[name=item_id]').val(calEvent.ID)
        $('#update-modal-car').find('[name=update-type]').val('จองรถ')
        $('#update-modal-car').find('[name=code]').val(calEvent.CODE)
        $('#update-modal-car').find('[name=update-name]').val(calEvent.EVENT_NAME)
        $('#update-modal-car').find('[name=update-head]').val(calEvent.STAFF_ID)
        $('#update-modal-car').find('[name=update-description]').val(calEvent.EVENT_DESCRIPTION)
        $('#update-modal-car').find('[name=update-dates]').val(calEvent.DATE_BEGIN)
        $('#update-modal-car').find('[name=update-datee]').val(calEvent.DATE_END)
        $('#update-modal-car').find('[name=update-times]').val(calEvent.TIME_BEGIN)
        $('#update-modal-car').find('[name=update-timee]').val(calEvent.TIME_END)
        if (vis) {
            $('#update-modal-car').find('[name=update-visitor]').val(vis)
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
</script>