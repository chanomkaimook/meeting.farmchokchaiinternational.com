<script>
function createFullcalendar(url,array = []) {
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

                /* drop: function(date) {
                    calendarDrop($(this), date);
                }, */
                // select: function(start, end, allDay) {
                //     modal_insert(start, end, allDay);
                // },
                eventClick: function(calEvent, jsEvent, view) {
                    detail(calEvent, jsEvent, view);
                },
            });
        })
}

function calendarDestroy(calendar, url, filter = null) {
    $(calendar).fullCalendar('destroy');
    $(calendar).empty();
    if (filter) {
        createFullcalendar(url,filter)
    } else {
        createFullcalendar(url)
    }
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