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
                                        <th>Account no</th>
                                        <th>Shareholder Name</th>
                                        <th>Value Date</th>
                                        <th>Cash paid</th>
                                        <th>transfer from</th>
                                        <th>capitalized Type</th>
                                        <th>Status</th>
                                       </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    
                 $query = mysqli_query($conn,"SELECT * from capitalized left join shareholders on capitalized.account=shareholders.account_no where capitalized_status = 3 ") or die(mysqli_error($conn));
                                    
                                    $a = 0;
                                    
                                    while ($rows = mysqli_fetch_array($query)) {
                                        $a = $a + 1;
                                        $status=$rows['capitalized_status'];
                                        $status_query = mysqli_query($conn,"SELECT * FROM status where id=$status");
                                        $status_result = mysqli_fetch_array($status_query);
                                        
                                        $capitalized_type=$rows['type'];
                                        $capitalized_type_query = mysqli_query($conn,"SELECT * FROM capitalized_type where id=$capitalized_type");
                                        $capitalized_type_result = mysqli_fetch_array($capitalized_type_query);

                                        $id = $rows['id'];
                                        
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><input type="checkbox" name="id[]" value="<?php echo $rows['id'];?>"></td>

                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $rows['account']; ?></td>
                                        <td><?php echo $rows['name']; ?></td>
                                        <td><?php echo $rows['value_date']; ?></td>
                                        <td><?php echo $rows['capitalized_in_birr']; ?></td>
                                        <td><?php echo $rows['transfer_from']; ?></td>
                                        <td><?php echo $capitalized_type_result['type']; ?></td>
                                       
                                        <td><?php
                                            if($rows['capitalized_status'] == 3){
                                                
                                                ?>
                                                
                                                <span class="badge bg-red"><?php echo $status_result['status']; ?></span>
                                                
                                                <?php
                                                
                                            } else {
                                                
                                                ?>
                                                
                                                <span class="badge bg-blue"><?php echo $status_result['status']; ?></span>
                                                
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

if (isset($_POST['authorize'])) {

if(!isset($_POST['id'])){

echo '<script>alert("Either data not selected or no data to authorize !");</script>';
} else{

$id = $_POST['id'];

 foreach ($_POST['id'] as $ids) {
      
    $result = mysqli_query($conn,"UPDATE capitalized SET capitalized_status = 4 where id='$ids'");   
   header('location:/shareholder_new/shareholder/authorize_cashpayment?authorize=ok');

}
}
}

if (isset($_POST['reject'])){        

//$account_no = $_POST['selector'];
if(!isset($_POST['id'])){

echo '<script>alert("Either data not selected or no data to reject !");</script>';
} else{


foreach($_POST['id'] as $cap_del){ 
   $result = mysqli_query($conn,"UPDATE capitalized SET capitalized_status = 11 where id='$ids'"); 
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
 











