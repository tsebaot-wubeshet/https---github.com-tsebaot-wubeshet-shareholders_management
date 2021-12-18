<?php
		
		$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
		
		$username = $this->session->userdata['logged_in']['username'];
			
		} 
		
?> 
<?php

	if(isset($_GET['active'])){
	
	?>
	
	<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Shareholder Released Successfully!.
                                    </div>
	
	<?php } ?>
                <!-- Main content -->
                <section class="content">
                    <div class="row" style="width:2000px">
                        <div class="col-xs-12">
                           <div class="box">
                                
                                <div class="box-body table-responsive">
                                <form action="" method="POST">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th></th>
                                            <th>No.</th>
                                            <th>Share transfer from</th>
                                            <th>Total share subscribed before transfer</th>
                                            <th>Total share subscribed after transfer</th>
                                            <th>Amount of Share Transfered</th>  
											<th>Status</th>
                                        </thead>
                                        <tbody>
                                        	
                                    <?php
                                        	
                                        	
                                        	$query = mysqli_query($conn,"SELECT * from transfer_from_bank WHERE status_of_transfer = 'authorized' order by transfer_date ASC") or die(mysqli_error($conn));
                                        	
                                            $a = 0;
                                        	
                                        	while ($rows = mysqli_fetch_array($query)) {
                                        	$a = $a + 1;
                                          ?>
                                <tr>
                                    <td></td>
                                            	
                                	<td><?php echo $a; ?></td>                                  
                                    
                                    <td>NIB</td>

                                    <td><?php echo number_format($rows['total_share']); ?></td>

                                    <td><?php echo number_format($rows['total_share']+ $rows['new_share_subscribed']); ?></td>
                                                
                                    <td><?php echo number_format($rows['new_share_subscribed']); ?></td>

                                    <td><?php echo $rows['transfer_date']; ?></td>
                                                     
                                                   
                                                    
                                                <?php }  ?>
                                            </tr>
                                            
                                        </tbody>
                                       
                                    </table>
                                    
                                   </form> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         
