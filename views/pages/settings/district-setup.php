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

    <!-- Heading -->
    <div class="page-heading">
        <button type="button" class="btn btn-primary btn-sm float-right load-modal" data-url="<?= site_url('settings/add-district/'); ?>" data-title="Add New District" data-toggle="modal" data-target="#page-modal" data-backdrop="static">
            <i class="icon-plus mr-1"></i> Add District
        </button>
    </div>

    <!-- Panel -->
    <div class="panel panel-default bordered">
        <div class="panel-body" id="table-loader">
            <div class="table-responsive">
                <table id="records" class="table table-striped table-hover" width="100%" data-ajax="<?= site_url('settings/display-districts/'); ?>" data-save-state="true" data-page-length="10" data-targets="[0, -1]" data-order="[[ 1, &quot;asc&quot; ]]">
                    <thead>
                        <tr>
                            <th width="5%" data-orderable="false">#</th>
                            <th>District Name</th>
                            <th>Region</th>
                            <th width="15%" data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Disrict Name</th>
                            <th>Region</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
