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
     * action list
     *
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $category
     * 
     * @return void
     */
    public function listAction(\Gigabonus\Gbpartner\Domain\Model\Category $category = null)
    {
        /**
         * @todo show all partners if the url is /ru/partner/
         */

        if ($category !== NULL) {
            $GLOBALS['TSFE']->page['title'] = $category->getName();
        }
        else {
            $GLOBALS['TSFE']->page['title'] = 'Партнёры';
        }

        $this->view->assign('partnerDetailPageUid', MainHelper::PARTNERDETAILPAGEID);
        $this->view->assign('category', $category);
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
        // DebuggerUtility::var_dump($partner);

        if ($partner == NULL) {
            $this->forward('list', null, null, array('category' => $category));
        }
        else {
            DebuggerUtility::var_dump($partner->getMainCategory());
            
            $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
                array(
                    'parameter' => 17,
                    'additionalParams' => '&tx_gbpartner_partnerlisting[action]=show&tx_gbpartner_partnerlisting[category]=' . $partner->getMainCategory() . '&tx_gbpartner_partnerlisting[controller]=Partner&tx_gbpartner_partnerlisting[partner]=' . $partner->getUid()
                )
            );
            
            DebuggerUtility::var_dump($url,111);
            
            $this->view->assign('category', $category);
            $this->view->assign('partner', $partner);
        }
    }

    /**
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner|null $partner
     */
    public function gotoPartnerAction(\Gigabonus\Gbpartner\Domain\Model\Partner $partner = null) {

        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        $visitingTime = time();
        $token = md5($userId . $visitingTime . $partner->getApiKey());

        $queryString = '/go.php?visitingTime=' . $visitingTime . '&token=' . $token . ($userId != NULL ? ('&userId=' . $userId) : '');

        echo 'http://' . $partner->getWebsiteUrl() . $queryString;

        echo '<br>';
        echo $partner->getApiKey();
        # DebuggerUtility::var_dump($partner);
        exit;

    }


}