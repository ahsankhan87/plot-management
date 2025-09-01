<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>


<div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Permissions</h2>
        <a href="<?= site_url('permissions/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">Add Permission</a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($permissions as $permission): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-700"><?= $permission['id'] ?></td>
                        <td class="px-4 py-2 text-gray-700"><?= $permission['name'] ?></td>
                        <td class="px-4 py-2 text-gray-700"><?= $permission['description'] ?></td>
                        <td class="px-4 py-2">
                            <a href="<?= site_url('permissions/edit/' . $permission['id']) ?>" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <a href="<?= site_url('permissions/delete/' . $permission['id']) ?>" class="text-red-600 hover:underline" onclick="return confirm('Delete this permission?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>