<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>
<!-- Main Content -->

<div class="w-full mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Overview</h2>

    <!-- Dashboard content goes here... -->
    <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 p-5 rounded-lg border border-blue-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-blue-600">Total Plots</p>
                        <h3 class="text-2xl font-bold text-gray-800">142</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-map-marked text-blue-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-blue-600 mt-2"><i class="fas fa-arrow-up mr-1"></i> 12% from last month</p>
            </div>

            <div class="bg-green-50 p-5 rounded-lg border border-green-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-green-600">Customers</p>
                        <h3 class="text-2xl font-bold text-gray-800">87</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up mr-1"></i> 8% from last month</p>
            </div>

            <div class="bg-purple-50 p-5 rounded-lg border border-purple-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-purple-600">Revenue</p>
                        <h3 class="text-2xl font-bold text-gray-800">Rs. 12.5M</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-rupee-sign text-purple-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-purple-600 mt-2"><i class="fas fa-arrow-up mr-1"></i> 15% from last month</p>
            </div>
        </div> -->
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="stats-card bg-white rounded-lg shadow p-5">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Total Plots </p>
                    <h3 class="text-2xl font-bold text-dark"><?= $totalPlots ?></h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-map-marked text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up mr-1"></i> 12% from last month</p>
        </div>
        <div class="stats-card bg-white rounded-lg shadow p-5">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Available</p>
                    <h3 class="text-2xl font-bold text-dark"><?= $availablePlots ?></h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-600 mt-2">Ready for booking</p>
        </div>
        <div class="stats-card bg-white rounded-lg shadow p-5">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Booked</p>
                    <h3 class="text-2xl font-bold text-dark"><?= $bookedPlots ?></h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-file-contract text-yellow-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-600 mt-2">Pending allotment</p>
        </div>
        <div class="stats-card bg-white rounded-lg shadow p-5">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Allotted</p>
                    <h3 class="text-2xl font-bold text-dark"><?= $allottedPlots ?></h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-file-signature text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-600 mt-2">Fully processed</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        <!-- Overdue Payments -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Overdue Payments</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($overduePayments as $pay): ?>
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap"><?= esc($pay['customer_name']) ?></td>
                                <td class="px-3 py-2 whitespace-nowrap text-red-600 font-semibold"><?= number_format($pay['amount']) ?></td>
                                <td class="px-3 py-2 whitespace-nowrap text-red-500"><?= date('d-M-Y', strtotime($pay['due_date'])) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-right">
                <a href="<?= site_url('payments/overdue') ?>"
                    class="inline-block px-3 py-1 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                    View All
                </a>
            </div>
        </div>

        <!-- Latest Applications -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Latest Applications</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">App #</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($latestApplications as $app): ?>
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap"><?= esc($app['app_no']) ?></td>
                                <td class="px-3 py-2 whitespace-nowrap"><?= esc($app['customer_name']) ?></td>
                                <td class="px-3 py-2 whitespace-nowrap"><?= date('d-M-Y', strtotime($app['created_at'])) ?></td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $app['status'] == 'Draft' ? 'bg-gray-200 text-gray-800' : '' ?>
                                <?= $app['status'] == 'Booked' ? 'bg-blue-200 text-blue-800' : '' ?>
                                <?= $app['status'] == 'Provisional' ? 'bg-green-200 text-green-800' : '' ?>
                                <?= $app['status'] == 'Active' ? 'bg-yellow-200 text-yellow-800' : '' ?>
                                <?= $app['status'] == 'Completed' ? 'bg-purple-200 text-purple-800' : '' ?>
                                <?= $app['status'] == 'Cancelled' ? 'bg-red-200 text-red-800' : '' ?>">
                                        <?= esc($app['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>

</div>



<script>
    // Simple step navigation for the form
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.form-step');
        let currentStep = 0;

        // Show first step by default
        steps[currentStep].classList.add('active');

        // Next button functionality
        document.querySelector('button:last-child').addEventListener('click', function() {
            if (currentStep < steps.length - 1) {
                steps[currentStep].classList.remove('active');
                currentStep++;
                steps[currentStep].classList.add('active');

                // Update progress bar
                const progress = ((currentStep + 1) / steps.length) * 100;
                document.querySelector('.progress-fill').style.width = `${progress}%`;
                document.querySelector('.progress-bar + div span:last-child').textContent = `${Math.round(progress)}%`;
            }
        });

        // Previous button functionality
        document.querySelector('button:first-child').addEventListener('click', function() {
            if (currentStep > 0) {
                steps[currentStep].classList.remove('active');
                currentStep--;
                steps[currentStep].classList.add('active');

                // Update progress bar
                const progress = ((currentStep + 1) / steps.length) * 100;
                document.querySelector('.progress-fill').style.width = `${progress}%`;
                document.querySelector('.progress-bar + div span:last-child').textContent = `${Math.round(progress)}%`;
            }
        });
    });
</script>
<?= $this->endSection() ?>