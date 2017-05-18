[loginUser = *]
    lib.topnavigation.myaccount = COA
    lib.topnavigation.myaccount {

        wrap = <li><a>{LLL:EXT:gbbase/Resources/Private/Language/locallang.xlf:my_gigabonus}</a>|</li>
        wrap.insertData = 1

        20 = HMENU
        20 {
            special = list
            special.value = {$pages.changeUserDataPageUid},{$pages.changeUserPasswordPageUid},{$pages.transactionListPageUid}, {$pages.payOutPageUid}
            1 = TMENU
            1 {
                NO = 1
                NO.wrapItemAndSub = <li>|</li>
                NO.stdWrap.field = subtitle // title

                ACT < .NO
                ACT.wrapItemAndSub = <li class="active">|</li>

                wrap = <ul class="menu vertical">|</ul>
            }
        }

    }
[else]
    lib.topnavigation.myaccount = COA
    lib.topnavigation.myaccount {
        10 = TEXT
        10.value (
            <li><a data-signup-button>{LLL:EXT:gbbase/Resources/Private/Language/locallang.xlf:registration}</a></li>
            <li><a data-login-button>{LLL:EXT:gbbase/Resources/Private/Language/locallang.xlf:login}</a></li>
        )
        10.insertData = 1
    }
[global]



### myaccount navigation on the left side
lib.sidenavigation.myaccount = COA
lib.sidenavigation.myaccount {
    10 = HMENU
    10 {

        special = directory
        special.value.data = leveluid:1
        entryLevel = 1

        1 = TMENU
        1 {
            NO = 1
            NO {
                wrapItemAndSub = <li>|</li>
                stdWrap.field = subtitle // title
            }

            ACT < .NO
            ACT.wrapItemAndSub = <li class="active">|</li>
        }

        wrap = <ul>|</ul>
    }

}


lib.sidenavigation.categoryList = USER
lib.sidenavigation.categoryList {
    userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
    extensionName = Gbpartner
    pluginName = Categorylisting
    vendorName = Gigabonus
    controller = Category
    action = list
    switchableControllerActions {
        Category {
            1 = list
        }
    }

    persistence < plugin.tx_gbpartner_categorylisting.persistence

}

## don't show the category navigation if any page from myaccount is active
[PIDinRootline = 2]
    lib.page.navigation.sidenavigation < lib.sidenavigation.myaccount
[else]
    lib.page.navigation.sidenavigation < lib.sidenavigation.categoryList
[global]

