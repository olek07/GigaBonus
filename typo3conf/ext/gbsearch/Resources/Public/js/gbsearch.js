Gbsearch = {

    lang: 0,
    form: null,

    init: function () {

        var obj = this;

        obj.initSuggestSearch();

    },

    // rendering of the items in the suggest menu
    renderItem: function( ul, item ) {
        return $("<li>")
            .attr("data-value", item.value )
            .append('<b>' + item.label + '</b> ' + item.teaser)
            .appendTo(ul);
    },

    initSuggestSearch: function() {
        var suggestSearchField = $('#search_field');
        if (suggestSearchField.length == 0) return;

        var obj = this;
        var entityFound = true;
        var entityName = suggestSearchField.val();

        suggestSearchField.autocomplete({
            source      : '/index.php?type=126&L=' + Layout.currentLanguage,
            minLength   : 3,
            delay       : 300,
            html        : true,
            select: function(event, ui) {
                location.href = ui.item.url;
            },

            // wurde etwas gefunden?
            response: function( event, ui ) {
                if (ui.content.length == 0) entityFound = false;
            }
        }).data("ui-autocomplete")._renderItem = obj.renderItem;

        suggestSearchField.keydown(function(){
           // if (entityName !== suggestSearchField.val().trim()) $('#search_field').val(0);
        })

    }
}
