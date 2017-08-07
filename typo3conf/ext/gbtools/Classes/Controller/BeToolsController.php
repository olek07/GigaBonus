<?php
namespace Gigabonus\Gbtools\Controller;

use Gigabonus\Gborderapi\Domain\Repository\OrderRepository;
use Gigabonus\Gbpartner\Domain\Model\Partner;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
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

/**
 * OrderController
 */
class BeToolsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * orderRepository
     *
     * @var \Gigabonus\Gborderapi\Domain\Repository\OrderRepository
     * @inject
     */
    protected $orderRepository = NULL;

    /**
     * partnerRepository
     *
     * @var \Gigabonus\Gbpartner\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = NULL;



    /**
     * action new
     * 
     * @return void
     */
    public function overviewAction() {
        
    }
    
    public function createOrderLinkAction() {

        $this->initFrontend();

        $cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
        $linkConf = array(
            'parameter' => 41,
            'forceAbsoluteUrl' => 1,
            'additionalParams' => \TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl(NULL, array(
                'version' => '1.0',
                'tx_gborderapi_pi1[action]' => 'create',
                'amount' => 423.56
            )),
            'linkAccessRestrictedPages' => 1
        );
        $link = $cObj->typolink_URL($linkConf);

        $query = $this->partnerRepository->createQuery();
        $query->getQuerySettings()->setLanguageUid(0);
        $query->getQuerySettings()->setStoragePageIds([11]);
        $result = $query->execute();

        $this->view->assign('partners', $result);

DebuggerUtility::var_dump($result);


        # return 'create order link ' . $link;
    }


    /*
	 * init frontnend to render frontend links in task
	 */
    protected function initFrontend() {
        $id = 1;
        $type = 0;
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\TimeTracker;
            $GLOBALS['TT']->start();
        }
        $GLOBALS['TSFE'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController',  $GLOBALS['TYPO3_CONF_VARS'], $id, $typeNum);
        $GLOBALS['TSFE']->connectToDB();
        $GLOBALS['TSFE']->initFEuser();
        $GLOBALS['TSFE']->determineId();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->getConfigArray();

        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
            $rootline = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($id);
            $host = \TYPO3\CMS\Backend\Utility\BackendUtility::firstDomainRecord($rootline);
            $_SERVER['HTTP_HOST'] = $host;
        }
    }



}