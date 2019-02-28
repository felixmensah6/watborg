<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= asset('images/favicon.png'); ?>" sizes="32x32" type="image/png">
    <title><?= env('APP_OWNER') . ' - ' . env('APP_NAME'); ?></title>

    <!-- Stylesheets -->
    <link href="<?= asset('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= asset('plugins/select2/css/select2.min.css'); ?>" rel="stylesheet">
    <link href="<?= asset('plugins/datetimepicker/css/datetimepicker.min.css'); ?>" rel="stylesheet">
    <link href="<?= asset("plugins/datatables/css/datatables.bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?= asset('css/unity.css'); ?>" rel="stylesheet">

    <!-- Javascript -->
    <script src="<?= asset('js/jquery.min.js'); ?>"></script>
</head>

<body>
    <!-- Wrapper -->
    <div class="wrapper">

        <!-- Login Form Container -->
        <div class="row login-box">
            <div class="col-sm-6 col-md-5 col-lg-4 login-box-content">

                <!-- Panel -->
                <div class="panel panel-default bordered">
                    <div class="panel-heading">
                        <div class="panel-title login-box-header">
                            <h4><?= env('APP_OWNER'); ?></h4>
                            <p class="text-muted mb-0">Create a new password for your Account.</p>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?= site_url("login/set-password"); ?>">
                            <div class="status"><?= $this->app->alert('warning', $this->app_lang->set_password_info, true); ?></div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="New Password" autocomplete="off" tabindex="1">
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" autocomplete="off" tabindex="1">
                            </div>
                            <input type="hidden" name="submit" value="submit">
                            <button type="submit" onclick="submitForm(this.form, true);" class="btn btn-primary btn-block mb-3" tabindex="1">Save Password</button>
                            <div class="login-box-footer">
                                Don't want to change password?
                                <a href="<?= site_url("logout"); ?>">Logout.</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="login-box-footer">
                    Copyright © <?= env('APP_DEVELOPER'); ?>
                </div>

            </div>
        </div>

    </div>

    <!-- Javascript -->
    <script src="<?= asset('js/bootstrap.min.js'); ?>"></script>
    <script src="<?= asset('plugins/select2/js/select2.min.js'); ?>"></script>
    <script src="<?= asset('plugins/moment/js/moment.min.js'); ?>"></script>
    <script src="<?= asset('plugins/datetimepicker/js/datetimepicker.min.js'); ?>"></script>
    <script src="<?= asset("plugins/datatables/js/datatables.min.js"); ?>"></script>
    <script src="<?= asset("plugins/datatables/js/datatables.bootstrap.min.js"); ?>"></script>
    <script src="<?= asset('js/unity.core.min.js'); ?>"></script>
    <script src="<?= asset('js/unity.min.js'); ?>"></script>
    <script src="<?= asset('js/watborg.js'); ?>"></script>
</body>

</html>
