<?php

/** Default fee schedule and notes for /appraisals/fees (used by the seeder and the data migration). */
return [
    'items' => array_map(
        fn (array $r, int $i) => ['item' => $r[0], 'qty' => $r[1], 'amount' => $r[2], 'sort_order' => $i + 1],
        $rows = [
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
        ],
        array_keys($rows)
    ),
    'sections' => [
        [
            'heading' => 'Notes',
            'text' => "After obtaining the no claim letter from the custodian/identifier, company takes the material to its place.\n\n"
                ."After obtaining the necessary road transportation permission, the port clearance, and also the export clearance, the material will be exported, and after the export RBI clearance will be obtained.\n\n"
                ."** Arrangement fee is payable minimum 5 days in advance to engage us so as to make all necessary arrangements by us, and also to see our License and radiation monitoring instruments. The complete movement charges are required to be paid 3 days in advance.\n\n"
                .'* Company ready and willing to bear these charges if the sale-purchase assignment is entrusted to the company.',
        ],
        ['heading' => 'Last updated', 'text' => 'August 10, 2015'],
    ],
];
