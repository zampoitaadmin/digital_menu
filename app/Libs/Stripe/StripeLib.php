<?php
namespace App\Libs\Stripe;
use Mockery\CountValidator\Exception;

class StripeLib
{
    private $stripe;
    private $stripe_mode;
    private $stripe_publishable_key;
    private $stripe_api_key;

    public function __construct()
    {
        $this->stripe_mode = config('constants.stripe_mode');
        $this->stripe_publishable_key = config('constants.'.$this->stripe_mode.'.STRIPE_PUBLISHABLE_KEY');
        $this->stripe_api_key = config('constants.'.$this->stripe_mode.'.STRIPE_API_KEY');
        try {
            $this->stripe = new \Stripe\StripeClient($this->stripe_api_key);
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }
    }

    public function test($a)
    {
        $b = $a;
        return $b;
    }
    //BY VP
    public function customerCreate($customerData){
        $apiError = '';
        $status = false;
        $stripeCustomerId= '';
        try {
            $requestData = array();
            if(!empty($customerData['name'])){
                $requestData['name'] = $customerData['name'];
            }
            if(!empty($customerData['email'])){
                $requestData['email'] = $customerData['email'];
            }
            if(!empty($customerData['phone'])){
                $requestData['phone'] = $customerData['phone'];
            }
            if(!empty($customerData['phone'])){
                $requestData['metadata']['userId'] = $customerData['userId'];
            }
            $stripeCustomerDetails = $this->stripe->customers->create($requestData);
            $stripeCustomerId  = $stripeCustomerDetails->id;
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'stripeCustomerId' => $stripeCustomerId,
        );

        return $returnArray;
    }

    public function createUpdateCustomerStripe($tempArray)
    {
        $apiError = '';
        $customer = '';

        $stripe_customer_id = $tempArray["stripe_customer_id"];

        try
        {
            if($stripe_customer_id == "")
            {
                /*$customer = $stripe->customers->create([
                    'name' => $customer_name,
                    'email' => $billing_email,
                    // 'source'  => $stripeToken,
                    'address' => [
                        'city' => $billing_city,
                        // 'country' => $billing_country_id,
                        'country' => "United Kingdom",
                        'line1' => $billing_address_1,
                        'line2' => ($billing_address_2 != '') ? $billing_address_2 : '',
                        'postal_code' => $billing_postcode,
                        'state' => $billing_state,
                    ],
                    'metadata' => [
                        "user_id" => $user_id,
                        "email" => $billing_email,
                        "customer_name" => $customer_name,
                    ],
                    'shipping' =>
                        [
                            'address' => [
                                'line1' => $shipping_line1,
                                'city' => $shipping_city,
                                // 'country' => $shipping_country,
                                'country' => "United Kingdom",
                                'line2' => ($shipping_line2 != '') ? $shipping_line2 : '',
                                'postal_code' => $shipping_postal_code,
                                'state' => $shipping_state,
                            ],
                            'name' => $shipping_first_name." ".$shipping_last_name,
                            'phone' => $shipping_phone,
                        ]
                ]);*/
            }
            else
            {
                //
            }
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'apiError' => $apiError,
            'customer' => $customer,
        );

        return $returnArray;
    }
    #Get Stile Customer Details
    public function getStripeUserDetails($stripeCustomerId=''){
        try {

            if(!empty($stripeCustomerId)){
                $stripeCustomerDetails = $this->stripe->customers->retrieve(
                    $stripeCustomerId,
                    []
                );
                return array('status'=>true, 'data'=>$stripeCustomerDetails);
            }else{
                return array('status'=>false, 'data'=>[]);
            }
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
    }

    //BY VP
    public function setDefaultPaymentMethodToCustomer($tempArray)
    {
        $apiError = '';
        $customer = '';
        $status = false;
        $paymentMethodId = $tempArray["paymentMethodId"];
        $stripeCustomerId = $tempArray["stripeCustomerId"];
        try
        {
            // Set the default payment method on the customer
            $customer = $this->stripe->customers->update($stripeCustomerId, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethodId ,
                ],
            ]);
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError= $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'customer' => $customer,
        );

