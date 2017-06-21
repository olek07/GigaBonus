<?php
namespace Gigabonus\Gborderapi\Controller;

use Gigabonus\Gbpartner\Domain\Model\Partner;
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
     * transactionRepository
     *
     * @var \Gigabonus\Gbaccount\Domain\Repository\TransactionRepository
     * @inject
     */
    protected $transactionRepository = NULL;

    /**
     * @var \Gigabonus\Gborderapi\Utility\Helper\OrderDataHelper
     * @inject
     */
    protected $orderDataHelper = NULL;


    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {
        
    }

    /**
     * action create. creates a new order and a new transaction
     *
     */
    public function createAction()
    {

        $content = hex2bin('47494638396101000100900000ff000000000021f90405100000002c00000000010001000002020401003b');
        # $content = base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');

        # $GLOBALS['TSFE']->setContentType('image/gif');;

//        $this->response->setHeader('Content-Type', 'image/gif');
//        $this->response->setContent(base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw=='));
//        $this->response->send();

//        return '';

//        return $content;

        $orderData = $this->mapGetParamsToOrderData();
        $partner = $this->orderDataHelper->findPartnerByUid($orderData['partnerId']);

        if (!$this->orderDataHelper->isTokenValid($orderData, $partner)) {
            throw new \Exception('Token is wrong');
        }

        $content = '';

        try {
            /* Create a new order */
            $order = $this->orderDataHelper->createOrder($orderData, $partner);

            /* Create a new transaction */
            $this->createTransaction($order, $partner);

            switch ($orderData['t']) {

                case 'json':
                    $content = '{success:true}';
                    break;

                case 'gif':
                    // header('Content-Type: image/gif');
                    $content = base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');
                    break;
                default:
                    break;

            }

        }
        catch (\Exception $e) {
            // echo $e->getCode();
            $content = '{success:false}';
        }

        return $content;
    }


    /**
     * rejects an order and a transaction
     */
    public function rejectAction() {

        $orderData = $this->mapGetParamsToOrderData();
        $partner = $this->orderDataHelper->findPartnerByUid($orderData['partnerId']);

        if (!$this->orderDataHelper->isTokenValid($orderData, $partner)) {
            throw new \Exception('Token is wrong');
        }

        $order = $this->orderDataHelper->rejectOrder($orderData);

        if ($order != NULL) {
            $this->rejectTransaction($order);
        }
        
        return 'rejectAction';
    }


    public function changeStatusAction() {

        $orderData = $this->mapGetParamsToOrderData();
        $partner = $this->orderDataHelper->findPartnerByUid($orderData['partnerId']);

        if (!$this->orderDataHelper->isTokenValid($orderData, $partner)) {
            die('Token is wrong');
        }

        $order = $this->orderDataHelper->changeOrderStatus($orderData);

        $this->transactionRepository->changeTransactionStatus($order);

        return 'changeStatus';

    }

    /**
     *
     * tracking pixel
     *
     * @return string
     * @throws \Exception
     */
    public function trackingAction() {

        try {
            $orderData = $this->mapGetParamsToOrderData();
            $partner = $this->orderDataHelper->findPartnerByUid($orderData['partnerId']);

            if (!$this->orderDataHelper->isTokenValid($orderData, $partner)) {
                throw new \Exception('Token is wrong');
            }

            /* Create a new order */
            $order = $this->orderDataHelper->createOrder($orderData, $partner);

            /* Create a new transaction */
            $this->createTransaction($order, $partner);

        }
        catch (\Exception $e) {
            #echo $e->getCode();
            #echo $e->getMessage();
            #exit;
        }


        $this->response->setHeader('Content-Type', 'image/gif');
        $this->response->setContent(base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw=='));

        return '';
    }


    /**
     * @return array
     */
    protected function mapGetParamsToOrderData() {
        $orderData = [];
        $orderData['partnerId'] = GeneralUtility::_GET('partnerId');
        $orderData['partnerOrderId'] = GeneralUtility::_GET('partnerOrderId');
        $orderData['amount'] = GeneralUtility::_GET('amount');
        $orderData['status'] = GeneralUtility::_GET('status');
        $orderData['userId'] = GeneralUtility::_GET('userId');
        $orderData['currency'] = GeneralUtility::_GET('currency');
        $orderData['additionalData'] = GeneralUtility::_GET('data');
        $orderData['token'] = GeneralUtility::_GET('token');
        $orderData['t'] = GeneralUtility::_GET('t');                // type of returned data (json, gif)

        return $orderData;
    }



    /**
     * @param \Gigabonus\Gborderapi\Domain\Model\Order $order
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     */
    protected function createTransaction(\Gigabonus\Gborderapi\Domain\Model\Order $order, $partner) {

        $partnerClassObj = $this->orderDataHelper->initPartnerClass($partner);
        $bonus = $partnerClassObj->calculateBonus($order->getAmount());

        /** @var \Gigabonus\Gbaccount\Domain\Model\Transaction $transaction */
        $transaction = $this->objectManager->get('Gigabonus\\Gbaccount\\Domain\\Model\\Transaction');

        $transaction->setAmount($bonus);
        $transaction->setPartner($order->getPartnerId());
        $transaction->setUser($order->getUserId());
        $transaction->setPartnerOrder($order->getUid());             // NOT the partner order id, but the uid in tx_gborderapi_domain_model_order
        if ($order->getStatus() == 1) {
            $transaction->setIsOnHold(true);
        }
        $transaction->setStatus($order->getStatus());

        $this->transactionRepository->add($transaction);
    }


    /**
     * @param \Gigabonus\Gborderapi\Domain\Model\Order $order
     */
    protected function rejectTransaction(\Gigabonus\Gborderapi\Domain\Model\Order $order) {
        $this->transactionRepository->rejectTransaction($order);
    }


}