<?php 
if (isset($this->session->userdata['logged_in'])) {
            
        $username = $this->session->userdata['logged_in']['username'];
            
         
        } 
?>
<section class="content-header">
                    <h1>
					
				<?php 

                $no = $_GET['no'];
				    
					$query = mysqli_query($conn,"select * from share_request where registration_no= '$no'") or die(mysqli_error($conn));
					
					while($row = mysqli_fetch_array($query)){
					
					?>
				
                        <small><?php //echo $row['number']; ?></small>
                    </h1>
					
					
					
                    <!--<ol class="breadcrumb">
                        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Print</a></li>
                        
                    </ol> -->
                </section>

               <!-- <div class="pad margin no-print">
                    <div class="alert alert-info" style="margin-bottom: 0!important;">
                        <i class="fa fa-info"></i>
                        <b>Note:</b> This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                    </div>
                </div> -->

                <!-- Main content -->
                <section class="content invoice">                    
                    <!-- title row -->
					
                    <div class="row">
                        <div class="col-xs-12">
                            
                                <!--AdminLTE, Inc. -->
                               
                                <!--<i class="fa fa-globe"></i> --><img src="<?php echo base_url('public/img/logo.jpg');?>" width="300px" height="80px"> <!--AdminLTE, Inc. -->
                                <small class="pull-right">Date: <?php echo date('d/m/Y'); ?>-<?php echo $row['application_time']; ?></small>
                           
                                                     
                        </div><!-- /.col -->
                    </div>
					
					<br><br>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-3 invoice-col">
                            <!--From
                            <address>
                                <strong>Admin, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                Phone: (804) 123-5432<br/>
                                Email: info@almasaeedstudio.com
                            </address> -->
                        </div><!-- /.col -->
                        <div class="col-sm-26 invoice-col" style="font-size:18px;text-decoration:underline" >
                            Share Request Slip
                            <!--<address>
                                <strong>John Doe</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                Phone: (555) 539-1037<br/>
                                Email: john.doe@example.com
                            </address> -->
                        </div><!-- /.col -->
                        
                    </div><!-- /.row -->
						
					
					<br>
                   
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6" style=" font-size:13px;margin-left: 30px;">
                           <!-- <p class="lead">Payment Methods:</p> -->
                           <b>Registration No. <?php echo $row['registration_no']; ?></b><br/><br>
                      	
                            Date of Application: <?php echo $row['application_date']; ?><br>
							
							Name of Applicant: <?php echo $row['full_name']; ?><br>

                            Share Requested: <?php echo $row['total_share']; ?><br>
							
							Mobile No <?php echo $row['mobile_no']; ?><br><br>

                            Status <?php echo $row['status']; ?><br><br>
     
     
                        </div><!-- /.col -->
						
                        <div class="col-xs-5" style="font-size:13px">
                            <!--<p class="lead">Amount Due 2/22/2014</p> -->
                           
							Share officer
								 - <br><br> Name: ______________________________<br><br>
							
											Signature: _______________________
                        </div><!-- /.col -->
                    </div><!-- /.row -->
				<br>


                   
                    <?php
                    }
                    //}
                    ?>
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
           

 