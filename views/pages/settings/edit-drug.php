<!-- Panel -->
<div class="panel mb-0">
    <div class="panel-body p-0">
        <div class="status"></div>
        <form action="<?= site_url("settings/update-drug/" . $drug_id); ?>" method="post">
            <div class="form-group">
                <label class="label-required">Drug Name</label>
                <input type="text" name="drug_name" class="form-control" value="<?= $row['drug_name']; ?>" placeholder="e.g. Tobrex" tabindex="1">
            </div>
            <div class="form-group">
                <label>Drug Cost</label>
                <div class="input-group spinner" data-trigger="spinner">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><?= $currency; ?></span>
                    </div>
                    <input type="text" class="form-control" name="drug_cost" value="<?= $row['drug_cost']; ?>" data-rule="currency" data-step="1.00" tabindex="1">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-default spin-up" data-spin="up"><i class="icon-chevron-up"></i></button>
                        <button type="button" class="btn btn-default spin-down" data-spin="down"><i class="icon-chevron-down"></i></button>
                    </span>
                </div>
            </div>
            <input type="hidden" name="submit" value="submit">
            <button onclick="submitForm(this.form, false, true);" type="button" class="btn btn-primary mt-3" tabindex="1">Submit</button>
            <button type="button" class="btn btn-default mt-3 float-right" data-dismiss="modal">Close</button>
        </form>
    </div>
</div>

<!-- Javascript -->
<script src="<?= asset('js/unity.core.min.js'); ?>"></script>
