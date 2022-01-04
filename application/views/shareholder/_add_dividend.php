	<?php
    $conn = mysqli_connect('localhost', 'root', '', 'shareholder');
    if (isset($this->session->userdata['logged_in'])) {

        $username = $this->session->userdata['logged_in']['username'];
    }

    ?>
	<?php
    if (isset($_GET['dividend'])) {
    ?>
	    <div class="alert alert-success alert-dismissable">
	        <i class="fa fa-ban"></i>
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <b>Success!</b> Dividend Amount Created!.
	    </div>
	<?php } ?>
	<div class="box box-warning">
	    <div class="col-md-12">
	        <div class="col-md-6">
	            <div class="box-body">
	                <!-- display message -->
	                <?php if ($this->session->flashdata('flashError')) : ?>

	                    <p class='flashMsg flashError alert alert-danger alert-dismissable'> <?php echo $this->session->flashdata('flashError') ?> </p>
	                <?php endif ?>

	                <?php
                    $budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");
                    $budget_result = mysqli_fetch_array($budget_query);
                    $year = 0;
                    if ($budget_result) {
                        $year = $budget_result['id'];
                        // $endd = $budget_result['budget_to']; 
                        // $startd = $budget_result['budget_from'];
                    }

                    $query = mysqli_query($conn, "SELECT * from dividend_amount where year=$year") or die(mysqli_error($conn));
                    $row = mysqli_fetch_array($query);
                    if ($row) {
                    ?>
	                    <br><br><br><br>
	                    <div class="alert alert-danger alert-dismissable" align="center">
	                        <i class="fa fa-"> X </i>
	                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                        <b></b> Dividend Amount for Current Year Created!.
	                    </div>
	                <?php
                    } else {

                    ?>

	                    <form action="" method="POST" role="form" name='myForm'>

	                        <div class="form-group">
	                            <label>Total Profit Amount </label>
	                            <input type="text" name="amount" autofocus class="form-control" placeholder="Enter Paidup Amount..." required />

	                        </div>
	                        <div class="form-group">
	                            <label>Year</label>
	                            <input type="text" name="year" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly="" required />

	                        </div>

	                        <div class="box-footer">

	                            <button type="submit" class="btn btn-primary" name="submit">submit</button>
	                        </div>

	                    <?php }

                    if (isset($_POST['submit'])) {

                        $amount = $_POST['amount'];
                        $updated_date = date("Y-m-d");

                        mysqli_query($conn, "INSERT into dividend_amount(dividend,updated_date,year)values ('$amount','$updated_date',$year)") or die(mysqli_error($conn));
                        header('location:/shareholder_new/shareholder/add_dividend?dividend=success');
                        ?>

	                    <?php
                    }

                        ?>

	                    </form>
	            </div><!-- /.box-body -->

	        </div>