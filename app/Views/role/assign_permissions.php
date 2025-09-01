<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<nav class="bg-gray-800 p-4 mb-6">
    <div class="flex space-x-4">
        <a href="<?= base_url('/role') ?>" class="text-white font-semibold">Roles</a>
        <a href="<?= base_url('/permission') ?>" class="text-gray-300 hover:text-white">Permissions</a>
    </div>
</nav>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Assign Permissions to <?= esc($role['name']) ?></h1>
    <form method="post" action="<?= base_url('/role/assignPermissions/' . $role['id']) ?>" class="space-y-4">
        <div>
            <label class="block mb-2 font-semibold">Permissions</label>
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="selectAll" class="mr-2">
                    <span class="font-semibold">Select All</span>
                </label>
            </div>
            <?php
            // Group permissions by module
            $modules = [];
            foreach ($permissions as $perm) {
                $parts = explode('_', $perm['key'], 2);
                $module = ucfirst($parts[0]);
                $modules[$module][] = $perm;
            }
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($modules as $module => $perms): ?>
                    <div class="bg-gray-50 rounded p-4 mb-2">
                        <h2 class="font-bold text-primary mb-2 text-lg"><?= esc($module) ?></h2>
                        <div class="space-y-2">
                            <?php foreach ($perms as $perm): ?>
                                <label class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="<?= esc($perm['key']) ?>" class="mr-2 permission-checkbox" <?= in_array($perm['key'], $assigned) ? 'checked' : '' ?>>
                                    <?= esc($perm['description'] ?? $perm['key']) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Assign</button>
        <a href="<?= site_url('/role') ?>" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
<script>
    // Select All functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });
    });
</script>
<?= $this->endSection() ?>