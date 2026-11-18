<?php
$pageTitle = 'Appraisal Fee Structure | Wonder Antique Metals';
$pageDescription = 'Comprehensive schedule of appraisal, testing, packing, security, and regulatory fees.';
require_once __DIR__ . '/includes/header.php';

$feeSchedule = [
    ['Arrangement Fee**', '1', '12,500.00'],
    ['Documents/License Showing Charges', '1', '12,500.00'],
    ['Documents/License Verification Charges', '1', '50,000,000.00'],
    ['Documents/License Photocopy Charges', '1', '10,000,000.00'],
    ['Unpacking Charges for Normal Package', '1', '25,000.00'],
    ['Unpacking Charges of Chemical Package per Layer', '1', '22,500.00'],
    ['Manual Testing Charges (Low Level Radiation)', '1', '14,500.00'],
    ['Manual Testing Charges (Medium Level Radiation)', '1', '27,500.00'],
    ['Testing Charges (High Level Radiation)', '1', '55,500.00'],
    ['Testing Charges (Very High Level Radiation)', '1', '65,500.00'],
    ['Testing Charges with Radiation Detector Device', '1', '72,500.00'],
    ['Airtight Box Container Charges (Glass)', '1', '8,500.00'],
    ['Airtight Box Container Charges (Special Metal)', '1', '162,500.00'],
    ['Internationally Recognized Testing Report', '1', '575,000.00'],
    ['Testing Charges With Scanner', '1', '1,250,000.00'],
    ['Radioactivity Suction Machine Charges', '1', '1,580,000.00'],
    ['Anti Radiation Packing Charges (3 Layers)', '1', '28,700.00'],
    ['Anti Radiation Packing Charges (6 Layers)', '1', '52,500.00'],
    ['Anti Radiation Packing Charges (9 Layers)', '1', '78,200.00'],
    ['Anti Radiation Packing Charges (Per Layer)', '1', '9,500.00'],
    ['Chemical Charges Per Layer', '1', '11,800.00'],
    ['Radiation Safety Suit Charges', '1', '12,500.00'],
    ['Onsite Visit Charges', '1', '8,500.00'],
    ['Persons Insurance & Safety Charges', '1', '4,500.00'],
    ['Material Insurance Charges of the value', '1', '2%'],
    ['Armed Security Charges per person & per day', '1', '6,500.00'],
    ['Funds Mobilization Charges for Agreed Amount', '1', '3%'],
    ['Funds Verification Charges for Agreed Amount', '1', '7%'],
    ['Funds Delivery Charges for Agreed Amount', '1', '1%'],
    ['Funds Parking Charges for Agreed Amount', '1', '7%'],
    ['Tax excluded', '1', '—'],
    ['Registration Regulatory Compliance Charges*', '1', '820,000,000.00'],
];
?>

<main id="main">
    <section class="appraisal-page section-shell" aria-labelledby="appraisal-fees-title">
        <div class="appraisal-page__inner">
            <p class="eyebrow">Appraisals · Fees</p>
            <h1 id="appraisal-fees-title">Fee’s<br><em>structure.</em></h1>
            <p class="appraisal-page__lead">Review our standard schedule of charges for arrangement, licensing, testing, packing, radiation safety, security, and regulatory compliance.</p>
            <figure class="appraisal-page__visual">
                <img src="assets/images/appraisal-fees.jpg" alt="Fee Structure" width="1200" height="600">
            </figure>
            
            <div class="appraisal-table-wrap">
                <table class="appraisal-table" aria-label="Appraisal Fee Structure">
                    <thead>
                        <tr>
                            <th scope="col">Service / Item</th>
                            <th scope="col" class="text-center">Qty</th>
                            <th scope="col" class="text-right">Amount / Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feeSchedule as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row[0]); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row[1]); ?></td>
                            <td class="text-right"><?php echo htmlspecialchars($row[2]); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="appraisal-notes">
                <p>After obtaining the no claim letter from the custodian/identifier, company takes the material to its place.</p>
                <p>After obtaining the necessary road transportation permission, the port clearance, and also the export clearance, the material will be exported, and after the export RBI clearance will be obtained.</p>
                <p><strong>** Arrangement fee</strong> is payable minimum 5 days in advance to engage us so as to make all necessary arrangements by us, and also to see our License and radiation monitoring instruments. The complete movement charges are required to be paid 3 days in advance.</p>
                <p><strong>* Company ready and willing</strong> to bear these charges if the sale-purchase assignment is entrusted to the company.</p>
                <div class="notes-date">Updated on August 10, 2015</div>
            </div>

            <a class="button button-dark appraisal-page__action" href="contact.php">Request an appraisal quote <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
