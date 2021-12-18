<?php
$conn=mysqli_connect('localhost','root','','shareholder');
		if (isset($this->session->userdata['logged_in'])) {
		$username = $this->session->userdata['logged_in']['username'];
        $role = $this->session->userdata['logged_in']['role'];	
        $user = $this->session->userdata['logged_in']['id'];
		} 
?> 
	<?php
	if(isset($_GET['block'])){
	?>
	<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Shareholder Blocked Successfully!.
                                    </div>
	<?php } ?>
     <?php

  if(isset($_GET['blocked'])){
  
  ?>
  
  <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Shareholder Blocked Successfully!.
                                    </div>
  
  <?php } ?>

                <!-- Main content -->
                <section class="content">
                    <div class="row" style="width:100%">
                        <div class="col-xs-12">
                           <div class="box">
                                
                                <div class="box-body table-responsive">
                                <form action="" method="POST">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            	<th></th>
                                            	<th></th>
                                                <th>No.</th>
                                                <th>Account number</th>
                                                <th>Shareholder Name</th>
                                                <th>blocked amount</th>
                                                <th>blocked type</th>
                                               
												<th>Reason</th>
                                                <th>Status</th>
												
												
                                        </thead>
                                        <tbody>

                
                                        	<?php
                                        	
                                        	$query = mysqli_query($conn,"SELECT * from blocked left outer join shareholders on blocked.account = shareholders.account_no where blocked.blocked_status in(5,8)  order by blocked.id ASC") or die(mysqli_error($conn));
                                        	$a = 0;
                                        	
                                        	while ($rows = mysqli_fetch_array($query)) {
                                        		$a = $a + 1;
                                                $status=$rows['blocked_status'];
                                                $query2 = mysqli_query($conn,"SELECT * from status where id = $status") or die(mysqli_error($conn));
                                                $status = mysqli_fetch_array($query2);
                                        	?>
                                            <tr>
                                            	<td></td>
                                            	<td><input type="checkbox" name="applist[]" value="<?php echo $rows['id'];?>"></td>
                                            	<td><?php echo $a; ?></td>
                                                <td><?php echo $rows['account']; ?></td>
                                                <td><?php echo $rows['name']; ?></td>                                                                                         
                                                <td><?php echo $rows['blocked_amount']; ?></td>  
                                                <td><?php echo $rows['blocked_type']; ?></td>                                    
                                              	<td><?php echo $rows['block_remark']; ?></td>
                                                <td>

                                                    <?php
                                                	if($rows['blocked_status'] == 5){
                                                		
														?>
														
														<span class="badge bg-red"><?php echo $status['status']; ?></span>
														
														<?php
														
													} else {
														
														?>
														
														<span class="badge bg-red"><?php echo $status['status']; ?></span>
														
														<?php
														
														}?>
														</td>
                                                
                                             
                                               <?php } ?>
                                                
                                            </tr>
                                        
                                         
                                        
                                        </tbody>


                                <?php if($role == 3){?>      
                                  <button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
                                <?php } ?>
                                    <br><br>
                                    </table>
                                    
                                    <?php
						
									if (isset($_POST['release'])){
										
									$id=$_POST['applist'];
																	
									$N = count($id);
									
									for($i=0; $i < $N; $i++)
									{	
										$result = mysqli_query($conn,"UPDATE blocked SET blocked_status = 10, checker=$user where id='$id[$i]'");
										
										header('location:listed?active=true');
										
									}
							
									}
                                    if (isset($_POST['authorize'])){
   
                                    $id=$_POST['applist'];
                                                                    
                                    $N = count($id);
                                    
                                    for($i=0; $i < $N; $i++)
                                    {   
                                        $result = mysqli_query($conn,"UPDATE blocked SET blocked_status = 5, checker = $user where id='$id[$i]'");
                                        
                                        header('location:block?blocked=true');
                                        
                                    }
                            
                                    }
									?>
                                   </form> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         
