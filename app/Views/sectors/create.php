<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto max-w-lg p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Sector</h2>
    <form method="post" action="<?= site_url('/sectors/save') ?>" class="space-y-5">
        <div>
            <label class="block mb-1 text-gray-700">Select Phase</label>
            <select name="phase_id" required class="border rounded w-full px-3 py-2">
                <?php foreach ($phases as $phase): ?>
                    <option value="<?= $phase['phase_id'] ?>"><?= esc($phase['project_name']) ?> → <?= esc($phase['phase_name']) ?> → <?= esc($phase['name']) ?> </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-1 text-gray-700">Sector Name</label>
            <input type="text" name="name" required class="border rounded w-full px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Description</label>
            <textarea name="description" class="border rounded w-full px-3 py-2"></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">Save</button>
            <a href="<?= site_url('/sectors') ?>" class="ml-3 px-6 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>