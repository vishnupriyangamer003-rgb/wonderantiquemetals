<?php
$pageTitle = 'Appraisal Terms & Conditions | Wonder Antique Metals';
$pageDescription = 'Review the operational terms and conditions for testing, custody, and appraisals before arranging an assignment.';
require_once __DIR__ . '/includes/header.php';

$terms = [
    ['1. Assignment Date & Fee', 'The assignment date is agreed for a specific date and the amount paid towards the assignment of this particular date only, and it is non-refundable.'],
    ['2. Testing Spot Road & Access', 'The testing spot should be for a specific location, and should not be in forest area, and the approach road to the testing spot should be by a tar road, and 30 meters wide so that four wheeler can be moved on easily, and distance should not me more than 20 feet from vehicle parking spot to testing and delivery spot.'],
    ['3. Spot Structure & High Tension Clearance', 'The location of the testing spot should be exactly the same as per the given address details in Invitation Memo and location map to the company while inviting the company and the roofing of the testing spot should be concrete mould or cemented sheets, and at a distance of minimum 500 meters from HT electricity wires, transformer or Tower.'],
    ['4. Material Delivery Timeline & Disqualification', 'If an identifier/custodian fails to produce the material within the stipulated time i.e. by 08.00 am and or maximum by 09.00 am, and during the course of testing if the material is found as duplicate or dummy in nature, and if the custodian is having any pending criminal case or FIR in any court or police station in a country, or if number of people increased to four at the spot from custodian side, or the atmosphere at the spot is not peaceful, then the assignment will be aborted and cancelled and the fee/charges paid towards the assignment would be forfeited.'],
    ['5. Positive Testing & Joint Custody', 'If testing report is positive and the final test means 3rd test has been confirmed by 12.30 pm, then the material will be placed in the joint custody at the testing spot itself, and two persons from company side will sit in joint custody at the same spot.'],
    ['6. Custodian Declaration & Signal', 'Then the custodian has to sign the declaration form and agreement and provide his photographs, ID proof and address proof of the location. While in joint custody, once the company persons feel the peaceful and safe atmosphere at the testing and delivery spot of the material, they will send the required positive signal to the company.'],
    ['7. Gift Money Delivery Schedule', 'On receipt of the required positive signal sent by the company persons (which should be with in 01.00 pm on the testing day), the gift money will be delivered at the location within per-agreed time on the same day itself if no breach of the clauses B & D is committed as mentioned herein above.'],
    ['8. Financial Bond & Next Banking Day', 'If the test confirmation is done after 01.00 pm then the issued financial bond will be closed and the agreed gift amount money will be paid only on next working/banking day subject to the payment of financial bond opening charges.'],
    ['9. Safe Joint Custody & Security Deployment', 'After delivering the agreed gift amount money at testing spot, the joint custody of the material will be at agreed safe place with two persons from company side and two from custodian side, and also 4 security persons till the legal registration is obtained from the regulatory authority.'],
    ['10. Payment Disbursement Schedule', 'The payment disbursement shall be as per the agreed payment disbursement schedule, and the business will be completed in 45 working days.'],
    ['11. Proof of Funds Conditions', 'The proof of funds can be provided only after the joint custody, or after obtaining regulatory consent and registration from the regulatory body of the radioactive source, or it can be provided on payment of the 5% of the total amount of funds you wish to see prior to the testing.'],
    ['12. Address & Identity Verification', 'The custodian must possess his local proof of address and identity card issued by the local government, so as to enable us to obtain regulatory approvals.'],
    ['13. Legal Compliance & Penalties', 'If any criminal case or a complaint is found pending in the court or police station against the custodian, then the assignment is liable to be cancelled at once and charges paid towards the same will be forfeited and any money paid will be recovered from the custodian with suitable penalty.'],
    ['14. Auction House Consignment Fee', 'The source radioactive material can be put in our auction house directly for auction, provided the seller has obtained and possessing regulatory approvals and subject to the payment of USD 1000 Million as an auction arrangement fee. The source material must be placed in our bonded warehouse.'],
    ['15. Payment Beneficiary & Cash Verification', 'All payments should be made in favor of “WONDER ANTIQUE METALS”, and for cash payment made to our authorized representative shall be confirmed and verification would be provided by the same representative on our website for having received the cash by the company for the proposed assignment.'],
    ['16. Representative Password Verification', 'We strongly advise to cross check with us to corroborate the identity and existence of our representative, if he/she is not referred by us, and our representative can also arrange the identity verification through his/her individual password on our website.'],
    ['17. Five Days Advance Engagement', 'For any business proposal & invitation the company must be engaged at least 5 working days well in advance of the proposed business assignment to be scheduled by paying the full movement charges.'],
    ['18. Consulting Fee', 'Our consulting fee is USD 200 for each session of half an hour, and if you are consulting us without test sample or lab report of test sample then it would be waste of time.'],
    ['19. License Showing Charges', 'Our license and documents can be shown on the payment of USD 10,000 prior to the testing.'],
    ['20. Document Photocopy Issuance', 'The photocopies of our license and documents can be provided on payment of USD 10 million.'],
    ['21. Document Official Verification', 'The verification of our license and documents can be arranged & confirmed on payment of USD 50 Million prior to the testing.'],
    ['22. On-Site & Designated Testing Charges', 'We do testing/appraising at our designated place and also on-site, but for on-site visit testing/appraising charges will be extra.'],
];
?>

<main id="main">
    <section class="appraisal-page section-shell" aria-labelledby="appraisal-terms-title">
        <div class="appraisal-page__inner">
            <p class="eyebrow">Appraisals · Terms</p>
            <h1 id="appraisal-terms-title">Terms &amp;<br><em>conditions.</em></h1>
            <p class="appraisal-page__lead">Please review our operational terms and conditions before scheduling any appraisal or testing assignment.</p>
            <figure class="appraisal-page__visual">
                <img src="assets/images/appraisal-terms.jpg" alt="Terms and Conditions" width="1200" height="600">
            </figure>
            <div class="appraisal-page__content">
                <?php foreach ($terms as $i => [$heading, $text]): ?>
                <section class="appraisal-page__section" aria-labelledby="terms-sec-<?php echo $i; ?>">
                    <h2 id="terms-sec-<?php echo $i; ?>"><?php echo htmlspecialchars($heading); ?></h2>
                    <div>
                        <p><?php echo htmlspecialchars($text); ?></p>
                    </div>
                </section>
                <?php endforeach; ?>
            </div>
            <a class="button button-dark appraisal-page__action" href="contact.php">Request current terms <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
