<?php
namespace Gigabonus\Gbfemanager\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class ValidationController extends \In2code\Femanager\Controller\AbstractController {
    
    /**
     * ClientsideValidator
     *
     * @var \In2code\Femanager\Domain\Validator\ClientsideValidator
     * @inject
     */
    protected $clientsideValidator;
    
    /**
     * 
     * @param string $data
     * @return string
     */
    public function validateAction($data = null) {
        
        $settings = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_femanager.']['settings.']['edit.']['validation.'];
        
        $errorMessages = [];
        $fieldsToValidate = json_decode($data);
        
        
        if (count($fieldsToValidate) == 0) {
            return '{"validate":0}';
        }
        
        
        foreach ($fieldsToValidate as $field => $value) {
            
           # \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($settings[$field . '.']);
            
            $validation = '';
            switch ($field) {
                case 'firstName':
                case 'middlename':
                case 'lastname':
                    $validation = 'min(2),max(20),required';
                    break;
                case 'dateOfBirth':
                    $validation = 'date,required';
                    break;
                case 'cityId':
                    if ($value <= 0) {
                        $errorMessages['cityId'] = array('Город не указан');
                    }
                    break;
                case 'zip':
                    $validation = 'min(5),max(5),intOnly,required';
                    break;
                case 'gender':
                    if ($value == 0) {
                        $errorMessages['gender'] = array('Пол не указан');
                    }
                    break;
                default:
            }
            
            if ($validation !== '') {
                
                $clientsideValidator = $this->clientsideValidator;
                
                $result = $clientsideValidator
                    ->setValidationSettingsString($validation)
                    ->setValue($value)
                    ->validateField();
                
                if (!$result) {
                    $messages[$field . '_field'] = $this->clientsideValidator->getMessages();
                    $this->clientsideValidator->setMessages(array());
                }
                
            }
        }
        
        
        if (is_array($messages) && count($messages) > 0) {
            foreach ($messages as $field => $fieldMessages) {
                foreach ($fieldMessages as $fieldMessage) {
                    $errorMessages[] = sprintf(LocalizationUtility::translate($fieldMessage, "femanager"), $field);
                }
            }
        }
        
        
       // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($errorMessages);
        
        
        if (count($errorMessages) == 0) {
            $response = '{"validate": 1}';
        }
        else {
            $obj = array("validate" => 0,
                        "messages" => $errorMessages
            );
            
            $response = json_encode($obj);
        }
        
        return $response;
        
    }
}