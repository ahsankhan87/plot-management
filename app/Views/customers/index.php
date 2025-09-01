<?= $this->extend('layouts/header', ['title' => 'Customers']) ?>
<?= $this->section('content') ?>
<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-dark">Customers</h2>
            <p class="text-gray-600">Manage all customers in the system</p>
        </div>
        <div class="flex space-x-3">
            <!-- <button class="bg-white text-gray-700 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                <i class="fas fa-filter mr-2"></i> Filter
            </button> -->
            <a href="<?= site_url('/customers/create') ?>" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add New Customer
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



    <!-- Tabs Navigation -->
    <!-- <div class="bg-white rounded-lg shadow mb-6">
        <div class="flex border-b">
            <button class="tab-btn py-4 px-6 border-b-2 border-primary text-primary font-medium" data-tab="plots">Plots/Units</button>
            <button class="tab-btn py-4 px-6 text-gray-600 font-medium" data-tab="customers">Customers</button>
            <button class="tab-btn py-4 px-6 text-gray-600 font-medium" data-tab="applications">Booking Applications</button>
        </div>
    </div> -->

    <!-- Plots Tab Content -->
    <div id="plots" class="tab-content active">

        <!-- Plots Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200" id="dataTable_1">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Father/Husband Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($customers as $c): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $c['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $c['name'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $c['father_husband'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $c['cnic'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $c['phone'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge
                                <?= $c['status'] == 'active' ? 'bg-green-100 text-green-800' : '' ?>
                                <?= $c['status'] == 'inactive' ? 'bg-red-100 text-red-800' : '' ?>">
                                    <?= ucfirst($c['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href=<?= site_url("/customers/detail/{$c['id']}") ?> class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                                <a href=<?= site_url("/customers/edit/{$c['id']}") ?> class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></a> |
                                <a href=<?= site_url("/customers/delete/{$c['id']}") ?> onclick="return confirm('Delete this customer?')" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>


    </div>

    <!-- Customers Tab Content -->
    <div id="customers" class="tab-content">
        <!-- Customers content will go here -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-700">Customer Management</h3>
            <p class="text-gray-500">Switch to the Customers tab to manage customer records</p>
        </div>
    </div>

    <!-- Applications Tab Content -->
    <div id="applications" class="tab-content">
        <!-- Applications content will go here -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-file-contract text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-700">Booking Applications</h3>
            <p class="text-gray-500">Switch to the Booking Applications tab to manage applications</p>
        </div>
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