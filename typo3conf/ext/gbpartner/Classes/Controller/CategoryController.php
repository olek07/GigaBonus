<?php
namespace Gigabonus\Gbpartner\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
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

/**
 * CategoryController
 */
class CategoryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * categoryRepository
     * 
     * @var \Gigabonus\Gbpartner\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = NULL;
    
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
     * @return void
     */
    public function listAction()
    {
        $categories = $this->categoryRepository->findAll();

        $this->view->assign('currentCategory', GeneralUtility::_GET('tx_gbpartner_partnerlisting')['category']);
        $this->view->assign('categories', $categories);
    }
    
    /**
     * action show
     * 
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $category
     * @return void
     */
    public function showAction(\Gigabonus\Gbpartner\Domain\Model\Category $category = null)
    {

        if ($category === NULL) {
            DebuggerUtility::var_dump($this->partnerRepository->findAll());
            return;
        }

        // DebuggerUtility::var_dump($this->partnerRepository->findByCategory($category));

        $query = $this->partnerRepository->createQuery();
        // $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->getQuerySettings()->setRespectSysLanguage(false);


        // $query->getQuerySettings()->setRespectStoragePage(FALSE);

        // $query = $query->matching($query->logicalNot($query->equals('image', 0)));
        $result = $query->execute();

        // DebuggerUtility::var_dump($result);

        /*
        $object = NULL;
        if (count($result) > 0) {
            $object = $result->getFirst();
            $this->identityMap->registerObject($object, $uid);
        }
        */


        /*
        foreach ($category as $item) {
            
        }

        $header = $content->getHeader();
        */
        /*
        $categoryId = $category->getUid();
        $query = $this->partnerRepository->createQuery();
        $query->matching($query->like('category', $categoryId));
        DebuggerUtility::var_dump($query->execute());
        */

        $this->view->assign('category', $category);
    }

}