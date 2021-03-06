define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'maksuturva_base_payment',
                component: 'Svea_MaksuturvaBase/js/view/payment/method-renderer/maksuturva_base_payment'
            }
        );
        return Component.extend({});
    }
);
