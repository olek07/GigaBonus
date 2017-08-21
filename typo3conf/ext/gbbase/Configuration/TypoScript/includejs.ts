config {
    concatenateJs = 1
#    concatenateCss = 0

    compressJs = 0
#    compressCss = 0
}

### config.inlineStyle2TempFile = 1
### config.sendCacheHeaders = 1

page.includeJSLibs {
    qjuery = EXT:gbbase/Resources/Public/Scripts/Libs/jquery-2.2.4.min.js
    qjueryui = EXT:gbbase/Resources/Public/Scripts/Libs/jquery-ui.min.js
    qjueryform = EXT:gbbase/Resources/Public/Scripts/Libs/jquery.form.min.js
    autocomplete = EXT:gbbase/Resources/Public/Scripts/Libs/jquery.ui.autocomplete.html.js
}

page.includeJS {
    gbfemanager = EXT:gbfemanager/Resources/Public/js/gbfemanager.js
    gbtransactions = EXT:gbaccount/Resources/Public/js/transactions.js
    gbpartner = EXT:gbpartner/Resources/Public/js/gbpartner.js
    gbsearch = EXT:gbsearch/Resources/Public/js/gbsearch.js
}

page.includeJSFooterlibs {
    whatinput = EXT:gbbase/Resources/Public/Scripts/Libs/what-input.js
    foundation = EXT:gbbase/Resources/Public/Scripts/Libs/foundation.min.js
    app = EXT:gbbase/Resources/Public/Scripts/app.js
}