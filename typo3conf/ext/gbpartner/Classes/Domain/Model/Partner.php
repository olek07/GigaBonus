<?php
namespace Gigabonus\Gbpartner\Domain\Model;

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
 * Partner
 */
class Partner extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';
    
    /**
     * teaser
     * 
     * @var string
     */
    protected $teaser = '';
    
    /**
     * description
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * image
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image = null;


    /**
     * websiteUrl
     *
     * @var string
     */
    protected $websiteUrl = '';


    /**
     * incentive
     *
     * @var string
     */
    protected $incentive = '';

    /**
     * category
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gigabonus\Gbpartner\Domain\Model\Category>
     * @cascade remove
     */
    protected $category = null;
    
    /**
     * mainCategory
     * 
     * @var int
     * 
     */
    protected $mainCategory = 0;

    /**
     * @var \TYPO3\CMS\Core\Resource\FileRepository
     * @inject
     */
    protected $typo3FALRepository;

    /**
     * @var string
     */
    protected $apiKey = '';

    /**
     * @var string
     */
    protected $className = '';


    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the teaser
     * 
     * @return string $teaser
     */
    public function getTeaser()
    {
        return $this->teaser;
    }
    
    /**
     * Sets the teaser
     * 
     * @param string $teaser
     * @return void
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;
    }
    
    /**
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * @return mixed
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * @param mixed $websiteUrl
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    }

    /**
     * @return string
     */
    public function getIncentive()
    {
        return $this->incentive;
    }

    /**
     * @param string $incentive
     */
    public function setIncentive($incentive)
    {
        $this->incentive = $incentive;
    }


    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage() {
        $objectUid = $this->getUid();
        $objectUidLocalized = $this->_localizedUid;

        $image = $this->findImageByRelation($objectUidLocalized,'image');

        if(!$image){
            $image = $this->findImageByRelation($objectUid,'image');
        }


        return $image;
    }
    
    /**
     * Sets the image
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }


    
    

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->category = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Adds a Category
     * 
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\Gigabonus\Gbpartner\Domain\Model\Category $category)
    {
        $this->category->attach($category);
    }
    
    /**
     * Removes a Category
     * 
     * @param \Gigabonus\Gbpartner\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(\Gigabonus\Gbpartner\Domain\Model\Category $categoryToRemove)
    {
        $this->category->detach($categoryToRemove);
    }
    
    /**
     * Returns the category
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gigabonus\Gbpartner\Domain\Model\Category> $category
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Sets the category
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gigabonus\Gbpartner\Domain\Model\Category> $category
     * @return void
     */
    public function setCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $category)
    {
        $this->category = $category;
    }

    
    /**
     * Returns the mainCategory
     * 
     * @return int
     */
    public function getMainCategory()
    {
        return $this->mainCategory;
    }
    
    
    /**
     * Sets the mainCategory
     * 
     * @param int $mainCategory
     * @return void
     */
    public function setMainCategory($mainCategory)
    {
        $this->mainCategory = $mainCategory;
    }
    
    

    protected function findImageByRelation($uid, $fieldname){

        $fileObject = NULL;
        $tablename = 'tx_gbpartner_domain_model_partner';
        $fileObjects = $this->typo3FALRepository->findByRelation($tablename, $fieldname, $uid);


        $files = array();
        foreach ($fileObjects as $key => $value) {
            $files[$key]['reference'] = $value->getReferenceProperties();
            $files[$key]['original'] = $value->getOriginalFile()->getProperties();
        }

        return $files;



        return $fileObject;
    }


}