<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<nav class="bg-gray-800 p-4 mb-6">
    <div class="flex space-x-4">
        <a href="<?= base_url('/role') ?>" class="text-gray-300 hover:text-white">Roles</a>
        <a href="<?= base_url('/permission') ?>" class="text-white font-semibold">Permissions</a>
    </div>
</nav>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Permissions</h1>
    <a href="<?= base_url('/permission/create') ?>" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Permission</a>
    <?php if (session('success')): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-2 rounded"> <?= session('success') ?> </div>
    <?php endif; ?>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border">Key</th>
                <th class="py-2 px-4 border">Description</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions as $permission): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= esc($permission['key']) ?></td>
                    <td class="py-2 px-4 border"><?= esc($permission['description']) ?></td>
                    <td class="py-2 px-4 border">
                        <a href="<?= base_url('/permission/edit/' . $permission['id']) ?>" class="text-blue-500">Edit</a> |
                        <a href="<?= base_url('/permission/delete/' . $permission['id']) ?>" class="text-red-500" onclick="return confirm('Delete this permission?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>