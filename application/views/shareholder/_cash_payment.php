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
if (isset($_GET['update_allotement'])) {
?>
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Allotment must be updated for this account number before paying cash </b> .
    </div>
<?php } ?>
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

                        <select name="shareholder" class="form-control" required>
                            <option value="">Select Shareholder Name</option>
                            <?php

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
                        <input type="text" onkeyup="javascript:this.value=Comma(this.value);" name="capitalized_in_birr" class="form-control" placeholder="Enter ..." required />

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

                        $name = $_POST['name'];
                        $capitalized_in_birr_result = $_POST['capitalized_in_birr'];
                        $capitalized_in_birr = preg_replace('/[ ,]+/', '', trim($capitalized_in_birr_result));

                        $shareValue_request = mysqli_query($conn, "SELECT * FROM share_value ") or die(mysqli_error($conn));
                        $shareValue_row = mysqli_fetch_array($shareValue_request);
                        $shareValue = $shareValue_row ? $shareValue_row['share_value'] : 0;

                        $capitalized_share = $capitalized_in_birr / $shareValue;
                        $account_no = $_POST['account_no'];

                        $value_date = $_POST['value_date'];
                        $currentDate = $value_date;
                        $currentDate = date('Y-m-d', strtotime($currentDate));
                        $today = date('Y-m-d');

                        $divisible = $capitalized_in_birr % $shareValue;

                        if (($currentDate < $from) || ($currentDate > $to)) {

                            echo '<script>alert("Value date is out of budget year!");</script>';
                        } else {
                            $value_date = $_POST['value_date'];
                            $check = mysqli_query($conn, "SELECT * FROM allotment WHERE account= '$account_no' and allot_status = 4 and year=$year") or die(mysqli_error($conn));
                            $check_row = mysqli_fetch_array($check);

                            $check_allot = $check_row['allotment'] * $shareValue;
                            $allot_date = $check_row['allot_year'];

                            $allotment_query = mysqli_query($conn, "SELECT * from allotment where account = '$acct' and year=$year and allot_status=4 order by id ASC") or die(mysqli_error($conn));
                            $allotment_row = mysqli_fetch_array($allotment_query);
                            $allotment = $allotment_row ? $allotment_row['allotment'] : 0;
                            $allot_date = $allotment_row ? $allotment_row['allot_date'] : "";

                            $capitalized_query = mysqli_query($conn, "SELECT sum(capitalized_in_birr) as capitalized_in_birr from capitalized where account = '$acct'and capitalized_status in(4,3) and year=$year order by id ASC") or die(mysqli_error($conn));
                            $capitalized_row = mysqli_fetch_array($capitalized_query);
                            $capitalized = $capitalized_row ? $capitalized_row['capitalized_in_birr'] : 0;

                            $payable_query = mysqli_query($conn, "SELECT sum(capitalized_in_birr) as capitalized_in_birr from capitalized where account = '$acct'and capitalized_status in(4,3) and and type=2 and year=$year order by id ASC") or die(mysqli_error($conn));
                            $payable_row = mysqli_fetch_array($capitalized_query);
                            $payable = $capitalized_row ? $capitalized_row['capitalized_in_birr'] : 0;

                            $check_allot = $allotment * $shareValue - $capitalized;


                            if (!$payable && ($divisible > 0)) {
                                echo '<script language="javascript">';
                                echo 'alert("The cash payment amount must be divisible by share value.")';
                                echo '</script>';
                            } elseif ($capitalized_in_birr <= $check_allot) {

                                mysqli_query($conn, "INSERT into capitalized (account,capitalized_in_birr,capitalized_date,value_date,type,year,capitalized_status,maker) values ('$account_no','$capitalized_in_birr','$capitalized_date','$value_date',3,$year,3,$yearId)") or die(mysqli_error($conn));
                                header('location:/shareholder_new/shareholder/cash_payment?cash=paid');
                            } elseif ($value_date < $allot_date) {
                                echo '<script language="javascript">';
                                echo 'alert("Value date of cash payment must be greater than alloted start date")';
                                echo '</script>';
                            } else {

                                echo '<script language="javascript">';
                                echo 'alert("Allotment must be updated for this account number before paying cash")';
                                echo '</script>';
                            }

                    ?>


                    <?php
                        }
                    }

                    ?>

                </form>
            </div><!-- /.box-body -->

        </div>