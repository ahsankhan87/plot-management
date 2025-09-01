<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Users</h1>
    <a href="<?= site_url("/users/create") ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Add User</a>
</div>
<?php if (session('success')): ?>
    <div class="bg-green-100 text-green-700 p-2 mb-2 rounded"> <?= session('success') ?> </div>
<?php endif; ?>
<?php if (session('error')): ?>
    <div class="bg-red-100 text-red-700 p-2 mb-2 rounded"> <?= session('error') ?> </div>
<?php endif; ?>
<table class="table-auto w-full border" id="dataTable_1">
    <thead>
        <tr class="bg-gray-200">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Username</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Role</th>
            <th class="px-4 py-2">Status</th>
            <th class="py-2 px-4 border">Change Role</th>

            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td class="border px-4 py-2"><?= $u['id'] ?></td>
                <td class="border px-4 py-2"><?= $u['name'] ?></td>
                <td class="border px-4 py-2"><?= $u['username'] ?></td>
                <td class="border px-4 py-2"><?= $u['email'] ?></td>
                <td class="border px-4 py-2"><?= $u['role'] ?></td>
                <td class="border px-4 py-2"><?= $u['status'] == 1 ? 'Active' : 'Inactive' ?></td>
                <td class="py-2 px-4 border">
                    <form method="post" action="<?= base_url('/users/update-role') ?>" class="flex items-center space-x-2">
                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                        <select name="role_id" class="border rounded px-2 py-1">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>" <?= $role['id'] == $u['role_id'] ? 'selected' : '' ?>><?= esc($role['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Update</button>
                    </form>
                </td>
                <td class="border px-4 py-2">

                    <a href="<?= site_url("/users/edit/{$u['id']}") ?>" class="text-blue-500">Edit</a> |
                    <a href="<?= site_url("/users/delete/{$u['id']}") ?>" onclick="return confirm('Delete?')" class="text-red-500">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>