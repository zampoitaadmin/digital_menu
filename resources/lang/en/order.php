<?php
return [
    'missing_required_data' => 'Missing required data',
    'order_select_package' => 'Select Your Package',
    'order_menu_choice' => 'Menu Choice',
    'order_product_not_available' => 'No Menu Available...!!!',

    //Alert and Notification Message
    'common_error_msg' => 'Something went wrong. Please try again.',
    'cart_save_failed' => 'Cart could not be saved',
    'cart_plan_type_invalid' => 'Invalid Plan Type',
    'cart_is_empty' => 'Your cart is empty',
    'cart_item_added_success' => 'Item added successfully',
    'cart_voucher_added_success' => 'Gift voucher added successfully',
    'cart_voucher_added_error' => 'Gift voucher could not be added',
    'cart_item_save_failed' => 'Item could not be saved',
    'cart_item_save_success' => 'Item saved successfully',
    'cart_item_not_found' => 'Item could not be found',
    'cart_cart_empty' => 'Cart is empty.',
    'cart_product_limit_exceed' => "You can't exceed your limit.",
    'cart_product_limit_error' => "Please select minimum products",
    'cart_voucher_limit_exceed' => "You can't exceed voucher quantity greater than 1. <br> If your want multiple then add it again.",
    'cart_delivery_date_missing' => "Please select your delivery date",
    'cart_delivery_date_error' => "Delivery date should be grater than current date",
    'cart_coupon_code_not_exist_error' => "Invalid discount code",
    'cart_coupon_code_required' => "Discount code required",
    'cart_coupon_code_applied' => "Discount code applied successfully",
    'cart_coupon_code_reset' => "Reset discount code successfully",
    'cart_voucher_code_applied' => "Voucher code applied successfully",
    'cart_voucher_code_used' => "Voucher Code is already used.",
    'cart_voucher_code_expired' => "Voucher Code is expired",
    'cart_order_total_zero' => "Order amount should be grater than zero",
    'cart_extra_min_order_amount_error' => "Please select minimum order amount",
    'cart_urgent_order_success' => "Advance urgent order shipping updated successfully",
    'cart_urgent_order_failed' => 'Advance urgent order shipping could not be updated',

    'stripe_token_missing' => "Something went wrong with payment card. ",
    'stripe_customer_create_error' => "Stripe customer creation failed.",
    'stripe_customer_attach_payment_error' => "Stripe failed to attach payment method to customer. :error",
    'stripe_customer_default_payment_error' => "Stripe failed to set default payment method to customer. :error",

    'stripe_manual_order_error' => "Please retry. :error",

    'order_not_found' => "Oops! Order not found.",
    'order_account_inactive' => "Your entered email account is inactive, please contact administrator.",
    'order_account_deleted' => "Your entered email account is deleted, please contact administrator.",
    'order_account_create_failed' => "Something went wrong.Please try again. [Error Code: U001]",

    'order_invalid' => "Invalid Order. Order Not Found.",
    'order_product_not_selected' => "Product not selected at this moment.",
    'order_order_item_not_Available' => "order item not found at this moment.",
    'order_paypal_processing_title' => "Please be patient while your transaction is being processed.",
    'order_transaction_processing_msg' => "Please be patient while your transaction is being processed. \n <br> Do not 'close the window' or press 'refresh' or 'browser back/forward' button",
    'order_created_success' => "Your order placed successfully.",
    'order_created_failed' => "Your order could not be placed. Any  amount if deducted, will be refunded to your original mode of payment. Please contact administrator.", //payment within 5-7 bussiness days
    #'order_created_success_payment' => "Your order placed successfully. Your txn. id :txnId, OrderNumber::orderNumber",
    'order_created_success_payment' => "Thank you! <br> You order has been placed successfully.<br>  A confirmation email will be sent to you shortly.<br>  Order number : #:orderNumber",
    'order_shipping_not_allowed' => "shipping service is unavailable for this postcode",
    'order_payment_method_missing' => "Please select payment method",

    'order_product_sc_not_available' => 'No Product Available...!!!',
    'order_product_sc_not_exit' => 'signature collection is not exist any more',
]
?>