<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
  $username = $this->session->userdata['logged_in']['username'];
  $role = $this->session->userdata['logged_in']['role'];
}

?> <style type="text/css">
  #searchengine {
    margin-left: 40px;
    margin-top: 10px;
    width: 80%;
    float: left;
  }

  #dividend_top {
    margin-left: 300px;
  }

  #dividend_search {
    margin-left: 40px;
    margin-top: 10px;

  }
</style>
<!-- Main content -->

<section class="content">
  <div class="row" style="width:100%">
    <div class="col-sm-12">
      <div class="box">
        <div class="col-xs-2">

          <form method="POST" action="<?php echo base_url(''); ?>shareholder/dividend_report_excel" id="form">

            <button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Download Shareholder Data</button>

          </form>
        </div>
        <div class="col-sm-6">
          <?php if ($role == 3) { ?>
            <form method="POST" action="<?php echo base_url(''); ?>shareholder/dividend_portion_report" id="form">

              <button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Calculate dividend Portion</button>

            </form>
          <?php } ?>
          <form method="post" action=""><br>
            <?php $this->load->view('shareholder/year1'); ?>
            <select name="name" id="searchengine" class="form-control">
              <option value="">Select Shareholder</option>
              <?php
              $budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status =1");
              $budget_result = mysqli_fetch_array($budget_query);
              $from = "";
              $to = "";
              $year = 0;
              if ($budget_result) {
                $from = $budget_result['budget_from'];
                $to = $budget_result['budget_to'];
                $year = $budget_result['id'];
              }
              $result = mysqli_query($conn, "SELECT * FROM shareholders where currentYear_status=1 or (currentYear_status=2 and closed_year=$year) order by account_no");
              while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['account_no'] . '">';
                echo $row['account_no'] . " - " . $row['name'];
                echo '</option>';
              }
              ?>
            </select>
            <button type="submit" name="search" class="btn btn-primary btn-sm" id="dividend_search">Search</button>
          </form>
        </div>
        <?php

        if (isset($_POST['search'])) {


          $countNumber = "";
          if (isset($_POST['name'])) {
            $countNumber = $_POST['name'];
          }
          //echo "<h1>".$countNumber."</h1>";


          $paidup_utilized = mysqli_query($conn, "SELECT SUM(total_utilized_paidup_capital) as total_amount from dividend_report where year = $year") or die(mysqli_error($conn));
          $total_paidup_utilized = mysqli_fetch_array($paidup_utilized);

          $dividend_amt = mysqli_query($conn, "SELECT * from dividend_amount where year = $year ") or die(mysqli_error($conn));
          $div_amt = mysqli_fetch_array($dividend_amt);
          $dividend_amount = $div_amt ? $div_amt['dividend'] : 0;
          // $shareholders="";
          if ($countNumber) {
            $shareholders = mysqli_query($conn, "SELECT * from shareholders where account_no = '$countNumber' and (currentYear_status=1 or (currentYear_status=2 and closed_year=$year))  order by id ASC") or die(mysqli_error($conn));
          } else {
            $shareholders = mysqli_query($conn, "SELECT * from shareholders where  currentYear_status=1 order by id ASC") or die(mysqli_error($conn));
          }
          //does one person have more than one account_no?
          //why group by name is used in balance & shareholder  
          $orderShareholder = 0;
          while ($shareholder = mysqli_fetch_array($shareholders)) {
        ?>

            <div class="col-md-12">
              <form action="" method="POST">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead>
                    <tr>

                      <th>Account number</th>

                      <th>Shareholder Name</th>

                      <th>Total Paidup Capital in Birr</th>

                      <th>Amount Transfered</th>

                      <th>Adjusted Balance</th>

                      <th>for Adjustment </th>

                      <th>Adjusted Balance for Dividend</th>

                      <th>Dividend Capitalized</th>

                      <th>Dividend Payable Capitalized</th>

                      <th>Cash Payment</th>

                      <th>Total Raised</th>

                      <th>Total Paid-Up Capital</th>


                  </thead>
                  <tbody>

                    <?php

                    $account = $shareholder['account_no'];
                    $result = mysqli_query($conn, "SELECT * from dividend_report where account = '$account'  and year = $year") or die(mysqli_error($conn));
                    $dividendReport = mysqli_fetch_assoc($result);
                    ?>

                    <tr>

                      <td><?php echo $dividendReport['account']; ?></td>
                      <td><?php echo $shareholder['name']; ?></td>
                      <td><?php echo $dividendReport['initial_paidup_capital']; ?></td>
                      <td>&nbsp;<?php echo $dividendReport['transfer'] ?><br /></td>
                      <!-- adjested balance -->
                      <td><?php echo $dividendReport['adjusted_balance']; ?></td>
                      <td><?php echo $dividendReport['forAdjustment']; ?></td>
                      <!-- adjested balance for dividend -->
                      <td><?php echo $dividendReport['adjusted_balance_for_dividend']; ?></td>
                      <!-- dividend capitalized -->
                      <td><?php echo $dividendReport['capitalized'] . "<br>";  ?></td>
                      <!-- dividend payable capitalized -->
                      <td><?php echo $dividendReport['payable'] . "<br>";  ?></td>
                      <!-- cash paid -->
                      <td> <?php echo $dividendReport['cash'] . "<br>";  ?></td>
                      <!-- total raised -->
                      <td><?php echo $dividendReport['total_raised']; ?></td>
                      <!-- totail PaidUp capital      -->
                      <td><?php echo $dividendReport['total_paidup_capital']; ?></td>
                      <td></td>

                    </tr>

                  </tbody>

                </table>
            </div>

            <div class="col-md-12">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>

                    <th>Value Date</th>
                    <th>End Value Date</th>
                    <th>total date</th>
                    <th>Breakdown</th>

                    <th>Average Paidup Capital</th>

                    <th>Sum of the Average Paidup Capital</th>

                    <th>Total Paid-up capital utilized during the Year</th>

                    <th>Ratio</th>

                    <th>Portion of Ordinary Dividend</th>


                    <!-- value date on dividend report-->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $breakdownResult = mysqli_query($conn, "SELECT * from break_down where account = '$account'  and year = $year") or die(mysqli_error($conn));
                  $breakdownReport = array();
                  while ($value = mysqli_fetch_assoc($breakdownResult)) {
                    $breakdownReport[] = $value;
                  }
                  ?>

                  <td><?php

                      foreach ($breakdownReport as $breakdown) {
                        echo $breakdown['value_date'];
                      ?><br>__________<br><?php

                            }

                              ?>
                  </td>

                  <td>
                    <?php

                    foreach ($breakdownReport as $breakdown) {
                      echo $breakdown['end_value_date'];
                    ?><br>__________<br><?php

                          }

                            ?>

                  </td>
                  <td>
                    <?php

                    foreach ($breakdownReport as $breakdown) {
                      echo $breakdown['total_date'];
                    ?><br>__________<br><?php

                          }

                            ?>
                  </td>
                  <td>
                    <?php

                    foreach ($breakdownReport as $breakdown) {
                      echo $breakdown['amount'];
                    ?><br>__________<br><?php

                          }

                            ?>
                  </td>
                  <td>
                    <?php

                    foreach ($breakdownReport as $breakdown) {
                      echo $breakdown['avarage_paidup_capital'];
                    ?><br>__________<br><?php

                          }

                            ?>
                  </td>
                  <!-- total paid up capital utilized during the year -->
                  <td><?php echo $dividendReport['total_average_paidup_capital'];
                      ?>
                  </td>
                  <td><?php echo $dividendReport['total_utilized_paidup_capital']; ?>
                    <br />
                    <br />
                    <div style="background-color: purple; color:white">
                      <?php echo $total_paidup_utilized ? $total_paidup_utilized['total_amount'] : ""; ?>
                    </div>
                  </td>

                  <?php
                  $ratio = mysqli_query($conn, "SELECT * from ratio_dividend where account = '$account'  and year = $year") or die(mysqli_error($conn));
                  $ratioResult = mysqli_fetch_assoc($ratio)
                  ?>
                  <td> <?php echo $ratioResult ? $ratioResult['ratio'] : ""; ?>
                    <br />
                    <br />
                    <div style="background-color: purple; color:white">
                      <?php echo $dividend_amount; ?>
                    </div>
                  </td>

                  <td><?php echo $ratioResult ? $ratioResult['dividend_portion'] : ""; ?></td>

                  </td>
                  </tr>

                </tbody>
              </table>
              </form>

            </div>

        <?php  }
        }
        ?>
      </div>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
  </div>
  </div>

</section><!-- /.content -->