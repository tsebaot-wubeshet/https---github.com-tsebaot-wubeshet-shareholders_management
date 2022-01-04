	<?php
    $conn = mysqli_connect('localhost', 'root', '', 'shareholder');
    if (isset($this->session->userdata['logged_in'])) {
        $username = $this->session->userdata['logged_in']['username'];
    }
    ?>
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
	            xmlhttp.open("GET", "<?php echo base_url(); ?>shareholder/getaccountno?q=" + str, true);
	            xmlhttp.send();
	        }
	    }
	</script>

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
    if (isset($_GET['edit_requested_share'])) {
    ?>
	    <div class="alert alert-success alert-dismissable">
	        <i class="fa fa-ban"></i>
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <b> Share request edited successfully!.
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
	                    <?php
                        if (isset($_GET['id'])) {
                            $acct = $_GET['id'];
                        }

                        $query = mysqli_query($conn, "SELECT * from share_request WHERE account_no = '$acct'");

                        while ($row = mysqli_fetch_array($query)) {

                        ?>
	                        <div class="form-group">
	                            <label>Shareholder Full names</label>
	                            <input type="text" readonly name="name" class="form-control" value="<?php echo $row['name']; ?>" placeholder="Enter ..." />
	                            <?php echo form_error('name'); ?>
	                        </div>


	                        <div class="form-group">
	                            <label>Application Date</label>
	                            <input type="text" readonly="" name="application_date" class="form-control" value="<?php echo $row['application_date']; ?>" placeholder="Enter ..." />

	                        </div>

	                        <div class="form-group">
	                            <label>Total Share Needed</label>
	                            <input type="text" name="total_share" autofocus="" value="<?php echo $row['total_share']; ?>" class="form-control" placeholder="Enter ..." />
	                            <?php echo form_error('total_share'); ?>
	                        </div>
	                        <input type="hidden" name="account_no" autofocus="" value="<?php echo $acct; ?>" class="form-control" placeholder="Enter ..." />

	                    <?php } ?>

	                    <div class="box-footer">
	                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
	                    </div>
	                </form>
	            </div><!-- /.box-body -->
	        </div>

	        <?php

            if (isset($_POST['submit'])) {

                $account_no = $_POST['account_no'];
                $application_date = $_POST['application_date'];
                $total_share = $_POST['total_share'];

                $result = mysqli_query($conn, "UPDATE share_request SET total_share = '$total_share',application_date = '$application_date' WHERE account_no = '$account_no'") or die(mysqli_error($conn));
                header('location:sharerequest?edit_requested_share=true');
            }
            ?>