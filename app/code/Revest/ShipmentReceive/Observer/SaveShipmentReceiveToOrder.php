<?php

declare(strict_types=1);

namespace Revest\ShipmentReceive\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SaveShipmentReceiveToOrder implements ObserverInterface
{
    /**
     * Copy shipment_receive from quote to order.
     */
    public function execute(Observer $observer): void
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();

        if ($quote->getData('shipment_receive')) {
            $order->setData('shipment_receive', $quote->getData('shipment_receive'));
        }
    }
}
