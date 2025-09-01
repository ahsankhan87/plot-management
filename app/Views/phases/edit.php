<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Phase</h1>
    <form method="post" action="<?= site_url('/phases/update/' . $phase['id']) ?>" class="space-y-4 bg-white p-6 rounded shadow">
        <div>
            <label class="block mb-1">Project</label>
            <select name="project_id" class="border rounded w-full px-3 py-2">
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id'] ?>" <?= $project['id'] == $phase['project_id'] ? 'selected' : '' ?>><?= esc($project['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="border rounded w-full px-3 py-2" value="<?= old('name', $phase['name']) ?>">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Phase</button>
        <a href="<?= site_url('/phases') ?>" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>