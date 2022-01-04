<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
$budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 'active'");
$budget_result = mysqli_fetch_array($budget_query);

$from = "";
$to = "";
if ($budget_result) {
	$from = $budget_result['budget_from'];
	$to = $budget_result['budget_to'];
}

//echo "From".$from.'<br/>';
//echo "To".$to.'<br/>';

$shar = mysqli_query($conn, "SELECT * from shareholders WHERE status = 'active'") or die(mysqli_error($conn));

while ($shar_row = mysqli_fetch_array($shar)) {

	$name = $shar_row['name'];
	$acc = $shar_row['account_no'];
	echo "account number-" . $acc . '<br/>';
	$balance_query = mysqli_query($conn, "SELECT * from balance where account_no = '$acc' and (budget_year BETWEEN '$from' and '$to') group by name order by id ASC") or die(mysqli_error($conn));
	$balance_rows = mysqli_fetch_array($balance_query);
	$share_subscribed_inbirr1 = $shar_row['total_paidup_capital_inbirr'];
	echo "share subscribed in birr 1111" . $share_subscribed_inbirr1;

	$resultp = mysqli_query($conn, "SELECT * from capitalized where account_no = '$acc' AND (value_date BETWEEN '$from' and '$to') AND capitalized_status = 'authorized'") or die(mysqli_error($conn));

	$results = array();

	while ($cash = mysqli_fetch_array($resultp)) {

		//echo "SUm".$cash['sum(capitalized_in_birr)']."<br>";

		$db_date = $cash['value_date'];

		echo "db date" . $db_date;

		$month = 7;
		$year = date('Y');

		$datediff = date("Y-m-t", mktime(0, 0, 0, $month - 1, 1, $year));

		echo "dateDiff1-" . $datediff . '<br/>';

		if (!function_exists("dateDiff")) {

			function dateDiff($start, $end)
			{
				$start_ts = strtotime($start);
				$end_ts = strtotime($end);
				$diff = $end_ts - $start_ts;
				return round($diff / 86400);
			}
		}

		$diff = dateDiff($db_date, $datediff);

		$dif = $diff + 1;

		$cap_cash = $cash['capitalized_in_birr'] * $dif / 365;
		echo "account_no" . $acc . '<br/>';
		echo "cap cash" . $cap_cash . '<br/>';
?>
		<br>__________<br><?php echo number_format(round($cap_cash, 3), 2);

											$results[] = $cap_cash;
										}

										$resultp1 = mysqli_query($conn, "SELECT * from transfer where status_of_transfer = 'authorized' and agred_to = '$acc' || both_buyer = '$acc' || both_seller = '$acc' and (value_date BETWEEN '$from' and '$to')") or die(mysqli_error($conn));

										$results1 = array();

										while ($cash1 = mysqli_fetch_array($resultp1)) {

											if ($cash1['agreement'] == 'both' && $cash1['both_seller'] == $acc) {

												$db_date = $cash1['transfer_date'];

												echo "First case" . $db_date . '<br/>';
											} elseif ($cash1['agreement'] == 'both' && $cash1['both_buyer'] == $acc) {

												$db_date = $cash1['value_date'];

												echo "Second case" . $db_date . '<br/>';
											} else {

												$db_date = $cash1['value_date'];

												echo "Third case" . $db_date . '<br/>';
											}

											$month = 7;

											if ($cash1['agreement'] == 'both' && $cash1['both_seller'] == $acc) {

												$datediff = $cash1['value_date'];

												echo "datediff aggrement both , bothseller = acct_no" . $datediff . '<br/>';
											} else {


												$year = date('Y');
												$datediff = date("Y-m-t", mktime(0, 0, 0, $month - 1, 1, $year));
												echo "date difference " . $datediff . '<br/>';
											}

											if (!function_exists("dateDiff")) {

												function dateDiff($start, $end)
												{
													$start_ts = strtotime($start);
													$end_ts = strtotime($end);
													$diff = $end_ts - $start_ts;
													return round($diff / 86400);
												}
											}

											$diff = dateDiff($db_date, $datediff);

											$dif = $diff + 1;
											echo "diff " . $dif . '<br/>';
											echo "db_date " . $db_date . '<br/>'; //2019-09-17
											echo "datediff " . $datediff . '<br/>'; //2019-06-30
											echo "totalshae" . $cash1['total_transfered_in_birr'] . '<br/>';

											$cap_cash = ($cash1['total_transfered_in_birr'] * $dif) / 365;
											?>
		<br>__________<br><?php echo "cap cash -- " . number_format(round($cap_cash, 3), 2);

											$results1[] = $cap_cash;
										}

										$po_trans = mysqli_query($conn, "SELECT *,sum(total_transfered_in_birr) from transfer where agred_to = '$acc' || both_buyer = '$acc' || both_seller = '$acc' AND (value_date BETWEEN '$from' and '$to') AND status_of_transfer = 'authorized'") or die(mysqli_error($conn));

										while ($po_row = mysqli_fetch_array($po_trans)) {

											print_r($po_row) . '<br/>';

											$resultp = mysqli_query($conn, "SELECT *,SUM(average) from capitalized where account_no = '$acc' AND (value_date BETWEEN '$from' and '$to') AND capitalized_status = 'authorized'") or die(mysqli_error($conn));

											while ($cash = mysqli_fetch_array($resultp)) {

												if ($balance_rows['total_paidup_capital_inbirr'] == '0') {

													$share_subscribed_inbirr = $shar_row['total_paidup_capital_inbirr'];
												} else {

													$share_subscribed_inbirr = $balance_rows['total_paidup_capital_inbirr'];
												}

												echo '<br/>' . "share subscribed in birr1 =" . $share_subscribed_inbirr . '<br/>';

												$db_date = $cash['value_date'];

												$month = 7;
												$year = date('Y');

												$datediff = date("Y-m-t", mktime(0, 0, 0, $month - 1, 1, $year));

												if (!function_exists("dateDiff")) {

													function dateDiff($start, $end)
													{
														$start_ts = strtotime($start);
														$end_ts = strtotime($end);
														$diff = $end_ts - $start_ts;
														return round($diff / 86400);
													}
												}

												$diff = dateDiff($db_date, $datediff);

												$dif = $diff + 1;

												$sum = $cash['capitalized_in_birr'] * $dif / 366;

												$array_result = array_sum($results);

												$array_result1 = array_sum($results1);
												echo '<br/>' . "array result  = " . $array_result . '<br/>';
												echo '<br/>' . "array result 1 = " . $array_result1 . '<br/>';
												$sum_result = $array_result + $array_result1;

												echo '<br/>' . "sum result" . $sum_result . '<br/>';

												$total_paid = $share_subscribed_inbirr + $sum_result;

												echo "po row = " . $po_row['sum(total_transfered_in_birr)'] . '<br/>';
												echo "share subscribed in birr2 = " . $share_subscribed_inbirr . '<br/>';
												$adjusted = $share_subscribed_inbirr - $po_row['sum(total_transfered_in_birr)'];

												$total_paidup_value[] = $adjusted + $sum_result;
												//$total_paidup_value_sum = array_sum($total_paidup_value);
												echo "array result = " . $array_result . '<br/>';

												$total_sum = $array_result + $share_subscribed_inbirr - $po_row['sum(total_transfered_in_birr)'];

												/*if($cash['name'] !== '$name' && $cash['capitalized_in_birr'] == ''){

  $total_paidup_value[] = $share_subscribed_inbirr - $po_row['sum(total_transfered_in_birr)'];

} else {

  $total_paidup_value[] = round($array_result,2) + $share_subscribed_inbirr - $po_row['sum(total_transfered_in_birr)'];

}*/
											?>

			<!-- <input type="text" value="<?php echo $share_subscribed_inbirr; ?>"><br><br>

<input type="text" value="<?php //echo $array_result; 
													?>"><br><br>

<input type="text" value="<?php //echo $total_paidup_value; 
													?>">-->

	<?php //echo number_format(round(array_sum($results),2) + $share_subscribed_inbirr - $po_row['sum(total_transfered_in_birr)'] + $neg_row['sum(total_transfered_in_birr)'],2); 
												//print_r(array_sum($results));
											}
										} ?>

	</td>

	<?php //echo $this->load->view('shareholder/year');
	?>

<?php

	$year = date('Y');

	echo "year " . $year . '<br/>';
	echo "share subscribed in birr 1111-111" . $share_subscribed_inbirr1;
	$sel_query = mysqli_query($conn, "SELECT * from total_paidup_utilized where year = '$year'") or die(mysqli_error($conn));

	$sh_count = mysqli_num_rows($sel_query);

	$sel_row = mysqli_fetch_array($sel_query);

	$total_paidup = array_sum($total_paidup_value);

	echo "<h1>" . "total paidup333 = " . $total_paidup . "</h1>";

	$month = 8;
	$year1 = date('Y');

	$year1 = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year1));

	echo "year1 " . $year1 . '<br/>';

	$month1 = 7;
	$year2 = date('Y') + 1;

	$year4 = date('Y');

	echo "year4 " . $year4 . '<br/>';

	// $year2 = date("Y-m-t", mktime(0, 0, 0, $month1 - 1, 1, $year2));

	echo "year2 " . $year2 . '<br/>';

	$from = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year4 - 1)); //july1 2016

	echo "from" . $from . '<br/>';

	$to = date("Y-m-t", mktime(0, 0, 0, $month1 - 1, 1, $year2 - 1)); //june 30 2017

	echo "To" . $to . '<br/>';

	$year3 = date('Y', strtotime($year1));

	echo "year3 " . $year3 . '<br/>';

	if ($sh_count == 0) {

		mysqli_query($conn, "INSERT into total_paidup_utilized (shareholder_name,value,year) values('$name','$total_paidup','$year3')") or die(mysqli_error($conn));

		header("location:/shareholder_new/shareholder/dividend_report?from=" . $from . "&to=" . $to);
	} else {

		mysqli_query($conn, "UPDATE total_paidup_utilized set value = '$total_paidup' where year = '$year3'") or die(mysqli_error($conn));

		header("location:/shareholder_new/shareholder/dividend_report?from=" . $from . "&to=" . $to);
	}
}
?>