<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Edit Plot</h2>

    <form method="post" action=<?= site_url("/plots/update/{$plot['id']}") ?> class="space-y-3">
        <div>
            <label>Plot No</label>
            <input type="text" name="plot_no" value="<?= esc($plot['plot_no']) ?>" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label>Block</label>
            <input type="text" name="block" value="<?= esc($plot['block_id']) ?>" class="border rounded w-full p-2" required>
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

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="<?= site_url('/plots') ?>" class="bg-gray-300 text-gray-800 px-6 py-2 rounded">Cancel</a>

    </form>
</div>
<?= $this->endSection() ?>