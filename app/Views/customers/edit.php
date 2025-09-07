<?= $this->extend('layouts/header', ['title' => 'Edit Customer']) ?>
<?= $this->section('content') ?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Customer</h1>
    <form action="<?= site_url('customers/update/' . $customer['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Name</label>
                <input type="text" name="name" class="border rounded w-full px-3 py-2" value="<?= old('name', $customer['name']) ?>" required>
            </div>
            <div>
                <label class="block mb-1">Father/Husband</label>
                <input type="text" name="father_husband" class="border rounded w-full px-3 py-2" value="<?= old('father_husband', $customer['father_husband']) ?>">
            </div>
            <div>
                <label class="block mb-1">CNIC</label>
                <input type="text" name="cnic" class="border rounded w-full px-3 py-2" value="<?= old('cnic', $customer['cnic']) ?>" required>
            </div>
            <div>
                <label class="block mb-1">Phone</label>
                <input type="text" name="phone" class="border rounded w-full px-3 py-2" value="<?= old('phone', $customer['phone']) ?>">

            </div>
            <div>
                <label class="block mb-1">Email</label>
                <input type="email" name="email" class="border rounded w-full px-3 py-2" value="<?= old('email', $customer['email']) ?>">
            </div>
            <div>
                <label class="block mb-1">Postal Address</label>
                <input type="text" name="postal_address" class="border rounded w-full px-3 py-2" value="<?= old('postal_address', $customer['postal_address']) ?>">
            </div>
            <div>
                <label class="block mb-1">Residential Address</label>
                <input type="text" name="residential_address" class="border rounded w-full px-3 py-2" value="<?= old('residential_address', $customer['residential_address']) ?>">
            </div>
            <div>
                <label class="block mb-1">Occupation</label>
                <input type="text" name="occupation" class="border rounded w-full px-3 py-2" value="<?= old('occupation', $customer['occupation']) ?>">
            </div>
            <div>
                <label class="block mb-1">Mobile</label>
                <input type="text" name="mobile" class="border rounded w-full px-3 py-2" value="<?= old('mobile', $customer['mobile']) ?>">
            </div>
            <div>
                <label class="block mb-1">Date of Birth</label>
                <input type="date" name="dob" class="border rounded w-full px-3 py-2" value="<?= old('dob', $customer['dob']) ?>">
            </div>
        </div>
        <div class="mt-6">
            <label class="block mb-1">Customer Photo</label>
            <input type="file" name="photo_path" class="border rounded w-full px-3 py-2">
            <?php if (!empty($customer['photo_path'])): ?>
                <img src="<?= base_url('uploads/customers/' . $customer['photo_path']) ?>" alt="Customer Photo" class="mt-2 h-24 w-24 object-cover rounded">
            <?php endif; ?>
        </div>
        <h2 class="text-lg font-semibold mt-6 mb-2">Nominee Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Nominee Name</label>
                <input type="text" name="nominee_name" class="border rounded w-full px-3 py-2" value="<?= old('nominee_name', $customer['nominee_name']) ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee Relation</label>
                <input type="text" name="nominee_relation" class="border rounded w-full px-3 py-2" value="<?= old('nominee_relation', $customer['nominee_relation']) ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee CNIC</label>
                <input type="text" name="nominee_cnic" class="border rounded w-full px-3 py-2" value="<?= old('nominee_cnic', $customer['nominee_cnic']) ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee Address</label>
                <input type="text" name="nominee_address" class="border rounded w-full px-3 py-2" value="<?= old('nominee_address', $customer['nominee_address']) ?>">
            </div>
            <div>
                <label class="block mb-1">Nominee Phone</label>
                <input type="text" name="nominee_phone" class="border rounded w-full px-3 py-2" value="<?= old('nominee_phone', $customer['nominee_phone']) ?>">
            </div>
            <div>

            </div>
        </div>
        <div class="mt-6">
            <label class="block mb-1">Nominee Photo</label>
            <input type="file" name="nominee_photo" class="border rounded w-full px-3 py-2">
            <?php if (!empty($customer['nominee_photo'])): ?>
                <img src="<?= base_url('uploads/customers/' . $customer['nominee_photo']) ?>" alt="Nominee Photo" class="mt-2 h-24 w-24 object-cover rounded">
            <?php endif; ?>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update Customer</button>
            <a href="<?= site_url('customers') ?>" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>