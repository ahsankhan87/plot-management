<div id="provisionalModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-1/2">
        <h3 class="text-xl font-bold mb-4">Generate Provisional Letter</h3>
        <p>Do you want to generate and print the Provisional Allotment Letter?</p>
        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal('provisionalModal')" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
            <a href="<?= site_url('applications/print-letter/' . $application['id'] . '/provisional') ?>"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generate</a>
        </div>
    </div>
</div>

<div id="allotmentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-1/2">
        <h3 class="text-xl font-bold mb-4">Generate Allotment Letter</h3>
        <p>Do you want to generate and print the Allotment Letter?</p>
        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal('allotmentModal')" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
            <a href="<?= site_url('applications/print-letter/' . $application['id'] . '/allotment') ?>"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generate</a>
        </div>
    </div>
</div>
<div id="confirmBookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-1/2">
        <h3 class="text-xl font-bold mb-4">Generate Booking Letter</h3>
        <p>Do you want to generate and print the Booking Letter?</p>
        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal('confirmBookingModal')" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
            <a href="<?= site_url('applications/confirm-booking/' . $application['id']) ?>"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generate</a>
        </div>
    </div>
</div>
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-1/2">
        <h3 class="text-xl font-bold mb-4">Record Payment</h3>
        <p>Do you want to record a payment for this application?</p>
        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal('paymentModal')" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
            <a href="<?= site_url('applications/print-letter/' . $application['id'] . '/payment') ?>"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generate</a>
        </div>
    </div>
</div>