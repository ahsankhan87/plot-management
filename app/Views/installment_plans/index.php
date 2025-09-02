<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Installment Plans</h2>
    <a href="<?= site_url('/installmentplans/create') ?>" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Add Plan</a>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border">#</th>
                <th class="py-2 px-4 border">Name</th>
                <th class="py-2 px-4 border">Tenure (Months)</th>
                <th class="py-2 px-4 border">Down Payment (%)</th>
                <th class="py-2 px-4 border">Markup (%)</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plans as $plan): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= esc($plan['id']) ?></td>
                    <td class="py-2 px-4 border"><?= esc($plan['name']) ?></td>
                    <td class="py-2 px-4 border"><?= esc($plan['tenure_months']) ?></td>
                    <td class="py-2 px-4 border"><?= esc($plan['down_payment_pct']) ?></td>
                    <td class="py-2 px-4 border"><?= esc($plan['markup_pct']) ?></td>
                    <td class="py-2 px-4 border">
                        <a href="<?= site_url('/installmentplans/edit/' . $plan['id']) ?>" class="text-blue-600">Edit</a> |
                        <a href="<?= site_url('/installmentplans/delete/' . $plan['id']) ?>" class="text-red-600" onclick="return confirm('Delete this plan?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>