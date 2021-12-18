<?php
$conn=mysqli_connect('localhost','root','','shareholder');
		if (isset($this->session->userdata['logged_in'])) {
		$username = $this->session->userdata['logged_in']['username'];
        $role = $this->session->userdata['logged_in']['role'];
        $userId = $this->session->userdata['logged_in']['id'];	
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

      <?php

  if(isset($_GET['reject'])){
  
  ?>
  
  <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b> Blocked rejected successfully!</b>.
                                    </div>
  
  <?php } ?>

                <!-- Main content -->
                <section class="content">
                    <div class="row" style="width:100%">
                        <div class="col-xs-12">
                           <div class="box">
                                
                                <div class="box-body table-responsive">
                                <form action="" method="POST" role="form" name="myForm" id="myForm" onSubmit="return validateForm()">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            	<th></th>
                                            	<th></th>
                                                <th></th>
                                                <th>No.</th>
                                                <th>Account number</th>                                               
                                                <th>Total paid up capital in birr</th>                                                
												<th>Reason</th>
                                                <th>blocked letter rf_no</th>
                                                <th>Status</th>
                                                <th>maker</th>
												
												
                                        </thead>
                                        <tbody>

                
                                        	<?php
                                        	
                                        	$query = mysqli_query($conn,"SELECT * from blocked  where blocked_status = 8 order by id ASC") or die(mysqli_error($conn));
                                        	
                                        	$a = 0;
                                        	
                                        	while ($rows = mysqli_fetch_array($query)) {
                                        		$a = $a + 1;
                                        		$status=$rows['blocked_status'];
                                                $status_query = mysqli_query($conn,"SELECT * FROM status where id=$status");
                                                $status_result = mysqli_fetch_array($status_query);
                                                $status=$status_result?$status_result['status']:"";

                                                $maker=$rows['maker'];
                                                $maker_query = mysqli_query($conn,"SELECT * FROM user_login where id=$maker");
                                                $maker_result = mysqli_fetch_array($maker_query);
                                                $maker=$maker_result?$maker_result['fullname']:"";
                                        	?>
                                            <tr>
                                            	<td></td>
                                            	<td><input type="checkbox" name="applist[]" value="<?php echo $rows['id'];?>"></td>
                                                <td><input type="checkbox" name="selector[]" value="<?php echo $rows['account'];?>"></td>

                                            	<td><?php echo $a; ?></td>
                                                <td><?php echo $rows['account']; ?></td>                                              
                                           
                                                <td><?php echo $rows['blocked_amount']; ?></td>
                                                
                                              	<td><?php echo $rows['block_remark']; ?></td>
                                                  <td><?php echo $rows['blocked_letter_rf_no']; ?></td>
                                                <td>

                                                    <?php
                                                	if($rows['blocked_status'] == 8){
                                                		
														?>
														
														<span class="badge bg-red"><?php echo $status; ?></span>
														
														<?php
														
													} else {
														
														?>
														
														<span class="badge bg-red"><?php echo $status; ?></span>
														
														<?php
														
														}?>
                                                
														</td>
                                                        <td><?php echo $maker; ?></td>
                                             
                                               <?php } ?>
                                                
                                            </tr>
                                        
                                        </tbody>


                             <?php if($role == 3){?>      
                                  <fieldset>
                                <button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
                                 <button type="submit" name="reject" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Reject</button>
                                </fieldset>
                                <?php } ?>        <br><br>
                                    </table>
                            

                            <?php

                             if (isset($_POST['reject'])){

                                if(isset($_POST['applist'])){ 
                                         $id=$_POST['applist'];

                                         $account_no = $_POST['selector'];
                                                                            
                                            $N = count($id);
                                            
                                            for($i=0; $i < $N; $i++)
                                            {   

                                              $result = mysqli_query($conn,"UPDATE blocked  SET blocked_status = 11,checker = $userId WHERE  id ='$id[$i]'") or die(mysqli_error($conn));
                                              header('location:authorize_blocked?reject=true');
                                                
                                            }
                                        }else{
                                            echo "<script> alert('please select!') </script>" ;
                                        }
                                    }

									if (isset($_POST['release'])){
										if(isset($_POST['applist'])){
                                            $id=$_POST['applist'];
                                                                            
                                            $N = count($id);
                                            
                                            for($i=0; $i < $N; $i++)
                                            {	
                                            
                                                $result = mysqli_query($conn,"UPDATE blocked  SET blocked_status = 10,checker = $userId WHERE  id ='$id[$i]'") or die(mysqli_error($conn));
                                                
                                                header('location:listed?active=true');
                                            
                                            }
                                        }else{
                                            echo "<script> alert('please select!') </script>" ;
                                        }

									}
                           if (isset($_POST['authorize'])){

                            if(isset($_POST['selector'])){
                                $account_no = $_POST['selector'];  
                                $id=$_POST['applist'];
                                $N = count($id);
                                                                      
                                    
                                    for($i=0; $i < $N; $i++)
                                    {   
                                        
                                          $result = mysqli_query($conn,"UPDATE blocked  SET blocked_status = 5,checker = $userId WHERE  id ='$id[$i]'") or die(mysqli_error($conn));
                                            header('location:authorize_blocked?blocked=true');
                                    }
                                }else{
                                    echo "<script> alert('please select!') </script>" ;
                                }
                                  }
									?>
                                   </form> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         
