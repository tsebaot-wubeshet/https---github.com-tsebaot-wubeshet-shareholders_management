<?php

$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {

	$username = $this->session->userdata['logged_in']['username'];
}

?>
<?php

if (isset($_GET['active'])) {

?>

	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Success!</b> Shareholder Released Successfully!.
	</div>

<?php } ?>
<!-- Main content -->
<section class="content">
	<div class="row" style="width:100%">
		<div class="col-xs-12">
			<div class="box">
				<div class="col-xs-2">
					<form method="POST" action="<?php echo base_url(''); ?>shareholder/transfer_share_from_nib_excel" id="form">

						<button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Download Transfer Report From The Bank</button>

					</form>
				</div><br><br>
				<div class="box-body table-responsive">
					<form action="" method="POST">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>No.</th>
									<th>Share Transferred From</th>
									<th>Share Buyer Account </th>
									<th>Share Buyer Name </th>
									<th>Amount of Share Transferred</th>
							</thead>
							<tbody>

								<?php

								$budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");
								$budget_result = mysqli_fetch_array($budget_query);
								$from = "";
								$to = "";
								if ($budget_result) {
									$from = $budget_result['budget_from'];
									$to = $budget_result['budget_to'];
								}
								$query = mysqli_query($conn, "SELECT t.*, s.name as buyer_name from transfer t left join shareholders s on s.account_no = t.buyer_account WHERE status_of_transfer = 4 AND seller_account = 'NIB'") or die(mysqli_error($conn));

								$a = 0;

								while ($rows = mysqli_fetch_array($query)) {
									$a = $a + 1;
								?>
									<tr>

										<td><?php echo $a; ?></td>

										<td><?php echo $rows['seller_account']; ?></td>
										<td><?php echo $rows['buyer_account']; ?></td>
										<td><?php echo $rows['buyer_name']; ?></td>

										<td><?php echo number_format($rows['total_transfered_in_birr']); ?></td>


									<?php }  ?>
									</tr>

							</tbody>

						</table>

					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->