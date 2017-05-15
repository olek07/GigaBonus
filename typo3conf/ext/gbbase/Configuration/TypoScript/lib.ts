lib.footerNavi = HMENU
lib.footerNavi {
    special = directory
    special.value = {$pages.footerNaviUid}
    1 = TMENU
    1 {
        NO{
            wrapItemAndSub = &nbsp;|&nbsp;
            stdWrap.field = subtitle // title
        }
    }

}


# render main content colPos 0
lib.contentDefaultTemplate < styles.content.get
