<script>
    
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
    modal_show("#insert-modal-car")
// $('button[data-modal-show=insert-car]').click(function() {
    $("#insert-modal-car").find("#insert-car").trigger("reset")
    // $("#insert-modal-car").find('.modal').attr('aria-hidden', true)
    // $("#insert-modal-car").modal("show")
    $("#insert-modal").modal("hide")
})

$('.insert-meeting-room').click(function() {
    modal_show("#insert-modal-meeting")
// $('button[data-modal-show=insert-meeting-room]').click(function() {
    $("#insert-modal-meeting").find("#insert-meeting").trigger("reset")
    // $("#insert-modal-meeting").find('.modal').attr('aria-hidden', true)
    $("#insert-modal-meeting").find(".modal-title").html("จองห้องประชุม")
    $("#insert-modal-meeting").find("input[name=insert-rooms-id]").attr("disabled")
    $("#insert-modal-meeting").find(".meeting-room").removeClass("d-none")
    $("#insert-modal-meeting").find(".meeting-place").addClass("d-none")
    $("#insert-modal-meeting").find("[name=insert-type-id]").val("1")
    $("#insert-modal-meeting").find("[name=insert-type-name]").val("จองห้องประชุม")
    // $("#insert-modal-meeting").modal("show")
    $("#insert-modal").modal("hide")
})

$('.insert-meeting').click(function() {
    modal_show("#insert-modal-meeting")

// $('button[data-modal-show=insert-meeting]').click(function() {
    $("#insert-modal-meeting").find("#insert-meeting").trigger("reset")
    $("#insert-modal-meeting").find(".modal-title").html("นัดหมายกิจกรรม")
    $("#insert-modal-meeting").find("input[name=insert-rooms-id]").removeAttr("disabled")
    $("#insert-modal-meeting").find(".meeting-room").addClass("d-none")
    $("#insert-modal-meeting").find(".meeting-place").removeClass("d-none")
    $("#insert-modal-meeting").find("[name=insert-type-id]").val("3")
    $("#insert-modal-meeting").find("[name=insert-type-name]").val("นัดหมายกิจกรรม")
    // $("#insert-modal-meeting").find('.modal').attr('aria-hidden', true)
    // $("#insert-modal-meeting").modal("show")
    $("#insert-modal").modal("hide")
})

$(document).on('click','.modal-update-meeting',function() {
    modal_show("#update-modal-meeting")
    $("#update-modal-meeting").find('.modal').attr('aria-hidden', 'true')
    $("#update-modal-meeting").modal("show")
    $("#detail-modal-meeting").modal("hide")
})

/* $('.btn-update-meeting').click(function() {
    // $("#update-modal-meeting").find('.modal').attr('aria-hidden', true)
    // $("#update-modal-meeting").modal("show")
    $("#detail-modal-meeting").modal("hide")
}) */


/* ********** ADDITIONAL FUNCTION ********** */
/**
 * 
 * Component ที่ต้องการให้เห็นใน modal
 * 
 */
function modal_show(modal) {
    $(modal).modal('show')
}

function swal_alert(icon, title, text) {
    Swal.fire(title, text, icon).then((result) => {
        // if (result.isConfirmed) {

        //     // calendarDestroy()
        //     // console.log(url_calendar)
        // }
        $('.modal').modal('hide')
        calendarDestroy('#calendar', url_calendar)
        // $('#modal_draft').DataTable().ajax.reload()
    })

}
/* function swal_valid(icon, title, text) {
    Swal.fire(title, text, icon)

} */

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