<!-- Stylesheets -->
<link href="<?= asset('plugins/select2/css/select2.min.css'); ?>" rel="stylesheet">
<link href="<?= asset('plugins/datetimepicker/css/datetimepicker.min.css'); ?>" rel="stylesheet">

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
            <form action="<?= site_url("users/create-user"); ?>" method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="label-required">Hospital Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="hospital_number" id="hospital_number" placeholder="e.g. 174/19" readonly tabindex="1">
                            <?= select(['0'=>'New','1'=>'Old'], 'patient_type', null, null, 'form-control select2', 'id="patient_type" tabindex="1" data-width="30%" data-minimum-results-for-search="Infinity" data-clear'); ?>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="patient_search" disabled tabindex="1">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group offset-md-4 col-md-4">
                        <label class="label-required">Service</label>
                        <?= select($this->app->occupations(), 'occupation', null, ' ', 'form-control select2', ' tabindex="1" data-placeholder="Select Service" data-width="100%" data-clear'); ?>
                    </div>
                </div>
                <fieldset class="mt-3">
                    <legend>Patient Information</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Surname</label>
                            <input type="text" name="lastname" class="form-control" placeholder="e.g. Adongo" tabindex="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Other Names</label>
                            <input type="text" name="firstname" class="form-control" placeholder="e.g. John" tabindex="1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="label-required d-block">Gender</label>
                            <label class="radio-inline radio-styled mt-2 mr-3">
                                <input type="radio" name="gender"> Male
                                <span class="tick"></span>
                            </label>
                            <label class="radio-inline radio-styled mt-2 mr-3">
                                <input type="radio" name="gender"> Female
                                <span class="tick"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="label-required">Marrital Status</label>
                            <?= select($this->app->marrital_status(), 'marrital_status', null, ' ', 'form-control select2', ' tabindex="1" data-placeholder="Select Marrital Status" data-minimum-results-for-search="Infinity" data-width="100%" data-clear'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Date of Birth</label>
                            <div class="input-group datetimepicker mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Age: <span class="ml-1" id="age">0</span></span>
                                </div>
                                <input type="text" class="form-control" name="birthday" id="birthday" placeholder="dd/mm/yyyy" data-date-format="DD/MM/YYYY" tabindex="1">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="button"><i class="icon-calendar-alt"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Occupation</label>
                            <?= select($this->app->occupations(), 'occupation', null, ' ', 'form-control select2', ' tabindex="1" data-placeholder="Select Occupation" data-tags="true" data-width="100%" data-clear'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Religion</label>
                            <?= select($this->app->religion(), 'religion', null, ' ', 'form-control select2', ' tabindex="1" data-placeholder="Select Religion" data-minimum-results-for-search="Infinity" data-width="100%" data-clear'); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Home Address</label>
                            <input type="text" name="address" class="form-control" placeholder="e.g. Akwele, Kasoa" tabindex="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label-required">Contact Number</label>
                            <input type="phone" name="phone" class="form-control" placeholder="e.g. 024xxxxxxx" tabindex="1">
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-3 mb-3">
                    <legend>Next of Kin Information</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="label-required">Full Name</label>
                            <input type="text" name="relative_name" class="form-control" id="relative_name" placeholder="e.g. John Adongo" tabindex="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Contact Number</label>
                            <input type="phone" name="relative_phone" class="form-control" id="relative_phone" placeholder="e.g. 024xxxxxxx (Optional)" tabindex="1">
                        </div>
                    </div>
                </fieldset>
                <input type="hidden" name="submit" value="submit">
                <button onclick="submitForm(this.form);" class="btn btn-primary" tabindex="1">Submit</button>
            </form>
        </div>
    </div>

</div>

<!-- Javascript -->
<script src="<?= asset('plugins/select2/js/select2.min.js'); ?>"></script>
<script src="<?= asset('plugins/moment/js/moment.min.js'); ?>"></script>
<script src="<?= asset('plugins/datetimepicker/js/datetimepicker.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){

        // Select2 bootstrap theme
        $.fn.select2.defaults.set( "theme", "bootstrap" );

        // Select2
        $('.select2').select2();

        // Datepicker
        $('.datetimepicker').datetimepicker();

        // Hospital Number 
        $('#patient_type').on('change', function() {
            if(this.value == 1){
                $('#patient_search').removeProp('disabled');
                $('#hospital_number').removeProp('readonly');
            }else{
                $('#patient_search').prop('disabled', true);
                $('#hospital_number').prop('readonly', true);
            }
        });

        $('.datetimepicker').on("dp.change", function (e) {
            var input_date = format_date($("#birthday").val(), '/'),
                birth_date = (input_date == null) ? new Date() : new Date(input_date),
                age = moment().diff(birth_date, 'years');
            $("#age").text(age);
        });

    });
</script>
