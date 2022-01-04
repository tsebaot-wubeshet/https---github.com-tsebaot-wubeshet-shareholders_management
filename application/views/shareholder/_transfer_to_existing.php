	<?php

	$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
	if (isset($this->session->userdata['logged_in'])) {

		$username = $this->session->userdata['logged_in']['username'];
		$userId = $this->session->userdata['logged_in']['id'];
	}

	?>
	<script>
		function format(input) {
			var num = input.value.replace(/\,/g, '');
			if (!isNaN(num)) {
				if (num.indexOf('.') > -1) {
					num = num.split('.');
					num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1').split('').reverse().join('').replace(/^[\,]/, '');
					if (num[1].length > 2) {
						alert('You may only enter two decimals!');
						num[1] = num[1].substring(0, num[1].length - 1);
					}
					input.value = num[0] + '.' + num[1];
				} else {
					input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1').split('').reverse().join('').replace(/^[\,]/, '')
				};
			} else {
				alert('You may enter only Decimal numbers in this field!');
				input.value = input.value.substring(0, input.value.length - 2);
			}
		}
	</script>


	<?php
	if (isset($_GET['cash'])) {
	?>
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<b>Cash payment sent for authorization</b> .
		</div>
	<?php } ?>
	<!-- general form elements disabled -->
	<div class="box box-warning">
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="box-body">
					<!-- display message -->
					<?php
					if (isset($message_display)) { ?>
						<div class="alert alert-danger alert-dismissable" role="alert">
							<?php
							echo "<div class='message'>";
							echo $message_display;
							echo "</div>";
							?>
						</div>
					<?php } ?>

					<?php
					if (isset($message_success)) { ?>
						<div class="alert alert-success alert-dismissable" role="alert">
							<?php
							echo "<div class='message'>";
							echo $message_success;
							echo "</div>";
							?>
						</div>
					<?php } ?>

					<?php if ($this->session->flashdata('flashError')) : ?>

						<p class='flashMsg flashError alert alert-danger alert-dismissable'> <?php echo $this->session->flashdata('flashError') ?> </p>
					<?php endif ?>

					<form action="" method="POST" role="form" name='myForm'>

						<div class="form-group">

							<label> Shareholder Name</label>

							<select name="shareholder" class="form-control" required onchange="showUser(this.value)">
								<option value="">Select Shareholder Name</option>
								<?php

								$budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 'active'");
								$budget_result = mysqli_fetch_array($budget_query);
								$from = "";
								$to = "";
								if ($budget_result) {
									$from = $budget_result['budget_from'];
									$to = $budget_result['budget_to'];
									$year = $budget_result['id'];
								}
								$result = mysqli_query($conn, "SELECT * FROM shareholders WHERE currentYear_status = 1  order by account_no");
								while ($row = mysqli_fetch_array($result)) {
									echo '<option value="' . $row['account_no'] . '">';
									echo $row['account_no'] . "-" . $row['name'];
									echo '</option>';
								}
								?>

							</select>

						</div>
						<div id="txtHint"></div>
						<div class="form-group">
							<label>Cash Amount in Birr</label>
							<input type="text" onKeyUp="format(this);" name="capitalized_in_birr" class="form-control" placeholder="Enter ..." required />

						</div>

						<div class="form-group">
							<label>Value Date</label><br>
							<input type="text" readonly onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="value_date" class="tcal" placeholder="Enter ..." required />

						</div>

						<input type="hidden" readonly="" value="<?php echo $username; ?>" name="blocked_by" class="form-control" />
						<input type="hidden" readonly="" value="<?php //echo $_GET['id'];
																										?>" name="id" class="form-control" />

						<div class="box-footer">

							<button type="submit" class="btn btn-primary" name="submit">Pay</button>
						</div>

						<?php
						if (isset($_POST['submit'])) {
							$capitalized_in_birr = $_POST['capitalized_in_birr'];
							$account_no = $_POST['account_no'];
							$value_date = $_POST['value_date'];
							mysqli_query($conn, "INSERT into capitalized (account,capitalized_in_birr,capitalized_date,value_date,type,year,capitalized_status,maker,transfer_from) values ('$account_no','$capitalized_in_birr','$capitalized_date','$value_date',1,$year,3,$userId,'NIB')") or die(mysqli_error($conn));
							header('location:cash_payment?cash=paid')

						?>


						<?php
						}

						?>

					</form>
				</div><!-- /.box-body -->

			</div>