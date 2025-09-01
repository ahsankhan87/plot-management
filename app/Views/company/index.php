<!-- app/Views/company/index.php -->
<?= $this->extend('layouts/header') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Company Profile</h1>
    </div>

    <?php if (session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= session('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('company/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h2 class="text-lg font-semibold mb-4 border-b pb-2">Basic Information</h2>
                </div>

                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Company Name *</label>
                    <input type="text" name="name" id="name"
                        value="<?= old('name', $company['name'] ?? '') ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number *</label>
                    <input type="text" name="contact_number" id="contact_number"
                        value="<?= old('contact_number', $company['contact_number'] ?? '') ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" id="email"
                        value="<?= old('email', $company['email'] ?? '') ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number</label>
                    <input type="text" name="registration_number" id="registration_number"
                        value="<?= old('registration_number', $company['registration_number'] ?? '') ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="ntn" class="block text-sm font-medium text-gray-700">NTN Number</label>
                    <input type="text" name="ntn" id="ntn"
                        value="<?= old('ntn', $company['ntn'] ?? '') ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
                    <textarea name="address" id="address" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required><?= old('address', $company['address'] ?? '') ?></textarea>
                </div>

                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="url" name="website" id="website"
                        value="<?= old('website', $company['website'] ?? '') ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="tagline" class="block text-sm font-medium text-gray-700">Tagline</label>
                    <input type="text" name="tagline" id="tagline"
                        value="<?= old('tagline', $company['tagline'] ?? '') ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Logo Upload -->
                <div class="md:col-span-2">
                    <h2 class="text-lg font-semibold mb-4 border-b pb-2">Company Logo</h2>

                    <?php if (isset($company['logo']) && $company['logo']): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Current Logo</label>
                            <img src="<?= base_url('uploads/company/' . $company['logo']) ?>"
                                alt="Current logo"
                                class="h-20 w-20 object-contain border rounded mt-2">
                        </div>
                    <?php endif; ?>

                    <label for="logo" class="block text-sm font-medium text-gray-700">Upload Logo</label>
                    <input type="file" name="logo" id="logo"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                </div>

                <!-- Bank Details -->
                <div class="md:col-span-2">
                    <h2 class="text-lg font-semibold mb-4 border-b pb-2">Bank Account Details</h2>
                    <textarea name="bank_account_details" id="bank_account_details" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"><?= old('bank_account_details', $company['bank_account_details'] ?? '') ?></textarea>
                    <p class="mt-1 text-sm text-gray-500">Bank name, account number, IBAN, etc.</p>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Update Company Profile
                </button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>