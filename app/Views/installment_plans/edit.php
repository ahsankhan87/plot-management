<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="container mx-auto max-w-lg p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Installment Plan</h2>
    <form method="post" action="<?= site_url('/installmentplans/update/' . $plan['id']) ?>" class="space-y-5">
        <!-- <div>
            <label class="block mb-1 text-gray-700">Project</label>
            <select name="project_id" required class="border rounded w-full px-3 py-2">
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id'] ?>" <?= $plan['project_id'] == $project['id'] ? 'selected' : '' ?>><?= $project['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div> -->
        <div>
            <label class="block mb-1 text-gray-700">Plan Name</label>
            <input type="text" name="name" required class="border rounded w-full px-3 py-2" value="<?= esc($plan['name']) ?>">
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Tenure (Months)</label>
            <input type="number" name="tenure_months" required class="border rounded w-full px-3 py-2" value="<?= esc($plan['tenure_months']) ?>">
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Down Payment (%)</label>
            <input type="number" name="down_payment_pct" required class="border rounded w-full px-3 py-2" step="0.01" value="<?= esc($plan['down_payment_pct']) ?>">
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Markup (%)</label>
            <input type="number" name="markup_pct" required class="border rounded w-full px-3 py-2" step="0.01" value="<?= esc($plan['markup_pct']) ?>">
        </div>
        <div>
            <label class="block mb-1 text-gray-700">Schedule Rule (JSON)</label>
            <textarea name="schedule_rule_json" class="border rounded w-full px-3 py-2"><?= esc($plan['schedule_rule_json']) ?></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">Update</button>
            <a href="<?= site_url('/installmentplans') ?>" class="ml-3 px-6 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>