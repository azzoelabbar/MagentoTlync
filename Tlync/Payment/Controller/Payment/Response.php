<?php
namespace Tlync\Payment\Controller\Payment;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Response extends Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // Handle the response from TLYNC payment gateway here
        // Example: Check payment status and display success or failure message
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
