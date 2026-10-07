<?php
$currentScript = basename($_SERVER['PHP_SELF']);
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
                    <li><a href="<?= BASE_URL ?>/" class="nav-link <?= $currentScript === 'index.php' ? 'active' : '' ?>"><?= t('nav_home') ?></a></li>
                    <li><a href="<?= BASE_URL ?>/chi-siamo.php" class="nav-link <?= $currentScript === 'chi-siamo.php' ? 'active' : '' ?>"><?= t('nav_about') ?></a></li>
                    
                    <!-- Esperienze Dropdown (senza link diretto) -->
                    <li class="nav-item-dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle <?= in_array($currentScript, ['escursioni.php', 'tour.php', 'personalizza-tour.php', 'tour-dettaglio.php']) ? 'active' : '' ?>" @click.prevent="open = !open">
                            <?= CURRENT_LANG === 'en' ? 'Experiences' : 'Esperienze' ?> <i class="fa-solid fa-chevron-down" style="font-size: 0.72rem; margin-left: 0.35rem;"></i>
                        </a>
                        <ul class="dropdown-menu" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" style="display: none;">
                            <li><a href="<?= BASE_URL ?>/escursioni.php" class="dropdown-item"><i class="fa-solid fa-sun" style="color: var(--color-accent); margin-right: 0.5rem;"></i> <?= t('nav_excursions') ?></a></li>
                            <li><a href="<?= BASE_URL ?>/tour.php" class="dropdown-item"><i class="fa-solid fa-calendar-days" style="color: var(--color-accent); margin-right: 0.5rem;"></i> <?= t('nav_tours') ?></a></li>
                            <li><a href="<?= BASE_URL ?>/personalizza-tour.php" class="dropdown-item"><i class="fa-solid fa-sliders" style="color: var(--color-accent); margin-right: 0.5rem;"></i> <?= t('nav_custom') ?></a></li>
                        </ul>
                    </li>

                    <li><a href="<?= BASE_URL ?>/magazine.php" class="nav-link <?= $currentScript === 'magazine.php' || $currentScript === 'articolo.php' ? 'active' : '' ?>"><?= t('nav_magazine') ?></a></li>
                    <li><a href="<?= BASE_URL ?>/#calendario" class="nav-link"><?= t('nav_calendar') ?></a></li>
                    <li><a href="<?= BASE_URL ?>/contatti.php" class="nav-link <?= $currentScript === 'contatti.php' ? 'active' : '' ?>"><?= t('nav_contact') ?></a></li>
                </ul>
            </nav>

            <!-- Actions & Lang Switcher -->
            <div class="nav-actions">
                <!-- Language Selector -->
                <div class="lang-switcher">
                    <a href="?lang=it" class="lang-btn <?= CURRENT_LANG === 'it' ? 'active' : '' ?>" title="Italiano">IT</a>
                    <a href="?lang=en" class="lang-btn <?= CURRENT_LANG === 'en' ? 'active' : '' ?>" title="English">EN</a>
                </div>

                <a href="<?= BASE_URL ?>/personalizza-tour.php" class="btn btn-accent btn-sm btn-book-nav">
                    <i class="fa-solid fa-calendar-check"></i> <?= t('nav_book_now') ?>
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
        <li><a href="<?= BASE_URL ?>/" class="drawer-link" @click="mobileMenuOpen = false"><?= t('nav_home') ?></a></li>
        <li><a href="<?= BASE_URL ?>/chi-siamo.php" class="drawer-link" @click="mobileMenuOpen = false"><?= t('nav_about') ?></a></li>
        
        <!-- Mobile Esperienze Accordion -->
        <li>
            <div style="display: flex; justify-content: space-between; align-items: center;" class="drawer-link" @click="mobileExpOpen = !mobileExpOpen">
                <span><?= CURRENT_LANG === 'en' ? 'Experiences' : 'Esperienze' ?></span>
                <i class="fa-solid" :class="mobileExpOpen ? 'fa-chevron-up' : 'fa-chevron-down'" style="font-size: 0.8rem;"></i>
            </div>
            <div x-show="mobileExpOpen" style="padding-left: 1rem; display: none;">
                <a href="<?= BASE_URL ?>/escursioni.php" class="drawer-link" style="font-size: 0.95rem; opacity: 0.9;" @click="mobileMenuOpen = false"><i class="fa-solid fa-sun" style="color: var(--color-accent); width: 20px;"></i> <?= t('nav_excursions') ?></a>
                <a href="<?= BASE_URL ?>/tour.php" class="drawer-link" style="font-size: 0.95rem; opacity: 0.9;" @click="mobileMenuOpen = false"><i class="fa-solid fa-calendar-days" style="color: var(--color-accent); width: 20px;"></i> <?= t('nav_tours') ?></a>
                <a href="<?= BASE_URL ?>/personalizza-tour.php" class="drawer-link" style="font-size: 0.95rem; opacity: 0.9;" @click="mobileMenuOpen = false"><i class="fa-solid fa-sliders" style="color: var(--color-accent); width: 20px;"></i> <?= t('nav_custom') ?></a>
            </div>
        </li>

        <li><a href="<?= BASE_URL ?>/magazine.php" class="drawer-link" @click="mobileMenuOpen = false"><?= t('nav_magazine') ?></a></li>
        <li><a href="<?= BASE_URL ?>/#calendario" class="drawer-link" @click="mobileMenuOpen = false"><?= t('nav_calendar') ?></a></li>
        <li><a href="<?= BASE_URL ?>/contatti.php" class="drawer-link" @click="mobileMenuOpen = false"><?= t('nav_contact') ?></a></li>
    </ul>

    <div style="margin-top: auto; padding-top: 2rem;">
        <div class="lang-switcher" style="margin-bottom: 1.2rem; justify-content: center;">
            <a href="?lang=it" class="lang-btn <?= CURRENT_LANG === 'it' ? 'active' : '' ?>">Italiano</a>
            <a href="?lang=en" class="lang-btn <?= CURRENT_LANG === 'en' ? 'active' : '' ?>">English</a>
        </div>
        <a href="<?= BASE_URL ?>/personalizza-tour.php" class="btn btn-accent btn-sm" style="width: 100%; margin-bottom: 0.75rem;">
            <i class="fa-solid fa-calendar-check"></i> <?= t('nav_book_now') ?>
        </a>
        <a href="https://wa.me/<?= WA_NUMBER ?>" target="_blank" class="btn btn-outline-white btn-sm" style="width: 100%;">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp Info
        </a>
    </div>
</div>
