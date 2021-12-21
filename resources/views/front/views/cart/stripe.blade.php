<script type="text/javascript">
(function ()
{
	"use strict";
	<?php
	$stripe_mode = config('constants.stripe_mode');
	$stripe_publishable_key = config('constants.'.$stripe_mode.'.STRIPE_PUBLISHABLE_KEY');
	?>
	 var stripeAP = Stripe('<?php echo $stripe_publishable_key ?>', {
        apiVersion: "2020-08-27",
        //stripeAccount : ''
    });

	var elements = stripe.elements(
	{
		locale: window.__exampleLocale
	});

	/*** Card Element*/

	var card = elements.create("card",
	{
 		//hidePostalCode: true,
		iconStyle: "solid",
		style:
		{
			base:
			{
				iconColor: "#fff",
				color: "#fff",
				fontWeight: 400,
				fontFamily: "Helvetica Neue, Helvetica, Arial, sans-serif",
				fontSize: "16px",
				fontSmoothing: "antialiased",
				"::placeholder":
				{
					color: "#ffffff"
				},
				":-webkit-autofill":
				{
					color: "#fce883"
				}
			},
			invalid:
			{
				iconColor: "#FFC7EE",
				color: "#FFC7EE"
			}
		}
	});

	card.mount("#example5-card");
	//registerElements([card], "example5");

	var testTotalAmount =  0.88;
	//var totalOrderAmount = testTotalAmount;//FOr Test
	var totalOrderAmount = parseFloat($("form#frm_paypal input:hidden[name=amount_all]").val()).toFixed(2);
	var totalAmount = parseFloat(totalOrderAmount);
	/**
	 * Payment Request Element
	 */
	var displayItemsArr = ( $('input:hidden[name=hdn_form_apple_pay_stripe_details]').val() ) ? JSON.parse( $('input:hidden[name=hdn_form_apple_pay_stripe_details]').val() ) : [];
	
	
    var paymentRequest = stripeAP.paymentRequest({
        country: 'GB',
        currency: 'gbp',
       
		total:
		{
			amount: parseInt(totalAmount * 100),
			label: "Total"
		},
		displayItems: displayItemsArr,
        requestShipping: false,
        requestPayerName: true,
        requestPayerEmail: true,
    });
 	var elementsAP = stripeAP.elements();
	var paymentRequestElement = elementsAP.create("paymentRequestButton",
	{
		paymentRequest: paymentRequest,
		style:
		{
			paymentRequestButton:
			{
				theme: "light"
			}
		}
	});

 	paymentRequest.canMakePayment().then(function (result)
	{
		if (result.applePay)
		{
			document.querySelector(".example5 .card-only").style.display = "none";
			document.querySelector(
					".example5 .payment-request-available"
				).style.display =
				"block";
			paymentRequestElement.mount("#example5-paymentRequest");
		}
	});
	
	var totalAmount = totalAmount;
	paymentRequest.on('paymentmethod',  function (ev)
	{
		callGATagApplePay();
		 
		//  alert(JSON.stringify(ev));
        // Confirm the PaymentIntent without handling potential next actions (yet).
        //alert(" in " +clientSecret);
        //alert(JSON.stringify(ev));
        //console.log(ev.paymentMethod);

		var stripe_form_name = ev.paymentMethod.billing_details.name;
		var stripe_form_email = ev.paymentMethod.billing_details.email;
		var stripe_form_phone = ev.paymentMethod.billing_details.phone;
		var stripe_form_address1 = ev.paymentMethod.billing_details.address;
		var postal_code = ev.paymentMethod.billing_details.address.postal_code;

		 totalAmount = totalAmount;//testAmount;//parseFloat($("form#frm_paypal input:hidden[name=amount_all]").val());
		var cartObjectCurrent = localStorage.getItem("cartObjectCurrent");
		var currentStep = localStorage.getItem("currentStep");
		var cartObject = localStorage.getItem("cartObject");
		var giftVoucherCart = localStorage.getItem("giftVoucherCart");
		var cartOtherInfo = localStorage.getItem("cartOtherInfo");
		var hdn_form_stripe_details = ($('input:hidden[name=hdn_form_stripe_details]').val() ) ? JSON.parse( $('input:hidden[name=hdn_form_stripe_details]').val() ) : "";
        /*alert(JSON.stringify(
				{
					stripeToken: ev.paymentMethod.id,
					totalPayableAmount: totalAmount,
					type: 'apple-pay',
					
					currentStep: currentStep,
					cartObject: cartObject,
					giftVoucherCart: giftVoucherCart,
					cartOtherInfo: cartOtherInfo,
					hdn_form_stripe_details: hdn_form_stripe_details,
					stripe_form_name: stripe_form_name,
					stripe_form_email: stripe_form_email,
					stripe_form_phone: stripe_form_phone,
					stripe_form_address1: stripe_form_address1,
					postal_code: postal_code,
					cartObjectCurrent: cartObjectCurrent,

				}));*/
         /*fetch('https://slate.geckodevelopment.co.uk/public/apple-pay/create_payment.php', {
                method: 'post',
                body: JSON.stringify({payment_method_id: ev.paymentMethod.id,totalAmount : totalAmount,type:"apple-pay"}),
                 headers: {
                        "Content-type": "application/json; charset=UTF-8"
                }
            }).then(function(responseBody) {
                alert(" in 1st ");
                //alert(JSON.stringify(responseBody));
                        return responseBody.json();
            }).then(data => {
                alert(" in 2nd ");
                alert(JSON.stringify(data));
                            console.log('Success:', data);
                        //confirmCardPayment  process
                            //handleServerResponse(data,ev);

            }).catch((error) => {
                alert('PM Error:'+ error);
                console.error('Error:', error);
                  ev.complete('fail');
        });*/
		/*var stripe_form_name = ev.paymentMethod.billing_details.name;
		var stripe_form_email = ev.paymentMethod.billing_details.email;
		var stripe_form_phone = ev.paymentMethod.billing_details.phone;
		var stripe_form_address1 = ev.paymentMethod.billing_details.address;
		var postal_code = ev.paymentMethod.billing_details.address.postal_code;

		var totalAmount = testAmount;//parseFloat($("form#frm_paypal input:hidden[name=amount_all]").val());
		var cartObjectCurrent = localStorage.getItem("cartObjectCurrent");
		var currentStep = localStorage.getItem("currentStep");
		var cartObject = localStorage.getItem("cartObject");
		var giftVoucherCart = localStorage.getItem("giftVoucherCart");
		var cartOtherInfo = localStorage.getItem("cartOtherInfo");*/

		 fetch("{{ route('stripe-create-payment') }}",
			{
				method: 'POST',
				body: JSON.stringify(
				{
					stripeToken: ev.paymentMethod.id,
					totalPayableAmount: totalAmount,
					type: 'apple-pay',

					cartObjectCurrent: cartObjectCurrent,
					currentStep: currentStep,
					cartObject: cartObject,
					giftVoucherCart: giftVoucherCart,
					cartOtherInfo: cartOtherInfo,

					hdn_form_stripe_details: hdn_form_stripe_details,

					stripe_form_name: stripe_form_name,
					stripe_form_email: stripe_form_email,
					stripe_form_phone: stripe_form_phone,
					stripe_form_address1: stripe_form_address1,
					postal_code: postal_code,

				}),
				headers:
				{
					'content-type': 'application/json'
				},
			})
			
			.then(function (responseBody)
			{
				 //alert(" in 1st ");
				return responseBody.json()
			})
			//.then(handleServerResponseApplePay)
			.then(data =>
			{
				//console.log('Success:', data);
				//confirmCardPayment  process
				//alert(" in 2nd ");
                //alert(JSON.stringify(data));

				handleServerResponseApplePay(data, ev);
			})
			.catch((error) =>
			{
				//alert('PM Error:'+ error);
				toastr.error(error, 'Error');
                console.error('Error:', error);
				ev.complete('fail');
			});
	});


	async function handleServerResponseApplePay(response, ev)
	{
		
		if (response.error)
		{
			//alert('HSR1 Error:'+ JSON.stringify(response));
            //alert('HSR2 Error:'+ response.error.message);
			//toastr.error(response.message, 'Error');
			toastr.error(response.error.message, 'Error');
			//console.log('Error handleServerResponseApplePay:' + response.error.message);
			ev.complete('fail');
			//document.getElementById("payment-errors").textContent = response.error.message;
		}
		else if (response.requires_action)
		{
			
			console.log(' handleServerResponseApplePay:' + "Requires action");
			//document.getElementById("payment-errors").textContent = "Requires action";
			// Use Stripe.js to handle required card action
			ev.complete('success');

			handleActionApplePay(response, ev);
		}
		else
		{
			//alert('HSR2 Success :');
			ev.complete('success');
			console.log('Success  handleServerResponseApplePay:');
			//document.getElementById("payment-errors").textContent = "Success!";
			//document.getElementById("payment-form").submit();

			if(response.status ==false){
				toastr.error(response.message, 'Error');
				$(buyBtn).removeClass("in_process");
				buyBtn.textContent = 'Place Order';
			}else{
				if(response.redirect_url!=''){
					localStorage.removeItem('cartObjectCurrent');
					localStorage.removeItem('currentStep');
					localStorage.removeItem('cartObject');
					localStorage.removeItem('giftVoucherCart');
					localStorage.removeItem('cartOtherInfo');
					toastr.success("Your Payment has been Successful", 'Success');
					window.location.href = response.redirect_url;
					return false;
				}else{
					window.location.reload();
				}
			}
		}
	}

	 function handleActionApplePay(response, ev)
	{
		stripeAP.handleCardAction(
			response.payment_intent_client_secret
		).then(function (result)
		{
			if (result.error)
			{
				toastr.error(result.error.message, 'Error');
				console.log('Error handleActionApplePay:' + response.error.message);
				ev.complete('fail');
				// document.getElementById("payment-errors").textContent = result.error.message;
			}
			else
			{
				console.log('Success  handleActionApplePay:');
				console.log(response);
				// The card action has been handled
				// The PaymentIntent can be confirmed again on the server
				
				var cartObjectCurrent = localStorage.getItem("cartObjectCurrent");
				var currentStep = localStorage.getItem("currentStep");
				var cartObject = localStorage.getItem("cartObject");
				var giftVoucherCart = localStorage.getItem("giftVoucherCart");
				var cartOtherInfo = localStorage.getItem("cartOtherInfo");
				fetch("{{ route('confirm-payment') }}",
					{
						method: 'POST',
						headers:
						{
							'Content-Type': 'application/json'
						},
						body: JSON.stringify(
						{
							payment_intent_id: result.paymentIntent.id,
							totalPayableAmount:  totalAmount,//parseFloat($("form#frm_paypal input:hidden[name=amount_all]").val()),
							cartObjectCurrent: cartObjectCurrent,
							currentStep: currentStep,
							cartObject: cartObject,
							giftVoucherCart: giftVoucherCart,
							cartOtherInfo: cartOtherInfo
						})
					}).then(function (confirmResult)
					{
						
						return confirmResult.json();
					})
					//.then(handleServerResponseApplePay);
					.then(data =>
					{
						
						//console.log('Success Confrim Payment:', data);
						//confirmCardPayment  process

						handleServerResponseApplePay(data, ev);
					});
			}
		});
	}
	
	function callGATagApplePay()
	{
		var totalOrderAmount = parseFloat($("form#frm_paypal input:hidden[name=amount_all]").val()).toFixed(2);
		var totalAmount = parseFloat(totalOrderAmount);
		var jsObj = {
			'send_to': 'AW-975230974/hhaECK7vg-wBEP6vg9ED', 
			'value': parseFloat(totalAmount).toFixed(2), 
			'currency': 'GBP', 
			'transaction_id': ''
		};
		gtag('event', 'conversion', jsObj);
	}

})();


</script>