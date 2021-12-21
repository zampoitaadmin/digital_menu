<?php

#namespace App\Helpers; // Your helpers namespace
use App\Models\Admin, App\Product, App\Cart, App\User, App\Order, App\OrderItem, App\OrderAddress;
use App\Order_delivery_schedule;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Auth;
#use Illuminate\Support\Facades\Session;

if (! function_exists('testHelper')) {
    function testHelper()
    {
        return " Test Helper Work!";

    }
}



/** Generate  Random Unique Id for Cart Or use Database User Id if logged In*/
if (! function_exists('cartUserId')) {
    function cartUserId()
    {
        if(Session::has('userId')){
            # \Session::forget(['userId', 'login_details']);
            return Session::get('userId');
            # die(" in asda ".Session::get('userId'));
        }

        $objUser = Auth::user();
        if($objUser != null)
        {
            $userId= $objUser->id;
        }else{
            $userId=  time().rand(111,999);//uniqid();
            #$userId=  uniqid('u');//with prefix U
            #$userId=  hexdec(uniqid());//convert into numbers
        }
        Session::put('userId', $userId);
        Session::save();
        return $userId;
    }
}


if (! function_exists('getSize')) {
    function getSize($style='')
    {
        $sizeArray = array(
            'style1'=>array(
                'id'    => 'style1',
                'class'    => 'style_1',
                'series'    => 'one',
                'name'      => "Style 1 5X5 / 130X130mm",
                'price'     => "17.00",
                'size'     => "5X5",
                'imgUrl'    => asset('front/images/step2a/5X5CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'10.4032258064516vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'60px','fs'=>'40px'),
                    'other'     => array('mt'=>'6vw','fs'=>'4vw'),
                ),
                'dWidth'=>111,
                'sCursorSize'=>80,
                'fontSizeMax'=>80,
                'fontSizeMin'=>40,
                'imageW'    => 283 / 2,
                'imageH'    => 285 / 2,
                'maxLength'    => array(
                    'line1' => 2,
                    'line2' => 0,
                    'line3' => 0
                ),
                'onlyNumber' =>  true,
                'isSingleFixing' =>  true,
                'islandsShippingCharge' =>  18.85,
            ),
            'style2'=>array(
                'id'    => 'style2',
                'class'    => 'style_2',
                'series'    => 'two',
                'name'      => "Style 2 8X5 / 200X130mm",
                'price'     => "20.00",
                'size'     => "8X5",
                'imgUrl'    => asset('front/images/step2a/8X5CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'8.32258064516129vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'48px','fs'=>'40px'),
                    'other'     => array('mt'=>'4.8vw','fs'=>'4vw'),
                ),
                'dWidth'=>158,
                'sCursorSize'=>90,
                'fontSizeMax'=>90,
                'fontSizeMin'=>30,
                'imageW'    => 384 / 2,
                'imageH'    => 240 / 2,
                'maxLength'    => array(
                    'line1' => 3,
                    'line2' => 0,
                    'line3' => 0
                ),
                'onlyNumber' =>  true,
                'isSingleFixing' =>  true,
                'islandsShippingCharge' =>  18.85,
            ),
            'style3'=>array(
                'id'    => 'style3',
                'class'    => 'style_3',
                'series'    => 'three',
                'name'      => "Style 3 8X5 / 200X130mm",
                'price'     => "30.00",
                'size'     => "8X5",
                'imgUrl'    => asset('front/images/step2a/8X5CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'7.80241935483871vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'45px','fs'=>'40px'),
                    'other'     => array('mt'=>'4.5vw','fs'=>'4vw'),
                ),
                'dWidth'=>158,
                'sCursorSize'=>60,
                'fontSizeMax'=>60,
                'fontSizeMin'=>40,
                'imageW'    => 384 / 2,
                'imageH'    => 240 / 2,
                'maxLength'    => array(
                    'line1' => 15,
                    'line2' => 15,
                    'line3' => 0
                ),
                'onlyNumber' =>  false,
                'isSingleFixing' =>  true,
                'islandsShippingCharge' =>  18.85,
            ),
            'style4'=>array(
                'id'    => 'style4',
                'class'    => 'style_4',
                'series'    => 'four',
                'name'      => "Style 4 15X5 / 380X130mm",
                'price'     => "35.70",
                'size'     => "15X5",
                'imgUrl'    => asset('front/images/step2a/15X5CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'7.80241935483871vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'35px','fs'=>'40px'),
                    'other'     => array('mt'=>'4.5vw','fs'=>'4vw'),
                ),
                'dWidth'=>326,
                'sCursorSize'=>60,
                'fontSizeMax'=>60,
                'fontSizeMin'=>40,
                'imageW'    => 720 / 2,
                'imageH'    => 240 / 2,
                'maxLength'    => array(
                    'line1' => 15,
                    'line2' => 15,
                    'line3' => 0
                ),
                'onlyNumber' =>  false,
                'isSingleFixing' =>  false,
                'islandsShippingCharge' =>  18.85,
            ),
            'style5'=>array(
                'id'    => 'style5',
                'class'    => 'style_5',
                'series'    => 'five',
                'name'      => "Style 5 18X5 / 460X130mm",
                'price'     => "40.00",
                'size'     => "18X5",
                'imgUrl'    => asset('front/images/step2a/18X5CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'8.1491935483871vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'47px','fs'=>'40px'),
                    'other'     => array('mt'=>'4.7vw','fs'=>'4vw'),
                ),
                'dWidth'=>398,
                'sCursorSize'=>60,
                'fontSizeMax'=>60,
                'fontSizeMin'=>40,
                'imageW'    => 864 / 2,
                'imageH'    => 240 / 2,
                'maxLength'    => array(
                    'line1' => 18,
                    'line2' => 18,
                    'line3' => 0
                ),
                'onlyNumber' =>  false,
                'isSingleFixing' =>  false,
                'islandsShippingCharge' =>  18.85,
            ),
            'style6'=>array(
                'id'    => 'style6',
                'class'    => 'style_6',
                'series'    => 'six',
                'name'      => "Style 6 12X7 / 300X180mm",
                'price'     => "50.00",
                'size'     => "12X7",
                'imgUrl'    => asset('front/images/step2a/12X7CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'11.2701612903226vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'65px','fs'=>'40px'),
                    'other'     => array('mt'=>'6.5vw','fs'=>'4vw'),
                ),
                'dWidth'=>254,
                'sCursorSize'=>60,
                'fontSizeMax'=>60,
                'fontSizeMin'=>40,
                'imageW'    => 576 / 2,
                'imageH'    => 336 / 2,
                'maxLength'    => array(
                    'line1' => 15,
                    'line2' => 15,
                    'line3' => 0
                ),
                'onlyNumber' =>  false,
                'isSingleFixing' =>  false,
                'islandsShippingCharge' =>  18.85,
            ),
            'style7'=>array(
                'id'    => 'style7',
                'class'    => 'style_7',
                'series'    => 'seven',
                'name'      => "Style 7 12X8 / 300X200mm",
                'price'     => "55.00",
                'size'     => "12X8",
                'imgUrl'    => asset('front/images/step2a/12X8CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'12.1370967741935vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'70px','fs'=>'40px'),
                    'other'     => array('mt'=>'7vw','fs'=>'4vw'),
                ),
                'dWidth'=>254,
                'sCursorSize'=>60,
                'fontSizeMax'=>60,
                'fontSizeMin'=>40,
                'imageW'    => 576 / 2,
                'imageH'    => 384 / 2,
                'maxLength'    => array(
                    'line1' => 15,
                    'line2' => 15,
                    'line3' => 15
                ),
                'onlyNumber' =>  false,
                'isSingleFixing' =>  false,
                'islandsShippingCharge' =>  18.85,
            ),
            'style8'=>array(
                'id'    => 'style8',
                'class'    => 'style_8',
                'series'    => 'eight',
                'name'      => "Style 8 17X7 / 430X180mm",
                'price'     => "60.00",
                'size'     => "17X7",
                'imgUrl'    => asset('front/images/step2a/17X7CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'11.2701612903226vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'65px','fs'=>'40px'),
                    'other'     => array('mt'=>'6.5vw','fs'=>'4vw'),
                ),
                'dWidth'=>374,
                'sCursorSize'=>60,
                'fontSizeMax'=>60,
                'fontSizeMin'=>26,
                'imageW'    => 816 / 2,
                'imageH'    => 336 / 2,
                'maxLength'    => array(
                    'line1' => 18,
                    'line2' => 18,
                    'line3' => 0
                ),
                'onlyNumber' =>  false,
                'isSingleFixing' =>  false,
                'islandsShippingCharge' =>  18.85,
                #'islandsShippingCharge' =>  24.90,
            ),
            'style9'=>array(
                'id'    => 'style9',
                'class'    => 'style_9',
                'series'    => 'nine',
                'name'      => "Style 9 18X8 / 460X200mm",
                'price'     => "65.00",
                'size'     => "18X8",
                'imgUrl'    => asset('front/images/step2a/18X8CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'13.0040322580645vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'75px','fs'=>'40px'),
                    'other'     => array('mt'=>'7.5vw','fs'=>'4vw'),
                ),
                'dWidth'=>398,
                'sCursorSize'=>60,
                'fontSizeMax'=>60,
                'fontSizeMin'=>26,
                'imageW'    => 864 / 2,
                'imageH'    => 384 / 2,
                'maxLength'    => array(
                    'line1' => 18,
                    'line2' => 18,
                    'line3' => 0
                ),
                'onlyNumber' =>  false,
                'isSingleFixing' =>  false,
                'islandsShippingCharge' =>  18.85,
            ),
            'style10'=>array(
                'id'    => 'style10',
                'class'    => 'style_10',
                'series'    => 'ten',
                'name'      => "Style 10 16X10 / 400X250mm",
                'price'     => "70.00",
                'size'     => "16X10",
                'imgUrl'    => asset('front/images/step2a/16X10CLASSIC.png'),
                'cssData'   => array(
                    'lt_621'    => array('mt'=>'21.6733870967742vw','fs'=>'6.93548387096774vw'),
                    'gt_1000'   => array('mt'=>'125px','fs'=>'40px'),
                    'other'     => array('mt'=>'12.5vw','fs'=>'4vw'),
                ),
                'dWidth'=>350,
                'sCursorSize'=>60,
                'fontSizeMax'=>60,
                'fontSizeMin'=>26,
                'imageW'    => 768 / 2,
                'imageH'    => 576 / 2,
                'maxLength'    => array(
                    'line1' => 18,
                    'line2' => 18,
                    'line3' => 18
                ),
                'onlyNumber' =>  false,
                'isSingleFixing' =>  false,
                'islandsShippingCharge' =>  18.85,
            ),
        );
        if(!empty($style)){
            return @$sizeArray[$style];
        }else{
            return $sizeArray;
        }

    }
}


