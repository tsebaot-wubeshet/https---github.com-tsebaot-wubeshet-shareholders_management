<?php

$conn = mysqli_connect('localhost', 'root', '', 'shareholder');

$this->db->where('budget_status', '1');
$query = $this->db->get('budget_year');
$year = $query->row()->id;

$qryreport = mysqli_query($conn, "SELECT s.account_no, s.name, (b.total_paidup_capital_inbirr / 500) + ifnull(a.allotment, 0), b.total_paidup_capital_inbirr, ifnull(a.allotment, 0), b.total_paidup_capital_inbirr + ifnull(a.allotment * 500, 0) - b.total_paidup_capital_inbirr, ifnull(sr.total_share_request,0),  sa.city, sa.sub_city, sa.woreda, sa.house_no, sa.pobox, sa.telephone_residence, sa.telephone_office, sa.mobile 
FROM shareholders s
LEFT OUTER JOIN allotment a
	ON s.account_no = a.account
LEFT OUTER JOIN balance b
	ON b.account = s.account_no
LEFT OUTER JOIN shareholder_address sa
	ON sa.account = s.account_no
LEFT OUTER JOIN share_request sr
	ON s.account_no = sr.account 
WHERE s.currentYear_status = 1 and b.year = $year
ORDER BY cast(s.account_no as int) ASC") or die(mysqli_error($conn));

$sqlrows = mysqli_num_rows($qryreport);

$j = 8;

$forBreakdown = array();
$i = 0;
$date = date("d-m-Y");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Shareholders Data ' . $date . '.csv');
$output = fopen("php://output", "w");
fputcsv($output, array('', '', '', 'NIB International Bank S.C'));
fputcsv($output, array('', '', '', 'Shareholders Data'));

fputcsv($output, array('A/C No.', 'Full Name', 'Total Shares Subscribed', 'Total Paid-Up Capital in Birr', 'Allotment', 'Unpaid Balance', 'Additional share request', 'City', 'Kifle Ketema', 'Woreda/Kebele', 'House No.', 'P.O. Box', 'Telephone Residence', 'Telephone Office', 'Mobile'));

// $result = mysqli_query($conn, $qryreport);  
while ($row = mysqli_fetch_assoc($qryreport)) {
	fputcsv($output, $row);
	$i++;
}
fclose($output);
   
   
// 	$qryreport = mysqli_query($conn,"SELECT shareholders.id,shareholders.account_no,shareholders.name,shareholders.total_share_subscribed,shareholders.total_paidup_capital_inbirr,new_request.total_share,allotment.allotment,shareholders.city,shareholders.sub_city,Shareholders.woreda,Shareholders.house_no,Shareholders.pobox,Shareholders.telephone_residence,Shareholders.telephone_office,shareholders.mobile FROM shareholders LEFT JOIN allotment ON shareholders.account_no = allotment.account_no LEFT JOIN share_request ON shareholders.account_no = share_request.account_no WHERE shareholders.status = 'active' order by shareholders.account_no ASC") or die(mysqli_error($conn));
	
// 	$sqlrows=mysqli_num_rows($qryreport);
	
// 	$j=8;
	
// 	while ($reportdisp=mysqli_fetch_array($qryreport)) { $id=$reportdisp['id'];
	
// 	$j=$j+1;
		
// 			$account_no = $reportdisp['account_no'];

// 			$name = $reportdisp['name'];

// 			$total_share_subscribed = $reportdisp['total_share_subscribed'];

// 			$allotement = $reportdisp['allotment'];

// 			$total_paidup_capital_inbirr = $reportdisp['total_paidup_capital_inbirr'];

// 			$unpaid_balance = ($allotement*500) + ($total_share_subscribed*500)-$total_paidup_capital_inbirr;

// 			$new_share = $reportdisp['total_share'];

// 			$city = $reportdisp['city'];

// 			$subcity = $reportdisp['sub_city'];

// 			$woreda = $reportdisp['woreda'];

// 			$house_no = $reportdisp['house_no'];

// 			$pobox = $reportdisp['pobox'];

// 			$telephone_residence = $reportdisp['telephone_residence'];

// 			$telephone_office = $reportdisp['telephone_office'];

// 			$mobile = $reportdisp['mobile'];
			
		 
	 
// 	}
	
	
	
// /////////////////
 
  
// $workbook->close();
