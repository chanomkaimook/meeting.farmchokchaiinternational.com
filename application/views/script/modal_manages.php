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
$('select[name=insert-rooms-id]').change(function() {
    let id = $(this).val(),
        rooms_name = "";
    rooms_name = $(this).find('option[value=' + id + ']').attr('data-rooms-name')
    $('[name=insert-rooms-name]').val(rooms_name)
    // console.log($('[name=insert-rooms-name]').val())
})

$('select[name=update-rooms-id]').change(function() {
    let id = $(this).val(),
        rooms_name = "";
    rooms_name = $(this).find('option[value=' + id + ']').attr('data-rooms-name')
    $('[name=update-rooms-name]').val(rooms_name)
    // console.log($('[name=update-rooms-name]').val())
})

/* ********** EVENT CLICK ********** */
$('.insert-car').click(function() {
    modal_show("#insert-modal-car")

    $("#insert-modal-car").find("#insert-car").trigger("reset")
    $(insert_modal).modal("hide")
})

$('.insert-meeting-room').click(function() {
    modal_show(insert_modal_meeting)

    $(insert_modal_meeting).find("#insert-meeting").trigger("reset")
    $(insert_modal_meeting).find("ul.select2-selection__rendered").empty()
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
    $(insert_modal_meeting).find("ul.select2-selection__rendered").empty()
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

$(document).on('click', '.btn-detail', function() {
    let event_id = $(this).attr('data-id'),
        url = url_main
    url.searchParams.append('event_id', event_id)
    modalShow(url)
})

/* ********** ADDITIONAL FUNCTION ********** */

function swal_error(text = [], type) {
    let array = [],
        dataError = "";
    if (text.length) {
        if (type == "insert") {
            array.push({
                'insert-name': "ไม่พบข้อมูลหัวข้อ",
                'insert-head': "ไม่พบข้อมูลผู้นำ",
                'insert-description': "ไม่พบข้อมูลเนื้อหา",
                'insert-dates': "ไม่พบข้อมูลวันที่เริ่ม",
                'insert-datee': "ไม่พบข้อมูลวันที่สิ้นสุด",
                'insert-times': "ไม่พบข้อมูลเวลาที่เริ่ม",
                'insert-timee': "ไม่พบข้อมูลเวลาที่สิ้นสุด",
                'insert-rooms-id': "ไม่พบข้อมูลห้องประชุม",
                'insert-rooms-name': "ไม่พบข้อมูลห้องประชุม",
                'insert-car-id': "ไม่พบข้อมูลรถ",
                'insert-car-name': "ไม่พบข้อมูลรถ",
                'insert-driver-id': "ไม่พบข้อมูลผู้ขับ",
                'insert-driver-name': "ไม่พบข้อมูลผู้ขับ",
                'insert-meeting-name': "ไม่พบข้อมูลสถานที่",

            });
        } else if (type == "update") {
            array.push({
                'update-name': "ไม่พบข้อมูลหัวข้อ",
                'update-head': "ไม่พบข้อมูลผู้นำ",
                'update-description': "ไม่พบข้อมูลเนื้อหา",
                'update-dates': "ไม่พบข้อมูลวันที่เริ่ม",
                'update-datee': "ไม่พบข้อมูลวันที่สิ้นสุด",
                'update-times': "ไม่พบข้อมูลเวลาที่เริ่ม",
                'update-timee': "ไม่พบข้อมูลเวลาที่สิ้นสุด",
                'update-rooms-id': "ไม่พบข้อมูลห้องประชุม",
                'update-rooms-name': "ไม่พบข้อมูลห้องประชุม",
                'update-car-id': "ไม่พบข้อมูลรถ",
                'update-car-name': "ไม่พบข้อมูลรถ",
                'update-driver-id': "ไม่พบข้อมูลผู้ขับ",
                'update-driver-name': "ไม่พบข้อมูลผู้ขับ",
                'update-meeting-name': "ไม่พบข้อมูลสถานที่",
            });
        }

        text.forEach(function(item) {
            dataError += array[0][item] + "<br>"
        })
    }

    Swal.fire({
        title: 'ไม่สำเร็จ',
        html: dataError,
        icon: 'error'
    })

}

function swal_alert(icon, title, text) {
    Swal.fire(title, text, icon).then((result) => {

        $('.modal').modal('hide')

        let params = new URLSearchParams(url_main.search)
        params.delete("event_id")
        url_main.search = params

        reloadData(url_main)

        datatableReload(url_draft)
    })

}

function swal_reason(data, ctl) {
    Swal.fire({
        title: "กรุณาระบุเหตุผลที่ไม่เข้าร่วม",
        input: "text",
        inputAttributes: {
            autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "ยืนยัน",
        showLoaderOnConfirm: true,
        preConfirm: async (reason) => {
            if (!reason) {
                Swal.showValidationMessage(`กรุณาระบุ`);
            } else {
                return data.append('reason', reason)
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            invitation(data, ctl)
        }
    });
}

function swal_delete(data, ctl) {
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
            delete_meeting(data, ctl)
        }
    })
    $('.modal').modal('hide')
}

function swal_confirm(text, color, func, data, ctl) {
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
                approval(data, text)
            } else if (func == "invitation") {
                invitation(data, ctl)
            } else if (func == "processing") {
                processing(data, ctl)
            } else if (func == "restore") {
                restore(data, ctl)
            }

        }
    })

    $('.modal').modal('hide')
}

/* ********** CRUD FUNCTION ********** */
let row_error = "",
    txt_error = "";

function insert_meeting(insert_data, ctl) {
    let url = new URL('appointment/' + ctl + '/insert_data', domain);

    // let url = ctl + "/insert_data"
    fetch(url, {
            method: 'post',
            body: insert_data
        })
        .then(res => res.json())
        .then((resp) => {
            console.log(resp)

            if (resp.error) {
                swal_error(resp.error, "insert")
            } else {
                swal_alert('success', 'สำเร็จ', '')
                notification(resp.data.id)
            }
        })
}

function update_meeting(update_data, ctl) {
    let url = new URL('appointment/' + ctl + '/update_data', domain);

    // let url = ctl + "/update_data"
    fetch(url, {
            method: 'post',
            body: update_data
        })
        .then(res => res.json())
        .then((resp) => {

            if (resp.error) {
                swal_error(resp.error, "update")
            } else {
                swal_alert('success', 'สำเร็จ', '')
                if (resp.data.status == 1) {
                    notification(resp.data.id)
                }
            }
        })
}

function delete_meeting(delete_data, ctl) {
    let url = new URL('appointment/' + ctl + '/delete_data', domain);

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

function approval(data, text) {
    let url = new URL('appointment/' + ctl + '/approval', domain);

    // let url = ctl + "/approval"
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
                if (text == "อนุมัติ") {
                    notification(resp.data.id)
                }
            }
        })
}

function invitation(data, ctl) {
    let url = new URL('appointment/' + ctl + '/invitation', domain);

    // let url = ctl + "/invitation"
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

function processing(data, ctl) {
    let url = new URL('appointment/' + ctl + '/processing', domain);

    // let url = ctl + "/processing"
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

function restore(data, ctl) {
    let url = new URL('appointment/' + ctl + '/restore', domain);

    // let url = ctl + "/restore"
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
                notification(resp.data.id)
            }
        })
}
</script>