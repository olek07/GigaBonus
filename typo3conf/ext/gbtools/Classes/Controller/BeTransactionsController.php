<?php
namespace Gigabonus\Gbtools\Controller;

use Gigabonus\Gbaccount\Domain\Repository\TransactionRepository;
use Gigabonus\Gbfemanager\Domain\Model\User;
use Gigabonus\Gborderapi\Domain\Repository\OrderRepository;
use Gigabonus\Gbpartner\Domain\Model\Partner;
use In2code\Femanager\Domain\Repository\UserRepository;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
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

/**
 * OrderController
 */
class BeTransactionsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * transactionRepository
     *
     * @var \Gigabonus\Gbaccount\Domain\Repository\TransactionRepository
     * @inject
     */
    protected $transactionRepository = NULL;




    /**
     * action new
     * 
     * @return void
     */
    public function indexAction() {

        /** @var UserRepository $userRepository */
        $userRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(UserRepository::class);

        $query = $userRepository->createQuery();
        $query->getQuerySettings()->setLanguageUid(0);
        $query->getQuerySettings()->setStoragePageIds([5]);
        $result = $query->execute();

        $users = [];
        foreach ($result as $entry) {
            $user = new \stdClass();
            $user->value = $entry->getUid() . ' ' . $entry->getFirstName() . ' ' . $entry->getLastName();
            $user->key = $entry->getUid();
            $users[] = $user;
        }

        # DebuggerUtility::var_dump($users);

        $this->view->assign('users', $users);

    }




    public function showAction() {
        # $formData = $this->request->getArgument('transactionList');


        $query = $this->transactionRepository->createQuery();
        $query->getQuerySettings()->setLanguageUid(0);
        $query->getQuerySettings()->setStoragePageIds([13]);
        $and = [
            # $query->equals('user', $formData['user']),
             $query->equals('user', 6),
            // $query->equals('deleted', 0)
        ];

        $constraint = $query->logicalAnd($and);
        $query->matching($constraint);

        $result = $query->execute();


        $this->view->assign('transactions', $result);

        
    }


    


}