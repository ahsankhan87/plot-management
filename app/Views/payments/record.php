<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="container mx-auto px-4 py-8">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Errors!</strong>
            <ul class="list-disc pl-5">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Record Payment for Application #<?= $application['app_no'] ?></h1>
        <a href="<?= base_url('applications') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
            Back to Application
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Application Summary -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-2">Application Summary</h3>
            <p class="text-gray-600">Unit: <?= $application['project_name'] ?> - <?= $application['plot_no'] ?></p>
            <p class="text-gray-600">Customer: <?= $application['customer_name'] ?></p>
            <p class="text-gray-600">Total Price: Rs. <?= number_format($application['base_price'], 2) ?></p>
            <p class="text-gray-600">Paid: Rs. <?= number_format($totalPaid, 2) ?></p>
            <p class="text-gray-600">Balance: Rs. <?= number_format($application['base_price'] - $totalPaid, 2) ?></p>
        </div>

        <!-- Payment Form -->
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow">
            <form action="<?= site_url('installments/pay-custom-amount/' . $application['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" name="amount" id="amount" value="<?= esc(old('amount')) ?>" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                        <input type="date" name="payment_date" id="payment_date" value="<?= esc(old('payment_date', date('Y-m-d'))) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="cheque">Cheque</option>
                            <option value="pay_order">Pay Order</option>
                            <option value="online">Online</option>
                        </select>
                    </div>

                    <div>
                        <label for="transaction_ref" class="block text-sm font-medium text-gray-700">Transaction Ref.</label>
                        <input type="text" name="transaction_ref" value="<?= $referenceNo ?>" readonly id="transaction_ref" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><?= esc(old('remarks')) ?></textarea>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Record Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payment History -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <h3 class="font-semibold text-lg p-4 bg-gray-50">Payment History</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="dataTable_payments">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($payments)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No payments recorded yet</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $payment['id'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= date('d/m/Y', strtotime($payment['payment_date'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">Rs. <?= number_format($payment['paid_amount'], 2) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= ucfirst(str_replace('_', ' ', $payment['payment_method'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $payment['transaction_ref'] ?? 'N/A' ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= (new \App\Models\UserModel())->find($payment['received_by'])['name'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $payment['remarks'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="<?= base_url("payments/receipt/{$payment['id']}") ?>" class="text-blue-600 hover:text-blue-900" target="_blank">Receipt</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>