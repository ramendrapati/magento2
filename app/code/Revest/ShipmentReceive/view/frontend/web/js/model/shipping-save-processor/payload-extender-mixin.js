define([
    'mage/utils/wrapper',
    'uiRegistry'
], function (wrapper, registry) {
    'use strict';

    return function (originalFunction) {
        return wrapper.wrap(originalFunction, function (original, payload) {
            original(payload);

            var shipmentReceiveComponent = registry.get(
                'checkout.steps.shipping-step.shippingAddress.before-shipping-method-form.shipment-receive'
            );

            if (shipmentReceiveComponent && shipmentReceiveComponent.shipmentReceive()) {
                if (!payload.addressInformation.extension_attributes) {
                    payload.addressInformation.extension_attributes = {};
                }

                payload.addressInformation.extension_attributes.shipment_receive =
                    shipmentReceiveComponent.shipmentReceive();
            }

            return payload;
        });
    };
});
