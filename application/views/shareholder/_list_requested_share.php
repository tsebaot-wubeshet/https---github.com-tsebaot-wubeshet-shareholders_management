<?php
$conn=mysqli_connect('localhost','root','','shareholder');
		if (isset($this->session->userdata['logged_in'])) {
		$username = $this->session->userdata['logged_in']['username'];
		$role=$this->session->userdata['logged_in']['role'];	
		} 
?> 
	<?php

	if(isset($_GET['block'])){
	
	?>
	<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Shareholder Released Successfully!.
                                    </div>
	
	<?php } ?>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                           <div class="box">
                                
                                <div class="box-body table-responsive">
                                <form action="" method="POST">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>                                          
                                                <th>No.</th>
                                                <th>Account NO</th>
                                                <th>Application Date</th>
                                                <th>Total Share Requested</th>
                                                <?php if($role==3){?>
                                                <th></th>
                                                <?php }?>
                                       			<th>Status</th>
                                       														
                                        </thead>
                                        <tbody>
                                        	
                                        	<?php
                                        	
                             $query = mysqli_query($conn,"SELECT * from share_request order by application_date") or die(mysqli_error($conn));
                                        	
                                        	$a = 0;
                                        	
                                        	while ($rows = mysqli_fetch_array($query)) {
                                        		$a = $a + 1;
                                        		
                                        	?>
                                            <tr>
                                            <td><?php echo $a; ?></td>
                                            	<td><?php echo $rows['account']; ?></td>                                               
                                                <td><?php echo $rows['application_date']; ?></td>     
                                                <td><?php echo $rows['total_share_request']; ?></td>
                                                <?php if($role==3){?>
                                                <td><a href="<?php echo base_url();?>shareholder/edit_requested_share?id=<?php echo $rows['account_no']; ?>">Edit</td> 
                                                <?php }?>
                                                <td><?php
                                                	if($rows['share_request_status'] == 3){
                                                		
														?>
														
												<span class="badge bg-blue"><?php echo 'pending'; ?></span>
														
														<?php
														
													} else {
														
														?>
														
												<span class="badge bg-red"><?php echo 'authorized/rejected'; ?></span>
														
														<?php
														
														}
														
														?></td>

                                               <?php } ?>
                                                
                                            </tr>
                                            
                                        </tbody>
                                   
                                     <br><br>
                                    </table>
                                   
                            <?php
						            /*  
									if (isset($_POST['release'])){
                                    
                                    $id=$_POST['applist'];
														
									$N = count($id);

									for($i=0; $i < $N; $i++)
									{	
									   
                $result = mysqli_query($conn,"UPDATE shareholders SET total_share_subscribed = '$total',status = 'active' where account_no='$id[$i]'") or die(mysqli_error($conn));

                $result = mysqli_query($conn,"UPDATE pludge SET status = 'pludge_released' where account_no='$id[$i]'") or die(mysqli_error($conn));
                                
									}
							
									}
									*/
									?>
                                   </form> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         