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

<body class="bg-image">
    <!-- Wrapper -->
    <div class="wrapper">

        <!-- Login Form Container -->
        <div class="row login-box">
            <div class="col-sm-6 col-md-5 col-lg-4 login-box-content">

                <!-- Panel -->
                <div class="panel panel-default panel-light bordered">
                    <div class="panel-heading">
                        <div class="panel-title login-box-header py-3">
                            <img src="<?= asset('images/watborg2.svg'); ?>" width="32" height="32">
                            <h4><?= env('APP_OWNER'); ?></h4>
                            <p class="text-muted mb-0">Please Log In below to get Started.</p>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?= site_url("login/authenticate"); ?>">
                            <div class="status"></div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" tabindex="1">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" tabindex="1">
                            </div>
                            <div class="form-row login-forgot">
                                <div class="form-group col-6"></div>
                                <div class="form-group col-6 text-right">
                                    <a href="<?= site_url('password-reset'); ?>" tabindex="1">Forgot password?</a>
                                </div>
                            </div>
                            <input type="hidden" name="submit" value="submit">
                            <button type="submit" onclick="submitForm(this.form); return false;" class="btn btn-primary btn-block mb-2" tabindex="1">Log In</button>
                        </form>
                    </div>
                </div>

                <div class="login-box-footer text-muted">
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
