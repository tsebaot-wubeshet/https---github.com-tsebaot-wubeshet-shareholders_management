	<?php
		
		$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
			
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
	if(isset($_GET['status'])){
        if($_GET['status'] == "success")
        { ?>
        <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <b>Success!</b> Certificate Edited Successfully!
                                        </div>
        <?php } else if($_GET['status'] == "error"){?>
            <div class="alert alert-warning alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <b>Error!</b> The sum of prepared and issued share certificates can't be more than the total share!
                                        </div>
            <?php } } ?>
        
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
                

               <form action="" method="POST" role="form">
                
                 <?php 
                
                  $id = $_GET['id'];
                
                  $query = mysqli_query($conn,"SELECT * from certificate where account = '$id'") or die(mysqli_error($conn));
                                            
                        $row = mysqli_fetch_array($query);

                 $query1 = mysqli_query($conn,"SELECT s.*, b.total_paidup_capital_inbirr from shareholders s left join balance b on b.account = s.account_no where account_no = '$id'") or die(mysqli_error($conn));
                                            
                        $rows = mysqli_fetch_array($query1);

                 
                ?>      
 
            <div class="form-group">                
            <label> Shareholder Name</label>
            <input type="text" name="name" class="form-control" readonly value="<?php echo $rows['name'];?>">
               
            </div>
            <div class="form-group">                
            <label> Account No</label>
           <input type="text" name="account_no" class="form-control" readonly value="<?php echo $row['account']; ?>">
                
            </div>

            <div class="form-group">                
            <label> Total paid up capital in share</label>
            <input type="text" name="total_paid_up_cap" class="form-control" readonly value="<?php echo $rows['total_paidup_capital_inbirr']/500;?>">               
            </div>
           
			<div class="form-group">                
            <label> Remaining Share Certificates</label>
            <input type="text" readonly name="remaining_share" class="form-control" value="<?php echo ($rows['total_paidup_capital_inbirr']/500)-($row['issued_share_certificate'] + $row['prepared_share_certificate']); ?>">
               
            </div>
            <div class="form-group">                
            <label> Issued Share Certificates<span class="label label-danger"><?php //echo $row['issued_share_certificate']; ?></span></label>
            <input type="text" value="<?php echo $row['issued_share_certificate']; ?>" name="issued_share" class="form-control">
               
            </div>  
            <div class="form-group">
                <label>Prepared Share Certificate <span class="label label-danger"><?php //echo $row['prepared_share_certificate']; ?></span></label>
                <input type="text" value="<?php echo $row['prepared_share_certificate']; ?>" class="form-control" name="prepared_share" class="form-control" placeholder="Enter prepared certificate...">                                      
            </div>                     
           
           <input type="hidden" name="issued" value="<?php echo $row['issued_share_certificate']; ?>">

           <input type="hidden" name="prepared" value="<?php echo $row['prepared_share_certificate']; ?>">
      
            <div class="box-footer">
         
            <button type="submit" class="btn btn-primary" name="submit">submit</button>
        </div>
       

        <?php 
        	if(isset($_POST['submit'])){   
               ?>
            <script>
                 $("#success-alert").hide();
            </script>

                <?php
                $id = $_GET['id'];     		
				
                $issued_share = $_POST['issued_share']; //user input

				$prepared_share = $_POST['prepared_share']; //user input

     			$account_no = $_POST['account_no'];		
                 
                 $remaining = $_POST['remaining_share'];

                 $total_share = $_POST['total_paid_up_cap'];

                 if($issued_share + $prepared_share <= $total_share){
                    mysqli_query($conn,"UPDATE certificate SET issued_share_certificate = '$issued_share',prepared_share_certificate = '$prepared_share' WHERE account = '$account_no'") or die(mysqli_error($conn));

                    header("location:/shareholder_new/shareholder/update_certificate?id=".$id."&status=success");
                 }
                 else{
                    header("location:/shareholder_new/shareholder/update_certificate?id=".$id."&status=error");

                 }

                								
				

				?>
		
        	<?php
        }

        	?>
                                    
                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
                    
                 </div><!-- /.box-body -->
                           
                     </div>