plugin.tx_felogin_pi1 {
  restorePasswordPageUid = {$pages.restorePasswordPageUid}
  templateFile = EXT:gbfelogin/Resources/Private/Templates/FrontendLogin.html
  forgotResetMessageEmailSentMessage_stdWrap.htmlSpecialChars = 0

  errorMessage_stdWrap {
    required = 1
    wrap = <div class="error-text">|</div>
    htmlSpecialChars = 1
  }


  linkConfig.useCacheHash = 1

  _CSS_DEFAULT_STYLE >
}

GbfloginLogin = PAGE
GbfloginLogin {

  typeNum = 103

  config {
    disableAllHeaderCode = 1
    xhtml_cleaning = none
    admPanel = 0
    metaCharset = utf-8
    additionalHeaders {
      10 {
        header = Content-Type:text/html;charset=utf-8
      }
    }
    disablePrefixComment = 1
    debug = 0
    no_cache = 1
  }

  10 < plugin.tx_felogin_pi1
  10 {

    templateFile = EXT:gbfelogin/Resources/Private/Templates/FrontendLoginBox.html

    # location of member records
    storagePid = {$pages.fontendUsersFolderUid}

    # set redirect options as per felogin documentation
    redirectMode =

    #set other options as per felogin documentation
    showPermaLogin = 1
    showForgotPasswordLink = 1
    wrapContentInBaseClass = 0



  }



}