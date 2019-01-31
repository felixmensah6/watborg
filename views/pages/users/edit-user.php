<!-- Stylesheets -->
<link href="<?= asset('plugins/select2/css/select2.min.css'); ?>" rel="stylesheet">

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
    <div class="panel panel-default bordered column-item">
        <div class="panel-body">
            <div class="status"></div>
            <form action="<?= site_url("users/update-user/" . $userid); ?>" method="post" id="edit-user">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label class="label-required">Title</label>
                        <?= select($this->app->user_titles(), 'title', $row['title'], 'Select Title', 'form-control select2', 'id="title" data-minimum-results-for-search="Infinity" tabindex="1" data-clear'); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="label-required">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="First Name" id="firstname" tabindex="1" value="<?= $row['firstname']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-required">Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" id="lastname" tabindex="1" value="<?= $row['lastname']; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email (Optional)" id="email" tabindex="1" autocomplete="off" value="<?= $row['email']; ?>">
                        <small class="form-text text-muted">Note: Providing your email helps you to recover your password</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-required">User Role</label>
                        <?= select($this->app->user_roles(), 'role', $row['role_id'], 'Select Role', 'form-control select2', 'id="role" data-minimum-results-for-search="Infinity" tabindex="1" data-clear'); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="d-block">Allow this User to:</label>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_create" id="privilege_create" value="1" <?= $this->app->is_checked($row['privilege_create'], 1); ?> tabindex="1"><span></span> Add/Create Records
                        </label><br>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_update" id="privilege_update" value="1" <?= $this->app->is_checked($row['privilege_update'], 1); ?> tabindex="1"><span></span> Update/Edit Records
                        </label><br>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_trash" id="privilege_trash" value="1" <?= $this->app->is_checked($row['privilege_trash'], 1); ?> tabindex="1"><span></span> Delete/Remove Records
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="d-block">Lock this account</label>
                        <label class="switch switch-sm switch-primary d-block">
                            <input type="checkbox" name="locked" id="locked" value="1" <?= $this->app->is_checked($row['locked'], 1); ?> tabindex="1"><span></span>
                        </label>
                    </div>
                </div>
                <input type="hidden" name="submit" value="submit">
                <button onclick="submitForm('#edit-user', false);return false;" class="btn btn-primary" tabindex="1">Submit</button>
            </form>
        </div>
    </div>

</div>

<!-- Javascript -->
<script src="<?= asset('plugins/select2/js/select2.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){

        // Select2 bootstrap theme
        $.fn.select2.defaults.set( "theme", "bootstrap" );

        // Select2
        $('.select2').select2();

    });
</script>
