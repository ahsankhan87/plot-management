<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<nav class="bg-gray-800 p-4 mb-6">
    <div class="flex space-x-4">
        <a href="<?= base_url('/role') ?>" class="text-white font-semibold">Roles</a>
        <a href="<?= base_url('/permission') ?>" class="text-gray-300 hover:text-white">Permissions</a>
    </div>
</nav>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add Role</h1>
    <form method="post" class="space-y-4">
        <div>
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="border rounded w-full px-3 py-2" value="<?= old('name') ?>" required>
            <?php if (isset($errors['name'])): ?><div class="text-red-500 text-sm"><?= $errors['name'] ?></div><?php endif; ?>
        </div>
        <div>
            <label class="block mb-1">Description</label>
            <input type="text" name="description" class="border rounded w-full px-3 py-2" value="<?= old('description') ?>" required>
            <?php if (isset($errors['description'])): ?><div class="text-red-500 text-sm"><?= $errors['description'] ?></div><?php endif; ?>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
        <a href="<?= site_url('/role') ?>" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
<?php $errors = session('errors') ?? [] ?>
<?= $this->endSection() ?>