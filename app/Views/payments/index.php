<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Installments</h2>
<table class="table-auto w-full border" id="dataTable_1">
    <thead>
        <tr>
            <th>Due Date</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Paid Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($installments as $row): ?>
            <tr>
                <td><?= $row['due_date'] ?></td>
                <td><?= number_format($row['amount'], 2) ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td><?= $row['paid_date'] ?></td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <a href="<?= site_url('payments/pay/' . $row['id']) ?>"
                            class="bg-green-500 px-3 py-1 rounded text-white">Pay</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>