<?php
namespace Gigabonus\Gbaccount\Domain\Repository;

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
use Gigabonus\Gbaccount\Domain\Model\Transaction;
use Gigabonus\Gborderapi\Controller\OrderController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * The repository for Transactions
 */
class TransactionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    /**
     * @param int $userId
     * @return int
     */
    public function getBonusBalance($userId = 0) {
        $result = 0;

        $transactions = $this->findByUser($userId);

        foreach ($transactions as $item) {
            /**
             * @var Transaction $item
             */
            if (!$item->isRejected()) {
                $result += $item->getAmount();
            }
        }

        return $result;
    }


    /**
     * Check if there is already an entry in the table
     *
     * @param $partnerId
     * @return Transaction
     */
    public function checkUniqueDb($orderId)
    {
        $transaction = $this->findByOrderId($orderId);
        DebuggerUtility::var_dump($transaction);
        exit;


        /*
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(true);
        // $query->getQuerySettings()->setIgnoreEnableFields(true);

        $and = [
            $query->equals('partner_id', $partnerId),
            $query->equals('shop_order_id', $partnerOrderId)
        ];

        $constraint = $query->logicalAnd($and);

        $query->matching($constraint);

        $order = $query->execute()->getFirst();
        return $order;
        */
    }


    /**
     * @param \Gigabonus\Gborderapi\Domain\Model\Order $partnerOrder
     * @return Transaction
     */
    protected function findTransactionByPartnerOrder(\Gigabonus\Gborderapi\Domain\Model\Order $partnerOrder) {
        // read the full typoscript configuration
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $storagePid = $extbaseFrameworkConfiguration['plugin.']['tx_gbaccount_transactions.']['persistence.']['storagePid'];


        $query = $this->createQuery();
        $query->getQuerySettings()->setStoragePageIds(array($storagePid));

        /**
         * @var \Gigabonus\Gbaccount\Domain\Model\Transaction $transaction
         */
        $transaction = $query->matching($query->equals('partner_order', $partnerOrder))->execute()->getFirst();
        
        return $transaction;
    }
    

    /**
     * @param \Gigabonus\Gborderapi\Domain\Model\Order $partnerOrder
     */
    public function rejectTransaction(\Gigabonus\Gborderapi\Domain\Model\Order $partnerOrder) {

        $transaction = $this->findTransactionByPartnerOrder($partnerOrder);

        $transaction->setRejected(true);

        $this->update($transaction);

    }

    /**
     * @param \Gigabonus\Gborderapi\Domain\Model\Order $partnerOrder
     */
    public function changeTransactionStatus(\Gigabonus\Gborderapi\Domain\Model\Order $partnerOrder) {
        $transaction = $this->findTransactionByPartnerOrder($partnerOrder);

        $transaction->setIsOnHold(false);

        $this->update($transaction);
    }


}