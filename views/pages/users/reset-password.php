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
        <div class="panel-heading">
            <div class="panel-title">
                <h6>Reset Password for <?= ucwords($row['firstname'] . ' ' . $row['lastname']); ?></h6>
            </div>
        </div>
        <div class="panel-body">
            <div class="status"></div>
            <form action="<?= site_url("users/update-password/" . $userid); ?>" method="post" id="reset-password">
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
                <input type="hidden" name="submit" value="submit">
                <button onclick="submitForm('#reset-password', true);return false;" class="btn btn-primary" tabindex="1">Submit</button>
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
