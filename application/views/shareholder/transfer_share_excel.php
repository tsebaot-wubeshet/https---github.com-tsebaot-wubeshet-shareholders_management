<?php

$conn=mysqli_connect('localhost','root','','shareholder'); 

$qryreport = mysqli_query($conn, "SELECT t.seller_account, ss.name as seller_name, t.buyer_account, sb.name as buyer_name, bb.total_paidup_capital_inbirr as seller_share_before, (bb.total_paidup_capital_inbirr - t.total_transfered_in_birr) as seller_share_after, t.total_transfered_in_birr, bs.total_paidup_capital_inbirr as buyer_share_before, (bs.total_paidup_capital_inbirr + t.total_transfered_in_birr) as buyer_share_after, t.value_date FROM transfer t
	LEFT JOIN shareholders ss
		ON ss.account_no = t.seller_account
	LEFT JOIN shareholders sb
		ON sb.account_no = t.buyer_account
	LEFT JOIN balance bb
		ON bb.account = t.seller_account
	LEFT JOIN balance bs
		ON bs.account = t.buyer_account
	WHERE t.status_of_transfer = 4 AND t.seller_account != 'NIB' 
	ORDER BY t.transfer_date DESC") or die(mysqli_error($conn));

$sqlrows=mysqli_num_rows($qryreport);

$j=8;

  $forBreakdown=array();
  $i=0;
 $date=date("d-m-Y");
  header('Content-Type: text/csv; charset=utf-8');  
  header('Content-Disposition: attachment; filename=Transfer Report '.$date.'.csv');  
  $output = fopen("php://output", "w"); 
  fputcsv($output,array('','','','','NIB International Bank S.C'));
  fputcsv($output,array('','','','','Transfer Report')); 

  fputcsv($output, array('Seller A/C No.', 'Seller Full Name', 'Buyer A/C No.','Buyer Full Name','Seller Total Subscribed Before Transfer(in Birr)', 'Seller Total Subscribed After Transfer(in birr)', 'Amount of Share Transferred(in birr)','Buyer Total Subscribed Before Gaining Shares(in Birr)','Buyer Total Subscribed After Gaining Shares(in Birr)', 'Value Date'));  

  // $result = mysqli_query($conn, $qryreport);  
  while($row = mysqli_fetch_assoc($qryreport))  
  { 
      fputcsv($output, $row);  
      $i++;
  }  
  fclose($output);
