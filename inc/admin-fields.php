<?php

defined( 'ABSPATH' ) || exit;

// Add fields to the attachment details
add_filter('attachment_fields_to_edit', function ($form_fields, $post) {
    // Add a Text Field for "source"
    $form_fields['source'] = [
        'label' => 'Source for Imprint',
        'input' => 'text',
        'value' => get_post_meta($post->ID, 'source', true),
    ];

    // Add the "source-pin" checkbox
    $form_fields['source-pin'] = [
        'input' => 'html',
        'html' => '
            <div class="imprint-source-pin">
                <label>
                    <input type="checkbox" name="attachments[' . $post->ID . '][source-pin]" value="1" ' . checked(get_post_meta($post->ID, 'source-pin', true), 1, false) . ' style="vertical-align:text-bottom"/> Pin in the list
                </label>
            </div>
        ',
    ];

    return $form_fields;
}, 10, 2);


// Add the buttons to manipulate the "Source" content
add_action('admin_enqueue_scripts', function($hook) {

    if ($hook !== 'media-upload.php' && $hook !== 'media.php' && $hook !== 'upload.php') { return; }

    $name = 'imprint-source-buttons';

    $script_contents = file_get_contents( FCMTI_DIR . 'assets/meta-buttons.js' );
    wp_register_script( $name, '' );
    wp_enqueue_script( $name );
    wp_add_inline_script( $name, $script_contents );

    $style_content = file_get_contents( FCMTI_DIR . 'assets/meta-buttons.css' );
    wp_register_style( $name, false );
    wp_enqueue_style( $name );
    wp_add_inline_style( $name, $style_content );
}, 20);


// Save the field values
add_filter('attachment_fields_to_save', function ($post, $attachment) {

    if (isset($attachment['source'])) {
        update_post_meta($post['ID'], 'source', $attachment['source']);
    } else {
        delete_post_meta($post['ID'], 'source');
    }

    if (isset($attachment['source-pin']) && $attachment['source-pin'] === '1') {
        update_post_meta($post['ID'], 'source-pin', '1');
    } else {
        delete_post_meta($post['ID'], 'source-pin');
    }

    return $post;
}, 10, 2);