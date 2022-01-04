<?php

$conn = mysqli_connect('localhost', 'root', '', 'shareholder');

$qryreport = mysqli_query($conn, "SELECT c.account, s.name, b.total_paidup_capital_inbirr, (b.total_paidup_capital_inbirr / 500), c.issued_share_certificate, c.prepared_share_certificate, ((b.total_paidup_capital_inbirr / 500) - c.issued_share_certificate - c.prepared_share_certificate)
FROM certificate c 
LEFT JOIN shareholders s 
	ON s.account_no = c.account 
LEFT JOIN balance b 
	ON b.account = c.account") or die(mysqli_error($conn));

$sqlrows = mysqli_num_rows($qryreport);

$j = 8;

$forBreakdown = array();
$i = 0;
$date = date("d-m-Y");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Certificate Report ' . $date . '.csv');
$output = fopen("php://output", "w");
fputcsv($output, array('', '', '', 'NIB International Bank S.C'));
fputcsv($output, array('', '', '', 'Certificate Report'));

fputcsv($output, array('A/C No.', 'Full Name', 'Total Paid-Up Capital in Birr', 'Total Paid up shares', 'Issued Share Certificate', 'Prepared share certificate', 'Remaining share to be prepared'));

// $result = mysqli_query($conn, $qryreport);  
while ($row = mysqli_fetch_assoc($qryreport)) {
	fputcsv($output, $row);
	$i++;
}
fclose($output);
