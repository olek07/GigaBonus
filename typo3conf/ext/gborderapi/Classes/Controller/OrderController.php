<?php
namespace Gigabonus\Gborderapi\Controller;

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
class OrderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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
     * transactionRepository
     *
     * @var \Gigabonus\Gbaccount\Domain\Repository\TransactionRepository
     * @inject
     */
    protected $transactionRepository = NULL;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    
    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {
        
    }

    /**
     * action create
     *
     * @param \Gigabonus\Gborderapi\Domain\Model\Order $newOrder
     * @return string
     */
    public function createAction(\Gigabonus\Gborderapi\Domain\Model\Order $newOrder = NULL)
    {
        /**
         * @var \Gigabonus\Gborderapi\Domain\Model\Order $order
         */
        $order = $this->objectManager->get('Gigabonus\\Gborderapi\\Domain\\Model\\Order');

        $partnerId = GeneralUtility::_GET('partnerId');
        $partnerOrderId = GeneralUtility::_GET('orderId');             // rename to partner_order_id
        $amount = GeneralUtility::_GET('amount');
        $status = GeneralUtility::_GET('status');
        $userId = GeneralUtility::_GET('userId');
        $currency = GeneralUtility::_GET('currency');
        $additionalData = GeneralUtility::_GET('data');
        $token = GeneralUtility::_GET('token');


        /** @var \Gigabonus\Gbpartner\Domain\Model\Partner $partner */
        $partner = $this->partnerRepository->findByUid($partnerId);
        $apiKey = $partner->getApiKey();

        if ($apiKey == $token) {
            $order->setPartnerId($partnerId);
            $order->setPartner($partner);
            $order->setPartnerOrderId($partnerOrderId);
            $order->setAmount($amount);
            $order->setStatus($status);
            $order->setUserId($userId);
            $currency = ($currency == '' ? 'UAH' : $currency);
            $order->setCurrency($currency);
            $order->setData($additionalData);


            $partnerClassName = 'Gigabonus\\Gborderapi\\Partner\\' . $partner->getClassName();

            if (!class_exists($partnerClassName)) {
                throw new \Exception("Class doesn't exist");
            }

            /** @var \Gigabonus\Gborderapi\Partner\AbstractPartner $partnerClassObj */
            $partnerClassObj = GeneralUtility::makeInstance($partnerClassName);

            $fee = $partnerClassObj->calculateFee($amount);
            $bonus = $partnerClassObj->calculateBonus($amount);


            $order->setFee($fee);


            if ($this->orderRepository->checkUniqueDb($partnerId, $partnerOrderId)) {
                return 'not unique';
            }

            $this->orderRepository->add($order);
            $this->persistenceManager->persistAll();



            /*
             * Create a new transaction
             */

            /** @var \Gigabonus\Gbaccount\Domain\Model\Transaction $transaction */
            $transaction = $this->objectManager->get('Gigabonus\\Gbaccount\\Domain\\Model\\Transaction');

            $transaction->setAmount($bonus);
            $transaction->setPartner($partnerId);
            $transaction->setUser($userId);
            $transaction->setOrderId($order->getUid());             // NOT the partner order id, but uid in tx_gborderapi_domain_model_order
            $transaction->setIsOnHold(true);

            
            $this->transactionRepository->add($transaction);

        }
        else {
            throw new \Exception('Token is wrong');
        }

        return 'ok';
    }

}