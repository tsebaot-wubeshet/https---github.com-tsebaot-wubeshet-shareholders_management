<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
  $username = $this->session->userdata['logged_in']['username'];
}
?>
<script type="text/javascript">
  $(document).ready(function() {
    $("#myModal").modal('show');
  });
</script>

<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-dismissable" role="alert" align="center">
          The transferred paid up share amount must be less or equal to the seller paid up capital
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


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
      xmlhttp.open("GET", "<?php echo base_url(); ?>shareholder/getusers?q=" + str, true);
      xmlhttp.send();
    }
  }
</script>

<script type="text/javascript">
  function validateForm() {

    var a = parseInt(document.forms["myForm"]["t_seller_paidup"].value);

    var b = parseInt(document.forms["myForm"]["howmany"].value);

    if (b > a) {

      bootbox.alert(" Transfer not allowed. The transfered amount must be less than or equal to the seller paid up or please check the pledged amount");

      return false;
    }
  }
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

        <?php if (isset($_GET['transfer'])) { ?>

          <div class="alert alert-danger alert-dismissable" role="alert">
            Share transferred sent successfully for authorization
          </div>

        <?php } ?>


        <form action="" method="POST" role="form" name="myForm" id="myForm" onSubmit="return validateForm()">

          <?php
          //$this->load->view('shareholder/year');

          if (isset($_GET['id'])) {

            $id = $_GET['id'];
            $budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 'active'");
            $budget_result = mysqli_fetch_array($budget_query);
            $from = "";
            $to = "";
            $year = 0;
            if ($budget_result) {
              $from = $budget_result['budget_from'];
              $to = $budget_result['budget_to'];
              $year = $budget_result['id'];
            }

            $result = mysqli_query($conn, "SELECT * FROM shareholders WHERE account_no ='$id'");

            while ($row = mysqli_fetch_array($result)) {
              $acct = $_GET['id'];
              $year = date('Y');
              $query2 = mysqli_query($conn, "SELECT * from allotment where account_no = '$acct' order by id ASC") or die(mysqli_error($conn));
              $rows2 = mysqli_fetch_array($query2);
              $query4 = mysqli_query($conn, "SELECT *,sum(pledged_amount) from pludge where account_no = '$acct' and pledged_status = 'pledged' AND year = '$year' order by id ASC") or die(mysqli_error($conn));
              $rows4 = mysqli_fetch_array($query4);

          ?>
              <div class="form-group">

                <label>Transfer From </label>
                <input type="text" required readonly name="name" autofocus class="form-control" value="<?php echo $row['name']; ?>">
                <input type="hidden" name="total_share_of_seller" class="form-control" value="<?php echo $row['total_share_subscribed']; ?>">
                <input type="hidden" name="allot_amt" class="form-control" value="<?php echo $rows2['allotment']; ?>">

                <input type="hidden" name="seller_paidup" class="form-control" value="<?php echo $row['total_paidup_capital_inbirr']; ?>">
                <?php echo form_error('from'); ?>

              </div>

              <div class="form-group">
                <label>Total Subscribed Share</label>
                <input type="hidden" readonly required name="pledged_amount" value="<?php echo $rows4['sum(pledged_amount)']; ?>" class="form-control" placeholder="Enter ..." />
                <input type="hidden" readonly required name="t_seller_paidup" value="<?php $t_paid_up = ($row['total_paidup_capital_inbirr'] / 500);
                                                                                      $t_calc = ($t_paid_up - $rows4['sum(pledged_amount)']);
                                                                                      echo $t_calc; ?>" class="form-control" placeholder="Enter ..." />

                <input type="text" readonly required name="total_share_subscribed" value="<?php echo $row['total_share_subscribed'] + $rows2['allotment_update']; ?>" class="form-control" placeholder="Enter ..." />
                <?php echo form_error('total_share_subscribed'); ?>
              </div>

              <div class="form-group">
                <label>Account No</label>
                <input type="text" readonly required name="account_no" value="<?php echo $row['account_no']; ?>" class="form-control" placeholder="Enter ..." />
                <?php echo form_error('account_no'); ?>
              </div>

              <div class="form-group">

                <label>Transfer to</label>
                <select name="account_noof_buyyer" required class="form-control" onchange="showUser(this.value)">
                  <option value="">Select Name of Shareholder</option>
                  <?php

                  $name = $row['name'];
                  $result = mysqli_query($conn, "SELECT * FROM shareholders where status != 2 group by name order by account_no");
                  while ($row2 = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row2['account_no'] . '">';
                    echo $row2['account_no'] . " - " . $row2['name'];
                    echo '</option>';
                  }
                  ?>
                </select>
              </div>
          <?php }
          } ?>
          <div id="txtHint"></div>
          <div class="form-group">
            <label>Per Value</label>
            <input type="text" required readonly name="per_value" value="500" class="form-control" placeholder="Enter ..." />
            <?php echo form_error('per_value'); ?>
          </div>

          <!-- onkeyup = "javascript:this.value=Comma(this.value);" -->
          <div class="form-group">
            <label>How many paidup shares to be transfered</label>
            <input type="text" required onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="howmany" value="<?php echo set_value('howmany'); ?>" class="form-control" placeholder="Enter ..." />
            <?php echo form_error('howmany'); ?>
          </div>

          <div class="form-group">
            <label> Date:</label>
            <input type="text" required readonly onKeyPress="return event.charCode > 47 && event.charCode < 58;" class="tcal" value="<?php echo set_value('transfer_date'); ?>" name="transfer_date">
          </div>
          <?php echo form_error('transfer_date'); ?>

          <label>Dividend Agreement</label>
          <div class="form-group">
            <div class="radio">
              <label>
                <input type="radio" name="agreement" value="seller" required>
                For Seller
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="agreement" value="buyer">
                For Buyer
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="agreement" value="both">
                For Both
              </label>
            </div>
          </div>

          <label>Kind of transfer</label>
          <div class="form-group">
            <div>
              <label>
                <input type="radio" name="tt" value="sale" required>
                Sale
              </label>
            </div>
            <div>
              <label>
                <input type="radio" name="tt" value="heir">
                Heir
              </label>
            </div>
            <div>
              <label>
                <input type="radio" name="tt" value="court">
                Court
              </label>
            </div>
            <div>
              <label>
                <input type="radio" name="tt" value="other">
                Other
              </label>
            </div>
          </div>

          <input type="hidden" name="ag_year" value="<?php $month = 8;
                                                      $year = date('Y');

                                                      echo date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year)); ?>">
      </div>
      <input type="hidden" readonly="" value="<?php echo $username; ?>" name="blocked_by" class="form-control" />
      <input type="hidden" readonly="" value="<?php echo $_GET['id']; ?>" name="id" class="form-control" />

      <div class="box-footer">
        <button type="submit" class="btn btn-primary" name="submit">Transfer Share</button>
      </div>

      <?php
      if (isset($_POST['submit'])) {


        $select_budget_year = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 'active'");
        $budget_row = mysqli_fetch_array($select_budget_year);
        $startd = $budget_row['budget_from'];
        $endd = $budget_row['budget_to'];
        $value_date = $_POST['transfer_date'];
        $currentDate = $value_date;
        $currentDate = date('Y-m-d', strtotime($currentDate));

        if (($currentDate < $startd) || ($currentDate > $endd)) {

          echo '<script>alert("Value date is out of budget year!");</script>';
        } else {



          $id = $_POST['id'];
          $seller_share = $_POST['total_share_of_seller'];
          $buyyer_account_no = $_POST['account_noof_buyyer'];
          $per_value = $_POST['per_value'];
          $allotment_amount = $_POST['allot_amt'];
          $howmany  = $_POST['howmany'];
          $blocked_by = $_POST['blocked_by'];
          $account_no = $_POST['account_no'];
          $name = $_POST['name'];
          $rtotal_share = $_POST['tsubscribed_share'];
          $howmany_inbirr = $howmany * 500;
          $raccount_no = $_POST['taccount_no'];
          $rname = $_POST['rname'];
          $total_share_transfered = $howmany;
          $buyyer_paidup_in_birr = $_POST['buyyer_paidup'];
          $pervalue = $_POST['per_value'];
          $seller_paidup = $_POST['seller_paidup'];
          $buyyer_paidup = $_POST['buyyer_paidup'];
          $total_transfered_in_birr = $seller_paidup;

          if ($_POST['agreement'] == 'seller') {

            $transfer_date = $_POST['ag_year'];
            $agred_to = $account_no;
          } elseif ($_POST['agreement'] == 'buyer') {

            $transfer_date = $_POST['ag_year'];
            $agred_to = $raccount_no;
          } else {

            $transfer_date = $_POST['ag_year'];
            $agred_to = '';
            $both_seller = $account_no;
            $both_buyer = $raccount_no;
          }

          $agreement = $_POST['agreement'];
          $tt = $_POST['tt'];
          $value_date = $_POST['transfer_date'];

          $year = date('Y-m-d');
          echo "r account number " . $raccount_no . '<br/>';
          echo "account number " . $account_no . '<br/>';
          echo "total share of seller " . $seller_share . '<br/>';
          $tot_subscribe = $seller_share + $allotment_amount;
          echo "total share subscribe " . $tot_subscribe . '<br/>';
          echo "total share transfered " . $total_share_transfered . '<br/>';
          echo "howmany" . $howmany . '<br/>';
          echo "allotement" . $allotment_amount . '<br/>';

          if ($tot_subscribe == $howmany) {

            $capitalize_query = mysqli_query($conn, "SELECT * FROM capitalized WHERE account_no = '$account_no'") or die(mysqli_error($conn));
            while ($capitalize_row = mysqli_fetch_array($capitalize_query)) {

              $cap_value_date = $capitalize_row['value_date'];
              $cap_in_birr = $capitalize_row['capitalized_in_birr'];
              $cap_in_share = $capitalize_row['capitalized_in_share'];
              $cap_name = $rname;
              $cap_type = $capitalize_row['type'];
              $cap_year = $capitalize_row['year'];
              $cap_status = $capitalize_row['capitalized_status'];
              $cap_transfer_from = $account_no;

              echo "cap value date" . $cap_value_date . '<br/>';
              echo "cap in birr" . $cap_in_birr . '<br/>';
              echo "cap in share" . $cap_in_share . '<br/>';
              echo "cap name" . $cap_name . '<br/>';
              echo "cap type" . $cap_type . '<br/>';
              echo "cap year" . $cap_year . '<br/>';
              echo "cap status" . $cap_status . '<br/>';
              echo "account no" . $account_no . '<br/>';

              $update_capitalize = mysqli_query($conn, "INSERT into capitalized (name,capitalized_in_share,capitalized_in_birr,value_date,type,account_no,year,capitalized_status,transfer_from) values ('$cap_name','$cap_in_share','$cap_in_birr','$cap_value_date','$cap_type','$raccount_no','$year','transfer','$cap_transfer_from')") or die(mysqli_error($conn));
            }
          }

          $check_pending_capitalized_query = mysqli_query($conn, "SELECT * from capitalized where account_no = '$account_no' and capitalized_status = 'pending'") or die(mysqli_error($conn));
          $count_cap_row = mysqli_num_rows($check_pending_capitalized_query);
          if ($count_cap_row > 0) {

            echo '<script language="javascript">';
            echo 'alert("Please Update Seller Share Amount! There is Pending Cash,Capitalized or Payable Request Exist!")';
            echo '</script>';
            exit();
          }
          $query5 = mysqli_query($conn, "SELECT * from transfer where raccount_no = '$account_no' and status_of_transfer = 'pending'") or die(mysqli_error($conn));
          $count_row = mysqli_num_rows($query5);

          if ($count_row > 0) {

            echo '<script language="javascript">';
            echo 'alert("Please Update Seller Share Amount! There is Pending Request Exist!")';
            echo '</script>';
            exit();
          }
          $query7 = mysqli_query($conn, "SELECT *,sum(total_share_transfered) from transfer where account_no = '$account_no' and status_of_transfer = 'pending'") or die(mysqli_error($conn));

          $count_row7 = mysqli_fetch_array($query7);
          echo "count7--" . $count_row7['sum(total_share_transfered)'] . '<br/>';
          echo "seller share--" . $seller_share . '<br/>';
          $remaining_share = $seller_share - $count_row7['sum(total_share_transfered)'];
          echo "remaining share1--" . $remaining_share . '<br/>';
          $remaining_share = $allotment_amount + $remaining_share;
          echo "remaining share" . $remaining_share . '<br/>';
          echo "allotment share" . $allotment_amount;
          if ($howmany > $remaining_share) {

            echo '<script language="javascript">';
            echo 'alert("You Have no Sufficient Share to Transfer!")';
            echo '</script>';
            exit();
          }

          $query6 = mysqli_query($conn, "SELECT * from transfer where account_no = '$account_no' and raccount_no = '$raccount_no' and status_of_transfer = 'pending'") or die(mysqli_error($conn));
          $count_row6 = mysqli_num_rows($query6);

          if ($count_row6 > 0) {

            echo '<script language="javascript">';
            echo 'alert("Duplicate Entry! There is Pending Request Exist!")';
            echo '</script>';
            exit();
          }

          $query = mysqli_query(
            $conn,
            "INSERT INTO transfer (account_no,total_share, name,raccount_no,rname,rtotal_share,total_share_transfered,total_transfered_in_birr,buyyer_paidup_in_birr,seller_paidup_in_birr,transfer_date,value_date,pervalue,status_of_transfer,year,agreement,agred_to,both_seller,both_buyer,transfer_type) 
  VALUES ('$account_no', '$seller_share','$name','$raccount_no','$rname','$rtotal_share','$total_share_transfered','$total_transfered_in_birr','$buyyer_paidup_in_birr','$seller_paidup','$transfer_date','$value_date','$pervalue','pending','$year','$agreement','$agred_to','$both_seller','$both_buyer','$tt')"
          ) or die(mysqli_error($conn));


          header("location:/shareholder_new/shareholder/transfer?id=" . $id . "&transfer=okay&from=$from&to=$to");
        }
      }
      ?>

      </form>
    </div><!-- /.box-body -->

  </div>