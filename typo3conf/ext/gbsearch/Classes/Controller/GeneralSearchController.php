<?php
namespace Gigabonus\Gbsearch\Controller;

use Gigabonus\Gbpartner\Domain\Model\Partner;

class GeneralSearchController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * @param $s
     * @return Partner
     */
    public function doSearch($s) {
        $query = $this->partnerRepository->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(true);

        $s = trim($s);
        $s = preg_replace('~\s+~' , ' ',  $s);

        $query->matching(
            $query->logicalOr(
                $query->like('name', '%' . $s . '%', false),
                $query->like('tags', '%' . $s . '%', false),
                $query->like('teaser', '%' . $s . '%', false)
            )
        );

        // $query->matching($query->in('uid', array(1,3,5,8,14)));

        $query->getQuerySettings()->setLanguageUid($GLOBALS['TSFE']->sys_language_uid);
        $query->getQuerySettings()->setStoragePageIds([11]);


        $partners = $query->execute();
        
        return $partners;
    }
}