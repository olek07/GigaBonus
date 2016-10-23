<?php
namespace Gigabonus\Gbpartner\Controller;

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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * PartnerController
 */
class PartnerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * partnerRepository
     * 
     * @var \Gigabonus\Gbpartner\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = NULL;
    
    /**
     * action list
     *
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $category
     * 
     * @return void
     */
    public function listAction(\Gigabonus\Gbpartner\Domain\Model\Category $category = null)
    {

        // $partners = $this->partnerRepository->findAll();
        // DebuggerUtility::var_dump($partners);
        // $this->view->assign('partners', $partners);

        $this->view->assign('category', $category);
    }
    
    /**
     * action show
     * 
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $category
     * @return void
     */
    public function showAction(\Gigabonus\Gbpartner\Domain\Model\Partner $partner = null, \Gigabonus\Gbpartner\Domain\Model\Category $category = null)
    {
        if ($partner == NULL) {
            $this->forward('list', null, null, array('category' => $category));
        }
        else {
            $this->view->assign('category', $category);
            $this->view->assign('partner', $partner);
        }
    }

}