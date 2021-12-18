<?php

   
// function dividendCalculation(){
    $conn=mysqli_connect('localhost','root','','shareholder');
   $initialPaidUpCapital=0;
    $soldShare=0;
    $boughtShare=0;
    //$totalTransfered=$boughtShare-$soldShare;
    $totalTransfered=0;
    //$adjestedBalance=$initialPaidUpCapital+$totalTransfered;
    $adjestedBalance=0;
    $forAdjustment=0;
    //$adjestedBalanceForDividend=$adjestedBalance-$forAdjustment;
    $adjestedBalanceForDividend=0;
    $dividendCapitalized=0;
    $dividendPayableCapitalized=0;
    $cashPaid=0;
    //$totalRaised=$dividendCapitalized+$dividendPayableCapitalized+$cashPaid
    $totalRaised=0;
    //$totalPaidUpCapital=$adjestedBalance+$totalRaised;
    $totalPaidUpCapital=0;
    //sum Of each breackdown value
    $sumOfAveragePaidupCapital=0;
    //$totalPaidUpCapitalUtilazid=$adjestedBalanceForDividend+$sumOfAveragePaidupCapital
    $totalPaidUpCapitalUtilazid=0;
    
    function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = abs($end_ts - $start_ts);
        return round($diff / 86400);
    }
    $countNumber ="";
    if(isset($_POST['name'])){
        $countNumber =$_POST['name'];
    }
    $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 'active'");
    $budget_result = mysqli_fetch_array($budget_query);
    $from="";
    $to="";
    $year=0;
    if($budget_result){
    $from = $budget_result['budget_from'];
    $to = $budget_result['budget_to'];
    $year=$budget_result['id'];
    }
    $shareholders = mysqli_query($conn,"SELECT * from shareholders where  status='active' order by id ASC") or die(mysqli_error($conn));    
    $orderShareholder=0; 
    $breakdown=array();
    while ($shareholder = mysqli_fetch_array($shareholders)) {
        $account=$shareholder['account_no'];
        $countNumber=$shareholder['account_no'];
        $balance_query = mysqli_query($conn,"SELECT * from balance where account_no = '$account'") or die(mysqli_error($conn));
        $balance_rows = mysqli_fetch_array($balance_query);   
        $balance = $balance_rows?$balance_rows['total_paidup_capital_inbirr']:0;   
        $initialPaidUpCapital= floatval($balance);    
        
        $result = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr)  from transfer where account_no = '$account'  and (value_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
        $soldShareArray=mysqli_fetch_assoc($result);
        $result1 = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where raccount_no = '$account' and (value_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
        $boughtShareArray = mysqli_fetch_array($result1);
        $boughtShare=$boughtShareArray?$boughtShareArray['sum(total_transfered_in_birr)']:0;
        $soldShare=$soldShareArray?$soldShareArray['sum(total_transfered_in_birr)']:0;
       $totalTransfered=$boughtShare- $soldShare;
        $adjestedBalance=$initialPaidUpCapital+ $totalTransfered;
        
        $resultForAdjestment = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr)  from transfer where account_no = '$account' and agreement='seller' and (transfer_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
        $soldShareArrayForAdjestment=mysqli_fetch_assoc($resultForAdjestment);
        $soldValueForAdjestment=$soldShareArrayForAdjestment?$soldShareArrayForAdjestment['sum(total_transfered_in_birr)']:0;
        $resultForAdjestment = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where raccount_no = '$account' and agreement != 'buyer' and (transfer_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
        $boughtShareArrayForAdjestment = mysqli_fetch_array($resultForAdjestment);
        $boughtValueForAdjestment=$boughtShareArrayForAdjestment?$boughtShareArrayForAdjestment['sum(total_transfered_in_birr)']:0;
        
        $forAdjustment=$soldValueForAdjestment-$boughtValueForAdjestment;

        $adjestedBalanceForDividend=$adjestedBalance+$forAdjustment;
        
        $result = mysqli_query($conn,"SELECT SUM(capitalized_in_birr) AS capitalized_in_birr from capitalized where account_no = '$account' and type = 'capitalized' and (value_date BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));
        $capitalizedArray=mysqli_fetch_array($result);
        $dividendCapitalized=$capitalizedArray['capitalized_in_birr']?$capitalizedArray['capitalized_in_birr']:0;
        $result = mysqli_query($conn,"SELECT SUM(capitalized_in_birr) AS capitalized_in_birr from capitalized where account_no = '$account' and type = 'payable' and (value_date BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn)); 
        $payableArray= mysqli_fetch_array($result);
        $dividendPayableCapitalized=$payableArray['capitalized_in_birr']?$payableArray['capitalized_in_birr']:0;
        $result = mysqli_query($conn,"SELECT SUM(capitalized_in_birr) AS capitalized_in_birr from capitalized where account_no = '$account' and type = 'cash' and (value_date BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));
        $cashArray=mysqli_fetch_array($result);
        $cashPaid=$cashArray['capitalized_in_birr']?$cashArray['capitalized_in_birr']:0;
        
        $totalRaised=$dividendCapitalized+$dividendPayableCapitalized+$cashPaid;

        $totalPaidUpCapital=$adjestedBalance+$totalRaised;
        
        $sellerTransfer = mysqli_query($conn,"SELECT * from transfer where account_no = '$account' and agreement='both' and (value_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
        $fromSold=array();
        while($row=mysqli_fetch_array($sellerTransfer)){
            $fromSold[]=$row;
        }
        $buyerTransfer = mysqli_query($conn,"SELECT * from transfer where raccount_no = '$account' and agreement='both' and (value_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
        //$fromBought=mysqli_fetch_assoc($buyerTransfer);
        $fromBought=array();
        while($row=mysqli_fetch_array($buyerTransfer)){
            $fromBought[]=$row;
        }
        $capitalized = mysqli_query($conn,"SELECT * from capitalized where account_no = '$account' and type='capitalized' and (value_date BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));
        //$fromCapitalized=mysqli_fetch_array($capitalized);
        $fromCapitalized=array();
        while($row=mysqli_fetch_array($capitalized)){
            $fromCapitalized[]=$row;
        }
        $payable = mysqli_query($conn,"SELECT * from capitalized where account_no = '$account' and type='payable' and (value_date BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));
        $fromPayable=mysqli_fetch_array($payable);
        // $fromPayable=array();
        // while($row=mysqli_fetch_array($payable)){
        //   $fromPayable[]=$row;
        // }
        $cash = mysqli_query($conn,"SELECT * from capitalized where account_no = '$account' and type='cash' and (value_date BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));
        //$fromCash=mysqli_fetch_array($cash);
        $fromCash=array();
        while($row=mysqli_fetch_array($cash)){
            $fromCash[]=$row;
        }
        $soldGet = array();
        $endDate=$to;
        $startDate=$from;
        $soldBreakdowun=array();
        $i=0;
        foreach($fromSold as $value) {  
            $amount=$value['total_transfered_in_birr']; 
            $startDate = $from;
            $endDate = $value['value_date'];
            $endDate=date('d-m-Y', strtotime($endDate. ' - 1 days'));
            $diff = dateDiff($startDate, $endDate);
            $dif = $diff + 1;
            $cap_cash = ($amount * $dif) / 366;
            $soldGet[] = $cap_cash;
            $type='sold';
            $id=$value['id'];
            mysqli_query($conn,"INSERT INTO break_down (account,amount,value_date,end_value_date,total_date,avarage_paidup_capital,bk_id,bk_type,start_date,end_date)
                   values('$account',$amount,'$startDate','$endDate',$dif,round($cap_cash,2),$id,'$type','$from','$to') 
                   ON DUPLICATE KEY UPDATE amount=values(amount),value_date=values(value_date),end_value_date=values(end_value_date),total_date=values(total_date),avarage_paidup_capital=values(avarage_paidup_capital)")or die(mysqli_error($conn));
            $soldBreakdowun[$i]['value_date']=$startDate;
            $soldBreakdowun[$i]['end_date']=$endDate;
            $soldBreakdowun[$i]['total_date']=$dif;
            $soldBreakdowun[$i]['amount']=$amount;
            $soldBreakdowun[$i]['avarage_paidup_capital']=round($cap_cash,2);
            $i++;
        
       }
        $endDate=$to;
        $startDate=$from;
        $boughtGet = array();
        $boughtBreakdown=array();
        foreach($fromBought as $value) {
            $amount=$value['total_transfered_in_birr'];
            $startDate = $value['value_date'];
            $endDate = $to ;
            $startDate=date('d-m-Y', strtotime($startDate));
            $diff = dateDiff($startDate, $endDate);
            $dif = $diff + 1;
            $cap_cash = ($amount * $dif) / 366;
            $boughtGet[] = $cap_cash;
            $type='bought';
            $id=$value['id'];
            mysqli_query($conn,"INSERT INTO break_down (account,amount,value_date,end_value_date,total_date,avarage_paidup_capital,bk_id,bk_type,start_date,end_date)
                   values('$account',$amount,'$startDate','$endDate',$dif,round($cap_cash,2),$id,'$type','$from','$to') 
                   ON DUPLICATE KEY UPDATE amount=values(amount),value_date=values(value_date),end_value_date=values(end_value_date),total_date=values(total_date),avarage_paidup_capital=values(avarage_paidup_capital)")or die(mysqli_error($conn));
            $boughtBreakdown[$i]['value_date']=$startDate;
            $boughtBreakdown[$i]['end_date']=$endDate;
            $boughtBreakdown[$i]['total_date']=$dif;
            $boughtBreakdown[$i]['amount']=$amount;
            $boughtBreakdown[$i]['avarage_paidup_capital']=round($cap_cash,2);
            $i++;
       } 
        $startDate=$from;
        $capitalizedGet = array();
        $capitalizedBreackdown=array();
        $i=0;
        foreach($fromCapitalized as $value) {
            $amount=$value['capitalized_in_birr'];
            $startDate = $value['value_date'];
            $endDate = $to ;
            $startDate=date('d-m-Y', strtotime($startDate));
            $diff = dateDiff($startDate, $endDate);
            $dif = $diff + 1;
            $cap_cash = ($amount * $dif) / 366;
            $capitalizedGet[] = $cap_cash;
            $type='capitalized';
            $id=$value['id'];
            mysqli_query($conn,"INSERT INTO break_down (account,amount,value_date,end_value_date,total_date,avarage_paidup_capital,bk_id,bk_type,start_date,end_date)
                   values('$account',$amount,'$startDate','$endDate',$dif,round($cap_cash,2),$id,'$type','$from','$to') 
                   ON DUPLICATE KEY UPDATE amount=values(amount),value_date=values(value_date),end_value_date=values(end_value_date),total_date=values(total_date),avarage_paidup_capital=values(avarage_paidup_capital)")or die(mysqli_error($conn));
            $capitalizedBreackdown[$i]['value_date']=$startDate;
            $capitalizedBreackdown[$i]['end_date']=$endDate;
            $capitalizedBreackdown[$i]['total_date']=$dif;
            $capitalizedBreackdown[$i]['amount']=$amount;
            $capitalizedBreackdown[$i]['avarage_paidup_capital']=round($cap_cash,2);
            $i++;
        } 

        $endDate=$to;
        $startDate=$from;
        $cashGet = array();
        $sumCount=0;
        $cashBreakdown=array();
        $i=0;
        foreach($fromCash as $value) {
            $amount=$value['capitalized_in_birr'];
            $startDate = $value['value_date'];
            $endDate = $to ;
            $startDate=date('d-m-Y', strtotime($startDate));
            $diff = dateDiff($startDate, $endDate);
            $dif = $diff + 1;
            if($fromPayable && $sumCount==0){
                if($value['capitalized_in_birr'] % 500 !=0 && $value['value_date'] >= $fromPayable['value_date']){
                    $amount=$value['capitalized_in_birr']+$fromPayable['capitalized_in_birr'];
                    $sumCount++;
                }
            }
            $cap_cash = ($amount * $dif) / 366;
            $cashGet[] = $cap_cash;
            $type='cash';
            $id=$value['id'];
            mysqli_query($conn,"INSERT INTO break_down (account,amount,value_date,end_value_date,total_date,avarage_paidup_capital,bk_id,bk_type,start_date,end_date)
                   values('$account',$amount,'$startDate','$endDate',$dif,round($cap_cash,2),$id,'$type','$from','$to') 
                   ON DUPLICATE KEY UPDATE amount=values(amount),value_date=values(value_date),end_value_date=values(end_value_date),total_date=values(total_date),avarage_paidup_capital=values(avarage_paidup_capital)")or die(mysqli_error($conn));
            $cashBreakdown[$i]['value_date']=$startDate;
            $cashBreakdown[$i]['end_date']=$endDate;
            $cashBreakdown[$i]['total_date']=$dif;
            $cashBreakdown[$i]['amount']=$amount;
            $cashBreakdown[$i]['avarage_paidup_capital']=round($cap_cash,2);
            $i++;
        } 
       
        $sumOfAveragePaidupCapital = array_sum($cashGet)+array_sum($capitalizedGet) + array_sum($boughtGet)+ array_sum($soldGet);
        
        $totalPaidUpCapitalUtilazid= $sumOfAveragePaidupCapital + $adjestedBalanceForDividend;

        mysqli_query($conn,"INSERT INTO paidup_utilized (account,amount,start_date,end_date) values($account,$totalPaidUpCapitalUtilazid,'$from','$to') ON DUPLICATE KEY UPDATE amount=values(amount)")or die(mysqli_error($conn));

        mysqli_query($conn,"INSERT INTO dividend_report (account,initial_paidup_capital,transfer,adjusted_balance,forAdjustment,adjusted_balance_for_dividend,capitalized,payable,cash,total_raised,total_paidup_capital,total_average_paidup_capital,total_utilized_paidup_capital,start_date,end_date)
        values('$account',round($initialPaidUpCapital,2),round($totalTransfered,2),round($adjestedBalance,2),round($forAdjustment,2),round($adjestedBalanceForDividend,2),round($dividendCapitalized,2),round($dividendPayableCapitalized,2),round($cashPaid,2),round($totalRaised,2),round($totalPaidUpCapital,2),round($sumOfAveragePaidupCapital,2),round($totalPaidUpCapitalUtilazid,2),'$from','$to') 
        ON DUPLICATE KEY UPDATE initial_paidup_capital = values(initial_paidup_capital), transfer = values(transfer), adjusted_balance = values(adjusted_balance), forAdjustment = values(forAdjustment), adjusted_balance_for_dividend = values(adjusted_balance_for_dividend), capitalized = values(capitalized), payable = values(payable), cash = values(cash), total_raised = values(total_raised), total_paidup_capital = values(total_paidup_capital), total_average_paidup_capital = values(total_average_paidup_capital), total_utilized_paidup_capital = values(total_utilized_paidup_capital)") or die(mysqli_error($conn));
      
        $breakdown[$account]['fromSold']=$soldBreakdowun;
        $breakdown[$account]['fromBought']=$boughtBreakdown;
        $breakdown[$account]['fromCapitalized']= $capitalizedBreackdown;
        $breakdown[$account]['fromCash']=$cashBreakdown;
        $orderShareholder+=1;
    }
        $paidup_utilized_sum = mysqli_query($conn,"SELECT SUM(amount) as value from paidup_utilized where year = $year ") or die(mysqli_error($conn));
        $total_paidup_utilized = mysqli_fetch_array($paidup_utilized_sum); 
        $paidup_utilized = mysqli_query($conn,"SELECT * from paidup_utilized where year = $year ") or die(mysqli_error($conn));
        while($paidup_utilized_row = mysqli_fetch_array($paidup_utilized)){
            $accountNum=$paidup_utilized_row['account'];
            $ratio = 0;
            if($total_paidup_utilized['value']>0){
                $ratio = $paidup_utilized_row['amount']/floatval($total_paidup_utilized['value']);
            }
            $dividend_amt = mysqli_query($conn,"SELECT * from dividend_amount where year = $year ") or die(mysqli_error($conn));
            $div_amt = mysqli_fetch_array($dividend_amt);
            $dividend = 0;
            if($div_amt['dividend']){
                $dividend=$div_amt['dividend'];
            }
            $dividend_portion = $ratio*$dividend;
            mysqli_query($conn,"INSERT INTO ratio_dividend (account,ratio,dividend_portion,year) values($accountNum,$ratio,$dividend_portion,$year) ON DUPLICATE KEY UPDATE ratio=values(ratio),dividend_portion=values(dividend_portion)")or die(mysqli_error($conn));
        }
    // }
        ?>