<?php
$currentScript = basename($_SERVER['PHP_SELF']);

$menusFile = BASE_PATH . '/data/menus.json';
$menuData = file_exists($menusFile) ? json_decode(file_get_contents($menusFile), true) ?: [] : [];

$headerMenu = $menuData['header_menu'] ?? [
    [ 'id' => 'home', 'title_it' => 'Home', 'title_en' => 'Home', 'url' => '', 'type' => 'link' ],
    [ 'id' => 'about', 'title_it' => 'Chi Siamo', 'title_en' => 'About Us', 'url' => 'chi-siamo.php', 'type' => 'link' ],
    [
        'id' => 'experiences',
        'title_it' => 'Esperienze',
        'title_en' => 'Experiences',
        'type' => 'dropdown',
        'children' => [
            [ 'title_it' => 'Escursioni Giornaliere', 'title_en' => 'Day Trips', 'url' => 'escursioni.php', 'icon' => 'sun' ],
            [ 'title_it' => 'Tour Itineranti', 'title_en' => 'Multi-day Tours', 'url' => 'tour.php', 'icon' => 'calendar-days' ],
            [ 'title_it' => 'Tour su Misura', 'title_en' => 'Custom Tour', 'url' => 'personalizza-tour.php', 'icon' => 'sliders' ]
        ]
    ],
    [ 'id' => 'custom', 'title_it' => 'Su Misura', 'title_en' => 'Custom Tour', 'url' => 'personalizza-tour.php', 'type' => 'link' ],
    [ 'id' => 'magazine', 'title_it' => 'Magazine', 'title_en' => 'Magazine', 'url' => 'magazine.php', 'type' => 'link' ],
    [ 'id' => 'contact', 'title_it' => 'Contatti', 'title_en' => 'Contact', 'url' => 'contatti.php', 'type' => 'link' ]
];

$ctaBtn = $menuData['cta_button'] ?? [
    'text_it' => 'Prenota Ora',
    'text_en' => 'Book Now',
    'url' => 'personalizza-tour.php'
];

$ctaText = CURRENT_LANG === 'en' ? ($ctaBtn['text_en'] ?? 'Book Now') : ($ctaBtn['text_it'] ?? 'Prenota Ora');
$ctaUrl = $ctaBtn['url'] ?? 'personalizza-tour.php';
$ctaLink = str_starts_with($ctaUrl, 'http') ? $ctaUrl : (empty($ctaUrl) ? BASE_URL . '/' : BASE_URL . '/' . ltrim($ctaUrl, '/'));
?>
<!-- Main Header / Navbar -->
<header class="site-navbar" :class="{ 'scrolled': scrolled }">
    <div class="container">
        <div class="navbar-inner">
            <!-- Brand Logo -->
            <a href="<?= BASE_URL ?>/" class="navbar-brand">
                <img src="<?= BASE_URL ?>/assets/img/logo/logo-light.png" x-show="!scrolled" alt="<?= SITE_NAME ?>" class="navbar-brand-logo">
                <img src="<?= BASE_URL ?>/assets/img/logo/logo.png" x-show="scrolled" style="display: none;" alt="<?= SITE_NAME ?>" class="navbar-brand-logo">
            </a>

            <!-- Desktop Menu -->
            <nav>
                <ul class="nav-menu">
                    <?php foreach ($headerMenu as $item): 
                        $itemTitle = CURRENT_LANG === 'en' ? ($item['title_en'] ?? $item['title_it']) : $item['title_it'];
                        $itemUrl = $item['url'] ?? '';
                        $itemLink = str_starts_with($itemUrl, 'http') ? $itemUrl : (empty($itemUrl) ? BASE_URL . '/' : BASE_URL . '/' . ltrim($itemUrl, '/'));
                        $isActive = ($currentScript === basename($itemUrl)) || (empty($itemUrl) && in_array($currentScript, ['index.php', '']));
                    ?>
                        <?php if (($item['type'] ?? 'link') === 'dropdown'): 
                            $children = $item['children'] ?? [];
                            $childScripts = array_map(function($c) { return basename($c['url'] ?? ''); }, $children);
                            $isDropdownActive = in_array($currentScript, $childScripts) || in_array($currentScript, ['tour-dettaglio.php']);
                        ?>
                            <li class="nav-item-dropdown" x-data="{ open: false, timer: null }" @mouseenter="clearTimeout(timer); open = true" @mouseleave="timer = setTimeout(() => { open = false }, 200)">
                                <a href="javascript:void(0)" class="nav-link dropdown-toggle <?= $isDropdownActive ? 'active' : '' ?>" @click.prevent="open = !open">
                                    <?= htmlspecialchars($itemTitle) ?> <i class="fa-solid fa-chevron-down" style="font-size: 0.72rem; margin-left: 0.35rem;"></i>
                                </a>
                                <ul class="dropdown-menu" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" style="display: none;">
                                    <?php foreach ($children as $c): 
                                        $cTitle = CURRENT_LANG === 'en' ? ($c['title_en'] ?? $c['title_it']) : $c['title_it'];
                                        $cUrl = $c['url'] ?? '';
                                        $cLink = str_starts_with($cUrl, 'http') ? $cUrl : (empty($cUrl) ? BASE_URL . '/' : BASE_URL . '/' . ltrim($cUrl, '/'));
                                        $cIcon = $c['icon'] ?? 'circle';
                                    ?>
                                        <li>
                                            <a href="<?= htmlspecialchars($cLink) ?>" class="dropdown-item">
                                                <i class="fa-solid fa-<?= htmlspecialchars($cIcon) ?>" style="color: var(--color-accent); margin-right: 0.5rem;"></i>
                                                <?= htmlspecialchars($cTitle) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?= htmlspecialchars($itemLink) ?>" class="nav-link <?= $isActive ? 'active' : '' ?>">
                                    <?= htmlspecialchars($itemTitle) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Actions & Lang Switcher -->
            <div class="nav-actions">
                <!-- Language Selector -->
                <div class="lang-switcher">
                    <a href="?lang=it" class="lang-btn <?= CURRENT_LANG === 'it' ? 'active' : '' ?>" title="Italiano">IT</a>
                    <a href="?lang=en" class="lang-btn <?= CURRENT_LANG === 'en' ? 'active' : '' ?>" title="English">EN</a>
                </div>

                <a href="<?= htmlspecialchars($ctaLink) ?>" class="btn btn-accent btn-sm btn-book-nav">
                    <i class="fa-solid fa-calendar-check"></i> <?= htmlspecialchars($ctaText) ?>
                </a>

                <!-- Mobile Toggle -->
                <button class="mobile-toggle" @click="mobileMenuOpen = true" aria-label="Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Flyout Drawer -->
