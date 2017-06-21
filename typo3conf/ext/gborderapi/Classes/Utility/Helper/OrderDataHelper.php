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
        $order->setData($orderData['additionalData']);

        $fee = $partnerClassObj->calculateFee($orderData['amount']);
        $order->setFee($fee);


        if ($this->orderRepository->checkUniqueDb($orderData['partnerId'], $orderData['partnerOrderId'])) {
            throw new \Exception('not unique', 1);
        }


        /* save order */
        $this->orderRepository->saveOrder($order);

        return $order;

    }

    /**
     * @param  \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     * @return \Gigabonus\Gborderapi\Partner\AbstractPartner
     * @throws \Exception
     */
    public function initPartnerClass($partner) {

        $partnerClassName = 'Gigabonus\\Gborderapi\\Partner\\' . $partner->getClassName();

        if (!class_exists($partnerClassName)) {
            throw new \Exception("Class doesn't exist");
        }

        /** @var \Gigabonus\Gborderapi\Partner\AbstractPartner $partnerClassObj */
        $partnerClassObj = GeneralUtility::makeInstance($partnerClassName);

        return $partnerClassObj;
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
            throw new \Exception('Partner not found');
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
            return null;
        }

    }

    /**
     * @param array $orderData
     */
    public function changeOrderStatus($orderData) {
        $order = $this->orderRepository->findOrderByPartnerIdPartnerOrderId($orderData['partnerId'], $orderData['partnerOrderId']);

        if ($order != NULL) {
            $order->setStatus($orderData['status']);
            $this->orderRepository->update($order);
            return $order;
        }
        else {
            return null;
        }
    }
    
}