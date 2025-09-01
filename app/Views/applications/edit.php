<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>


<form method="post" action="<?= site_url("/applications/update/{$application['id']}") ?>" class="space-y-3">
    <label>Customer</label>
    <select name="customer_id" class="border p-2 w-full" required>
        <?php foreach ($customers as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $application['customer_id'] == $c['id'] ? 'selected' : '' ?>>
                <?= $c['name'] ?> - <?= $c['cnic'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Plot</label>
    <select name="plot_id" class="border p-2 w-full" required>
        <?php foreach ($plots as $p): ?>
            <option value="<?= $p['id'] ?>" <?= $application['plot_id'] == $p['id'] ? 'selected' : '' ?>>
                Plot #<?= $p['plot_no'] ?> (<?= $p['size'] ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label>Date</label>
    <input type="date" name="app_date" value="<?= $application['app_date'] ?>" class="border p-2 w-full">

    <label>Booking Amount</label>
    <input type="number" name="booking_amount" value="<?= $application['booking_amount'] ?>" class="border p-2 w-full">

    <label>Installment Plan</label>
    <select name="installment_plan_id" class="border p-2 w-full">
        <?php foreach ($installmentPlans as $plan): ?>
            <option value="<?= $plan['id'] ?>" <?= $application['installment_plan_id'] == $plan['id'] ? 'selected' : '' ?>>
                <?= $plan['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Status</label>
    <select name="status" class="border p-2 w-full">
        <option value="draft" <?= $application['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
        <option value="booked" <?= $application['status'] == 'booked' ? 'selected' : '' ?>>Booked</option>
        <option value="provisional" <?= $application['status'] == 'provisional' ? 'selected' : '' ?>>Provisional</option>

    </select>

    <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
</form>
<?= $this->endSection() ?>