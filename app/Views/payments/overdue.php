<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-3">Overdue Payments</h2>
    <?php if (!empty($overdue_payments)): ?>
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($overdue_payments as $pay): ?>
                    <tr>
                        <td class="px-3 py-2 whitespace-nowrap"><?= esc($pay['customer_name']) ?></td>
                        <td class="px-3 py-2 whitespace-nowrap text-red-600 font-semibold"><?= number_format($pay['amount']) ?></td>
                        <td class="px-3 py-2 whitespace-nowrap text-red-500"><?= date('d-M-Y', strtotime($pay['due_date'])) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-gray-600">No overdue payments found.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>