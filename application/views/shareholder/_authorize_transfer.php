<?php
$conn=mysqli_connect('localhost','root','','shareholder');
if (isset($this->session->userdata['logged_in'])) {
$username = $this->session->userdata['logged_in']['username'];
$role = $this->session->userdata['logged_in']['role'];  
$userId= $this->session->userdata['logged_in']['id']; 
} 
?> 

<?php if(isset($_GET['authorize'])){ ?>

<div class="alert alert-success alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Success!</b>  Transfer Authorized Successfully!.
    </div>

<?php } ?>
<?php if(isset($_GET['check'])){ ?>

<div class="alert alert-success alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        You have to activate the new shareholder first 
    </div>

<?php } ?>
<?php

if(isset($_GET['reject'])){

?>

<div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b></b> Transfer Rejected Succesfully!.
    </div>

<?php } ?>



<!-- Main content -->
<section class="content">
<div class="row">
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
                <th>Seller Account number</th>
                <th>Seller Name</th>
                <th>Total Share Transfered</th>
                <th>Buyer Account number</th>
                <th>Buyer Name</th>
                <th>Value Date</th>
                <th>Agreement type</th>
                <th>Kind of transfer</th>
                <th>is Full transfer</th>
                <th>Status</th>
               
               </tr>
        </thead>
        <tbody>
            <?php

                  
            $query = mysqli_query($conn,"SELECT * from transfer where  status_of_transfer = 3 ") or die(mysqli_error($conn));
                        
            $a = 0;
            
            while ($rows = mysqli_fetch_array($query)) {
                $a = $a + 1;
                $seller=$rows['seller_account'];
                $seller_query = mysqli_query($conn,"SELECT name from shareholders where  account_no = $seller") or die(mysqli_error($conn));
                $seller_result = mysqli_fetch_array($seller_query);
                $buyer=$rows['buyer_account'];
                $buyer_query = mysqli_query($conn,"SELECT name from shareholders where  account_no = $buyer") or die(mysqli_error($conn));
                $buyer_result = mysqli_fetch_array($buyer_query);

                $agreement=$rows['agreement'];
                $agreement_query = mysqli_query($conn,"SELECT * from agreement where  id = $agreement") or die(mysqli_error($conn));
                $agreement_result = mysqli_fetch_array($agreement_query);

                $transfer=$rows['transfer_type'];
                $transfer_query = mysqli_query($conn,"SELECT * from transfer_type where  id = $transfer") or die(mysqli_error($conn));
                $transfer_result = mysqli_fetch_array($transfer_query);
                
                $status=$rows['status_of_transfer'];
                $status_query = mysqli_query($conn,"SELECT * FROM status where id=$status");
                $status_result = mysqli_fetch_array($status_query);
            ?>
            <tr>

                <td><input type="checkbox" name="id[]" value="<?php echo $rows['id']; ?>"></td>
                
                <td><!--<input type="Checkbox" name="applist[]" value="<?php //echo $rows['id'];?>">--></td>

                <td><?php echo $a; ?></td>
                
                <td><?php echo $rows['seller_account']; ?></td>
                <td><?php echo $seller_result['name']; ?></td>
                <td><?php echo $rows['total_transfered_in_birr']; ?></td>
                <td><?php echo $rows['buyer_account']; ?></td>            
                <td><?php echo $buyer_result['name']; ?></td>                
                <td><?php echo $rows['value_date']; ?></td>
                <td><?php echo $agreement_result['agreemen_type']; ?></td>                
                <td><?php echo $transfer_result['transfer_type']; ?></td>
                <td><?php echo $rows['full_transfer']?"Yes":"No"; ?></td>
                <td><?php
                    if($rows['status_of_transfer'] == 1){
                        
                        ?>
                        
                        <span class="badge bg-blue"><?php echo $status_result['status']; ?></span>
                        
                        <?php
                        
                    } else {
                        
                        ?>
                        
                        <span class="badge bg-red"><?php echo $status_result['status']; ?></span>
                        
                        <?php
                        
                        }
                        
                        ?></td>
               
                
               <?php } ?>
                
            </tr>
            
        </tbody>
                                                    
<?php if($role ==3){?>      
  <fieldset>
<button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
 <button type="submit" name="reject" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Reject</button>
</fieldset>
<?php } ?>        <br><br>
    </table>



    <?php
                        
 if (isset($_POST['authorize'])){
     if(isset($_POST['id'])){
        $id = $_POST['id'];
        foreach ($_POST['id'] as $ids) {            
      
            $result4 = mysqli_query($conn,"UPDATE transfer SET status_of_transfer = 4, checker=$userId where id='$ids'")or die(mysqli_error($conn));        
            }     
        header("location:authorize_transfer?authorize=true&from=".$from.'&to='.$to);
    }else{
        echo "<script>alert('please select!')</script>";
        }

}                                 
?>
<?php 

if (isset($_POST['reject'])){
            if(isset($_POST['id'])){
                $id = $_POST['id'];
                foreach ($_POST['id'] as $ids) {            
              
                    $result4 = mysqli_query($conn,"UPDATE transfer SET status_of_transfer = 11, checker=$userId where id='$ids'")or die(mysqli_error($conn));        
                    }     
                header("location:authorize_transfer?authorize=true&from=".$from.'&to='.$to);
            }else{
                echo "<script>alert('please select!')</script>";
                }
            }
?>
</form> 
</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>

</section><!-- /.content -->