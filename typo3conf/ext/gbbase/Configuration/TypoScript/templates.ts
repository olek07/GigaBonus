# Zentral für alle Plugins
// Template für pagination widget
config.tx_extbase.view.widget.TYPO3\CMS\Fluid\ViewHelpers\Widget\PaginateViewHelper.templateRootPath = EXT:gbbase/Resources/Private/Templates/

# Nur für ein bestimmtes Plugin
# plugin.fluid.view.widget.TYPO3\CMS\Fluid\ViewHelpers\Widget\PaginateViewHelper.templateRootPath = EXT:gbbase/Resources/Private/Templates/


lib.fluidContent.layoutRootPaths.30 = EXT:gbbase/Resources/Private/Layouts/fluid_styled_content

page = PAGE
page.typeNum = 0

page.10 < lib.langMenu

page.30 = FLUIDTEMPLATE
page.30 {
    format = html
    file = EXT:gbbase/Resources/Private/Templates/Page/Layouts/MainTemplate.html
    partialRootPath = EXT:gbbase/Resources/Private/Templates/Page/Partials/
    # layoutRootPath = typo3conf/ext/gbbase/Resources/Private/Templates/Page/Layouts/
}
