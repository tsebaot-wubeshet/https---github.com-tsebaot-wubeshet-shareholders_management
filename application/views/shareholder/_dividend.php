	<?php
  $conn = mysqli_connect('localhost', 'root', '', 'shareholder');
  if (isset($this->session->userdata['logged_in'])) {

    $username = $this->session->userdata['logged_in']['username'];
  }

  ?>
	<script language="javascript" type="text/javascript">
	  //Browser Support Code
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
	        var ajaxDisplay1 = document.getElementById('totalpaidup');
	        ajaxDisplay1.value = ajaxRequest.responseText;
	      }
	    }

	    var num1 = document.getElementById('cash_payment').value;
	    var num2 = document.getElementById('dividend_payablecap').value;
	    var num3 = document.getElementById('dividend_cap').value;
	    var num5 = document.getElementById('Adjusted').value;
	    var num6 = document.getElementById('ajaxDiv').value;
	    var queryString = "?cash_payment=" + num1;
	    queryString += "&dividend_payablecap=" + num2;
	    queryString += "&dividend_cap=" + num3;

	    ajaxRequest.open("GET", "<?php echo base_url(); ?>shareholder/calculate" + queryString, true);
	    ajaxRequest.send(null);

	  }
	  //-->
	</script>
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

	          <?php
            if (isset($_GET['id'])) {

              $id = $_GET['id'];
            }
            $result = mysqli_query($conn, "SELECT * FROM shareholders where id ='$id'");
            while ($row = mysqli_fetch_array($result)) {
            ?>
	            <div class="form-group">

	              <label> Shareholder Name</label>
	              <input type="text" name="name" readonly="" autofocus class="form-control" value="<?php echo $row['name']; ?>">
	              <input type="hidden" name="total_share_of_seller" class="form-control" value="<?php echo $row['total_share_subscribed']; ?>">
	              <input type="hidden" name="sc_seller" class="form-control" value="<?php echo $row['sc_no']; ?>">

	              <?php echo form_error('from'); ?>

	            </div>
	            <div class="form-group">
	              <label>Serial No</label>
	              <input type="text" readonly name="sc_no" value="<?php echo $row['sc_no']; ?>" class="form-control" placeholder="Enter ..." />
	              <?php echo form_error('sc_no'); ?>
	            </div>


	            <div class="form-group">
	              <label>Account No</label>
	              <input type="text" name="account_no" readonly="" value="<?php echo $row['account_no']; ?>" class="form-control" placeholder="Enter ..." />
	              <?php echo form_error('account_no'); ?>
	            </div>


	            <div class="form-group">
	              <label>Total Paidup Capital</label>
	              <input type="text" name="total_paidup_capital" readonly="" value="<?php echo $row['total_share_subscribed_inbirr']; ?>" class="form-control" placeholder="Enter ..." />
	              <?php echo form_error('total_paidup_cap'); ?>
	            </div>

	            <?php

              $name = $_GET['name'];

              $query4 = mysqli_query($conn, "SELECT * from shareholders where name = '$name'") or die(mysqli_error($conn));

              while ($transfer3 = mysqli_fetch_array($query4)) {

              ?>

	              <?php

                $name = $_GET['name'];

                $query2 = mysqli_query($conn, "SELECT *,sum(total_transfered_in_birr) from transfer where name = '$name'") or die(mysqli_error($conn));

                while ($transfer1 = mysqli_fetch_array($query2)) {

                ?>

	                <?php

                  $name = $_GET['name'];

                  $query3 = mysqli_query($conn, "SELECT *,sum(total_transfered_in_birr) from transfer where rname = '$name'") or die(mysqli_error($conn));

                  while ($transfer2 = mysqli_fetch_array($query3)) {

                  ?>


	                  <div class="form-group">
	                    <label>Adjusted Balance</label>
	                    <input type="text" name="adjusted_balance" readonly="" id="Adjusted" value="<?php echo $transfer3['total_share_subscribed_inbirr'];
                                                                                                }
                                                                                              }
                                                                                            } ?>" class="form-control" placeholder="Enter ..." />
	                    <?php echo form_error('adjusted_balance'); ?>
	                  </div>

	                  <div class="form-group">
	                    <label>Dividend payable capitilized</label>
	                    <input type="text" name="dividend_payable_capitalized" readonly="" id="dividend_payablecap" value="<?php echo set_value('dividend__payablecap'); ?>" onkeyup='ajaxFunction();' class="form-control" placeholder="Enter ..." />
	                    <?php echo form_error('dividend__payablecap'); ?>
	                  </div>
	                  <div class="form-group">
	                    <label> Dividend payable capitilized Value Date:</label>

	                    <div class="input-group">


	                      <input type="text" class="form-control" value="<?php echo set_value('dpcvalue_date'); ?>" name="dividend_payable_capitalized_date">

	                    </div>

	                  </div><!-- /.input group -->
	                  <?php echo form_error('dpcvalue_date'); ?>
	      </div>

	      <?php

              $name = $_GET['name'];

              $query4 = mysqli_query($conn, "SELECT *,sum(capitalized_in_birr) from capitalized where name = '$name' and type = 'cash'") or die(mysqli_error($conn));

              while ($cash = mysqli_fetch_array($query4)) {

        ?>

	        <div class="form-group">
	          <label>Cash Payment</label>
	          <input type="text" name="cash_payment" readonly="" id="cash_payment" value="<?php echo $cash['sum(capitalized_in_birr)']; ?>" onkeyup='ajaxFunction();' class="form-control" placeholder="Enter ..." />
	          <?php echo form_error('cash_payment'); ?>
	        </div>


	        <div class="form-group">
	          <label> Cash Payment Value Date:</label>

	          <div class="input-group">


	            <input type="text" class="form-control pull-right" readonly="" value="<?php echo $cash['value_date'];
                                                                                  } ?>" name="cash_payment_value_date">

	          </div>


	          <?php echo form_error('cpvalue_date'); ?>
	        </div>

	        <?php

              $name = $_GET['name'];

              $query5 = mysqli_query($conn, "SELECT *,sum(capitalized_in_birr) from capitalized where name = '$name' and type = 'capitalized'") or die(mysqli_error($conn));

              while ($capitalized = mysqli_fetch_array($query5)) {

          ?>
	          <div class="form-group">
	            <label>Dividend Capitilized</label>
	            <input type="text" name="dividend_capitalized" readonly="" id="dividend_cap" value="<?php echo $capitalized['sum(capitalized_in_birr)']; ?>" onkeyup='ajaxFunction();' class="form-control" placeholder="Enter ..." />
	            <?php echo form_error('dividend_cap'); ?>
	          </div>

	          <div class="form-group">
	            <label>Dividend Capitilized Value Date</label>

	            <div class="input-group">


	              <input type="text" class="form-control pull-right" readonly="" value="<?php echo $capitalized['value_date'];
                                                                                    } ?>" name="dividend_capitalized_valuedate">


	              <?php echo form_error('dcvalue_date'); ?>
	            </div>

	          </div>

	          <?php

              $name = $_GET['name'];

              $query6 = mysqli_query($conn, "SELECT *,sum(capitalized_in_birr) from capitalized where name = '$name'") or die(mysqli_error($conn));

              while ($raised = mysqli_fetch_array($query6)) {

            ?>

	            <div class="form-group">
	              <label>Total Raised</label>
	              <input type="text" readonly name="total_raised" value="<?php echo $raised['sum(capitalized_in_birr)'];
                                                                      } ?>" id="ajaxDiv" class="form-control" placeholder="Enter ..." />
	              <?php echo form_error('total_raised'); ?>
	            </div>

	            <?php

              $name = $_GET['name'];

              $query2 = mysqli_query($conn, "SELECT *,sum(total_transfered_in_birr) from transfer where name = '$name'") or die(mysqli_error($conn));

              while ($transfer1 = mysqli_fetch_array($query2)) {

              ?>

	              <?php

                $name = $_GET['name'];

                $query3 = mysqli_query($conn, "SELECT *,sum(total_transfered_in_birr) from transfer where rname = '$name'") or die(mysqli_error($conn));

                while ($transfer2 = mysqli_fetch_array($query3)) {

                ?>

	                <?php

                  $name = $_GET['name'];

                  $query6 = mysqli_query($conn, "SELECT *,sum(capitalized_in_birr) from capitalized where name = '$name'") or die(mysqli_error($conn));

                  while ($raised = mysqli_fetch_array($query6)) {

                  ?>

	                  <div class="form-group">
	                    <label>Total Paidup Capital</label>
	                    <input type="text" readonly name="total_paidup" id="totalpaidup" value="<?php echo $transfer1['sum(total_transfered_in_birr)'] - $transfer2['sum(total_transfered_in_birr)'] + $raised['sum(capitalized_in_birr)'];
                                                                                            }
                                                                                          }
                                                                                        } ?>" class="form-control" placeholder="Enter ..." />
	                    <?php echo form_error('total_raised'); ?>
	                  </div>


	                  <input type="hidden" readonly="" value="<?php echo $username; ?>" name="blocked_by" class="form-control" />
	                  <input type="hidden" readonly="" value="<?php echo $_GET['id']; ?>" name="id" class="form-control" />

	                <?php } ?>

	                <div class="box-footer">

	                  <button type="submit" class="btn btn-primary" name="submit">Calculate Dividend</button>
	                </div>

	                <?php
                  if (isset($_POST['submit'])) {

                    $id = $_POST['id'];

                    $name = $_POST['name'];

                    $sc_no = $_POST['sc_no'];

                    $account_no = $_POST['account_no'];

                    $total_paidup_capital = $_POST['total_paidup_capital'];

                    $adjusted_balance = $_POST['adjusted_balance'];

                    $dividend_payable_capitalized = $_POST['dividend_payable_capitalized'];

                    $dividend_payable_capitalized_date = $_POST['dividend_payable_capitalized_date'];

                    $cash_payment = $_POST['cash_payment'];

                    $cash_payment_value_date = $_POST['cash_payment_value_date'];

                    $dividend_capitalized = $_POST['dividend_capitalized'];

                    $dividend_capitalized_valuedate = $_POST['dividend_capitalized_valuedate'];

                    $total_raised = $_POST['total_raised'];

                    $total_paidup = $_POST['total_paidup'];


                    $query = mysqli_query(
                      $conn,
                      "INSERT INTO dividend (name,sc_no,account_no,total_paidup_capital,adjusted_balance,dividend_payable_capitalized,dividend_payable_capitalized_date,cash_payment,cash_payment_valuedate,dividend_capitalized,dividend_capitalized_valuedate,total_raised,total_paidup) 
											VALUES ('$name','$sc_no', '$account_no', '$total_paidup_capital','$adjusted_balance','$dividend_payable_capitalized','$dividend_payable_capitalized_date','$cash_payment','$cash_payment_value_date','$dividend_capitalized','$dividend_capitalized_valuedate','$total_raised','$total_paidup')"
                    ) or die(mysqli_error($conn));

                    header('location:/shareholder_new/shareholder/listed?dividend=calculated');

                  ?>


	                <?php  }
                  ?>

	                </form>
	    </div><!-- /.box-body -->

	  </div>