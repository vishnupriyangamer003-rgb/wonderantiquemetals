<?php
$pageTitle = 'Appraisal Procedure | Wonder Antique Metals';
$pageDescription = 'Step-by-step procedure for testing, packing, regulatory approvals, and sale-purchase assignments.';
require_once __DIR__ . '/includes/header.php';

$steps = [
    ['1. Advance Arrangement Fee', 'The company should be engaged by paying requisite arrangement fee 5 days in advance, which is a part payment of our movement charges, and upon receipt of the same the company will make all the necessary arrangements.'],
    ['2. Issuance of Demand Note', 'The company after making all necessary arrangements shall issue the demand note to make the balance amount of movement charges within the stipulated period.'],
    ['3. Date & Time Confirmation', 'The company after receipt of the agreed total onsite assignment charges shall confirm its task commencement date & time 3 days in advance.'],
    ['4. Expert Team Spot Visit', 'The company expert team shall visit the testing spot on the committed date to test and pack the material as per safety norms and guidelines issued by the competent authority.'],
    ['5. Motor-able Road Access', 'The testing spot should be easily accessible by motor-able road, if the testing spot is changed without intimating the company then company reserve the right to refuse the testing of the material on the given date and time and the testing charges paid would be forfeited.'],
    ['6. Testing Protocols', 'On scheduled date and time our metallurgist/appraiser will test the material manually or with the radiation monitor/detector device depending on the payment made.'],
    ['7. Spot Hospitality Rules', 'The company official will not be offered with any food or beverages items at the testing spot.'],
    ['8. Packing & Anti-Radiation Materials', 'The company metallurgist/appraiser after having found it a genuine material, shall pack it with the same packing material or with its new anti-radiation material (if the charges for the same is paid in advance to the company) so as to ensure the complete safety of men and material.'],
    ['9. Master Appraiser & Scientific Valuation', 'On the 3rd day after the test, the company Sr. Appraiser shall visit and test the material with radiation monitor/detector device and on the same day company hired internationally recognized master appraiser shall also test the material, valuation will be assessed scientifically and after that the material shall be packed carefully by preparing a complete record of the packing details along with diagram of the same.'],
    ['10. Custodian Declaration Form', 'The declaration form has to be signed by the identifier/custodian by giving the exact address in the declaration/application form so as to register the material with the competent regulatory authority.'],
    ['11. Regulatory Consent & Submission', 'The company official shall approach the competent authority with the record file containing all the requisite details for the regulatory consent and approval and the custodian has to extend his full cooperation in obtaining the regulatory approval process.'],
    ['12. Joint Custody Transition', 'Once the detailed record file of the material is prepared, and moved towards the regulatory authority for the approvals, the material shall be placed under the joint custody at the given address in the record file to be registered with the regulatory authority.'],
    ['13. Registered Custody Address', 'The joint custody would be an individual house, or a star hotel or resort and it may be noted that the same place and address of the joint custody is required to be registered with the competent regulatory authority and shall be the same till the final completion of the business.'],
    ['14. Change of Joint Custody Address', 'For any valid reason if the joint custody registered address is required to be changed, then it can be done after obtaining the requisite approval from the regulatory authority.'],
    ['15. Government Security & Funds Mobilization', 'After obtaining the regulatory consent and legal registration of the material from the competent regulatory authority, security personals will be deployed at the joint custody site from the government side as well, and the company mobilizes funds through BGs and LCs and also from Global Capital market and reputed corporate house under its private invitation to selective alliance partners, and the funds will be arranged and parked outside India.'],
    ['16. Purchase Order & Govt Payment', 'The purchase order will be issued in favor of the competent authority as per the prescribe format and a considerable amount of payment shall be made to the account officer of the concerned government department.'],
    ['17. Staged Payment Disbursement', 'The Company starts paying the mutually agreed amount as per the agreed schedule.'],
    ['18. Stage-by-Stage Clearances', 'The Company also approaches all the concern departments for obtaining the necessary regulatory consent and approvals stage by stage.'],
    ['19. Full Settlement within 45 Days', 'Within 45 working days the company shall complete the business and make the full and final payment to the custodian and beneficiaries involved and the bank account transfer funds shall be duly super tax paid.'],
    ['20. Custodian No-Claim Letter', 'After obtaining the no claim letter from the custodian/identifier, company takes the material to its place.'],
    ['21. Export, Road & RBI Clearances', 'After obtaining the necessary road transportation permission, the port clearance, and also the export clearance, the material will be exported, and after the export RBI clearance will be obtained.'],
];
?>

<main id="main">
    <section class="appraisal-page section-shell" aria-labelledby="appraisal-procedure-title">
        <div class="appraisal-page__inner">
            <p class="eyebrow">Appraisals · Procedure</p>
            <h1 id="appraisal-procedure-title">Appraisal<br><em>procedure.</em></h1>
            <p class="appraisal-page__lead">The company initiates and performs the task as per the agreed and accepted “Invitation & Assignment Memo” (Unpacking, Testing, Packing, and Regulatory Approvals & Legal Sale-Purchase).</p>
            <figure class="appraisal-page__visual">
                <img src="assets/images/appraisal-procedure.jpg" alt="Appraisal Procedure" width="1200" height="600">
            </figure>
            <div class="appraisal-page__content">
                <?php foreach ($steps as $i => [$heading, $text]): ?>
                <section class="appraisal-page__section" aria-labelledby="proc-sec-<?php echo $i; ?>">
                    <h2 id="proc-sec-<?php echo $i; ?>"><?php echo htmlspecialchars($heading); ?></h2>
                    <div>
                        <p><?php echo htmlspecialchars($text); ?></p>
                    </div>
                </section>
                <?php endforeach; ?>
            </div>

            <div class="appraisal-notes">
                <p><strong>** Arrangement fee</strong> is payable minimum 5 days in advance to engage us so as to make all necessary arrangements by us, and also to see our License and radiation monitoring instruments. The complete movement charges are required to be paid 3 days in advance.</p>
                <p><strong>* Company ready and willing</strong> to bear these charges if the sale-purchase assignment is entrusted to the company.</p>
            </div>

            <a class="button button-dark appraisal-page__action" href="contact.php">Start an enquiry <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
