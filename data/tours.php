<?php
/**
 * SICILY BIKE TOURS - Catalogo Tour ed Escursioni
 * Database configurabile e aggiornabile per tutti i tour (giornalieri e plurigiornalieri).
 */

$jsonFile = __DIR__ . '/tours.json';
if (file_exists($jsonFile)) {
    $tours = json_decode(file_get_contents($jsonFile), true) ?: [];
    return;
}

$tours = [
    [
        'id' => 1,
        'slug' => 'etna-summit-vulcano-avventura',
        'type' => 'escursione', // 'escursione' (1 giorno) o 'tour' (più giorni)
        'category' => 'Escursioni Giornaliere',
        'category_en' => 'Day Excursions',
        'area' => 'Etna',
        'area_tag' => 'etna',
        'featured' => true,
        'title' => 'Etna Summit: la scalata del vulcano in E-Bike',
        'title_en' => 'Etna Summit: E-Bike Volcano Climb',
        'subtitle' => 'Una giornata memorabile tra colate laviche storiche, crateri e paesaggi lunari fino alle quote sommitali.',
        'subtitle_en' => 'An unforgettable day through historical lava flows, craters and moonscapes up to the high peaks.',
        'image' => 'assets/img/gallery/summit.jpg',
        'gallery' => [
            'assets/img/gallery/summit.jpg',
            'assets/img/gallery/Etna-home-page.jpg',
            'assets/img/gallery/etna-2.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-113.jpg'
        ],
        'price' => 85,
        'price_note' => 'a persona (guida + e-bike inclusa)',
        'price_note_en' => 'per person (guide + e-bike included)',
        'duration' => '5-6 ore',
        'duration_en' => '5-6 hours',
        'days' => 1,
        'distance' => '40 km',
        'elevation' => '+1.300 m',
        'difficulty' => 'Medio / Difficile',
        'difficulty_en' => 'Medium / Challenging',
        'start_location' => 'Randazzo / Rifugio Nord Etna',
        'season' => 'Aprile - Ottobre',
        'season_en' => 'April - October',
        'highlights' => [
            'Salita panoramica verso i crateri sommitali',
            'Attraversamento delle colate laviche storiche e deserto di sabbia vulcanica',
            'Sosta panoramica sulla Valle del Bove e vista fino al Mar Ionio',
            'Guida esperta di vulcanologia e cicloturismo'
        ],
        'highlights_en' => [
            'Panoramic ascent towards the summit craters',
            'Riding through historical lava fields and volcanic sand',
            'Panoramic stop overlooking the Valle del Bove and Ionian Sea',
            'Certified volcanological & cycling local guide'
        ],
        'included' => [
            'Noleggio E-MTB biammortizzata di ultima generazione',
            'Casco, kit riparazione e sacca idrica',
            'Guida cicloturistica certificata',
            'Assicurazione infortuni',
            'Snack energetico e acqua'
        ],
        'included_en' => [
            'Latest generation full-suspension E-MTB rental',
            'Helmet, repair kit and hydration pack',
            'Certified local cycling guide',
            'Personal injury insurance',
            'Energy snack and fresh water'
        ],
        'excluded' => [
            'Pranzo completo (disponibile su richiesta)',
            'Transfer da hotel (su richiesta)'
        ],
        'excluded_en' => [
            'Full lunch (available upon request)',
            'Hotel pickup/transfer (on request)'
        ],
        'schedule_dates' => ['2026-04-15', '2026-04-22', '2026-05-06', '2026-05-20', '2026-06-10', '2026-07-08', '2026-08-12', '2026-09-09', '2026-10-07']
    ],
    [
        'id' => 2,
        'slug' => 'tour-in-e-bike-e-pranzo-gourmet',
        'type' => 'escursione',
        'category' => 'Escursioni Giornaliere',
        'category_en' => 'Day Excursions',
        'area' => 'Etna',
        'area_tag' => 'etna',
        'featured' => true,
        'title' => 'Escursione in E-Bike & Pranzo Gourmet',
        'title_en' => 'E-Bike Tour & Gourmet Lunch',
        'subtitle' => 'Un mix perfetto di natura, panorami tra mare e vulcano e un pranzo indimenticabile in Home Restaurant tipico.',
        'subtitle_en' => 'A perfect blend of nature, sea-to-volcano views and an unforgettable lunch at a typical Home Restaurant.',
        'image' => 'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-31.jpg',
        'gallery' => [
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-31.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-32.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-sicilia-tour-in-bici-sicilia-escursioni-sulletna-escursioni-sui-nebrodi-escursioni-alcantara-33.jpg'
        ],
        'price' => 95,
        'price_note' => 'a persona (e-bike + pranzo gourmet incluso)',
        'price_note_en' => 'per person (e-bike + gourmet lunch included)',
        'duration' => '3-4 ore + pranzo',
        'duration_en' => '3-4 hours + lunch',
        'days' => 1,
        'distance' => '35 km',
        'elevation' => '+1.100 m',
        'difficulty' => 'Medio / Facile',
        'difficulty_en' => 'Easy / Moderate',
        'start_location' => 'Milo (Versante Est Etna)',
        'season' => 'Aprile - Novembre',
        'season_en' => 'April - November',
        'highlights' => [
            'Pedalata tra i vigneti più celebri dell\'Etna DOC e boschi di castagni secolari',
            'Spettacolari scorci sulla costa ionica di Taormina e Riposto',
            'Pranzo gourmet a 4 portate con prodotti biologici a km 0 e vino locale',
            'Atmosfera intima e calorosa accoglienza siciliana'
        ],
        'highlights_en' => [
            'Ride through famous Etna DOC vineyards and centuries-old chestnut woods',
            'Spectacular views over the Ionian coast from Taormina to Riposto',
            '4-course gourmet lunch featuring local organic ingredients and wine',
            'Intimate atmosphere and warm authentic Sicilian hospitality'
        ],
        'included' => [
            'Noleggio E-Bike biammortizzata',
            'Guida ciclistica locale per tutto il percorso',
            'Pranzo gourmet completo in Home Restaurant selezionato',
            'Degustazione vino locale DOC',
            'Casco e assicurazione'
        ],
        'included_en' => [
            'Full-suspension E-Bike rental',
            'Local cycling guide for the whole tour',
            'Full gourmet lunch in a selected Home Restaurant',
            'Local Etna DOC wine tasting',
            'Helmet and insurance'
        ],
        'excluded' => [
            'Extra personali e acquisti bottiglie in cantina'
        ],
        'excluded_en' => [
            'Personal extras and wine bottle purchases'
        ],
        'schedule_dates' => ['2026-04-18', '2026-05-02', '2026-05-16', '2026-06-06', '2026-06-27', '2026-07-18', '2026-09-12', '2026-10-10']
    ],
    [
        'id' => 3,
        'slug' => 'escursione-in-bicicletta-etna-grotta-lamponi',
        'type' => 'escursione',
        'category' => 'Escursioni Giornaliere',
        'category_en' => 'Day Excursions',
        'area' => 'Etna',
        'area_tag' => 'etna',
        'featured' => false,
        'title' => 'Escursione in E-Bike: Etna & Grotta dei Lamponi',
        'title_en' => 'Etna & Raspberry Lava Cave E-Bike Tour',
        'subtitle' => 'Viaggio tra le pinete della Ragabo, la maestosa colata del 2002 e l\'esplorazione speleologica di un tunnel lavico millenario.',
        'subtitle_en' => 'A journey through Ragabo pine forest, the huge 2002 lava flow and speleological exploration of an ancient lava tube.',
        'image' => 'assets/img/gallery/etna-2.jpg',
        'gallery' => [
            'assets/img/gallery/etna-2.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-106.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-93.jpg'
        ],
        'price' => 75,
        'price_note' => 'a persona (guida + casco + torcia speleo inclusi)',
        'price_note_en' => 'per person (guide + helmet + cave torch included)',
        'duration' => '4-6 ore',
        'duration_en' => '4-6 hours',
        'days' => 1,
        'distance' => '45 km',
        'elevation' => '+930 m',
        'difficulty' => 'Medio',
        'difficulty_en' => 'Moderate',
        'start_location' => 'Randazzo / Pineta Ragabo',
        'season' => 'Marzo - Novembre',
        'season_en' => 'March - November',
        'highlights' => [
            'Pedalata tra i pini larici della secolare Pineta Ragabo',
            'Visita con caschetto e torcia all\'interno della Grotta dei Lamponi',
            'Passaggio sulla grande colata lavica del 2002 a Piano Provenzana',
            'Discese divertenti su piste forestali battute'
        ],
        'highlights_en' => [
            'Cycling among the ancient towering pines of Ragabo forest',
            'Caving exploration of the famous Grotta dei Lamponi with helmets and torches',
            'Crossing the massive 2002 lava flow near Piano Provenzana',
            'Fun flow descents on scenic forest gravel trails'
        ],
        'included' => [
            'Noleggio E-Bike MTB',
            'Casco, torce frontali per speleologia',
            'Guida ciclistica ed escursionistica',
            'Assicurazione'
        ],
        'included_en' => [
            'E-MTB rental',
            'Helmets and headlamps for cave exploration',
            'Certified cycling guide',
            'Insurance'
        ],
        'excluded' => [
            'Pranzo al sacco / ristorante'
        ],
        'excluded_en' => [
            'Packed lunch / restaurant'
        ],
        'schedule_dates' => ['2026-04-12', '2026-04-26', '2026-05-10', '2026-05-24', '2026-06-14', '2026-07-05', '2026-09-20']
    ],
    [
        'id' => 4,
        'slug' => 'escursione-etna-degustazione-vino',
        'type' => 'escursione',
        'category' => 'Escursioni Giornaliere',
        'category_en' => 'Day Excursions',
        'area' => 'Etna',
        'area_tag' => 'etna',
        'featured' => false,
        'title' => 'Etna in E-Bike: Avventura e Degustazione di Vino',
        'title_en' => 'Etna E-Bike & Wine Tasting Adventure',
        'subtitle' => 'Una fuga tra le contrade del vino vulcanico, antichi palmenti e cantine prestigiose sull\'Etna Nord.',
        'subtitle_en' => 'An escape through volcanic wine contradas, historic stone presses and prestigious northern Etna wineries.',
        'image' => 'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-77.jpg',
        'gallery' => [
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-77.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-82.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-96.jpg'
        ],
        'price' => 90,
        'price_note' => 'a persona (inclusa degustazione 3 calici + tagliere)',
        'price_note_en' => 'per person (includes 3 wine tastings + local board)',
        'duration' => '4-5 ore',
        'duration_en' => '4-5 hours',
        'days' => 1,
        'distance' => '38 km',
        'elevation' => '+800 m',
        'difficulty' => 'Facile / Medio',
        'difficulty_en' => 'Easy / Moderate',
        'start_location' => 'Castiglione di Sicilia / Solicchiata',
        'season' => 'Tutto l\'anno',
        'season_en' => 'All year round',
        'highlights' => [
            'Pedalata panoramica lungo la famosa Strada del Vino dell\'Etna',
            'Visita a uno storico palmento in pietra lavica',
            'Degustazione guidata di Nerello Mascalese e Carricante in cantina',
            'Tagliere di formaggi dei Nebrodi, salumi nostrani e pane casereccio'
        ],
        'highlights_en' => [
            'Panoramic ride along the famous Etna Wine Route',
            'Visit to a historic lava-stone wine press',
            'Guided tasting of Nerello Mascalese and Carricante at a boutique winery',
            'Platter of Nebrodi cheeses, local cured meats and artisan bread'
        ],
        'included' => [
            'Noleggio E-Bike',
            'Guida ciclistica',
            'Degustazione vini e tagliere tipico in cantina',
            'Casco e assicurazione'
        ],
        'included_en' => [
            'E-Bike rental',
            'Cycling guide',
            'Wine tasting with local platter at winery',
            'Helmet and insurance'
        ],
        'excluded' => [
            'Spese personali'
        ],
        'excluded_en' => [
            'Personal expenses'
        ],
        'schedule_dates' => ['2026-04-11', '2026-04-25', '2026-05-09', '2026-05-23', '2026-06-13', '2026-07-11', '2026-08-22', '2026-09-19', '2026-10-17']
    ],
    [
        'id' => 5,
        'slug' => 'escursione-in-bici-randazzo-bronte',
        'type' => 'escursione',
        'category' => 'Escursioni Giornaliere',
        'category_en' => 'Day Excursions',
        'area' => 'Etna',
        'area_tag' => 'etna',
        'featured' => false,
        'title' => 'Da Randazzo a Bronte: Sapori dell\'Etna e Castello di Nelson',
        'title_en' => 'From Randazzo to Bronte: Flavors & Nelson Castle',
        'subtitle' => 'Tra le colate laviche, le piantagioni dell\'oro verde (il pistacchio di Bronte DOP) e il fascino storico dell\'antico maniero.',
        'subtitle_en' => 'Through lava fields, emerald pistachio plantations and the historic charm of the British Nelson Castle.',
        'image' => 'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-119.jpg',
        'gallery' => [
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-119.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-30.jpg'
        ],
        'price' => 80,
        'price_note' => 'a persona (e-bike + guida + degustazione pistacchio inclusi)',
        'price_note_en' => 'per person (e-bike + guide + pistachio tasting included)',
        'duration' => '4-6 ore',
        'duration_en' => '4-6 hours',
        'days' => 1,
        'distance' => '48 km',
        'elevation' => '+850 m',
        'difficulty' => 'Medio / Facile',
        'difficulty_en' => 'Moderate / Easy',
        'start_location' => 'Randazzo',
        'season' => 'Aprile - Novembre',
        'season_en' => 'April - November',
        'highlights' => [
            'Partenza dalla cittadina medievale di Randazzo',
            'Percorso sterrato panoramico attraverso le lave di Bronte',
            'Visita ai pistacchieti vulcanici e degustazione di dolci al pistacchio DOP',
            'Sosta culturale al Castello di Nelson e ai suoi giardini inglesi'
        ],
        'highlights_en' => [
            'Departing from the medieval stone town of Randazzo',
            'Scenic gravel trails across historic Bronte volcanic lava fields',
            'Visit to pistachio groves with tasting of genuine Bronte PDO pistachio treats',
            'Cultural stop at Nelson Castle and its lush English gardens'
        ],
        'included' => [
            'Noleggio E-Bike',
            'Guida cicloturistica',
            'Degustazione pistacchio',
            'Casco e assistenza tecnica'
        ],
        'included_en' => [
            'E-Bike rental',
            'Tour cycling guide',
            'Pistachio tasting experience',
            'Helmet and technical assistance'
        ],
        'excluded' => [
            'Biglietto ingresso interni Castello di Nelson',
            'Pranzo'
        ],
        'excluded_en' => [
            'Nelson Castle interior ticket',
            'Lunch'
        ],
        'schedule_dates' => ['2026-04-19', '2026-05-03', '2026-05-17', '2026-06-07', '2026-07-19', '2026-09-13', '2026-10-18']
    ],
    [
        'id' => 6,
        'slug' => 'escursione-in-bici-sui-nebrodi-da-randazzo-a-floresta',
        'type' => 'escursione',
        'category' => 'Escursioni Giornaliere',
        'category_en' => 'Day Excursions',
        'area' => 'Nebrodi',
        'area_tag' => 'nebrodi',
        'featured' => false,
        'title' => 'Da Randazzo a Floresta: Vivi la Sicilia più Verde',
        'title_en' => 'From Randazzo to Floresta: The Green Heart of Sicily',
        'subtitle' => 'Una salita verso il comune più alto della Sicilia (1.275m) tra pascoli incontaminati, boschi di faggio e tradizioni casearie millenarie.',
        'subtitle_en' => 'A ride to Sicily\'s highest village (1,275m) through pristine pastures, beech woods and ancient cheesemaking traditions.',
        'image' => 'assets/img/gallery/escursioni-in-bicicletta-sicilia-tour-in-bici-sicilia-escursioni-sulletna-escursioni-sui-nebrodi-escursioni-alcantara-42.jpg',
        'gallery' => [
            'assets/img/gallery/escursioni-in-bicicletta-sicilia-tour-in-bici-sicilia-escursioni-sulletna-escursioni-sui-nebrodi-escursioni-alcantara-42.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-sicilia-tour-in-bici-sicilia-escursioni-sulletna-escursioni-sui-nebrodi-escursioni-alcantara-58.jpg'
        ],
        'price' => 75,
        'price_note' => 'a persona (guida + e-bike + sosta provola inclusi)',
        'price_note_en' => 'per person (guide + e-bike + cheese stop included)',
        'duration' => '4-6 ore',
        'duration_en' => '4-6 hours',
        'days' => 1,
        'distance' => '46 km',
        'elevation' => '+1.100 m',
        'difficulty' => 'Medio',
        'difficulty_en' => 'Moderate',
        'start_location' => 'Randazzo',
        'season' => 'Maggio - Ottobre',
        'season_en' => 'May - October',
        'highlights' => [
            'Salita attraverso i boschi e le vallate selvagge dei Monti Nebrodi',
            'Arrivo a Floresta, il borgo più alto di Sicilia con aria purissima',
            'Assaggio della rinomata Provola dei Nebrodi DOP direttamente dai casari',
            'Viste spettacolari sui due mari e sul cono dell\'Etna'
        ],
        'highlights_en' => [
            'Climb through wild woods and green valleys of the Nebrodi Mountains',
            'Arrival in Floresta, the highest village in Sicily with pure mountain air',
            'Tasting of authentic Nebrodi PDO Provola cheese direct from local shepherds',
            'Spectacular vantage points over both seas and Mount Etna'
        ],
        'included' => [
            'E-Bike MTB performante',
            'Guida esperta del Parco dei Nebrodi',
            'Casco protettivo',
            'Degustazione formaggi tipici'
        ],
        'included_en' => [
            'High-performance E-MTB',
            'Nebrodi Park expert guide',
            'Protective helmet',
            'Local artisan cheese tasting'
        ],
        'excluded' => [
            'Pranzo completo'
        ],
        'excluded_en' => [
            'Full restaurant lunch'
        ],
        'schedule_dates' => ['2026-05-17', '2026-05-31', '2026-06-21', '2026-07-12', '2026-08-09', '2026-09-06', '2026-10-04']
    ],
    [
        'id' => 7,
        'slug' => 'escursione-in-bici-sui-nebrodi-dorsale',
        'type' => 'escursione',
        'category' => 'Escursioni Giornaliere',
        'category_en' => 'Day Excursions',
        'area' => 'Nebrodi',
        'area_tag' => 'nebrodi',
        'featured' => false,
        'title' => 'Escursione in E-Bike: Dorsale dei Nebrodi & Laghi',
        'title_en' => 'Nebrodi Ridge & Alpine Lakes E-Bike Excursion',
        'subtitle' => 'Una magnifica traversata lungo la dorsale dei Nebrodi, toccando i laghi d\'alta quota Maulazzo e Biviere.',
        'subtitle_en' => 'A magnificent ridge traverse touching the high altitude mountain lakes Maulazzo and Biviere.',
        'image' => 'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-68.jpg',
        'gallery' => [
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-68.jpg',
            'assets/img/gallery/IMG-20251008-WA0037.jpg',
            'assets/img/gallery/IMG-20251008-WA0029-scaled.jpg'
        ],
        'price' => 80,
        'price_note' => 'a persona (guida + e-bike biammortizzata)',
        'price_note_en' => 'per person (guide + full suspension e-bike)',
        'duration' => '5 ore',
        'duration_en' => '5 hours',
        'days' => 1,
        'distance' => '42 km',
        'elevation' => '+950 m',
        'difficulty' => 'Medio',
        'difficulty_en' => 'Moderate',
        'start_location' => 'Portella Femmina Morta (Cesarò)',
        'season' => 'Maggio - Ottobre',
        'season_en' => 'May - October',
        'highlights' => [
            'La grande dorsale montuosa della Sicilia verde',
            'Sosta ai laghi montani Maulazzo e Biviere, rifugio di aironi e uccelli migratori',
            'Faggete secolari e cavalli Sanfratellani al pascolo brado',
            'Aria freschissima e contatto totale con la natura'
        ],
        'highlights_en' => [
            'The legendary high mountain ridge of green Sicily',
            'Scenic stops at alpine lakes Maulazzo and Biviere',
            'Centuries-old beech trees and wild Sanfratellano horses grazing freely',
            'Pure refreshing mountain breeze and immersion in nature'
        ],
        'included' => [
            'Noleggio E-MTB biammortizzata',
            'Guida ciclistica del Parco',
            'Casco, kit forature, assistenza',
            'Assicurazione'
        ],
        'included_en' => [
            'Full-suspension E-MTB',
            'Park cycling guide',
            'Helmet, toolkit, assistance',
            'Insurance'
        ],
        'excluded' => [
            'Pranzo al sacco'
        ],
        'excluded_en' => [
            'Packed lunch'
        ],
        'schedule_dates' => ['2026-05-24', '2026-06-14', '2026-07-05', '2026-07-26', '2026-08-30', '2026-09-27']
    ],
    [
        'id' => 8,
        'slug' => 'tour-2-giorni-nebrodi-montalbano-elicona-alcantara',
        'type' => 'tour',
        'category' => 'Tour Itineranti & Weekend',
        'category_en' => 'Multi-Day Tours & Weekends',
        'area' => 'Nebrodi & Alcantara',
        'area_tag' => 'nebrodi',
        'featured' => true,
        'title' => 'Weekend in Sicilia: Randazzo, Megaliti dell\'Argimusco & Alcantara',
        'title_en' => 'Sicily Weekend: Megaliths of Argimusco, Nebrodi & Alcantara',
        'subtitle' => 'Un weekend tra storia, natura e mistero: pedalando tra i borghi più belli d\'Italia, la Stonehenge siciliana e le gole fluviali.',
        'subtitle_en' => 'A weekend between history, mystery and nature: riding through Italy\'s top heritage villages, the Sicilian Stonehenge and river canyons.',
        'image' => 'assets/img/gallery/IMG-20251008-WA0031-scaled.jpg',
        'gallery' => [
            'assets/img/gallery/IMG-20251008-WA0031-scaled.jpg',
            'assets/img/gallery/IMG-20251008-WA0036.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-106.jpg'
        ],
        'price' => 240,
        'price_note' => 'a persona (2 giorni / 1 notte in B&B / agriturismo + e-bike + guida)',
        'price_note_en' => 'per person (2 days / 1 night in agriturismo + e-bike + guide)',
        'duration' => '2 Giorni / 1 Notte',
        'duration_en' => '2 Days / 1 Night',
        'days' => 2,
        'distance' => '120 km',
        'elevation' => '+2.100 m',
        'difficulty' => 'Medio',
        'difficulty_en' => 'Moderate',
        'start_location' => 'Randazzo',
        'season' => 'Marzo - Novembre',
        'season_en' => 'March - November',
        'highlights' => [
            'Visita ai misteriosi Megaliti dell\'Argimusco, luogo sacro millenario',
            'Sosta nel borgo medievale di Montalbano Elicona con castello federiciano',
            'Pedalata lungo il corso del fiume Alcantara e le sue gole basaltiche',
            'Pernottamento in agriturismo tipico con cena a base di specialità locali'
        ],
        'highlights_en' => [
            'Visit the mystical Argimusco Megaliths, an ancient sacred stone site',
            'Explore medieval Montalbano Elicona with its Swabian-Aragonese castle',
            'Cycle along the Alcantara river and its deep basalt canyon',
            'Overnight in an authentic agriturismo with traditional dinner'
        ],
        'included' => [
            '2 giorni di noleggio E-Bike con batteria ad alta capacità',
            '1 notte con colazione in agriturismo/struttura caratteristica',
            'Guida cicloturistica per entrambi i giorni',
            'Furgone di supporto e trasporto bagagli',
            'Cena tipica del sabato sera con vino incluso',
            'Assicurazione medico/bagaglio'
        ],
        'included_en' => [
            '2 days E-Bike rental with high-capacity battery',
            '1 night accommodation with breakfast in charming agriturismo',
            'Full-time cycling guide for both days',
            'Support van and luggage transfer',
            'Traditional Saturday dinner with wine included',
            'Travel & injury insurance'
        ],
        'excluded' => [
            'Pranzi veloci lungo il percorso',
            'Spese personali'
        ],
        'excluded_en' => [
            'Light lunches on the route',
            'Personal extras'
        ],
        'schedule_dates' => ['2026-04-18', '2026-05-09', '2026-05-30', '2026-06-20', '2026-09-12', '2026-10-03', '2026-10-24']
    ],
    [
        'id' => 9,
        'slug' => 'tour-ebike-etna-sicilia-3-giorni',
        'type' => 'tour',
        'category' => 'Tour Itineranti & Weekend',
        'category_en' => 'Multi-Day Tours & Weekends',
        'area' => 'Etna & Borghi',
        'area_tag' => 'etna',
        'featured' => true,
        'title' => 'Tour 3 Giorni: Bike & Taste tra Etna, Randazzo & Bronte',
        'title_en' => '3-Day Tour: Bike & Taste around Etna, Randazzo & Bronte',
        'subtitle' => 'La circumnavigazione dell\'Etna in 3 tappe indimenticabili: sapori di cantina, boschi vulcanici e le colate più scenografiche.',
        'subtitle_en' => 'Circumnavigate Mount Etna in 3 stunning stages: winery tastings, volcanic woods and the most scenic lava flows.',
        'image' => 'assets/img/gallery/Etna-home-page.jpg',
        'gallery' => [
            'assets/img/gallery/Etna-home-page.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-113.jpg',
            'assets/img/gallery/PXL_20250704_081536971.MP_-scaled.jpg'
        ],
        'price' => 390,
        'price_note' => 'a persona (3 giorni / 2 notti in mezza pensione + e-bike + guida)',
        'price_note_en' => 'per person (3 days / 2 nights half board + e-bike + guide)',
        'duration' => '3 Giorni / 2 Notti',
        'duration_en' => '3 Days / 2 Nights',
        'days' => 3,
        'distance' => '160 km',
        'elevation' => '+3.200 m',
        'difficulty' => 'Medio',
        'difficulty_en' => 'Moderate',
        'start_location' => 'Randazzo (Anello Completo)',
        'season' => 'Marzo - Novembre',
        'season_en' => 'March - November',
        'highlights' => [
            'Tappa 1: Versante Nord, la Pineta Ragabo e la Grotta dei Lamponi',
            'Tappa 2: Versante Est, Milo e le celebri cantine dell\'Etna DOC',
            'Tappa 3: Versante Ovest, le lave cordate e i pistacchieti di Bronte',
            'Pernottamenti in relais di charme e cene gourmet tipiche'
        ],
        'highlights_en' => [
            'Stage 1: North slope, Ragabo pine forest and Raspberry Cave',
            'Stage 2: East slope, Milo village and renowned Etna DOC wine estates',
            'Stage 3: West slope, ropey lava fields and Bronte pistachio groves',
            'Overnights in charming countryside relais with authentic gourmet dinners'
        ],
        'included' => [
            '3 giorni di noleggio E-MTB biammortizzata',
            '2 notti in camera doppia con colazione in relais/agriturismi',
            '2 cene tipiche gourmet con vini del vulcano',
            'Guida cicloturistica certificata per tutte le tappe',
            'Van di appoggio al seguito e trasporto valigie',
            'Assicurazione completa'
        ],
        'included_en' => [
            '3 days full-suspension E-MTB rental',
            '2 nights in double room with breakfast in charming country relais',
            '2 typical gourmet dinners with Etna volcano wines',
            'Certified cycling guide for all stages',
            'Support van with luggage transport between stages',
            'Comprehensive insurance'
        ],
        'excluded' => [
            'Pranzi leggeri a mezzogiorno',
            'Supplemento singola'
        ],
        'excluded_en' => [
            'Light midday lunches',
            'Single room supplement'
        ],
        'schedule_dates' => ['2026-04-24', '2026-05-15', '2026-06-05', '2026-06-26', '2026-09-18', '2026-10-09', '2026-10-30']
    ],
    [
        'id' => 10,
        'slug' => 'tour-ebike-etna-nebrodi-sicilia-4giorni',
        'type' => 'tour',
        'category' => 'Tour Itineranti & Weekend',
        'category_en' => 'Multi-Day Tours & Weekends',
        'area' => 'Nebrodi & Etna',
        'area_tag' => 'nebrodi',
        'featured' => false,
        'title' => 'Grand Tour 4 Giorni: Cicloturismo tra Parco dei Nebrodi ed Etna',
        'title_en' => '4-Day Grand Tour: Cycling between Nebrodi Park & Mount Etna',
        'subtitle' => 'Una grande traversata tra la Sicilia più verde e selvaggia e le imponenti quote vulcaniche dell\'Etna.',
        'subtitle_en' => 'A grand mountain traverse between wild green Sicily and the majestic volcano elevations of Etna.',
        'image' => 'assets/img/gallery/IMG-20251008-WA0024.jpg',
        'gallery' => [
            'assets/img/gallery/IMG-20251008-WA0024.jpg',
            'assets/img/gallery/IMG-20251008-WA0029-scaled.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-106.jpg'
        ],
        'price' => 520,
        'price_note' => 'a persona (4 giorni / 3 notti mezza pensione + e-bike + van)',
        'price_note_en' => 'per person (4 days / 3 nights half board + e-bike + van)',
        'duration' => '4 Giorni / 3 Notti',
        'duration_en' => '4 Days / 3 Nights',
        'days' => 4,
        'distance' => '210 km',
        'elevation' => '+4.100 m',
        'difficulty' => 'Medio / Impegnativo',
        'difficulty_en' => 'Moderate / Challenging',
        'start_location' => 'Cesarò -> Floresta -> Randazzo -> Etna',
        'season' => 'Maggio - Ottobre',
        'season_en' => 'May - October',
        'highlights' => [
            'Attraversamento dell\'intera Dorsale dei Nebrodi con i suoi laghi',
            'Sosta nei borghi autentici di Cesarò, Floresta e Randazzo',
            'Salita sulle piste d\'alta quota dell\'Etna fino a 2.000 metri',
            'Esperienze gastronomiche uniche: Provola DOP, Maialino Nero e Vini DOC'
        ],
        'highlights_en' => [
            'Traversing the entire high Nebrodi ridge with its alpine lakes',
            'Overnights in untouched mountain hamlets: Cesarò, Floresta, Randazzo',
            'High altitude Etna climb up to 2,000 meters above sea level',
            'Signature gourmet experiences: Nebrodi Black Pig, PDO cheeses, DOC wines'
        ],
        'included' => [
            '4 giorni noleggio E-Bike Full Suspension',
            '3 notti con colazione e 3 cene tipiche',
            'Guida ciclistica esperta per l\'intero tour',
            'Mezzo di supporto al seguito, trasporto bagagli e ricariche batterie',
            'Assicurazione infortuni e assistenza'
        ],
        'included_en' => [
            '4 days Full-Suspension E-Bike rental',
            '3 nights with breakfast and 3 traditional dinners',
            'Expert cycling guide for the whole expedition',
            'Support vehicle, luggage transfer and battery recharge logistics',
            'Full insurance'
        ],
        'excluded' => [
            'Pranzi a buffet lungo i sentieri',
            'Voli / treni per la Sicilia'
        ],
        'excluded_en' => [
            'Light lunch snacks along trails',
            'Flights / trains to Sicily'
        ],
        'schedule_dates' => ['2026-05-21', '2026-06-11', '2026-07-02', '2026-09-03', '2026-09-24', '2026-10-15']
    ],
    [
        'id' => 11,
        'slug' => 'tour-isole-eolie-bici-barca-5giorni',
        'type' => 'tour',
        'category' => 'Tour Itineranti & Weekend',
        'category_en' => 'Multi-Day Tours & Weekends',
        'area' => 'Isole Eolie',
        'area_tag' => 'isole',
        'featured' => true,
        'title' => 'Cicloturismo alle Isole Eolie: Bici & Barca tra Mare e Vulcani',
        'title_en' => 'Aeolian Islands Bike & Boat: Cycling between Sea & Volcanoes',
        'subtitle' => 'Una vacanza da sogno a pedali navigando tra Lipari, Vulcano, Salina e Stromboli con e-bike e barca privata.',
        'subtitle_en' => 'A dream cycling & sailing holiday hopping between Lipari, Vulcano, Salina and Stromboli on private boat.',
        'image' => 'assets/img/gallery/Immagine-WhatsApp-2025-04-06-ore-09.21.16_3d0a628f.jpg',
        'gallery' => [
            'assets/img/gallery/Immagine-WhatsApp-2025-04-06-ore-09.21.16_3d0a628f.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-106.jpg'
        ],
        'price' => 790,
        'price_note' => 'a persona (5 giorni / 4 notti + barca + e-bike + guida + hotel)',
        'price_note_en' => 'per person (5 days / 4 nights + boat + e-bike + guide + hotels)',
        'duration' => '5 Giorni / 4 Notti',
        'duration_en' => '5 Days / 4 Nights',
        'days' => 5,
        'distance' => '220 km',
        'elevation' => '+3.500 m',
        'difficulty' => 'Medio',
        'difficulty_en' => 'Moderate',
        'start_location' => 'Milazzo / Lipari',
        'season' => 'Aprile - Maggio & Settembre - Ottobre',
        'season_en' => 'April - May & September - October',
        'highlights' => [
            'Lipari: il periplo dell\'isola tra scogliere bianche di pomice e tramonti',
            'Vulcano: salita al Gran Cratere della Fossa e bagni nelle acque termali',
            'Salina: la verde isola del film "Il Postino", la Malvasia e i capperi',
            'Navigazione privata in caicco/barca con tuffi nelle calette più segrete'
        ],
        'highlights_en' => [
            'Lipari: island circumference ride past white pumice cliffs and sunset lookouts',
            'Vulcano: hiking/riding to the Gran Cratere and relaxing in geothermal hot springs',
            'Salina: the lush island of "Il Postino" movie, sweet Malvasia wine and capers',
            'Private boat cruising with refreshing swims in secluded turquoise coves'
        ],
        'included' => [
            '5 giorni noleggio E-Bike',
            '4 notti in hotel 3*/4* con colazione sulle isole',
            'Tutti i trasferimenti marittimi in barca / aliscafo con trasporto bici',
            'Guida esperta per tutto il viaggio',
            'Degustazione Malvasia e prodotti tipici a Salina',
            'Assistenza e assicurazione'
        ],
        'included_en' => [
            '5 days E-Bike rental',
            '4 nights in 3*/4* hotels with breakfast on the islands',
            'All boat / ferry island transfers with bike transport',
            'Full-time expert local guide',
            'Malvasia wine and local specialty tasting in Salina',
            'Assistance and insurance'
        ],
        'excluded' => [
            'Cene libere nei tipici ristorantini isolani',
            'Tassa di soggiorno comunale'
        ],
        'excluded_en' => [
            'Dinners at typical island seaside restaurants',
            'City tourist tax'
        ],
        'schedule_dates' => ['2026-04-29', '2026-05-20', '2026-06-10', '2026-09-09', '2026-09-30', '2026-10-14']
    ],
    [
        'id' => 12,
        'slug' => 'sicilia-ebike-citta-barocche-spiagge-val-di-noto',
        'type' => 'tour',
        'category' => 'Tour Itineranti & Weekend',
        'category_en' => 'Multi-Day Tours & Weekends',
        'area' => 'Val di Noto & Sud Est',
        'area_tag' => 'barocco',
        'featured' => true,
        'title' => 'Barocco Siciliano & Costa: 7 Giorni di Bellezza nella Val di Noto',
        'title_en' => 'Sicilian Baroque & Coastline: 7 Days in Val di Noto',
        'subtitle' => 'Un viaggio da favola tra le meraviglie UNESCO di Noto, Modica, Scicli, Ragusa Ibla e la riserva marina di Vendicari.',
        'subtitle_en' => 'A fairytale ride through the UNESCO Baroque marvels of Noto, Modica, Scicli, Ragusa Ibla and Vendicari reserve.',
        'image' => 'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-106.jpg',
        'gallery' => [
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-106.jpg',
            'assets/img/gallery/escursioni-in-bicicletta-Sicilia-escursioni-in-bicicletta-elettrica-Sicilia-Escursioni-in-bici-Sicilia-Orientale-Escursioni-sullEtna-Escursione-sui-Nebrodi-Escursioni-Madonie-113.jpg',
            'assets/img/gallery/PXL_20250704_081536971.MP_-scaled.jpg'
        ],
        'price' => 890,
        'price_note' => 'a persona (7 giorni / 6 notti in dimore storiche + e-bike + guida + van)',
        'price_note_en' => 'per person (7 days / 6 nights in historic stays + e-bike + guide + van)',
        'duration' => '7 Giorni / 6 Notti',
        'duration_en' => '7 Days / 6 Nights',
        'days' => 7,
        'distance' => '280 km',
        'elevation' => '+2.500 m',
        'difficulty' => 'Medio / Facile',
        'difficulty_en' => 'Moderate / Easy',
        'start_location' => 'Siracusa / Noto',
        'season' => 'Marzo - Giugno & Settembre - Novembre',
        'season_en' => 'March - June & September - November',
        'highlights' => [
            'I gioielli barocchi Patrimonio UNESCO: Noto, Scicli, Modica e Ragusa Ibla',
            'Degustazione del celebre Cioccolato artigianale di Modica lavorato a freddo',
            'Pedalata tra i fenicotteri della Riserva di Vendicari e l\'antica tonnara',
            'Sosta marinara nel suggestivo borgo di pescatori di Marzamemi'
        ],
        'highlights_en' => [
            'UNESCO Baroque masterpieces: Noto, Scicli, Modica and Ragusa Ibla',
            'Tasting of the world-famous cold-pressed Aztec chocolate in Modica',
            'Coastal ride among flamingos in Vendicari Nature Reserve and ancient tuna fishery',
            'Seaside stop at the postcard-perfect fishing hamlet of Marzamemi'
        ],
        'included' => [
            '7 giorni di noleggio E-Bike touring/gravel di alta gamma',
            '6 notti con colazione in boutique hotel e dimore storiche',
            'Guida cicloturistica e culturale al seguito',
            'Furgone di assistenza, scopa e trasporto bagagli da hotel a hotel',
            'Visite guidate e degustazioni di prodotti tipici (cioccolato, vino, formaggi)',
            'Assicurazione completa'
        ],
        'included_en' => [
            '7 days premium touring/gravel E-Bike rental',
            '6 nights with breakfast in boutique hotels and historic estates',
            'Professional cycling and cultural guide',
            'Support van, mechanical assistance and hotel-to-hotel luggage transport',
            'Guided visits and signature tastings (Modica chocolate, Nero d\'Avola wine)',
            'Comprehensive insurance'
        ],
        'excluded' => [
            'Pranzi e cene non specificati',
            'Voli per Catania/Comiso'
        ],
        'excluded_en' => [
            'Unspecified lunches and dinners',
            'Flights to Catania/Comiso'
        ],
        'schedule_dates' => ['2026-04-18', '2026-05-09', '2026-05-30', '2026-09-12', '2026-10-03', '2026-10-24']
    ]
];
