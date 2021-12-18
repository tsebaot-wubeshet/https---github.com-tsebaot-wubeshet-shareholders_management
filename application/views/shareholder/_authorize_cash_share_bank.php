<?php
$conn=mysqli_connect('localhost','root','','shareholder');
        if (isset($this->session->userdata['logged_in'])) {
        $username = $this->session->userdata['logged_in']['username'];
        $role = $this->session->userdata['logged_in']['role'];  
        } 
?> 
    <?php if(isset($_GET['authorize'])){ ?>
    
        <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Cash payment Authorized Successfully!.
                                    </div>
    
    <?php } ?>
     <?php

  if(isset($_GET['reject'])){
  
  ?>
  
  <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Cash Payment Rejected Successfully!.
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
                                                <th></th>
                                                <th>No.</th>
                                                <th>Value Date</th>
                                                <th>Cash paid</th>
                                                <th>Shareholder Name</th>
                                               
                                               
                                                <th>Status</th>
                                               </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                            
       $query = mysqli_query($conn,"SELECT * from capitalized where 
        capitalized_status = 'pending' and type = 'cash' and transfer_from = 'Bank'") or die(mysqli_error($conn));
                                            
                                            $a = 0;
                                            
                                            while ($rows = mysqli_fetch_array($query)) {
                                                $a = $a + 1;

                                                $id = $rows['id'];
                                                
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><input type="checkbox" name="applist[]" value="<?php echo $rows['id'];?>"></td>
                                                <td><input type="checkbox" name="selector[]" value="<?php echo $rows['account_no'];?>"></td>

                                                <td><?php echo $a; ?></td>
                                                <td><?php echo $rows['value_date']; ?></td>
                                                <td><?php echo $rows['capitalized_in_birr']; ?></td>
                                                <td><?php echo $rows['name']; ?></td>
                                               
                                                <input type="hidden" name="value_date" value="<?php echo $rows['value_date']; ?>">
                                                <input type="hidden" name="name" value="<?php echo $rows['name']; ?>">

                                                <input type="hidden" name="capitalized_in_share" value="<?php echo $rows['capitalized_in_share']; ?>">
                                                <input type="hidden" name="account_no" value="<?php echo $rows['account_no']; ?>">

                                                <input type="hidden" name="type" value="<?php echo $rows['type']; ?>">
                                                <input type="hidden" name="capitalized_in_birr" value="<?php echo $rows['capitalized_in_birr']; ?>">
                                                <input type="hidden" name="year" value="<?php echo $rows['year']; ?>">
                                                <input type="hidden" name="capitalized_status" value="<?php echo $rows['capitalized_status']; ?>">

                                                <input type="hidden" name="cap" value="<?php echo $rows['capitalized_in_birr']; ?>">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <td><?php
                                                    if($rows['capitalized_status'] == 'pending'){
                                                        
                                                        ?>
                                                        
                                                        <span class="badge bg-red"><?php echo $rows['capitalized_status']; ?></span>
                                                        
                                                        <?php
                                                        
                                                    } else {
                                                        
                                                        ?>
                                                        
                                                        <span class="badge bg-blue"><?php echo $rows['capitalized_status']; ?></span>
                                                        
                                                        <?php
                                                        
                                                        }
                                                        
                                                        ?></td>
                                            
                                                
                                               <?php } ?>
                                                
                                            </tr>
                                            
                                        </tbody>
                                                                                    
                                <?php if($role == 3){ ?>      
                                  
                                  <fieldset>
                                    <button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
                                    <button type="submit" name="reject" class="btn btn-danger"><i class="glyphicon glyphicon-ok"></i> Reject</button>
                                </fieldset>

                                <?php } ?>        <br><br>
                                    </table>

                                 


        <?php 

        if (isset($_POST['authorize'])){

        $N = count($_POST['applist']);

        $id = $_POST['applist'];
        
        $account_no = $_POST['selector'];

        for($i=0; $i < $N; $i++)
        {
        
        $query_cap = mysqli_query($conn,"SELECT * from capitalized where 
            capitalized_status = 'pending' and type = 'cash' and transfer_from = 'Bank' AND id = '$id[$i]'") or die(mysqli_error($conn));
        
        $row_cap = mysqli_fetch_array($query_cap);

        $capitalized_in_birr = $row_cap['capitalized_in_birr'];
        $capitalized_in_share = ($capitalized_in_birr/500);       

                      
            $result1 = mysqli_query($conn,"UPDATE shareholders set total_share_subscribed = total_share_subscribed + $capitalized_in_share,total_paidup_capital_inbirr = total_paidup_capital_inbirr + '$capitalized_in_birr' where account_no='$account_no[$i]'") or die(mysqli_error($conn));

            $result = mysqli_query($conn,"UPDATE capitalized SET capitalized_status = 'authorized' where id='$id[$i]'");
            
           header('location:/shareholder_new/shareholder/authorize_cashpayment?authorize=ok');
 
    }
}
        ?>

                                   
    <?php 

        if (isset($_POST['reject'])){        
        
        //$account_no = $_POST['selector'];
        

        foreach($_POST['applist'] as $cap_del){

            //$id=$_POST['applist'];  

            $id = array();
            array_push($id, $cap_del);
          
            $N = count($id);
            
            $query_cap = mysqli_query($conn,"SELECT * from capitalized where 
            capitalized_status = 'pending' AND type = 'cash' AND id = '$cap_del'") or die(mysqli_error($conn));
        
            $row_cap1 = mysqli_fetch_array($query_cap);
            $value_date = $row_cap1['value_date'];

            $capitalized_in_birr = $row_cap1['capitalized_in_birr'];
            $capitalized_in_share = $row_cap1['capitalized_in_share'];
            $name = $row_cap1['name'];
            $account_no2 = $row_cap1['account_no'];
            $type = $row_cap1['type'];
            $year = $row_cap1['year'];
            $capitalized_status = $row_cap1['capitalized_status'];
            

        for($i=0; $i < $N; $i++)
        {   

           $result_cap = mysqli_query($conn,"INSERT INTO rejected_capitalized (value_date,capitalized_in_birr,capitalized_in_share,name,account_no,type,year,capitalized_status) VALUES ('$value_date','$capitalized_in_birr','$capitalized_in_share','$name','$account_no2','$type','$year','$capitalized_status')") or die(mysqli_error($conn));
           
           $result_delete = mysqli_query($conn,"DELETE FROM capitalized WHERE capitalized_status = 'pending' AND id='$cap_del'") or die(mysqli_error($conn));

           header('location:authorize_cashpayment?reject=true');

        }
    }
}
        ?>

                           
                                   </form> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         











