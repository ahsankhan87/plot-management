<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Application Detail</h2>
        <a href="<?= site_url('applications') ?>" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if (isset($validation)): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>
    <!-- Application Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-lg mb-2">Application Info</h3>
            <p><strong>App No:</strong> <?= esc($application['app_no']) ?></p>
            <p><strong>Date:</strong> <?= esc($application['app_date']) ?></p>
            <p><strong>Status:</strong>
                <span class="px-3 py-1 text-sm rounded-full 
                <?= $application['status'] == 'Draft' ? 'bg-gray-200 text-gray-800' : '' ?>
                <?= $application['status'] == 'Booked' ? 'bg-blue-200 text-blue-800' : '' ?>
                <?= $application['status'] == 'Provisional' ? 'bg-green-200 text-green-800' : '' ?>
                <?= $application['status'] == 'Active' ? 'bg-yellow-200 text-yellow-800' : '' ?>
                <?= $application['status'] == 'Completed' ? 'bg-purple-200 text-purple-800' : '' ?>
                <?= $application['status'] == 'Cancelled' ? 'bg-red-200 text-red-800' : '' ?>">
                    <?= esc($application['status']) ?>
                </span>
            </p>
            <p><strong>Plot No:</strong> <?= esc($plot['plot_no']) . ' (' . esc($plot['size']) . ')' ?></p>

            <p><strong>Total Price:</strong> <?= number_format($plot['base_price'], 2) ?></p>
            <p><strong>Booking Amount:</strong> <?= number_format($application['booking_amount'], 2) ?></p>
            <p><strong>Total Dues:</strong> <?= number_format($totalDue, 2) ?></p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold text-lg mb-2">Customer Info</h3>
            <p><strong>Name:</strong> <?= esc($customer['name']) ?></p>
            <p><strong>CNIC:</strong> <?= esc($customer['cnic']) ?></p>
            <p><strong>Phone:</strong> <?= esc($customer['phone']) ?></p>
            <p><strong>Email:</strong> <?= esc($customer['email']) ?></p>
        </div>
    </div>

    <!-- Transition Buttons -->
    <div class="bg-white p-4 rounded shadow mb-8">
        <h3 class="font-bold text-lg mb-4">Actions</h3>
        <div class="flex gap-3">
            <?php if ($application['status'] == 'Draft'): ?>
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    onclick="openModal('confirmBookingModal')">Confirm Booking</button>
            <?php elseif ($application['status'] == 'Booked'): ?>
                <button class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700"
                    onclick="openModal('provisionalModal')">Generate Provisional Letter</button>
            <?php elseif ($application['status'] == 'Completed'): ?>
                <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                    onclick="openModal('allotmentModal')">Generate Allotment Letter</button>
            <?php endif; ?>

            <a href="<?= site_url('/installments/generate/' . $application['id']) ?>" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Generate Installments</a>
            <!-- Custom Payment -->
            <a href="<?= site_url('/payments/record/' . $application['id']) ?>" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Custom Payment</a>

            <!-- Pay Full Remaining -->
            <form action="<?= site_url('installments/pay-full-remaining/' . $application['id']) ?>" method="post">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Pay Full Remaining
                </button>
            </form>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white p-4 rounded shadow mb-8">
        <h3 class="font-bold text-lg mb-4">Payments / Installments</h3>
        <table class="min-w-full text-sm text-left border" id="dataTable_payments">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Amount</th>
                    <th class="px-4 py-2 border">Mode</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($installments as $i): ?>
                    <tr>
                        <td class="px-4 py-2 border"><?= esc($i['installment_no']) ?></td>
                        <td class="px-4 py-2 border"><?= esc($i['due_date']) ?></td>
                        <td class="px-4 py-2 border"><?= number_format($i['amount'], 2) ?></td>
                        <td class="px-4 py-2 border"><?= esc($i['head']) ?></td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded text-xs <?= $i['status'] == 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                <?= esc($i['status']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            <?php if ($i['status'] != 'paid' && $i['status'] != 'cancelled'): ?>
                                <a href="<?= site_url('/installments/pay/' . $i['id']) ?>"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                                    onclick="return confirm('Are you sure you want to pay this installment?');">
                                    Pay
                                </a>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <!-- Print History -->
    <h3 class="mt-6 font-semibold">Letter Print History</h3>
    <ul class="list-disc pl-6">
        <?php foreach ($letterHistory as $lh): ?>
            <li><?= ucfirst($lh['letter_type']) ?> Letter
                <?= $lh['is_duplicate'] ? '(Duplicate)' : '(Original)' ?> -
                <?= $lh['created_at'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<!-- Custom Payment Modal -->
<div id="customPaymentModal" tabindex="-1"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
        <h3 class="text-lg font-bold mb-4">Custom Payment</h3>
        <form action="<?= base_url('installments/pay-custom-amount/' . $application['id']) ?>" method="post">
            <label class="block text-sm font-medium mb-1">Enter Amount</label>
            <input type="number" name="amount" required
                class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:ring-2 focus:ring-blue-500">
            <label class="block text-sm font-medium mb-1">Remarks</label>
            <textarea name="remarks" rows="3"
                class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:ring-2 focus:ring-blue-500"></textarea>

            <div class="flex justify-end space-x-2">
                <button type="button"
                    class="bg-gray-300 px-4 py-2 rounded-lg"
                    data-modal-hide="customPaymentModal"
                    onclick="closeModal('customPaymentModal')">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODALS -->
<?= $this->include('applications/letters/modals') ?>



<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>