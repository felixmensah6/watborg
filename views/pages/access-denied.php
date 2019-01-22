<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= asset('images/favicon.png'); ?>" sizes="32x32" type="image/png">
    <title><?= env('APP_OWNER') . ' - ' . env('APP_NAME'); ?></title>

    <!-- Stylesheets -->
    <link href="<?= asset('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= asset('css/unity.css'); ?>" rel="stylesheet">

    <!-- Javascript -->
    <script src="<?= asset('js/jquery.min.js'); ?>"></script>
    <script src="<?= asset('js/bootstrap.min.js'); ?>"></script>
</head>

<body>
    <!-- Wrapper -->
    <div class="wrapper">

        <!-- Login Form Container -->
        <div class="row login-box">
            <div class="col-sm-12 col-md-10 col-lg-6">

                <div class="error-box">
                    <span class="error-icon">
                        <i class="icon-ban"></i>
                    </span>
                    <h3>Access denied!</h3>
                    <p>You do not have the necessary privileges to access this section. Contact your system administrator.</p>
                    <a href="javascript:history.back()" class="btn btn-light btn-label mt-3">
                        <span class="btn-label-left"><i class="icon-arrow-left"></i></span>Go Back
                    </a>
                </div>

            </div>
        </div>

    </div>

    <!-- Javascript -->
    <script src="<?= asset('js/unity.core.min.js'); ?>"></script>
    <script src="<?= asset('js/unity.min.js'); ?>"></script>
    <script src="<?= asset('js/watborg.js'); ?>"></script>
</body>

</html>
