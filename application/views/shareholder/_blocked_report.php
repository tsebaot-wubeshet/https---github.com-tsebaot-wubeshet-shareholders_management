<?php
$conn=mysqli_connect('localhost','root','','shareholder');
        if (isset($this->session->userdata['logged_in'])) {
        $username = $this->session->userdata['logged_in']['username'];
        $role = $this->session->userdata['logged_in']['role'];  
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
    if(isset($_GET['reject_block'])){
    ?>
    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Request Rejected Succesfully!</b> 
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

  if(isset($_GET['release_blocked'])){
  
  ?> 
  <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Request Released Succesfully</a>
                                    </div>
  <?php } ?>

                <!-- Main content -->
                <section class="content">
                    <div class="row" style="width:100%">
                        <div class="col-xs-12">
                           <div class="box">
                           <div class="col-xs-2">
                    <form method="POST" action="<?php echo base_url(''); ?>shareholder/blocked_share_excel" id="form">

                        <button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Download Blocked Report</button>

                    </form>
                </div><br><br>
                                
                                <div class="box-body table-responsive">
                                <form action="" method="POST">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Account number</th>
                                                <th>Name</th>
                                                <th>blocked amount</th>
                                                <th>blocked type</th>
                                                <th>Total Paid Up Capital</th>
                                                <th>remark</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                
<?php 
                        $query = mysqli_query($conn,"SELECT b.*, s.name, bl.total_paidup_capital_inbirr from blocked b left join shareholders s on s.account_no = b.account left join balance bl on bl.account = b.account  where blocked_status not in(10,11) and b.year = 1  order by b.id DESC") or die(mysqli_error($conn));
                                            
                                               $a = 0;
                                            
                                            while ($rows = mysqli_fetch_array($query)) {
                                                $a = $a + 1;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $a; ?></td>
                                                
                                                <td><?php echo $rows['account']; ?></td>
                                                <td><?php echo $rows['name']; ?></td>
                                                <td><?php echo $rows['blocked_amount']; ?></td>
                                                <td><?php echo $rows['blocked_type']; ?></td>
                                                <td><?php echo $rows['total_paidup_capital_inbirr']; ?></td>
                                                <td><?php echo $rows['block_remark']; ?></td>
                                                <td>

                                                    <?php
                                                    $blocked_status=$rows['blocked_status'];
                                                     $status_query = mysqli_query($conn,"SELECT * from status where status =$blocked_status") or die(mysqli_error($conn));
                                                     $status_resualt = mysqli_fetch_array($status_query);
                                                      $status=$status_resualt?$status_resualt['status']:"";
                                                    if($rows['blocked_status'] == 7){
                                                        
                                                        ?>
                                                        
                                                        <span class="badge bg-red"><?php echo $status; ?></span>
                                                        
                                                        <?php
                                                        
                                                    } else {
                                                        
                                                        ?>
                                                        
                                                        <span class="badge bg-red"><?php echo $status; ?></span>
                                                        
                                                        <?php
                                                        
                                                        }?>
                                                
                                                
                                                        </td>
                                        

                                               <?php } ?>
                                                
                                            </tr>
                                        </tbody>
       <br><br>
                                    </table>                     
                                    <br><br>
                                    </table>
                                   </form> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         
