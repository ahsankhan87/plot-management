<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Projects</h1>
    <a href="<?= site_url('/projects/create') ?>" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Project</a>
    <?php if (session('success')): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-2 rounded"> <?= session('success') ?> </div>
    <?php endif; ?>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border">Name</th>
                <th class="py-2 px-4 border">Location</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= esc($project['name']) ?></td>
                    <td class="py-2 px-4 border"><?= esc($project['location']) ?></td>
                    <td class="py-2 px-4 border">
                        <a href="<?= site_url('/projects/edit/' . $project['id']) ?>" class="text-blue-500">Edit</a> |
                        <a href="<?= site_url('/projects/delete/' . $project['id']) ?>" class="text-red-500" onclick="return confirm('Delete this project?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>