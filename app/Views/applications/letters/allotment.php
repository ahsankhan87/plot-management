<!DOCTYPE html>
<html>

<head>
    <title>Final Allotment Letter</title>
    <!-- Tailwind CSS CDN -->
    <script src="<?= base_url() ?>assets/css/tailwindcss-3.4.16.css"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .duplicate {
            color: red;
            font-size: 12px;
        }

        .watermark {
            display: block !important;
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999 !important;
            opacity: 0.10;
            pointer-events: none;
            text-align: center;
            white-space: nowrap;
        }

        .watermark img {
            width: 300px;
            opacity: 1.0;
            z-index: 9999;
            mix-blend-mode: multiply;
        }

        @media print {

            .watermark {
                display: block !important;
                position: fixed !important;
                top: 30% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                opacity: 0.08 !important;
                z-index: 9999 !important;
                font-size: 7rem !important;
                color: #1e40af !important;
            }

            .watermark img {
                width: 300px !important;
                opacity: 1.0 !important;
            }
        }
    </style>
</head>

<body onload="window.print()" style="position:relative;">
    <!-- Watermark -->
    <div class="watermark">

        <?php if (!empty($companyDetail['logo'])): ?>
            <img src="<?= base_url('uploads/company/' . $companyDetail['logo']) ?>" alt="Logo Watermark">
        <?php else: ?>
            <span style="font-size:3rem; font-weight:bold; color:#1e40af;"><?= esc(strtoupper($companyDetail['name'])) ?></span>
        <?php endif; ?>
    </div>
    <div class="p-8 relative z-10 bg-white rounded-xl shadow-xl max-w-3xl mx-auto border border-gray-200">
        <?php if ($isDuplicate): ?>
            <p class="duplicate">Duplicate Copy</p>
        <?php endif; ?>
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-primary mb-2 tracking-wide"><?= esc(strtoupper($companyDetail['name'])) ?></h1>
            <p class="text-lg text-gray-700 mb-1"><?= esc($companyDetail['address']) ?></p>
            <p class="text-gray-600">Contact: <?= esc($companyDetail['contact_number']) ?></p>
        </div>

        <div class="text-right mb-8">
            <p class="text-gray-700"><strong>Application No:</strong> <?= esc($application['app_no']) ?></p>
            <p class="text-gray-700"><strong>Date:</strong> <?= esc($application['app_date']) ?></p>
        </div>

        <div class="mb-8">
            <p class="font-semibold text-gray-700">To,</p>
            <p class="text-lg font-bold text-gray-800"><?= esc($application['customer_name']) ?></p>
            <p class="text-gray-700"><?= esc($application['residential_address']) ?></p>
        </div>

        <div class="mb-8">
            <p class="font-semibold text-xl text-center mb-4 text-primary"><strong>FINAL ALLOTMENT LETTER</strong></p>

            <p class="mb-4 text-gray-800">Dear Sir/Madam,</p>

            <p class="mb-4 text-gray-700">With reference to your application dated <?= date('d/m/Y', strtotime($application['created_at'])) ?>, we are pleased to allot you the following unit in <span class="font-semibold text-primary"><?= esc($companyDetail['name']) ?></span>:</p>

            <div class="ml-8 mb-4">
                <p><span class="font-semibold text-gray-700">Unit No:</span> <span class="text-gray-900"><?= esc($plotDetail['plot_no']) ?></span></p>
                <p><span class="font-semibold text-gray-700">Project:</span> <span class="text-gray-900"><?= esc($plotDetail['project_name']) . ' - ' . esc($plotDetail['phase_name']) . ' - ' . esc($plotDetail['sector_name']) . ' - ' . esc($plotDetail['street_no']) ?></span></p>
                <p><span class="font-semibold text-gray-700">Size:</span> <span class="text-gray-900"><?= esc($plotDetail['size']) . ', ' . esc($plotDetail['area_sqft']) ?> sq.ft</span></p>
                <p><span class="font-semibold text-gray-700">Total Price:</span> <span class="text-gray-900">Rs. <?= number_format($plotDetail['base_price'], 2) ?></span></p>
                <p><span class="font-semibold text-gray-700">Booking Amount:</span> <span class="text-gray-900">Rs. <?= number_format($application['booking_amount'], 2) ?></span></p>
            </div>

            <p class="mb-4 text-gray-800">This allotment is final and subject to the following terms and conditions:</p>

            <ol class="list-decimal ml-8 mb-4 text-gray-700">
                <li class="mb-2">Failure to pay installments for more than 3 months will result in cancellation of this allotment.</li>
                <li class="mb-2">This allotment will be confirmed only after receipt of full payment.</li>
                <li class="mb-2">All payments should be made through bank draft/pay order in favor of "<?= esc($companyDetail['name']) ?>".</li>
            </ol>
        </div>

        <div class="mt-12 text-right">
            <p class="text-gray-700">Yours sincerely,</p>
            <p class="font-semibold mt-8 text-primary">For <?= esc($companyDetail['name']) ?></p>
            <p class="mt-2 text-gray-700">Authorized Signatory</p>
        </div>
    </div>
</body>

</html>