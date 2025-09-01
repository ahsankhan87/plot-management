<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Role</h2>
    <?php if (isset($validation)): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>
    <form action="<?= site_url('roles/store') ?>" method="post" class="space-y-5">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="name" name="name" value="<?= old('name') ?>" required>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" id="description" name="description" rows="3"><?= old('description') ?></textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Role</button>
            <a href="<?= site_url('roles') ?>" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>