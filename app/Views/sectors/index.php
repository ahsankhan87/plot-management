<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Sectors</h1>
    <a href="<?= site_url('/sectors/create') ?>" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Sector</a>
    <?php if (session('success')): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-2 rounded"> <?= session('success') ?> </div>
    <?php endif; ?>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th>Phases</th>
                <th class="py-2 px-4 border">Name</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sectors as $sector): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= esc($sector['phase_name']) ?></td>

                    <td class="py-2 px-4 border"><?= esc($sector['name']) ?></td>
                    <td class="py-2 px-4 border">
                        <a href="<?= site_url('/sectors/edit/' . $sector['id']) ?>" class="text-blue-500">Edit</a> |
                        <a href="<?= site_url('/sectors/delete/' . $sector['id']) ?>" class="text-red-500" onclick="return confirm('Delete this sector?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>