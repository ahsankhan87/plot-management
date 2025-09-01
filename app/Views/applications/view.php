<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Application Detail</h2>

    <!-- Customer + Plot Info -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <h3 class="font-semibold">Customer Info</h3>
            <p><b>Name:</b> <?= $customer['name'] ?></p>
            <p><b>CNIC:</b> <?= $customer['cnic'] ?></p>
            <p><b>Phone:</b> <?= $customer['phone'] ?></p>
        </div>
        <div>
            <h3 class="font-semibold">Plot Info</h3>
            <p><b>Project:</b> <?= $project['name'] ?></p>
            <p><b>Plot No:</b> <?= $plot['plot_no'] ?></p>
            <p><b>Size:</b> <?= $plot['size'] ?></p>
        </div>
    </div>

    <!-- Payments -->
    <h3 class="font-semibold mb-2">Payment History</h3>
    <table class="w-full border mb-6">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-2 border">Date</th>
                <th class="px-3 py-2 border">Amount</th>
                <th class="px-3 py-2 border">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $p): ?>
                <tr>
                    <td class="px-3 py-2 border"><?= $p['payment_date'] ?></td>
                    <td class="px-3 py-2 border"><?= number_format($p['amount'], 2) ?></td>
                    <td class="px-3 py-2 border"><?= $p['status'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Print Options -->
    <div class="flex gap-4">
        <?php if ($application['status'] == 'Provisional'): ?>
            <a href="<?= site_url('applications/printLetter/' . $application['id'] . '/provisional') ?>"
                target="_blank"
                class="px-4 py-2 bg-blue-600 text-white rounded">Print Provisional Letter</a>
        <?php elseif ($application['status'] == 'Completed'): ?>
            <a href="<?= site_url('applications/printLetter/' . $application['id'] . '/allotment') ?>"
                target="_blank"
                class="px-4 py-2 bg-green-600 text-white rounded">Print Allotment Letter</a>
        <?php endif; ?>
    </div>

    <!-- Print Logs -->
    <h3 class="font-semibold mt-6 mb-2">Letter Print History</h3>
    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-2 border">Letter Type</th>
                <th class="px-3 py-2 border">Printed At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($printLogs as $log): ?>
                <tr>
                    <td class="px-3 py-2 border"><?= $log['letter_type'] ?></td>
                    <td class="px-3 py-2 border"><?= $log['printed_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>