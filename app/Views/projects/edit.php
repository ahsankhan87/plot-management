<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Project</h1>
    <form method="post" action="<?= site_url('/projects/update/' . $project['id']) ?>" class="space-y-4 bg-white p-6 rounded shadow">
        <div>
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="border rounded w-full px-3 py-2" value="<?= old('name', $project['name']) ?>">
        </div>
        <div>
            <label class="block mb-1">Location</label>
            <input type="text" name="location" class="border rounded w-full px-3 py-2" value="<?= old('location', $project['location']) ?>">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Project</button>
        <a href="<?= site_url('/projects') ?>" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>