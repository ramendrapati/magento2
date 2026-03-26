<?php

declare(strict_types=1);

namespace Revest\ShipmentReceive\Block\Adminhtml\Order;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;

class ShipmentReceiveInfo extends Template
{
    private const LABELS = [
        'home' => 'Home',
        'work' => 'Work',
        'other' => 'Other',
    ];

    private Registry $coreRegistry;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Get the order associated with the current admin page.
     */
    private function getOrder(): ?Order
    {
        $order = $this->coreRegistry->registry('current_order');
        if ($order) {
            return $order;
        }

        $shipment = $this->coreRegistry->registry('current_shipment');
        if ($shipment) {
            return $shipment->getOrder();
        }

        return null;
    }

    /**
     * Get the raw shipment_receive value.
     */
    public function getShipmentReceive(): ?string
    {
        $order = $this->getOrder();
        return $order ? $order->getData('shipment_receive') : null;
    }

    /**
     * Get the human-readable label for the shipment_receive value.
     */
    public function getShipmentReceiveLabel(): ?string
    {
        $value = $this->getShipmentReceive();
        return $value ? (self::LABELS[$value] ?? ucfirst($value)) : null;
    }
}
