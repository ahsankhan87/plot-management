<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<nav class="bg-gray-800 p-4 mb-6">
    <div class="flex space-x-4">
        <a href="<?php echo base_url('/role'); ?>" class="text-gray-300 hover:text-white">Roles</a>
        <a href="<?php echo base_url('/permission'); ?>" class="text-gray-300 hover:text-white">Permissions</a>
        <a href="<?php echo base_url('/userrole'); ?>" class="text-white font-semibold">User Roles</a>
    </div>
</nav>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Assign Roles to Users</h1>
    <?php if (session('success')): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-2 rounded"> <?= session('success') ?> </div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="bg-red-100 text-red-700 p-2 mb-2 rounded"> <?= session('error') ?> </div>
    <?php endif; ?>
    <table class="min-w-full bg-white border mb-6">
        <thead>
            <tr>
                <th class="py-2 px-4 border">Username</th>
                <th class="py-2 px-4 border">Email</th>
                <th class="py-2 px-4 border">Current Role</th>
                <th class="py-2 px-4 border">Change Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= esc($user['username']) ?></td>
                    <td class="py-2 px-4 border"><?= esc($user['email']) ?></td>
                    <td class="py-2 px-4 border">
                        <?php foreach ($roles as $role): ?>
                            <?php if ($role['id'] == $user['role_id']): ?>
                                <?= esc($role['name']) ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <td class="py-2 px-4 border">
                        <form method="post" action="<?= base_url('/userrole/updateRole') ?>" class="flex items-center space-x-2">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <select name="role_id" class="border rounded px-2 py-1">
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>" <?= $role['id'] == $user['role_id'] ? 'selected' : '' ?>><?= esc($role['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>