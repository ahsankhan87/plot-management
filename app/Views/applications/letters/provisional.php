<!DOCTYPE html>
<html>

<head>
    <title>Provisional Allotment Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .duplicate {
            color: red;
            font-size: 12px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="p-8">
        <?php if ($isDuplicate): ?>
            <p class="duplicate">Duplicate Copy</p>
        <?php endif; ?>
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold">EXECUTIVE HEIGHTS</h1>
            <p>Near Technical College, Main Kohat Road, Peshawar</p>
            <p>Contact: 091-2322432</p>
        </div>

        <div class="text-right mb-8">
            <p><strong>Application No:</strong> <?= esc($application['app_no']) ?></p>
            <p><strong>Date:</strong> <?= esc($application['app_date']) ?></p>
        </div>

        <div class="mb-8">
            <p class="font-semibold">To,</p>
            <p>Customer Name</p>
            <p>Address </p>
        </div>

        <div class="mb-8">
            <p class="font-semibold text-lg text-center mb-4">PROVISIONAL ALLOTMENT LETTER</p>

            <p class="mb-4">Dear Sir/Madam,</p>

            <p class="mb-4">With reference to your application dated <?= date('d/m/Y', strtotime($application['created_at'])) ?>, we are pleased to provisionally allot you the following unit in Executive Heights:</p>

            <div class="ml-8 mb-4">
                <p><strong>Unit No:</strong> <?= $application['plot_id'] ?></p>
                <p><strong>Project:</strong> <?= $application['project_id'] ?></p>
                <p><strong>Size:</strong> sq.ft</p>
                <p><strong>Total Price:</strong> Rs. <?= number_format($application['total_price'], 2) ?></p>
                <p><strong>application Amount:</strong> Rs. <?= number_format($application['booking_amount'], 2) ?></p>
            </div>

            <p class="mb-4">This allotment is provisional and subject to the following terms and conditions:</p>

            <ol class="list-decimal ml-8 mb-4">
                <li class="mb-2">Installment Plan: <strong><?= esc($installmentPlan['name']) ?></strong> - <?= esc($installmentPlan['description'] ?? '') ?>
                    <?php
                    $months = (int)($installmentPlan['tenure_months'] ?? 0);
                    $years = intdiv($months, 12);
                    $remainingMonths = $months % 12;
                    ?>
                    <?php if ($months > 0): ?>
                        <span class="ml-2 text-gray-700">(
                            <?php if ($years > 0): ?>
                                <?= $years ?> year<?= $years > 1 ? 's' : '' ?>
                            <?php endif; ?>
                            <?php if ($remainingMonths > 0): ?>
                                <?= $years > 0 ? ', ' : '' ?><?= $remainingMonths ?> month<?= $remainingMonths > 1 ? 's' : '' ?>
                            <?php endif; ?>
                            )</span>
                    <?php endif; ?>
                </li>
                <li class="mb-2">Failure to pay installments for more than 3 months will result in cancellation of this allotment.</li>
                <li class="mb-2">This allotment will be confirmed only after receipt of full payment.</li>
                <li class="mb-2">All payments should be made through bank draft/pay order in favor of "Executive Heights".</li>
            </ol>
        </div>

        <div class="mt-12">
            <p>Yours sincerely,</p>
            <p class="font-semibold mt-8">For Executive Heights</p>
            <p class="mt-2">Authorized Signatory</p>
        </div>
    </div>
</body>

</html>