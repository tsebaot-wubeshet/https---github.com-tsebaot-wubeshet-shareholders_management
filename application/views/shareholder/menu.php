<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');

if (isset($this->session->userdata['logged_in'])) {

	$username = $this->session->userdata['logged_in']['username'];
	$role = $this->session->userdata['logged_in']['role'];
}
?>
<?php
$budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");

$budget_result = mysqli_fetch_array($budget_query);
$from = "";
$to = "";
$year = 0;
if ($budget_result) {
	$from = $budget_result['budget_from'];
	$to = $budget_result['budget_to'];
	$year = $budget_result['id'];
}

?>

<?php if ($role == 3) { ?>


	<ul class="sidebar-menu">
		<li>
			<a href="<?php echo base_url(''); ?>shareholder/home">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
			</a>
		</li>
		<li class="treeview">
			<a href="#">

				<i class="fa fa-th"></i>
				<span>Authorize/Reject</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<?php
				$result1 = mysqli_query($conn, "SELECT count(id) from shareholders where currentYear_status=3");
				$rowss = mysqli_fetch_array($result1);
				?>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/authorize_new_shareholder?from=<?php echo $from; ?>&to=<?php echo $to; ?>"><i class="fa fa-angle-double-right"></i>New Shareholders<?php if ($rowss['count(id)'] == '0') {
																																																																																																							} else { ?><span class="badge bg-red"><?php echo $rowss['count(id)']; ?><?php } ?></a></li>
				<?php

				$query2 = mysqli_query($conn, "SELECT count(id) from blocked where blocked_status = 8");

				$row2 = mysqli_fetch_array($query2);

				?>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/authorize_blocked"><i class="fa fa-angle-double-right"></i>Blocked Shareholders <?php if ($row2['count(id)'] == '0') {
																																																																														} else { ?><span class="badge bg-red"><?php echo $row2['count(id)']; ?><?php } ?></a></li>

				<?php

				$query1212 = mysqli_query($conn, "SELECT count(id) from blocked where blocked_status = 7");

				$row1212 = mysqli_fetch_array($query1212);

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/release_blocked"><i class="fa fa-angle-double-right"></i>Released Blocked <?php if ($row1212['count(id)'] == '0') {
																																																																											} else { ?><span class="badge bg-red"><?php echo $row1212['count(id)']; ?><?php } ?></a></li>
				<?php

				$query3 = mysqli_query($conn, "SELECT count(id) from pludge where pledged_status = 9");

				$row3 = mysqli_fetch_array($query3);

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/pledged"><i class="fa fa-angle-double-right"></i>Pledge Shareholders <?php if ($row3['count(id)'] == '0') {
																																																																								} else { ?><span class="badge bg-red"><?php echo $row3['count(id)']; ?><?php } ?></span></a></li>
				<?php

				$query23 = mysqli_query($conn, "SELECT count(id) from pludge where pledged_status = 7");

				$row23 = mysqli_fetch_array($query23);

				?>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/pledged_release"><i class="fa fa-angle-double-right"></i>Pledged Released <?php if ($row23['count(id)'] == '0') {
																																																																											} else { ?><span class="badge bg-red"><?php echo $row23['count(id)']; ?><?php } ?></a></li>

				<?php

				$query4 = mysqli_query($conn, "SELECT count(id) from transfer where status_of_transfer = 3");

				$row4 = mysqli_fetch_array($query4);

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/authorize_transfer?from=<?php echo $from; ?>&to=<?php echo $to; ?>"><i class="fa fa-angle-double-right"></i> Transfer <?php if ($row4['count(id)'] == '0') {
																																																																																																	} else { ?><span class="badge bg-red"><?php echo $row4['count(id)']; ?><?php } ?></span></a></li>
				<?php

				$query6 = mysqli_query($conn, "SELECT count(id) from capitalized where capitalized_status = 3 ");

				$row6 = mysqli_fetch_array($query6);
				?>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/authorize_capitalized"><i class="fa fa-angle-double-right"></i>Capitilized<?php if ($row6['count(id)'] == '0') {
																																																																											} else { ?><span class="badge bg-red"><?php echo $row6['count(id)']; ?><?php } ?></span></a></li>
			</ul>


			<?php

			$query_allotment = mysqli_query($conn, "SELECT count(id) from allotment where allot_status = 3");

			$alloted_row = mysqli_fetch_array($query_allotment);

			?>
		<li class="active"><a href="<?php echo base_url(''); ?>shareholder/authorize_allotment"><i class="fa fa-angle-double-right"></i>New Allotement <?php if ($alloted_row['count(id)'] == '0') {
																																																																										} else { ?><span class="badge bg-red"><?php echo $alloted_row['count(id)']; ?><?php } ?></span></a></li>

		<li class="active"><a href="<?php echo base_url(''); ?>shareholder/transfer_cap_cash_pay"><i class="fa fa-angle-double-right"></i>Transfer Capitalized, Cash or Payable</a></li>


		<li class="treeview">
			<a href="#">

				<i class="fa fa-th"></i>
				<span>Manage Certificate</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/certificate?from=<?php echo $from; ?>&to=<?php echo $to; ?>"><i class="fa fa-angle-double-right"></i>Certificate</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/certificate_report"><i class="fa fa-angle-double-right"></i>Certificate Report</a></li>
			</ul>

		</li>
		<li class="treeview">
			<a href="#">

				<i class="fa fa-gear"></i>
				<span>Dividend Calculation</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">


				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/add_dividend"><i class="fa fa-angle-double-right"></i>Add Dividend Profit</a></li>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/edit_dividend"><i class="fa fa-angle-double-right"></i>Edit Dividend Profit</a></li>
			</ul>

		</li>
		<li class="active"><a href="<?php echo base_url(''); ?>shareholder/dividend_calculationAlgorithim"><i class="fa fa-angle-double-right"></i>Dividend Report</a></li>

		<li class="active"><a href="<?php echo base_url(''); ?>shareholder/listed"><i class="fa fa-angle-double-right"></i>Manage Shareholders </a></li>


		</li>

		<li class="active"><a href="<?php echo base_url(''); ?>shareholder/top_shareholders"><i class="fa fa-angle-double-right"></i>Top Shareholders</a></li>
		<li class="treeview">
			<a href="#">

				<i class="fa fa-gear"></i>
				<span>Report</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<?php

				$query_blocked_report = mysqli_query($conn, "SELECT *,count(id) from blocked where blocked_status = 5 ");
				$blocked_report_row = mysqli_fetch_array($query_blocked_report);

				?>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/blocked_report"><i class="fa fa-angle-double-right"></i>Blocked Report<?php if ($blocked_report_row['count(id)'] == '0') {
																																																																									} else { ?><span class="badge bg-red"><?php echo $blocked_report_row['count(id)']; ?><?php } ?></a></li>
				<?php

				$query_pledged_report = mysqli_query($conn, "SELECT *, count(id) from pludge where pledged_status = 6 ");
				$pledged_row = mysqli_fetch_array($query_pledged_report);

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/pledged_report"><i class="fa fa-angle-double-right"></i>Pledged Report<?php if ($pledged_row['count(id)'] == '0') {
																																																																									} else { ?><span class="badge bg-red"><?php echo $pledged_row['count(id)']; ?><?php } ?></a></li>
				<?php

				$query_transfer_report = mysqli_query($conn, "SELECT *, count(id) from transfer where status_of_transfer = 4 and year = $year and seller_account !='NIB'");
				$transfer_row = mysqli_fetch_assoc($query_transfer_report);

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/transfer_report"><i class="fa fa-angle-double-right"></i>Transfer Report<?php if ($transfer_row['count(id)'] == '0') {
																																																																										} else { ?><span class="badge bg-red"><?php echo $transfer_row['count(id)']; ?><?php } ?></a></li>
				<?php

				$query_closed_report = mysqli_query($conn, "SELECT *, count(id) from shareholders where currentYear_status = 2 ");
				$closed_row = mysqli_fetch_array($query_closed_report);

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/closed_report"><i class="fa fa-angle-double-right"></i>Closed Report<?php if ($closed_row['count(id)'] == '0') {
																																																																								} else { ?><span class="badge bg-red"><?php echo $closed_row['count(id)']; ?><?php } ?></a></li>

				<?php $certificate_report = $this->db->get('certificate'); ?>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/certificate_report"><i class="fa fa-angle-double-right"></i>Certificate Report</a><span class="badge bg-red"><?php echo $certificate_report->num_rows(); ?></span></li>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/rejected_report"><i class="fa fa-angle-double-right"></i>Rejected List </a></li>

				<?php

				$query_transfer_from_nib = mysqli_query($conn, "SELECT *, count(id) from transfer where status_of_transfer = 4  and year = $year and seller_account ='NIB'");
				$transfer_nib = mysqli_fetch_array($query_transfer_from_nib);

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/transfer_from_nib"><i class="fa fa-angle-double-right"></i>Transfer From NIB<?php if ($transfer_nib['count(id)'] == '0') {
																																																																												} else { ?><span class="badge bg-red"><?php echo $transfer_nib['count(id)']; ?><?php } ?></a></li>

				<?php $this->db->where('share_request_status', 4);
				$share_request_query = $this->db->get('share_request'); ?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/new_share_request_report"><i class="fa fa-angle-double-right"></i>New Share Request<span class="badge bg-red"><?php echo $share_request_query->num_rows(); ?></a></li>

			</ul>

		</li>



	</ul>

