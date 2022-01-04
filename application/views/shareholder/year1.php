<div align="left">
	<?php
	$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
	$budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");
	$budget_result = mysqli_fetch_array($budget_query);
	$from = "";
	$to = "";
	if ($budget_result) {
		$from = $budget_result['budget_from'];
		$to = $budget_result['budget_to'];
	}
	?>
	From: <input type="text" class="tcal" value="<?php echo $from; ?>" name="from" readonly required>
	To: <input type="text" class="tcal" value="<?php echo $to; ?>" name="to" readonly required>

</div>