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

/**
 * Partner categories
 */
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Partners
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gigabonus\Gbpartner\Domain\Model\Partner>
     * @lazy
     */
    protected $partners;


    /**
     * @var int
     */
    protected $sysLanguageUid;

    /**
     * @var int
     */
    protected $l10nParent;


    /**
     * name
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';
    
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
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $partners
     */
    public function setPartners($partners)
    {
        $this->partners = $partners;
    }


    /**
     * Set sys language
     *
     * @param int $sysLanguageUid
     * @return void
     */
    public function setSysLanguageUid($sysLanguageUid)
    {
        $this->_languageUid = $sysLanguageUid;
    }

    /**
     * Get sys language
     *
     * @return int
     */
    public function getSysLanguageUid()
    {
        return $this->_languageUid;
    }

    /**
     * Set l10n parent
     *
     * @param int $l10nParent
     * @return void
     */
    public function setL10nParent($l10nParent)
    {
        $this->l10nParent = $l10nParent;
    }

    /**
     * Get l10n parent
     *
     * @return int
     */
    public function getL10nParent()
    {
        return $this->l10nParent;
    }


    /**
     * __construct
     */
    /*
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    */
    
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
        
    }

}