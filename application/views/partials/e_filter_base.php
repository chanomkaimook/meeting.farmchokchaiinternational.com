<div id="accordion">
    <div class="card mb-0">

        <?php require_once('application/views/partials/dom_filter_collaspe.php'); ?>

        <div id="collapseOne" class="collapse show d-md-block" aria-labelledby="headingOne" data-parent="#accordion">

            <div class="d-sm-flex">
                <div class="filter">
                    <?php require_once('application/views/partials/dom_filter_calendar.php'); ?>
                </div>
                <div class="filter-add">
                    <?php require_once('application/views/partials/dom_filter_doc.php'); ?>
                </div>

                <?php require_once('application/views/partials/dom_filter_button.php'); ?>
            </div>

        </div>
    </div>
</div>