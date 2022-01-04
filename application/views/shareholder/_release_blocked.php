<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
	$username = $this->session->userdata['logged_in']['username'];
	$role = $this->session->userdata['logged_in']['role'];
	$userId = $this->session->userdata['logged_in']['id'];
}
?>

<?php
if (isset($_GET['block'])) {
?>
	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Success!</b> Shareholder Blocked Successfully!.
	</div>
<?php } ?>
<?php
if (isset($_GET['reject_block'])) {
?>
	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Request Rejected Successfully!</b>
	</div>
<?php } ?>
<?php

if (isset($_GET['blocked'])) {

?>

	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Success!</b> Shareholder Blocked Successfully!.
	</div>

<?php } ?>
<?php

if (isset($_GET['release_blocked'])) {

?>
	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Request Released Successfully</a>
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
									<th>Blocked Amount</th>
									<th>Blocked status</th>
									<th>Reason</th>
									<th>Status</th>
							</thead>
							<tbody>

								<?php
								$query = mysqli_query($conn, "SELECT * from blocked where blocked_status = 7 order by id ASC") or die(mysqli_error($conn));

								$a = 0;

								while ($rows = mysqli_fetch_array($query)) {
									$a = $a + 1;

								?>
									<tr>
										<td><input type="checkbox" name="applist[]" value="<?php echo $rows['id']; ?>"></td>
										<td><input type="checkbox" name="selector[]" value="<?php echo $rows['account']; ?>"></td>
										<td><?php echo $a; ?></td>
										<td><?php echo $rows['account']; ?></td>
										<td><?php echo $rows['blocked_amount']; ?></td>
										<td><?php echo $rows['blocked_type']; ?></td>
										<td><?php echo $rows['block_remark']; ?></td>
										<td><span class="badge bg-red"><?php echo "pending For Released"; ?></span></td>
									<?php } ?>

									</tr>
							</tbody>

							<?php if ($role == 3) { ?>
								<fieldset>
									<button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
									<button type="submit" name="reject" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Reject</button>
								</fieldset>
							<?php } ?>
							<?php if ($role == 2) { ?>
								<button type="submit" name="release" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-ok"></i> Release</button>
							<?php } ?>
							<br><br>
						</table>

						<?php
						if (isset($_POST['authorize'])) {
							if (isset($_POST['applist'])) {
								$id = $_POST['applist'];

								$account_no = $_POST['selector'];

								$N = count($id);

								for ($i = 0; $i < $N; $i++) {



									$result2 = mysqli_query($conn, "UPDATE blocked SET blocked_status = 10 , checker=$userId where id = '$id[$i]'") or die(mysqli_error($conn));



									header('location:release_blocked?release_blocked=true');
								}
							} else {
								echo "<script>alert('please select !')</script>";
							}
						}


						if (isset($_POST['reject'])) {
							if (isset($_POST['applist'])) {
								$id = $_POST['applist'];

								$account_no = $_POST['selector'];

								$N = count($id);

								for ($i = 0; $i < $N; $i++) {
									$result = mysqli_query($conn, "UPDATE blocked SET blocked_status = 5,checker=$userId where id='$id[$i]'");

									header('location:release_blocked?reject_block=true');
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



									$result2 = mysqli_query($conn, "UPDATE blocked SET blocked_status = 7 , maker=$userId where id = '$id[$i]'") or die(mysqli_error($conn));



									header('location:release_blocked?release_blocked=true');
								}
							} else {
								echo "<script>alert('please select !')</script>";
							}
						}



						?>

					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->