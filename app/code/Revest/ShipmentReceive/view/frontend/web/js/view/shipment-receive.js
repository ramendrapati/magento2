define([
    'uiComponent',
    'ko',
    'jquery'
], function (Component, ko, $) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Revest_ShipmentReceive/shipment-receive'
        },

        shipmentReceive: ko.observable('home'),

        initialize: function () {
            this._super();
            return this;
        },

        /**
         * Callback fired by afterRender in the template.
         * Moves this section out of the Shipping Methods container and places it
         * as an independent <li> above the Shipping Methods <li> in the checkout
         * step list.
         */
        onRender: function (element) {
            var $el = $(element),
                $shippingMethodLi = $el.closest('#opc-shipping_method');

            if (!$shippingMethodLi.length) {
                return;
            }

            var $wrapper = $('<li/>', {
                'id': 'opc-shipment-receive',
                'class': 'checkout-shipment-receive'
            });

            $el.appendTo($wrapper);
            $wrapper.insertBefore($shippingMethodLi);

            // Keep visibility in sync with the Shipping Address section
            var shippingEl = document.getElementById('shipping');

            if (shippingEl) {
                new MutationObserver(function () {
                    $wrapper.toggle($(shippingEl).is(':visible'));
                }).observe(shippingEl, {attributes: true, attributeFilter: ['style']});
            }
        }
    });
});
