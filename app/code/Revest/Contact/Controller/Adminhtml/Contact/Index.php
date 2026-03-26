<?php
/**
 * Revest Contact Manager - Admin Module controller
 *
 * @category  Revest
 * @package   Revest_Contact
 */
namespace Revest\Contact\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Revest_Contact::contact');
        $resultPage->getConfig()->getTitle()->prepend(__('Contact Request'));
        return $resultPage;
    }
}