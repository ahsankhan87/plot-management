<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <script src="<?= base_url() ?>assets/css/tailwindcss-3.4.16.css"></script>
    <style>
        @media print {
            .print-btn {
                display: none !important;
            }

            body {
                background: #fff !important;
                margin: 0;
            }

            .receipt {
                /* page-break-after: always; */
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="max-w-3xl mx-auto mt-6 space-y-8">

        <!-- Loop Two Copies: Customer & Office -->
        <?php foreach (['Customer Copy', 'Office Copy'] as $copy): ?>
            <div class="receipt bg-white border border-gray-400 rounded-lg shadow p-6">

                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4">
                    <div class="flex items-center gap-3">
                        <?php if (!empty($companyDetail['logo'])): ?>
                            <img src="<?= base_url('uploads/company/' . $companyDetail['logo']) ?>" alt="Company Logo" class="h-14">
                        <?php endif; ?>
                        <div>
                            <h1 class="text-xl font-bold text-blue-900"><?= esc(strtoupper($companyDetail['name'])) ?></h1>
                            <p class="text-gray-700 text-sm"><?= esc($companyDetail['address']) ?></p>
                            <p class="text-gray-600 text-xs">Contact: <?= esc($companyDetail['contact_number']) ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <h2 class="text-lg font-bold text-gray-800">Payment Receipt</h2>
                        <span class="text-xs text-gray-500">Ref: <?= esc($payment['transaction_ref'] ?? '') ?></span><br>
                        <span class="text-[10px] font-semibold text-gray-500"><?= $copy ?></span>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="grid grid-cols-2 gap-6 mb-6 text-sm">
                    <p><span class="font-semibold">Customer:</span> <?= esc($booking['customer_name'] ?? '') ?></p>
                    <p><span class="font-semibold">Plot No:</span> <?= esc($booking['plot_no'] ?? '') ?></p>
                    <p><span class="font-semibold">Project:</span> <?= esc($booking['project_name'] . ' - ' . $booking['phase_name'] . ' - ' . $booking['sector_name'] . ' - ' . $booking['street_no']) ?></p>
                    <p><span class="font-semibold">Payment Date:</span> <?= date('d M Y', strtotime($payment['payment_date'] ?? '')) ?></p>
                    <!-- <p><span class="font-semibold">Due Date:</span> <?= date('d M Y', strtotime($payment['due_date'] ?? '')) ?></p> -->
                    <p>
                        <span class="font-semibold">Status:</span>
                        <span class="text-green-700 font-bold">Paid</span>
                    </p>
                </div>

                <!-- Payment Info -->
                <div class="border-t border-b border-gray-300 py-4 mb-6 text-sm">
                    <div class="mb-4 border-t pt-4">
                        <p><span class="font-semibold">Amount Paid:</span> <span class="text-green-700 font-bold text-lg"><?= number_format($payment['paid_amount'] ?? 0, 2) ?></span></p>
                        <p><span class="font-semibold">Balance Amount:</span> <span class="text-red-700 font-bold text-lg">
                                <?php
                                echo number_format($booking['base_price'] - $totalPaid, 2);
                                ?>
                            </span></p>
                        <p><span class="font-semibold">Payment Method:</span> <?= esc($payment['payment_method'] ?? '') ?></p>
                        <p><span class="font-semibold">Remarks:</span> <?= esc($payment['remarks'] ?? '') ?></p>
                    </div>
                </div>

                <!-- Signatures -->
                <!-- <div class="grid grid-cols-2 gap-8 mt-12 text-sm">
                    <div class="text-center">
                        <p class="border-t border-gray-400 pt-2">Received By</p>
                    </div>
                    <div class="text-center">
                        <p class="border-t border-gray-400 pt-2">Authorized Signatory</p>
                    </div>
                </div> -->

                <!-- Footer -->
                <div class="mt-6 text-xs text-gray-500 text-center border-t pt-2">
                    This receipt is computer generated and does not require a signature. Please retain it for your records.
                </div>

            </div>
        <?php endforeach; ?>

        <!-- Print Button -->
        <div class="text-center print-btn">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                Print Receipt
            </button>
        </div>
    </div>
</body>

</html>