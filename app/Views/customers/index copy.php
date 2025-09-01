<?= $this->extend('layouts/header', ['title' => 'Customers']) ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Customers</h2>
</div>
<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>


<a href="<?= site_url('/customers/create') ?>" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Customer</a>

<table class="w-full mt-4 border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2">#</th>
            <th class="p-2">Name</th>
            <th class="p-2">Father/Husband Name</th>
            <th class="p-2">CNIC</th>
            <th class="p-2">Phone</th>
            <th class="p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $c): ?>
            <tr>
                <td class="border p-2"><?= $c['id'] ?></td>
                <td class="border p-2"><?= $c['name'] ?></td>
                <td class="border p-2"><?= $c['father_husband'] ?></td>
                <td class="border p-2"><?= $c['cnic'] ?></td>
                <td class="border p-2"><?= $c['phone'] ?></td>
                <td class="border p-2">
                    <a href=<?= site_url("/customers/edit/{$c['id']}") ?> class="text-blue-600">Edit</a> |
                    <a href=<?= site_url("/customers/delete/{$c['id']}") ?> onclick="return confirm('Delete?')" class="text-red-600">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>