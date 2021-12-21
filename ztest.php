<?php
// error_reporting(E_ALL);
// ini_set('display_errors',1);

if( isset($_REQUEST["from"]) && isset($_REQUEST["to"]) ){
    $from = $_REQUEST["from"];
    $to = $_REQUEST["to"];
}else{
    echo json_encode([]);
    exit();
}

include(dirname(dirname(__FILE__)) . '/database/connection.php');
$db = new PDO_DB();

$live=0;
if($live){

    $orders = $db->rawQry('SELECT pl.*, asi.site_name, asi.site_acronym, COALESCE(aow.camp_vat_type,0) as camp_vat_type,CONCAT(asi.site_acronym,"_", COALESCE(aow.camp_vat_type,0)) as uniqu_site_acronym, asi.site_id FROM as_payment_log pl
						LEFT JOIN as_orders ao ON ao.trans_id = pl.trans_id
						LEFT JOIN as_orders_children aoc ON aoc.order_id = ao.order_id
						LEFT JOIN as_orders_weeks aow ON aow.child_id = aoc.child_id
						LEFT JOIN as_venue_weeks avw ON avw.activity_week_id=aow.activity_week_id
						LEFT JOIN as_sites asi ON asi.site_id = avw.site_id
						WHERE pl.transStatus = ? AND pl.payment_method = ?
						AND ao.trans_status = ? AND ao.order_discon = ?
						AND (date_completed BETWEEN UNIX_TIMESTAMP(?) AND UNIX_TIMESTAMP(?) )
						GROUP BY pl.order_id
						ORDER BY asi.site_acronym',
        ['Y', 'worldpay','Success', 'N', $from, $to]);

    echo json_encode($orders);
}else{
    $orders = $db->rawQry('SELECT pl.* FROM as_payment_log pl, as_orders o
	WHERE pl.transStatus = ? AND pl.payment_method = ?
	AND pl.trans_id=o.trans_id AND o.trans_status = ?
	AND (date_completed BETWEEN UNIX_TIMESTAMP(?) AND UNIX_TIMESTAMP(?) )
	/*AND pl.order_id IN (76421,76433,76440,76401,76398)*/
	/*AND pl.order_id IN (76339,76337)*/
	GROUP BY pl.order_id
	',
        ['Y', 'worldpay','Success', $from, $to]);
    //echo "<pre>";print_r($orders);exit;
    if($orders){
        $WeekListArry = array();
        $finalTaxList = array();
        $totalLPC =0;
        $totalCD =0;
        $totalVat = 0;
        foreach ($orders as $keyOrder => $rowOrder) {
            $orderId = $rowOrder['order_id'];
            #echo "<pre>";print_r($rowOrder);#exit; // [payment_type] => deposit
            #echo $orderId;

            $sqlChild = 'SELECT aoc.* FROM as_orders_children  as aoc WHERE order_id = '.$orderId;
            $orderChildList = $db->rawQry($sqlChild);
            if($orderChildList){
                $refund = 0;
                $isOrderRefundEntery = 1;
                foreach ($orderChildList as $key => $row_child) {
                    $sql_week = "SELECT s.site_acronym,  COALESCE(o.camp_vat_type,0) as camp_vat_type,CONCAT(s.site_acronym,'_', COALESCE(o.camp_vat_type,0)) as uniqu_site_acronym,   s.site_name, s.site_id, v.venue_name, w.week_begin_date, w.week_end_date, o.day_type, o.lunches, o.working_days, o.camp_type, a.activity_name, w.week_type_id, o.week_total, o.week_deposit, o.early_total, o.day_1, o.day_2, o.day_3, o.day_4, o.day_5, o.day_1_early, o.day_2_early, o.day_3_early, o.day_4_early, o.day_5_early, o.day_1_time, o.day_2_time, o.day_3_time, o.day_4_time, o.day_5_time, o.day_1_early_time, o.day_2_early_time, o.day_3_early_time, o.day_4_early_time, o.day_5_early_time, o.day_1_session, o.day_2_session, o.day_3_session, o.day_4_session, o.day_5_session, o.activate_leader, o.camp_vat_type , o.* FROM as_venue_weeks w LEFT JOIN as_sites s ON s.site_id = w.site_id LEFT JOIN as_orders_weeks o ON o.activity_week_id=w.activity_week_id LEFT JOIN as_venues v ON w.venue_id = v.venue_id LEFT JOIN as_activities a ON (o.activity_id=a.activity_id) WHERE o.child_id =".$row_child['child_id'];
                    $orderWeekList =$db->rawQry($sql_week);
                    #echo "<pre>"; print_r($orderWeekList);
                    if($orderWeekList){
                        $GAmount = 0;

                        foreach ($orderWeekList as $keyWeek => $rowWeek) {
                            #	echo "<pre>"; print_r($rowWeek);exit;
                            $rowWeek = (object)$rowWeek;
                            $siteId = $rowWeek->site_id;
                            $campVatType = $rowWeek->camp_vat_type ;
                            $siteName = $rowWeek->site_name;
                            #$week_total = $rowWeek->week_total;

                            $siteAcronym = $rowWeek->site_acronym;

                            if($rowOrder['payment_type'] == 'refund'){
                                $week_total = $rowOrder['amount'];
                                $week_total_vat = $rowOrder['amount_vat'];
                                $pct =0;
                                if(1){
                                    if($siteId==27){
                                        if($campVatType==1){ //CD
                                            $pct =1;
                                            $siteName = $rowWeek->site_name. ' - Development Centre -'.$campVatType;
                                            $GAmount  +=  $week_total;
                                            #$totalForCDLPC  +=  $week_total;
                                            $temp =array(
                                                'course' => $siteName ,
                                                'activity_week_id' => $rowWeek->activity_week_id,
                                                'weekTotalA' => $week_total,
                                                'weekTotal' => $week_total,//$rowWeek->week_total,
                                                'weekTax' => $week_total_vat,//$rowWeek->week_total_vat,
                                                'weekSubTotal' => $week_total,
                                                'campVatType'=>$campVatType,
                                                'taxPct'=> $pct,
                                                'siteId'=>$siteId,
                                                'paymentType' => $rowOrder['payment_type']
                                            );
                                            $WeekListArry['CD'][] = $temp;
                                        }else if($campVatType==2){ //Compbine
                                            $pct =1;
                                            $siteName = $rowWeek->site_name. ' - Development Centre -'.$campVatType;
                                            $GAmount  +=  $week_total;
                                            $totalForCDLPC  +=  $week_total;

                                            $temp =array(
                                                'siteAcronym' => $siteAcronym ,
                                                'course' => $siteName ,
                                                'activity_week_id' => $rowWeek->activity_week_id,
                                                'weekTotalA' => $week_total,
                                                'weekTotal' => $week_total,//$rowWeek->week_total,
                                                'weekTax' => $week_total_vat,//$rowWeek->week_total_vat,
                                                'weekSubTotal' => 0,
                                                'campVatType'=>$campVatType,
                                                'taxPct'=> $pct,
                                                'siteId'=>$siteId,
                                                'paymentType' => $rowOrder['payment_type']
                                            );
                                            $WeekListArry['COMBINE'][] = $temp;
                                        }else{ //LPC
                                            $siteName = $rowWeek->site_name. " - Let's Play Cricket -".$campVatType;
                                            $temp =array(
                                                'siteAcronym' => $siteAcronym ,
                                                'course' => $siteName ,
                                                'activity_week_id' => $rowWeek->activity_week_id,
                                                'weekTotalA' => $week_total,
                                                'weekTotal' => $week_total,//$rowWeek->week_total,
                                                'weekTax' => $week_total_vat,//$rowWeek->week_total_vat,
                                                'weekSubTotal' => 0,
                                                'campVatType'=>$campVatType,
                                                'taxPct'=> $pct,
                                                'siteId'=>$siteId,
                                                'paymentType' => $rowOrder['payment_type']
                                            );
                                            $WeekListArry['LPC'][] = $temp;
                                        }
                                    }else{

                                        $temp =array(
                                            'siteAcronym' => $siteAcronym ,
                                            'course' => $siteName ,
                                            'activity_week_id' => $rowWeek->activity_week_id,
                                            'weekTotalA' => $week_total,
                                            'weekTotal' => $week_total,//$rowWeek->week_total,
                                            'weekTax' => $week_total_vat,//$rowWeek->week_total_vat,
                                            'weekSubTotal' => 0,
                                            'campVatType'=>$campVatType,
                                            'taxPct'=> $pct,
                                            'siteId'=>$siteId,
                                            'paymentType' => $rowOrder['payment_type'],
                                            'mayu' => true
                                        );
                                        if($isOrderRefundEntery){
                                            $WeekListArry['other'][] =$temp;
                                        }
                                        $isOrderRefundEntery = 0;
                                    }
                                }
                                $refund++;
                            }else{
                                $week_total = $rowWeek->week_deposit;
                                $week_total_vat = $rowWeek->week_total_vat;
                                $pct =0;
                                if($siteId==27){
                                    if($campVatType==1){ //CD
                                        $pct =1;
                                        $siteName = $rowWeek->site_name. ' - Development Centre -'.$campVatType;
                                        $GAmount  +=  $week_total;
                                        #$totalForCDLPC  +=  $week_total;
                                        $temp =array(
                                            'course' => $siteName ,
                                            'activity_week_id' => $rowWeek->activity_week_id,
                                            'weekTotalA' => $week_total,
                                            'weekTotal' => $week_total,//$rowWeek->week_total,
                                            'weekTax' => $week_total_vat,//$rowWeek->week_total_vat,
                                            'weekSubTotal' => $week_total,
                                            'campVatType'=>$campVatType,
                                            'taxPct'=> $pct,
                                            'siteId'=>$siteId,
                                            'paymentType' => $rowOrder['payment_type']
                                        );
                                        $WeekListArry['CD'][] = $temp;
                                    }else if($campVatType==2){ //Compbine
                                        $pct =1;
                                        $siteName = $rowWeek->site_name. ' - Development Centre -'.$campVatType;
                                        $GAmount  +=  $week_total;
                                        $totalForCDLPC  +=  $week_total;

                                        $temp =array(
                                            'siteAcronym' => $siteAcronym ,
                                            'course' => $siteName ,
                                            'activity_week_id' => $rowWeek->activity_week_id,
                                            'weekTotalA' => $week_total,
                                            'weekTotal' => $week_total,//$rowWeek->week_total,
                                            'weekTax' => $week_total_vat,//$rowWeek->week_total_vat,
                                            'weekSubTotal' => 0,
                                            'campVatType'=>$campVatType,
                                            'taxPct'=> $pct,
                                            'siteId'=>$siteId,
                                            'paymentType' => $rowOrder['payment_type']
                                        );
                                        $WeekListArry['COMBINE'][] = $temp;
                                    }else{ //LPC
                                        $siteName = $rowWeek->site_name. " - Let's Play Cricket -".$campVatType;
                                        $temp =array(
                                            'siteAcronym' => $siteAcronym ,
                                            'course' => $siteName ,
                                            'activity_week_id' => $rowWeek->activity_week_id,
                                            'weekTotalA' => $week_total,
                                            'weekTotal' => $week_total,//$rowWeek->week_total,
                                            'weekTax' => $week_total_vat,//$rowWeek->week_total_vat,
                                            'weekSubTotal' => 0,
                                            'campVatType'=>$campVatType,
                                            'taxPct'=> $pct,
                                            'siteId'=>$siteId,
                                            'paymentType' => $rowOrder['payment_type']
                                        );
                                        $WeekListArry['LPC'][] = $temp;
                                    }
                                }else{
                                    $temp =array(
                                        'siteAcronym' => $siteAcronym ,
                                        'course' => $siteName ,
                                        'activity_week_id' => $rowWeek->activity_week_id,
                                        'weekTotalA' => $week_total,
                                        'weekTotal' => $week_total,//$rowWeek->week_total,
                                        'weekTax' => $week_total_vat,//$rowWeek->week_total_vat,
                                        'weekSubTotal' => 0,
                                        'campVatType'=>$campVatType,
                                        'taxPct'=> $pct,
                                        'siteId'=>$siteId,
                                        'paymentType' => $rowOrder['payment_type']
                                    );
                                    $WeekListArry['other'][] =$temp;
                                }
                            }
                        }
                    }//if End orderWeekList
                }//Foreach End orderChildList
            }//ENd IF orderChildList


        }//ENd ForEach Orders

        #echo "<pre>";print_r($WeekListArry);#exit
        #		echo "<br>********************************************************************************";

        if($WeekListArry){
            $isLPCExist = array_key_exists('LPC', $WeekListArry);
            #ksort($WeekListArry);
            $tempA = @$WeekListArry['other'];
            if($tempA){
                array_multisort(array_column($tempA, 'siteAcronym'), SORT_ASC, $WeekListArry['other']);
            }

            #echo "<pre>";print_r($WeekListArry);exit;
            foreach ($WeekListArry as $key => $value) {
                if($key=='other'){
                    #echo "<br>=============================================================<br>";
                    #echo "<pre>";print_r($value);#exit;
                    foreach ($value as $vk => $row) {

                        $siteAcronym = $row['siteAcronym'];
                        if($row['paymentType']=='refund')		{
                            $vatTotalRefund = $row['weekTax'] + @$finalTaxList[$siteAcronym]['refundVat'];
                            $subTotalRefund =  $row['weekTotal'] + @$finalTaxList[$siteAcronym]['refundGross'];
                            $TotalCampRefund =$subTotalRefund;
                            $weekSubTotalRefund = _numberFormatWitoutComma(($subTotalRefund - $vatTotalRefund));

                            $vatTotal = @$finalTaxList[$siteAcronym]['weekTax'];
                            $subTotal = @$finalTaxList[$siteAcronym]['weekTotal'];
                            $weekSubTotal = @$finalTaxList[$siteAcronym]['weekSubTotal'];
                            /*echo "<br>REFUND RN : ".$weekSubTotalRefund . " RV : ".$vatTotalRefund. ' RG: '.$TotalCampRefund . " siteAcronym: ".$siteAcronym;
                            echo "<pre> FTS ";
                            var_dump($finalTaxList[$siteAcronym]);
                            print_r(@$finalTaxList[$siteAcronym]);
                            echo "<pre>";print_r(array(
                                'siteAcronym'=>$row['siteAcronym'],
                                'depositNett' => _numberFormatWitoutComma($weekSubTotal),
                                'depositVat' => _numberFormatWitoutComma($vatTotal),
                                'depositGross' => _numberFormatWitoutComma($TotalCamp),

                                'refundNett' => _numberFormatWitoutComma($weekSubTotalRefund),
                                'refundVat' => _numberFormatWitoutComma($vatTotalRefund),
                                'refundGross' => _numberFormatWitoutComma($TotalCampRefund),
                            ));
                            echo "<br>======================<br>";*/
                        }else{
                            $vatTotal = $row['weekTax'] + @$finalTaxList[$siteAcronym]['weekTax'];
                            $subTotal = $row['weekTotal'] + @$finalTaxList[$siteAcronym]['weekTotal'];
                            $TotalCamp =$subTotal;// $row['weekTotal'] ;// + @$finalTaxList[$row['course']]['weekTotal'];
                            $weekSubTotal = 	_numberFormatWitoutComma(($subTotal - $vatTotal));

                            /*if($finalTaxList[$siteAcronym])	{
                                echo "<br>========= START ========<br>";
                                echo "<pre>"; print_r($finalTaxList[$siteAcronym] ); var_dump(@$finalTaxList[$siteAcronym]['refundGross']);
                                echo "<br>=================<br>";
                            }else{
                                echo "<br>************** IN *************<br>";
                                echo "<pre>"; print_r($siteAcronym); var_dump(@$finalTaxList[$siteAcronym]['refundGross']);
                                echo "<br>=================<br>";
                            }*/
                            $vatTotalRefund = (@$finalTaxList[$siteAcronym]['refundVat']) ? @$finalTaxList[$siteAcronym]['refundVat'] : 0;
                            $subTotalRefund =  (@$finalTaxList[$siteAcronym]['refundGross']) ? @$finalTaxList[$siteAcronym]['refundGross'] : 0;
                            $TotalCampRefund =$subTotalRefund;
                            $weekSubTotalRefund = (@$finalTaxList[$siteAcronym]['refundNett']) ? @$finalTaxList[$siteAcronym]['refundNett'] : 0;

                            /*echo "<br>Deposite RN : ".$weekSubTotalRefund . " RV : ".$vatTotalRefund. ' RG: '.$TotalCampRefund . " siteAcronym: ".$siteAcronym;
                            echo "<pre> FTS ";
                            var_dump($finalTaxList[$siteAcronym]);
                            print_r(@$finalTaxList[$siteAcronym]);
                            echo "<pre>";print_r(array(
                                'siteAcronym'=>$row['siteAcronym'],
                                'depositNett' => _numberFormatWitoutComma($weekSubTotal),
                                'depositVat' => _numberFormatWitoutComma($vatTotal),
                                'depositGross' => _numberFormatWitoutComma($TotalCamp),

                                'refundNett' => _numberFormatWitoutComma($weekSubTotalRefund),
                                'refundVat' => _numberFormatWitoutComma($vatTotalRefund),
                                'refundGross' => _numberFormatWitoutComma($TotalCampRefund),
                            ));
                            echo "<br>======================<br>";*/
                            #$key = array_search($row['siteAcronym'], array_column($userdb, 'siteAcronym'));
                        }

                        $finalTaxList[$siteAcronym] = array(
                            'siteAcronym'=>$row['siteAcronym'],
                            'course' => $row['course'] ,
                            'activity_week_id' => $row['activity_week_id'] ,
                            'weekTotalA' => _numberFormatWitoutComma($row['weekTotalA']),
                            'weekTotal' => _numberFormatWitoutComma($TotalCamp),
                            'weekTax' => _numberFormatWitoutComma($vatTotal),
                            'weekSubTotal' => $weekSubTotal,
                            'campVatType'=>$row['campVatType'],
                            'taxPct'=> ($vatTotal>0) ? 1 : $row['taxPct'] ,
                            'siteId'=>$row['siteId'],


                            'depositNett' => _numberFormatWitoutComma($weekSubTotal),
                            'depositVat' => _numberFormatWitoutComma($vatTotal),
                            'depositGross' => _numberFormatWitoutComma($TotalCamp),

                            'refundNett' => _numberFormatWitoutComma($weekSubTotalRefund),
                            'refundVat' => _numberFormatWitoutComma($vatTotalRefund),
                            'refundGross' => _numberFormatWitoutComma($TotalCampRefund),
                            'paymentType' => $row['paymentType']
                        );
                        #echo "<pre> FT ARRAY "; print_r($finalTaxList[$siteAcronym]);
                        /*$finalTaxList[$row['course']] = array(
                                'course' => $row['course'] ,
                                'activity_week_id' => $row['activity_week_id'] ,
                                'weekTotalA' => _numberFormatWitoutComma($row['weekTotalA']),
                                'weekTotal' => _numberFormatWitoutComma($TotalCamp),
                                'weekTax' => _numberFormatWitoutComma($vatTotal),
                                'weekSubTotal' => $weekSubTotal,
                                'campVatType'=>$row['campVatType'],
                                'taxPct'=> ($vatTotal>0) ? 1 : $row['taxPct'] ,
                                'siteId'=>$row['siteId'],
                                'siteAcronym'=>$row['siteAcronym'],

                                'depositNett' => _numberFormatWitoutComma($weekSubTotal),
                                'depositVat' => _numberFormatWitoutComma($vatTotal),
                                'depositGross' => _numberFormatWitoutComma($TotalCamp),

                                'refundNett' => _numberFormatWitoutComma($weekSubTotalRefund),
                                'refundVat' => _numberFormatWitoutComma($vatTotalRefund),
                                'refundGross' => _numberFormatWitoutComma($TotalCampRefund),
                        );*/
                    }
                }
                if($key=='COMBINE'){
                    /*
                        += CD total (60% of week total)
                        += LPC total (40% of week total)
                        += vat amount (CD total / 6)
                    */
                    foreach ($value as $vk => $row) {
                        $weekTotal = $row['weekTotal'];
                        $cdTot = _numberFormatWitoutComma(($weekTotal * 0.6));
                        $lpcTot = _numberFormatWitoutComma(($weekTotal * 0.4));
                        $totalCD  += $cdTot;
                        $totalLPC += $lpcTot;
                        $totalVat += ($cdTot/6);
                    }
                }
                else if($key=='LPC'){
                    /*
                        += LPC total (100% of week total)
                        += vat amount (0)
                    */
                    foreach ($value as $vk => $row) {
                        /*$weekTotal = $row['weekTotalA'];
                        $lpcTot = $weekTotal  + ($totalForCDLPC * 0.4);
                        $totalLPC += $lpcTot;*/
                        $weekTotal = $row['weekTotalA'];
                        $lpcTot =  $weekTotal ;
                        $totalLPC += $lpcTot;
                    }
                }
                else if($key=='CD'){
                    /*
                        += CD total (100% of week total)
                        += vat amount (CD total / 6)
                    */
                    foreach ($value as $vk => $row) {
                        $weekTotal = $row['weekTotalA'];
                        $cdTot =  $weekTotal ; //($totalForCDLPC * 0.6);
                        $totalCD += $cdTot;
                        $totalVat += $cdTot/6;
                    }
                }
            }
            if($totalLPC>0){
                //LPC RECORDS
                $finalTaxList["The Cricket Academy - LPC"] = array(
                    'course' => "The Cricket Academy - Let's Play Cricket" ,
                    'activity_week_id' => 0 ,
                    'weekTotalA' => 0.00,
                    'weekTotal' => _numberFormatWitoutComma($totalLPC),
                    'weekTax' => 0.00,
                    'weekSubTotal' => _numberFormatWitoutComma($totalLPC),
                    'campVatType'=>0,
                    'taxPct'=> 0,
                    'siteId'=> 27,
                    #'siteId'=>$row['siteId'],
                    'siteAcronym'=>'TCA - LPC', //number_format(1000.5, 2, '.', '');
                    'depositNett' => _numberFormatWitoutComma($totalLPC),
                    'depositVat' => 0.00,
                    'depositGross' => _numberFormatWitoutComma($totalLPC),
                    'refundNett' => _numberFormatWitoutComma('0.00'),
                    'refundVat' => _numberFormatWitoutComma('0.00'),
                    'refundGross' => _numberFormatWitoutComma('0.00'),
                );
            }
            if($totalCD>0){
                //LPC RECORDS
                $finalTaxList["The Cricket Academy - CD"] = array(
                    'course' => "The Cricket Academy - Development Centre" ,
                    'activity_week_id' => 0 ,
                    'weekTotalA' => 0.00,
                    'weekTotal' => _numberFormatWitoutComma($totalCD),
                    'weekTax' => $totalVat,
                    'weekSubTotal' => _numberFormatWitoutComma(($totalCD-$totalVat)), //$totalCD,//
                    'campVatType'=>0,
                    'taxPct'=> 1,
                    'siteId'=> 27,
                    #'siteId'=>$row['siteId'],
                    'siteAcronym'=>'TCA - CD',
                    'depositNett' => _numberFormatWitoutComma(($totalCD-$totalVat)), //$totalCD,//
                    'depositVat' => $totalVat,
                    'depositGross' => _numberFormatWitoutComma($totalCD),

                    'refundNett' => _numberFormatWitoutComma('0.00'),
                    'refundVat' => _numberFormatWitoutComma('0.00'),
                    'refundGross' => _numberFormatWitoutComma('0.00'),
                );
            }
        }

    }
    ksort($finalTaxList);



    #echo "<pre>";print_r($finalTaxList);exit;
    $responseData['data'] = $finalTaxList;
    #$responseData['data'] = array('records'=>$finalTaxList,'products' => '');

    echo json_encode($responseData);
}

function _numberFormatWitoutComma($amount){
    return number_format($amount,2,'.','');
}
/*
	Fetch Order with Payment log GetPayments
	get type in order wise
	calculate vat order and type wise.


*/
//Amount: 378.25+309.60+716.40+190+148.50+171+414+144+309.60 = 2781.35
//AmountVat : 33.16+51.60+24.75+17.10+24+51.60				 = 202.21
//Amount net: 345.09+258+716.40+190+123.75+153.90+414.00+120+258 = 2579.14
//AuthAMount: 378.25+309.60+716.40+190+148.50+171+414+144+309.60 =  2781.35

?>