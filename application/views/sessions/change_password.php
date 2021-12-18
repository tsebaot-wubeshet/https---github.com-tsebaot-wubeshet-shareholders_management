    <?php
        
        if (isset($this->session->userdata['logged_in'])) {
            
            
        $username = $this->session->userdata['logged_in']['username'];
            
        } 
        
    ?>
              
                            <!-- general form elements disabled -->
                           
                      <div class="box box-warning">
                          <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="box-body">
                                         <!-- display message -->
                                    <?php
                                        if (isset($message_display)) { ?>
                                    <div class="alert alert-info" role="alert">
                                        <?php 
                                            echo "<div class='message'>";
                                            echo $message_display;
                                            echo "</div>";
                                        ?>
                                    </div> 
                                    <?php } ?> 
                                    
                                
                                         <form action="<?php echo base_url('');?>shareholder/change_pass" method="POST" role="form">
                                        <!-- text input -->
                                      
                                        <div class="form-group">
                                            <label>User Name</label>
                                            
                                            <input type="text" readonly="" name="username" value="<?php echo $username; ?>" readonly="" class="form-control" placeholder="Enter ..."/>
                                            <input type="hidden" name="oldpass" readonly="" class="form-control" value="123456" placeholder="Enter ..."/>
                                            <?php echo form_error('username'); ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" autofocus name="newpass" class="form-control"  placeholder="Enter ..."/>
                                            <?php echo form_error('newpass'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" name="confirmpass" class="form-control" placeholder="Enter ..."/>
                                            <?php echo form_error('confirmpass'); ?>
                                        </div>
                                        
                                     <button type="submit" class="btn btn-primary" name="submit">Change Password</button>
                          </div></div>
                        
                                       
                                    </div>
                                    
                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
                    
             