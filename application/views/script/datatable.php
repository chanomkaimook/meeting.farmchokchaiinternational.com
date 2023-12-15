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
                "data": "STATUS_COMPLETE_NAME"
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
                            <a href="" data-id="${data['ID']}" class="dropdown-item btn-detail" data-toggle="modal" data-dismiss="modal">
                                <span class="align-middle">รายละเอียด</span>
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

function modalShow(url)
{
    get_data(url)
        .then((data) => {
            
            modal_show('#detail-modal-meeting')
            form_displayed(data)
        })
}

function reloadData(url) {
    // $('#data_table').DataTable().ajax.reload()
    createDatatable(url)
    // if (filter) {
    //     createDatatable(url, filter)
    // } else {
    // }
}

function datatableReload(url_draft) {
    createDraftModal(url_draft)
}

async function createQueue(url, array = []) {
    let response = await fetch(url, {
        method: 'post',
        body: array
    })

    return response.json()
}

async function get_data(url, array = []) {
    let response = await fetch(url, {
        method: 'post',
        body: array
    })

    return response.json()
}

async function get_data_draft(url) {
    let response = await fetch(url, {})

    return response.json()
}
</script>