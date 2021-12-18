	<?php
		$conn=mysqli_connect('localhost','root','','shareholder');
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
        xmlhttp.open("GET","<?php echo base_url();?>shareholder/getusers?q="+str,true);
        xmlhttp.send();
    }
}
</script>

<?php
	if(isset($_GET['paidup'])){
	?>
	<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Paidup Amount Created!.
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

                    <?php if($this->session->flashdata('flashError')): ?>
                   
                  <p class='flashMsg flashError alert alert-danger alert-dismissable'> <?php echo $this->session->flashdata('flashError')?> </p>
                  <?php endif ?>

                                        <?php
                                    $query = mysqli_query($conn,"SELECT * from paidup") or die(mysqli_error($conn));

                                    $row = mysqli_fetch_array($query); 

                                    $divyear = $row['year'];

                                    $year = date('Y');

                                    if($year == $divyear){

                                     ?>

                                     <br><br><br><br>

                                     <div class="alert alert-danger alert-dismissable" align="center">
                                        <i class="fa fa-"> X </i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b></b> Payable Amount for Current Year Created!.
                                    </div>

                                     <?php

                                    } else {

                                    ?>
                       
                         				<form action="" method="POST" role="form" name='myForm'>
                                    
									 	<div class="form-group">
                                            <label>Total Paidup Amount </label>
                                            <input type="text" name="amount" autofocus class="form-control" placeholder="Enter Paidup Amount..." required/>
                                 			
                                        </div>
                    					<div class="form-group">
                                            <label>Year</label>
                                            <input type="text" name="year" class="form-control" value="<?php echo date('Y'); ?>" readonly="" required/>
                                      
                                        </div>                       
                                       
                                        <div class="box-footer">
                                     
                                        <button type="submit" class="btn btn-primary" name="submit">submit</button>
                                    </div>

                                    <?php } ?>
                                    
                                    <?php 
                                    	if(isset($_POST['submit'])) {
                                    		
											$amount = $_POST['amount'];

											$year = $_POST['year'];

											
											mysqli_query($conn,"INSERT into paidup (paidup,year) 
												values ('$amount','$year')") or die(mysqli_error($conn));

										    header('location:/shareholder_new/shareholder/add_paidup?paidup=success');								
											

											?>
									
                                    	<?php
                                    }

                                    	?>
                                    
                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
                    
             