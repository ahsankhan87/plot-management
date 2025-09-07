<?= $this->extend('layouts/header', ['title' => 'Booking Applications']) ?>
<?= $this->section('content') ?>
<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-dark">Booking Applications</h2>
            <p class="text-gray-600">Manage all booking applications in the system</p>
        </div>
        <div class="flex space-x-3">
            <button class="bg-white text-gray-700 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
            <a href="<?= site_url('/applications/create') ?>" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add New Booking
            </a>
        </div>
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

    <!-- Plots Tab Content -->
    <div id="plots" class="tab-content active">

        <!-- Plots Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200" id="dataTable_applications">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">App No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($applications as $a): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $a['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $a['app_no'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $a['customer_name'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $a['project_name'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $a['plot_no'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge
                               <?= $a['status'] == 'Draft' ? 'bg-gray-200 text-gray-800' : '' ?>
                                <?= $a['status'] == 'Booked' ? 'bg-blue-200 text-blue-800' : '' ?>
                                <?= $a['status'] == 'Provisional' ? 'bg-green-200 text-green-800' : '' ?>
                                <?= $a['status'] == 'Active' ? 'bg-yellow-200 text-yellow-800' : '' ?>
                                <?= $a['status'] == 'Completed' ? 'bg-purple-200 text-purple-800' : '' ?>
                                <?= $a['status'] == 'Cancelled' ? 'bg-red-200 text-red-800' : '' ?>">
                                    <?= ucfirst($a['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $a['booking_amount'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $a['app_date'] ?></td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="<?= site_url('/applications/print/' . $a['id']) ?>" target="_blank" class="text-green-600 hover:text-green-900 mr-3"><i class="fas fa-print"></i></a>
                                <!-- <a href="<?= site_url('/applications/download-application/' . $a['id']) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-download"></i></a> -->
                                <!-- <a href="<?= site_url('/payments/record/' . $a['id']) ?>" class="text-purple-600">Payment</a> -->
                                <a href="<?= site_url('/applications/detail/' . $a['id']) ?>" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                                <!-- <a href="<?= site_url('/applications/print-letter/' . $a['id']) ?>" class="text-blue-600">Print Letter</a> -->
                                <!-- <a href="<?= site_url('/applications/edit/' . $a['id']) ?>" class="text-blue-600">Edit</a> -->
                                <form action="<?= site_url('/applications/delete/' . $a['id']) ?>" method="post" class="inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this booking application?')"><i class="fas fa-trash"></i></button>
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </div>


</div>

<script>
    // Tab functionality
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-primary', 'text-primary');
                btn.classList.add('text-gray-600');
            });

            // Add active class to clicked tab
            button.classList.add('border-primary', 'text-primary');
            button.classList.remove('text-gray-600');

            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Show the selected tab content
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Modal functionality
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    // Close modal when clicking outside
    document.querySelectorAll('.form-modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    });
</script>

<?= $this->endSection() ?>