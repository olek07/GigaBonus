<?php
namespace Gigabonus\Gbsearch\Controller;

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
use Gigabonus\Gbbase\Utility\Helpers\MainHelper;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * CategoryController
 */
class SearchController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * partnerRepository
     *
     * @var \Gigabonus\Gbpartner\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = NULL;


    /**
     * categoryRepository
     *
     * @var \Gigabonus\Gbpartner\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = NULL;



    /**
     * action search
     * 
     * @return void
     */
    public function searchAction()
    {
        // $partners = $this->partnerRepository->findAll();

        $query = $this->partnerRepository->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching($query->in('uid', array(1,3,5,8,14)));
        //$query->getQuerySettings()->setLanguageUid(0);
       // $query->getQuerySettings()->setStoragePageIds([11]);
        $partners = $query->execute();

        $this->view->assign('partnerDetailPageUid', MainHelper::PARTNERDETAILPAGEID);
        $this->view->assign('partners', $partners);
    }

}