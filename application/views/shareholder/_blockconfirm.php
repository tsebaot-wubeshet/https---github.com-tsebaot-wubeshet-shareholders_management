<?php
$conn=mysqli_connect('localhost','root','','shareholder');
if (isset($this->session->userdata['logged_in'])) {

$username = $this->session->userdata['logged_in']['username'];

} 

?>
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

<?php if($this->session->flashdata('flashError')): ?>

<p class='flashMsg flashError alert alert-danger alert-dismissable'> <?php echo $this->session->flashdata('flashError')?> </p>
<?php endif ?>

			<form action="" method="POST" role="form">
													
			<div class="form-group">
				
				<label>Reason</label>
				<textarea name="reason" required autofocus class="form-control"><?php echo set_value('reason'); ?></textarea>
															
				<?php 
				
				$id = $_GET['id'];				
				$budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 'active'");
				$budget_result = mysqli_fetch_array($budget_query);
				$from = $budget_result['budget_from'];
				$to = $budget_result['budget_to'];
				 
				$query = mysqli_query($conn,"SELECT * FROM shareholders WHERE account_no = '$id'") or die(mysqli_error($conn));
				$row = mysqli_fetch_array($query);
				
				?>				
			</div>
			
			<input type="hidden" readonly="" value="<?php echo $username;?>" name="blocked_by" class="form-control"/>
			<input type="hidden" readonly="" value="<?php echo $_GET['id'];?>" name="id" class="form-control"/>
			<input type="hidden" readonly="" value="<?php echo $row['account_no'];?>" name="account_no" class="form-control"/>
			<input type="hidden" readonly="" value="<?php echo $row['name'];?>" name="name" class="form-control"/>
			<input type="hidden" readonly="" value="<?php echo $row['total_paidup_capital_inbirr'];?>" name="total_paidup_capital_inbirr" class="form-control"/>

			<div class="box-footer">			
			<button type="submit" class="btn btn-primary" name="submit">Block Shareholder</button>
		</div>
		
		<?php 
			if(isset($_POST['submit'])){
				
				$id = $_POST['id'];

				$reason = $_POST['reason'];
				
				$account_no = $_POST['account_no'];

				$name = $_POST['name'];

				$total_paidup_capital_inbirr = $_POST['total_paidup_capital_inbirr'];

				$blocked_by = $_POST['blocked_by'];

				$blocked_year = date('Y-m-d');

				$query = mysqli_query($conn,"INSERT INTO blocked (account_no,name,total_paidup_capital_inbirr,blocked_year,block_remark,status) values('$account_no','$name','$total_paidup_capital_inbirr','$blocked_year','$reason','pending')") or die(mysqli_error($conn));
				
				header('location:block?block=true');
			}
		?>
		
			</form>
	</div><!-- /.box-body -->

</div>

