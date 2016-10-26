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
        if ($this->settings['callOnlyAction'] != '' && $this->settings['callOnlyAction'] . 'Action' != $this->actionMethodName) {
            $this->actionMethodName = $this->settings['callOnlyAction'] . 'Action';
        }
        parent::callActionMethod(); 
    }


    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $transactions = $this->transactionRepository->findAll();
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
        $query = $this->transactionRepository->createQuery();
        $query->getQuerySettings()->setStoragePageIds([13]);
        $result = $query->execute();

        // $GLOBALS['TSFE']->fe_user->user['uid']
        DebuggerUtility::var_dump($result);


        return '';
    }


}