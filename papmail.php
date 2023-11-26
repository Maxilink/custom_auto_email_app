<?php


// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class_exists( 'WeDevs\WeMail\WeMail' ) || require_once __DIR__ . '/vendor/autoload.php';

use WeDevs\WeMail\WeMail;

define( 'WEMAIL_FILE', __FILE__ );
define( 'WEMAIL_PATH', dirname( WEMAIL_FILE ) );

/**
 * Init the wemail plugin
 *
 * @since 1.0.0
 *
 * @return WeMail
 */
function wemail() {
    return WeMail::instance();
}

// kick it off
wemail();

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_wemail() {
    if ( ! class_exists( 'Appsero\Client' ) ) {
        require_once __DIR__ . '/appsero/src/Client.php';
    }

    $client = new Appsero\Client( '2452f1cc-57eb-4e54-b027-1b5a2957d066', 'weMail', __FILE__ );

    // Active insights
    $client->insights()->hide_notice()->init();
}

appsero_init_tracker_wemail();

/**
 * Add custom links in activation tab of wemail
 */
function wemail_plugin_action_links( $links ) {
    $links = array_merge(
        [
            '<a href="https://getwemail.io/docs/wemail/get-started/?utm_source=orgplugin&utm_medium=dashboarddoc&utm_campaign=settinglink" target="_blank">' . __( 'Docs', 'wemail' ) . '</a>',
            '<a href="https://getwemail.io/contact?utm_source=orgplugin&utm_medium=dashboardcontact&utm_campaign=settinglink" target="_blank">' . __( 'Support', 'wemail' ) . '</a>',
            '<a href="https://getwemail.io/?utm_source=site-plugin-settings&utm_medium=website-url" target="_blank">' . __( 'Visit Site', 'wemail' ) . '</a>',
        ],
        $links
    );

    return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wemail_plugin_action_links' );
