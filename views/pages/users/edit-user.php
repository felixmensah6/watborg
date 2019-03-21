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
        <div class="panel-body">
            <div class="status"></div>
            <form action="<?= site_url("users/update-user/" . $userid); ?>" method="post">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label class="label-required">Title</label>
                        <?= select($this->app->user_titles(), 'title', $row['title'], ' ', 'form-control select2', 'data-placeholder="Select Title" data-minimum-results-for-search="Infinity" tabindex="1" data-width="100%" data-clear'); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="label-required">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="First Name" tabindex="1" value="<?= $row['firstname']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-required">Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" tabindex="1" value="<?= $row['lastname']; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email (Optional)" tabindex="1" autocomplete="off" value="<?= $row['email']; ?>">
                        <small class="form-text text-muted">Note: Providing your email helps you to recover your password</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-required">User Role</label>
                        <?= select($this->app->user_roles(), 'role', $row['role_id'], ' ', 'form-control select2', 'data-placeholder="Select Role" data-minimum-results-for-search="Infinity" tabindex="1" data-width="100%" data-clear'); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="d-block">Allow this User to:</label>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_create" value="1" <?= $this->app->is_checked($row['privilege_create'], 1); ?> tabindex="1"><span></span> Add/Create Records
                        </label><br>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_update" value="1" <?= $this->app->is_checked($row['privilege_update'], 1); ?> tabindex="1"><span></span> Update/Edit Records
                        </label><br>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_trash" value="1" <?= $this->app->is_checked($row['privilege_trash'], 1); ?> tabindex="1"><span></span> Delete/Remove Records
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="d-block">Lock this account</label>
                        <label class="switch switch-sm switch-primary d-block">
                            <input type="checkbox" name="locked" value="1" <?= $this->app->is_checked($row['locked'], 1); ?> tabindex="1"><span></span>
                        </label>
                    </div>
                </div>
                <input type="hidden" name="submit" value="submit">
                <button onclick="submitForm(this.form, false);" type="button" class="btn btn-primary" tabindex="1">Submit</button>
            </form>
        </div>
    </div>

</div>
