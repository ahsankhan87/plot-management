<?= $this->include('layouts/header'); ?>

<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Assign Permissions to Role: <?= $role['name'] ?></h2>

    <form method="POST" action="<?= site_url('rolepermissions/save/' . $role['id']) ?>">
        <div class="grid grid-cols-2 gap-2">
            <?php foreach ($permissions as $perm): ?>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="permissions[]" value="<?= $perm['id'] ?>"
                        <?= in_array($perm['id'], $assigned_ids) ? 'checked' : '' ?>>
                    <span><?= $perm['name'] ?> (<?= $perm['description'] ?>)</span>
                </label>
            <?php endforeach; ?>
        </div>
        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg">Save</button>
    </form>
</div>

<?= $this->include('layouts/footer'); ?>