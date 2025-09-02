<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto max-w-2xl p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Plot Details</h2>
    <div class="space-y-4">
        <div>
            <span class="font-semibold text-gray-700">Plot No:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['plot_no'] ?? '') ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Project:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['project_name'] ?? '') ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Phase:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['phase_name'] ?? '') ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Sector:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['sector_name'] ?? '') ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Street:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['street_no'] ?? '') ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Size:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['size'] ?? '') ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Type:</span>
            <span class="ml-2 text-gray-900"><?= esc(ucfirst($plot['type'] ?? '')) ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Price:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['base_price'] ?? '') ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Facing:</span>
            <span class="ml-2 text-gray-900"><?= esc(ucfirst($plot['facing'] ?? '')) ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Status:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['status'] ?? '') ?></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Description:</span>
            <span class="ml-2 text-gray-900"><?= esc($plot['description'] ?? '') ?></span>
        </div>
    </div>
    <div class="mt-8 flex justify-end">
        <a href="<?= site_url('/plots') ?>" class="px-6 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Back to List</a>
    </div>
</div>
<?= $this->endSection() ?>