        return $returnArray;
    }
    public function attachPaymentMethodToCustomer($tempArray)
    {
        $apiError = '';
        $status = false;
        $paymentMethodId = $tempArray["paymentMethodId"];
        $stripeCustomerId = $tempArray["stripeCustomerId"];
        $paymentMethod = '';
        try
        {
            $paymentMethod = $this->stripe->paymentMethods->retrieve(
                $paymentMethodId
            );

            $paymentMethod = $paymentMethod->attach([
                'customer' => $stripeCustomerId,
            ]);
            $status = true;
        }
        /*catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }*/
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            /*echo 'Status is:' . $e->getHttpStatus() . '\n';
            echo 'Type is:' . $e->getError()->type . '\n';
            echo 'Code is:' . $e->getError()->code . '\n';
            // param is '' in this case
            echo 'Param is:' . $e->getError()->param . '\n';
            echo 'Message is:' . $e->getError()->message . '\n';*/
            $apiError = $e->getError()->message;
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            $apiError = $e->getMessage();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $apiError = $e->getMessage();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $apiError = $e->getMessage();
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $apiError = $e->getMessage();
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $apiError = $e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'paymentMethod' => $paymentMethod,
        );

        return $returnArray;
    }
    #Get Stile Customer's default payment method
    public function getStripeDefaultPaymentMethod($stripeCustomerDetails){
        $defaultPaymentMethod = '';
        if($stripeCustomerDetails){
            $defaultPaymentMethod = $stripeCustomerDetails->default_source;
            if(empty($defaultPaymentMethod)){
                $defaultPaymentMethod = $stripeCustomerDetails->invoice_settings->default_payment_method;
            }
        }
        if(empty($defaultPaymentMethod )){
            #TODO Get Payment list and set default
        }
        return $defaultPaymentMethod ;
    }

    #Do Payment with Payment method Id with confirm payment mode,
    public function paymentIntentWithConfirm($stripeCustomerId='',$totalPayableAmount,$paymentMethodId='',$metaData=array()){
        try {
            $stripeUserDetails = $this->getStripeUserDetails($stripeCustomerId);
            if($stripeUserDetails['status']){
                $stripeCustomer = $stripeUserDetails['data'];
                $defaultPaymentMethod = $paymentMethodId;
                /*$defaultPaymentMethod = $this->getStripeDefaultPaymentMethod($stripeCustomer);
                if(empty($defaultPaymentMethod )){
                    return array('status'=>false, 'data'=>null,'error'=> __('messages.LANG_ERROR_STRIPE_02'));
                }*/
                #https://stripe.com/docs/api/payment_intents/create#create_payment_intent-setup_future_usage
                $intent = $this->stripe->paymentIntents->create([
                    'payment_method' => $defaultPaymentMethod,
                    'amount' => $totalPayableAmount,
                    'currency' => 'GBP',
                    'customer' => $stripeCustomer,
                    'metadata' => $metaData,
                    'confirmation_method' => 'manual', //automatic
                    'confirm' => true,
                    'statement_descriptor' => config('constants.stripe_statement_descriptor'),
                    'description' => config('constants.stripe_statement_descriptor'),
                    #'receipt_email' =>true,
                    //'setup_future_usage' =>'off_session'
                ]);

                if (in_array($intent->status,['requires_source_action','requires_action']) &&
                    $intent->next_action->type == 'use_stripe_sdk') {
                    # Tell the client to handle the action
                    return array(
                        'status'=>true,
                        'requires_action' => true,
                        'data'=>array(
                            'payment_intent_client_secret' => $intent->client_secret,
                            'intent' => $intent
                        ),
                        'payment_intent_client_secret' => $intent->client_secret
                    );
                } else if ($intent->status == 'succeeded') {
                    # The payment didn’t need any additional actions and completed!
                    # Handle post-payment fulfillment
                    return array(
                        'status'=>true,
                        'requires_action' => false,
                        'data'=>array(
                            'payment_intent_client_secret' => $intent->client_secret,
                            'intent' => $intent
                        ),
                        'payment_intent_client_secret' => $intent->client_secret
                    );
                } else {
                    # Invalid status
                    #http_response_code(500);
                    return array('status'=>false, 'data'=>null,'error'=>'Invalid PaymentIntent status');
                    //echo json_encode(['error' => 'Invalid PaymentIntent status']);
                }
            }
            else{
                return array('status'=>false, 'data'=>null,'error'=>'Missing required details. [Code:S101]');
            }


        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
    }

    //Confirm Payment Intent
    public function paymentIntentConfirm($paymentIntentId){

        try {
            #$stripeUserDetails = $this->getStripeUserDetails($stripeCustomerId);
            if(!empty($paymentIntentId)){
                $intent = $this->stripe->paymentIntents->retrieve($paymentIntentId);
                $intent->confirm();
            }
            else{
                return array('status'=>false, 'data'=>null,'error'=>'Missing required details. [Code:S109]');
            }

        }

        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        if (in_array($intent->status,['requires_source_action','requires_action','requires_confirmation']) &&
            $intent->next_action->type == 'use_stripe_sdk') {
            # Tell the client to handle the action
            return array(
                'status'=>true,
                'requires_action' => true,
                'data'=>array(
                    'payment_intent_client_secret' => $intent->client_secret,
                    'intent' => $intent
                ),
                'payment_intent_client_secret' => $intent->client_secret
            );
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            return array(
                'status'=>true,
                'requires_action' => false,
                'data'=>array(
                    'payment_intent_client_secret' => $intent->client_secret,
                    'intent' => $intent
                ),
                'payment_intent_client_secret' => $intent->client_secret
            );
        } else {
            # Invalid status
            #http_response_code(500);
            return array('status'=>false, 'data'=>null,'error'=>'Invalid PaymentIntent status');
            //echo json_encode(['error' => 'Invalid PaymentIntent status']);
        }
    }


    //Retrive  Payment Intent
    public function paymentIntentFetch($paymentIntentId){

        try {
            #$stripeUserDetails = $this->getStripeUserDetails($stripeCustomerId);
            if(!empty($paymentIntentId)){
                $intent = $this->stripe->paymentIntents->retrieve($paymentIntentId);
                #$intent->confirm();
            }
            else{
                return array('status'=>false, 'data'=>null,'error'=>'Missing required details. [Code:S109]');
            }

        }

        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        if (in_array($intent->status,['requires_source_action','requires_action','requires_confirmation']) &&
            $intent->next_action->type == 'use_stripe_sdk') {
            # Tell the client to handle the action
            return array(
                'status'=>true,
                'requires_action' => true,
                'data'=>array(
                    'payment_intent_client_secret' => $intent->client_secret,
                    'intent' => $intent
                ),
                'payment_intent_client_secret' => $intent->client_secret
            );
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            return array(
                'status'=>true,
                'requires_action' => false,
                'data'=>array(
                    'payment_intent_client_secret' => $intent->client_secret,
                    'intent' => $intent
                ),
                'payment_intent_client_secret' => $intent->client_secret
            );
        } else {
            # Invalid status
            #http_response_code(500);
            return array('status'=>false, 'data'=>null,'error'=>'Invalid PaymentIntent status');
            //echo json_encode(['error' => 'Invalid PaymentIntent status']);
        }
    }

    //Update Payment Intent
    public function paymentIntentUpdate($paymentIntentId,$dataArray){

        try {
            $shipping = @$dataArray['address'];
            $description = @$dataArray['description'];
            $metadata = @$dataArray;
            unset($metadata['address']);
            unset($metadata['name']);
            unset($metadata['phone']);
            unset($metadata['description']);
            if(!empty($paymentIntentId)){
                $intent = $this->stripe->paymentIntents->update(
                    $paymentIntentId,
                    [
                        'description' => $description,
                        'metadata' => $metadata,
                        'shipping' => [
                            'address' => [
                                'line1' => (!empty($shipping['line1'])) ?  $shipping['line1'] : 'N/A',
                                'line2' => (!empty($shipping['line2'])) ?  $shipping['line2'] : '',
                                'city' => (!empty($shipping['city'])) ?  $shipping['city'] : '',
                                'state' => (!empty($shipping['state'])) ?  $shipping['state'] : '',
                                'country' => (!empty($shipping['country'])) ?  $shipping['country'] : '',
                                'postal_code' => (!empty($shipping['postal_code'])) ?  $shipping['postal_code'] : '',
                            ],
                            'name'=> (!empty($dataArray['name'])) ?  $dataArray['name'] : '',
                            'phone'=> (!empty($dataArray['phone'])) ?  $dataArray['phone'] : '',
                        ]
                    ]
                );
            }
            else{
                return array('status'=>false, 'data'=>null,'error'=>'Missing required details. [Code:S109]');
            }

        }

        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        if (in_array(@$intent->status,['requires_source_action','requires_action','requires_confirmation']) &&
            @$intent->next_action->type == 'use_stripe_sdk') {
            # Tell the client to handle the action
            return array(
                'status'=>true,
                'requires_action' => true,
                'data'=>array(
                    'payment_intent_client_secret' => $intent->client_secret,
                    'intent' => $intent
                ),
                'payment_intent_client_secret' => $intent->client_secret
            );
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            return array(
                'status'=>true,
                'requires_action' => false,
                'data'=>array(
                    'payment_intent_client_secret' => $intent->client_secret,
                    'intent' => $intent
                ),
                'payment_intent_client_secret' => $intent->client_secret
            );
        } else {
            # Invalid status
            #http_response_code(500);
            return array('status'=>false, 'data'=>null,'error'=>'Invalid PaymentIntent status');
            //echo json_encode(['error' => 'Invalid PaymentIntent status']);
        }
    }

    #Detach and remove Payment Method from stripe
    public function paymentMethodDetach($stripeCustomerId,$paymentMethodId){

        try {

            $stripeUserDetails = $this->getStripeUserDetails($stripeCustomerId);
            if($stripeUserDetails['status']){


                $stripeCustomer = $stripeUserDetails['data'];

                $defaultPaymentMethod = $this->getStripeDefaultPaymentMethod($stripeCustomer);
                $detachPaymentMethod = $this->stripe->paymentMethods->detach(
                    $paymentMethodId
                );
                #dd($detachPaymentMethod);
                if($defaultPaymentMethod == $paymentMethodId){
                    //id default payment method remove then set any payment method to default payment method
                }else{

                }
                return array(
                    'status'=>true,
                    'data'=>array(),
                    'message' => 'Payment method removed successfully'
                );
            }
            else{
                return array('status'=>false, 'data'=>null,'error'=>'Missing required details. [Code:S101]');
            }


        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
    }
    public function paymentMethodAttach($stripeCustomerId,$paymentMethodId){

        try {

            #$stripeUserDetails = $this->getStripeUserDetails($stripeCustomerId);
            //if($stripeUserDetails['status']){
            if(1){


                #$stripeCustomer = $stripeUserDetails['data'];

                #$defaultPaymentMethod = $this->getStripeDefaultPaymentMethod($stripeCustomer);
                $paymentMethodDetail = $this->stripe->paymentMethods->attach(
                #'pm_1IHpYOCPhoVnhnl5N8fOeVsn',
                    $paymentMethodId,
                    ['customer' => $stripeCustomerId]
                );
                $setDefaultMethod = $this->stripe->customers->update(
                    $stripeCustomerId,
                    [
                        //'metadata' => ['order_id' => '6735'],
                        #'invoice_settings' =>['default_payment_method'=>'pm_1IHpYOCPhoVnhnl5N8fOeVsn']
                        'invoice_settings' =>['default_payment_method'=>$paymentMethodId]
                    ]
                );
                return array(
                    'status'=>true,
                    'data'=>$paymentMethodDetail ,
                    'message' => 'Payment method attach successfully'
                );
            }
            else{
                return array('status'=>false, 'data'=>null,'error'=>'Missing required details. [Code:S101]');
            }


        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
            return array('status'=>false, 'data'=>null,'error'=>$apiError);
        }
    }
    
    //Subscription
    public function createOneTimeProduct($tempArray)
    {
        $apiError = '';
        $status = false;

        $plan = '';
        $planName = $tempArray["planName"];
        $planPrice = $tempArray["planPrice"];
        $priceCents = $tempArray["priceCents"];
        $currency = $tempArray["currency"];
        $userId = $tempArray["userId"];
        $planInterval = $tempArray["planInterval"];
        #$packageCost = $tempArray["packageCost"];

        // Create a plan

        try
        {

            $plan = $this->stripe->plans->create([
                "product" => [
                    "name" => $planName
                ],
                'metadata' => [
                    "userId" => $userId,
                    "orderId" => '', // todo: update
                    "packageCost" => "£".$planPrice,
                ],
                "amount" => $priceCents,
                "currency" => $currency,
                "interval" => $planInterval,
                "interval_count" => config('constants.subscription_duration_interval')
            ]);
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'plan' => $plan,
        );

        return $returnArray;
    }

    public function createRecurringProduct($tempArray)
    {
        $apiError = '';
        $status = false;

        $plan = '';
        $planName = $tempArray["planName"];
        $planPrice = $tempArray["planPrice"];
        $priceCents = $tempArray["priceCents"];
        $currency = $tempArray["currency"];
        $userId = $tempArray["userId"];
        $planInterval = $tempArray["planInterval"];
        #$packageCost = $tempArray["packageCost"];

        try
        {
            $plan = $this->stripe->plans->create([
                "product" => [
                    "name" => $planName
                ],
                'metadata' => [
                    "userId" => $userId,
                    "orderId" => '', // todo: update
                    "packageCost" => "£".$planPrice,
                ],
                "amount" => $priceCents,
                "currency" => $currency,
                "interval" => $planInterval,
                "interval_count" => config('constants.subscription_duration_interval')
            ]);
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'plan' => $plan,
        );

        return $returnArray;
    }

    public function createSubscription($tempArray)
    {
        $apiError = '';
        $status = false;
        $subscription = '';
        $planId = $tempArray["planId"];
        $stripeCustomerId = $tempArray["stripeCustomerId"];
        $paymentMethodId = $tempArray["paymentMethodId"];
        $metaData = $tempArray["metaData"];
        // Creates a new subscription
        try
        {
            //https://stripe.com/docs/api/subscriptions/create
            $subscription = $this->stripe->subscriptions->create([
                "customer" => $stripeCustomerId ,
                "default_payment_method" => $paymentMethodId,
                // "trial_period_days" => 1,
                'items' => [
                    [
                        'price' => $planId
                    ]
                ],
                'metadata' => $metaData,
                "expand" => ['latest_invoice.payment_intent']
            ]);

            $status = true;
            $subscriptionId = $subscription->id;
            $stripeSubscriptionData = $subscription;
            $stripeSubscriptionInvoiceData = @$stripeSubscriptionData['latest_invoice'];
            $stripeSubscriptionPaymentIntentData = @$stripeSubscriptionInvoiceData['payment_intent'];
            $intent = $stripeSubscriptionPaymentIntentData;
            if (in_array($intent->status,['requires_source_action','requires_action']) &&
                $intent->next_action->type == 'use_stripe_sdk') {
                # Tell the client to handle the action
                return array(
                    'status'=>true,
                    'apiError' => $apiError,
                    'requires_action' => true,
                    'data'=>array(
                        'payment_intent_client_secret' => $intent->client_secret,
                        'intent' => $intent
                    ),
                    'payment_intent_client_secret' => $intent->client_secret,
                    'subscription_id' => $subscriptionId,
                    'subscription' => $subscription
                );
            } else if ($intent->status == 'succeeded') {
                # The payment didn’t need any additional actions and completed!
                # Handle post-payment fulfillment
                return array(
                    'status'=>true,
                    'apiError' => $apiError,
                    'requires_action' => false,
                    'data'=>array(
                        'payment_intent_client_secret' => $intent->client_secret,
                        'intent' => $intent
                    ),
                    'payment_intent_client_secret' => $intent->client_secret,
                    'subscription_id' => $subscriptionId,
                    'subscription' => $subscription
                );
            } else {
                # Invalid status
                return array('status'=>false, 'apiError'=>'Invalid PaymentIntent status');
            }
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        
        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }

    public function updateSubscriptionItem($tempArray)
    {
        $apiError = '';
        $status = false;
        $subscription = '';
        $planId = $tempArray["planId"];
        $subscriptionId = $tempArray["subscriptionId"];
        // Creates a new subscription
        try
        {
            $subscription = $this->stripe->subscriptionItems->update(
                $subscriptionId,
                [
                    'proration_behavior' => "none",
                    'price' => $planId
                ]
            );
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }
    public function retrieveSubscription($tempArray)
    {
        $apiError = '';
        $status = false;
        $subscription = '';
        $subscriptionId = $tempArray["subscriptionId"];
        // Creates a new subscription
        try
        {
            $subscription = $this->stripe->subscriptions->retrieve(
                $subscriptionId,
                []
            );
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }
    public function getAllInvoiceSubscriptionWise($subscriptionId)
    {
        $apiError = '';
        $status = false;
        $subscription = '';

        try
        {
            $subscription = $this->stripe->invoices->all([
                    'limit' => 3,
                    'subscription'=>$subscriptionId,

            ]);
            /*$subscription = $this->stripe->subscriptions->retrieve(
                $subscriptionId,
                []
            );*/
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }

    public function cancelSubscription($orderData)
    {
        $apiError = '';
        $status = false;
        
        $subscription = '';
        
        $subscriptionId = $orderData["subscriptionId"];
        
        try
        {
            /*$subscription = $this->stripe->subscriptions->update(
                $subscriptionId,
                [
                    'cancel_at_period_end' => true,
                ]
            );*/
            $subscription = $this->stripe->subscriptions->cancel(
                $subscriptionId,
                []
            );
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }

    public function pauseSubscription($orderData)
    {
        $apiError = '';
        $status = false;
        
        $subscription = '';
        
        $subscriptionId = $orderData["subscriptionId"];
        
        try
        {
            $subscription = $this->stripe->subscriptions->update(
                $subscriptionId,
                [
                    'pause_collection' => [
                        'behavior' => 'void',
                        // 'behavior' => 'mark_uncollectible',
                    ],
                ]
            );
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }

    public function activeSubscription($orderData)
    {
        $apiError = '';
        $status = false;
        
        $subscription = '';
        
        $subscriptionId = $orderData["subscriptionId"];
        
        try
        {
            $subscription = $this->stripe->subscriptions->update(
                $subscriptionId,
                [
                    'pause_collection' => '',
                ]
            );
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }

    public function getLastPaymentIntent($orderData)
    {
        $apiError = '';
        $status = false;
        
        $intent = '';
        
        $stripeCustomerId = $orderData["stripeCustomerId"];
        
        try
        {
            $intent = $this->stripe->paymentIntents->all([
                'customer' => $stripeCustomerId,
                'limit' => 1
            ]);
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'intent' => $intent,
        );
        return $returnArray;
    }
    public function createInvoice($orderData)
    {
        $apiError = '';
        $status = false;

        $invoice = '';

        $stripeCustomerId = $orderData["stripeCustomerId"];
        $price = $orderData["totalPayableAmount"];
        $product_data = $orderData["productData"];
        $metaData = $orderData["metaData"];
        $productNameTemp = $orderData["productNameTemp"];
        $isSend='';
        try
        {
            $invoiceItems = $this->createInvoiceItems($orderData);
            if($invoiceItems['status']){
                #$invoiceItemId = $invoiceItems['invoiceItems']['id'];
                $invoice = $this->stripe->invoices->create([
                    'customer' => $stripeCustomerId,
                    #'collection_method'=>'send_invoice',
                    #'status'=>'open',
                    'metadata' =>$metaData,
                    'description' => $productNameTemp,
                    'statement_descriptor' => config('constants.stripe_statement_descriptor'),
                    #'days_until_due' => 1
                    # 'limit' => 1
                ]);
                #$isSend = $invoice->sendInvoice();
                $isSend = $invoice->finalizeInvoice();
                $status = true;
            }else{
                $apiError = $invoiceItems['apiError'];
            }

        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }
        if(!$status){
            #remove invoice items
            #$invoiceItems
            if(@$invoiceItems['status']){
                $invoiceItemId = $invoiceItems['invoiceItems']['id'];
                $this->stripe->invoiceItems->delete(
                    $invoiceItemId ,
                    []
                );
            }
            //Remove price id //$priceId
        }
        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'isSend' => $isSend,
            'invoice' => $invoice,
        );
        return $returnArray;
    }
    public function createInvoiceItems($orderData)
    {
        $apiError = '';
        $status = false;

        $invoiceItems = '';

        $stripeCustomerId = $orderData["stripeCustomerId"];
        $price = $orderData["totalPayableAmount"];
        $metaData = $orderData["metaData"];
        $productNameTemp = $orderData["productNameTemp"];
        $priceId = '';
        try
        {
            $priceData = $this->createPrice($orderData);
            if($priceData['status']){
                $priceId = $priceData['priceData']['id'];
                $invoiceItems = $this->stripe->invoiceItems->create([
                    'customer' => $stripeCustomerId,
                    'price' => $priceId,
                    #'amount' => $price,
                    #'collection_method'=>'send_invoice',
                    'metadata' =>$metaData,
                    'description' => $productNameTemp,
                    #'statement_descriptor' => config('constants.stripe_statement_descriptor'),
                    #'days_until_due' => 1
                    # 'limit' => 1
                ]);
                $status = true;
            }else{
                $apiError = $priceData['apiError'];
            }
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'invoiceItems' => $invoiceItems,
            'priceId' => $priceId,
        );
        return $returnArray;
    }
    public function createPrice($orderData)
    {
        $apiError = '';
        $status = false;

        $priceData = '';
       # $stripeCustomerId = $orderData["stripeCustomerId"];
        $price = $orderData["totalPayableAmount"];
        $product_data = $orderData["productData"];
        $metaData = $orderData["metaData"];
        try
        {
            $priceData = $this->stripe->prices->create([
                #'customer' => $stripeCustomerId,
                'unit_amount' => $price,
                'currency' => 'gbp',
                #'recurring' => ['interval' => 'day'],
                #'product' => 'prod_JNx66rIyF5whKs',
                'metadata' =>$metaData,
                'product_data' =>$product_data,
                #'statement_descriptor' => config('constants.stripe_statement_descriptor'),
                #'days_until_due' => 1
               # 'limit' => 1
            ]);
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'priceData' => $priceData,
        );
        return $returnArray;
    }

    public function retrieveInvoice($invoiceId)
    {
        $apiError = '';
        $status = false;
        
        $invoice = '';
        
        try
        {
            $invoice = $this->stripe->invoices->retrieve(
                $invoiceId,
                []
            );
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'invoice' => $invoice,
        );
        return $returnArray;
    }
    //Update Subscription date
    public function updateSubscriptionDate($tempArray)
    {
        $apiError = '';
        $status = false;
        $subscription = '';
        $subscriptionId = $tempArray["subscriptionId"];
        $renewalDate = $tempArray["renewalDate"];
        // Creates a new subscription
        try
        {
            $subscription = $this->stripe->subscriptions->update(
                $subscriptionId,
                [
                    'proration_behavior' => "none",
                    'trial_end' => $renewalDate
                    #'billing_cycle_anchor' => $renewalDate
                    /*'billing_thresholds' => [
                        'billing_cycle_anchor' => $renewalDate
                    ]*/
                ]
            );
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }
    //Update Subscription date
    public function fetchUpcomingInvoice($tempArray)
    {
        $apiError = '';
        $status = false;
        $subscription = '';
        $subscriptionId = $tempArray["subscriptionId"];
        $stripeCustomerId = $tempArray["stripeCustomerId"];
        // Creates a new subscription
        try
        {

            $subscription = $this->stripe->invoices->upcoming([
                'customer' => $stripeCustomerId,
                'subscription' => $subscriptionId
                ]);
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'subscription' => $subscription,
        );
        return $returnArray;
    }
    public function getCustomerByEmail($email)
    {
        $apiError = '';
        $status = false;
        $customers = '';
        try
        {
            $customers = $this->stripe->customers->all(['email'=>'parmarvikrant1r@gmail.com',
                'limit' => 15,
            ]);
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'customers' => $customers,
        );
        return $returnArray;
    }

    public function createInvoiceAndSend($orderData)
    {
        $apiError = '';
        $status = false;

        $invoice = '';

        $stripeCustomerId = $orderData["stripeCustomerId"];
        $price = $orderData["totalPayableAmount"];
        $product_data = $orderData["productData"];
        $metaData = $orderData["metaData"];
        $productNameTemp = $orderData["productNameTemp"];
        $isSend='';
        try
        {
            #$orderData['productNameTemp'] = ' 1st Price';
            $invoiceItems = $this->createInvoiceItemsOneTime($orderData); //Multiple
            #$orderData['productNameTemp'] = ' 2nd Price';
            #$invoiceItems = $this->createInvoiceItemsOneTime($orderData);
            if($invoiceItems['status']){
                #$invoiceItemId = $invoiceItems['invoiceItems']['id'];
                $invoice = $this->stripe->invoices->create([
                    'customer' => $stripeCustomerId,
                   // 'auto_advance'=>false,
                    'collection_method'=>'send_invoice',
                    //'status'=>'open',
                    'metadata' =>$metaData,
                    'description' => $productNameTemp,
                    'statement_descriptor' => config('constants.stripe_statement_descriptor'),
                    'days_until_due' => 30
                    # 'limit' => 1
                ]);
                $invoiceId = $invoice->id;
                #_pre($invoiceId,0);
                #$isSend = $invoice->sendInvoice();
                $isSend = $this->stripe->invoices->sendInvoice($invoiceId, []);
                #_pre($isSend);
                #var_dump($isSend);
                #_pre($invoice);
                #$isSend = $invoice->finalizeInvoice();
                $status = true;
            }else{
                 $apiError = $invoiceItems['apiError'];
            }

        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }
        /*if(!$status){
            #remove invoice items
            #$invoiceItems
            if(@$invoiceItems['status']){
                $invoiceItemId = $invoiceItems['invoiceItems']['id'];
                $this->stripe->invoiceItems->delete(
                    $invoiceItemId ,
                    []
                );
            }
            //Remove price id //$priceId
        }*/
        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'isSend' => $isSend,
            'invoice' => $invoice,
        );
        return $returnArray;
    }

    public function createInvoiceItemsOneTime($orderData)
    {
        $apiError = '';
        $status = false;

        $invoiceItems = '';

        $stripeCustomerId = $orderData["stripeCustomerId"];
        $price = $orderData["totalPayableAmount"];
        $metaData = $orderData["metaData"];
        $productNameTemp = $orderData["productNameTemp"];
        $priceId = '';
        try
        {
            $priceData = $this->createPriceOneTime($orderData);
            if($priceData['status']){
                $priceId = $priceData['priceData']['id'];
                $invoiceItems = $this->stripe->invoiceItems->create([
                    'customer' => $stripeCustomerId,
                    'price' => $priceId,
                    #'amount' => $price,
                    #'collection_method'=>'send_invoice',
                    'metadata' =>$metaData,
                    'description' => $productNameTemp,
                    #'statement_descriptor' => config('constants.stripe_statement_descriptor'),
                    #'days_until_due' => 1
                    # 'limit' => 1
                ]);
                $status = true;
            }else{
                $apiError = $priceData['apiError'];
            }
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'invoiceItems' => $invoiceItems,
            'priceId' => $priceId,
        );
        return $returnArray;
    }
    public function createPriceOneTime($orderData)
    {
        $apiError = '';
        $status = false;

        $priceData = '';
        # $stripeCustomerId = $orderData["stripeCustomerId"];
        $price = $orderData["totalPayableAmount"];
        $product_data = $orderData["productData"];
        $metaData = $orderData["metaData"];
        try
        {
            $priceData = $this->stripe->prices->create([
                #'customer' => $stripeCustomerId,
                'unit_amount' => $price,
                'currency' => 'gbp',
                #'recurring' => ['interval' => 'day'],
                #'product' => 'prod_JNx66rIyF5whKs',
                'metadata' =>$metaData,
                'product_data' =>$product_data,
                #'statement_descriptor' => config('constants.stripe_statement_descriptor'),
                #'days_until_due' => 1
                # 'limit' => 1
            ]);
            $status = true;
        }
        catch(\Stripe\Exception\InvalidRequestException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\CardException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(\Stripe\Exception\ApiConnectionException $e)
        {
            $apiError = $e->getMessage();
        }
        catch(Exception $e)
        {
            $apiError = $e->getMessage();
        }

        $returnArray = array(
            'status' => $status,
            'apiError' => $apiError,
            'priceData' => $priceData,
        );
        return $returnArray;
    }
}
?>