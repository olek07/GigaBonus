<?php
namespace Gigabonus\Gbpartner\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Alexander Averbuch <alav@gmx.net>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use Gigabonus\Gbbase\Utility\Helpers\MainHelper;
use Gigabonus\Gbpartner\Domain\Repository\PartnerRepository;
use Gigabonus\Gbpartner\Utility\Token;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * PartnerController
 */
class PartnerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * partnerRepository
     * 
     * @var \Gigabonus\Gbpartner\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = NULL;


    /**
     * @var \Gigabonus\Gbpartner\Utility\Token
     * @inject
     */
    protected $token = null;


    /**
     * action ajaxList
     *
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $category
     *
     * @return void
     */
    public function ajaxListAction(\Gigabonus\Gbpartner\Domain\Model\Category $category = null) {
        // $partners = $this->partnerRepository->findAll();
        $this->view->assign('category', $category);

    }

    
    /**
     * action list
     *
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $category
     * 
     * @return void
     */
    public function listAction(\Gigabonus\Gbpartner\Domain\Model\Category $category = null)
    {

        $partners = NULL;

        // if the partner entry page called
        if ($category === NULL) {
            $partners = $this->partnerRepository->findByUidList(ArrayUtility::integerExplode(',', $this->settings['partners']));
        }


        if ($category !== NULL) {
            MainHelper::setTitleTag($category->getName());
        }
        else {
            MainHelper::setTitleTag('Наши партнёры');
        }

        $this->view->assign('partnerDetailPageUid', MainHelper::PARTNERDETAILPAGEID);
        $this->view->assign('category', $category);
        $this->view->assign('partners', $partners);
    }
    
    /**
     * action show
     * 
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $category
     * @return void
     */
    public function showAction(\Gigabonus\Gbpartner\Domain\Model\Partner $partner = null, \Gigabonus\Gbpartner\Domain\Model\Category $category = null)
    {

        if ($GLOBALS['TSFE']->fe_user->user != NULL) {
            $userLoggedIn = true;
        }
        else {
            $userLoggedIn = false;
        }
        
        if ($partner == NULL) {
            $this->forward('list', null, null, $this->request->getArguments());
        }
        else {

            $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);

            $pageRenderer->addJsFooterInlineCode('',"
            $(document).ready(function(){
                $(document).on(Layout.EVENT_INIT_FORMS, function() {
                    Gbpartner.init();
                });
                $(document).trigger(Layout.EVENT_INIT_FORMS);
            });
            "
            );

            MainHelper::setTitleTag($partner->getName());
            $this->generateCanonicalTag($partner);
            $this->view->assign('category', $category);
            $this->view->assign('partner', $partner);
            $this->view->assign('userLoggedIn', $userLoggedIn);
        }
    }


    /**
     * action generateGotoLink. Generates the link to the 'go-to-partner' page with ?t=token_xxxxxxxxxxxxx
     *
     * @return void
     */
    public function generateGotoLinkAction() {

        $partnerId = (int)GeneralUtility::_GET('tx_gbpartner_partnerlisting')['partner'];
        $partner = $this->partnerRepository->findByUid($partnerId);

        $gbToken = uniqid('token_', true);
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        $partnerId = $partner->getUid();

        $this->token->gc();
        
        // save token with partnerId and userId 
        $this->token->setToken($gbToken, $partnerId, $userId);
        
        $this->view->assign('gbToken', $gbToken);
        $this->view->assign('partner', $partner);

    }


    

    /**
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner|null $partner
     */
    public function getPartnerTokenAction(\Gigabonus\Gbpartner\Domain\Model\Partner $partner = null) {

        $t = GeneralUtility::_GET('t');

        try {
            if ($partner == NULL || $GLOBALS['TSFE']->fe_user->user == NULL || $t == '') {
                throw new \Exception('Partner not set, or user not logged in, or token is absent');
            }

            $userId = $GLOBALS['TSFE']->fe_user->user['uid'];


            if ($res = $this->token->getToken($t)) {
                if ($res['partner'] == $partner->getUid() && $res['user'] == $userId) {
                    $this->token->deleteToken($t);
                    $resp = GeneralUtility::getUrl($partner->getWebsiteUrl() . '/go.php?getToken=1&' . uniqid());
                    if (!$resp) {
                        throw new \Exception('Incorrect response');
                    } else {
                        return $resp;
                    }

                }
            }
            else {
                throw new \Exception('False token');
            }
        }
        catch (\Exception $e) {
        }

        return '{}';
    }
    

    /**
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner|null $partner
     */
    public function ___gotoPartnerAction(\Gigabonus\Gbpartner\Domain\Model\Partner $partner = null) {

        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        $visitingTime = time();
        $token = md5($userId . $visitingTime . $partner->getApiKey());

        $queryString = '/go.php?visitingTime=' . $visitingTime . '&token=' . $token . ($userId != NULL ? ('&userId=' . $userId) : '');


        echo '<pre>';
        var_dump($_SERVER);
        echo '</pre>';

        echo $_SERVER['HTTP_USER_AGENT'];
        echo '<br><br>';

        echo 'http://' . $partner->getWebsiteUrl() . $queryString;

        echo '<br>';
        echo $partner->getApiKey();
        # DebuggerUtility::var_dump($partner);
        exit;

    }


    /**
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     * 
     */
    protected function generateCanonicalTag(\Gigabonus\Gbpartner\Domain\Model\Partner $partner) {
        
        $url = MainHelper::getPartnerPageUrl($partner);

        /**
         * @var \TYPO3\CMS\Extbase\Mvc\Web\Response $response
         */
        $response = $this->response;
        $response->addAdditionalHeaderData('<link rel="canonical" href="https://' . $GLOBALS['SERVER_ENVIRONMENT']['GBDOMAIN'] . $url . '">');

    }

}