<!-- Panel -->
<div class="panel mb-0">
    <div class="panel-body p-0">
        <div class="status"></div>
        <form action="<?= site_url("settings/update-service/" . $service_id); ?>" method="post">
            <div class="form-group">
                <label class="label-required">Service Name</label>
                <input type="text" name="service_name" class="form-control" value="<?= $row['service_name']; ?>" placeholder="e.g. Consultation" tabindex="1">
            </div>
            <div class="form-group">
                <label class="label-required">Service Category</label>
                <?= select($this->app->service_categories(), 'service_category', $row['service_category'], ' ', 'form-control select2', 'tabindex="1" data-placeholder="Select Category" data-minimum-results-for-search="Infinity" data-width="100%" data-clear'); ?>
            </div>
            <div class="form-group">
                <label>Service Cost</label>
                <div class="input-group spinner" data-trigger="spinner">
                    <div class="input-group-prepend">
                        <span class="input-group-text">GHS</span>
                    </div>
                    <input type="text" class="form-control" name="service_cost" value="<?= $row['service_cost']; ?>" data-rule="currency" data-step="1.00" tabindex="1">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-default spin-up" data-spin="up"><i class="icon-chevron-up"></i></button>
                        <button type="button" class="btn btn-default spin-down" data-spin="down"><i class="icon-chevron-down"></i></button>
                    </span>
                </div>
            </div>
            <input type="hidden" name="submit" value="submit">
            <button onclick="submitForm(this.form, false, true);" type="button" class="btn btn-primary mt-3" tabindex="1">Submit</button>
        </form>
    </div>
</div>

<!-- Javascript -->
<script src="<?= asset('plugins/select2/js/select2.min.js'); ?>"></script>
<script src="<?= asset('js/unity.core.min.js'); ?>"></script>
<script type="text/javascript">

    // Select 2
    $('.select2').select2();

</script>
