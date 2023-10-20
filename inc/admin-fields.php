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

    // Add the buttons to manipulate the "Source" content every time the meta appears
    $script_contents = file_get_contents( FCMTI_DIR . 'assets/meta-buttons.js' );
    $form_fields['source-pin']['html'] .= '<script>'.$script_contents.'</script>';

    $style_content = file_get_contents( FCMTI_DIR . 'assets/meta-buttons.css' );
    $form_fields['source-pin']['html'] .= '<style>'.$style_content.'</style>';


    return $form_fields;
}, 10, 2);


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