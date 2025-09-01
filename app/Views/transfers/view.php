<?= $this->extend('layouts/header') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
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

    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Transfer Request #<?= $transfer['id'] ?></h1>
            <p class="text-gray-600">Created on <?= date('F j, Y', strtotime($transfer['created_at'])) ?></p>
        </div>
        <div class="flex gap-2">
            <?php if ($transfer['approval_status'] == 'pending'): ?>
                <a href="<?= base_url('transfers/approve/' . $transfer['id']) ?>"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
                    onclick="return confirm('Are you sure you want to approve this transfer?')">
                    Approve
                </a>
                <button onclick="showRejectModal()"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Reject
                </button>
            <?php endif; ?>
            <a href="<?= base_url('transfers/agreement/' . $transfer['id']) ?>"
                target="_blank"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Generate Agreement
            </a>
            <a href="<?= base_url('transfers') ?>"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                Back to List
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        <span class="px-4 py-2 rounded-full text-sm font-semibold
            <?= $transfer['approval_status'] == 'approved' ? 'bg-green-100 text-green-800' : '' ?>
            <?= $transfer['approval_status'] == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' ?>
            <?= $transfer['approval_status'] == 'rejected' ? 'bg-red-100 text-red-800' : '' ?>">
            <?= ucfirst($transfer['approval_status']) ?>
        </span>
        <?php if ($transfer['approval_status'] == 'approved' && $transfer['approved_by_name']): ?>
            <span class="ml-2 text-sm text-gray-600">
                Approved by <?= $transfer['approved_by_name'] ?> on <?= date('F j, Y', strtotime($transfer['approval_date'])) ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column - Transfer Details -->
        <div class="space-y-6">
            <!-- Booking Information -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Booking Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Registration No.</label>
                        <p class="text-sm text-gray-900"><?= $transfer['app_no'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Application No.</label>
                        <p class="text-sm text-gray-900"><?= $transfer['app_no'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Unit Details</label>
                        <p class="text-sm text-gray-900"><?= $transfer['project_name'] ?> - <?= $transfer['plot_no'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Transfer Date</label>
                        <p class="text-sm text-gray-900"><?= date('F j, Y', strtotime($transfer['transfer_date'])) ?></p>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Payment Summary</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Price</label>
                        <p class="text-sm text-gray-900">Rs. <?= number_format($paymentSummary['total_price'], 2) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Amount Paid</label>
                        <p class="text-sm text-gray-900">Rs. <?= number_format($paymentSummary['total_paid'], 2) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Balance</label>
                        <p class="text-sm text-gray-900">Rs. <?= number_format($paymentSummary['balance'], 2) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Completion</label>
                        <p class="text-sm text-gray-900"><?= number_format($paymentSummary['completion_percentage'], 1) ?>%</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full"
                            style="width: <?= min($paymentSummary['completion_percentage'], 100) ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Transfer Financials -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Transfer Financials</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Transfer Amount</label>
                        <p class="text-sm text-gray-900">
                            <?= $transfer['transfer_amount'] ? 'Rs. ' . number_format($transfer['transfer_amount'], 2) : 'Not specified' ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Transfer Fee</label>
                        <p class="text-sm text-gray-900">Rs. <?= number_format($transfer['transfer_fee'], 2) ?></p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Reason for Transfer</label>
                        <p class="text-sm text-gray-900 mt-1 p-2 bg-gray-50 rounded"><?= nl2br(htmlspecialchars($transfer['reason'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Customer Information -->
        <div class="space-y-6">
            <!-- Current Customer -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Current Customer</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="text-sm text-gray-900"><?= $transfer['current_customer_name'] ?> S/O <?= $transfer['current_customer_father_husband'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CNIC</label>
                        <p class="text-sm text-gray-900"><?= $transfer['current_customer_cnic'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact</label>
                        <p class="text-sm text-gray-900">
                            <?= $booking['phone'] ?? 'N/A' ?>
                            <?= $booking['email'] ? '<br>' . $booking['email'] : '' ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <p class="text-sm text-gray-900"><?= $booking['residential_address'] ?? 'N/A' ?></p>
                    </div>
                </div>
            </div>

            <!-- New Customer -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">New Customer</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="text-sm text-gray-900"><?= $transfer['new_customer_name'] ?> S/O <?= $transfer['new_customer_father_husband'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CNIC</label>
                        <p class="text-sm text-gray-900"><?= $transfer['new_customer_cnic'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact</label>
                        <p class="text-sm text-gray-900">
                            <?= $newCustomer['phone'] ?? 'N/A' ?>
                            <?= $newCustomer['email'] ? '<br>' . $newCustomer['email'] : '' ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <p class="text-sm text-gray-900"><?= $newCustomer['residential_address'] ?? 'N/A' ?></p>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Supporting Documents</h2>
                <?php
                $documents = $transfer['transfer_documents'] ? json_decode($transfer['transfer_documents'], true) : [];
                ?>

                <?php if (!empty($documents)): ?>
                    <div class="space-y-2">
                        <?php foreach ($documents as $doc): ?>
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                <div>
                                    <span class="text-sm text-gray-900"><?= $doc['name'] ?></span>
                                    <br>
                                    <span class="text-xs text-gray-500">Uploaded: <?= date('M j, Y g:i A', strtotime($doc['uploaded_at'])) ?></span>
                                </div>
                                <a href="<?= base_url('uploads/' . $doc['path']) ?>"
                                    target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                    View Document
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-gray-500">No documents uploaded</p>
                <?php endif; ?>
            </div>

            <!-- Audit Trail -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Audit Trail</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-700">Created</span>
                        <span class="text-sm text-gray-900">
                            <?= date('M j, Y g:i A', strtotime($transfer['created_at'])) ?>
                            by <?= $createdBy['full_name'] ?? 'System' ?>
                        </span>
                    </div>

                    <?php if ($transfer['approval_status'] != 'pending'): ?>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-700"><?= ucfirst($transfer['approval_status']) ?></span>
                            <span class="text-sm text-gray-900">
                                <?= date('M j, Y g:i A', strtotime($transfer['approval_date'])) ?>
                                by <?= $transfer['approved_by_name'] ?? 'System' ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-700">Last Updated</span>
                        <span class="text-sm text-gray-900">
                            <?= date('M j, Y g:i A', strtotime($transfer['updated_at'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-xl w-96">
        <h3 class="text-lg font-semibold mb-4">Reject Transfer Request</h3>
        <form action="<?= base_url('transfers/reject/' . $transfer['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST">
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Reason for Rejection</label>
                <textarea name="rejection_reason" id="rejection_reason" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    placeholder="Please provide detailed reason for rejection..."
                    required></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="hideRejectModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function hideRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target.id === 'rejectModal') {
            hideRejectModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideRejectModal();
        }
    });
</script>

<?= $this->endSection() ?>