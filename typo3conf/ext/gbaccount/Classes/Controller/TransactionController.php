<?php
namespace Gigabonus\Gbaccount\Controller;

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
use Gigabonus\Gbbase\Utility\Helpers\MainHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * TransactionController
 */
class TransactionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * transactionRepository
     * 
     * @var \Gigabonus\Gbaccount\Domain\Repository\TransactionRepository
     * @inject
     */
    protected $transactionRepository = NULL;


    /**
     * partnerRepository
     *
     * @var \Gigabonus\Gbpartner\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = NULL;


    /**
     * Override the method to avoid a calling of another action, if the get-parameter set, like
     * tx_gbaccount_transactions[action]=new&tx_gbaccount_transactions[controller]=Transaction
     * The typoscript setting callOnlyAction contains the action name to call
     */
    protected function callActionMethod()
    {
        if (isset($this->settings['callOnlyAction'])
            && $this->settings['callOnlyAction'] != ''
            && $this->settings['callOnlyAction'] . 'Action' != $this->actionMethodName
        ) {
            $this->actionMethodName = $this->settings['callOnlyAction'] . 'Action';
        }
        parent::callActionMethod(); 
    }


    /**
     * @param $date
     */
    protected function dateToTimestamp($date) {
        if (preg_match('/(\d\d)\.(\d\d)\.(\d\d\d\d)/', $date, $matches)) {
            if (checkdate($matches[2], $matches[1], $matches[3])) {
                return mktime(0, 0, 0, $matches[2], $matches[1], $matches[3]);
            }
        }

        return null;
    }


    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {

        if ($GLOBALS['TSFE']->fe_user->user === NULL) {
            exit;
        }

        /**
         * @var $pageRenderer \TYPO3\CMS\Core\Page\PageRenderer 
         */
        $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        
        $isoLang = strtolower($GLOBALS['TSFE']->config['config']['language']);

        switch ($isoLang) {
            case 'ru':
                $fileName = 'datepicker-ru.js';
                break;
            case 'uk':
                $fileName = 'datepicker-uk.js';
                break;
            default: $fileName = '';
        }

        if ($fileName != '') {
            $pageRenderer->addJsLibrary('datepicker', '/typo3conf/ext/gbbase/Resources/Public/Scripts/Libs/' . $fileName);
        }

        $pageRenderer->addJsFooterInlineCode('',
            "jQuery(document).ready(function(){
                    Gbtransactions.init();
            });"
        );

        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];

        $startdateFormated = GeneralUtility::_GET('startdate');
        $enddateFormated = GeneralUtility::_GET('enddate');

        $startdate = $this->dateToTimestamp($startdateFormated);
        $enddate = $this->dateToTimestamp($enddateFormated);


        $bonusBalance = $this->transactionRepository->getBonusBalance($userId);


        $query = $this->transactionRepository->createQuery();

        $constraints = array();

        $constraints[] = $query->equals('user', $userId);

        if ($startdate != NULL) {
            $constraints[] = $query->greaterThanOrEqual('crdate', $startdate);
        }
        else {
            // wenn das Datum nicht korrekt ist (URL manipuliert etc)
            $startdateFormated = '';
        }

        if ($enddate != NULL) {
            $constraints[] = $query->lessThanOrEqual('crdate', $enddate + 3600 * 24);
        }
        else {
            $enddateFormated = '';
        }

        $query->matching(
            $query->logicalAnd($constraints)
        );

        $transactions = $query->execute();

        $this->view->assign('startdate', $startdateFormated);
        $this->view->assign('enddate', $enddateFormated);
        $this->view->assign('transactions', $transactions);
        $this->view->assign('bonusBalance', $bonusBalance);
    }
    
    /**
     * action show
     * 
     * @param \Gigabonus\Gbaccount\Domain\Model\Transaction $transaction
     * @return void
     */
    public function showAction(\Gigabonus\Gbaccount\Domain\Model\Transaction $transaction)
    {
        DebuggerUtility::var_dump($transaction);
        $this->view->assign('transaction', $transaction);
    }
    

    public function bonusBalanceAction() {

        $bonusBalance = 0;
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        $userEmail = $GLOBALS['TSFE']->fe_user->user['email'];

        if ($userId !== NULL) {
            $bonusBalance = $this->transactionRepository->getBonusBalance($userId);
        }

        $links = array(
            'transactionListPageUid' => MainHelper::TRANSACTIONLISTPAGEUID,
            'changedUserDataPageId' => MainHelper::CHANGEUSERDATAPAGEID
        );
        

        $this->view->assign('links', $links);
        $this->view->assign('userEmail', $userEmail);
        $this->view->assign('bonusBalance', $bonusBalance);
    }


}