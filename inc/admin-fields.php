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

    // Add buttons to insert symbols to the "Source" field and the "source-pin" checkbox
    $form_fields['insert-symbols'] = [
        'input' => 'html',
        'html' => '
            <div style="display:flex;justify-content:flex-end">
                <label style="margin-right:auto">
                    <input type="checkbox" name="attachments[' . $post->ID . '][source-pin]" value="1" ' . checked(get_post_meta($post->ID, 'source-pin', true), 1, false) . ' style="vertical-align:text-bottom"/> Pin in the list
                </label>
                <button type="button" class="insert-symbol button" data-symbol="&copy;">&copy;</button>
                <button type="button" class="insert-symbol button" data-symbol="&trade;">&trade;</button>
                <button type="button" class="insert-symbol button" data-symbol="&reg;">&reg;</button>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $(".insert-symbol").on("click", function() {
                        const symbol = $(this).data("symbol");
                        const textArea = $(".compat-field-source input");
                        const startPos = textArea[0].selectionStart;
                        const endPos = textArea[0].selectionEnd;
                        const text = textArea.val();

                        // Save the cursor position
                        const initialCursorPosition = textArea[0].selectionStart + 1;

                        const newText = text.substring(0, startPos) + symbol + text.substring(endPos, text.length);
                        textArea.val(newText).focus();

                        // Restore the cursor position
                        textArea[0].setSelectionRange(initialCursorPosition, initialCursorPosition);
                        $(textArea).change(); // Trigger the change event to simulate saving
                    });
                });
        </script>
        ',
    ];

    return $form_fields;
}, 10, 2);

// Save the field values
add_filter('attachment_fields_to_save', function ($post, $attachment) {
    if (isset($attachment['source'])) {
        update_post_meta($post['ID'], 'source', $attachment['source']);
    }

    // Check if the checkbox is checked, and set its value accordingly
    if (isset($attachment['source-pin']) && $attachment['source-pin'] == '1') {
        update_post_meta($post['ID'], 'source-pin', '1');
    } else {
        delete_post_meta($post['ID'], 'source-pin');
    }

    return $post;
}, 10, 2);