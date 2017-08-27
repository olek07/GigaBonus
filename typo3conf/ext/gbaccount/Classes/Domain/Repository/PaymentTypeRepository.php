<?php
namespace Gigabonus\Gbaccount\Domain\Repository;

/**
 * The repository for PaymentTypes
 */
class PaymentTypeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );
}
