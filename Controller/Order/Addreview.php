<?php
namespace OAG\OrderReview\Controller\Order;

class Addreview extends \Magento\Framework\App\Action\Action
{
    /**
     * Holds page factory object class
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $pageFactory;

    /**
     * Holds module helper object class
     * @var \OAG\OrderReview\Helper
     */
    protected $helper;

    /**
     * construct function
     * @param \Magento\Framework\App\Action\Context      $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \OAG\OrderReview\Helper\Data               $helper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \OAG\OrderReview\Helper\Data $helper
    )
    {
        $this->pageFactory = $pageFactory;
        $this->helper = $helper;
        return parent::__construct($context);
    }

    public function execute()
    {
        $token = $this->getRequest()->getParam('token');
        $incrementid = $this->getRequest()->getParam('increment_id');
        if ($token != $this->helper->getToken($incrementid)) {
            //@todo: redirect to 404 page
            die("Error in url, token incorrect");
        }
        return $this->pageFactory->create();
    }
}

