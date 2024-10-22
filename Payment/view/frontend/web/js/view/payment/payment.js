define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Tlync_Payment/payment/payment'  // Ensure this path matches your template file.
            }
        });
    }
);
