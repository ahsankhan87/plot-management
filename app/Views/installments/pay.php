<?= $this->include('layouts/header') ?>

<h1 class="text-xl font-bold mb-4">Pay Installment #<?= $installment['installment_no'] ?></h1>

<form method="post" class="bg-white p-6 rounded shadow max-w-lg">
    <div class="mb-3">
        <label>Amount</label>
        <input type="number" name="paid_amount" class="border p-2 w-full" required>
    </div>
    <div class="mb-3">
        <label>Method</label>
        <select name="method" class="border p-2 w-full">
            <option value="Cash">Cash</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Cheque">Cheque</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Notes</label>
        <textarea name="notes" class="border p-2 w-full"></textarea>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Record Payment
    </button>
</form>

<?= $this->include('layouts/footer') ?>