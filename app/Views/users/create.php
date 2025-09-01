<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Add User</h1>

<form method="post" action="<?= site_url('/users/store') ?>" class="space-y-4">
    <input type="text" name="name" placeholder="Name" class="w-full border px-4 py-2" required>
    <input type="text" name="username" placeholder="Username" class="w-full border px-4 py-2" required>
    <input type="email" name="email" placeholder="Email" class="w-full border px-4 py-2" required>
    <input type="password" name="password" placeholder="Password" class="w-full border px-4 py-2" required>

    <select name="role_id" class="w-full border px-4 py-2">
        <?php foreach ($roles as $r): ?>
            <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="status" class="w-full border px-4 py-2">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
</form>
<?= $this->endSection() ?>