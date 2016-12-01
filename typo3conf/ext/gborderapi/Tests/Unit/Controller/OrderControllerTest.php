<?php
namespace Gigabonus\Gborderapi\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Gigabonus\Gborderapi\Controller\OrderController.
 *
 */
class OrderControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Gigabonus\Gborderapi\Controller\OrderController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Gigabonus\\Gborderapi\\Controller\\OrderController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenOrderToOrderRepository()
	{
		$order = new \Gigabonus\Gborderapi\Domain\Model\Order();

		$orderRepository = $this->getMock('Gigabonus\\Gborderapi\\Domain\\Repository\\OrderRepository', array('add'), array(), '', FALSE);
		$orderRepository->expects($this->once())->method('add')->with($order);
		$this->inject($this->subject, 'orderRepository', $orderRepository);

		$this->subject->createAction($order);
	}
}
