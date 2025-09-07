<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Land Management System' ?></title>

    <!-- jQuery CDN -->
    <script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap CDN -->
    <!-- Font Awesome for icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"> -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome-free-7.0.0-web/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="<?= base_url() ?>assets/css/tailwindcss-3.4.16.css"></script>

    <!-- Custom configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#3b82f6',
                        accent: '#f59e0b',
                        dark: '#1f2937',
                        light: '#f3f4f6'
                    }
                }
            }
        }
    </script>

    <!-- Custom style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">

</head>

<body class="bg-gray-100">
    <?php if (session()->get('isLoggedIn')): ?>
        <div class="flex min-h-screen">
            <!-- Header -->
            <header class="header bg-white fixed w-full z-50">

                <div class="flex items-center justify-between px-6 h-full">
                    <!-- Logo and Hamburger -->
                    <div class="flex items-center">
                        <button class="mr-4 text-gray-600">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <?php
                        $companyModel = new \App\Models\CompanyModel();
                        $company = $companyModel->getCompany();
                        $companyName = $company['name'] ?? 'Company';
                        ?>
                        <h1 class="text-xl font-bold text-primary"><?= esc($companyName) ?></h1>
                    </div>

                    <!-- Search Box -->
                    <div class="search-box hidden md:flex items-center bg-gray-100 rounded-lg px-3 py-2 w-60">
                        <i class="fas fa-search text-gray-500 mr-2"></i>
                        <input type="text" placeholder="Search..." class="bg-transparent outline-none w-full">
                    </div>

                    <!-- Right Menu -->
                    <div class="flex items-center">
                        <!-- Notification Bell -->
                        <div class="relative mr-4">
                            <button class="header-btn relative p-2 rounded-full hover:bg-gray-100" id="notificationBtn">
                                <i class="fas fa-bell text-gray-600 text-xl"></i>
                                <span class="notification-dot absolute top-2 right-2"></span>
                            </button>

                            <!-- Notification Dropdown -->
                            <div class="dropdown-menu bg-white mt-2" id="notificationDropdown">
                                <div class="p-4 border-b">
                                    <h3 class="font-semibold text-gray-800">Notifications</h3>
                                    <p class="text-xs text-gray-500">You have 5 unread notifications</p>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    <div class="notification-item p-4 border-b">
                                        <div class="flex">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-file-contract text-blue-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">New booking application received</p>
                                                <p class="text-xs text-gray-500">Ahmed Khan applied for Plot B-102</p>
                                                <p class="text-xs text-gray-400 mt-1">10 minutes ago</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-item p-4 border-b">
                                        <div class="flex">
                                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-money-check text-green-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">Payment received</p>
                                                <p class="text-xs text-gray-500">Sara Ahmed paid installment for Plot A-205</p>
                                                <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-item p-4 border-b">
                                        <div class="flex">
                                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-exclamation-circle text-red-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">Payment overdue</p>
                                                <p class="text-xs text-gray-500">Usman Ali has overdue payment for Plot C-103</p>
                                                <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-item p-4 border-b">
                                        <div class="flex">
                                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-file-signature text-purple-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">Allotment letter ready</p>
                                                <p class="text-xs text-gray-500">Allotment letter for Plot B-102 is ready for printing</p>
                                                <p class="text-xs text-gray-400 mt-1">2 days ago</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-item p-4">
                                        <div class="flex">
                                            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-user-plus text-yellow-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">New customer registered</p>
                                                <p class="text-xs text-gray-500">Zainab Ali created a new account</p>
                                                <p class="text-xs text-gray-400 mt-1">3 days ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 border-t text-center">
                                    <a href="#" class="text-sm text-primary font-medium">View All Notifications</a>
                                </div>
                            </div>
                        </div>

                        <!-- Messages -->
                        <div class="relative mr-4">
                            <button class="header-btn relative p-2 rounded-full hover:bg-gray-100">
                                <i class="fas fa-envelope text-gray-600 text-xl"></i>
                                <span class="notification-dot absolute top-2 right-2"></span>
                            </button>
                        </div>

                        <!-- User Profile -->
                        <div class="relative">
                            <button class="flex items-center" id="userMenuBtn">
                                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-semibold mr-2">

                                    <?php
                                    $username = session()->get('name') ?? 'User';
                                    $nameParts = explode(' ', $username);
                                    $initials = '';
                                    foreach ($nameParts as $part) {
                                        $initials .= strtoupper($part[0]);
                                    }
                                    ?>
                                    <?= $initials ?>
                                </div>
                                <div class="hidden md:block">
                                    <p class="text-sm font-medium text-gray-800"><?= esc(session()->get('username') ?? 'User') ?></p>
                                    <p class="text-xs text-gray-500"><?= esc(session()->get('role') ?? 'Role') ?></p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-500 ml-1 text-xs"></i>
                            </button>

                            <!-- User Dropdown Menu -->
                            <div class="dropdown-menu bg-white mt-2 w-48" id="userDropdown">
                                <div class="p-4 border-b">
                                    <p class="font-medium text-gray-800"><?= esc(session()->get('name') ?? 'User') ?></p>
                                    <p class="text-sm text-gray-500"><?= esc(session()->get('email') ?? '') ?></p>
                                    <p class="text-xs text-gray-500">Role: <?= esc(session()->get('role') ?? 'Role') ?></p>
                                </div>
                                <div class="py-2">
                                    <a href="<?= site_url('company') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-user mr-3 text-gray-500"></i>
                                        <span>My Profile</span>
                                    </a>
                                    <a href="<?= site_url('role') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-user-shield mr-3 text-gray-500"></i>
                                        <span>Roles</span>
                                    </a>
                                    <a href="<?= site_url('projects') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-briefcase mr-3 text-gray-500"></i>
                                        <span>Projects</span>
                                    </a>
                                    <a href="<?= site_url('phases') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-tasks mr-3 text-gray-500"></i>
                                        <span>Phases</span>
                                    </a>
                                    <a href="<?= site_url('sectors') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-building mr-3 text-gray-500"></i>
                                        <span>Sectors</span>
                                    </a>
                                    <a href="<?= site_url('streets') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-road mr-3 text-gray-500"></i>
                                        <span>Streets</span>
                                    </a>
                                    <a href="<?= site_url('installmentplans') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-file-invoice-dollar mr-3 text-gray-500"></i>
                                        <span>Installment Plans</span>
                                    </a>
                                    <a href="<?= site_url('terms') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-file-contract mr-3 text-gray-500"></i>
                                        <span>Terms & Conditions</span>
                                    </a>
                                    <a href="<?= site_url('audit') ?>" class="user-menu-item flex items-center px-4 py-2 text-gray-700">
                                        <i class="fas fa-file-alt mr-3 text-gray-500"></i>
                                        <span>Audit Log</span>
                                    </a>
                                    <a href="<?= site_url('backup') ?>" class="user-menu-item flex items-center px-4 py-2 text-blue-700">
                                        <i class="fas fa-database mr-3 text-blue-500"></i>
                                        <span>Download DB Backup</span>
                                    </a>
                                </div>

                                <div class="py-2 border-t">
                                    <a href="<?= site_url('logout') ?>" class="user-menu-item flex items-center px-4 py-2 text-red-600">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>


            <!-- Sidebar -->
            <div class="sidebar bg-white shadow-lg fixed h-full overflow-y-auto z-40 mt-16">

                <?php
                $uri = current_url(true);
                if ($uri->getTotalSegments() > 0) {
                    $segment = $uri->getSegment(1);
                } else {
                    $segment = 'dashboard';
                }
                ?>

                <nav class="mt-6">
                    <a href="<?= site_url('dashboard') ?>"
                        class="nav-item flex items-center px-6 py-3 <?= $segment === 'dashboard' ? 'text-primary bg-blue-50 border-r-4 border-primary' : 'text-gray-600' ?>">
                        <i class="fas fa-home w-6"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    <a href="<?= site_url('customers') ?>"
                        class="nav-item flex items-center px-6 py-3 <?= $segment === 'customers' ? 'text-primary bg-blue-50 border-r-4 border-primary' : 'text-gray-600' ?>">
                        <i class="fas fa-users w-6"></i>
                        <span class="ml-3">Customers</span>
                    </a>
                    <a href="<?= site_url('plots') ?>"
                        class="nav-item flex items-center px-6 py-3 <?= $segment === 'plots' ? 'text-primary bg-blue-50 border-r-4 border-primary' : 'text-gray-600' ?>">
                        <i class="fas fa-map-marked w-6"></i>
                        <span class="ml-3">Plots/Units</span>
                    </a>
                    <a href="<?= site_url('applications') ?>"
                        class="nav-item flex items-center px-6 py-3 <?= $segment === 'applications' ? 'text-primary bg-blue-50 border-r-4 border-primary' : 'text-gray-600' ?>">
                        <i class="fas fa-file-contract w-6"></i>
                        <span class="ml-3">Bookings</span>
                    </a>
                    <a href="<?= site_url('transfers') ?>"
                        class="nav-item flex items-center px-6 py-3 <?= $segment === 'transfers' ? 'text-primary bg-blue-50 border-r-4 border-primary' : 'text-gray-600' ?>">
                        <i class="fas fa-exchange-alt w-6"></i>
                        <span class="ml-3">Transfers</span>
                    </a>
                    <a href="<?= site_url('expenses') ?>"
                        class="nav-item flex items-center px-6 py-3 <?= $segment === 'expenses' ? 'text-primary bg-blue-50 border-r-4 border-primary' : 'text-gray-600' ?>">
                        <i class="fas fa-file-invoice-dollar w-6"></i>
                        <span class="ml-3">Expenses</span>
                    </a>
                    <a href="<?= site_url('users') ?>"
                        class="nav-item flex items-center px-6 py-3 <?= $segment === 'users' ? 'text-primary bg-blue-50 border-r-4 border-primary' : 'text-gray-600' ?>">
                        <i class="fas fa-user-shield w-6"></i>
                        <span class="ml-3">Users</span>
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 pt-20 px-6 overflow-y-auto main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>

    <?php else: ?>
        <!-- Content for non-logged in users -->
        <div class="min-h-full flex-1 px-6 py-8">
            <?= $this->renderSection('content') ?>
        </div>
    <?php endif; ?>

    <script>
        // Toggle dropdown menus
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBtn = document.getElementById('notificationBtn');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userDropdown = document.getElementById('userDropdown');

            // Toggle notification dropdown
            notificationBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('active');
                userDropdown.classList.remove('active');
            });

            // Toggle user dropdown
            userMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('active');
                notificationDropdown.classList.remove('active');
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                notificationDropdown.classList.remove('active');
                userDropdown.classList.remove('active');
            });

            // Prevent closing when clicking inside dropdown
            notificationDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
    <footer class="bg-gray-800 text-white text-center p-4 mt-8 w-full">
        <p>&copy; <?= date('Y') ?> Land/Plot Management System</p>
    </footer>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatable-1.11.5/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatable-1.11.5/buttons.dataTables.min.css">

    <script src="<?= base_url() ?>assets/datatable-1.11.5/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/datatable-1.11.5/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>assets/datatable-1.11.5/jszip.min.js"></script>
    <script src="<?= base_url() ?>assets/datatable-1.11.5/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>assets/datatable-1.11.5/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>assets/js/datatable.tailwind.pagination.js"></script>
    <script src="<?= base_url() ?>assets/js/datatable.custom.js"></script>

    <script>
        $(function() {
            attachDataTable('#dataTable_1');
            attachDataTable('#dataTable_applications', 7);
            attachDataTable('#dataTable_payments', 1, 'asc');

        });
    </script>

</body>

</html>