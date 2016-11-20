<?php
namespace Gigabonus\Gbfemanager\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class ValidationController extends \In2code\Femanager\Controller\AbstractController {


    /**
     * Validation names with extended configuration
     *
     * @var array
     */
    protected $extendedValidations = [
        'min',
        'max',
        'mustInclude',
        'mustNotInclude',
        'inList',
        'sameAs'
    ];
    
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

        $settings = $this->config['edit.']['validation.'];

        #$validationString = $this->getValidationString($this->config, 'firstName.');
        # var_dump($validationString);exit;

        $errorMessages = [];
        $fieldsToValidate = json_decode($data);
        
        
        if (count($fieldsToValidate) == 0) {
            return '{"validate":0}';
        }
        
        foreach ($fieldsToValidate as $field => $value) {
            
            $validation = '';
            switch ($field) {
                case 'firstName':
                    $validation = $this->getValidationString($this->config, 'firstName.');
                    break;
                case 'middleName':
                    $validation = $this->getValidationString($this->config, 'middleName.');
                    break;
                case 'lastName':
                    $validation = $this->getValidationString($this->config, 'lastName.');
                    break;
                case 'dateOfBirth':
                    $validation = 'date,required';
                    break;
                case 'cityId':
                    if ($value <= 0) {
                        $errorMessages[] = array('femanager_field_city' => 'Город не указан');
                    }
                    break;
                case 'zip':
                    $validation = 'min(5),max(5),intOnly,required';
                    break;
                case 'gender':
                    if ($value == 0) {
                        $errorMessages[] = array('femanager_field_gender' => 'Пол не указан');
                        $errorMessages['gender'] = array('Пол не указан');
                    }
                    break;
                case 'password':
                     $validation = 'min(6),mustInclude(number)';
                     break;
                case 'password_repeat':
                    $validation = 'required,sameAs(password)';
                    break;
                default:
            }
            
            if ($validation !== '') {
                
                $clientsideValidator = $this->clientsideValidator;

                $additionalValue = '';
                # var_dump($fieldsToValidate);
                if ($field == 'password_repeat') {
                    $additionalValue = $fieldsToValidate->password;
                }

                $result = $clientsideValidator
                    ->setValidationSettingsString($validation)
                    ->setValue($value)
                    ->setAdditionalValue($additionalValue)
                    ->validateField();
                
                if (!$result) {
                    $messages['field_' . $field] = $this->clientsideValidator->getMessages();
                    $this->clientsideValidator->setMessages(array());
                }
                
            }
        }

        // var_dump($messages);;
        if (is_array($messages) && count($messages) > 0) {
            foreach ($messages as $field => $fieldMessages) {
                foreach ($fieldMessages as $fieldMessage) {
                    # echo $field . '_' . $fieldMessage . "\n";
                    // $errorMessages[] = array('femanager_' . $field => sprintf(LocalizationUtility::translate($field . '_' . $fieldMessage, "femanager")));
                    if ($field == 'field_dateOfBirth') {
                        $errorMessages[] = array('femanager_container_dateOfBirth' => $field . '_' . $fieldMessage);
                    }
                    else {
                        $errorMessages[] = array('femanager_' . $field => $field . '_' . $fieldMessage);
                    }
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


    /**
     * Get validation string like
     *        required, email, min(10), max(10), intOnly,
     *        lettersOnly, uniqueInPage, uniqueInDb, date,
     *        mustInclude(number|letter|special), inList(1|2|3)
     *
     * @param array $settings Validation TypoScript
     * @param string $fieldName Fieldname
     * @return string
     */
    protected function getValidationString($settings, $fieldName)
    {
        $string = '';
        $validationSettings = (array) $settings['edit.']['validation.'][$fieldName];
        foreach ($validationSettings as $validation => $configuration) {
            if (!empty($string)) {
                $string .= ',';
            }
            $string .= $this->getSingleValidationString($validation, $configuration);
        }
        return $string;
    }

    /**
     * @param string $validation
     * @param string $configuration
     * @return string
     */
    protected function getSingleValidationString($validation, $configuration)
    {
        $string = '';
        if ($this->isSimpleValidation($validation) && $configuration === '1') {
            $string = $validation;
        }
        if (!$this->isSimpleValidation($validation)) {
            $string = $validation;
            $string .= '(' . str_replace(',', '|', $configuration) . ')';
        }
        return $string;
    }

    /**
     * Check if validation is simple or extended
     *
     * @param string $validation
     * @return bool
     */
    protected function isSimpleValidation($validation)
    {
        if (in_array($validation, $this->extendedValidations)) {
            return false;
        }
        return true;
    }


}