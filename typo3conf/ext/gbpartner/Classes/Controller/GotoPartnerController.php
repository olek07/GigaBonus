<?php
namespace Gigabonus\Gbpartner\Controller;

use Gigabonus\Gbbase\Utility\Helpers\MainHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GotoPartnerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {


    /**
     * @var \Gigabonus\Gbpartner\Utility\Token
     * @inject
     */
    protected $token = null;


    /**
     *
     * 'go-to-partner' page. gets by using ajax the session id and token from the partner website
     *
     *
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner|null $partner
     */
    public function gotoPartnerAction(\Gigabonus\Gbpartner\Domain\Model\Partner $partner = null) {

        $t = GeneralUtility::_GET('t');

        if ($partner == NULL || $GLOBALS['TSFE']->fe_user->user == NULL || $t == '') {
            MainHelper::redirect2Home();
        }

        $partnerId = $partner->getUid();
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];


        if ($res = $this->token->getToken($t)) {

            if ($res['partner'] == $partnerId && $res['user'] == $userId) {
                $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);

                $landingPage = urlencode('/index.php?id=51');
                # $landingPage = '';

                $url = $partner->getWebsiteUrl() . '/go.php?uid=' . $userId . '&url=' . $landingPage;

                $pageRenderer->addJsFooterInlineCode('', "
                    var url = '$url';
                    $(document).ready(function(){
                        $(document).on(Layout.EVENT_INIT_FORMS, function() {
                            Gbpartner.init();
                            Gbpartner.reloadOpener();
                            Gbpartner.gotoPartner('$t', $partnerId);
                        });
                        $(document).trigger(Layout.EVENT_INIT_FORMS);
                    });
                    "
                );

                $this->view->assign('url', $url);
                $this->view->assign('partner', $partner);

            } else {
                MainHelper::redirect2Home();
            }

        }
    }


}