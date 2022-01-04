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
		<b>Success!</b> Shareholder pledged Successfully!.
	</div>

<?php } ?>
<?php if (isset($_GET['pledged_rejected'])) { ?>

	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Pledge Request Rejected Successfully!.</b>
	</div>

<?php } ?>
<?php if (isset($_GET['pledged_release'])) { ?>

	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Pledge Request Released Successfully!.</b>
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
									<th></th>
									<th></th>
									<th>No.</th>
									<th>Account number</th>
									<th>Shareholder Name</th>
									<th>Total paid up capital in share after pledged</th>
									<th>Pledged Amount</th>
									<th>Reason</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>

								<?php

								$query = mysqli_query($conn, "SELECT p.*, s.name, b.total_paidup_capital_inbirr from pludge p LEFT JOIN shareholders s ON s.account_no = p.account LEFT JOIN balance b ON b.account = p.account where pledged_status = 7") or die(mysqli_error($conn));

								$a = 0;

								while ($rows = mysqli_fetch_array($query)) {
									$a = $a + 1;

								?>
									<tr>

										<td><input type="checkbox" name="applist[]" value="<?php echo $rows['id']; ?>"></td>
										<td><input type="checkbox" name="selector[]" value="<?php echo $rows['account']; ?>">

										<td><?php echo $a; ?></td>

										<td><?php echo $rows['account']; ?></td>
										<td><?php echo $rows['name']; ?></td>
										<td><?php echo $rows['total_paidup_capital_inbirr'] - $rows['pledged_amount']; ?></td>
										<td><?php echo $rows['pledged_amount']; ?></td>
										<td><?php echo $rows['pledged_reason']; ?></td>
										<td>

											<span class="badge bg-red"><?php echo "pending for release"; ?></span>

										</td>


										<input type="hidden" name="pledged_amount" value="<?php echo $rows['pledged_amount']; ?>">
										<input type="hidden" name="account_no" value="<?php echo $rows['account']; ?>">


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
if (isset($_POST['reject'])) {

	if (isset($_POST['applist'])) {
		$id = $_POST['applist'];

		$account_no = $_POST['selector'];

		$N = count($id);

		for ($i = 0; $i < $N; $i++) {

			$result = mysqli_query($conn, "UPDATE pludge SET pledged_status = 6,checker = $userId WHERE account_no ='$account_no[$i]'") or die(mysqli_error($conn));
			header('location:pledged_release?reject=true');
		}
	} else {
		echo "<script>alert('please select !')</script>";
	}
}

if (isset($_POST['authorize'])) {
	if (isset($_POST['applist'])) {
		$id = $_POST['applist'];

		$account_no = $_POST['selector'];

		$N = count($id);

		for ($i = 0; $i < $N; $i++) {



			$result2 = mysqli_query($conn, "UPDATE pludge SET pledged_status = 10,checker= $userId where id='$id[$i]'") or die(mysqli_error($conn));


			header('location:pledged_release?pledged_release=true');
		}
	} else {
		echo "<script>alert('please select !')</script>";
	}
}
if (isset($_POST['release'])) {
	if (isset($_POST['applist'])) {
		$id = $_POST['applist'];

		$account_no = $_POST['selector'];

		$N = count($id);

		for ($i = 0; $i < $N; $i++) {



			$result2 = mysqli_query($conn, "UPDATE pludge SET pledged_status = 7 , maker=$userId where id = '$id[$i]'") or die(mysqli_error($conn));



			header('location:release_blocked?release_blocked=true');
		}
	} else {
		echo "<script>alert('please select !')</script>";
	}
}

?>