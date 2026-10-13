<?php
/**
 * SICILY BIKE TOURS - FAQs and Customer Reviews
 */

$jsonFile = __DIR__ . '/faqs.json';
if (file_exists($jsonFile)) {
    $faqs = json_decode(file_get_contents($jsonFile), true) ?: [];
    return;
}

$faqs = [
    [
        'q_it' => 'A chi sono adatte le vostre escursioni in e-bike?',
        'q_en' => 'Who are your e-bike tours suitable for?',
        'a_it' => 'Le nostre escursioni sono adatte a tutti: da chi sale in bici per la prima volta fino ai ciclisti esperti, dai 6 ai 99 anni! Grazie alla pedalata assistita delle nostre e-bike di ultima generazione, salite e dislivelli non saranno più un ostacolo.',
        'a_en' => 'Our tours are suitable for everyone from beginners to experienced cyclists, ages 6 to 99! Thanks to the pedal assistance of our latest-generation e-bikes, climbs and elevation gains become effortless and fun.'
    ],
    [
        'q_it' => 'Cosa è incluso nel prezzo del tour?',
        'q_en' => 'What is included in the tour price?',
        'a_it' => 'Tutti i nostri tour includono il noleggio della e-bike (MTB o Touring), casco omologato, kit di riparazione, una guida locale certificata, assicurazione infortuni e acqua/snack. Nei tour con degustazione o gourmet è incluso anche il pasto/degustazione.',
        'a_en' => 'All tours include high-end e-bike rental, certified helmet, repair kit, expert local guide, insurance and water/snack. For wine & gourmet tours, full tasting/meals are also included.'
    ],
    [
        'q_it' => 'Posso richiedere un tour privato o personalizzato su misura?',
        'q_en' => 'Can I request a private or customized tailor-made tour?',
        'a_it' => 'Assolutamente sì! Oltre alle date standard a calendario, organizziamo tour privati e itinerari su misura in qualsiasi periodo dell\'anno in base ai vostri giorni disponibili, tappe desiderate e ritmo di pedalata.',
        'a_en' => 'Absolutely yes! Beyond fixed calendar departures, we design custom private itineraries year-round tailored to your available days, desired destinations and preferred cycling pace.'
    ],
    [
        'q_it' => 'Cosa succede in caso di maltempo?',
        'q_en' => 'What happens in case of bad weather?',
        'a_it' => 'La sicurezza viene sempre al primo posto. In caso di condizioni meteo avverse o allerta vulcanica, il tour potrà essere riprogrammato in un\'altra data oppure rimborsato integralmente.',
        'a_en' => 'Safety always comes first. In case of severe weather or volcanic alerts, the tour can be rescheduled to another date or refunded in full.'
    ],
    [
        'q_it' => 'Quale abbigliamento è consigliato?',
        'q_en' => 'What clothing is recommended?',
        'a_it' => 'Consigliamo abbigliamento sportivo a strati, scarpe da ginnastica o da trekking con suola scolpita, giacca antivento/antipioggia leggera, occhiali da sole e crema solare. Per le quote alte dell\'Etna una felpa è sempre utile.',
        'a_en' => 'We recommend layered athletic clothing, comfortable trainers or light hiking shoes, a light windproof/rain jacket, sunglasses and sunscreen. On Etna summits, an extra fleece layer is always recommended.'
    ]
];

$reviews = [
    [
        'author' => 'Mark & Sarah Thompson',
        'country' => 'Regno Unito (UK)',
        'rating' => 5,
        'tour' => 'Etna Summit & Grotta dei Lamponi',
        'text_it' => 'Esperienza indimenticabile! Mariella e la nostra guida sono state fantastiche. Le e-bike erano potentissime e ci hanno permesso di raggiungere paesaggi vulcanici che tolgono il fiato senza fatica. Il pranzo in home restaurant poi è stato sublime!',
        'text_en' => 'Unforgettable experience! Mariella and our guide were amazing. The e-bikes were super powerful, letting us reach breathtaking volcanic landscapes effortlessly. The home restaurant lunch was simply sublime!'
    ],
    [
        'author' => 'Jean-Luc Dupont',
        'country' => 'Francia',
        'rating' => 5,
        'tour' => 'Cicloturismo Isole Eolie Bici & Barca',
        'text_it' => '5 giorni magici tra Lipari, Salina e Vulcano. Organizzazione impeccabile, hotel perfetti e percorsi cicloturistici spettacolari. Consiglio Sicily Bike Tours a chiunque voglia scoprire la vera Sicilia.',
        'text_en' => '5 magical days between Lipari, Salina and Vulcano. Flawless organization, charming hotels and spectacular cycling roads. I wholeheartedly recommend Sicily Bike Tours to anyone wishing to discover real Sicily.'
    ],
    [
        'author' => 'Famiglia Rossi',
        'country' => 'Italia (Milano)',
        'rating' => 5,
        'tour' => 'Da Randazzo a Floresta - Parco dei Nebrodi',
        'text_it' => 'Abbiamo partecipato con i nostri due figli di 11 e 14 anni. Giornata splendida tra faggi secolari e degustazione di provola. Guide gentili, attentissime alla sicurezza e molto preparate.',
        'text_en' => 'We joined with our two kids (11 and 14). Wonderful day among ancient beech woods and local cheese tasting. Friendly guides, deeply focused on safety and very knowledgeable.'
    ]
];
