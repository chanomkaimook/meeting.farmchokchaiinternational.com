<script>
function createDatatable(url) {
    $('#data_table').DataTable().destroy();
    
    $('#data_table').DataTable({
        ajax: {
            url: url,
            type: "post",
            dataType: "json",
            data: function(d) {
                d.dates = $('#hidden_dates').val(),
                    d.datee = $('#hidden_datee').val(),
                    d.times = $('#hidden_times').val(),
                    d.timee = $('#hidden_timee').val(),
                    d.user = $('#hidden_user').val(),
                    d.permit = $('#hidden_permit').val(),
                    d.status = $('#hidden_status').val(),
                    d.area = $('#hidden_area').val(),
                    d.type = $('#hidden_type').val()
            }
        },
        autoWidth: false,
        // columnDefs: [ { orderDataType: 'date-time', 'targets': [2] } ],
        "order": [],
        columns: [{
                "data": "HEAD_FULLNAME"
            },
            {
                "data": "EVENT_NAME"
            },
            {
                "data": {
                    _: "date_datatable.display",
                    sort: "date_datatable.timestamp"
                }
            },
            {
                "data": "TIME_BEGIN_SHOW"
            },
            {
                "data": "USER_START_FULLNAME"
            },
            {
                "data": "STATUS_SHOW"
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
                            <a href="" class="dropdown-item delete-meeting" data-event-id='${data['ID']}' data-event-code='${data['CODE']}'>
                                <span class="align-middle">ลบ</span>
                            </a>
                        </div>
                </div>

         `
            $('td', row).eq(6).html(table_btn_name)
        },

        dom: datatable_dom,
        buttons: datatable_button,

    });

}
/* function createDatatable(url,datatable,array = []) {
    get_data(url,array)
        .then((data) => {
            // console.log(data)
            let dataDefault = [];
            if (data) {
                data.forEach(function(item, index) {
                    dataDefault.push(item);
                })
            }
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: dataDefault,
                timeFormat: "H:mm",
                // droppable: true, // this allows things to be dropped onto the calendar !!!
                // selectable: true,

                drop: function(date) {
                    calendarDrop($(this), date);
                },
                // select: function(start, end, allDay) {
                //     modal_insert(start, end, allDay);
                // },
                eventClick: function(calEvent, jsEvent, view) {
                    detail(calEvent, jsEvent, view);
                },
            });
        })
} */

function reloadData(url, filter = null) {
    // $('#data_table').DataTable().destroy()
    if (filter) {
        createDatatable(url, filter)
    } else {
        createDatatable(url)
    }
}

function datatableReload(url_draft) {
    createDraftModal(url_draft)
}

/* async function get_data(url, array = []) {
    let response = await fetch(url, {
        method: 'post',
        body: array
    })

    return response.json()
}
 */
async function get_data_draft(url) {
    let response = await fetch(url, {})

    return response.json()
}
</script>