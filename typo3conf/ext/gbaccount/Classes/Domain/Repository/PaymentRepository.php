<?php
namespace Gigabonus\Gbaccount\Domain\Repository;

/**
 * The repository for Payments
 */
class PaymentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    protected $defaultOrderings = array(
        'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );
}
