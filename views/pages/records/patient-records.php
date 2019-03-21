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
    <?= $this->app->page_menu($this->session->role_level); ?>
</div>

<!-- Content -->
<div class="content boxed">

    <!-- Panel -->
    <div class="panel panel-default bordered">
        <div class="panel-body" id="table-loader">
            <div class="table-responsive">
                <table id="records" class="table table-striped table-hover" width="100%" data-ajax="<?= site_url('records/display-patients/'); ?>" data-save-state="true" data-page-length="10" data-targets="[0, -1, -4]" data-order="[[ 1, &quot;asc&quot; ]]">
                    <thead>
                        <tr>
                            <th data-orderable="false">#</th>
                            <th>Hosp. Number</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Gender</th>
                            <th data-orderable="false">Age</th>
                            <th>Phone No.</th>
                            <th>Last Visit</th>
                            <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Hosp. Number</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Phone No.</th>
                            <th>Last Visit</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
