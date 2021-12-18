<?php
        $conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
        $username = $this->session->userdata['logged_in']['username'];
        $role = $this->session->userdata['logged_in']['role'];  
        } 
?> 
    <?php if(isset($_GET['authorize'])){ ?>
    
        <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Request Authorized Successfully!.
                                    </div>
    
    <?php } ?>

     <?php if(isset($_GET['reject'])){ ?>
    
        <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Request Rejected Successfully!.
                                    </div>
    
    <?php } ?>
    <?php if(isset($_GET['delete'])){ ?>
    
        <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        Request Rejected Successfully!.
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
                                                <th>No.</th>                                                
                                                <th>Account number</th>
                                                <th>Shareholder Name</th>
                                                <th>city </th>
                                                <th>Sub city </th>
                                                <th>Woreda</th>
                                                <th>House no </th>
                                                <th>P.O.Box</th>
                                                <th>Telephone Residence</th>
                                                <th>Telephone Office</th>
                                                <th>Mobile</th>
                                                <th>Member</th>
                                                <th>remark</th>
                                                
                                               </tr>
                                        </thead>
                                        <tbody>
                                          <?php
       

         $query = mysqli_query($conn,"SELECT * from shareholders s left join shareholder_address sa on s.account_no=sa.account where  currentYear_status = 11") or die(mysqli_error($conn));
                                            
                                            $a = 0;
                                            
                                            while ($rows = mysqli_fetch_array($query)) {
                                                $a = $a + 1;
                                                
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><input type="checkbox" name="applist[]" value="<?php echo $rows['account_no'];?>"></td>
                                                <td><?php echo $a; ?></td>
                                               
                                                <td><?php echo $rows['account_no']; ?></td>
                                                <td><?php echo $rows['name']; ?></td>
                                                                                               
                                                <td><?php echo $rows['city']; ?></td>
                                                <td><?php echo $rows['sub_city']; ?></td>
                                                <td><?php echo $rows['woreda']; ?></td>
                                               
                                                <td><?php echo $rows['house_no']; ?></td>
                                                
                                                <td><?php echo $rows['pobox']; ?></td>
                                                <td><?php echo $rows['telephone_residence']; ?></td>
                                                <td><?php echo $rows['telephone_office']; ?></td>
                                                
                                                <td><?php echo $rows['mobile']; ?></td>
                                               
                                                <td><?php echo $rows['member']; ?></td>
                                                <td><?php echo $rows['remark']; ?></td>
                                              
                                         
                                                
                                               <?php } ?>
                                                
                                            </tr>
                                            
                                        </tbody>
                                                                                    
                                <?php if($role == 3) { ?>      
                                    <fieldset>
                                        <button type="submit" name="delete" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Delete</button>
                                        
                                    </fieldset>
 
                                <?php } ?>        <br><br>
                                    </table>

                                    <?php 

                                    if (isset($_POST['delete'])){
                                        if(!isset($_POST['applist'])){
                                       echo "<script>alert('please select from the least!')</script>" ;
                                        }else{
                                        $id=$_POST['applist'];                                                                    
                                        $N = count($id);
                                        $from = $_POST['from'];
                                        $to = $_POST['to'];
                                                                                                    
                                        for($i=0; $i < $N; $i++)
                                        {   
                                            $result = mysqli_query($conn,"DELETE FROM shareholders where account_no='$id[$i]'");
                                            
                                            header("location:rejected_report?delete=true&from=".$from."&to=".$to."");
     
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
         











