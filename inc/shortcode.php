<?php

defined( 'ABSPATH' ) || exit;

add_shortcode('media_sources_list', function () {
    global $wpdb;

    // get the sources list, faster with query than WP_Query()
    $results = $wpdb->get_col( $wpdb->prepare('
        SELECT sources.meta_value
        FROM '.$wpdb->posts.'
            LEFT JOIN '.$wpdb->postmeta.' AS sources
                ON ID = sources.post_id AND sources.meta_key = %s
            LEFT JOIN '.$wpdb->postmeta.' AS pins
                ON ID = pins.post_id AND pins.meta_key = %s
        WHERE post_type = %s
            AND sources.meta_value IS NOT NULL
            AND sources.meta_value != ""
        ORDER BY COALESCE(pins.meta_value, 0) DESC, sources.meta_value ASC
    ', 'source', 'source-pin', 'attachment'));

    if ( empty( $results ) ) { return ''; }
    
    return '<ul class="imprint-list">' . implode( '', array_map( function($a) { return '<li>' . esc_html($a) . '</li>'; }, $results ) ) . '</ul>';

});