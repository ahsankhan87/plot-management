<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Agreement - Executive Heights</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        .signature {
            margin-top: 50px;
        }

        .footer {
            margin-top: 100px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <?php
        $companyModel = new \App\Models\CompanyModel();
        $company = $companyModel->getCompany();
        $companyName = $company['name'] ?? 'Company';
        ?>
        <h1><?= $companyName ?></h1>
        <p><?= $company['address'] ?? '' ?></p>
        <p>Contact: <?= $company['contact_number'] ?? '' ?></p>
        <h2>PLOT TRANSFER AGREEMENT</h2>
    </div>

    <div class="section">
        <p>This agreement is made on <?= date('F j, Y') ?> between:</p>
        <p><strong>Transferor:</strong> <?= $transfer['current_customer_name'] ?> S/O <?= $transfer['current_customer_father_husband'] ?> (CNIC: <?= $transfer['current_customer_cnic'] ?>)</p>
        <p><strong>Transferee:</strong> <?= $transfer['new_customer_name'] ?> S/O <?= $transfer['new_customer_father_husband'] ?> (CNIC: <?= $transfer['new_customer_cnic'] ?>)</p>
    </div>

    <div class="section">
        <p><strong>Property Details:</strong></p>
        <p>Unit No: <?= $transfer['plot_no'] ?></p>
        <p>Project: <?= $transfer['project_name'] ?></p>
        <p>Registration No: <?= $transfer['app_no'] ?></p>
    </div>

    <div class="section">
        <p><strong>Transfer Amount:</strong> Rs. <?= number_format($transfer['transfer_amount'], 2) ?></p>
        <p><strong>Transfer Fee:</strong> Rs. <?= number_format($transfer['transfer_fee'], 2) ?></p>
    </div>

    <div class="signature">
        <p>_________________________</p>
        <p>Transferor Signature</p>
        <p>Date: ___________________</p>
    </div>

    <div class="signature">
        <p>_________________________</p>
        <p>Transferee Signature</p>
        <p>Date: ___________________</p>
    </div>

    <div class="signature">
        <p>_________________________</p>
        <p>Authorized Signatory, <?= $companyName ?></p>
        <p>Date: ___________________</p>
    </div>

    <div class="footer">
        <p>This is a computer generated document. No signature is required.</p>
    </div>
</body>

</html>