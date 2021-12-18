<?php
        $conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
        
        $username = $this->session->userdata['logged_in']['username'];
        $role = $this->session->userdata['logged_in']['role'];  
            
        } 
?> 
    <?php if(isset($_GET['pledged'])){ ?>
    
        <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Shareholder pledged Successfully!.
                                    </div>
    
    <?php } ?>
    <?php if(isset($_GET['pledged_rejected'])){ ?>
    
        <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Pledge Request Rejected Successfully!.</b>
                                    </div>
    
    <?php } ?>
     <?php if(isset($_GET['pledged_release'])){ ?>
    
        <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Pledge Request Released Successfully!.</b>
                                    </div>
    
    <?php } ?>
                <!-- Main content -->
                <section class="content">
                     <div class="row" style="width:100%">
                        <div class="col-xs-12">
                           <div class="box">
                           <div class="col-xs-2">
                    <form method="POST" action="<?php echo base_url(''); ?>shareholder/pledged_share_excel" id="form">

                        <button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Download Pledged Report</button>

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
                                                <th>Pledged Amount</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                               </tr>
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
       $query = mysqli_query($conn,"SELECT p.*, s.name FROM pludge p left join shareholders s on s.account_no = p.account WHERE pledged_status = 6 order by year DESC") or die(mysqli_error($conn));
                                            
                                            $a = 0;
                                            
                                            while ($rows = mysqli_fetch_array($query)) {
                                                $a = $a + 1;
                                                
                                            ?>
                                            <tr>

                                                
                                                <td><?php echo $a; ?></td>
                                                
                                                <td><?php echo $rows['account']; ?></td>
                                                <td><?php echo $rows['name']; ?></td>
                        
                                                <td><?php echo number_format($rows['pledged_amount'],2);?></td>
                                                <td><?php echo $rows['pledged_reason']; ?></td>
                                                <td>
                                                        <span class="badge bg-red"><?php echo "pledged"; ?></span>
                                             </td>
                                            
                                            
                                                  <?php } ?>
                                                
                                            </tr>
                                            
                                        </tbody>
                                   
                                                       
                                        <br><br>
                                    </table>
                   </form> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         
                                   