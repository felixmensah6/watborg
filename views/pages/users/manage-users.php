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

    <!-- Panel -->
    <div class="panel panel-default bordered">
        <div class="panel-body" id="table-loader">
            <div class="table-responsive">
                <table id="records" class="table table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Username</th>
                            <th>User Role</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Username</th>
                            <th>User Role</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
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
