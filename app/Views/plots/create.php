<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Add New Plot</h2>
    <?php if (isset($validation)): ?>
        <div class="bg-red-200 text-red-800 p-2 rounded mt-3">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>
    <!-- <ul class="list-disc pl-5">
        <?php if (isset($validation)): ?>
            <?php foreach ($validation->getErrors() as $error): ?>
                <li class="text-red-600"><?= esc($error) ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul> -->

    <form method="post" action=<?= site_url("/plots/store") ?> class="space-y-3">
        <!-- Project Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Project</label>
            <div class="flex">
                <select id="project" name="project_id" class="w-full border rounded p-2">
                    <option value="">-- Select Project --</option>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?= $project['id'] ?>"><?= $project['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="ml-2 bg-blue-500 text-white px-2 rounded" onclick="openModal('projectModal')">+</button>
            </div>
        </div>

        <!-- Phase Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Phase</label>
            <div class="flex">
                <select id="phase" name="phase_id" class="w-full border rounded p-2">
                    <option value="">-- Select Phase --</option>
                </select>
                <button type="button" class="ml-2 bg-blue-500 text-white px-2 rounded" onclick="openModal('phaseModal')">+</button>
            </div>
        </div>

        <!-- Sector Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Sector</label>
            <div class="flex">
                <select id="sector" name="sector_id" class="w-full border rounded p-2">
                    <option value="">-- Select Sector --</option>
                </select>
                <button type="button" class="ml-2 bg-blue-500 text-white px-2 rounded" onclick="openModal('sectorModal')">+</button>
            </div>
        </div>

        <!-- Street Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Street</label>
            <div class="flex">
                <select id="street" name="street_id" class="w-full border rounded p-2">
                    <option value="">-- Select Street --</option>
                </select>
                <button type="button" class="ml-2 bg-blue-500 text-white px-2 rounded" onclick="openModal('streetModal')">+</button>
            </div>
        </div>

        <!-- Block Dropdown -->
        <div class="mb-4">
            <label class="block text-gray-700">Plot No</label>
            <input type="text" name="plot_no" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Block</label>
            <select name="block_id" class="border rounded w-full p-2" required>
                <?php foreach ($blocks as $block): ?>
                    <option value="<?= $block['id'] ?>"><?= $block['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Size</label>
            <input type="text" name="size" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Area (sqft)</label>
            <input type="number" name="area_sqft" class="border rounded w-full p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Base Price</label>
            <input type="number" name="base_price" class="border rounded w-full p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Type</label>
            <select name="type" class="border rounded w-full p-2">
                <option value="residential">Residential</option>
                <option value="commercial">Commercial</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Status</label>
            <select name="status" class="border rounded w-full p-2">
                <option value="available">Available</option>
                <option value="booked">Booked</option>
                <option value="alloted">Alloted</option>
                <option value="transferred">Transferred</option>
                <option value="cancelled">Cancelled</option>
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
                data.forEach(row => options += `<option value="${row.id}">${row.plot_no} (${row.size} Marla)</option>`);
                $('#plot').html(options);
            });
        });

    });
</script>
<?= $this->endSection() ?>