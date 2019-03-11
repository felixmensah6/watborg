<!-- Page Header -->
<div class="page-header has-menu">
    <div class="page-title">
        <h5><?= $title; ?></h5>
    </div>
    <div class="page-header-link">
        <a href="#" class="link" data-toggle="tooltip" data-placement="bottom" title="Help">
            <i class="icon-question-circle"></i>
        </a>
    </div>
    <?= $this->app->page_menu($page_menu_list, $this->session->role_level); ?>
</div>

<!-- Content -->
<div class="content boxed">

    <!-- Panel -->
    <div class="panel panel-default bordered">
        <div class="panel-body" id="table-loader">
            <div class="table-responsive">
                <table id="records" class="table table-striped table-hover" width="100%" data-ajax="<?= site_url('cashier/display-pending-bills/'); ?>" data-save-state="true" data-page-length="10" data-targets="[0, -1]" data-order="[[ 7, &quot;desc&quot; ]]">
                    <thead>
                        <tr>
                            <th data-orderable="false">#</th>
                            <th>Hosp. Number</th>
                            <th>Patient Name</th>
                            <th>Phone Number</th>
                            <th>Patient Type</th>
                            <th>Total Cost</th>
                            <th>Amount Paid</th>
                            <th>Date Added</th>
                            <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Hosp. Number</th>
                            <th>Patient Name</th>
                            <th>Phone Number</th>
                            <th>Patient Type</th>
                            <th>Total Cost</th>
                            <th>Amount Paid</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
