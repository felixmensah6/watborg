<!-- Stylesheets -->
<link href="<?= asset("plugins/datatables/css/datatables.bootstrap.css"); ?>" rel="stylesheet">

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
    <?= $this->app->page_menu($page_menu_list); ?>
</div>

<!-- Content -->
<div class="content boxed">

    <!-- Heading -->
    <div class="page-heading">
        <button type="button" class="btn btn-default btn-sm load-modal" data-toggle="modal" data-target="#add-service" data-backdrop="static">
            <i class="icon-plus mr-1"></i> Add New Service
        </button>
    </div>

    <!-- Panel -->
    <div class="panel panel-default bordered">
        <div class="panel-body" id="table-loader">
            <div class="table-responsive">
                <table id="records" class="table table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Service Category</th>
                            <th>Service Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Service Category</th>
                            <th>Service Price</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add-service" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" >Add New Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Panel -->
                    <div class="panel mb-0">
                        <div class="panel-body p-0">
                            <div class="status"></div>
                            <form action="<?= site_url("settings/create-service"); ?>" method="post">
                                <div class="form-group">
                                    <label class="label-required">Service Name</label>
                                    <input type="text" name="service_name" class="form-control" placeholder="e.g. Consultation" tabindex="1">
                                </div>
                                <div class="form-group">
                                    <label class="label-required">Service Category</label>
                                    <?= select($this->app->service_categories(), 'service_category', null, ' ', 'form-control select2', 'tabindex="1" data-placeholder="Select Category" data-minimum-results-for-search="Infinity" data-width="100%" data-clear'); ?>
                                </div>
                                <div class="form-group">
                                    <label class="label-required">Service Price</label>
                                    <div class="input-group spinner" data-trigger="spinner">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">GHS</span>
                                        </div>
                                        <input type="text" class="form-control" name="service_price" data-rule="currency" data-step="0.50" tabindex="1">
                                        <span class="input-group-append">
                                            <button class="btn btn-default spin-up" data-spin="up"><i class="icon-chevron-up"></i></button>
                                            <button class="btn btn-default spin-down" data-spin="down"><i class="icon-chevron-down"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" name="submit" value="submit">
                                <button onclick="submitForm(this.form, true, true);" class="btn btn-primary mt-3" tabindex="1">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Javascript -->
<script src="<?= asset("plugins/datatables/js/datatables.min.js"); ?>"></script>
<script src="<?= asset("plugins/datatables/js/datatables.bootstrap.min.js"); ?>"></script>
<script type="text/javascript">
    // Initialize datatables
    $('#records').DataTable({
        "processing": true,
        "stateSave": true,
        "serverSide": true,
        "ajax": "<?= site_url('users/display-users/'); ?>",
        "aoColumnDefs": [
            {
                'bSortable': false,
                'bSearchable': false,
                'aTargets': [ 0, -1 , -2 ]
            }
        ],
        "order": [[ 1, "asc" ]],
        "pageLength": 25
    });
</script>
