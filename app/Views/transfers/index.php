<?= $this->extend('layouts/header') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Plot Transfer Management</h1>
        <a href="<?= base_url('transfers/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            New Transfer Request
        </a>
    </div>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>
    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="get" class="flex gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?= $status ?>" <?= ($currentStatus === $status) ? 'selected' : '' ?>>
                            <?= ucfirst($status) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <a href="<?= base_url('transfers') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Transfers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transfer ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Application No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transfer Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($transfers)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">No transfer requests found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transfers as $transfer): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">#<?= $transfer['id'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $transfer['app_no'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $transfer['project_name'] ?> - <?= $transfer['plot_no'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $transfer['current_customer_name'] ?></div>
                                    <div class="text-sm text-gray-500"><?= $transfer['current_customer_cnic'] ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $transfer['new_customer_name'] ?></div>
                                    <div class="text-sm text-gray-500"><?= $transfer['new_customer_cnic'] ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= date('d/m/Y', strtotime($transfer['transfer_date'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?= $transfer['approval_status'] == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                                <?= $transfer['approval_status'] == 'approved' ? 'bg-green-100 text-green-800' : '' ?>
                                <?= $transfer['approval_status'] == 'rejected' ? 'bg-red-100 text-red-800' : '' ?>">
                                        <?= ucfirst($transfer['approval_status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="<?= base_url('transfers/view/' . $transfer['id']) ?>" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    <?php if ($transfer['approval_status'] == 'pending'): ?>
                                        <a href="<?= base_url('transfers/approve/' . $transfer['id']) ?>" class="text-green-600 hover:text-green-900 mr-2" onclick="return confirm('Approve this transfer?')">Approve</a>
                                        <a href="#" class="text-red-600 hover:text-red-900" onclick="showRejectModal(<?= $transfer['id'] ?>)">Reject</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-xl w-96">
        <h3 class="text-lg font-semibold mb-4">Reject Transfer Request</h3>
        <form id="rejectForm" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST">
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Reason for Rejection</label>
                <textarea name="rejection_reason" id="rejection_reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="hideRejectModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showRejectModal(transferId) {
        const form = document.getElementById('rejectForm');
        form.action = '<?= base_url('transfers/reject/') ?>' + transferId;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function hideRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>

<?= $this->endSection() ?>