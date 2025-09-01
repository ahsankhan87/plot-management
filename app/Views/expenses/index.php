<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Expenses</h1>
    <a href="<?= site_url('expenses/create') ?>" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Expense</a>

    <?php if (session('success')): ?>
        <div class="bg-green-100 text-green-700 p-2 mb-2 rounded"> <?= session('success') ?> </div>
    <?php endif; ?>
    <?php if (session('errors')): ?>
        <div class="bg-red-100 text-red-700 p-2 mb-2 rounded">
            <h2 class="font-bold">Validation Errors</h2>
            <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Summary Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow text-center">
            <div class="text-gray-500">Today Expenses</div>
            <div class="text-2xl font-bold text-primary">Rs. <?= number_format($today_expenses['amount'] ?? 0, 2) ?></div>
        </div>
        <div class="bg-white p-4 rounded shadow text-center">
            <div class="text-gray-500">This Month</div>
            <div class="text-2xl font-bold text-primary">Rs. <?= number_format($month_expenses['amount'] ?? 0, 2) ?></div>
        </div>
        <div class="bg-white p-4 rounded shadow text-center">
            <div class="text-gray-500">Top Category</div>
            <div class="text-2xl font-bold text-primary"><?= esc($top_category['name'] ?? '-') ?></div>
        </div>
    </div>

    <!-- Filters -->
    <form method="get" class="flex flex-wrap gap-4 mb-6 items-end">
        <div>
            <label class="block mb-1">From</label>
            <input type="date" name="date_from" value="<?= esc($_GET['date_from'] ?? date('Y-m-d')) ?>" class="border rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1">To</label>
            <input type="date" name="date_to" value="<?= esc($_GET['date_to'] ?? date('Y-m-d')) ?>" class="border rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1">Category</label>
            <select name="category_id" class="border rounded px-3 py-2">
                <option value="">All</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= esc($cat['id']) ?>" <?= ($_GET['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
    </form>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-bold mb-2">Expenses by Category</h2>
            <canvas id="categoryChart" height="180"></canvas>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-bold mb-2">Expenses by Month</h2>
            <canvas id="monthChart" height="180"></canvas>
        </div>
    </div>

    <!-- Expenses Table -->
    <table class="min-w-full bg-white border" id="dataTable_1">
        <thead>
            <tr>
                <th class="py-2 px-4 border">Date</th>
                <th class="py-2 px-4 border">Amount</th>
                <th class="py-2 px-4 border">Category</th>
                <th class="py-2 px-4 border">Description</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= esc($expense['date']) ?></td>
                    <td class="py-2 px-4 border">Rs. <?= esc(number_format($expense['amount'], 2)) ?></td>
                    <td class="py-2 px-4 border"><?= esc($expense['category_name']) ?></td>
                    <td class="py-2 px-4 border"><?= esc($expense['description']) ?></td>
                    <td class="py-2 px-4 border">
                        <a href="<?= site_url("/expenses/edit/{$expense['id']}") ?>" class="text-blue-500">Edit</a> |
                        <a href="<?= site_url("/expenses/delete/{$expense['id']}") ?>" class="text-red-500" onclick="return confirm('Are you sure you want to delete this expense? This action cannot be undone.');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Chart.js CDN -->
<script src="<?= base_url('assets/js/chartjs/chart.js') ?>"></script>
<script>
    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_keys($category_totals ?? [])) ?>,
            datasets: [{
                data: <?= json_encode(array_values($category_totals ?? [])) ?>,
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#6366f1', '#f472b6'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    // Month Chart
    const monthCtx = document.getElementById('monthChart').getContext('2d');
    const monthChart = new Chart(monthCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($month_totals ?? [])) ?>,
            datasets: [{
                label: 'Expenses',
                data: <?= json_encode(array_values($month_totals ?? [])) ?>,
                backgroundColor: '#3b82f6',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>