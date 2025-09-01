<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Plots List</h2>
    <a href=<?= site_url("/plots/create") ?> class="bg-blue-600 text-white px-4 py-2 rounded">+ Add New Plot</a>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-200 text-green-800 p-2 rounded mt-3">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <table class="table-auto w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-2 py-1">Plot No</th>
                <th class="border px-2 py-1">Block</th>
                <th class="border px-2 py-1">Size</th>
                <th class="border px-2 py-1">Area (sqft)</th>
                <th class="border px-2 py-1">Base Price</th>
                <th class="border px-2 py-1">Status</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plots as $p): ?>
                <tr>
                    <td class="border px-2 py-1"><?= esc($p['plot_no']) ?></td>
                    <td class="border px-2 py-1"><?= esc($p['block_id']) ?></td>
                    <td class="border px-2 py-1"><?= esc($p['size']) ?></td>
                    <td class="border px-2 py-1"><?= esc(number_format($p['area_sqft'])) ?></td>
                    <td class="border px-2 py-1 text-right"><?= esc(number_format($p['base_price'], 2)) ?></td>
                    <td class="border px-2 py-1 text-center">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?= $p['status'] == 'Available' ? 'bg-green-100 text-green-800' : '' ?>
                                <?= $p['status'] == 'Booked' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                                <?= $p['status'] == 'Allotted' ? 'bg-blue-100 text-blue-800' : '' ?>
                                <?= $p['status'] == 'Cancelled' ? 'bg-red-100 text-red-800' : '' ?>">
                            <?= ucfirst($p['status']) ?>
                        </span>
                    </td>
                    <td class="border px-2 py-1">
                        <a href=<?= site_url("/plots/edit/{$p['id']}") ?> class="text-blue-600">Edit</a> |
                        <a href=<?= site_url("/plots/delete/{$p['id']}") ?> onclick="return confirm('Delete this plot?')" class="text-red-600">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    // AJAX status update
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const plotId = this.dataset.id;
            const status = this.value;

            fetch('<?= base_url('plots/updateStatus') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        id: plotId,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        });
    });
</script>

<?= $this->endSection() ?>