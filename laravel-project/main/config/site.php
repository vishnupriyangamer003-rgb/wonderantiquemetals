<?php

// Single source of truth for services (ported verbatim from legacy service-detail.php).
// The /services/{slug} route constraint is derived from these keys.
return [
    'services' => [
    'regulatory' => [
        'number' => '01',
        'eyebrow' => 'Guidance',
        'title' => 'Regulatory support',
        'summary' => 'Navigate changing compliance requirements, documentation, and export logistics with guidance for precious-metal and antique transactions.',
        'image' => 'assets/images/service-regulatory.jpg',
        'alt' => 'Person in a navy suit signing a document with a pen at a wooden desk',
        'details' => [
            'Rules affecting precious metals and antique items keep changing, and they differ from one country to another. Documentation requirements and penalties for getting them wrong have become more demanding, so understanding them early can prevent delays and avoidable cost.',
            'We help you see which local and international requirements may apply to your assets, and how transport, customs, and export paperwork fit into a transaction. Where specialist input is needed, we point you to the right people.',
            'This is general guidance and not legal advice. Regulatory understanding also supports the other services we offer, from assessment through to sale.',
        ],
    ],
    'assaying' => [
        'number' => '02',
        'eyebrow' => 'Technical',
        'title' => 'Assaying & assessment',
        'summary' => 'Professional testing and quality assessment of metals, stones, and antique items, with findings explained clearly.',
        'image' => 'assets/images/service-assaying.jpg',
        'alt' => 'Hand holding a jeweler\'s loupe over a cluster of loose diamonds',
        'details' => [
            'Assaying gives you a clear, evidence-based view of what an item is made of and its condition. Professional testing and quality assessment of metals, stones, and antique pieces helps confirm what you hold before any decision about its value is made.',
            'We explain our findings in plain language, so you understand what was examined, what it shows, and how it relates to the market for similar items.',
            'Assessment is the starting point of a connected route that can continue into regulatory review, acquisition, auction, or sale.',
        ],
    ],
    'acquisition' => [
        'number' => '03',
        'eyebrow' => 'Market',
        'title' => 'Acquisition',
        'summary' => 'Valuation, negotiation, and completion support to help you find suitable buyers or sellers for precious metals, gemstones, and antiques.',
        'image' => 'assets/images/service-acquisition.jpg',
        'alt' => 'Close-up of two people shaking hands over a desk with papers and a notebook',
        'details' => [
            'Acquisition begins with understanding what is on offer. We look at technical quality and market context together, so opportunities in precious metals, gemstones, antiques, and rare materials can be weighed on more than price alone.',
            'Our support covers valuation, negotiation, and completion, and helps identify suitable buyers or sellers so that a transaction can be pursued towards the best available outcome. Regulatory and tax points that can affect a deal are considered alongside.',
            'Because assessment, acquisition, and auction are connected, one team can follow an asset from first examination to a completed sale.',
        ],
    ],
    'auction' => [
        'number' => '04',
        'eyebrow' => 'Exchange',
        'title' => 'Auction services',
        'summary' => 'Online, offline, and on-site auctions for antiques, rare materials, collectibles, and consignments, from planning to completion.',
        'image' => 'assets/images/service-auction.jpg',
        'alt' => 'Wooden gavel with a gold band resting on its sound block beside folders',
        'details' => [
            'A well-prepared lot is easier to understand and easier to value. We prepare metal and antique assets for auction with attention to condition, history, and the qualities that make each piece distinctive.',
            'Auctions can be held online, offline, or on site, and can suit estates, antiques, rare materials, collectibles, and consignments. We support the process from planning through to completion.',
            'Market context guides how an item is presented and when it is offered, whether it is a single piece or a wider collection.',
        ],
    ],
    'monetization' => [
        'number' => '05',
        'eyebrow' => 'Value',
        'title' => 'Monetization',
        'summary' => 'Convert precious metals, stones, and antique assets into value through one connected route of assessment, approvals, and sale.',
        'image' => 'assets/images/service-monetization.jpg',
        'alt' => 'Gold bars lying across a strip of platinum bars on a black background',
        'details' => [
            'Realizing value from precious-metal holdings or unique assets usually starts with knowing exactly what you have. Assessment and regulatory understanding come first, so that the route you choose is an informed one.',
            'From there we discuss practical options for turning precious metals, stones, and antique assets into value, whether through direct sale, auction, or a considered combination of both.',
            'Assaying, approvals, sales, and auction support work together, so each step builds on the one before it and you can weigh the trade-offs before deciding on next steps.',
        ],
    ],
    ],
];
