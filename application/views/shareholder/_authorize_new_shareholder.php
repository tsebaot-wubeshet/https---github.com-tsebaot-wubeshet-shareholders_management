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
<b>Success!</b> Shareholder Authorized Successfully!.
</div>

<?php } ?>
<?php if(isset($_GET['check'])){ ?>

<div class="alert alert-danger alert-dismissable">
<i class="fa fa-ban"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
You have to activate the shareholder first before authorizing the transfer!.
</div>

<?php } ?>

<?php if(isset($_GET['reject'])){ ?>

<div class="alert alert-success alert-dismissable">
<i class="fa fa-ban"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<b>Success!</b> Shareholder data deleted successfully!.
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
    <th>Total share subscribed</th>
    <th>Total paid up capital in birr</th>
    <th>city </th>
    <th>Sub city </th>
    <th>Woreda</th>
    <th>House no </th>
    <th>P.O.Box</th>
    <th>Telephone Residence</th>
    <th>Telephone Office</th>
    <th>Mobile</th>
    <th>Share type</th>
    <th>Member</th>
    <th>Reason</th>
    <th>Status</th>
    <th>Created by</th>
   </tr>
</thead>
<tbody>
<?php
$shareValue_query = mysqli_query($conn,"SELECT * FROM share_value ");
$shareValue_result = mysqli_fetch_array($shareValue_query);
$shareValue=$shareValue_result?$shareValue_result['share_value']:500;

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

$query = mysqli_query($conn,"SELECT * from shareholders left outer join shareholder_address on shareholders.account_no=shareholder_address.account left join balance on shareholders.account_no=balance.account  where shareholders.currentYear_status=3") or die(mysqli_error($conn));

//$query = mysqli_query($conn,"SELECT * from shareholders where 
//status_of_new_share = 'pending' and (year BETWEEN '$from' and '$to')") or die(mysqli_error($conn));
$a = 0;

while ($rows = mysqli_fetch_array($query)) {
    $a = $a + 1;
    $status=$rows['currentYear_status'];
    $status_query = mysqli_query($conn,"SELECT * FROM status where id=$status");
    $status_result = mysqli_fetch_array($status_query);
    $status=$status_result?$status_result['status']:"";

    $maker=$rows['maker'];
    $maker_query = mysqli_query($conn,"SELECT * FROM user_login where id=$maker");
    $maker_result = mysqli_fetch_array($maker_query);
    $maker=$maker_result?$maker_result['fullname']:"";
?>
<tr>
    <td></td>
    <td><input type="checkbox" name="account_no[]" value="<?php echo $rows['account_no'];?>"></td>    
    <td><?php echo $a; ?></td>   
    <td><?php echo $rows['account_no']; ?></td>
    <td><?php echo $rows['name']; ?></td>
    <td><?php echo $rows['total_paidup_capital_inbirr']/$shareValue; ?></td>
    <td><?php echo $rows['total_paidup_capital_inbirr']; ?></td>                                                   
    <td><?php echo $rows['city']; ?></td>
    <td><?php echo $rows['sub_city']; ?></td>
    <td><?php echo $rows['woreda']; ?></td>   
    <td><?php echo $rows['house_no']; ?></td>    
    <td><?php echo $rows['pobox']; ?></td>
    <td><?php echo $rows['telephone_residence']; ?></td>
    <td><?php echo $rows['telephone_office']; ?></td>    
    <td><?php echo $rows['mobile']; ?></td>
    <td><?php echo $rows['share_type']; ?></td>    
    <td><?php echo $rows['member']; ?></td>   
    <td><?php echo $rows['remark']; ?></td>
    <td><?php
        if($rows['currentYear_status'] == 1){

            ?>
            
            <span class="badge bg-blue"><?php echo $status; ?></span>
            
            <?php
            
        } else {
            
            ?>
            
            <span class="badge bg-red"><?php echo $status; ?></span>
            
            <?php
            
            }
            
            ?></td>

     <td><?php echo $maker;?></td>
   <?php } ?>
   
</tr>

</tbody>
                                        
<?php if($role == 3) { ?>      
<fieldset>
<button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
<button type="submit" name="reject" class="btn btn-danger"><i class="glyphicon glyphicon-ok"></i> Reject</button>
</fieldset>

<?php } ?>        <br><br>
</table>

<?php 

if (isset($_POST['authorize'])){

if(!isset($_POST['account_no'])){

    echo '<script>alert("Either data not selected or no data to authorize !");</script>';
} else{

$id=$_POST['account_no'];                                                                                                                                           

$current_date = date('Y-m-d');
                                                     
foreach ($id as $ids) {

   $result = mysqli_query($conn,"UPDATE shareholders SET currentYear_status = 1,nextYear_status = 1,authorization_date = '$current_date',checker = $userId where account_no='$ids'");
   $result = mysqli_query($conn,"UPDATE balance SET balance_status = 1,checker = $userId where account='$ids'");
   header("location:authorize_new_shareholder?authorize=true&from=".$from."&to=".$to."");

}
}
}
?>

<?php 

        if (isset($_POST['reject'])){        
            
            
            if(!isset($_POST['account_no'])){

     echo '<script>alert("Either data not selected or no data to reject !");</script>';
} else{
            $id=$_POST['account_no'];
            $current_date = date('Y-m-d'); 
        foreach($id as $ids){ 

                $result = mysqli_query($conn,"UPDATE shareholders SET currentYear_status = 11,nextYear_status = 11,authorization_date = '$current_date',checker = $userId where account_no='$ids'");
             header("location:authorize_new_shareholder?reject=true".$from."&to=".$to."");    

            


           

    }
}
}
?>

<?php 

?>

</form> 
</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>

</section><!-- /.content -->












