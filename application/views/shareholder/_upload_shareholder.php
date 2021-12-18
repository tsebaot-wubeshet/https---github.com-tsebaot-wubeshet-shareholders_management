	<?php
		$conn=mysqli_connect('localhost','root','','shareholder');
		if (isset($this->session->userdata['logged_in'])) {
			
		$username = $this->session->userdata['logged_in']['username'];
		$userId = $this->session->userdata['logged_in']['id'];
			
		} 
        $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status =1");
        $budget_result = mysqli_fetch_array($budget_query);
        $from="";
        $to="";
        $year=0;
        if($budget_result){
        $from = $budget_result['budget_from'];
        $to = $budget_result['budget_to'];
        $year= $budget_result['id'];
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
									<div class="alert alert-danger alert-dismissable" role="alert">
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
                       				   				    
                         				 <form action="" method="POST" role="form" enctype='multipart/form-data'>
                                        <!-- text input -->
                                        
                                        <!-- textarea -->

                                        <div class="form-group">
                                            <label></label>
                                           
                                        </div>
                                        <?php

if (isset($_POST['submit'])) {

    if (is_uploaded_file($_FILES['filename']['tmp_name'])) {

        echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";

    }

    $handle = fopen($_FILES['filename']['tmp_name'], "r");

 
    while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {

        //$import="INSERT into shareholders (account_no,name,total_share_subscribed,total_paidup_capital_inbirr,city,year,share_type,status,status_of_new_share) values 
        //('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]')";

        $import="INSERT into shareholders (account_no,name,created_date,currentYear_status,nextYear_status,created_year,maker ) values 
        ('$data[0]','$data[1]','$data[2]',4,4,$year,$userId)";
$import2="INSERT into shareholders (account,city,sub_city,woreda,house_no,pobox,telephone_residence,telephone_office,mobile,remark) values 
('$data[0]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]')";


        mysqli_query($conn,$import) or die(mysqli_error($conn));
        mysqli_query($conn,$import2) or die(mysqli_error($conn));
    }

    fclose($handle);

    print "Import done";

    //view upload form

}else {

 
 ?>       
                                        <div class="form-group">
                                            <label>Upload CSV File only</label>
                                            <input type="file" name="filename" class="form-control" placeholder="Enter ..." required/>
                                 			
                                        </div>
                                        	
                                        	
                                        <div class="box-footer">
                                          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                         </div>

       <?php
        }
        ?>  
                                    
                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
                    
             