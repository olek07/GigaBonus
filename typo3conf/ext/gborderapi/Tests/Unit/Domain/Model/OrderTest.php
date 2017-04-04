<?php

namespace Gigabonus\Gborderapi\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 
 *
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
 * Test case for class \Gigabonus\Gborderapi\Domain\Model\Order.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class OrderTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Gigabonus\Gborderapi\Domain\Model\Order
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Gigabonus\Gborderapi\Domain\Model\Order();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getPartnerIdReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setPartnerIdForIntSetsPartnerId()
	{	}

	/**
	 * @test
	 */
	public function getOrderidReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getOrderid()
		);
	}

	/**
	 * @test
	 */
	public function setOrderidForStringSetsOrderid()
	{
		$this->subject->setOrderid('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'orderid',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAmountReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getAmount()
		);
	}

	/**
	 * @test
	 */
	public function setAmountForFloatSetsAmount()
	{
		$this->subject->setAmount(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'amount',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getFeeReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getFee()
		);
	}

	/**
	 * @test
	 */
	public function setFeeForFloatSetsFee()
	{
		$this->subject->setFee(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'fee',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getStatusReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setStatusForIntSetsStatus()
	{	}

	/**
	 * @test
	 */
	public function getUserIdReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setUserIdForIntSetsUserId()
	{	}

	/**
	 * @test
	 */
	public function getCurrencyReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getCurrency()
		);
	}

	/**
	 * @test
	 */
	public function setCurrencyForStringSetsCurrency()
	{
		$this->subject->setCurrency('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'currency',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDataReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getData()
		);
	}

	/**
	 * @test
	 */
	public function setDataForStringSetsData()
	{
		$this->subject->setData('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'data',
			$this->subject
		);
	}
}
