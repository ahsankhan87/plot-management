<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="flex items-center justify-center h-full min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
        <h1 class="text-3xl font-bold text-red-600 mb-4">403 - No Access</h1>
        <p class="text-gray-700 mb-6">You do not have permission to access this page or perform this action.</p>
        <a href="<?= site_url('/dashboard') ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Go to Dashboard</a>

        <a href="<?= previous_url() ?>" class="text-blue-500 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded">Go Back</a>
    </div>
</div>
<?= $this->endSection() ?>