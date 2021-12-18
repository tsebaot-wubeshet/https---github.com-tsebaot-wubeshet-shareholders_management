    <?php echo $this->load->view('layouts/header1');?>
    
    <body class="skin-blue">
        
		<?php echo $this->load->view('shareholder/menu');?>
                  
                  </section>
           </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Transfer
                      
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">transfer</a></li>
                      
                    </ol>
                </section> 

                <!-- Main content -->
<section class="content">

<section class="content-header">
                    <h1>
					
				<?php 

                	$no = $_GET['no'];
				    
					$query = mysqli_query($conn,"select * from transfer where rsc_no= '$no' group by rsc_no") or die(mysqli_error($conn));
					
					while($row = mysqli_fetch_array($query)){
					
					?>
					
                        <!--No. -->
                        <small><?php //echo $row['number']; ?></small>
                    </h1>

                </section>

                <section class="content invoice">                    
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                        	<img src="<?php echo base_url('public/img/logo.jpg');?>" width="300px" height="80px"> <!--AdminLTE, Inc. -->
                                
                            <h2 class="page-header">
                                <i class="fa"></i> Share Transfer Slip
                                <small class="pull-right">Date: <?php echo date('d/m/Y'); ?><?php echo $row['transfer_date']; ?></small>
                            </h2>                            
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Share Transfer From
                            <address>
                                <strong><?php echo $row['name']; ?></strong><br>
                                account number, <?php echo $row['account_no']; ?><br>
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong><?php echo $row['rname']; ?></strong><br>
                                account number, <?php echo $row['raccount_no']; ?><br>
                                
                            </address>
                        </div><!-- /.col -->
                        
                    </div><!-- /.row -->
 				<?php
                    }
                    //}
                    ?>
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Value Date</th>
                                        <th>Particulars</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>No of Shares</th>
                                        <th>Per value</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                    <?php 

                	$no = $_GET['no'];
				    
					$query = mysqli_query($conn,"select * from transfer where rsc_no= '$no'") or die(mysqli_error($conn));
					
					while($row = mysqli_fetch_array($query)){
					
					?>
                                    <tr>
                                        <td><?php echo $row['transfer_date']; ?></td>
                                        <td>Call of Duty</td>
                                        <td><?php echo $row['account_no']; ?></td>
                                        <td><?php echo $row['debit']; ?></td>
                                        <td><?php echo $row['credit']; ?></td>
                                        <td><?php echo number_format($row['balance'],2); ?></td>
                                        <td>No of Shares</td>
                                        <td>$64.50</td>
                                    </tr>
                       <?php } ?>
                                </tbody>
                            </table>                            
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
                            
                             Prepared by 
                                 - <br><br> Name: ______________________________<br><br>
                            
                                            Signature: _______________________
                       </br></br>
                                            
                        </div><!-- /.col -->
                        <div class="col-xs-6">
                           Checked by 
                                 - <br><br> Name: ______________________________<br><br>
                            
                                            Signature: _______________________
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                   
                
                
                
                
                
                <section class="content invoice">                    
                    <!-- title row -->
			
 <div class="row">
                   
                                <!-- this row will not appear when printing -->
                                <br>


                    <div class="row no-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onClick="window.print();"><i class="fa fa-print"></i> Print</button>
                            <!--<button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>  
                            <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button> -->
                        </div>
                    </div>
                </section><!-- /.content -->
           

 
                    <div class="row">
                        <!-- left column -->
                      
                 	<?php echo $this->load->view('shareholder/_printslip'); ?>
                                 
               </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        
       <?php echo $this->load->view('layouts/footer');?>

   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   