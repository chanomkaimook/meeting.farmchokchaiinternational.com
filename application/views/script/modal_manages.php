<script>
$(document).ready(function() {

    $('body').on('hidden.bs.modal', function() {
        if ($('.modal').hasClass('show')) {
            $('body').addClass('modal-open');
        }
    });
    
})

    /**
     * Modal ID
     *
     * #
     * # Properties Modal
     * 1. insert_modal = Modal insert 
     * 2. insert_modal_car = Modal insert event car
     * 3. update_modal_car = Modal update event car
     * 4. detail_modal_car = Modal detail event car
     * 5. insert_modal_meeting = Modal insert event rooms,meeting
     * 6. update_modal_meeting = Modal update event rooms,meeting
     * 7. detail_modal_meeting = Modal detail event rooms,meeting
     * 8. draft_modal = Modal detail draft (datatable)
     * 
     *
     */
    let insert_modal = '#insert-modal';

    let insert_modal_car = '#insert-modal-car';
    let update_modal_car = '#update-modal-car';
    let detail_modal_car = '#detail-modal-car';

    let insert_modal_meeting = '#insert-modal-meeting';
    let update_modal_meeting = '#update-modal-meeting';
    let detail_modal_meeting = '#detail-modal-meeting';

    let draft_modal = '#draft-modal';

    /**
     * 
     */

function modal_show(modal) {
    $(modal).modal('show')
}

/* ********** EVENT CLICK ********** */
$('.insert-car').click(function() {
    modal_show("#insert-modal-car")

    $("#insert-modal-car").find("#insert-car").trigger("reset")
    $(insert_modal).modal("hide")
})

$('.insert-meeting-room').click(function() {
    modal_show(insert_modal_meeting)

    $(insert_modal_meeting).find("#insert-meeting").trigger("reset")
    $(insert_modal_meeting).find(".modal-title").html("จองห้องประชุม")
    $(insert_modal_meeting).find("input[name=insert-rooms-id]").removeAttr("disabled")
    $(insert_modal_meeting).find(".meeting-room").removeClass("d-none")
    $(insert_modal_meeting).find(".meeting-place").addClass("d-none")
    $(insert_modal_meeting).find("[name=insert-type-id]").val("1")
    $(insert_modal_meeting).find("[name=insert-type-name]").val("จองห้องประชุม")
    $(insert_modal).modal("hide")
})

$('.insert-meeting').click(function() {
    modal_show(insert_modal_meeting)

    $(insert_modal_meeting).find("#insert-meeting").trigger("reset")
    $(insert_modal_meeting).find(".modal-title").html("นัดหมายกิจกรรม")
    $(insert_modal_meeting).find("input[name=insert-rooms-id]").attr("disabled")
    $(insert_modal_meeting).find(".meeting-room").addClass("d-none")
    $(insert_modal_meeting).find(".meeting-place").removeClass("d-none")
    $(insert_modal_meeting).find("[name=insert-type-id]").val("3")
    $(insert_modal_meeting).find("[name=insert-type-name]").val("นัดหมายกิจกรรม")
    $(insert_modal).modal("hide")
})

$(document).on('click', '.modal-update-meeting', function() {
    modal_show(update_modal_meeting)

    $(detail_modal_meeting).modal("hide")
})

/* ********** ADDITIONAL FUNCTION ********** */

function swal_alert(icon, title, text) {
    Swal.fire(title, text, icon).then((result) => {

        $('.modal').modal('hide')
        calendarDestroy('#calendar', url_calendar)
        // $('#modal_draft').DataTable().ajax.reload()
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
            } else if (func == "restore") {
                restore(data)
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
            console.log(resp)

            /* if (resp.error) {
                swal_alert('error', 'ไม่สำเร็จ', resp.txt)
            } else {
                swal_alert('success', 'สำเร็จ', '')
            } */
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
            console.log(resp)

            /* if (resp.error) {
                swal_alert('error', 'ไม่สำเร็จ', resp.txt)
            } else {
                swal_alert('success', 'สำเร็จ', '')
            } */
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