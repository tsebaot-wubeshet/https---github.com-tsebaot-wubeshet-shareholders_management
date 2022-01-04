	<?php

  $conn = mysqli_connect('localhost', 'root', '', 'shareholder');
  if (isset($this->session->userdata['logged_in'])) {
    $username = $this->session->userdata['logged_in']['username'];
  }
  ?>

	<?php
  if (isset($_GET['sharerequest'])) {
  ?>
	  <div class="alert alert-success alert-dismissable">
	    <i class="fa fa-ban"></i>
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <b> Share Requested successfully!.
	  </div>
	<?php } ?>

	<?php
  if (isset($_GET['sharerequestupdate'])) {
  ?>
	  <div class="alert alert-success alert-dismissable">
	    <i class="fa fa-ban"></i>
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <b> Share request updated successfully!.
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


	        <form action="" method="POST" role="form">
	          <!-- text input -->
	          <!-- textarea -->

	          <div class="form-group">

	            Shareholder Name
	            <select name="account_no" class="form-control" required>
	              <option disabled value="">Select Name of Shareholder</option>
	              <?php

                $result = mysqli_query($conn, "SELECT account_no,name FROM shareholders where currentYear_status=1 order by account_no");
                while ($row2 = mysqli_fetch_array($result)) {
                  echo '<option value="' . $row2['account_no'] . '">';
                  echo $row2['account_no'] . " - " . $row2['name'];
                  echo '</option>';
                }
                ?>
	            </select>
	          </div>

	          <div id="txtHint"></div>
	          <div class="form-group">
	            <label>Application Date</label>
	            <input type="text" readonly name="application_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="Enter ..." />

	          </div>

	          <div class="form-group">
	            <label>Total Share Needed</label>
	            <input type="text" name="total_share" required autofocus="" class="form-control" plactaeholder="Enter ..." />
	            <?php echo form_error('total_share'); ?>
	          </div>


	          <div class="box-footer">
	            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
	          </div>
	        </form>
	      </div><!-- /.box-body -->
	    </div>

	    <?php

      if (isset($_POST['submit']) && isset($_POST['account_no'])) {
        $account_no = $_POST['account_no'];
        $application_date = $_POST['application_date'];
        $total_share = $_POST['total_share'];

        $budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");
        $budget_result = mysqli_fetch_array($budget_query);
        $from = "";
        $to = "";
        $year = 0;
        if ($budget_result) {
          $from = $budget_result['budget_from'];
          $to = $budget_result['budget_to'];
          $year = $budget_result['id'];
        }

        $result2 = mysqli_query($conn, "SELECT * FROM share_request WHERE account= '$account_no' and share_request_status !=4 AND year = '$year'");

        if (mysqli_num_rows($result2) > 0) {

          $row = mysqli_fetch_array($result2);

          $share_requested = $row['total_share'];

          $total_share = $_POST['total_share'] + $share_requested;

          $result = mysqli_query($conn, "UPDATE share_request SET total_share_request = $total_share,application_date = '$application_date' WHERE account = '$account_no'") or die(mysqli_error($conn));
          header('location:sharerequest?sharerequestupdate=true');
        } else {

          $result = mysqli_query($conn, "INSERT INTO share_request (account,total_share_request,share_request_status,application_date,year) VALUES ('$account_no',$share_requested,3,'$application_date',$year)") or die(mysqli_error($conn));
          header('location:sharerequest?sharerequest=true');
        }
      }
      ?>