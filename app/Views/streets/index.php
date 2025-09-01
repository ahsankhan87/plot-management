<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Streets</h1>
    <a href="<?= site_url('/streets/create') ?>" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Street</a>
    <?php if (session('success')): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-2 rounded"> <?= session('success') ?> </div>
    <?php endif; ?>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border">Sector</th>
                <th class="py-2 px-4 border">Street No</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($streets as $street): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= $street['project_name'] ?> → <?= $street['phase_name'] ?> → <?= $street['sector_name'] ?></td>
                    <td class="py-2 px-4 border"><?= esc($street['street_no']) ?></td>
                    <td class="py-2 px-4 border">
                        <a href="<?= site_url('/streets/edit/' . $street['id']) ?>" class="text-blue-500">Edit</a> |
                        <a href="<?= site_url('/streets/delete/' . $street['id']) ?>" class="text-red-500" onclick="return confirm('Delete this street?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>