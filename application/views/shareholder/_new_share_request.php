<?php

$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {

	$username = $this->session->userdata['logged_in']['username'];
	$userId = $this->session->userdata['logged_in']['id'];
}
?>
<!-- Main content -->
<section class="content">
	<div class="row" style="width:100%">
		<div class="col-xs-12">
			<div class="box">
				<div class="col-xs-2">
					<form method="POST" action="<?php echo base_url(''); ?>shareholder/new_share_request_excel" id="form">

						<button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Download New Share Request Report</button>

					</form>
				</div><br><br>
				<div class="box-body table-responsive">
					<form action="" method="POST">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>No.</th>
									<th>Account No</th>
									<th>Name</th>
									<th>Total share request</th>
									<th>Budget Year</th>
									<th>Application Date</th>
									<th>Maker</th>
									<th>Status</th>
							</thead>
							<tbody>

								<?php
								$this->db->where('budget_status', '1');
								$query = $this->db->get('budget_year');
								$active_budget_year = $query->row()->id;
								$from = $query->row()->budget_from;
								$to = $query->row()->budget_to;

								$query_new_request = mysqli_query($conn, "SELECT sr.*, s.name, b.budget_from, b.budget_to from share_request sr left join shareholders s on s.account_no = sr.account left join budget_year b on b.id = sr.year where sr.year = $active_budget_year and sr.share_request_status = 4") or die(mysqli_error($conn));
								$a = 0;
								while ($rows = mysqli_fetch_array($query_new_request)) {
									$a = $a + 1;
									$status_id = $rows['share_request_status'];
									$status_query = mysqli_query($conn, "SELECT status FROM status WHERE id = $status_id") or die(mysqli_error($conn));
									$status = mysqli_fetch_array($status_query)[0];
									$maker_id = $rows['maker'];
									$maker_query = mysqli_query($conn, "SELECT user_name FROM user_login WHERE id = $maker_id") or die(mysqli_error($conn));
									$maker = mysqli_fetch_array($maker_query)[0];
								?>
									<tr>
										<td><?php echo $a; ?></td>
										<td><?php echo $rows['account']; ?></td>
										<td><?php echo $rows['name']; ?></td>
										<td><?php echo $rows['total_share_request']; ?></td>
										<td><?php echo "(" . $rows['budget_from'] . ") - (" . $rows['budget_to'] . ")"; ?></td>
										<td><?php echo $rows['application_date']; ?></td>
										<td><?php echo $maker; ?></td>
										<td><span class="badge bg-blue"><?php echo $status; ?></span></td>
									</tr>

								<?php
								}

								?>

							</tbody>

						</table>

					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->