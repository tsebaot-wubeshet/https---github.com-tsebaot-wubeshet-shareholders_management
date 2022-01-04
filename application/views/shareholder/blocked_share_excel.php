<?php

$conn = mysqli_connect('localhost', 'root', '', 'shareholder');

$qryreport = mysqli_query($conn, "SELECT b.account, s.name, bl.total_paidup_capital_inbirr, b.blocked_amount, b.blocked_type, b.block_remark, b.blocked_date 
FROM blocked b 
  LEFT JOIN shareholders s ON s.account_no = b.account 
  LEFT JOIN balance bl ON bl.account = b.account  
  WHERE blocked_status = 5 AND b.year = 1  ORDER BY b.id DESC") or die(mysqli_error($conn));

$sqlrows = mysqli_num_rows($qryreport);

$j = 8;

$forBreakdown = array();
$i = 0;
$date = date("d-m-Y");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Blocked Shareholders Report ' . $date . '.csv');
$output = fopen("php://output", "w");
fputcsv($output, array('', '', '', 'NIB International Bank S.C'));
fputcsv($output, array('', '', '', 'Blocked Share Report'));

fputcsv($output, array('A/C No.', 'Full Name', 'Total Paid-Up Capital in Birr', 'Amount Blocked', 'Blocked Type', 'Reason', 'Blocked Date'));

// $result = mysqli_query($conn, $qryreport);  
while ($row = mysqli_fetch_assoc($qryreport)) {
  fputcsv($output, $row);
  $i++;
}
fclose($output);
