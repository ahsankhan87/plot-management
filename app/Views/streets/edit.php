<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Street</h1>
    <form method="post" action="<?= site_url('/streets/update/' . $street['id']) ?>" class="space-y-4 bg-white p-6 rounded shadow">
        <div>
            <label class="block mb-1">Sector</label>
            <select name="sector_id" required class="border rounded w-full px-3 py-2">
                <?php foreach ($sectors as $sector): ?>
                    <option value="<?= $sector['sector_id'] ?>" <?= $sector['sector_id'] == $street['sector_id'] ? 'selected' : '' ?>><?= $sector['project_name'] ?> → <?= $sector['phase_name'] ?> → <?= $sector['sector_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Street No</label>
            <input type="text" name="street_no" class="border rounded w-full px-3 py-2" value="<?= old('street_no', $street['street_no']) ?>">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Street</button>
        <a href="<?= site_url('/streets') ?>" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>