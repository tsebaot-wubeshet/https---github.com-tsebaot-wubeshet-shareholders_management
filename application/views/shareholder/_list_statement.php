<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {

	$username = $this->session->userdata['logged_in']['username'];
}
?>
<?php
if (isset($_GET['acct'])) {
	$account = $_GET['acct'];
}

if (isset($_GET['block'])) {

?>
	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Success!</b> Shareholder Released Successfully!.
	</div>

<?php } ?>
<!-- Main content -->
<section class="content invoice" style="overflow:hidden">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<img src="<?php echo base_url(); ?>public/img/logo.jpg" alt="">

			</h2>
		</div>
		<!-- /.col -->
	</div>
	<?php
	if (isset($_GET['acct'])) {

		$account = $_GET['acct'];
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
		$query = mysqli_query($conn, "SELECT * FROM shareholders  WHERE account_no = '$account' group by name") or die(mysqli_error($conn));

		$a = 0;

		while ($rows = mysqli_fetch_array($query)) {

			$a = $a + 1;

	?>
			<!-- info row -->
			<div class="col-sm invoice-col" style="width:100%">

				<address>
					<strong>Name of Shareholder: <?php echo $rows['name']; ?></strong><br>
					<strong>Account Number:: <?php echo $rows['account_no']; ?></strong>
				</address>
			</div>

		<?php } ?>
		<!-- Table row -->
		<div class="row">
			<div class="col-xs-12 table-responsive">
				<table id="" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th></th>
							<th>Date</th>
							<th>Particular</th>
							<th>Debit</th>
							<th>Credit</th>
							<th>Balance</th>

					</thead>
					<tbody>
						<tr align="right">
							<td></td>
							<td></td>
							<td>Balance Forward</td>
							<td></td>
							<td></td>
							<td>

								<?php
								$account = $_GET['acct'];
								$query1 = mysqli_query($conn, "SELECT * from balance where account = '$account' and year=$year") or die(mysqli_error($conn));

								$row_balance = mysqli_fetch_array($query1);

								echo number_format($row_balance['total_paidup_capital_inbirr'], 2);
								?>
							</td>
						</tr>
						<?php
						//while ($rows1 = mysqli_fetch_array($query1)) {                                           

						$query2 = mysqli_query($conn, "select c.account, c.capitalized_in_birr, c.value_date as date, ct.type from capitalized c left join capitalized_type ct on c.type=ct.id where c.account = '$account' AND capitalized_status = 4 union

select t.buyer_account, t.total_transfered_in_birr, t.transfer_date as date, 'Transfer = sell'  from transfer t where t.seller_account = '$account' AND status_of_transfer = 4 union

select t.buyer_account, t.total_transfered_in_birr, t.transfer_date as date, 'Transfer = buy'  from transfer t where t.buyer_account = '$account' AND status_of_transfer = 4
order by date asc") or die(mysqli_error($conn));

						$sum1 = 0;
						$balance = $row_balance['total_paidup_capital_inbirr'];
						while ($rows_cap = mysqli_fetch_array($query2)) {


						?>

							<tr align="right">
								<td></td>

								<td><?php echo $rows_cap['date']; ?></td>

								<td><?php echo $rows_cap['type']; ?></td>
								<?php

								if ($rows_cap['account'] == $account) {
								?>

									<td></td>

									<td><?php echo number_format($rows_cap['capitalized_in_birr'], 2); ?></td>

									<?php

									$balance += $rows_cap['capitalized_in_birr'];
									?>

									<td> <?php echo number_format($balance, 2); ?></td>

								<?php
								} else {

								?>
									<td><?php echo number_format($rows_cap['capitalized_in_birr'], 2); ?></td>
									<td></td>
									<?php
									$balance -= $rows_cap['capitalized_in_birr'];
									?>

									<td> <?php echo number_format($balance, 2); ?></td>

								<?php

								}

								?>
							</tr>

						<?php } ?>


					</tbody>
				</table>
			</div><!-- /.col -->
		</div><!-- /.row -->
	<?php } ?>
	<!-- this row will not appear when printing -->
	<div class="row no-print">
		<div class="col-xs-12">
			<button class="btn btn-default" onclick="window.print();"> Print</button>

		</div>
	</div>
</section><!-- /.content -->