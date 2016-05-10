<?php
/*
  Plugin Name: wp-profile
  Description: Plugin profile for wordpress 
  Version: 0.1
  Author: Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
  Author URI: http://kuznik.tk
  License: GPLv2
 */

/**
 * Install
 */
function profileExtends_install( ) {
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'user_extends';
    $db_version = "1.0";

    if ($wpdb->get_var("SHOW TABLES LIKE '" . $$table . "'") != $table) {
        $query = "CREATE TABLE " . $table . " ( 
        id int(9) NOT NULL AUTO_INCREMENT, 
        userid int(9),
        picture varchar(100);
        PRIMARY KEY  (id),
        INDEX `profile_extends_userid` (`userid`),
        CONSTRAINT `profile_extends_userid`
            FOREIGN KEY (`userid`)
            REFERENCES `" . $prefix . "users` (`ID`)
        ) DEFAULT CHARSET=utf8";

        $wpdb->query($query);

    }
    
    add_option("pe_db_version", $db_version);
    add_option( 'pe_speed', '2000' );
    add_option( 'pe_interval', '2000');
    add_option( 'pe_type', 'vertical');
}
register_activation_hook(__FILE__, 'profileExtends_install');

/**
 * Uninstall
 */
function profileExtends_uninstall( ) {
    global $wpdb;
    $prefix = $wpdb->prefix;

    $table = $prefix . 'user_extends';

    $query ='DROP TABLE '.$table;
    $wpdb->query($query);
}
register_deactivation_hook(__FILE__, 'profileExtends_uninstall');


add_action('admin_menu', function ( ) {
    add_users_page('Profile extends', 'Profile extends', 'read', 'profile-extends-id', function( ) {
        if ( isset($_GET['action']) && $_GET['action'] == 'save_profile' ) {
            require __DIR__ . '/upload.php';
        } else {
            require __DIR__ . '/html/profile-extends.php';
        }
    });
});
