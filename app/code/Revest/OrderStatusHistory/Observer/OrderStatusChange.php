<?php
namespace Revest\OrderStatusHistory\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\State;
use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Observer to track order status changes
 * Adds comment with user (admin/customer) and timestamp
 */
class OrderStatusChange implements ObserverInterface
{
    protected $appState;
    protected $adminSession;
    protected $customerSession;

    public function __construct(
        State $appState,
        AdminSession $adminSession,
        CustomerSession $customerSession
    ) {
        $this->appState = $appState;
        $this->adminSession = $adminSession;
        $this->customerSession = $customerSession;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();

        // Get original status before change
        $originalStatus = $order->getOrigData('status');
        $newStatus = $order->getStatus();

        // Only proceed if status is changed
        if ($originalStatus == $newStatus) {
            return;
        }

        // Default user info
        $userName = 'ramendra';

        try {
            // Check if request is from admin
            if ($this->appState->getAreaCode() === \Magento\Framework\App\Area::AREA_ADMINHTML) {

                // Get admin user
                $adminUser = $this->adminSession->getUser();

                if ($adminUser) {
                    $userName = $adminUser->getName();
                }

            } else {
                // Frontend case → get customer
                if ($this->customerSession->isLoggedIn()) {
                    $customer = $this->customerSession->getCustomer();
                    $userName = $customer->getFirstname() . ' ' . $customer->getLastname();
                } else {
                    $userName = 'Guest Customer';
                }
            }
        } catch (\Exception $e) {
            $userName = 'Unknown';
        }

        // Current date time
        $dateTime = date('Y-m-d H:i:s');

        // Prepare comment
        $comment = sprintf(
            'Order status changed from "%s" to "%s" by %s on %s',
            $originalStatus,
            $newStatus,
            $userName,
            $dateTime
        );

        // Add comment to order history
        $order->addStatusHistoryComment($comment)
              ->setIsCustomerNotified(false);
    }
}