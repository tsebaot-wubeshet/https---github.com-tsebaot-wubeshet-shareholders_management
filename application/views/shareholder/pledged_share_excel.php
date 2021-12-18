<?php

$conn=mysqli_connect('localhost','root','','shareholder'); 

$qryreport = mysqli_query($conn, "SELECT p.account, s.name, b.total_paidup_capital_inbirr, p.pledged_amount, p.pledged_reason, pledged_date FROM pludge p
LEFT JOIN shareholders s 
    ON p.account = s.account_no
LEFT JOIN balance b
    ON b.account = p.account
WHERE pledged_status = '6' ORDER BY pledged_date DESC") or die(mysqli_error($conn));

$sqlrows=mysqli_num_rows($qryreport);

$j=8;

  $forBreakdown=array();
  $i=0;
 $date=date("d-m-Y");
  header('Content-Type: text/csv; charset=utf-8');  
  header('Content-Disposition: attachment; filename=Pledged Shareholders Report '.$date.'.csv');  
  $output = fopen("php://output", "w"); 
  fputcsv($output,array('','','NIB International Bank S.C'));
  fputcsv($output,array('','','Pledged Share Report')); 

  fputcsv($output, array('A/C No.', 'Full Name', 'Total Paid-Up Capital in Birr', 'Pledged Amount', 'Reason','Pledged Date'));  

  while($row = mysqli_fetch_assoc($qryreport))  
  { 
      fputcsv($output, $row);  
      $i++;
  }  
  fclose($output);
   
?>
			

