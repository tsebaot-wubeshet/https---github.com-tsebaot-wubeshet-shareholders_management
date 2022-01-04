	<?php
  $conn = mysqli_connect('localhost', 'root', '', 'shareholder');
  if (isset($this->session->userdata['logged_in'])) {

    $username = $this->session->userdata['logged_in']['username'];
  }

  ?>
	<script language="javascript" type="text/javascript">
	  function ajaxFunction() {
	    var ajaxRequest; // The variable that makes Ajax possible!

	    try {
	      // Opera 8.0+, Firefox, Safari
	      ajaxRequest = new XMLHttpRequest();
	    } catch (e) {
	      // Internet Explorer Browsers
	      try {
	        ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	      } catch (e) {
	        try {
	          ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
	        } catch (e) {
	          // Something went wrong
	          alert("Your browser broke!");
	          return false;
	        }
	      }
	    }

	    ajaxRequest.onreadystatechange = function() {
	      if (ajaxRequest.readyState == 4) {
	        var ajaxDisplay = document.getElementById('ajaxDiv');
	        ajaxDisplay.value = ajaxRequest.responseText;
	      }
	    }

	    var num1 = document.getElementById('num1').value;
	    var queryString = "?num1=" + num1;
	    ajaxRequest.open("GET", "<?php echo base_url(); ?>" + "index.php/shareholder/convertnum" + queryString, true);
	    ajaxRequest.send(null);
	  }
	  //-->
	</script>

	<?php
  if (isset($_GET['cash'])) {
  ?>
	  <div class="alert alert-success alert-dismissable">
	    <i class="fa fa-ban"></i>
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <b>Success!</b> Cash Payment Done!.
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

	            <select name="name" class="form-control" required>
	              <option value="">Select Shareholder Name</option>
	              <?php

                $result = mysqli_query($conn, "SELECT * FROM shareholders group by name");
                while ($row = mysqli_fetch_array($result)) {
                  echo '<option value="' . $row['name'] . '">';
                  echo $row['name'];
                  echo '</option>';
                }
                ?>

	            </select>

	          </div>

	          <div class="form-group">
	            <label>Cash Amount in Share</label>
	            <input type="text" name="capitalized_share" id='num1' onkeyup='ajaxFunction();' class="form-control" placeholder="Enter ..." required />

	          </div>


	          <div class="form-group">
	            <label>Cash Amount in Birr</label>
	            <input type="text" name="capitalized_in_birr" class="form-control" placeholder="Enter ..." required />

	          </div>

	          <div class="form-group">
	            <label>Value Date</label><br>
	            <input type="text" name="value_date" class="tcal" placeholder="Enter ..." required />

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

              $value_date = $_POST['value_date'];

              mysqli_query($conn, "INSERT into capitalized (account,capitalized_in_birr,value_date,type) values ('$name','$capitalized_share','$capitalized_in_birr','$value_date','cash')") or die(mysqli_error($conn));

              //mysqli_query($conn,"UPDATE shareholders set total_share_subscribed = total_share_subscribed + '$capitalized_share',total_share_subscribed_inbirr = total_share_subscribed_inbirr + '$capitalized_in_birr' where name = '$name'") or die(mysqli_error($conn));

              header('location:/shareholder_new/shareholder/cash_payment?cash=paid')

            ?>


	          <?php
            }

            ?>

	        </form>
	      </div><!-- /.box-body -->

	    </div>