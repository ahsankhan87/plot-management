<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Sector</h1>
    <form method="post" action="<?= site_url('/sectors/update/' . $sector['id']) ?>" class="space-y-4 bg-white p-6 rounded shadow">
        <div>
            <label class="block mb-1">Phase</label>
            <select name="phase_id" required class="border rounded w-full px-3 py-2">
                <?php foreach ($phases as $phase): ?>
                    <option value="<?= $phase['phase_id'] ?>" <?= $phase['phase_id'] == $sector['phase_id'] ? 'selected' : '' ?>><?= esc($phase['project_name']) ?> → <?= esc($phase['phase_name']) ?> → <?= esc($phase['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="border rounded w-full px-3 py-2" value="<?= old('name', $sector['name']) ?>">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Sector</button>
        <a href="<?= site_url('/sectors') ?>" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>