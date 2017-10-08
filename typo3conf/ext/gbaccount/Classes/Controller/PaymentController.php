<?php
namespace Gigabonus\Gbaccount\Controller;



use Gigabonus\Gbaccount\Domain\Model\Payment;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class PaymentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {


    /**
     * transactionRepository
     *
     * @var \Gigabonus\Gbaccount\Domain\Repository\TransactionRepository
     * @inject
     */
    protected $transactionRepository = NULL;

    /**
     * @var \Gigabonus\Gbaccount\Domain\Repository\PaymentTypeRepository
     * @inject
     */
    protected $paymentTypeRepository = NULL;


    /**
     * @var \Gigabonus\Gbaccount\Domain\Repository\PaymentRepository
     * @inject
     */
    protected $paymentRepository = NULL;


    public function indexAction() {
        echo $this->transactionRepository->getBonusBalance(6);
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];

        $payments = $this->paymentRepository->findByUser($userId);
        $paymentTypes = $this->paymentTypeRepository->findAll();


       # DebuggerUtility::var_dump($payments);

        /** @var \Gigabonus\Gbaccount\Domain\Model\Payment $payment */
        /*
        $payment = $this->objectManager->get('Gigabonus\\Gbaccount\\Domain\\Model\\Payment');

        $payment->setAmount(300);
        $payment->setUser(6);
        $payment->setPaidStatus(false);
        $payment->setPaymentData('not yet paid');

        $this->paymentRepository->add($payment);
        */

        $this->view->assign('payments', $payments);
        $this->view->assign('paymentTypes', $paymentTypes);

    }

    /**
     * action payout
     *
     * @param \Gigabonus\Gbaccount\Domain\Model\Payment|null $payment
     * @return void
     */
    public function payoutAction(Payment $payment = null) {
        /**
         * @todo: implement validation of payment
         */
        if ($payment != NULL) {
            $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
            if ($payment->getAmount() > $this->transactionRepository->getBonusBalance($userId)) {
                # $this->addFlashMessage(LocalizationUtility::translate('not enough bonus', 'gbaccount'), '', FlashMessage::ERROR);
                $this->addFlashMessage('not enough bonus', 'gbaccount', '', FlashMessage::ERROR);
                $this->redirect('index');
            }
            else {
                /** @var \Gigabonus\Gbaccount\Domain\Model\Transaction $transaction */
                $transaction = $this->objectManager->get('Gigabonus\\Gbaccount\\Domain\\Model\\Transaction');

                $transaction->setAmount(-$payment->getAmount());
                $transaction->setUser($userId);

                $this->transactionRepository->add($transaction);

                $payment->setUser($userId);
                $payment->setPaidStatus(false);
                $this->paymentRepository->add($payment);
            }
        }

        DebuggerUtility::var_dump($payment);
    }
}