<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto max-w-lg p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Street</h2>
    <form method="post" action="<?= site_url('/streets/save') ?>" class="space-y-5">
        <div>
            <label class="block mb-1 text-gray-700">Sector</label>
            <select name="sector_id" required class="border rounded w-full px-3 py-2">
                <?php foreach ($sectors as $sector): ?>
                    <option value="<?= $sector['sector_id'] ?>"><?= $sector['project_name'] ?> → <?= $sector['phase_name'] ?> → <?= $sector['sector_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Street No</label>
            <input type="text" name="street_no" required class="border rounded w-full px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Description</label>
            <textarea name="description" class="border rounded w-full px-3 py-2"></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">Save</button>
            <a href="<?= site_url('/streets') ?>" class="ml-3 px-6 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>