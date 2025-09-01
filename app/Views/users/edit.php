<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Edit User</h1>

<form method="post" action="<?= site_url('/users/update/' . $user['id']) ?>" class="space-y-4">
    <input type="text" name="name" value="<?= $user['name'] ?>" class="w-full border px-4 py-2" required>
    <input type="text" name="username" value="<?= $user['username'] ?>" class="w-full border px-4 py-2" required>
    <input type="email" name="email" value="<?= $user['email'] ?>" class="w-full border px-4 py-2" required>
    <input type="password" name="password" placeholder="Leave blank to keep old" class="w-full border px-4 py-2">

    <select name="role_id" class="w-full border px-4 py-2">
        <?php foreach ($roles as $r): ?>
            <option value="<?= $r['id'] ?>" <?= $user['role_id'] == $r['id'] ? 'selected' : '' ?>><?= $r['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="status" class="w-full border px-4 py-2">
        <option value="1" <?= $user['status'] == 1 ? 'selected' : '' ?>>Active</option>
        <option value="0" <?= $user['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
    </select>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
</form>
<?= $this->endSection() ?>