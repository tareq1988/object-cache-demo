<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class TH_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
        add_action( 'admin_post_th_delete_book', array( $this, 'delete_book' ) );
    }

    /**
     * Delete a book
     *
     * @return void
     */
    public function delete_book() {
        if ( ! current_user_can( 'manage_options' ) ) {
            die( __( 'Are you cheating?', 'th' ) );
        }

        $redirect_to = admin_url( 'admin.php?page=th-books' );
        $book_id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        th_delete_book( $book_id );

        wp_safe_redirect( $redirect_to );
        exit;
    }

    /**
     * Handle the book new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'nonce' ) ) {
            die( __( 'Are you cheating?', 'th' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'th' ) );
        }

        $errors       = array();
        $page_url     = admin_url( 'admin.php?page=th-books' );
        $field_id     = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $name         = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $author       = isset( $_POST['author'] ) ? sanitize_text_field( $_POST['author'] ) : '';
        $isbn         = isset( $_POST['isbn'] ) ? intval( $_POST['isbn'] ) : 0;
        $edition      = isset( $_POST['edition'] ) ? sanitize_text_field( $_POST['edition'] ) : '';
        $pages        = isset( $_POST['pages'] ) ? intval( $_POST['pages'] ) : 0;
        $language     = isset( $_POST['language'] ) ? sanitize_text_field( $_POST['language'] ) : '';
        $publish_date = isset( $_POST['publish_date'] ) ? sanitize_text_field( $_POST['publish_date'] ) : '';

        // some basic validation
        if ( ! $name ) {
            $errors[] = __( 'Error: Name is required', 'th' );
        }

        if ( ! $author ) {
            $errors[] = __( 'Error: Author is required', 'th' );
        }

        if ( ! $isbn ) {
            $errors[] = __( 'Error: ISBN Number is required', 'th' );
        }

        if ( ! $edition ) {
            $errors[] = __( 'Error: Edition is required', 'th' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'name' => $name,
            'author' => $author,
            'isbn' => $isbn,
            'edition' => $edition,
            'pages' => $pages,
            'language' => $language,
            'publish_date' => $publish_date,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = th_insert_book( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = th_insert_book( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}
