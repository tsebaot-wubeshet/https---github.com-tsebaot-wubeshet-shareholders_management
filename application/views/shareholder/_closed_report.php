<?php
		$conn=mysqli_connect('localhost','root','','shareholder');
		if (isset($this->session->userdata['logged_in'])) {
		
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
    <?php 
?>
                <!-- Main content -->
                <section class="content">
                    <div class="row" style="width:100%">
                        <div class="col-xs-12">
                           <div class="box">
                                  <div class="col-xs-2">
                    <form method="POST" action="<?php echo base_url('');?>shareholder/closed_share" id="form">
                    
                    <button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Download Closed Report</button>
                
                    </form>
                        </div>
                        <br><br>
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
                                                <th>Share Transfere To</th>
                                                <th>Total Share subscribed before gaining share</th>
                                                <th>Total Share subscribed after gaining share</th>
												<th>Closed Date</th>
                                        </thead>
                                        <tbody>
                                        	
                                    <?php
                                        	
                    $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
                    $budget_result = mysqli_fetch_array($budget_query);
                    $from="";
                    $to="";
                    $year=0;
                    if($budget_result){
                    $from = $budget_result['budget_from'];
                    $to = $budget_result['budget_to'];
                    $year=$budget_result['id'];
                    }
                        
                        $query = mysqli_query($conn,"SELECT * FROM transfer WHERE status_of_transfer = 4 AND  seller_account in (select account_no from shareholders where currentYear_status=2) order by transfer_date DESC") or die(mysqli_error($conn));
                        $a = 0;
                        
                        while ($rows = mysqli_fetch_array($query)) {
                        $a = $a + 1;
                        $buyer_account=$rows['buyer_account'];
                        $balance_query = mysqli_query($conn,"SELECT * FROM balance WHERE account = $buyer_account");
                        $balance_result = mysqli_fetch_array($balance_query);
                        $buyer_balance=$balance_result?$balance_result['total_paidup_capital_inbirr']:0;

                        $capitalized_query = mysqli_query($conn,"SELECT sum(capitalized_in_birr) as capitalized_in_birr FROM capitalized WHERE account = $buyer_account and capitalized_status=4");
                        $capitalized_result = mysqli_fetch_array($capitalized_query);
                        $buyer_capitalized=$capitalized_result?$capitalized_result['capitalized_in_birr']:0;
                          
                        $buyer_share=$buyer_balance+$buyer_capitalized;

                        $seller_account=$rows['seller_account'];
                        $balance_query = mysqli_query($conn,"SELECT * FROM balance WHERE account = $seller_account");
                        $balance_result = mysqli_fetch_array($balance_query);
                        $seller_balance=$balance_result?$balance_result['total_paidup_capital_inbirr']:0;

                        $capitalized_query = mysqli_query($conn,"SELECT sum(capitalized_in_birr) as capitalized_in_birr FROM capitalized WHERE account = $seller_account and capitalized_status=4");
                        $capitalized_result = mysqli_fetch_array($capitalized_query);
                        $seller_capitalized=$capitalized_result?$capitalized_result['capitalized_in_birr']:0;
                         
                        $seller_share=$seller_balance+$seller_capitalized;
                                          ?>
                                <tr>
                                    
                                    <td></td>
                                            	
                                	<td><?php echo $a; ?></td>  

                                    <td><?php echo $rows['seller_account']; ?></td>                                

                                    <td><?php echo number_format($seller_share); ?></td>

                                    <td><?php echo number_format($seller_share- $rows['total_transfered_in_birr']); ?></td>
                                                
                                    <td><?php echo number_format($rows['total_transfered_in_birr']); ?></td>
                                    
                                    <td><?php echo $rows['buyer_account']; ?></td>

                                    <td><?php echo number_format($buyer_share); ?></td>

                                    <td><?php echo number_format($buyer_share+$rows['total_transfered_in_birr']); ?></td>

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
         
