<?php

$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {

	$username = $this->session->userdata['logged_in']['username'];
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
<script>
	function showUser(str) {
		if (str == "") {
			document.getElementById("txtHint").innerHTML = "";
			return;
		} else {
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
				}
			};
			xmlhttp.open("GET", "<?php echo base_url(); ?>shareholder/getaccountuser?q=" + str, true);
			xmlhttp.send();
		}
	}
</script>

<?php
if (isset($_GET['share_alloted'])) {
?>
	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Allotement sent for authorization</b> .
	</div>
<?php } ?>

<?php
if (isset($_GET['update_allotment'])) {
?>
	<div class="alert alert-success alert-dismissable">
		<i class="fa fa-ban"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Please Update the allotment </b> .
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

						<select name="shareholder" class="form-control" required>
							<option value="">Select Shareholder Name</option>
							<?php


							$result = mysqli_query($conn, "SELECT * FROM shareholders WHERE shareholders.currentYear_status =1 order by shareholders.account_no");

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
						<label>Alloted share</label>
						<input type="text" onKeyUp="format(this);" name="alloted_share" class="form-control" placeholder="Enter ..." required />
						<input type="hidden" onKeyUp="format(this);" name="alloted_share_update" class="form-control" placeholder="Enter ..." required />

					</div>

					<div class="form-group">
						<label>Alloted start date</label><br>
						<input type="text" onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="alloted_date" class="tcal" placeholder="Enter ..." required />

					</div>

					<div class="form-group">
						<label>Due date</label><br>
						<input type="text" onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="due_date" class="tcal" placeholder="Enter ..." required />

					</div>

					<input type="hidden" readonly="" value="<?php echo $username; ?>" name="blocked_by" class="form-control" />
					<input type="hidden" readonly="" value="<?php //echo $_GET['id'];
																									?>" name="id" class="form-control" />

					<div class="box-footer">

						<button type="submit" class="btn btn-primary" name="submit">Allot</button>
					</div>

					<?php
					if (isset($_POST['submit'])) {

						//$name = $_POST['name'];										
						$alloted_share = $_POST['alloted_share'];
						$account_no = $_POST['shareholder'];
						$alloted_date = $_POST['alloted_date'];
						$due_date = $_POST['due_date'];
						$year = date('Y-m-d');

						$select_budget_year = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");
						$budget_row = mysqli_fetch_array($select_budget_year);
						$startd = $budget_row['budget_from'];
						$endd = $budget_row['budget_to'];
						$currentDate = $alloted_date;
						$current_due_date = $due_date;
						$currentDate = date('Y-m-d', strtotime($currentDate));
						$current_due_date = date('Y-m-d', strtotime($current_due_date));
						$today = date('Y-m-d');

						// $query_share = mysqli_query($conn,"SELECT * from shareholders where account_no = '$account_no'") or die(mysqli_error($conn));
						// $rows_share = mysqli_fetch_array($query_share);
						// $subscribed = $rows_share['total_share_subscribed'];

						if (($currentDate < $startd) || ($currentDate > $endd)) {

							echo '<script>alert("Allotment date is out of budget year!");</script>';
						} elseif ($current_due_date < $startd) {

							echo '<script>alert("Allotment due date is out of budget year!");</script>';
						} elseif (($current_due_date < $currentDate)) {

							echo '<script>alert("Due date must be greater than allotment start date!");</script>';
						}
						// elseif($alloted_share >=  $subscribed) {

						//     echo '<script>alert("Total alloted share amount must be less than total share subscribed!");</script>';
						// }
						else {

							mysqli_query($conn, "UPDATE allotment set allotment = '$alloted_share',allotment_update = '$alloted_share',allot_date = '$alloted_date',due_date = '$due_date',allot_status = 3 WHERE account = '$account_no'") or die(mysqli_error($conn));

							header('location:manage_allotement?share_alloted=paid');

					?>

					<?php
						}
					}

					?>

				</form>
			</div><!-- /.box-body -->

		</div>