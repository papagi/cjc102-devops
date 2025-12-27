<?php
/** WordPress 的基礎設定檔案 */

// 1. 資料庫設定 - 從環境變數讀取
define( 'DB_NAME',     getenv('WORDPRESS_DB_NAME') ?: 'wordpress' ); // 補上這行
define( 'DB_USER',     getenv('WORDPRESS_DB_USER') ?: 'root' );
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'rootpassword' );
define( 'DB_HOST',     getenv('WORDPRESS_DB_HOST') ?: 'db' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

// 2. 身份認證唯一金鑰 (建議可由環境變數注入，或保持預設)
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

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

// 5. 權限與安全控制
define( 'DISALLOW_FILE_MODS', getenv('WORDPRESS_LOCK_MODS') === 'true' );
define( 'DISALLOW_FILE_EDIT', true );
define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', false );

$table_prefix = 'wp_';

// 6. Debug 開關 - 【建議目前強制設為 true 排查問題】
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** 載入 WordPress 設定與定義變數 */
require_once ABSPATH . 'wp-settings.php';
