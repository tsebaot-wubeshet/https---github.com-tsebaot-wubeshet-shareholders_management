	<?php
    $conn = mysqli_connect('localhost', 'root', '', 'shareholder');
    if (isset($this->session->userdata['logged_in'])) {

        $username = $this->session->userdata['logged_in']['username'];
        $userId = $this->session->userdata['logged_in']['id'];
    }

    ?>
	<?php
    if (isset($_GET['cash'])) {
    ?>
	    <div class="alert alert-success alert-dismissable">
	        <i class="fa fa-ban"></i>
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <b>Success!</b> Dividend Capitalized!.
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
	                        <select name="shareholder" class="form-control" required onchange="showUser(this.value)">
	                            <option value="">Select Shareholder Name</option>
	                            <?php

                                $result = mysqli_query($conn, "SELECT account_no,name FROM shareholders WHERE currentYear_status = 1  order by account_no");

                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['account_no'] . '">';
                                    echo $row['account_no'] . '-' . $row['name'];
                                    echo '</option>';
                                }
                                ?>

	                        </select>

	                    </div>

	                    <div id="txtHint"></div>
	                    <div class="form-group">
	                        <label>Capitalized Amount in Birr</label>
	                        <input type="text" name="capitalized_in_birr" class="form-control" placeholder="Enter ..." required />

	                    </div>

	                    <div class="form-group">
	                        <label>Value Date</label><br>
	                        <input type="text" name="value_date" class="tcal" placeholder="Enter ..." required />

	                    </div>
	                    <div class="box-footer">

	                        <button type="submit" class="btn btn-primary" name="submit">Capitalize</button>
	                    </div>

	                    <?php

                        if (isset($_POST['submit'])) {
                            $from = "";
                            $to = "";
                            $year = 0;
                            if ($budget_result) {
                                $from = $budget_result['budget_from'];
                                $to = $budget_result['budget_to'];
                                $year = $budget_result['id'];
                            }
                            $capitalized_in_birr = $_POST['capitalized_in_birr'];
                            $account_no = $_POST['account_no'];
                            $value_date = $_POST['value_date'];
                            $capitalized_date = date('Y-m-d');

                            // $check = mysqli_query($conn,"SELECT * FROM allotment WHERE account = '$account_no' and allot_status =4") or die(mysqli_error($conn));
                            // $check_row = mysqli_fetch_array($check);
                            // $check_allot = $check_row['allotment']*500;
                            // $allot_date = $check_row['allot_year'];   
                            // if($capitalized_in_birr <= $check_allot){


                            mysqli_query($conn, "INSERT into capitalized (account,capitalized_in_birr,capitalized_date,value_date,type,capitalized_status,year,maker) values ('$account_no','$capitalized_in_birr','$capitalized_date','$value_date',1,3,$year,$userId)") or die(mysqli_error($conn));
                            header('location:dividend_capitalized?cash=true');
                        }
                        ?>



	                </form>
	            </div><!-- /.box-body -->

	        </div>