	<?php
		
		$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
			
		$username = $this->session->userdata['logged_in']['username'];
        $userId = $this->session->userdata['logged_in']['id'];
			
		} 
        $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
        $budget_result = mysqli_fetch_array($budget_query);
        $from="";
        $to="";
        $year= 0;
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
    //   var_dump($data);
        $import="INSERT into certificate (account,issued_share_certificate,prepared_share_certificate,year,maker) values ('$data[0]','$data[1]','$data[2]',$year,$userId)";

        mysqli_query($conn,$import) or die(mysqli_error($conn));

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
                    
             