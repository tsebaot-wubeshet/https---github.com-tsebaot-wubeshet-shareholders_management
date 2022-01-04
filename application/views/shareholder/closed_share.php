<?php


$conn = mysqli_connect('localhost', 'root', '', 'shareholder');

$qryreport = mysqli_query($conn, "SELECT s.account_no, s.name, b.total_paidup_capital_inbirr, 'Closed', s.closed_date FROM shareholders s 
LEFT JOIN balance b 
  ON b.account = s.account_no
WHERE s.currentYear_status = 2 ORDER BY s.closed_date DESC") or die(mysqli_error($conn));

$sqlrows = mysqli_num_rows($qryreport);

$j = 8;

$forBreakdown = array();
$i = 0;
$date = date("d-m-Y");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Closed Report ' . $date . '.csv');
$output = fopen("php://output", "w");
fputcsv($output, array('', '', 'NIB International Bank S.C'));
fputcsv($output, array('', '', 'Closed Report'));

fputcsv($output, array('A/C No.', 'Shareholder Name', 'Total Paid-Up Capital(in birr)', 'Shareholder Status', 'Closed Date'));

while ($row = mysqli_fetch_assoc($qryreport)) {
	fputcsv($output, $row);
	$i++;
}
fclose($output);


//   require_once('OLEwriter.php');
//   require_once('BIFFwriter.php');
//   require_once('Worksheet.php');
//   require_once('Workbook.php');
//   //require_once('../conn.php');
//   $conn=mysqli_connect('localhost','root','','shareholder'); 
//     function HeaderingExcel($filename) {
//       header("Content-type: application/vnd.ms-excel");
//       header("Content-Disposition: attachment; filename=$filename" );
//       header("Expires: 0");
//       header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
//       header("Pragma: public");
//       }
	  
// 	  // HTTP headers
// 	HeaderingExcel('closed_report.csv');// Creating a workbook
// 	$workbook = new excel("-");
// 	// Creating the first worksheet
// 	$worksheet1 =& $workbook->add_worksheet('SHAREHOLDER MANAGEMENT SYSTEM');
// 	$worksheet1->freeze_panes(1, 1);
//   $worksheet1->set_column(0, 0, 25);
//   $worksheet1->set_column(1, 1, 20);
//   $worksheet1->set_column(1, 2, 20);
//   $worksheet1->set_column(1, 3, 20);
//   $worksheet1->set_column(1, 4, 20);
//   $worksheet1->set_column(1, 5, 20);
//   $worksheet1->set_column(1, 6, 20);
  

//    $worksheet1->write_string(1,6.15,"NIB International Bank S.C");
   
   
//    $worksheet1->write_string(4,6.15,"Shareholder Transfer Report");
   
//    $worksheet1->write_string(7,0,"Share transfer from");
   
//    $worksheet1->write_string(7,1,"Share subscribed before transfer");
   
//    $worksheet1->write_string(7,2,"Share subscribed after transfer");

//    $worksheet1->write_string(7,3,"Amount of share transfered");
   
//    $worksheet1->write_string(7,4,"Share transfer to");
   
//    $worksheet1->write_string(7,5,"Share subscribed before gaining share");

//    $worksheet1->write_string(7,6,"Share subscribed after gaining share");
   
//    $worksheet1->write_string(7,7,"Closed Date");
   
// /////////////////
// $j=8;

// $a = 0;
// $query = mysqli_query($conn,"SELECT * FROM transfer WHERE status_of_transfer = 4 AND  seller_account in (select account_no from shareholders where currentYear_status=2) order by transfer_date DESC") or die(mysqli_error($conn));
                      
                        
//                         while ($rows = mysqli_fetch_array($query)) {
//                         $a = $a + 1;
// 						$j=$j+1;
//                         $buyer_account=$rows['buyer_account'];
//                         $balance_query = mysqli_query($conn,"SELECT * FROM balance WHERE account = $buyer_account");
//                         $balance_result = mysqli_fetch_array($balance_query);
//                         $buyer_balance=$balance_result?$balance_result['total_paidup_capital_inbirr']:0;

//                         $capitalized_query = mysqli_query($conn,"SELECT sum(capitalized_in_birr) as capitalized_in_birr FROM capitalized WHERE account = $buyer_account and capitalized_status=4");
//                         $capitalized_result = mysqli_fetch_array($capitalized_query);
//                         $buyer_capitalized=$capitalized_result?$capitalized_result['capitalized_in_birr']:0;
                          
//                         $buyer_share=$buyer_balance+$buyer_capitalized;

//                         $seller_account=$rows['seller_account'];
//                         $balance_query = mysqli_query($conn,"SELECT * FROM balance WHERE account = $seller_account");
//                         $balance_result = mysqli_fetch_array($balance_query);
//                         $seller_balance=$balance_result?$balance_result['total_paidup_capital_inbirr']:0;

//                         $capitalized_query = mysqli_query($conn,"SELECT sum(capitalized_in_birr) as capitalized_in_birr FROM capitalized WHERE account = $seller_account and capitalized_status=4");
//                         $capitalized_result = mysqli_fetch_array($capitalized_query);
//                         $seller_capitalized=$capitalized_result?$capitalized_result['capitalized_in_birr']:0;
                         
//                         $seller_share=$seller_balance+$seller_capitalized;


// 						$seller_account = $rows['seller_account'];

// 						$total_share = number_format($seller_share);
			
// 						$total_share_transfered = number_format($seller_share- $rows['total_transfered_in_birr']);

// 						$total_share_transfered_in_birr = number_format($rows['total_transfered_in_birr']);
			
// 						$buyer_account =  $rows['buyer_account'];
						
// 						$buyer_share = number_format($buyer_share);

// 						$buyer_total = number_format($buyer_share+$rows['total_transfered_in_birr']);

// 						$transfer_date = $rows['transfer_date'];
                                             
						
// 			$worksheet1->write_string($j,0,"$seller_account");
				
// 			 $worksheet1->write_string($j,1,"$total_share");
			 
// 			 $worksheet1->write_string($j,2,"$total_share_transfered");

// 			 $worksheet1->write_string($j,3,"$total_share_transfered_in_birr");
			 
// 			 $worksheet1->write_string($j,4,"$buyer_account");
			
// 			 $worksheet1->write_string($j,5,"$buyer_share");

// 			 $worksheet1->write_string($j,6,"$buyer_total");
			 
// 			 $worksheet1->write_string($j,7,"$transfer_date");
                                                   
                                                    
//                                                 } 
	


			
			 
	 
	
	
// /////////////////
  
// $workbook->close();
