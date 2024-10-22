define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';

    rendererList.push({
        type: 'tlyncpayment',
        component: 'tlync_Payment/js/view/payment/tlyncpayment'
    });

    return Component.extend({});
});