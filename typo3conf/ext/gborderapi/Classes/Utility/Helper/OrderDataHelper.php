<?php
namespace Gigabonus\Gborderapi\Utility\Helper;

use Gigabonus\Gbpartner\Domain\Model\Partner;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class OrderDataHelper {

    /**
     * Object Manager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;


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



    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;
    const STATUS_CHANGED = 4;
    
    const PARTNER_NOT_FOUND = 1;
    const NOT_UNIQUE = 2;
    const PARTNER_CLASS_NOT_FOUND = 3;
    const ORDER_NOT_FOUND = 4;
    const WRONG_TOKEN = 5;
    const NOT_CHANGEABLE = 6;
    const WRONG_ORDERDATA = 7;


    /**
     * @param $orderData
     * @param Partner $partner
     * @return bool
     */
    public function isTokenValid($orderData, $partner) {

        $apiKey = $partner->getApiKey();


        /**
         * @todo die Prüflogik implementieren
         */

        // temporär wird apiKey als token benutzt
        if ($apiKey == $orderData['token']) {
            return true;
        }
        else {
            return false;
        }
    }


    /**
     * @param  \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     * @return \Gigabonus\Gborderapi\Partner\AbstractPartner
     * @throws \Exception
     */
    public function initPartnerClass($partner) {

        $partnerClassName = 'Gigabonus\\Gborderapi\\Partner\\' . $partner->getClassName();

        if (!class_exists($partnerClassName)) {
            throw new \Exception("Class doesn't exist", self::PARTNER_CLASS_NOT_FOUND);
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
    public function createOrder($orderData, $partner) {

        $partnerClassObj = $this->initPartnerClass($partner);

        /**
         * @var \Gigabonus\Gborderapi\Domain\Model\Order $order
         */
        $order = $this->objectManager->get('Gigabonus\\Gborderapi\\Domain\\Model\\Order');


        $order->setPartnerId($orderData['partnerId']);
        $order->setPartner($partner);
        $order->setPartnerOrderId($orderData['partnerOrderId']);
        $order->setAmount($orderData['amount']);
        $order->setStatus($orderData['status']);
        $order->setUserId($orderData['userId']);
        $currency = ($orderData['currency'] == '' ? 'UAH' : $orderData['currency']);
        $order->setCurrency($currency);
        $order->setData($orderData['data']);

        $fee = $partnerClassObj->calculateFee($orderData['amount']);
        $order->setFee($fee);


        if ($this->orderRepository->checkUniqueDb($orderData['partnerId'], $orderData['partnerOrderId'])) {
            throw new \Exception('Not unique', self::NOT_UNIQUE);
        }


        /* save order */
        $this->orderRepository->saveOrder($order);

        return $order;

    }


    /**
     * @param int $uid
     * @return Partner
     * @throws \Exception
     */
    public function findPartnerByUid($uid) {
        /** @var \Gigabonus\Gbpartner\Domain\Model\Partner $partner */
        $partner = $this->partnerRepository->findByUid($uid);

        // $uid may ONLY be the default language partner uid, NOT localization partner uid

        if ($partner == NULL || $partner->getUid() != $uid) {
            throw new \Exception('Partner not found', self::PARTNER_NOT_FOUND);
        }

        return $partner;
    }


    /**
     * @param array $orderData
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @return \Gigabonus\Gborderapi\Domain\Model\Order
     */
    public function rejectOrder($orderData) {

        $order = $this->orderRepository->findOrderByPartnerIdPartnerOrderId($orderData['partnerId'], $orderData['partnerOrderId']);
        if ($order != NULL) {
            $order->setStatus(self::STATUS_REJECTED);
            $this->orderRepository->update($order);

            return $order;
        }
        else {
            throw new \Exception('Order not found', self::ORDER_NOT_FOUND);
        }

    }

    /**
     * @param array $orderData
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     */
    public function changeOrder($orderData, $partner) {
        $order = $this->orderRepository->findOrderByPartnerIdPartnerOrderId($orderData['partnerId'], $orderData['partnerOrderId']);

        if ($order != NULL) {

            $status = $order->getStatus();
            if ($status == self::STATUS_APPROVED) {
                throw new \Exception('Approved. Not changeable', self::NOT_CHANGEABLE);
            }

            if ($status == self::STATUS_REJECTED) {
                throw new \Exception('Rejected. Not changeable', self::NOT_CHANGEABLE);
            }

            $partnerClassObj = $this->initPartnerClass($partner);

            if ($orderData['status'] != '') {
                $order->setStatus($orderData['status']);
            }

            if ($orderData['currency'] != '') {
                $order->setCurrency($orderData['currency']);
            }

            if ($orderData['data'] != '') {
                $order->setData($orderData['data']);
            }

            if ($orderData['amount'] != '') {
                $order->setAmount($orderData['amount']);
                $fee = $partnerClassObj->calculateFee($orderData['amount']);
                $order->setFee($fee);
            }

            $this->orderRepository->update($order);
            return $order;
        }
        else {
            throw new \Exception('Order not found', self::ORDER_NOT_FOUND);
        }
    }
    
}