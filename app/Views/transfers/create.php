<?= $this->extend('layouts/header') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Transfer Request</h1>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <h2 class="font-bold">Validation Errors</h2>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="bg-white p-6 rounded-lg shadow">
        <form action="<?= base_url('transfers/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Application Selection -->
                <div class="col-span-2">
                    <h2 class="text-lg font-semibold mb-4 border-b pb-2">Application Information</h2>
                    <div class="form-group">
                        <label for="application_search" class="block text-sm font-medium text-gray-700">Search Application</label>
                        <input type="text" id="application_search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Enter registration number or customer name">
                        <input type="hidden" name="application_id" id="application_id">
                    </div>

                    <div id="application_details" class="mt-4 p-4 bg-gray-50 rounded-md hidden">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Registration No.</label>
                                <p id="reg_no" class="text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit</label>
                                <p id="unit_info" class="text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Current Customer</label>
                                <p id="current_customer" class="text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <p id="payment_status" class="text-sm text-gray-900"></p>
                            </div>
                        </div>
                        <div id="eligibility_status" class="mt-2 p-2 rounded-md"></div>
                    </div>
                </div>

                <!-- Transfer Details -->
                <div class="col-span-2">
                    <h2 class="text-lg font-semibold mb-4 border-b pb-2">Transfer Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new_customer_id" class="block text-sm font-medium text-gray-700">Transfer To Customer</label>
                            <select name="new_customer_id" id="new_customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer['id'] ?>">
                                        <?= $customer['name'] ?> (CNIC: <?= $customer['cnic'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="transfer_date" class="block text-sm font-medium text-gray-700">Transfer Date</label>
                            <input type="date" name="transfer_date" id="transfer_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div>
                            <label for="transfer_amount" class="block text-sm font-medium text-gray-700">Transfer Amount (Optional)</label>
                            <input type="number" name="transfer_amount" id="transfer_amount" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Transfer Fee</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"
                                value="Rs. <?= number_format($transferFee, 2) ?>" readonly>
                            <small class="text-gray-500">2.5% of transfer amount or Rs. 5,000 minimum</small>
                        </div>
                    </div>
                </div>

                <!-- Documents and Reason -->
                <div class="col-span-2">
                    <h2 class="text-lg font-semibold mb-4 border-b pb-2">Additional Information</h2>

                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Transfer</label>
                        <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Please provide detailed reason for the transfer..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Supporting Documents</label>
                        <input type="file" name="documents[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <small class="text-gray-500">Upload relevant documents (agreement, NOC, etc.)</small>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="col-span-2">
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h3 class="font-semibold mb-2">Terms and Conditions</h3>
                        <div class="text-sm text-gray-600 mb-4">
                            <p>1. Transfer fee is non-refundable once processed.</p>
                            <p>2. All outstanding payments must be cleared before transfer.</p>
                            <p>3. The new customer accepts all terms of the original booking.</p>
                            <p>4. Transfer subject to management approval.</p>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms_accepted" name="terms_accepted" type="checkbox"
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms_accepted" class="font-medium text-gray-700">I accept the transfer terms and conditions</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" id="submit_btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded" disabled>
                    Submit Transfer Request
                </button>
                <a href="<?= base_url('transfers') ?>" class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const applicationSearch = document.getElementById('application_search');
        const applicationDetails = document.getElementById('application_details');
        const submitBtn = document.getElementById('submit_btn');

        // Application search functionality
        applicationSearch.addEventListener('input', debounce(function(e) {
            const searchTerm = e.target.value.trim();
            if (searchTerm.length < 3) return;

            fetch(`<?= base_url('api/applications/search?q=') ?>${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.length > 0) {
                        const application = data[0];
                        displayApplicationDetails(application);
                        checkEligibility(application.id);
                    }
                });
        }, 300));

        function displayApplicationDetails(application) {
            document.getElementById('reg_no').textContent = application.app_no;
            document.getElementById('unit_info').textContent = `${application.project_name} - ${application.plot_no}`;
            document.getElementById('current_customer').textContent = `${application.customer_name} (${application.cnic})`;
            document.getElementById('payment_status').textContent = `Paid: Rs. ${application.total_paid.toLocaleString()}`;

            document.getElementById('application_id').value = application.id;
            applicationDetails.classList.remove('hidden');
        }

        function checkEligibility(applicationId) {
            fetch(`<?= base_url('transfers/checkEligibility/') ?>${applicationId}`)
                .then(response => response.json())
                .then(data => {
                    const eligibilityDiv = document.getElementById('eligibility_status');

                    if (data.eligible) {
                        eligibilityDiv.innerHTML = `
                        <div class="bg-green-100 text-green-800 p-2 rounded-md">
                            ✓ Eligible for transfer (${data.payment_summary.completion_percentage.toFixed(1)}% paid)
                        </div>
                    `;
                        submitBtn.disabled = false;
                    } else {
                        eligibilityDiv.innerHTML = `
                        <div class="bg-red-100 text-red-800 p-2 rounded-md">
                            ✗ Not eligible for transfer. Minimum 25% payment required.
                            (Current: ${data.payment_summary.completion_percentage.toFixed(1)}%)
                        </div>
                    `;
                        submitBtn.disabled = true;
                    }
                });
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    });
</script>

<?= $this->endSection() ?>