<?php
namespace Gigabonus\Gbfemanager\Controller;


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
     * @param string $dateOfBirth
     * @return string
     */
    public function validateAction($dateOfBirth = null) {
        
        
        $validation = 'date,required';
        $field = 'dateOfBirth';
        $additionalValue = null;
        
        $result = $this->clientsideValidator
            ->setValidationSettingsString($validation)
            ->setValue($dateOfBirth)
            ->validateField();
        
        $this->view->assignMultiple(
            [
                'isValid' => $result,
                'messages' => $this->clientsideValidator->getMessages(),
                'validation' => $validation,
                'value' => $value,
                'fieldname' => $field,
                'user' => $user
            ]
        );

        $errorMessage = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($this->clientsideValidator->getMessages()[0], "femanager");
        $response = '{"validate":0, "message": "' . $errorMessage . '"}';
  #  \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($result);
  # \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->clientsideValidator->getMessages());
        
return $response;        
    }
}