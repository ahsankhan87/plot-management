<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="w-full mt-10  p-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Installments List</h1>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <table class="table-auto w-full bg-white" id="dataTable_1">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-3 py-2">#</th>
                <th class="px-3 py-2">Due Date</th>
                <th class="px-3 py-2">Amount</th>
                <th class="px-3 py-2">Paid</th>
                <th class="px-3 py-2">Status</th>
                <th class="px-3 py-2">Action</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($installments as $i): ?>
                <tr class="border-b">
                    <td class="px-3 py-2"><?= $i['installment_no'] ?></td>
                    <td class="px-3 py-2"><?= $i['due_date'] ?></td>
                    <td class="px-3 py-2"><?= number_format($i['amount'], 2) ?></td>
                    <td class="px-3 py-2"><?= (!empty($i['paid_amount']) ? number_format($i['paid_amount'], 2) : '0.00') ?></td>
                    <td class="px-3 py-2">
                        <span class="px-2 py-1 rounded text-white 
        <?= $i['status'] == 'paid' ? 'bg-green-500' : ($i['status'] == 'overdue' ? 'bg-red-500' : 'bg-yellow-500') ?>">
                            <?= $i['status'] ?>
                        </span>
                    </td>
                    <td class="px-3 py-2">
                        <?php if ($i['status'] != 'paid' && $i['status'] != 'cancelled'): ?>
                            <a href="<?= site_url('/installments/pay/' . $i['id']) ?>"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                                onclick="return confirm('Are you sure you want to pay this installment?');">
                                Pay
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>