<?php } else if ($role == 1) { ?>

	<ul class="sidebar-menu">

		<li>
			<a href="<?php echo base_url(''); ?>shareholder/home">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
			</a>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-th"></i>
				<span>User Management</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/add_user"><i class="fa fa-angle-double-right"></i>Add User </a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/list_user"><i class="fa fa-angle-double-right"></i>User List</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/reset_password"><i class="fa fa-angle-double-right"></i>Reset Passwrod </a></li>

			</ul>


		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-th"></i>

				<span>Upload Data</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/upload_shareholder"><i class="fa fa-angle-double-right"></i>Upload shareholder</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/upload_allotement"><i class="fa fa-angle-double-right"></i>Upload allotement</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/upload_certificate"><i class="fa fa-angle-double-right"></i>Upload certificate</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/upload_balance"><i class="fa fa-angle-double-right"></i>Upload balance</a></li>
			</ul>
		</li>

		<li class="treeview">
			<a href="#">

				<i class="fa fa-th"></i>
				<span>Manage Requestes</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/sharerequest"><i class="fa fa-angle-double-right"></i>Request Share </a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/list_requested_share"><i class="fa fa-angle-double-right"></i>List Request Share</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/upload_sharerequest"><i class="fa fa-angle-double-right"></i>Upload share request</a></li>

			</ul>

		</li>
		<li class="active"><a href="<?php echo base_url(''); ?>shareholder/allotment_update?from=<?php echo $from; ?>&to=<?php echo $to; ?>"> <i class="fa fa-th"></i>Allotment Update</a></li>

	</ul>


<?php } else { ?>

	<ul class="sidebar-menu">

		<li>
			<a href="<?php echo base_url(''); ?>shareholder/home">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span>
			</a>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-th"></i>
				<span>Manage Shareholders</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/listed"><i class="fa fa-angle-double-right"></i>Manage Shareholders </a></li>
				<!--<li class="active"><a href="<?php //echo base_url('');
																				?>shareholder/createshareholder"><i class="fa fa-angle-double-right"></i>Create Shareholder</a></li>-->
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/choose_shareholder"><i class="fa fa-angle-double-right"></i>Create Shareholder</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/block"><i class="fa fa-angle-double-right"></i>Blocked Shareholders </a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/pledged"><i class="fa fa-angle-double-right"></i>Pledged Shareholders </a></li>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/top_shareholders"><i class="fa fa-angle-double-right"></i>Top Shareholders</a></li>
				<!-- <li class="active"><a href="<?php //echo base_url('');
																					?>shareholder/share_for_resale?from=<?php //echo $from; 
																																							?>&to=<?php //echo $to; 
																																															?>"><i class="fa fa-angle-double-right"></i>Share For Resale</a></li> -->

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/manage_allotement"><i class="fa fa-angle-double-right"></i>Manage Allotement</a></li>
			</ul>
		</li>

		<li class="treeview">
			<a href="#">
				<i class="fa fa-th"></i>
				<span>Manage Allotment</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/manage_allotement"><i class="fa fa-angle-double-right"></i>New Allotment</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/list_allotment"><i class="fa fa-angle-double-right"></i>List Allotment</a></li>
				<!-- <li class="active"><a href="<?php //echo base_url('');
																					?>shareholder/upload_allotement"><i class="fa fa-angle-double-right"></i>Upload New Allotement</a></li> -->

			</ul>
		</li>

		<li class="treeview">
			<a href="#">

				<i class="fa fa-th"></i>
				<span>Manage Dividend</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>

			<ul class="treeview-menu">
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/dividend_report"><i class="fa fa-angle-double-right"></i>Dividend Report</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/dividend_capitalized"><i class="fa fa-angle-double-right"></i>Dividend Capitalized</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/dividend_payable"><i class="fa fa-angle-double-right"></i>Dividend Payable</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/cash_payment"><i class="fa fa-angle-double-right"></i>Cash Payment</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/transfer_to_existing"><i class="fa fa-angle-double-right"></i>Transfer From Bank</a></li>

			</ul>

		</li>

		<li class="treeview">
			<a href="#">

				<i class="fa fa-th"></i>
				<span>Manage Certificate</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/certificate"><i class="fa fa-angle-double-right"></i>Certificate</a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/certificate_report"><i class="fa fa-angle-double-right"></i>Certificate Report</a></li>
			</ul>

		</li>
		<li class="treeview">
			<a href="#">

				<i class="fa fa-th"></i>
				<span>Manage Requestes</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/sharerequest"><i class="fa fa-angle-double-right"></i>Request Share </a></li>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/list_requested_share"><i class="fa fa-angle-double-right"></i>List Request Share</a></li>

			</ul>

		</li>


		<li class="treeview">
			<a href="#">

				<i class="fa fa-gear"></i>
				<span>Report</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">

				<?php

				$query_blocked_report = mysqli_query($conn, "SELECT count(id) from blocked where blocked_status = 5 ");
				$blocked_report_row = mysqli_fetch_array($query_blocked_report);

				?>

				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/blocked_report"><i class="fa fa-angle-double-right"></i>Blocked Report<?php if ($blocked_report_row['count(id)'] == '0') {
																																																																									} else { ?><span class="badge bg-red"><?php echo $blocked_report_row['count(id)']; ?><?php } ?></a></li>
				<?php

				$query_pledged_report = mysqli_query($conn, "SELECT count(id) from pludge where pledged_status = 6");
				$pledged_row = mysqli_fetch_array($query_pledged_report);

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/pledged_report"><i class="fa fa-angle-double-right"></i>Pledged Report<?php if ($pledged_row['count(id)'] == '0') {
																																																																									} else { ?><span class="badge bg-red"><?php echo $pledged_row['count(id)']; ?><?php } ?></a></li>
				<?php

				$query_transfer_report = mysqli_query($conn, "SELECT count(id) from transfer where status_of_transfer = 4 and year = $year AND seller_account  != 'NIB'");
				$transfer_row = mysqli_fetch_array($query_transfer_report);
				$transfer_total = $transfer_row ? $transfer_row['count(id)'] : 0;

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/transfer_report"><i class="fa fa-angle-double-right"></i>Transfer Report<?php if ($transfer_total == '0') {
																																																																										} else { ?><span class="badge bg-red"><?php echo $transfer_total; ?><?php } ?></a></li>
				<?php

				$query_closed_report = mysqli_query($conn, "SELECT count(id) from shareholders where currentYear_status = 2");
				$closed_row = mysqli_fetch_array($query_closed_report);
				$closed_total = $closed_row ? $closed_row['count(id)'] : 0;

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/closed_report"><i class="fa fa-angle-double-right"></i>Closed Report<?php if ($closed_total == '0') {
																																																																								} else { ?><span class="badge bg-red"><?php echo $closed_total; ?><?php } ?></a></li>
				<?php

				$query_transfer_from_nib = mysqli_query($conn, "SELECT count(id) from transfer where status_of_transfer = 4 and year = $year and seller_account  = 'NIB'");
				$transfer_nib = mysqli_fetch_array($query_transfer_from_nib);
				$transfer_nib_total = $transfer_nib ? $transfer_nib['count(id)'] : 0;

				?>
				<li class="active"><a href="<?php echo base_url(''); ?>shareholder/transfer_from_nib"><i class="fa fa-angle-double-right"></i>Transfer From NIB<?php if ($transfer_nib_total == '0') {
																																																																												} else { ?><span class="badge bg-red"><?php echo $transfer_nib_total; ?><?php } ?></a></li>

			</ul>

		</li>


	</ul>

<?php } ?>