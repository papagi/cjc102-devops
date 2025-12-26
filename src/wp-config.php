<?php
// 1. 本地除錯設定 (上線前可改為 false)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. 資料庫設定 (優先讀取環境變數)
define( 'DB_NAME',     getenv('WORDPRESS_DB_NAME') ?: 'wordpress' );
define( 'DB_USER',     getenv('WORDPRESS_DB_USER') ?: 'root' );
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'rootpassword' );
define( 'DB_HOST',     getenv('WORDPRESS_DB_HOST') ?: 'db' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

// 3. AWS ALB SSL 修正 (防止無限重新導向)
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// 4. 動態網址設定
if (isset($_SERVER['HTTP_HOST'])) {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    define('WP_HOME', $protocol . $_SERVER['HTTP_HOST']);
    define('WP_SITEURL', $protocol . $_SERVER['HTTP_HOST']);
}

// 5. 權限控制 (本地開發允許安裝外掛，AWS 上鎖定)
define( 'DISALLOW_FILE_MODS', getenv('WORDPRESS_LOCK_MODS') === 'true' );
define( 'DISALLOW_FILE_EDIT', true );
define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', false );

$table_prefix = 'wp_';

// Debug 開關
define( 'WP_DEBUG', getenv('WORDPRESS_DEBUG') === 'true' );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

// 【重要】這行必須在檔案的最下方
require_once ABSPATH . 'wp-settings.php';