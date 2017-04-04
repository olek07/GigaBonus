<?php
namespace Gigabonus\Gbpartner\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Alexander Averbuch <alav@gmx.net>
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
 * Test case for class Gigabonus\Gbpartner\Controller\PartnerController.
 *
 * @author Alexander Averbuch <alav@gmx.net>
 */
class PartnerControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Gigabonus\Gbpartner\Controller\PartnerController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Gigabonus\\Gbpartner\\Controller\\PartnerController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllPartnersFromRepositoryAndAssignsThemToView()
	{

		$allPartners = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$partnerRepository = $this->getMock('Gigabonus\\Gbpartner\\Domain\\Repository\\PartnerRepository', array('findAll'), array(), '', FALSE);
		$partnerRepository->expects($this->once())->method('findAll')->will($this->returnValue($allPartners));
		$this->inject($this->subject, 'partnerRepository', $partnerRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('partners', $allPartners);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenPartnerToView()
	{
		$partner = new \Gigabonus\Gbpartner\Domain\Model\Partner();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('partner', $partner);

		$this->subject->showAction($partner);
	}
}