<div class="drawer-backdrop" x-show="mobileMenuOpen" x-transition.opacity @click="mobileMenuOpen = false" style="display: none;"></div>
<div class="mobile-drawer" :class="{ 'open': mobileMenuOpen }" style="display: none;" x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="transform translate-x-full" x-transition:enter-end="transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="transform translate-x-0" x-transition:leave-end="transform translate-x-full">
    <div class="drawer-header">
        <a href="<?= BASE_URL ?>/">
            <img src="<?= BASE_URL ?>/assets/img/logo/logo.png" alt="<?= SITE_NAME ?>" style="height: 38px;">
        </a>
        <button class="modal-close-btn" @click="mobileMenuOpen = false">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <ul class="drawer-nav" x-data="{ mobileExpOpen: false }">
        <?php foreach ($headerMenu as $item): 
            $itemTitle = CURRENT_LANG === 'en' ? ($item['title_en'] ?? $item['title_it']) : $item['title_it'];
            $itemUrl = $item['url'] ?? '';
            $itemLink = str_starts_with($itemUrl, 'http') ? $itemUrl : (empty($itemUrl) ? BASE_URL . '/' : BASE_URL . '/' . ltrim($itemUrl, '/'));
        ?>
            <?php if (($item['type'] ?? 'link') === 'dropdown'): 
                $children = $item['children'] ?? [];
            ?>
                <li>
                    <div style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; user-select: none;" class="drawer-link" :class="{ 'text-primary': mobileExpOpen }" @click="mobileExpOpen = !mobileExpOpen">
                        <span><?= htmlspecialchars($itemTitle) ?></span>
                        <i class="fa-solid" :class="mobileExpOpen ? 'fa-chevron-up' : 'fa-chevron-down'" style="font-size: 0.85rem; color: var(--color-primary); transition: transform 0.2s ease;"></i>
                    </div>
                    <div x-show="mobileExpOpen" x-collapse x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-150" class="drawer-submenu-list" style="display: none;">
                        <?php foreach ($children as $c): 
                            $cTitle = CURRENT_LANG === 'en' ? ($c['title_en'] ?? $c['title_it']) : $c['title_it'];
                            $cUrl = $c['url'] ?? '';
                            $cLink = str_starts_with($cUrl, 'http') ? $cUrl : (empty($cUrl) ? BASE_URL . '/' : BASE_URL . '/' . ltrim($cUrl, '/'));
                            $cIcon = $c['icon'] ?? 'circle';
                        ?>
                            <a href="<?= htmlspecialchars($cLink) ?>" class="drawer-submenu-item" @click="mobileMenuOpen = false">
                                <span class="drawer-submenu-icon">
                                    <i class="fa-solid fa-<?= htmlspecialchars($cIcon) ?>"></i>
                                </span>
                                <span><?= htmlspecialchars($cTitle) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?= htmlspecialchars($itemLink) ?>" class="drawer-link" @click="mobileMenuOpen = false">
                        <?= htmlspecialchars($itemTitle) ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

    <div style="margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--color-gray-100);">
        <div class="lang-switcher" style="margin-bottom: 1.2rem; justify-content: center;">
            <a href="?lang=it" class="lang-btn <?= CURRENT_LANG === 'it' ? 'active' : '' ?>">Italiano</a>
            <a href="?lang=en" class="lang-btn <?= CURRENT_LANG === 'en' ? 'active' : '' ?>">English</a>
        </div>
        <a href="<?= htmlspecialchars($ctaLink) ?>" class="btn btn-accent btn-sm" style="width: 100%; margin-bottom: 0.75rem;" @click="mobileMenuOpen = false">
            <i class="fa-solid fa-calendar-check"></i> <?= htmlspecialchars($ctaText) ?>
        </a>
        <a href="https://wa.me/<?= WA_NUMBER ?>" target="_blank" class="btn btn-sm" style="width: 100%; background: #25D366; color: #ffffff; font-weight: 700; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);">
            <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i> WhatsApp Info
        </a>
    </div>
</div>

