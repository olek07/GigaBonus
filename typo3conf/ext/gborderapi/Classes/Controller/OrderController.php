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

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;
    const STATUS_CHANGED = 4;

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
     * @throws \Exception
     */
    public function createAction(\Gigabonus\Gborderapi\Domain\Model\Order $newOrder = NULL)
    {

        $orderData = [];
        $orderData['partnerId'] = GeneralUtility::_GET('partnerId');
        $orderData['partnerOrderId'] = GeneralUtility::_GET('partnerOrderId');
        $orderData['amount'] = GeneralUtility::_GET('amount');
        $orderData['status'] = GeneralUtility::_GET('status');
        $orderData['userId'] = GeneralUtility::_GET('userId');
        $orderData['currency'] = GeneralUtility::_GET('currency');
        $orderData['additionalData'] = GeneralUtility::_GET('data');
        $orderData['token'] = GeneralUtility::_GET('token');

        switch ($orderData['status']) {

            case self::STATUS_PENDING:
            case self::STATUS_APPROVED:

                /** @var \Gigabonus\Gbpartner\Domain\Model\Partner $partner */
                $partner = $this->partnerRepository->findByUid($orderData['partnerId']);

                /* Create a new order */
                $order = $this->createOrder($orderData, $partner);

                /* Create a new transaction */
                $this->createTransaction($order, $partner);
                break;

            case self::STATUS_REJECTED:
                $order = $this->rejectOrder($orderData);
                if ($order != NULL) {
                    $this->rejectTransaction($order);
                }
                break;
            default:
                break;
        }

        return 'ok';
    }

    /**
     * @param  \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     * @return \Gigabonus\Gborderapi\Partner\AbstractPartner
     * @throws \Exception
     */
    protected function initPartnerClass($partner) {

        $partnerClassName = 'Gigabonus\\Gborderapi\\Partner\\' . $partner->getClassName();

        if (!class_exists($partnerClassName)) {
            throw new \Exception("Class doesn't exist");
        }

        /** @var \Gigabonus\Gborderapi\Partner\AbstractPartner $partnerClassObj */
        $partnerClassObj = GeneralUtility::makeInstance($partnerClassName);

        return $partnerClassObj;
    }

    /**
     * @param $orderData
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     * @return \Gigabonus\Gborderapi\Domain\Model\Order
     * @throws \Exception
     */
    protected function createOrder($orderData, $partner) {

        $apiKey = $partner->getApiKey();
        $partnerClassObj = $this->initPartnerClass($partner);

        /**
         * @var \Gigabonus\Gborderapi\Domain\Model\Order $order
         */
        $order = $this->objectManager->get('Gigabonus\\Gborderapi\\Domain\\Model\\Order');


        // temporär wird apiKey als token benutzt
        if ($apiKey == $orderData['token']) {
            $order->setPartnerId($orderData['partnerId']);
            $order->setPartner($partner);
            $order->setPartnerOrderId($orderData['partnerOrderId']);
            $order->setAmount($orderData['amount']);
            $order->setStatus($orderData['status']);
            $order->setUserId($orderData['userId']);
            $currency = ($orderData['currency'] == '' ? 'UAH' : $orderData['currency']);
            $order->setCurrency($currency);
            $order->setData($orderData['additionalData']);

            $fee = $partnerClassObj->calculateFee($orderData['amount']);
            $order->setFee($fee);


            if ($this->orderRepository->checkUniqueDb($orderData['partnerId'], $orderData['partnerOrderId'])) {
                // return 'not unique';
                throw new \Exception('not unique');
            }


            /* save order */
            $this->orderRepository->saveOrder($order);

            return $order;

        }
        else {
            throw new \Exception('Token is wrong');
        }

    }


    /**
     * @param \Gigabonus\Gborderapi\Domain\Model\Order $order
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     */
    protected function createTransaction(\Gigabonus\Gborderapi\Domain\Model\Order $order, $partner) {

        $partnerClassObj = $this->initPartnerClass($partner);
        $bonus = $partnerClassObj->calculateBonus($order->getAmount());

        /** @var \Gigabonus\Gbaccount\Domain\Model\Transaction $transaction */
        $transaction = $this->objectManager->get('Gigabonus\\Gbaccount\\Domain\\Model\\Transaction');

        $transaction->setAmount($bonus);
        $transaction->setPartner($order->getPartnerId());
        $transaction->setUser($order->getUserId());
        $transaction->setPartnerOrder($order->getUid());             // NOT the partner order id, but the uid in tx_gborderapi_domain_model_order
        $transaction->setIsOnHold(true);
        $transaction->setStatus($order->getStatus());

        $this->transactionRepository->add($transaction);
    }

    /**
     * @param array $orderData
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @return \Gigabonus\Gborderapi\Domain\Model\Order
     */
    protected function rejectOrder($orderData) {

        $order = $this->orderRepository->findOrderByPartnerIdPartnerOrderId($orderData['partnerId'], $orderData['partnerOrderId']);
        if ($order != NULL) {
            $order->setStatus(self::STATUS_REJECTED);
            $this->orderRepository->update($order);

            return $order;
        }
        else {
            return null;
        }

    }

    /**
     * @param \Gigabonus\Gborderapi\Domain\Model\Order $order
     */
    protected function rejectTransaction(\Gigabonus\Gborderapi\Domain\Model\Order $order) {
        $this->transactionRepository->rejectTransaction($order);
    }



}