<?php
/**
 * SICILY BIKE TOURS - WordPress & Remote Hosting Connection Config (Template)
 * Rinominare questo file in config/wordpress.php e inserire le credenziali effettive.
 */

define('WP_SITE_URL', 'https://www.sicilybiketours.it');
define('WP_ADMIN_URL', 'https://www.sicilybiketours.it/wp-admin/');
define('WP_REST_API_URL', 'https://www.sicilybiketours.it/wp-json/wp/v2');

// Credenziali WordPress
define('WP_ADMIN_USER', 'wp_admin_user');
define('WP_ADMIN_PASS', 'wp_admin_password');

// Credenziali Hosting Aruba
define('ARUBA_FTP_HOST', 'ftp.sicilybiketours.it');
define('ARUBA_FTP_USER', 'username@aruba.it');
define('ARUBA_FTP_PASS', 'password');
define('ARUBA_FTP_PORT', 21);
define('ARUBA_SERVER_IP', '89.46.110.34');

// Database MySQL Aruba
define('DB_REMOTE_HOST', '89.46.111.213');
define('DB_REMOTE_USER', 'Sql1782786');
define('DB_REMOTE_PASS', 'password');
define('DB_REMOTE_NAMES', [
    'Sql1782786_1',
    'Sql1782786_2',
    'Sql1782786_3',
    'Sql1782786_4',
    'Sql1782786_5'
]);

function wp_check_connection($force = false) {
    return ['status' => 'mock', 'message' => 'Template config'];
}
