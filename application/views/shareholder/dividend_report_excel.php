<?php 
$conn=mysqli_connect('localhost','root','','shareholder'); 
$qryreport = mysqli_query($conn,"SELECT shareholders.account_no ,shareholders.name,dividend_report.initial_paidup_capital,dividend_report.transfer,dividend_report.adjusted_balance,dividend_report.forAdjustment,dividend_report.adjusted_balance_for_dividend,dividend_report.capitalized,dividend_report.payable,dividend_report.cash,dividend_report.total_raised,dividend_report.total_paidup_capital,break_down.value_date,break_down.end_value_date,break_down.total_date,break_down.amount,break_down.avarage_paidup_capital,dividend_report.total_average_paidup_capital, dividend_report.total_utilized_paidup_capital,ratio_dividend.ratio,ratio_dividend.dividend_portion
  FROM shareholders
    LEFT JOIN dividend_report ON shareholders.account_no = dividend_report.account
    LEFT JOIN break_down ON shareholders.account_no = break_down.account
    LEFT JOIN ratio_dividend ON shareholders.account_no = ratio_dividend.account
    WHERE shareholders.currentYear_status = 1 order by cast(shareholders.account_no as int) ASC") or die(mysqli_error($conn));

$sqlrows=mysqli_num_rows($qryreport);

$j=8;

  $forBreakdown=array();
  $i=0;
 $date=date("d-m-Y");
  header('Content-Type: text/csv; charset=utf-8');  
  header('Content-Disposition: attachment; filename=Shareholders Dividend Report '.$date.'.csv');  
  $output = fopen("php://output", "w"); 
  fputcsv($output,array('','','','','','','','','','NIB International Bank S.C'));
  fputcsv($output,array('','','','','','','','','','Dividend Report')); 
  fputcsv($output, array('A/C No.', 'FUll Name', 'initial paidup capital', 'transfer', 'adjusted_balance','for Adjustment','Adjusted balance for dividend','capitalized','payable','cash',
'Total Raised','Total paidup capital','Value Date','End value Date','Total Date','Break Down amount','Avarage paidup Capital','Total average paidup capital','Total utilized paidup capital','Ratio','Dividend portion'));  

  // $result = mysqli_query($conn, $qryreport);  
  while($row = mysqli_fetch_assoc($qryreport))  
  { 
     
          if($i%2==0){
            $forBreakdown[0]=$row['account_no'];
          }else{
            $forBreakdown[1]=$row['account_no'];
          }
          if($i>0){
            if($forBreakdown[0]==$forBreakdown[1]){
              $row['account_no']=" ";
              $row['name']=" ";
               $row['initial_paidup_capital']=" ";
               $row['transfer']=" ";
              $row['adjusted_balance']=" ";
              $row['forAdjustment']=" ";
             $row['adjusted_balance_for_dividend']=" ";
              $row['capitalized']=" ";
              $row['payable']=" ";
               $row['cash']=" ";
               $row['total_raised']=" ";
              $row['total_paidup_capital']=" ";
             $row['total_average_paidup_capital']=" ";
             $row['total_utilized_paidup_capital']=" ";
             $row['ratio']="";
             $row['dividend_portion']=" ";

            }
          } 
      fputcsv($output, $row);  
      $i++;
  }  
  fclose($output);
?>