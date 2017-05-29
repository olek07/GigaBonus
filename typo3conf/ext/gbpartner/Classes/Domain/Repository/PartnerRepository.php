<?php
namespace Gigabonus\Gbpartner\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Alexander Averbuch <alav@gmx.net>
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
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * The repository for Partners
 */
class PartnerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{


    /**
     * @param array $uidlist
     * @return QueryResultInterface
     */
    public function findByUidList(array $uidList){
        /** @var QueryInterface $query */
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);

        $constraints = array();
        
        if (count($uidList) > 0) {
            foreach($uidList as $uid){
                $constraints[] = $query->equals('uid', $uid);
            }
        }
        
        $query->matching(
            $query->logicalOr(
                $constraints
            )
        );
        
        $query->setOrderings($this->orderByKey('uid', $uidList));
        return $query->execute();
    }


    /**
     * @param $key
     * @param $uidList
     * @return array
     */
    protected function orderByKey($key, $uidList) {
        $order = array();
        
        foreach ($uidList as $uid) {
            $order["$key={$uid}"] = QueryInterface::ORDER_DESCENDING;
        }

        return $order;
    }


    /**
     * @param array $partnerIds
     * @return array
     */

    public function ___getPartnersForEntryPage(array $partnerIds) {

/*
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(true);
        $query->matching($query->in('uid', $partnerIds));
        $query->getQuerySettings()->setLanguageUid(0);
        $query->getQuerySettings()->setStoragePageIds([11]);
        $partners = $query->execute();
*/
        $partners = [];

        foreach ($partnerIds as $partnerId) {
            $partners[] = $this->findByUid($partnerId);
        }

        return $partners;

    }
    
}