<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../config/config.php';
}

$pageTitle = $pageTitle ?? (SITE_NAME . ' - ' . SITE_TAGLINE);
$pageDescription = $pageDescription ?? SITE_DESCRIPTION;
$pageImage = $pageImage ?? (BASE_URL . '/assets/img/gallery/summit.jpg');
$canonicalUrl = $canonicalUrl ?? ('https://www.sicilybiketours.it' . $_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="<?= CURRENT_LANG === 'en' ? 'en' : 'it' ?>" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    
    <!-- Open Graph / Social Meta -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= SITE_NAME ?>">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($pageImage) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($pageImage) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/img/logo/logo.png">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css?v=2.1">
    
    <!-- FontAwesome 6 Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js Core -->
    <script defer src="<?= BASE_URL ?>/assets/js/alpine.min.js"></script>

    <!-- Schema.org JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SportsActivityLocation",
      "name": "Sicily Bike Tours",
      "image": "<?= BASE_URL ?>/assets/img/gallery/summit.jpg",
      "@id": "https://www.sicilybiketours.it",
      "url": "https://www.sicilybiketours.it",
      "telephone": "<?= CONTACT_PHONE ?>",
      "email": "<?= CONTACT_EMAIL ?>",
      "priceRange": "€€",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Via Bonaventura, 66",
        "addressLocality": "Randazzo",
        "addressRegion": "CT",
        "postalCode": "95036",
        "addressCountry": "IT"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 37.8767,
        "longitude": 14.9458
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
          "Sunday"
        ],
        "opens": "08:00",
        "closes": "20:00"
      },
      "sameAs": [
        "<?= INSTAGRAM_URL ?>",
        "<?= FACEBOOK_URL ?>"
      ]
    }
    </script>
</head>
<body x-data="{ 
    mobileMenuOpen: false, 
    scrolled: false,
    bookingModalOpen: false,
    selectedTour: null,
    openBooking(tour) {
        this.selectedTour = tour;
        this.bookingModalOpen = true;
    }
}" @scroll.window="scrolled = (window.pageYOffset > 40)">
