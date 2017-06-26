# Zentral für alle Plugins

// Template für pagination widget
// config.tx_extbase.view.widget.TYPO3\CMS\Fluid\ViewHelpers\Widget\PaginateViewHelper.templateRootPath = EXT:gbbase/Resources/Private/Templates/

# Nur für ein bestimmtes Plugin
# plugin.fluid.view.widget.TYPO3\CMS\Fluid\ViewHelpers\Widget\PaginateViewHelper.templateRootPath = EXT:gbbase/Resources/Private/Templates/



### custom layout for content elements
lib.fluidContent.layoutRootPaths.30 = EXT:gbbase/Resources/Private/Layouts/fluid_styled_content

page = PAGE
page.typeNum = 0

page.meta.viewport = initial-scale=1, minimum-scale=1, maximum-scale=1


config.pageTitleFirst = 1
config.pageTitleSeparator.noTrimWrap = | | |

page.10 = FLUIDTEMPLATE
page.10 {
    format = html
    file = EXT:gbbase/Resources/Private/Templates/Page/Layouts/MainTemplate.html
    partialRootPath = EXT:gbbase/Resources/Private/Templates/Page/Partials/
    layoutRootPath = EXT:gbbase/Resources/Private/Templates/Page/Layouts/
}


page.10.file.stdWrap.cObject = CASE
page.10.file.stdWrap.cObject {
    key.data = levelfield:-1, backend_layout_next_level, slide
    key.override.field = backend_layout

    default = TEXT
    default.value = EXT:gbbase/Resources/Private/Templates/Page/Layouts/MainTemplate.html

    2 = TEXT
    2.value = EXT:gbbase/Resources/Private/Templates/Page/Layouts/TwoColumnWidthLeftNaviTemplate.html


}


### Tracking Pixel Page
[globalVar = TSFE:id = {$pages.trackingPixelPageUid}]
    page >
    page = PAGE
    page {
        config {
            disableAllHeaderCode = 1
            debug = 0
            no_cache = 1

            disableCharsetHeader = 1
        }

        10 < tt_content.list.20.gborderapi_tracking
        10 = USER_INT
        10 {

        persistence < plugin.tx_gborderapi_pi1.persistence

        }
    }
[end]

### Tracking Pixel Page
[globalVar = TSFE:id = 41]
    page >
    page = PAGE
    page {
        config {
            disableAllHeaderCode = 1
            debug = 0
            no_cache = 1

            additionalHeaders {
                10 {
                    # header = Content-Type: application/json
                    replace = 1
                }
            }

            disableCharsetHeader = 1
        }

        10 < tt_content.list.20.gborderapi_pi1
        10 = USER_INT
        10 {

            persistence < plugin.tx_gborderapi_pi1.persistence

        }
    }
[end]
