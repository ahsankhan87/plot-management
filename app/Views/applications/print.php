<!-- app/Views/applications/print_form.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Application Form</title>
    <script src="<?= base_url() ?>assets/css/tailwindcss-3.4.16.css"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        @page {
            /* size: Legal portrait; */
            /* Force Legal page size */
            margin: 0.5cm;
            /* smaller margins for better fit */
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0.5cm;
                /* same as @page */
                zoom: 90%;
                /* scale down content slightly */
            }

            .max-w-4xl {
                max-width: 100%;
                /* let it expand full width */
            }

            /* Reduce padding to save space */
            .p-8 {
                padding: 1rem !important;
            }

            .mb-6,
            .mb-8,
            .mt-12 {
                margin-bottom: 0.75rem !important;
                margin-top: 1rem !important;
            }

            .text-sm {
                font-size: 0.8rem !important;
            }

            .page-break {
                page-break-before: always;
                /* Force new page */
            }

            ol {
                list-style-type: decimal !important;
                margin-left: 20px !important;
            }

            ul {
                list-style-type: disc !important;
                margin-left: 20px !important;
            }

            ol li,
            ul li {
                display: list-item !important;
            }
        }
    </style>

</head>
<!-- onload="window.print()" -->

<body class="bg-white text-gray-900">
    <div class="max-w-4xl mx-auto bg-white border border-gray-400 p-8 rounded-lg shadow relative">

        <!-- Header -->
        <div class="flex justify-between items-start mb-6">

            <!-- Left: Logo + Company Info -->
            <div class="text-left flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <?php if (!empty($companyDetail['logo'])): ?>
                        <img src="<?= base_url('uploads/company/' . $companyDetail['logo']) ?>"
                            alt="Company Logo" class="h-16">
                    <?php endif; ?>
                    <div>
                        <h1 class="text-2xl font-bold text-blue-900"><?= esc(strtoupper($companyDetail['name'])) ?></h1>
                        <p class="text-gray-700"><?= esc($companyDetail['address']) ?></p>
                        <p class="text-gray-600">Contact: <?= esc($companyDetail['contact_number']) ?></p>
                    </div>
                </div>
                <h2 class="mt-2 text-xl font-semibold underline">APPLICATION FORM</h2>
            </div>

        </div>

        <!-- Application Info -->
        <div class="grid grid-cols-2 gap-6 mb-6 text-sm">
            <p><span class="font-semibold">Application No:</span> <?= esc($application['app_no']) ?></p>
            <p><span class="font-semibold">Date:</span> <?= date('d/m/Y', strtotime($application['created_at'])) ?></p>
        </div>

        <!-- Applicant Details -->
        <h3 class="font-bold text-blue-800 mb-2">Applicant Details</h3>
        <div class="grid grid-cols-3 gap-4 border border-gray-300 p-4 mb-6 text-sm items-start">
            <div class="col-span-2 grid grid-cols-2 gap-4">
                <p><span class="font-semibold">Name:</span> <?= esc($application['customer_name']) ?></p>
                <p><span class="font-semibold">Father/Husband:</span> <?= esc($application['father_husband']) ?></p>
                <p><span class="font-semibold">CNIC:</span> <?= esc($application['cnic']) ?></p>
                <p><span class="font-semibold">Phone:</span> <?= esc($application['phone']) ?></p>
                <p><span class="font-semibold">Email:</span> <?= esc($application['email']) ?></p>
                <p><span class="font-semibold">Occupation:</span> <?= esc($application['occupation']) ?></p>
                <p><span class="font-semibold">Address:</span> <?= esc($application['residential_address']) ?></p>
                <p><span class="font-semibold">Postal Address:</span> <?= esc($application['postal_address']) ?></p>

            </div>
            <div class="w-28 h-32 border-2 border-gray-400 flex items-center justify-center overflow-hidden">
                <?php if (!empty($application['photo'])): ?>
                    <img src="<?= base_url('uploads/customers/' . $application['photo']) ?>"
                        alt="Applicant Photo" class="object-cover w-full h-full">
                <?php else: ?>
                    <span class="text-xs text-gray-500">Applicant Photo</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Nominee Details -->
        <h3 class="font-bold text-blue-800 mb-2">Nominee Details</h3>
        <div class="grid grid-cols-3 gap-2 border border-gray-300 p-4 mb-6 text-sm items-start">
            <div class="col-span-2 grid grid-cols-2 gap-2">
                <p><span class="font-semibold">Nominee Name:</span> <?= esc($application['nominee_name']) ?></p>
                <p><span class="font-semibold">Relation:</span> <?= esc($application['nominee_relation']) ?></p>
                <p><span class="font-semibold">CNIC:</span> <?= esc($application['nominee_cnic']) ?></p>
                <p><span class="font-semibold">Phone:</span> <?= esc($application['nominee_phone']) ?></p>
                <p><span class="font-semibold">Address:</span> <?= esc($application['nominee_address']) ?></p>
            </div>
            <div class="w-28 h-32 border-2 border-gray-400 flex items-center justify-center overflow-hidden">
                <?php if (!empty($application['nominee_photo'])): ?>
                    <img src="<?= base_url('uploads/customers/' . $application['nominee_photo']) ?>"
                        alt="Nominee Photo" class="object-cover w-full h-full">
                <?php else: ?>
                    <span class="text-xs text-gray-500">Nominee Photo</span>
                <?php endif; ?>
            </div>
        </div>


        <!-- Plot Details -->
        <h3 class="font-bold text-blue-800 mb-2">Plot Details</h3>
        <div class="grid grid-cols-2 gap-2 border border-gray-300 p-4 mb-6 text-sm">
            <p><span class="font-semibold">Plot No:</span> <?= esc($application['plot_no']) ?></p>
            <p><span class="font-semibold">Project:</span> <?= esc($application['project_name']) ?></p>
            <p><span class="font-semibold">Phase:</span> <?= esc($application['phase_name']) ?></p>
            <p><span class="font-semibold">Sector:</span> <?= esc($application['sector_name']) ?></p>
            <p><span class="font-semibold">Street:</span> <?= esc($application['street_no']) ?></p>
            <p><span class="font-semibold">Size:</span> <?= esc($application['plot_size']) ?> (<?= esc($application['area_sqft']) ?> sqft)</p>
            <p><span class="font-semibold">Total Price:</span> Rs. <?= number_format($application['total_price'], 2) ?></p>
        </div>

        <!-- Payment Details -->
        <h3 class="font-bold text-blue-800 mb-2">Payment Details</h3>
        <?php
        $months = (int)($application['tenure_months'] ?? 0);
        $years = intdiv($months, 12);
        $remainingMonths = $months % 12;
        $monthlyPayment = ($application['total_price'] - $application['booking_amount']) / ($months > 0 ? $months : 1);
        ?>
        <div class="grid grid-cols-2 gap-2 border border-gray-300 p-4 mb-6 text-sm">
            <p><span class="font-semibold">Booking Amount:</span> Rs. <?= number_format($application['booking_amount'], 2) ?></p>
            <p><span class="font-semibold">Installments:</span> <?= esc($months) ?> Months</p>
            <p><span class="font-semibold">Monthly Installment:</span> Rs. <?= number_format($monthlyPayment, 2) ?></p>
        </div>

        <!-- Declaration -->
        <div class="border border-gray-300 p-4 mb-8 text-sm">
            <h3 class="font-bold text-blue-800 mb-2">Declaration</h3>
            <p class="text-gray-700 leading-relaxed">
            <p><strong>(I)</strong> I, hereby declare that I have read and understood the terms and conditions of the allotment of the Plot in the project and accept the same.</p>

            <p><strong>(II)</strong> I further agree to pay regularly the installments and dues etc, and abide by all the existing rules and regulations and those, which may be prescribed by (<?= esc($companyDetail['name']) ?>) from time to time.</p>

            <p>I enclose herewith a sum of Rs. <?= number_format($application['booking_amount'], 2) ?> By <?= ucfirst(str_replace('_', ' ', $application['payment_method'])) ?> No. <?= $application['payment_ref'] ?> Dated <?= date('d/m/Y', strtotime($application['payment_date'])) ?> drawn On account of booking of the above Plot.</p>
            <p>I understand that this application is subject to acceptance by (<?= esc($companyDetail['name']) ?>) and does not in any way bind (<?= esc($companyDetail['name']) ?>) to allot the Plot applied for or any other Plot to me.</p>
            </p>
        </div>

        <!-- Signatures -->
        <div class="grid grid-cols-2 gap-8 mt-11 text-sm">
            <div class="text-center">
                <p class="border-t border-gray-400 pt-2">Applicant Signature</p>
            </div>
            <div class="text-center">
                <p class="border-t border-gray-400 pt-2">Authorized Signatory</p>
            </div>
        </div>
    </div>
    <?php if (!empty($terms)): ?>
        <div class="page-break"></div>
        <div class="max-w-4xl mx-auto bg-white border border-gray-400 p-8 text-sm leading-relaxed">
            <!-- <h2 class="text-center font-bold text-lg underline mb-4"><?= esc($terms['title'] ?? '') ?></h2> -->
            <div class="prose print:prose"><?= $terms['content'] ?></div>
        </div>

        <!-- <div class="mt-12 text-right">
            <p class="border-t border-gray-400 pt-2 inline-block">Signature</p>
        </div> -->
    <?php endif; ?>
</body>

</html>