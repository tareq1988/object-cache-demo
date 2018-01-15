<?php

/**
 * Get all book
 *
 * @param $args array
 *
 * @return array
 */
function th_get_all_book( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args         = wp_parse_args( $args, $defaults );

    $last_changed = wp_cache_get_last_changed( 'books' );
    $cache_group  = 'books';
    $key          = md5( serialize( array_diff_assoc( $args, $defaults ) ) );
    $cache_key    = "get_all_book:$key:$last_changed";
    $items        = wp_cache_get( $cache_key, $cache_group );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'books ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, $cache_group );
    }

    return $items;
}

/**
 * Fetch all book from database
 *
 * @return array
 */
function th_get_book_count() {
    global $wpdb;

    $count = wp_cache_get( 'count', 'books' );

    if ( false === $count ) {
        $count = (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'books' );

        wp_cache_set( 'count', $count, 'books' );
    }

    return ;
}

/**
 * Fetch a single book from database
 *
 * @param int   $id
 *
 * @return array
 */
function th_get_book( $id = 0 ) {
    global $wpdb;

    $book = wp_cache_get( $id, 'books' );

    if ( false === $book ) {
        $book = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'books WHERE id = %d', $id ) );

        wp_cache_set( $id, $book, 'books' );
    }

    return $book;
}


/**
 * Insert a new book
 *
 * @param array $args
 */
function th_insert_book( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'name' => '',
        'author' => '',
        'isbn' => '',
        'edition' => '',
        'pages' => '',
        'language' => '',
        'publish_date' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'books';

    // some basic validation
    if ( empty( $args['name'] ) ) {
        return new WP_Error( 'no-name', __( 'No Name provided.', 'th' ) );
    }
    if ( empty( $args['author'] ) ) {
        return new WP_Error( 'no-author', __( 'No Author provided.', 'th' ) );
    }
    if ( empty( $args['isbn'] ) ) {
        return new WP_Error( 'no-isbn', __( 'No ISBN Number provided.', 'th' ) );
    }
    if ( empty( $args['edition'] ) ) {
        return new WP_Error( 'no-edition', __( 'No Edition provided.', 'th' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    // invalidate the caches
    th_clear_book_cache( $row_id );

    if ( ! $row_id ) {

        $args['created_at'] = current_time( 'mysql' );

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}

/**
 * Delete a book
 *
 * @param  integer $book_id
 *
 * @return integer|false
 */
function th_delete_book( $book_id ) {
    global $wpdb;

    th_clear_book_cache( $book_id );

    return $wpdb->delete( $wpdb->prefix . 'books', array( 'id' => $book_id ), array( '%d' ) );
}

/**
 * Clear the book cache
 *
 * @param  integer $book_id
 *
 * @return void
 */
function th_clear_book_cache( $book_id ) {
    wp_cache_delete( $book_id, 'books' );

    wp_cache_delete( 'count', 'books' );
    wp_cache_set( 'last_changed', microtime(), 'books' );
}
