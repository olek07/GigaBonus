lib.langMenu = HMENU
lib.langMenu {
        special = language
        special.value = 0,1
        special.normalWhenNoLanguage = 0
        1 = TMENU
        1 {
                # Normal link to language that exists:
                NO = 1
                # NO.allWrap = |*| | *  |*| |
                NO.linkWrap = <b style="background-color : grey"> | </b><br>
                NO.stdWrap.setCurrent = Русский || Украинский
                NO.stdWrap.current = 1

                # Current language selected:
                ACT < .NO
                ACT.linkWrap = <b style="background-color : red"> | </b><br>

                # Language that is NOT available:
                USERDEF1 < .NO
                USERDEF1.linkWrap = <span style="background-color : yellow"> | </span><br>
                USERDEF1.doNotLinkIt = 1
        }
}