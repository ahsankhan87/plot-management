<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<nav class="bg-gray-800 p-4 mb-6">
    <div class="flex space-x-4">
        <a href="<?= base_url('/role') ?>" class="text-gray-300 hover:text-white">Roles</a>
        <a href="<?= base_url('/permission') ?>" class="text-white font-semibold">Permissions</a>
    </div>
</nav>
<?php $errors = session('errors') ?? [] ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add Permission</h1>
    <form method="post" action="<?= base_url('/permission/create') ?>" class="space-y-4">
        <div>
            <label class="block mb-1">Key</label>
            <input type="text" name="key" class="border rounded w-full px-3 py-2" value="<?= old('key') ?>">
            <?php if (isset($errors['key'])): ?><div class="text-red-500 text-sm"><?= $errors['key'] ?></div><?php endif; ?>
            <small class="text-gray-500">Use only lowercase letters, numbers, and underscores (e.g., view_customer).</small>
        </div>
        <div>
            <label class="block mb-1">Description</label>
            <input type="text" name="description" class="border rounded w-full px-3 py-2" value="<?= old('description') ?>">
            <?php if (isset($errors['description'])): ?><div class="text-red-500 text-sm"><?= $errors['description'] ?></div><?php endif; ?>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
        <a href="<?= base_url('/permission') ?>" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>