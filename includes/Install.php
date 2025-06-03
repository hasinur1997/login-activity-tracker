<?php
namespace Hasinur\LoginActivityTracker;

/**
 * Install class.
 */
class Install {
    /**
     * Install hook.
     *
     * @return void
     */
    public static function run(): void {
        global $wpdb;
        $table_name = $wpdb->prefix . 'login_activity';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            username VARCHAR(60) NOT NULL,
            login_status VARCHAR(20) NOT NULL,
            ip_address VARCHAR(45) NOT NULL,
            location VARCHAR(100) DEFAULT NULL,
            device VARCHAR(50) DEFAULT NULL,
            user_agent TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
}
