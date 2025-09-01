<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Errors!</strong>
            <ul class="list-disc pl-5">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <h2 class="text-2xl font-bold mb-4">New Booking Application</h2>

    <form method="post" action="<?= site_url('/applications/store') ?>" class="space-y-4">
        <div>
            <label>Application No</label>
            <input type="text" name="app_no" value="<?= $app_no ?>" readonly class="border rounded w-full p-2">
        </div>

        <div>
            <label>Application Date</label>
            <input type="date" name="app_date" value="<?= date('Y-m-d') ?>" class="border rounded w-full p-2">
        </div>

        <div>
            <label>Customer</label>
            <select name="customer_id" class="border rounded w-full p-2">
                <option value="">Select Customer</option>
                <?php foreach ($customers as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Cascading Dropdowns -->
        <div>
            <label>Project</label>
            <select id="project" name="project_id" class="border rounded w-full p-2">
                <option value="">Select Project</option>
                <?php foreach ($projects as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Phase</label>
            <select id="phase" name="phase_id" class="border rounded w-full p-2"></select>
        </div>

        <div>
            <label>Sector</label>
            <select id="sector" name="sector_id" class="border rounded w-full p-2"></select>
        </div>

        <div>
            <label>Street</label>
            <select id="street" name="street_id" class="border rounded w-full p-2"></select>
        </div>

        <div>
            <label>Plot</label>
            <select name="plot_id" id="plot" class="border rounded w-full p-2"></select>
            <!-- <select id="plot" name="plot_id" class="border rounded w-full p-2">
                <?php foreach ($plots as $plot): ?>
                    <option value="<?= $plot['id'] ?>"><?= $plot['plot_no'] ?> (<?= $plot['size'] ?>)</option>
                <?php endforeach; ?>
            </select> -->
        </div>

        <div>
            <label>Booking Amount</label>
            <input type="number" step="0.01" name="booking_amount" value="<?= old('booking_amount') ?>" class="border rounded w-full p-2">
        </div>

        <div>
            <label>Installment Plan</label>
            <select name="installment_plan_id" id="installment_plan" class="border rounded w-full p-2">
                <option value="">Select Installment Plan</option>
                <?php print_r($installmentPlans); ?>
                <?php foreach ($installmentPlans as $plan): ?>
                    <option value="<?= $plan['id'] ?>"><?= $plan['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Terms Accepted</label>
            <input type="checkbox" name="terms_accepted" value="1" required>
        </div>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Save Application</button>
        <a href="<?= site_url('/applications') ?>" class="bg-gray-300 text-gray-800 px-6 py-2 rounded">Cancel</a>
    </form>
</div>

<!-- AJAX for cascading dropdowns -->
<script>
    // document.getElementById('project_id').addEventListener('change', function() {
    //     fetch('/phases/byProject/' + this.value)
    //         .then(res => res.json())
    //         .then(data => {
    //             let phaseSelect = document.getElementById('phase_id');
    //             phaseSelect.innerHTML = '<option value="">Select Phase</option>';
    //             data.forEach(p => {
    //                 phaseSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
    //             });
    //         });
    // });

    // Similar fetch logic for sectors, streets, plots...

    $(document).ready(function() {

        // When Project changes, load phases
        $('#project').change(function() {
            let project_id = $(this).val();
            $('#phase').html('<option value="">Loading...</option>');
            $.getJSON("<?= site_url("/phases/byProject/") ?>" + project_id, function(data) {
                let options = '<option value="">Select Phase</option>';
                data.forEach(row => options += `<option value="${row.id}">${row.name}</option>`);
                $('#phase').html(options);
                $('#sector').html('<option value="">Select Sector</option>');
                $('#street').html('<option value="">Select Street</option>');
            });
        });

        // When Phase changes, load sectors
        $('#phase').change(function() {
            let phase_id = $(this).val();
            $('#sector').html('<option value="">Loading...</option>');
            $.getJSON("<?= site_url('/sectors/byPhase/') ?>" + phase_id, function(data) {
                let options = '<option value="">Select Sector</option>';
                data.forEach(row => options += `<option value="${row.id}">${row.name}</option>`);
                $('#sector').html(options);
                $('#street').html('<option value="">Select Street</option>');
            });
        });

        // When Sector changes, load streets
        $('#sector').change(function() {
            let sector_id = $(this).val();
            $('#street').html('<option value="">Loading...</option>');
            $.getJSON("<?= site_url('/streets/bySector/') ?>" + sector_id, function(data) {
                let options = '<option value="">Select Street</option>';
                data.forEach(row => options += `<option value="${row.id}">${row.street_no}</option>`);
                $('#street').html(options);
            });
        });
        // When Street changes, load plots
        $('#street').change(function() {
            let street_id = $(this).val();
            $('#plot').html('<option value="">Loading...</option>');
            $.getJSON("<?= site_url('/plots/byStreet/') ?>" + street_id, function(data) {
                let options = '<option value="">Select Plot</option>';
                data.forEach(row => options += `<option value="${row.id}">${row.plot_no} (${row.size})</option>`);
                $('#plot').html(options);
            });
        });


    });
</script>

<?= $this->endSection() ?>