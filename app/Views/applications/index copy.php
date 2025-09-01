<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="p-6">
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

    <h2 class="text-2xl font-bold mb-4">Applications</h2>
    <a href="<?= site_url('/applications/create') ?>" class="bg-blue-600 text-white px-4 py-2 rounded">+ New Application</a>
    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100">
                <th>#</th>
                <th>App No</th>
                <th>Customer</th>
                <th>Project</th>
                <th>Plot</th>
                <th>Status</th>
                <th>Booking Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $app): ?>
                <tr class="border-b">
                    <td><?= $app['id'] ?></td>
                    <td><?= $app['app_no'] ?></td>
                    <td><?= $app['customer_name'] ?></td>
                    <td><?= $app['project_name'] ?></td>
                    <td><?= $app['plot_no'] ?></td>
                    <td><?= $app['status'] ?></td>
                    <td><?= $app['booking_amount'] ?></td>
                    <td><?= $app['app_date'] ?></td>
                    <td>
                        <a href="<?= site_url('/installments/generate/' . $app['id']) ?>" class="text-yellow-600">Generate</a>
                        <a href="<?= site_url('/payments/record/' . $app['id']) ?>" class="text-purple-600">Payment</a>
                        <a href="<?= site_url('/applications/detail/' . $app['id']) ?>" class="text-green-600">Detail</a>
                        <a href="<?= site_url('/applications/print-letter/' . $app['id']) ?>" class="text-blue-600">Print Letter</a>
                        <a href="<?= site_url('/applications/edit/' . $app['id']) ?>" class="text-blue-600">Edit</a>
                        <form action="<?= site_url('/applications/delete/' . $app['id']) ?>" method="post" class="inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>