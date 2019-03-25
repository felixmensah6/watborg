<!-- Panel -->
<div class="panel mb-0">
    <div class="panel-body p-0">
        <div class="status"></div>
        <form action="<?= site_url("settings/create-district"); ?>" method="post">
            <div class="form-group">
                <label class="label-required">District Name</label>
                <input type="text" name="district_name" class="form-control" placeholder="e.g. Bongo" tabindex="1">
            </div>
            <div class="form-group">
                <label class="label-required">Region</label>
                <?= select($this->app->district_regions(), 'region', null, ' ', 'form-control select2', 'tabindex="1" data-placeholder="Select Region" data-minimum-results-for-search="Infinity" data-width="100%" data-clear'); ?>
            </div>
            <input type="hidden" name="submit" value="submit">
            <button onclick="submitForm(this.form, true, true);" type="button" class="btn btn-primary mt-3" tabindex="1">Submit</button>
            <button type="button" class="btn btn-default mt-3 float-right" data-dismiss="modal">Close</button>
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
