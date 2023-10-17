<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-2">
                <button type="button" id="btn-insert" data-toggle="modal" data-target="#insert-modal"
                    class="btn btn-primary"><i class="fa fa-plus"></i> Booking</button>
            </div>
            <div class="col-lg-10 text-right">
                <!-- <a id="btn-insert" href="#" data-toggle="modal" data-target="#event-modal" class="btn btn-lg btn-primary btn-block waves-effect mt-2 waves-light">
                            <i class="fa fa-plus"></i> Booking
                        </a> -->
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div id="calendar"></div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>

        </div>
    </div>
</div>

<?php
include "crud_event_modal.php";
?>
<script>
$(document).ready(function() {

    /**
     * Button modal 
     */
    /**
     * #
     * # Properties Button
     * 1. btn_insert = button insert
     * 2. save_category = button save
     * 3. approve_footer = button approve,button not approve
     * 4. save_footer = button save,button close
     * 5. btn_unloading = button save in #detail-modal
     * 6. btn_loading = button save (spinner) in #detail-modal
     * 7. btn_edit = button edit in #detail-modal
     * 8. btn_delete = button delete in #detail-modal
     * 
     * 
     */

    let btn_insert = '#btn-insert'
    let save_category = '.save-category'
    let approve_footer = '.approve-footer'
    let save_footer = '.save-footer'
    let btn_edit = '.btn-edit'
    let btn_delete = '.btn-delete'
    let btn_unloading = '.unloading'
    let btn_loading = '.loading'

    /**
     * #
     * #
     */
    // console.log($('select[name=select-visitor]'))

    // select2
    $('[data-toggle=select2]').select2({
        theme: "bootstrap"
    });

    // inisialize datepicker
    $('.datepicker-autoclose').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
    });


    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        // events: dateDefault,
        timeFormat: "H:mm",
        droppable: true, // this allows things to be dropped onto the calendar !!!
        selectable: true,

        /* drop: function(date) {
            calendarDrop($(this), date);
        }, */
        select: function(start, end, allDay) {
            calendarSelect(start, end, allDay);
        },
        /* eventClick: function(calEvent, jsEvent, view) {
            calendarClick(calEvent, jsEvent, view);
        }, */
    });

    function calendarSelect(start, end, allDay) {
        $("#detail-modal").modal("show")
    }
})
</script>