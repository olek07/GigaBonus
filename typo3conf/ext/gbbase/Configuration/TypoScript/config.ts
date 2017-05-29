config {
   # no_cache = 1
    doctype = html5
    sys_language_uid = 0
    language = ru
    locale_all = ru_RU.UTF-8
    htmlTag_setParams = lang="ru-UA" class="nojs"
    defaultGetVars.L  = 0
    linkVars = L(0-1)
    tx_realurl_enable = 1
    absRefPrefix = /
    simulateStaticDocuments = 0
    pageTitleSeparator = - Кэшбэк-система
}


### Ukrainian language ###
[globalVar = GP:L=1]
    config.sys_language_uid = 1
    config.language = uk
    config.locale_all = uk_UA.UTF-8
    config.htmlTag_setParams = lang="uk" class="nojs"
    config.pageTitleSeparator = - Кешбек-система
[global]


### There is the Partnerlist plugin only 1 time on the page, only in the default language. 
### The partners for the entry page are same for all languages
[globalVar = TSFE:id = {$pages.partnerListUid}]
    config.sys_language_overlay = 1
    config.sys_language_mode = content_fallback
[global]