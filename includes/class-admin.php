<?php

/**
 * Admin Menu
 */
class TH_Admin {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/
        add_menu_page( __( 'Books', 'th' ), __( 'Books', 'th' ), 'manage_options', 'th-books', array( $this, 'plugin_page' ), 'dashicons-book-alt', 3 );

        add_submenu_page( 'th-books', __( 'Books', 'th' ), __( 'Books', 'th' ), 'manage_options', 'th-books', array( $this, 'plugin_page' ) );
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/book-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/book-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/book-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/book-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}
