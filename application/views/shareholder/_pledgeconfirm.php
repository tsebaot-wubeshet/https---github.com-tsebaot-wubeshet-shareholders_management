	<?php
		
		$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
			
		$username = $this->session->userdata['logged_in']['username'];
    $userId = $this->session->userdata['logged_in']['id'];
			
		} 
		
	?>
  <script type="text/javascript">


        function validateForm() {
            
            var a = parseInt(document.forms["myForm"]["total_paidup_capital_inbirr"].value);

            var b = parseInt(document.forms["myForm"]["pledged_amount"].value);

            if (b > a) {

                bootbox.alert(" The pledged amount must be less than the paid up capital");
 
                return false;
            }
        }

</script>
  <script>function format(input){
            var num = input.value.replace(/\,/g,'');
            if(!isNaN(num)){
            if(num.indexOf('.') > -1){
            num = num.split('.');
            num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1').split('').reverse().join('').replace(/^[\,]/,'');
            if(num[1].length > 2){
            alert('You may only enter two decimals!');
            num[1] = num[1].substring(0,num[1].length-1);
            } input.value = num[0]+'.'+num[1];
            } else {
            input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1').split('').reverse().join('').replace(/^[\,]/,'') };
            } else {
            alert('You may enter only Decimal numbers in this field!');
            input.value = input.value.substring(0,input.value.length-2);
            }
            }
    </script>
	<?php

  if(isset($_GET['pledged'])){
  
  ?>
  
  <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Shareholder Pledged Successfully !.
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
                       
  
                         			<form action="" method="POST" role="form" name="myForm" id="myForm" onSubmit="return validateForm()">
                                        <!-- text input -->
                                           <?php
                                        if(isset($_GET['id'])){
                                        	
                                        	$id = $_GET['id'];
                                        } 
                    $result = mysqli_query($conn,"SELECT * FROM shareholders where id ='$id'");
										$row = mysqli_fetch_array($result);
                    if($row){
												?>
                                        <div class="form-group">
                                            
                                            <label>Pledged Shareholder</label>
                                            
                                            <input type="text" name="name" readonly autofocus class="form-control" value="<?php echo $row['name']; ?>">
                                        </div>
                                        
                                        <div class="form-group">
                                            <labe>Account No</label>
                                            <input type="text" name="account_no" readonly class="form-control" value="<?php echo $row['account_no']; ?>">
                                         
                                        </div> 
                                         <div class="form-group">
                                            <label>Total paidup capital in birr</label>
                                            <input type="text" readonly name="total_paidup_capital_inbirr" value="<?php echo $row['total_paidup_capital_inbirr']; ?>" class="form-control" placeholder="Enter ..."/>
                                            <?php echo form_error('total_paidup_capital_inbirr'); ?>
                                        </div>    
                                                                         
                                        <?php }?>
                                        <!-- textarea -->
                                       <div class="form-group">
                                            <label>Pledged amount in birr</label>
                                            <input type="text" required name="pledged_amount" onKeyUp="format(this);" value="" class="form-control" placeholder="Enter ..."/>
                                 			<?php echo form_error('pledged_amount'); ?>
                                        </div>

                                        <div class="form-group">
                                            
                                            <label>Reason</label>
                                            <textarea name="reason" required autofocus class="form-control"><?php echo set_value('reason'); ?></textarea>
                                 			
                                        </div>
                                         <?php echo form_error('reason'); ?>
                                         
                                         <div>
                                            <label> Pledged Date:</label>
                                         <div class="form-group">
                                         	
                                       		<input type="text" readonly onKeyPress="return event.charCode > 47 && event.charCode < 58;" required class="tcal" value="<?php echo set_value('pledged_date'); ?>" name="pledged_date">
	                                        <input type="hidden" readonly="" value="<?php echo $username;?>" name="pledged_by" class="form-control"/>
                                            <input type="hidden" readonly="" value="<?php echo $_GET['id'];?>" name="id" class="form-control"/>   
										</div>
										                <?php echo form_error('pledged_date'); ?>
                                        </div>
										
                                        <div class="box-footer">
                                     
                                        <button type="submit" class="btn btn-primary" name="submit">Pledge Shareholder</button>
                                    </div>
                                    
                                    <?php 
                                    	if(isset($_POST['submit'])){
                                           
                                    		   
											                      $id = $_POST['id'];
                                            $account_no = $_POST['account_no'];
                                            $name = $_POST['name'];
                                            $total_paidup_in_birr = $_POST['total_paidup_capital_inbirr'];

                      											$reason = $_POST['reason'];
                      											$pledged_amount = $_POST['pledged_amount'];
                                            $pledged_amount = $_POST['pledged_amount'];
											                      $pledged_by = $_POST['pledged_by'];
                                            $pldate = $_POST['pledged_date'];
                                            $pledgedamount = $total_paidup_in_birr - $pledged_amount;
                                            $status = "pending";
                                            $year = date('Y-m-d');                                            
											
                      $result = mysqli_query($conn,"INSERT INTO pludge (account_no,total_paidup_capital,name,pledged_by,pledged_amount,pledged_status,pldate,pledged_reason,year) VALUES ('$account_no','$pledgedamount','$name','$pledged_by','$pledged_amount','$status','$pldate','$reason','$year')") or die(mysqli_error($conn));
                                           
											header('location:pledged?pledge=true');
                    }
                                    
                                    ?>
                                    
                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
                    
             