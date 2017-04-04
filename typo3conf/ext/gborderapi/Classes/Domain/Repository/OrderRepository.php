<?php
namespace Gigabonus\Gborderapi\Domain\Repository;

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
use Gigabonus\Gborderapi\Domain\Model\Order;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * The repository for Orders
 */
class OrderRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );


    /**
     * Check if there is already an entry in the table
     *
     * @param $partnerId
     * @param $partnerOrderId
     * @return Order
     */
    public function checkUniqueDb($partnerId, $partnerOrderId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(true);
        // $query->getQuerySettings()->setIgnoreEnableFields(true);

        $and = [
            $query->equals('partner_id', $partnerId),
            $query->equals('partner_order_id', $partnerOrderId)
        ];

        $constraint = $query->logicalAnd($and);

        $query->matching($constraint);

        $order = $query->execute()->getFirst();
        return $order;
    }


}