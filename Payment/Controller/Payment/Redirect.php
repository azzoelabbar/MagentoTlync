<?php

namespace Tlync\Payment\Controller\Payment;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Tlync\Payment\Model\Payment;

class Redirect extends Action
{
    protected $resultRedirectFactory;
    protected $paymentModel;

    public function __construct(
        Context $context,
        ResultFactory $resultRedirectFactory,
        Payment $paymentModel
    ) {
        parent::__construct($context);
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->paymentModel = $paymentModel;
    }

    public function execute()
    {
        // Retrieve the amount, phone, and email from the request
        $amount = $this->getRequest()->getParam('amount');
        $phone = $this->getRequest()->getParam('phone');
        $email = $this->getRequest()->getParam('email');

        // Input validation
        if (!$amount || !$phone || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->messageManager->addErrorMessage(__('Please provide all required fields with valid formats.'));
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }

        // Call the initiatePayment method
        try {
            $paymentResponse = $this->paymentModel->initiatePayment($amount, $phone, $email);
            if ($paymentResponse && isset($paymentResponse['status']) && $paymentResponse['status'] === 'success') {
                return $this->resultRedirectFactory->create()->setUrl($paymentResponse['url']);
            } else {
                $errorMessage = isset($paymentResponse['message']) ? $paymentResponse['message'] : __('An error occurred during payment initiation.');
                $this->messageManager->addErrorMessage($errorMessage);
                return $this->resultRedirectFactory->create()->setPath('checkout/cart');
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Payment initiation failed: %1', $e->getMessage()));
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }
    }
}
