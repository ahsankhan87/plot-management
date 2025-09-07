<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Heights - Booking Application</title>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
                font-size: 12pt;
            }

            .container {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .signature-pad {
                border: 1px solid #000 !important;
                background: white !important;
            }
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #f0f0f0;
            padding: 8px 12px;
            font-weight: bold;
            border-left: 4px solid #000;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }

        .form-label {
            font-weight: bold;
            min-width: 200px;
            padding-right: 15px;
        }

        .form-value {
            flex: 1;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 3px;
            min-height: 20px;
        }

        .signature-area {
            margin-top: 40px;
            padding: 20px;
            border: 2px solid #000;
            page-break-inside: avoid;
        }

        .signature-pad {
            border: 1px dashed #ccc;
            background: #f9f9f9;
            height: 150px;
            margin-bottom: 15px;
            cursor: crosshair;
        }

        .signature-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .signature-info {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }

        .terms {
            font-size: 11px;
            line-height: 1.3;
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #ccc;
            background: #f9f9f9;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            font-size: 12px;
            color: #666;
        }

        .stamp-area {
            margin-top: 30px;
            text-align: right;
        }

        .stamp {
            display: inline-block;
            border: 2px solid #000;
            padding: 20px;
            text-align: center;
            min-width: 150px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>EXECUTIVE HEIGHTS</h1>
            <p>Near Technical College, Main Kohat Road, Peshawar</p>
            <p>Contact: 091-2322432</p>
        </div>

        <!-- Application Details -->
        <div class="section">
            <div class="section-title">APPLICATION FORM</div>

            <div class="form-group">
                <div class="form-label">Registration No.</div>
                <div class="form-value">: <?= $application['app_no'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Application Form No.</div>
                <div class="form-value">: <?= $application['app_no'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Unit No.</div>
                <div class="form-value">: <?= $application['plot_no'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Block</div>
                <div class="form-value">: <?= $application['project_name'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Floor</div>
                <div class="form-value">: <?= $application['floor'] ?? 'N/A' ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Size</div>
                <div class="form-value">: <?= $application['plot_size'] ?> sq.ft</div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="section">
            <div class="section-title">PERSONAL INFORMATION</div>

            <div class="form-group">
                <div class="form-label">Name</div>
                <div class="form-value">: <?= $application['customer_name'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Father's/Husband's Name</div>
                <div class="form-value">: <?= $application['father_husband'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Postal Address</div>
                <div class="form-value">: <?= $application['postal_address'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Residential Address</div>
                <div class="form-value">: <?= $application['residential_address'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Phone (Office)</div>
                <div class="form-value">: <?= $application['phone'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Phone (Residential)</div>
                <div class="form-value">: <?= $application['phone'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Mobile</div>
                <div class="form-value">: <?= $application['mobile'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Email</div>
                <div class="form-value">: <?= $application['email'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Occupation</div>
                <div class="form-value">: <?= $application['occupation'] ?? 'N/A' ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Age</div>
                <div class="form-value">: <?= $application['age'] ?? 'N/A' ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Nationality</div>
                <div class="form-value">: <?= $application['nationality'] ?? 'N/A' ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">CNIC No.</div>
                <div class="form-value">: <?= $application['cnic'] ?? 'N/A' ?></div>
            </div>
        </div>

        <!-- Nominee Information -->
        <div class="section">
            <div class="section-title">NOMINEE INFORMATION</div>

            <div class="form-group">
                <div class="form-label">Nominee Name</div>
                <div class="form-value">: <?= $application['nominee_name'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Relation</div>
                <div class="form-value">: <?= $application['nominee_relation'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Nominee Address</div>
                <div class="form-value">: <?= $application['nominee_address'] ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Nominee CNIC No.</div>
                <div class="form-value">: <?= $application['nominee_cnic'] ?></div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <div class="section-title">PAYMENT INFORMATION</div>

            <div class="form-group">
                <div class="form-label">Total Price</div>
                <div class="form-value">: Rs. <?= number_format($application['total_price'], 2) ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Booking Amount</div>
                <div class="form-value">: Rs. <?= number_format($application['booking_amount'], 2) ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Payment Method</div>
                <div class="form-value">: </div>
            </div>

            <div class="form-group">
                <div class="form-label">Reference No.</div>
                <div class="form-value">: <?= $application['payment_ref'] ?? 'N/A' ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Payment Date</div>
                <div class="form-value">: </div>
            </div>

            <div class="form-group">
                <div class="form-label">Bank Name</div>
                <div class="form-value">: <?= $application['bank_name'] ?? 'N/A' ?></div>
            </div>

            <?php if (!empty($application['tenure_months'])): ?>
                <?php
                $months = (int)($application['tenure_months'] ?? 0);
                $years = intdiv($months, 12);
                $remainingMonths = $months % 12;
                $monthlyPayment = ($application['total_price'] - $application['booking_amount']) / ($months > 0 ? $months : 1);
                ?>
                <div class="form-group">
                    <div class="form-label">Monthly Payment</div>
                    <div class="form-value">: Rs. <?= number_format($monthlyPayment, 2) ?></div>
                </div>

                <div class="form-group">
                    <div class="form-label">Payment Duration</div>
                    <div class="form-value">: <?= $years ?> Years</div>
                </div>

                <div class="form-group">
                    <div class="form-label">Start Date</div>
                    <div class="form-value">: </div>
                </div>

                <div class="form-group">
                    <div class="form-label">End Date</div>
                    <div class="form-value">: </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Declaration -->
        <div class="section">
            <div class="section-title">DECLARATION</div>

            <div class="terms">
                <p><strong>(I)</strong> I, hereby declare that I have read and understood the terms and conditions of the allotment of the Plot in the project and accept the same.</p>

                <p><strong>(II)</strong> I further agree to pay regularly the installments and dues etc, and abide by all the existing rules and regulations and those, which may be prescribed by (ITTEMAD BUILDERS & DEVELOPERS) from time to time.</p>

                <p>I enclose herewith a sum of Rs. <?= number_format($application['booking_amount'], 2) ?> By <?= ucfirst(str_replace('_', ' ', $application['payment_method'])) ?> No. <?= $application['payment_ref'] ?> Dated <?= date('d/m/Y', strtotime($application['payment_date'])) ?> drawn On account of application of the above Unit.</p>
            </div>
        </div>

        <!-- Signature Area -->
        <div class="signature-area">
            <h3>APPLICANT'S SIGNATURE</h3>

            <?php if (empty($signature)): ?>
                <div class="signature-pad" id="signature-pad"></div>

                <div class="signature-actions no-print">
                    <button onclick="clearSignature()" class="btn btn-secondary">Clear</button>
                    <button onclick="saveSignature()" class="btn btn-success">Save Signature</button>
                </div>

                <div class="signature-info">
                    Please sign above using your mouse or touchscreen. Click "Save Signature" when done.
                </div>
            <?php else: ?>
                <div style="text-align: center; margin: 20px 0;">
                    <img src="<?= $signature ?>" alt="Customer Signature" style="max-width: 300px; border: 1px solid #ccc; padding: 10px;">
                    <p style="margin-top: 10px; font-style: italic;">Signed electronically on <?= date('d/m/Y H:i') ?></p>
                </div>
            <?php endif; ?>

            <div class="form-group" style="margin-top: 30px;">
                <div class="form-label">Date</div>
                <div class="form-value">: <?= date('d/m/Y', strtotime($application['app_date'])) ?></div>
            </div>

            <div class="form-group">
                <div class="form-label">Signature of Applicant</div>
                <div class="form-value">: _________________________</div>
            </div>
        </div>

        <!-- Stamp Area -->
        <div class="stamp-area">
            <div class="stamp">
                <p>FOR EXECUTIVE HEIGHTS</p>
                <p>Authorized Signatory</p>
                <p>Date: ___________</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="no-print" style="margin-top: 40px; text-align: center;">
            <button onclick="window.print()" class="btn btn-primary">Print Application</button>
            <a href="<?= base_url("applications/download-application/{$application['id']}") ?>" class="btn btn-success">Download PDF</a>
            <a href="<?= base_url('applications') ?>" class="btn btn-secondary">Back to Applications</a>
        </div>

        <div class="footer">
            <p>This is a computer generated document. No physical signature is required when signed electronically.</p>
            <p>Generated on: <?= date('d/m/Y H:i:s') ?></p>
        </div>
    </div>

    <!-- Signature Pad JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        <?php if (empty($signature)): ?>
            let signaturePad = null;

            document.addEventListener('DOMContentLoaded', function() {
                const canvas = document.getElementById('signature-pad');
                if (canvas) {
                    canvas.innerHTML = '<canvas width="600" height="150" style="width: 100%; height: 150px;"></canvas>';
                    const signatureCanvas = canvas.querySelector('canvas');

                    signaturePad = new SignaturePad(signatureCanvas, {
                        minWidth: 1,
                        maxWidth: 3,
                        penColor: "rgb(0, 0, 0)",
                        backgroundColor: "rgb(255, 255, 255)"
                    });

                    // Adjust canvas size for printing
                    function resizeCanvas() {
                        const ratio = Math.max(window.devicePixelRatio || 1, 1);
                        signatureCanvas.width = signatureCanvas.offsetWidth * ratio;
                        signatureCanvas.height = signatureCanvas.offsetHeight * ratio;
                        signatureCanvas.getContext("2d").scale(ratio, ratio);
                        signaturePad.clear(); // Clear after resize
                    }

                    window.addEventListener('resize', resizeCanvas);
                    resizeCanvas();
                }
            });

            function clearSignature() {
                if (signaturePad) {
                    signaturePad.clear();
                }
            }

            function saveSignature() {
                if (!signaturePad || signaturePad.isEmpty()) {
                    alert('Please provide your signature first.');
                    return;
                }

                const signatureData = signaturePad.toDataURL();

                fetch('<?= base_url("applications/save-signature/{$application['id']}") ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            signature: signatureData
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Signature saved successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to save signature. Please try again.');
                    });
            }
        <?php endif; ?>

        // Print styling
        window.addEventListener('beforeprint', function() {
            document.body.style.zoom = '100%';
        });

        window.addEventListener('afterprint', function() {
            document.body.style.zoom = '';
        });
    </script>
</body>

</html>