if (! function_exists('getStyleWallList')) {
    function getStyleWallList()
    {
        $dataArray = array(
            'wall21'=>array(
                'id'    => '21',
                'name'    => 'COUNTRYSTONE',
                'imgUrl'    => asset('front/images/step2a/color/21.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/COUNTRYSTONE.jpg'),
            ),
            'wall10'=>array(
                'id'    => '10',
                'name'    => 'RUSTICSTONE',
                'imgUrl'    => asset('front/images/step2a/color/10.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/RUSTICSTONE.jpg'),
            ),
            'wall18'=>array(
                'id'    => '18',
                'name'    => 'CLASSICALSTONE',
                'imgUrl'    => asset('front/images/step2a/color/18.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/CLASSICALSTONE.jpg'),
            ),
            'wall20'=>array(
                'id'    => '20',
                'name'    => 'COTSWALDBUFF',
                'imgUrl'    => asset('front/images/step2a/color/20.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/COTSWALDBUFF.jpg'),
            ),
            'wall6'=>array(
                'id'    => '6',
                'name'    => 'PEBBLEDASH',
                'imgUrl'    => asset('front/images/step2a/color/6.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/PEBBLEDASH.jpg') ,
            ),
            'wall5'=>array(
                'id'    => '5',
                'name'    => 'LONDONBRICK',
                'imgUrl'    => asset('front/images/step2a/color/5.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/LONDONBRICK.jpg'),
            ),
            'wall16'=>array(
                'id'    => '16',
                'name'    => 'YELLOWBRICK',
                'imgUrl'    => asset('front/images/step2a/color/16.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/YELLOWBRICK.jpg'),
            ),
            'wall9'=>array(
                'id'    => '9',
                'name'    => 'REDBRICK',
                'imgUrl'    => asset('front/images/step2a/color/9.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/REDBRICK.jpg'),
            ),
            'wall12'=>array(
                'id'    => '12',
                'name'    => 'TIMBERDARK',
                'imgUrl'    => asset('front/images/step2a/color/12.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/TIMBERDARK.jpg'),
            ),
            'wall13'=>array(
                'id'    => '13',
                'name'    => 'TIMBERLIGHT',
                'imgUrl'    => asset('front/images/step2a/color/13.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/TIMBERLIGHT.jpg'),
            ),
            'wall15'=>array(
                'id'    => '15',
                'name'    => 'WHITERENDER',
                'imgUrl'    => asset('front/images/step2a/color/15.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/WHITERENDER.jpg'),
            ),
            'wall8'=>array(
                'id'    => '8',
                'name'    => 'CREAMRENDER',
                'imgUrl'    => asset('front/images/step2a/color/8.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/CREAMRENDER.jpg'),
            ),
            'wall4'=>array(
                'id'    => '4',
                'name'    => 'LEMONRENDER',
                'imgUrl'    => asset('front/images/step2a/color/4.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/LEMONRENDER.jpg'),
            ),
            'wall2'=>array(
                'id'    => '2',
                'name'    => 'GREENRENDER',
                'imgUrl'    => asset('front/images/step2a/color/2.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/GREENRENDER.jpg'),
            ),
            'wall14'=>array(
                'id'    => '14',
                'name'    => 'WEDGWOODRENDER',
                'imgUrl'    => asset('front/images/step2a/color/14.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/WEDGWOODRENDER.jpg'),
            ),
            'wall3'=>array(
                'id'    => '3',
                'name'    => 'HEATHERRENDER',
                'imgUrl'    => asset('front/images/step2a/color/3.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/HEATHERRENDER.jpg'),
            ),
            'wall7'=>array(
                'id'    => '7',
                'name'    => 'PINKRENDER',
                'imgUrl'    => asset('front/images/step2a/color/7.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/PINKRENDER.jpg'),
            ),
            'wall19'=>array(
                'id'    => '19',
                'name'    => 'CORALRENDER',
                'imgUrl'    => asset('front/images/step2a/color/19.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/CORALRENDER.jpg'),
            ),
            'wall11'=>array(
                'id'    => '11',
                'name'    => 'SALMONRENDER',
                'imgUrl'    => asset('front/images/step2a/color/11.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/SALMONRENDER.jpg'),
            ),
            'wall17'=>array(
                'id'    => '17',
                'name'    => 'CHARCOALRENDER',
                'imgUrl'    => asset('front/images/step2a/color/17.jpg'),
                'imgBgUrl'    => asset('front/images/step2a/CHARCOALRENDER.jpg'),
            ),
        );
        return $dataArray;
    }
}
if (! function_exists('getStyleEdge')) {
    function getStyleEdge()
    {
        $dataArray = array(
            'CLASSIC'=>array(
                'id'    => 1,
                'name'    => 'CLASSIC',
                'imgUrl'    => asset('front/images/edge-thumb-classic.png'), //For Style #1,#2,#3
                'imgUrlA'    => asset('front/images/edge-thumb-classic.png'),
                'price'=>0.00, //For Style #1,#2,#3
                'priceA'=>0.00
            ),
            'BORDERED'=>array(
                'id'    => 2,
                'name'    => 'BORDERED',
                'imgUrl'    => asset('front/images/edge-thumb-bordered-5.png'), //For Style #1,#2,#3
                'imgUrlA'    => asset('front/images/edge-thumb-bordered-10.png'),
                'price'=> 5.00, //For Style #1,#2,#3
                'priceA'=> 10.00
            ),
            'RUSTIC'=>array(
                'id'    => 3,
                'name'    => 'RUSTIC',
                'imgUrl'    => asset('front/images/edge-thumb-rustic-5.png'), //For Style #1,#2,#3
                'imgUrlA'    => asset('front/images/edge-thumb-rustic-10.png'),
                'price'=> 5.00, //For Style #1,#2,#3
                'priceA'=> 10.00
            ),
            'NEO-RUSTIC'=>array(
                'id'    => 4,
                'name'    => 'NEO-RUSTIC',
                'imgUrl'    => asset('front/images/edge-thumb-neo-rustic-5.png'), //For Style #1,#2,#3
                'imgUrlA'    => asset('front/images/edge-thumb-neo-rustic-10.png'),
                'price'=> 5.00, //For Style #1,#2,#3
                'priceA'=> 10.00
            )
        );
        return $dataArray;
    }
}
if (! function_exists('getDesignFonts')) {
    function getDesignFonts()
    {
        $dataArray = array(
            'Albertus-Medium'=>array(
                'id'    => 1,
                'font'    => 'Albertus-Medium',
                'name'    => 'Albertus',
            ),
            'Dyer'=>array(
                'id'    => 2,
                'font'    => 'Dyer',
                'name'    => 'Art Deco',
            ),
            'NeueHammerUnzialeLTStd'=>array(
                'id'    => 3,
                'font'    => 'NeueHammerUnzialeLTStd',
                'name'    => 'Celtic',
            ),
            'KeltNormal'=>array(
                'id'    => 4,
                'font'    => 'KeltNormal',
                'name'    => 'Celt Pride',
            ),
            'ComicSansMS'=>array(
                'id'    => 5,
                'font'    => 'ComicSansMS',
                'name'    => 'Comic Sans',
            ),
            'FelixTitlingMT'=>array(
                'id'    => 6,
                'font'    => 'FelixTitlingMT',
                'name'    => 'Felix',
            ),

            'Gill Sans Std'=>array(
                'id'    => 7,
                'font'    => 'Gill Sans Std',
                'name'    => 'Gill Sans',
            ),
            'HogwartsWizardBold'=>array(
                'id'    => 8,
                'font'    => 'HogwartsWizardBold',
                'name'    => 'Hogwarts',
            ),
            'KabelITCbyBT-Book'=>array(
                'id'    => 9,
                'font'    => 'KabelITCbyBT-Book',
                'name'    => 'Kabel',
            ),
            'OldEnglishTextMT'=>array(
                'id'    => 10,
                'font'    => 'OldEnglishTextMT',
                'name'    => 'Old English',
            ),
            'Papyrus-Regular'=>array(
                'id'    => 11,
                'font'    => 'Papyrus-Regular',
                'name'    => 'Papyrus',
            ),
            'poorrichardmedium'=>array(
                'id'    => 12,
                'font'    => 'poorrichardmedium',
                'name'    => 'Poor Richard',
            ),
            'TempusSansITC'=>array(
                'id'    => 13,
                'font'    => 'TempusSansITC',
                'name'    => 'Tempus Sans',
            ),
            'TimesNewRomanPSMT'=>array(
                'id'    => 14,
                'font'    => 'TimesNewRomanPSMT',
                'name'    => 'Times Roman',
            ),
            'Incimar1'=>array(
                'id'    => 15,
                'font'    => 'Incimar1',
                'name'    => 'V Cut',
            ),
            'Vivaldii'=>array(
                'id'    => 16,
                'font'    => 'Vivaldii',
                'name'    => 'Vivaldi',
            ),
            'WaltDisneyScript'=>array(
                'id'    => 17,
                'font'    => 'WaltDisneyScript',
                'name'    => 'Walt',
            ),
        );
        return $dataArray;
    }
}
if (! function_exists('getColors')) {
    function getColors()
    {
        $dataArray = array(
            'Gold-Leaf'=>array(
                'id'    => 1,
                'name'    => 'Gold Leaf',
                'price'    => 4.50,
                'colorCode'    => '#E0C150',
                'imgUrl'    => asset('front/images/step4/colour-thumbs-24ct.png'), //None Border
                'imgUrlA'    => asset('front/images/step4/colour-thumbs-24ct-10.png'), //For Style #1,#2,#3
                'imgUrlB'    => asset('front/images/step4/colour-thumbs-24ct-20.png'), //For Style All
            ),
            'Gold'=>array(
                'id'    => 2,
                'name'    => 'Gold',
                'price'    => 0.00,
                'colorCode'    => '#d0b33c',
                'imgUrl'    => asset('front/images/step4/colour-thumbs-gold.png'),
                'imgUrlA'    => asset('front/images/step4/colour-thumbs-gold.png'), //For Style #1,#2,#3
                'imgUrlB'    => asset('front/images/step4/colour-thumbs-gold.png'), //For Style #1,#2,#3
            ),
            'Silver'=>array(
                'id'    => 3,
                'name'    => 'Silver',
                'price'    => 0.00,
                'colorCode'    => 'silver',
                'imgUrl'    => asset('front/images/step4/colour-thumbs-silver.png'),
                'imgUrlA'    => asset('front/images/step4/colour-thumbs-silver.png'),//For Style #1,#2,#3
                'imgUrlB'    => asset('front/images/step4/colour-thumbs-silver.png'),//For Style #1,#2,#3
            ),
            'Grey'=>array(
                'id'    => 4,
                'name'    => 'Grey',
                'price'    => 0.00,
                'colorCode'    => '#949494',
                'imgUrl'    => asset('front/images/step4/colour-thumbs-grey.png'),
                'imgUrlA'    => asset('front/images/step4/colour-thumbs-grey.png'),//For Style #1,#2,#3
                'imgUrlB'    => asset('front/images/step4/colour-thumbs-grey.png'),//For Style #1,#2,#3
            ),
            'Cream'=>array(
                'id'    => 5,
                'name'    => 'Cream',
                'price'    => 0.00,
                'colorCode'    => '#E4D3B3',
                'imgUrl'    => asset('front/images/step4/colour-thumbs-cream.png'),
                'imgUrlA'    => asset('front/images/step4/colour-thumbs-cream.png'),//For Style #1,#2,#3
                'imgUrlB'    => asset('front/images/step4/colour-thumbs-cream.png'),//For Style #1,#2,#3
            ),
            'White'=>array(
                'id'    => 6,
                'name'    => 'White',
                'price'    => 0.00,
                'colorCode'    => 'white',
                'imgUrl'    => asset('front/images/step4/colour-thumbs-white.png'),
                'imgUrlA'    => asset('front/images/step4/colour-thumbs-white.png'),
                'imgUrlB'    => asset('front/images/step4/colour-thumbs-white.png'),
            ),
        );
        return $dataArray;
    }
}
if (! function_exists('getFixingType')) {
    function getFixingType($type='',$key='')
    {
        $dataArray = array(
            'fixing_type_secret'=>array(
                'id'    => 1,
                'name'    => 'Secret Fixing',
                'code'    => 'fixing_type_secret',
                'price'    => 0.00,
                'imgUrl'    => asset('front/images/step5a/Stakes-Page-Secret-Fixings.png'),
            ),
            'fixing_type_single_ground_stake'=>array(
                'id'    => 2,
                'name'    => 'Single Ground Stake Fixings',
                'code'    => 'fixing_type_single_ground_stake',
                'price'    => 7.50,
                'imgUrl'    => asset('front/images/step5a/Stakes-Page-Single-Fixing.png'),
            ),
            'fixing_type_double_ground_stake'=>array(
                'id'    => 3,
                'name'    => 'Double Ground Stake Fixings',
                'code'    => 'fixing_type_double_ground_stake',
                'price'    => 15.00,
                'imgUrl'    => asset('front/images/step5a/Stakes-Page-Double-Fixings.png'),
            ),
        );
        if(!empty($type)){
            if(!empty($key)) {
                return @$dataArray[$type][$key];
            }else{
                return @$dataArray[$type];
            }
        }else{
            return $dataArray;
        }

    }
}
if (! function_exists('getVoucherType')) {
    function getVoucherType($type='',$key='')
    {
        $dataArray = array(
            '30'=>array(
                'displayPrice'    => 30.00,
                'price'    => 25.00,
                'vat'    => 5.00,
                'imgUrl'    => url('front/images/gift_vouchers/voucher-feature-30.jpg'),
            ),
            '50'=>array(
                'displayPrice'    => 50.00,
                'price'    => 41.66,
                'vat'    => 8.34,
                'imgUrl'    => url('front/images/gift_vouchers/voucher-feature-50.jpg'),
            ),
            '80'=>array(
                'displayPrice'    => 80.00,
                'price'    => 66.66,
                'vat'    => 13.34,
                'imgUrl'    => url('front/images/gift_vouchers/voucher-feature-80.jpg'),
            ),
        );
        if(!empty($type)){
            if(!empty($key)) {
                return @$dataArray[$type][$key];
            }else{
                return @$dataArray[$type];
            }
        }else{
            return $dataArray;
        }

    }
}


if (! function_exists('uniqueVoucherCode')) {
    function uniqueVoucherCode()
    {
        $vCode = _random_alpha_numeric(8);
        $objCart = new Cart();
        $userId = cartUserId();
        $isExistCode = $objCart->isExistVoucherCode($vCode);
        if($isExistCode){
            return uniqueVoucherCode();
        }
        return $vCode;
    }
}


if (! function_exists('cartStepType')) {
    function cartStepType($step)
    {
        $array = array(
            2 => '1'
        );

    }
}

if (! function_exists('cartTotalItemCount')) {
    function cartTotalItemCount()
    {
        $objCart = new Cart();
        $userId = cartUserId();
        $cartDetail = $objCart->isCartExist($userId );
        $totalItems = 0;
        if($cartDetail){
            $cartId = $cartDetail->id;
            $totalItems  = $objCart->getTotalCartItems($cartId);
        }
        return $totalItems ;
    }
}


if (! function_exists('isAdminLogged')) {
    function isAdminLogged()
    {
        return (session()->get('is_active')) ? true : false ;
    }
}
