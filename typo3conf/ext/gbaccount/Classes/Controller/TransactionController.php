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
            $pageRenderer->addJsFile('/typo3conf/ext/gbbase/Resources/Public/Scripts/Libs/' . $fileName);
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


        $query = $this->transactionRepository->createQuery();
        $query->getQuerySettings()->setStoragePageIds([13]);

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
    
    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {
        $query = $this->partnerRepository->createQuery();
        $query->getQuerySettings()->setLanguageUid(0);
        $query->getQuerySettings()->setStoragePageIds([11]);
        $result = $query->execute();

        /*
        $partners = [];
        foreach ($result as $entry) {
            $partner = new \stdClass();
            $partner->value = $entry->getName();
            $partner->key = $entry->getUid();
            $partners[] = $partner;
        }

        $this->view->assign('partners', $partners);
        */

        $this->view->assign('partners', $result);
    }

    /**
     * action create
     * 
     * @param \Gigabonus\Gbaccount\Domain\Model\Transaction $newTransaction
     * @return void
     */
    public function createAction(\Gigabonus\Gbaccount\Domain\Model\Transaction $newTransaction)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->transactionRepository->add($newTransaction);
        $this->redirect('list');
    }
    
    /**
     * action edit
     * 
     * @param \Gigabonus\Gbaccount\Domain\Model\Transaction $transaction
     * @ignorevalidation $transaction
     * @return void
     */
    public function editAction(\Gigabonus\Gbaccount\Domain\Model\Transaction $transaction)
    {
        $this->view->assign('transaction', $transaction);
    }
    
    /**
     * action update
     * 
     * @param \Gigabonus\Gbaccount\Domain\Model\Transaction $transaction
     * @return void
     */
    public function updateAction(\Gigabonus\Gbaccount\Domain\Model\Transaction $transaction)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->transactionRepository->update($transaction);
        $this->redirect('list');
    }
    


    public function bonusBalanceAction() {

        $bonusBalance = 0;
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];

        if ($userId !== NULL) {
            $bonusBalance = $this->transactionRepository->getBonusBalance($userId);
        }

        
        $transactionListPageUid = MainHelper::TRANSACTIONLISTPAGEUID;

        $this->view->assign('transactionListPageUid', $transactionListPageUid);
        $this->view->assign('bonusBalance', $bonusBalance);
    }


}