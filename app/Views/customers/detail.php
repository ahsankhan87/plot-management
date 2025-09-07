<?= $this->extend('layouts/header', ['title' => 'Customer Detail']) ?>
<?= $this->section('content') ?>
<div class="container mx-auto p-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row gap-8">
            <div class="flex flex-col items-center justify-center md:w-1/3">
                <div class="h-32 w-32 rounded-full overflow-hidden border-4 border-primary shadow mb-4">
                    <?php if (!empty($customer['photo_path'])): ?>
                        <img src="<?= base_url('uploads/customers/' . $customer['photo_path']) ?>" alt="Customer Photo" class="object-cover h-full w-full">
                    <?php else: ?>
                        <div class="flex items-center justify-center h-full w-full bg-gray-100 text-gray-400">No Photo</div>
                    <?php endif; ?>
                </div>
                <h2 class="text-xl font-bold text-primary mb-1"><?= esc($customer['name']) ?></h2>
                <p class="text-gray-600 text-sm mb-2">CNIC: <?= esc($customer['cnic']) ?></p>
                <p class="text-gray-500 text-xs">Phone: <?= esc($customer['phone']) ?></p>
                <p class="text-gray-500 text-xs">Email: <?= esc($customer['email']) ?></p>
            </div>
            <div class="md:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Personal Info</h3>
                    <div class="mb-2"><span class="font-medium text-gray-600">Father/Husband:</span> <?= esc($customer['father_husband']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Postal Address:</span> <?= esc($customer['postal_address']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Residential Address:</span> <?= esc($customer['residential_address']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Occupation:</span> <?= esc($customer['occupation']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Mobile:</span> <?= esc($customer['mobile']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Date of Birth:</span> <?= esc(date('d/m/Y', strtotime($customer['dob']))) ?></div>

                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Nominee Info</h3>
                    <div class="mb-2"><span class="font-medium text-gray-600">Name:</span> <?= esc($customer['nominee_name']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Relation:</span> <?= esc($customer['nominee_relation']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">CNIC:</span> <?= esc($customer['nominee_cnic']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Address:</span> <?= esc($customer['nominee_address']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Phone:</span> <?= esc($customer['nominee_phone']) ?></div>
                    <div class="mb-2"><span class="font-medium text-gray-600">Nominee Photo:</span>
                        <?php if (!empty($customer['nominee_photo'])): ?>
                            <img src="<?= base_url('uploads/customers/' . $customer['nominee_photo']) ?>" alt="Nominee Photo" class="inline-block h-16 w-16 object-cover rounded ml-2">
                        <?php else: ?>
                            <span class="text-gray-400">No Photo</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-8">
            <a href="<?= site_url('/customers') ?>" class="bg-blue-500 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition">Back to Customers</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>