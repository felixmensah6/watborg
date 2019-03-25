<!-- Panel -->
<div class="panel mb-0">
    <div class="panel-body p-0">
        <div class="status"></div>
        <form action="<?= site_url("settings/update-locality/" . $locality_id); ?>" method="post">
            <div class="form-group">
                <label class="label-required">Locality Name</label>
                <input type="text" name="locality_name" class="form-control" placeholder="e.g. Kasoa" value="<?= $row['locality_name']; ?>" tabindex="1">
            </div>
            <input type="hidden" name="submit" value="submit">
            <button onclick="submitForm(this.form, false, true);" type="button" class="btn btn-primary mt-3" tabindex="1">Submit</button>
            <button type="button" class="btn btn-default mt-3 float-right" data-dismiss="modal">Close</button>
        </form>
    </div>
</div>
