<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Add New Plot</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <h2 class="font-bold">Validation Errors</h2>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action=<?= site_url("/plots/store") ?> class="space-y-3">
        <!-- Project Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Project</label>
            <div class="flex">
                <select id="project" name="project_id" value="<?= old('project_id') ?>" class="w-full border rounded p-2">
                    <option value="">-- Select Project --</option>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?= $project['id'] ?>" <?= $project['id'] == old('project_id') ? 'selected' : '' ?>><?= $project['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="ml-2 bg-blue-500 text-white px-2 rounded" onclick="openModal('projectModal')">+</button>
            </div>
        </div>

        <!-- Phase Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Phase</label>
            <div class="flex">
                <select id="phase" name="phase_id" value="<?= old('phase_id') ?>" class="w-full border rounded p-2">
                    <option value="">-- Select Phase --</option>
                </select>
                <button type="button" class="ml-2 bg-blue-500 text-white px-2 rounded" onclick="openModal('phaseModal')">+</button>
            </div>
        </div>

        <!-- Sector Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Sector</label>
            <div class="flex">
                <select id="sector" name="sector_id" value="<?= old('sector_id') ?>" class="w-full border rounded p-2">
                    <option value="">-- Select Sector --</option>
                </select>
                <button type="button" class="ml-2 bg-blue-500 text-white px-2 rounded" onclick="openModal('sectorModal')">+</button>
            </div>
        </div>

        <!-- Street Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Street</label>
            <div class="flex">
                <select id="street" name="street_id" value="<?= old('street_id') ?>" class="w-full border rounded p-2">
                    <option value="">-- Select Street --</option>
                </select>
                <button type="button" class="ml-2 bg-blue-500 text-white px-2 rounded" onclick="openModal('streetModal')">+</button>
            </div>
        </div>

        <!-- Block Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Plot No</label>
            <input type="text" name="plot_no" value="<?= old('plot_no') ?>" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Block</label>
            <select name="block_id" class="border rounded w-full p-2">
                <option value="">-- Select Block --</option>
                <?php foreach ($blocks as $block): ?>
                    <option value="<?= $block['id'] ?>" <?= $block['id'] == old('block_id') ? 'selected' : '' ?>><?= $block['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Size</label>
            <input type="text" name="size" value="<?= old('size') ?>" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Area (sqft)</label>
            <input type="number" name="area_sqft" value="<?= old('area_sqft') ?>" class="border rounded w-full p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Base Price</label>
            <input type="number" name="base_price" value="<?= old('base_price') ?>" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Type</label>
            <select name="type" class="border rounded w-full p-2">
                <option value="residential">Residential</option>
                <option value="commercial">Commercial</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Facing</label>
            <select name="facing" class="border rounded w-full p-2">
                <option value="north" <?= old('facing') == 'north' ? 'selected' : '' ?>>North</option>
                <option value="south" <?= old('facing') == 'south' ? 'selected' : '' ?>>South</option>
                <option value="east" <?= old('facing') == 'east' ? 'selected' : '' ?>>East</option>
                <option value="west" <?= old('facing') == 'west' ? 'selected' : '' ?>>West</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Status</label>
            <select name="status" class="border rounded w-full p-2">
                <option value="available" <?= old('status') == 'available' ? 'selected' : '' ?>>Available</option>
                <option value="booked" <?= old('status') == 'booked' ? 'selected' : '' ?>>Booked</option>
                <option value="alloted" <?= old('status') == 'alloted' ? 'selected' : '' ?>>Alloted</option>
                <option value="transferred" <?= old('status') == 'transferred' ? 'selected' : '' ?>>Transferred</option>
                <option value="cancelled" <?= old('status') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
        <a href="<?= site_url('/plots') ?>" class="bg-gray-300 text-gray-800 px-6 py-2 rounded">Cancel</a>

    </form>
</div>
<!-- Modals for Add New -->
<?= $this->include('plots/modals'); ?>
<!-- Repeat similar modals for Sector, Street -->

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function saveProject() {
        fetch("<?= site_url('projects/store') ?>", {
            method: "POST",
            body: new URLSearchParams({
                name: document.getElementById('projectName').value,
                location: document.getElementById('projectLocation').value
            })
        }).then(r => r.json()).then(data => {
            if (data.status === 'success') {
                closeModal('projectModal');
                // Reload dropdown
                document.getElementById('project').innerHTML += `<option value="${data.id}">${document.getElementById('projectName').value}</option>`;
            } else {
                alert('Error saving project');
            }
        });
    }

    function savePhase() {
        fetch("<?= site_url('phases/store') ?>", {
            method: "POST",
            body: new URLSearchParams({
                project_id: document.getElementById('project').value,
                name: document.getElementById('phaseName').value
            })
        }).then(r => r.json()).then(data => {
            if (data.status === 'success') {
                closeModal('phaseModal');
                // Reload dropdown
                document.getElementById('phase').innerHTML += `<option value="${data.id}">${document.getElementById('phaseName').value}</option>`;
            } else {
                alert('Error saving phase \n' + data);
            }
        });
    }

    function saveSector() {
        fetch("<?= site_url('sectors/store') ?>", {
            method: "POST",
            body: new URLSearchParams({
                phase_id: document.getElementById('phase').value,
                name: document.getElementById('sectorName').value
            })
        }).then(r => r.json()).then(data => {
            if (data.status === 'success') {
                closeModal('sectorModal');
                // Reload dropdown
                document.getElementById('sector').innerHTML += `<option value="${data.id}">${document.getElementById('sectorName').value}</option>`;
            } else {
                alert('Error saving sector');
            }
        });
    }

    function saveStreet() {
        fetch("<?= site_url('streets/store') ?>", {
            method: "POST",
            body: new URLSearchParams({
                sector_id: document.getElementById('sector').value,
                name: document.getElementById('streetName').value
            })
        }).then(r => r.json()).then(data => {
            if (data.status === 'success') {
                closeModal('streetModal');
                // Reload dropdown
                document.getElementById('street').innerHTML += `<option value="${data.id}">${document.getElementById('streetName').value}</option>`;
            } else {
                alert('Error saving street');
            }
        });
    }

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