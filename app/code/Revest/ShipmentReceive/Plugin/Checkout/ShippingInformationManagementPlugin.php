<?php

declare(strict_types=1);

namespace Revest\ShipmentReceive\Plugin\Checkout;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Api\ShippingInformationManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;

class ShippingInformationManagementPlugin
{
    private const ALLOWED_VALUES = ['home', 'work', 'other'];

    private CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Save shipment receive value to quote before processing shipping information.
     *
     * @param ShippingInformationManagementInterface $subject
     * @param int $cartId
     * @param ShippingInformationInterface $addressInformation
     * @return array
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagementInterface $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ): array {
        $extensionAttributes = $addressInformation->getExtensionAttributes();

        if ($extensionAttributes && $extensionAttributes->getShipmentReceive()) {
            $value = $extensionAttributes->getShipmentReceive();

            if (in_array($value, self::ALLOWED_VALUES, true)) {
                $quote = $this->cartRepository->getActive($cartId);
                $quote->setData('shipment_receive', $value);
            }
        }

        return [$cartId, $addressInformation];
    }
}
