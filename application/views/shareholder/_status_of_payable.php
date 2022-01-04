<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
	$username = $this->session->userdata['logged_in']['username'];
	$role = $this->session->userdata['logged_in']['role'];
}
?>
<?php if (isset($_GET['authorize'])) { ?>

	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Success!</b> Cash payment Authorized Successfully!.
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

<!-- Main content -->
<section class="content">
	<div class="row">
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
									<th>Value Date</th>
									<th>Cash paid</th>
									<th>Shareholder Name</th>


									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$query = mysqli_query($conn, "SELECT * from capitalized where 
        status_of_cashpayment = 'pending'") or die(mysqli_error($conn));

								$a = 0;

								while ($rows = mysqli_fetch_array($query)) {
									$a = $a + 1;

								?>
									<tr>
										<td></td>
										<td><input type="checkbox" name="applist[]" value="<?php echo $rows['id']; ?>"></td>

										<td><?php echo $a; ?></td>
										<td><?php echo $rows['value_date']; ?></td>
										<td><?php echo $rows['capitalized_in_birr']; ?></td>
										<td><?php echo $rows['name']; ?></td>



										<td><?php
												if ($rows['status_of_cashpayment'] == 'active') {

												?>

												<span class="badge bg-blue"><?php echo $rows['status_of_cashpayment']; ?></span>

											<?php

												} else {

											?>

												<span class="badge bg-red"><?php echo $rows['status_of_cashpayment']; ?></span>

											<?php

												}

											?>
										</td>


									<?php } ?>

									</tr>

							</tbody>

							<?php if ($role == 3) { ?>

								<button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>

							<?php } ?> <br><br>
						</table>

						<?php

						if (isset($_POST['authorize'])) {

							$id = $_POST['applist'];

							$N = count($id);

							for ($i = 0; $i < $N; $i++) {
								$result = mysqli_query($conn, "UPDATE capitalized SET status_of_cashpayment = '' where id='$id[$i]'");

								header('location:authorize_cashpayment?authorize=true');
							}
						}
						?>

					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->