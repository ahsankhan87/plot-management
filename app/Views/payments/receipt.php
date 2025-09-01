<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-8 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Payment Receipt</h2>
        <span class="text-gray-500">#<?= esc($payment['transaction_ref'] ?? '') ?></span>
    </div>

    <div class="mb-4">
        <p><span class="font-semibold">Customer:</span> <?= esc($payment['customer_name'] ?? '') ?></p>
        <p><span class="font-semibold">Plot No:</span> <?= esc($payment['plot_no'] ?? '') ?></p>
        <p><span class="font-semibold">Project:</span> <?= esc($payment['project_name'] ?? '') ?></p>
        <p><span class="font-semibold">Payment Date:</span> <?= date('d M Y', strtotime($payment['payment_date'] ?? '')) ?></p>
        <p><span class="font-semibold">Due Date:</span> <?= date('d M Y', strtotime($payment['due_date'] ?? '')) ?></p>
        <p>
            <span class="font-semibold">Status:</span>
            <?php
            $due_date = isset($payment['due_date']) ? strtotime($payment['due_date']) : null;
            $now = time();
            $three_months_ago = strtotime('-3 months', $now);
            if ($due_date && $due_date < $three_months_ago) {
                echo '<span class="text-red-600 font-bold">Overdue</span>';
            } else {
                echo '<span class="text-yellow-600 font-bold">Pending</span>';
            }
            ?>
        </p>
    </div>

    <div class="border-t pt-4 mt-4">
        <p><span class="font-semibold">Amount Paid:</span> <span class="text-green-700 font-bold"><?= number_format($payment['paid_amount'] ?? 0, 2) ?></span></p>
        <p><span class="font-semibold">Payment Method:</span> <?= esc($payment['payment_method'] ?? '') ?></p>
        <p><span class="font-semibold">Remarks:</span> <?= esc($payment['remarks'] ?? '') ?></p>
    </div>

    <div class="mt-8 text-center">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">Print Receipt</button>
    </div>
</div>

<?= $this->endSection() ?>