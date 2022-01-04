<?php

$conn=mysqli_connect('localhost','root','','shareholder'); 

$qryreport = mysqli_query($conn, "SELECT t.buyer_account, s.name, t.total_transfered_in_birr, t.value_date FROM transfer t
	LEFT JOIN shareholders s
		ON s.account_no = t.buyer_account
	WHERE t.status_of_transfer = 4 AND t.seller_account = 'NIB' 
	ORDER BY t.transfer_date DESC") or die(mysqli_error($conn));

$sqlrows=mysqli_num_rows($qryreport);

$j=8;

  $forBreakdown=array();
  $i=0;
 $date=date("d-m-Y");
  header('Content-Type: text/csv; charset=utf-8');  
  header('Content-Disposition: attachment; filename=Transfer from NIB Report '.$date.'.csv');  
  $output = fopen("php://output", "w"); 
  fputcsv($output,array('','','','','NIB International Bank S.C'));
  fputcsv($output,array('','','','','Transfer from NIB Report')); 

  fputcsv($output, array('Share Buyer A/C No.', 'Full Name', 'Amount of Share Transferred', 'Value Date'));  

  // $result = mysqli_query($conn, $qryreport);  
  while($row = mysqli_fetch_assoc($qryreport))  
  { 
      fputcsv($output, $row);  
      $i++;
  }  
  fclose($output);
