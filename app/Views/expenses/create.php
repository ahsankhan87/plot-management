<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <h2 class="font-bold">Validation Errors</h2>
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add Expense</h1>
    <form method="post" action="<?= site_url('expenses/store') ?>" class="space-y-4">
        <div>
            <label class="block mb-1">Date</label>
            <input type="date" name="date" class="border rounded w-full px-3 py-2" value="<?= old('date', date('Y-m-d')) ?>">
        </div>
        <div>
            <label class="block mb-1">Amount</label>
            <input type="number" step="0.01" name="amount" class="border rounded w-full px-3 py-2" value="<?= old('amount') ?>">
        </div>
        <div>
            <label class="block mb-1">Category</label>
            <select name="category_id" class="border rounded w-full px-3 py-2">
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= esc($cat['id']) ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Description</label>
            <textarea name="description" class="border rounded w-full px-3 py-2"><?= old('description') ?></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Expense</button>
        <a href="<?= site_url('expenses') ?>" class="ml-2 bg-gray-600 text-white px-4 py-2 rounded">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>