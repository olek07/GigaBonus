<?php
namespace Gigabonus\Gborderapi\Controller;

use Gigabonus\Gborderapi\Domain\Validator\OrderDataValidator;
use Gigabonus\Gborderapi\Utility\Helper\OrderDataHelper;
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

        try {
            $orderData = $this->mapGetParamsToOrderData();

            $validatorResponse = $this->validateOrderData($orderData);
            if (!$validatorResponse->isValid) {
                throw new \Exception('Order data are wrong', OrderDataHelper::WRONG_ORDERDATA);
            }

            $partner = $this->orderDataHelper->findPartnerByUid($orderData['partnerId']);

            if (!$this->orderDataHelper->isTokenValid($orderData, $partner)) {
                throw new \Exception('Token is wrong', OrderDataHelper::WRONG_TOKEN);
            }

            /* Create a new order */
            $order = $this->orderDataHelper->createOrder($orderData, $partner);

            /* Create a new transaction */
            $this->transactionRepository->createTransaction($order, $partner);

            $content = '{"success":true}';
        }
        catch (\Exception $e) {
            $obj = new \stdClass();
            $obj->sucess = false;
            $obj->errorCode = $e->getCode();
            $obj->errorMessage = $e->getMessage();
            $content = json_encode($obj);
        }

        return $content;
    }


    /**
     * rejects an order and a transaction
     */
    public function rejectAction() {

        try {
            $orderData = $this->mapGetParamsToOrderData();

            $validatorResponse = $this->validateOrderData($orderData);
            if (!$validatorResponse->isValid) {
                throw new \Exception('Order data are wrong', OrderDataHelper::WRONG_ORDERDATA);
            }

            $partner = $this->orderDataHelper->findPartnerByUid($orderData['partnerId']);

            if (!$this->orderDataHelper->isTokenValid($orderData, $partner)) {
                throw new \Exception('Token is wrong', OrderDataHelper::WRONG_TOKEN);
            }

            $order = $this->orderDataHelper->rejectOrder($orderData);

            if ($order != NULL) {
                $this->transactionRepository->rejectTransaction($order);
            }

            $content = '{"success":true}';
        }

        catch (\Exception $e) {
            $obj = new \stdClass();
            $obj->sucess = false;
            $obj->errorCode = $e->getCode();
            $obj->errorMessage = $e->getMessage();
            $content = json_encode($obj);
        }
        
        return $content;
    }


    /**
     * changes the status of the order 1 - onhold, 2 - approved
     *
     *
     * @return string
     * @throws \Exception
     */
    public function changeAction() {

        try {
            $orderData = $this->mapGetParamsToOrderData();

            $validatorResponse = $this->validateOrderData($orderData);
            if (!$validatorResponse->isValid) {
                throw new \Exception('Order data are wrong', OrderDataHelper::WRONG_ORDERDATA);
            }

            $partner = $this->orderDataHelper->findPartnerByUid($orderData['partnerId']);

            if (!$this->orderDataHelper->isTokenValid($orderData, $partner)) {
                throw new \Exception('Token is wrong', OrderDataHelper::WRONG_TOKEN);
            }

            $order = $this->orderDataHelper->changeOrder($orderData, $partner);

            if ($order != NULL) {
                $this->transactionRepository->changeTransaction($order, $partner);
            }

            $content = '{"success":true}';
        }

        catch (\Exception $e){
            $obj = new \stdClass();
            $obj->sucess = false;
            $obj->errorCode = $e->getCode();
            $obj->errorMessage = $e->getMessage();
            $content = json_encode($obj);
        }
        return $content;

    }

    /**
     *
     * tracking pixel
     *
     * @return string
     * @throws \Exception
     */
    public function trackingAction() {

        // $GLOBALS['TSFE']->pageNotFoundAndExit('No parameters found.');
        try {
            $orderData = $this->mapGetParamsToOrderData();

            $validatorResponse = $this->validateOrderData($orderData);
            if (!$validatorResponse->isValid) {
                throw new \Exception('Order data are wrong', OrderDataHelper::WRONG_ORDERDATA);
            }

            $partner = $this->orderDataHelper->findPartnerByUid($orderData['partnerId']);

            if (!$this->orderDataHelper->isTokenValid($orderData, $partner)) {
                throw new \Exception('Token is wrong', OrderDataHelper::WRONG_TOKEN);
            }

            /* Create a new order */
            $order = $this->orderDataHelper->createOrder($orderData, $partner);

            /* Create a new transaction */
            $this->transactionRepository->createTransaction($order, $partner);

        }
        catch (\Exception $e) {
            
        }

        // Generate gif 1x1
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
        $orderData['data'] = GeneralUtility::_GET('data');
        $orderData['token'] = GeneralUtility::_GET('token');

        return $orderData;
    }

    /**
     * @param $orderData
     * @return 
     */
    protected function validateOrderData($orderData) {

        /**
         * @var OrderDataValidator $validator
         */
        $validator = $this->objectManager->get('Gigabonus\\Gborderapi\\Domain\\Validator\\OrderDataValidator');
        $validatorResponse = $validator->isValid($orderData);

        return $validatorResponse;
    }


}