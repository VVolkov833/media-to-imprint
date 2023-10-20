jQuery(document).ready(function($) {

    const symbols = [
        { symbolText: '&copy;' },
        { symbolText: '&trade;' },
        { symbolText: '&reg;' },
    ];

    const createSymbolButton = symbolText => (
        $('<button>')
            .attr('type', 'button')
            .addClass('insert-symbol button')
            .html(symbolText)
            .on('click', insertSymbol)
    );

    const $symbolButtonsContainer = $('.imprint-source-pin');
    const $textField = $('.compat-field-source input');

    const insertSymbol = e => {
        const $button = $(e.target);
        const symbol = $button.html();

        const text = $textField.val();

        // Get the selection to restore the cursor
        const startPos = $textField[0].selectionStart;
        const endPos = $textField[0].selectionEnd;

        // Save the cursor position
        const initialCursorPosition = $textField[0].selectionStart;
        const newCursorPosition = initialCursorPosition + symbol.length;

        // Insert the updated text
        const newText = text.substring(0, startPos) + symbol + text.substring(endPos, text.length);
        $textField.val(newText).focus();

        // Restore the cursor position
        $textField[0].setSelectionRange(newCursorPosition, newCursorPosition);

        // Trigger the change event to simulate saving
        $($textField).change();
    };

    // Run
    symbols.forEach(symbol => {
        const $button = createSymbolButton(symbol.symbolText);
        $symbolButtonsContainer.append($button);
    });

});