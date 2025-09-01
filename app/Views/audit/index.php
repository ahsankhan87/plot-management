<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">📜 Audit Trail Report</h1>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-sm text-left border-collapse" id="dataTable_1">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2">Date & Time</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Action</th>
                    <th class="px-4 py-2">Module</th>
                    <th class="px-4 py-2">Record</th>
                    <th class="px-4 py-2">Changes</th>
                    <th class="px-4 py-2">IP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-700"><?= esc($log['created_at']) ?></td>
                        <td class="px-4 py-2 text-gray-700">User #<?= esc($log['user_id']) ?></td>
                        <td class="px-4 py-2 font-medium text-blue-600"><?= esc($log['action']) ?></td>
                        <td class="px-4 py-2"><?= esc($log['module']) ?></td>
                        <td class="px-4 py-2">#<?= esc($log['record_id']) ?></td>
                        <td class="px-4 py-2">
                            <?php
                            $old = json_decode($log['old_data'], true) ?? [];
                            $new = json_decode($log['new_data'], true) ?? [];
                            ?>
                            <div class="space-y-1">
                                <?php foreach ($new as $field => $newValue): ?>
                                    <div>
                                        <span class="font-semibold"><?= ucfirst($field) ?>:</span>
                                        <span class="line-through text-red-500">
                                            <?= esc($old[$field] ?? '-') ?>
                                        </span>
                                        <span class="text-green-600 ml-2">
                                            <?= esc($newValue) ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-gray-500"><?= esc($log['ip_address']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>