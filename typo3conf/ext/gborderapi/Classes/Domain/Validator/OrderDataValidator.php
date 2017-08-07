<?php
namespace Gigabonus\Gborderapi\Domain\Validator;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Validation\Validator\NumberValidator;

class OrderDataValidator {

    /**
     * Object Manager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;


    /**
     * @param array $orderData
     * @return 
     */
    public function isValid($orderData) {

        $retVal = true;

        // partnerOrderId may not be empty or absent
        if ($orderData['partnerOrderId'] == '') {
            $retVal = false;
        }


        // status may not be empty
        if ($orderData['status'] === '' || !in_array($orderData['status'], array(1,2)) ) {
            $retVal = false;
        }


        /**
         * @var \TYPO3\CMS\Extbase\Validation\Validator\NumberValidator $numberValidator
         */
        $numberValidator = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Validation\\Validator\\NumberValidator');
        if ($orderData['amount'] === '' || $numberValidator->validate($orderData['amount'])->hasErrors()) {
            $retVal = false;
        }

        $response = new \stdClass();
        $response->isValid = $retVal;
        // $response->errors = $this->getErrors();

        return $response;
    }
}
