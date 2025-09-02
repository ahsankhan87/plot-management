<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Edit Plot</h2>

    <form method="post" action=<?= site_url("/plots/update/{$plot['id']}") ?> class="space-y-3">
        <!-- Project Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Project</label>
            <div class="flex">
                <select id="project" name="project_id" class="w-full border rounded p-2">
                    <option value="">-- Select Project --</option>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?= $project['id'] ?>" <?= $project['id'] == $plot['project_id'] ? 'selected' : '' ?>><?= $project['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Phase Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Phase</label>
            <div class="flex">
                <select id="phase" name="phase_id" class="w-full border rounded p-2">
                    <option value="">-- Select Phase --</option>
                    <?php foreach ($phases as $phase): ?>
                        <option value="<?= $phase['id'] ?>" <?= $phase['id'] == $plot['phase_id'] ? 'selected' : '' ?>><?= $phase['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Sector Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Sector</label>
            <div class="flex">
                <select id="sector" name="sector_id" class="w-full border rounded p-2">
                    <option value="">-- Select Sector --</option>
                    <?php foreach ($sectors as $sector): ?>
                        <option value="<?= $sector['id'] ?>" <?= $sector['id'] == $plot['sector_id'] ? 'selected' : '' ?>><?= $sector['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Street Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Street</label>
            <div class="flex">
                <select id="street" name="street_id" class="w-full border rounded p-2">
                    <option value="">-- Select Street --</option>
                    <?php foreach ($streets as $street): ?>
                        <option value="<?= $street['id'] ?>" <?= $street['id'] == $plot['street_id'] ? 'selected' : '' ?>><?= $street['street_no'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div>
            <label>Plot No</label>
            <input type="text" name="plot_no" value="<?= esc($plot['plot_no']) ?>" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label>Block</label>
            <input type="text" name="block" value="<?= esc($plot['block_id']) ?>" class="border rounded w-full p-2">
        </div>
        <div>
            <label>Size</label>
            <input type="text" name="size" value="<?= esc($plot['size']) ?>" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label>Area (sqft)</label>
            <input type="number" name="area_sqft" value="<?= esc($plot['area_sqft']) ?>" class="border rounded w-full p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Base Price</label>
            <input type="number" name="base_price" value="<?= esc($plot['base_price']) ?>" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Type</label>
            <select name="type" class="border rounded w-full p-2">
                <option value="residential" <?= $plot['type'] == 'residential' ? 'selected' : '' ?>>Residential</option>
                <option value="commercial" <?= $plot['type'] == 'commercial' ? 'selected' : '' ?>>Commercial</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Facing</label>
            <select name="facing" class="border rounded w-full p-2">
                <option value="north" <?= $plot['facing'] == 'north' ? 'selected' : '' ?>>North</option>
                <option value="south" <?= $plot['facing'] == 'south' ? 'selected' : '' ?>>South</option>
                <option value="east" <?= $plot['facing'] == 'east' ? 'selected' : '' ?>>East</option>
                <option value="west" <?= $plot['facing'] == 'west' ? 'selected' : '' ?>>West</option>
            </select>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="<?= site_url('/plots') ?>" class="bg-gray-300 text-gray-800 px-6 py-2 rounded">Cancel</a>

    </form>
</div>
<script>
    $(document).ready(function() {

        // When Project changes, load phases
        $('#project').change(function() {
            let project_id = $(this).val();
            $('#phase').html('<option value="">Loading...</option>');
            $.getJSON("<?= site_url("/phases/byProject/") ?>" + project_id, function(data) {
                console.log(data);
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
                console.log(data);
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
                console.log(data);
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
                console.log(data);
                let options = '<option value="">Select Plot</option>';
                data.forEach(row => options += `<option value="${row.id}">${row.plot_no} (${row.size} Marla)</option>`);
                $('#plot').html(options);
            });
        });

    });
</script>
<?= $this->endSection() ?>