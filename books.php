<?php
/**
 * Plugin Name: Object Cache Books Demo
 * Description: A demo plugin to demonstrate persistent object caching with WordPress
 * Plugin URI: https://tareq.co
 * Author: Tareq Hasan
 * Author URI: https://tareq.co
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Books_Demo class
 *
 * @class Books_Demo The class that holds the entire Books_Demo plugin
 */
class Books_Demo {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0';

    /**
     * Constructor for the Books_Demo class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {

        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        $this->includes();
        $this->init_classes();
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'BOOKS_PLUGIN_VERSION', $this->version );
        define( 'BOOKS_PLUGIN_FILE', __FILE__ );
        define( 'BOOKS_PLUGIN_PATH', dirname( BOOKS_PLUGIN_FILE ) );
        define( 'BOOKS_PLUGIN_INCLUDES', BOOKS_PLUGIN_PATH . '/includes' );
        define( 'BOOKS_PLUGIN_URL', plugins_url( '', BOOKS_PLUGIN_FILE ) );
        define( 'BOOKS_PLUGIN_ASSETS', BOOKS_PLUGIN_URL . '/assets' );
    }

    /**
     * Initializes the Books_Demo() class
     *
     * Checks for an existing Books_Demo() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Books_Demo();
        }

        return $instance;
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {
        global $wpdb;

        $collate = '';

        if ( $wpdb->has_cap( 'collation' ) ) {
            if ( ! empty($wpdb->charset ) ) {
                $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
            }

            if ( ! empty($wpdb->collate ) ) {
                $collate .= " COLLATE $wpdb->collate";
            }
        }

        $table_schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}books` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) DEFAULT NULL,
            `author` varchar(255) DEFAULT NULL,
            `isbn` varchar(100) DEFAULT NULL,
            `edition` varchar(100) DEFAULT NULL,
            `pages` int(11) DEFAULT NULL,
            `language` varchar(255) DEFAULT NULL,
            `publish_date` datetime DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) $collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $table_schema );

        update_option( 'booksplugin_version', BOOKS_PLUGIN_VERSION );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {
        require_once BOOKS_PLUGIN_INCLUDES . '/class-admin.php';
        require_once BOOKS_PLUGIN_INCLUDES . '/class-book-list-table.php';
        require_once BOOKS_PLUGIN_INCLUDES . '/class-form-handler.php';

        require_once BOOKS_PLUGIN_INCLUDES . '/functions.php';
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_classes() {
        new TH_Admin();
        new TH_Form_Handler();
    }

} // Books_Demo

Books_Demo::init();
