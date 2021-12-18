  <?php
		$conn=mysqli_connect('localhost','root','','shareholder');
		if (isset($this->session->userdata['logged_in'])) {	
		$username = $this->session->userdata['logged_in']['username'];
			
		} 
	?>
                            <!-- general form elements disabled -->
                      <div class="box box-warning">
                          <div class="col-md-12">
                        	
                                <div class="box-body">
                                         <!-- display message -->
								   	<?php
										if (isset($message_display)) { ?>
									<div class="alert alert-success alert-dismissable" role="alert">
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
                  
                 
                  <form action="<?php echo base_url('');?>shareholder/update_capitalized" method="POST" role="form">
                      
              <?php  

                  $id = isset($_GET['id']);

                  $query = mysqli_query($conn,"SELECT * from capitalized WHERE id = '$id'"); 

                  while($row = mysqli_fetch_array($query)){

                ?>

                         <div class="col-sm-6">                                           
                                      <div class="form-group">
                                            <label>Value date</label>
                                            <input type="text" name="value_date" class="tcal" value="<?php echo $row['value_date']; ?>" placeholder="Enter ..."/>
                                      <?php echo form_error('value_date'); ?>
                                        </div>
                                      <div class="form-group">
                                            <label>Capitalized in birr  </label>
                                            <input type="text" name="capitalized_in_birr" class="form-control" value="<?php echo $row['capitalized_in_birr']; ?>" placeholder="Enter ..."/>
                                      <?php echo form_error('capitalized_in_birr'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Capitalized in share </label>
                                            <input type="text" name="cap_in_share" class="form-control" value="<?php echo $row['capitalized_in_share']; ?>" placeholder="Enter ..."/>
                                      <?php echo form_error('cap_in_share'); ?>
                                        </div>
                    <input type="hidden" value="<?php echo $row['id']; ?>" name="id" 
                    class="form-control"/>
                           
                                       <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                   </div>  
                                         <?php   } ?> 
                                </form>

                           </div><!-- /.box-body -->
                     </div>
                    </div>
         