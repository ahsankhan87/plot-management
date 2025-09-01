<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Record Payment</h2>

<form method="post">
    <label>Amount</label>
    <input type="number" name="amount" required class="border p-2 w-full">

    <label>Method</label>
    <select name="method" class="border p-2 w-full">
        <option value="cash">Cash</option>
        <option value="bank">Bank</option>
        <option value="cheque">Cheque</option>
        <option value="online">Online</option>
    </select>

    <label>Reference No</label>
    <input type="text" name="reference_no" class="border p-2 w-full">

    <button type="submit" class="bg-blue-500 px-4 py-2 mt-2 text-white">Save</button>
</form>

<?= $this->endSection() ?>