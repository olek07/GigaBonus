<?php
namespace Gigabonus\Gbaccount\Controller;


use Gigabonus\Gbaccount\Domain\Repository\TransactionRepository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class DashboardController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * transactionRepository
     *
     * @var \Gigabonus\Gbaccount\Domain\Repository\TransactionRepository
     * @inject
     */
    protected $transactionRepository = NULL;



    public function indexAction() {
        $user = $GLOBALS['TSFE']->fe_user->user;

        $bonus = $this->transactionRepository->getBonusBalanceAndOnHold($user['uid']);

        $this->view->assign('user', $user);
        $this->view->assign('bonus', $bonus);
    }
}
