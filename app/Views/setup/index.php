<!-- app/Views/setup/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Setup</title>

    <script src="<?= base_url() ?>assets/css/tailwindcss-3.4.16.css"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome-free-7.0.0-web/css/all.min.css">

</head>

<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-building text-white text-2xl"></i>
                </div>
                <h2 class="mt-4 text-3xl font-extrabold text-gray-900">
                    System Setup
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Welcome! Let's get your system configured.
                </p>
            </div>

            <?php if (session('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session('errors')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="mt-8 space-y-6" action="<?= base_url('setup/process') ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Company Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">
                        <i class="fas fa-building mr-2"></i>Company Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name *</label>
                            <input type="text" name="company_name" id="company_name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="<?= old('company_name') ?>">
                        </div>

                        <div>
                            <label for="company_contact" class="block text-sm font-medium text-gray-700">Contact Number *</label>
                            <input type="text" name="company_contact" id="company_contact" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="<?= old('company_contact') ?>">
                        </div>
                    </div>

                    <div>
                        <label for="company_email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                        <input type="email" name="company_email" id="company_email" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            value="<?= old('company_email') ?>">
                    </div>

                    <div>
                        <label for="company_address" class="block text-sm font-medium text-gray-700">Address *</label>
                        <textarea name="company_address" id="company_address" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"><?= old('company_address') ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="company_website" class="block text-sm font-medium text-gray-700">Website</label>
                            <input type="url" name="company_website" id="company_website"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="<?= old('company_website') ?>">
                        </div>

                        <div>
                            <label for="company_reg_number" class="block text-sm font-medium text-gray-700">Registration Number</label>
                            <input type="text" name="company_reg_number" id="company_reg_number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="<?= old('company_reg_number') ?>">
                        </div>
                    </div>

                    <div>
                        <label for="company_ntn" class="block text-sm font-medium text-gray-700">NTN Number</label>
                        <input type="text" name="company_ntn" id="company_ntn"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            value="<?= old('company_ntn') ?>">
                    </div>
                </div>

                <!-- Admin Account -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">
                        <i class="fas fa-user-shield mr-2"></i>Administrator Account
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="admin_fullname" class="block text-sm font-medium text-gray-700">Full Name *</label>
                            <input type="text" name="admin_fullname" id="admin_fullname" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="<?= old('admin_fullname') ?>">
                        </div>

                        <div>
                            <label for="admin_username" class="block text-sm font-medium text-gray-700">Username *</label>
                            <input type="text" name="admin_username" id="admin_username" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                value="<?= old('admin_username') ?>">
                        </div>
                    </div>

                    <div>
                        <label for="admin_email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                        <input type="email" name="admin_email" id="admin_email" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            value="<?= old('admin_email') ?>">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="admin_password" class="block text-sm font-medium text-gray-700">Password *</label>
                            <input type="password" name="admin_password" id="admin_password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Minimum 5 characters</p>
                        </div>

                        <div>
                            <label for="admin_password_confirm" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                            <input type="password" name="admin_password_confirm" id="admin_password_confirm" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-cog text-blue-300 group-hover:text-blue-400"></i>
                        </span>
                        Complete Setup
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        This setup will create your company profile and an administrator account.
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>