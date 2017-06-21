<?php
namespace Gigabonus\Gborderapi\Controller;

use Gigabonus\Gborderapi\Domain\Repository\OrderRepository;
use Gigabonus\Gbpartner\Domain\Model\Partner;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
class BeOrderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * orderRepository
     *
     * @var \Gigabonus\Gborderapi\Domain\Repository\OrderRepository
     * @inject
     */
    protected $orderRepository = NULL;


    /**
     * action new
     * 
     * @return void
     */
    public function listAction()
    {
        $orders = $this->orderRepository->findAll();
        $this->view->assign('orders', $orders);
    }




}