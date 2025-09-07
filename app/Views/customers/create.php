<?= $this->extend('layouts/header', ['title' => 'Add Customer']) ?>
<?= $this->section('content') ?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add Customer</h1>
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
    <form action="<?= site_url('customers/store') ?>" method="post" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Name</label>
                <input type="text" name="name" class="border rounded w-full px-3 py-2" value="<?= old('name') ?>" required>
            </div>
            <div>
                <label class="block mb-1">Father/Husband</label>
                <input type="text" name="father_husband" class="border rounded w-full px-3 py-2" value="<?= old('father_husband') ?>">
            </div>
            <div>
                <label class="block mb-1">CNIC</label>
                <input type="text" name="cnic" class="border rounded w-full px-3 py-2" value="<?= old('cnic') ?>" required>
            </div>
            <div>
                <label class="block mb-1">Phone</label>
                <input type="text" name="phone" class="border rounded w-full px-3 py-2" value="<?= old('phone') ?>">
            </div>
            <div>
                <label class="block mb-1">Email</label>
                <input type="email" name="email" class="border rounded w-full px-3 py-2" value="<?= old('email') ?>">
            </div>
            <div>
                <label class="block mb-1">Postal Address</label>
                <input type="text" name="postal_address" class="border rounded w-full px-3 py-2" value="<?= old('postal_address') ?>">
            </div>
            <div>
                <label class="block mb-1">Residential Address</label>
                <input type="text" name="residential_address" class="border rounded w-full px-3 py-2" value="<?= old('residential_address') ?>">
            </div>
            <div>
                <label class="block mb-1">Occupation</label>
                <input type="text" name="occupation" class="border rounded w-full px-3 py-2" value="<?= old('occupation') ?>">
            </div>
            <div>
                <label class="block mb-1">Mobile</label>
                <input type="text" name="mobile" class="border rounded w-full px-3 py-2" value="<?= old('mobile') ?>">
            </div>
            <div>
                <label class="block mb-1">Date of Birth</label>
                <input type="date" name="dob" class="border rounded w-full px-3 py-2" value="<?= old('dob') ?>">
            </div>
        </div>
        <div class="mt-6">
            <label class="block mb-1">Customer Photo</label>
            <input type="file" name="photo_path" class="border rounded w-full px-3 py-2">
        </div>
        <h2 class="text-lg font-semibold mt-6 mb-2">Nominee Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Nominee Name</label>
                <input type="text" name="nominee_name" class="border rounded w-full px-3 py-2" value="<?= old('nominee_name') ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee Relation</label>
                <input type="text" name="nominee_relation" class="border rounded w-full px-3 py-2" value="<?= old('nominee_relation') ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee CNIC</label>
                <input type="text" name="nominee_cnic" class="border rounded w-full px-3 py-2" value="<?= old('nominee_cnic') ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee Address</label>
                <input type="text" name="nominee_address" class="border rounded w-full px-3 py-2" value="<?= old('nominee_address') ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee Phone</label>
                <input type="text" name="nominee_phone" class="border rounded w-full px-3 py-2" value="<?= old('nominee_phone') ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee Photo</label>
                <input type="file" name="nominee_photo" class="border rounded w-full px-3 py-2">
            </div>

        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Customer</button>
            <a href="<?= site_url('customers') ?>" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>