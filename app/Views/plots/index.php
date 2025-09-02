<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-dark">Plots/Units Management</h2>
            <p class="text-gray-600">Manage all plots and units in the system</p>
        </div>
        <div class="flex space-x-3">
            <!-- <button class="bg-white text-gray-700 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
            <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700" onclick="openModal('plotFormModal')">
                <i class="fas fa-plus mr-2"></i> Add New Plot
            </button> -->
            <a href="<?= site_url('/plots/create') ?>" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add New Plot
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-200 text-green-800 p-2 rounded mt-3">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>




    <!-- Plots Tab Content -->
    <div id="plots" class="tab-content active">

        <!-- Plots Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200" id="dataTable_1">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plot No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($plots as $p): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $p['project_name'] . ' - ' . $p['phase_name'] . ' - ' . $p['sector_name'] . ' - ' . $p['street_no'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $p['plot_no'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $p['size'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $p['area_sqft'] ?> sq. ft</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rs. <?= number_format($p['base_price'], 2) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge
                                <?= $p['status'] == 'Available' ? 'bg-green-100 text-green-800' : '' ?>
                                <?= $p['status'] == 'Booked' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                                <?= $p['status'] == 'Allotted' ? 'bg-blue-100 text-blue-800' : '' ?>
                                <?= $p['status'] == 'Transferred' ? 'bg-purple-100 text-purple-800' : '' ?>
                                <?= $p['status'] == 'Cancelled' ? 'bg-blue-100 text-blue-800' : '' ?>
                                <?= $p['status'] == 'Cancelled' ? 'bg-red-100 text-red-800' : '' ?>">
                                    <?= ucfirst($p['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href=<?= site_url("/plots/view/{$p['id']}") ?> class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                                <a href=<?= site_url("/plots/edit/{$p['id']}") ?> class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></a> |
                                <a href=<?= site_url("/plots/delete/{$p['id']}") ?> onclick="return confirm('Delete this plot?')" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <!-- Pagination -->

    </div>

</div>


<!-- Add Plot Modal -->
<div id="plotFormModal" class="form-modal">
    <div class="form-container bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b">
            <h3 class="text-xl font-bold text-dark">Add New Plot/Unit</h3>
        </div>
        <div class="p-6">
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Plot/Unit Number</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary" placeholder="e.g., A-101">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Block</label>
                        <select class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                            <option value="">Select Block</option>
                            <option value="A">Block A</option>
                            <option value="B">Block B</option>
                            <option value="C">Block C</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Size (sq. yd)</label>
                        <input type="number" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary" placeholder="e.g., 200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rs.)</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary" placeholder="e.g., 3,500,000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                            <option value="allotted">Allotted</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facing</label>
                        <select class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                            <option value="north">North</option>
                            <option value="south">South</option>
                            <option value="east">East</option>
                            <option value="west">West</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary" rows="3" placeholder="Plot description..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex justify-end p-6 border-t">
            <button class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg mr-3 hover:bg-gray-300" onclick="closeModal('plotFormModal')">Cancel</button>
            <button class="bg-primary text-white px-5 py-2 rounded-lg hover:bg-blue-700">Save Plot</button>
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