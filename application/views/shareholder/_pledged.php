<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
	$username = $this->session->userdata['logged_in']['username'];
	$role = $this->session->userdata['logged_in']['role'];
	$userId = $this->session->userdata['logged_in']['id'];
}
?>
<?php if (isset($_GET['pledged'])) { ?>

	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Success!</b> Pledged Authorized Successfully!.
	</div>

<?php } ?>
<!-- Main content -->
<section class="content">
	<div class="row" style="width:100%">
		<div class="col-xs-12">
			<div class="box">

				<div class="box-body table-responsive">
					<form action="" method="POST">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<?php if ($role == 3) { ?>
										<th></th>
										<th></th>
									<?php } ?>
									<th>No.</th>
									<th>Account number</th>
									<th>Shareholder Name</th>
									<th>Pledged Amount</th>
									<th>Reason</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>

								<?php $query = mysqli_query($conn, "SELECT p.*, s.name from pludge p LEFT JOIN shareholders s ON s.account_no = p.account where pledged_status = 9 order by id ASC") or die(mysqli_error($conn));
								$a = 0;

								while ($rows = mysqli_fetch_array($query)) {
									$pledge_status_id = $rows['pledged_status'];
									$pledge_status_query = mysqli_query($conn, "SELECT status FROM status WHERE id = $pledge_status_id");
									$pledge_status = mysqli_fetch_object($pledge_status_query)->status;

									$a = $a + 1;

								?>
									<tr>
										<?php if ($role == 3) { ?>
											<td><input type="checkbox" name="selector[]" value="<?php echo $rows['id']; ?>"></td>

											<td><input type="checkbox" name="applist[]" value="<?php echo $rows['account']; ?>"></td>
										<?php } ?>
										<td><?php echo $a; ?></td>

										<td><?php echo $rows['account']; ?></td>

										<td><?php echo $rows['name']; ?></td>

										<td><?php echo $rows['pledged_amount']; ?></td>

										<td><?php echo $rows['pledged_reason']; ?></td>

										<td><span class="badge bg-red"><?php echo $pledge_status; ?></span></td>
									<?php } ?>
									</tr>
							</tbody>

							<?php if ($role == 3) { ?>
								<fieldset>
									<button type="submit" name="authorize" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
									<button type="submit" name="reject" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i> Reject</button>
								</fieldset>
							<?php }

							?>

							<br><br>


						</table>



					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
<?php

if (isset($_POST['authorize'])) {
	if (isset($_POST['applist'])) {


		$account_no = $_POST['applist'];
		$id = $_POST['selector'];
		$N = count($account_no);
		$count_id = count($id);

		for ($i = 0; $i < $N; $i++) {
			$result2 = mysqli_query($conn, "UPDATE pludge SET pledged_status = 6 where id = '$id[$i]'") or die(mysqli_error($conn));
		}

		header('location:pledged?pledged=true');
	} else {
		echo "<script>alert('please select !')</script>";
	}
}

if (isset($_POST['reject'])) {
	if (isset($_POST['applist'])) {


		$account_no = $_POST['applist'];
		$id = $_POST['selector'];

		$N = count($id);

		for ($i = 0; $i < $N; $i++) {

			$result = mysqli_query($conn, "UPDATE pludge SET pledged_status = 11, checker = $userId WHERE id ='$id[$i]'") or die(mysqli_error($conn));
			header('location:pledged?reject=true');
		}
	} else {
		echo "<script>alert('please select !')</script>";
	}
}
?>