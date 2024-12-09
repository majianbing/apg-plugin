
const apgcreditcard_settings = window.wc.wcSettings.getSetting( 'apgcreditcard_data', {} );


const apgcreditcard_label = window.wp.htmlEntities.decodeEntities( apgcreditcard_settings.title ) || window.wp.i18n.__( 'APGpayment Creditcard Payment Gateway', 'apgpayment-creditcard-gateway' );




const apgcreditcard_Content = () => {
    return window.wp.htmlEntities.decodeEntities( apgcreditcard_settings.description || '' );
};


var I = function(e) {
    var t = e.components,
        n = e.title,
        r = e.icons,
        a = e.id;
    Array.isArray(r) || (r = [r]);
    var o = t.PaymentMethodLabel,
        i = t.PaymentMethodIcons;
    return React.createElement("div", {
        className: "wc-apgcreditcard-blocks-payment-method__label ".concat(a)
    }, React.createElement(o, {
        text: n
    }), React.createElement(i, {
        icons: r
    }))
};
const APGcreditcard_Block_Gateway = {
    name: 'apgcreditcard',

    label: React.createElement(I, {
        id: "apgcreditcard",
        title: apgcreditcard_settings.title,
        icons: apgcreditcard_settings.icons
    }),

    content: Object( window.wp.element.createElement )( apgcreditcard_Content, null ),
    edit: Object( window.wp.element.createElement )( apgcreditcard_Content, null ),
    canMakePayment: () => true,
    ariaLabel: apgcreditcard_label,
    // placeOrderButtonLabel: window.wp.i18n.__( 'Proceed to pay', 'apgpayment-creditcard-gateway' ),
  /*  supports: {
        features: apgcreditcard_settings.supports,
    },*/
};

window.wc.wcBlocksRegistry.registerPaymentMethod( APGcreditcard_Block_Gateway );