<?php
		
		$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {

			
		$username = $this->session->userdata['logged_in']['username'];
			
		} 
		
?>
               
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                           <div class="box">
                                
                                <div class="box-body table-responsive">
                                    <form method="post" action="">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>No.</th>
                                                <th>First Name</th>
                                                <th>User Name</th>
                                                <th>User Role</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	
                                        	<?php
                                        	
                                        	$query = mysqli_query($conn,"SELECT * from user_login order by id ASC") or die(mysqli_error($conn));
                                        	
											$a = 0;
											
                                        	while ($rows = mysqli_fetch_array($query)) {
                                        		
											$a = $a + 1;
                                            $role=$rows['role'];
                                            $role_query = mysqli_query($conn,"SELECT * from role where id=$role order by id ASC") or die(mysqli_error($conn));
                                            $role=mysqli_fetch_array($role_query)
                                        	?>
                                            <tr>
                                                <td><input type="checkbox" name="selector[]"></td>
                                                <td><?php echo $a; ?></td>
                                                <td><?php echo $rows['fullname']; ?></td>
                                                <td><?php echo $rows['user_name']; ?></td>
                                                <td><?php echo $role['role']; ?></td>
                                               
                                                
                                               <?php } ?>
                                                
                                            </tr>
                                            
                                        </tbody>
                                       
                                    </table>
                                </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
          
