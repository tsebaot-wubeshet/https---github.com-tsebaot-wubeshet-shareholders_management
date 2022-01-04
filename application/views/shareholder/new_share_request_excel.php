<?php


$conn = mysqli_connect('localhost', 'root', '', 'shareholder');

$this->db->where('budget_status', '1');
$query = $this->db->get('budget_year');
$active_budget_year = $query->row()->id;

$qryreport = mysqli_query($conn, "SELECT sr.account, s.name, sr.total_share_request, CONCAT(b.budget_from ,' - ', b.budget_to), sr.application_date, u.user_name, st.status 
FROM share_request sr 
LEFT JOIN shareholders s ON s.account_no = sr.account 
LEFT JOIN budget_year b ON b.id = sr.year
LEFT JOIN status st ON st.id = sr.share_request_status
LEFT JOIN user_login u ON u.id = sr.maker
WHERE sr.year = $active_budget_year and sr.share_request_status = 4") or die(mysqli_error($conn));

$sqlrows = mysqli_num_rows($qryreport);

$j = 8;

$forBreakdown = array();
$i = 0;
$date = date("d-m-Y");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=New Share Request Report ' . $date . '.csv');
$output = fopen("php://output", "w");
fputcsv($output, array('', '', '', 'NIB International Bank S.C'));
fputcsv($output, array('', '', '', 'New Share Request Report'));

fputcsv($output, array('A/C No.', 'Full Name', 'Total Share Request', 'Budget Year', 'Application Date', 'Maker', 'Status'));

// $result = mysqli_query($conn, $qryreport);  
while ($row = mysqli_fetch_assoc($qryreport)) {
	fputcsv($output, $row);
	$i++;
}
fclose($output);
