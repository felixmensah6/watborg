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
            <form action="<?= site_url("users/create-user"); ?>" method="post" id="add-user">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label class="label-required">Title</label>
                        <?= select($this->app->user_titles(), 'title', null, ' ', 'form-control select2-nosearch', 'id="title" tabindex="1" data-placeholder="Select Title" data-clear'); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="label-required">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="First Name" id="firstname" tabindex="1">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-required">Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" id="lastname" tabindex="1">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="label-required">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" id="username" tabindex="1" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email (Optional)" id="email" tabindex="1" autocomplete="off">
                        <small class="form-text text-muted">Note: Providing your email helps you to recover your password</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="label-required">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password" tabindex="1">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-required">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" id="confirm_password" tabindex="1">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="label-required">User Role</label>
                        <?= select($this->app->user_roles(), 'role', null, ' ', 'form-control select2-nosearch', 'id="role" tabindex="1" data-placeholder="Select Role" data-clear'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-required">Enforce Password Change</label>
                        <?php
                            $options = [
                                '1' => 'Enforce the change of password on first login',
                                '0' => 'Do not enforce password change'
                            ];
                            echo select($options, 'temp_password', null, ' ', 'form-control select2-nosearch', 'id="temp_password" tabindex="1" data-placeholder="Enforce Password Change" data-clear');
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="d-block">Allow this User to:</label>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_create" id="privilege_create" value="1" checked tabindex="1"><span></span> Add/Create Records
                        </label><br>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_update" id="privilege_update" value="1" tabindex="1"><span></span> Update/Edit Records
                        </label><br>
                        <label class="switch switch-sm switch-primary">
                            <input type="checkbox" name="privilege_trash" id="privilege_trash" value="1" tabindex="1"><span></span> Delete/Remove Records
                        </label>
                    </div>
                </div>
                <input type="hidden" name="submit" value="submit">
                <button onclick="submitForm('#add-user', true);return false;" class="btn btn-primary" tabindex="1">Submit</button>
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
        $('.select2-nosearch').select2({
            minimumResultsForSearch: -1
        });

    });
</script>
