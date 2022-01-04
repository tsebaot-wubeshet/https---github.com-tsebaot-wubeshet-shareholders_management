	<?php

	$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
	if (isset($this->session->userdata['logged_in'])) {

		$userId = $this->session->userdata['logged_in']['id'];

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
						<div class="alert alert-info" role="alert">
							<?php
							echo "<div class='message'>";
							echo $message_display;
							echo "</div>";
							?>
						</div>
					<?php } ?>


					<form action="<?php echo base_url(''); ?>user_authentication/new_user_registration" method="POST" role="form">
						<!-- text input -->


						<div class="form-group">
							<label>FullName</label>
							<input type="text" name="fname" autofocus="" required value="<?php echo set_value('fname'); ?>" class="form-control" placeholder="Enter ..." />
							<?php echo form_error('fname'); ?>
						</div>

						<div class="form-group">
							<label>Username</label>
							<input type="text" name="username" required class="form-control" value="<?php echo set_value('username'); ?>" placeholder="Enter ..." />
							<?php echo form_error('username'); ?>
						</div>

						<div class="form-group">
							<label>Password</label>
							<input type="text" name="password" required class="form-control" placeholder="Enter ..." />

						</div>

						<div class="form-group">

							<label>Role</label>

							<select name="role" class="form-control" required>
								<option value="">Select User Role</option>
								<?php

								$role_query = mysqli_query($conn, "SELECT * from role order by id ASC") or die(mysqli_error($conn));
								while ($role = mysqli_fetch_array($role_query)) {
								?>
									<option value="<?php echo $role['id']; ?>"><?php echo $role['role']; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error('role'); ?>
						</div>



						<button type="submit" class="btn btn-primary" name="submit">Register user</button>
				</div>
			</div>


		</div>

		</form>
	</div><!-- /.box-body -->

	</div>