<INCLUDE_TYPOSCRIPT: source="FILE:EXT:gbbase/Configuration/TypoScript/config.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:gbbase/Configuration/TypoScript/lib.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:gbbase/Configuration/TypoScript/langMenu.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:gbbase/Configuration/TypoScript/femanager.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:gbfelogin/Configuration/TypoScript/setup.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:gbbase/Configuration/TypoScript/includejs.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:gbbase/Configuration/TypoScript/includecss.ts">


page = PAGE
page.typeNum = 0

page.5 < lib.langMenu
page.10 = FLUIDTEMPLATE
page.10 {
    format = html
    file = EXT:gbbase/Resources/Private/Templates/Page/Layouts/MainTemplate.html
    partialRootPath = EXT:gbbase/Resources/Private/Templates/Page/Partials/
    # layoutRootPath = typo3conf/ext/gbbase/Resources/Private/Templates/Page/Layouts/
}
