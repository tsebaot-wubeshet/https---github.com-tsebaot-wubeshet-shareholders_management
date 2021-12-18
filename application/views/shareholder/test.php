  <?php
    
    $conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
      
    $username = $this->session->userdata['logged_in']['username'];
      
    } 
    
  ?>
  <?php

  if(isset($_GET['pledged'])){
  
  ?>
  
  <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Shareholder Pledged Successfully !.
                                    </div>
  
  <?php } ?>

  <?php 
  if(isset($_GET['please_pledge'])){
  
  ?>
  
  <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                       Please Fill all the forms and try again!.
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
                       
  
                  <form action="<?php echo base_url('');?>shareholder/pledgeconfrim" method="POST" role="form">
                                        <!-- text input -->
                                           <?php
                                        if(isset($_GET['id'])){
                                          
                                          $id = $_GET['id'];
                                        } 
                    $result = mysqli_query($conn,"SELECT * FROM shareholders where id ='$id'");
                    while($row = mysqli_fetch_array($result))
                      {
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
                                                                         
                                        
                                        <!-- textarea -->
                                       <div class="form-group">
                                            <label>Pledged amount in birr</label>
                                            <input type="text" required name="pledged_amount" value="<?php echo $row['pledged_amount']; ?>" class="form-control" placeholder="Enter ..."/>
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
                                          
                                          <input type="text" required class="tcal" value="<?php echo set_value('pledged_date'); ?>" name="pledged_date" readonly>
                                          <input type="hidden" readonly="" value="<?php echo $username;?>" name="pledged_by" class="form-control"/>
                                          <input type="hidden" readonly="" value="<?php echo $_GET['id'];?>" name="id" class="form-control"/>   
                                          <input type="hidden" readonly="" value="<?php echo $row['total_paidup_capital_inbirr']-$row['pledged_amount'];?>" name="pledgedamount" class="form-control"/>   
                                          <input type="hidden" readonly="" value="pending" name="status" class="form-control"/>   
                                          <input type="hidden" readonly="" value="<?php echo date('Y-m-d');?>" name="year" class="form-control"/>   
           
                    </div>
                    </div>      <?php }?>

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

                                             if($reason == NULL || $pledged_amount == NULL || $pldate == NULL ) {

                                              header("location:pledgeconfirm?please_pledge=true&id=".$id);
                                             

                                             } else {
                      
                      //$query = mysqli_query($conn,"update shareholders set total_paidup_capital_inbirr = '$pledgedamount', pledged_status = '$status' where account_no = '$id'") or die(mysqli_error($conn));
                      
                      $result = mysqli_query($conn,"INSERT INTO pludge (account_no,total_paidup_capital,name,pledged_by,pledged_amount,pledged_status,pldate,pledged_reason,year) VALUES ('$account_no','$pledgedamount','$name','$pledged_by','$pledged_amount','$status','$pldate','$reason','$year')") or die(mysqli_error($conn));
                                           
                      header('location:pledged?pledge=true');
                    }
                                      }
                                    ?>
                                    
                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
                    
             