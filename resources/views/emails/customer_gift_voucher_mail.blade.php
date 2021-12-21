<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="date=no" />
    <meta name="format-detection" content="address=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="x-apple-disable-message-reformatting" />
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Fira+Mono:400,500,700|Ubuntu:400,400i,500,500i,700,700i" rel="stylesheet" />
    <!--<![endif]-->
    {{--<title>Email Template</title>--}}
    <!--[if gte mso 9]>
    <style type="text/css" media="all">
        sup { font-size: 100% !important; }
    </style>
    <![endif]-->


    <style type="text/css" media="screen">
        /* Linked Styles */
        body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#e4e4e5; -webkit-text-size-adjust:none }
        a { color:#000001; text-decoration:none }
        p { padding:0 !important; margin:0 !important }
        img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */ }
        .mcnPreviewText { display: none !important; }

        /* Mobile styles */
        @media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
            .mobile-shell { width: 100% !important; min-width: 100% !important; }

            .m-center { text-align: center !important; }
            .text3,
            .text-footer,
            .text-header { text-align: center !important; }

            .center { margin: 0 auto !important; }

            .td { width: 100% !important; min-width: 100% !important; }

            .m-br-15 { height: 15px !important; }
            .p30-15 { padding: 30px 15px !important; }
            .p30-15-0 { padding: 30px 15px 0px 15px !important; }
            .p40 { padding-bottom: 30px !important; }
            .box,
            .footer,
            .p15 { padding: 15px !important; }
            .h2-white { font-size: 40px !important; line-height: 44px !important; text-align: center !important; }

            .h2 { font-size: 42px !important; line-height: 50px !important; }

            .m-td,
            .m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }

            .m-block { display: block !important; }
            .container { padding: 0px !important; }
            .separator { padding-top: 30px !important; }

            .fluid-img img { width: 100% !important; max-width: 100% !important; height: auto !important; }

            .column,
            .column-top,
            .column-dir,
            .column-empty,
            .column-empty2,
            .column-bottom,
            .column-dir-top,
            .column-dir-bottom { float: left !important; width: 100% !important; display: block !important; }

            .column-empty { padding-bottom: 10px !important; }
            .column-empty2 { padding-bottom: 30px !important; }

            .content-spacing { width: 15px !important; }
        }
    </style>
</head>
<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#e4e4e5; -webkit-text-size-adjust:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#e4e4e5">
    <tr>
        <td align="center" valign="top" class="container" style="padding:50px 10px;">
            <!-- Container -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center">
                        <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                            <tr>
                                <td class="td" bgcolor="#ffffff" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                    <!-- Header -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                        <tr>
                                            <td class="p30-15-0" style="padding: 40px 30px 0px 30px;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td class="img m-center" style="font-size:0pt; line-height:0pt; text-align:center;"><img src="{{ $headerLogo }}" width="182" height="182" border="0" alt="" /></td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- END Header -->

                                    <!-- Intro -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                        <tr>
                                            <td class="p30-15" style="padding: 70px 30px 70px 30px;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td class="h2 center pb10" style="color:#595a5d; font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:60px; text-align:center; padding-bottom:10px;text-transform: uppercase;">Hi {{ $varGreetingName }} you've been sent a gift!</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:32px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:10px;text-transform: uppercase;font-style: italic;font-weight: 500;">Gift Voucher</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:30px;text-transform: uppercase;">To the value of</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fluid-img pb40" style="font-size:0pt; line-height:0pt; text-align:left; padding-bottom:40px;"><img src="{{ $giftVoucherData->imgUrl }}" width="590" height="auto" border="0" alt="" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:22px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:10px;text-transform: uppercase;font-style: normal;font-weight: normal;">Presented to</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:32px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:30px;text-transform: uppercase;font-weight: 500;">{{ $varGreetingName }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:22px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:50px;text-transform: none;font-weight: normal;font-style: italic;padding-top: 25px;">{{ $giftVoucherData->personal_message}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:22px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:10px;text-transform: uppercase;font-style: normal;font-weight: normal;">From</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:32px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:30px;text-transform: uppercase;font-weight: 500;">{{ $giftVoucherData->voucher_from }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:18px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:10px;text-transform: none;font-style: normal;font-weight: 500;padding-top: 40px;">Voucher Valid Until : {{ $giftVoucherData->validUntilDate }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:18px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:10px;text-transform: none;font-style: normal;font-weight: 500;padding-top: 0;">Voucher Number : {{ $giftVoucherData->voucher_code }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:18px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:50px;text-transform: none;font-style: normal;font-weight: lighter;padding-top: 0;">Enter this code at checkout</td>
                                                    </tr>
                                                    <!-- Button -->
                                                    <tr>
                                                        <td align="center">
                                                            <table width="200" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td class="text-button" style="background:#8CC63F; color:#ffffff; font-family:'Ubuntu', Arial,sans-serif; font-size:16px; line-height:50px; text-align:left; padding:0 15px;text-transform: uppercase;"><a href="{{ $websiteUrl }}" target="_blank" class="link-white" style="color:#ffffff; text-decoration:none;"><span class="link-white" style="color:#ffffff; text-decoration:none;">Visit Website <span style="float:right">&gt;</span></span></a></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:18px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:50px;text-transform: none;font-style: normal;font-weight: lighter;padding-top: 50px;">Got a question? Email us at<br><a href="mailto:{{_get_setting_data('site_info_email')}}">{{_get_setting_data('site_info_email')}}</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:18px; line-height:26px; text-align:center; color:#595a5d; padding-bottom:50px;text-transform: none;font-style: normal;font-weight: lighter;padding-top: 0;"><a href="{{ $termsUrl }}">Terms & Conditions Apply ></a></td>
                                                    </tr>
                                                    <!-- END Button -->
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- END Intro -->

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- END Container -->
        </td>
    </tr>
</table>
</body>
</html>
