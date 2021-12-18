<?php
require_once('OLEwriter.php');
require_once('BIFFwriter.php');
require_once('Worksheet.php');
require_once('Workbook.php');
//require_once('../conn.php');
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
		
    $username = $this->session->userdata['logged_in']['username'];
    $userId= $this->session->userdata['logged_in']['id']; 
    }
function HeaderingExcel($filename)
{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$filename");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
	header("Pragma: public");
}
$date = date('M d Y');

// HTTP headers
HeaderingExcel("New_Share_Request_Report - $date.csv"); // Creating a workbook
$workbook = new excel("-");
// Creating the first worksheet
$worksheet1 = &$workbook->add_worksheet('SHAREHOLDER MANAGEMENT SYSTEM');
$worksheet1->freeze_panes(1, 1);
$worksheet1->set_column(0, 0, 25);
$worksheet1->set_column(1, 1, 20);
$worksheet1->set_column(1, 2, 20);
$worksheet1->set_column(1, 3, 20);
$worksheet1->set_column(1, 4, 20);
$worksheet1->set_column(1, 5, 20);
$worksheet1->set_column(1, 6, 20);


$worksheet1->write_string(1, 2.15, "NIB International Bank S.C");

$worksheet1->write_string(4, 2.15, "Shareholder Transfer Report");

$worksheet1->write_string(7, 0, "A/N");

$worksheet1->write_string(7, 1, "Name");

$worksheet1->write_string(7, 2, "Total Share Request");

$worksheet1->write_string(7, 3, "Budget Year");

$worksheet1->write_string(7, 4, "Application Date");

$worksheet1->write_string(7, 5, "Maker");

$worksheet1->write_string(7, 6, "Status");



/////////////////
$this->db->where('budget_status', '1');
$query = $this->db->get('budget_year');

$active_budget_year = $query->row();
$from = $active_budget_year->budget_from;
$to = $active_budget_year->budget_to;

$qryreport = mysqli_query($conn, "SELECT sr.*, s.name from share_request sr left join shareholders s on s.account_no = sr.account where sr.year = $active_budget_year->id") or die(mysqli_error($conn));


$sqlrows = mysqli_num_rows($qryreport);

$j = 7;

while ($reportdisp = mysqli_fetch_array($qryreport)) {
	$j = $j + 1;

    $status_id = $reportdisp['share_request_status'];
    $status_query = mysqli_query($conn,"SELECT status FROM status WHERE id = $status_id") or die(mysqli_error($conn));

    $status = mysqli_fetch_array($status_query)[0];

	$account = $reportdisp['account'];
	$name = $reportdisp['name'];
	$total_share_request = $reportdisp['total_share_request'];
	$budget_year = "(".$from.") - (".$to.")";

	$application_date = $reportdisp['application_date'];

/////
	$worksheet1->write_string($j, 0, "$account");
	$worksheet1->write_string($j, 1, "$name");

	$worksheet1->write_string($j, 2, "$total_share_request");

	$worksheet1->write_string($j, 3, "$budget_year");

	$worksheet1->write_string($j, 4, "$application_date");

	$worksheet1->write_string($j, 5, "$username");
	$worksheet1->write_string($j, 6, "$status");
	
}



/////////////////




$workbook->close();
