<?php
$conn=mysqli_connect('localhost','root','','shareholder');
if (isset($this->session->userdata['logged_in'])) {    
$username = $this->session->userdata['logged_in']['username'];
$role = $this->session->userdata['logged_in']['role'];

} 
else {
    header("location:/shareholder_new/user_authentication/user_login_process");
    }
?> 
<style type="text/css">
#homepage_search{
margin-left: 400px;
}
#homepage_search_btn{
margin-left:200px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
$("#myRelease").modal('show');
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#myPledged").modal('show');
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#myReleaseblock").modal('show');
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#myModal").modal('show');
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#myAuthorize").modal('show');
});
</script>

<div id="myModal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Info</h4>
</div>
<div class="modal-body">
<div class="alert alert-danger alert-dismissable" role="alert" align="center">

You can't transfer Share , Shareholder Blocked!                        
</div>                
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>
</div>
</div>
<div id="myAuthorize" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Info</h4>
</div>
<div class="modal-body">
<div class="alert alert-danger alert-dismissable" role="alert" align="center">

Authorize the transfer first.                       
</div>                
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>
</div>
</div>
<div id="myReleaseblock" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Info</h4>
</div>
<div class="modal-body">
<div class="alert alert-danger alert-dismissable" role="alert" align="center">

Blocked Request waiting for Authorization                        
</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>
</div>
</div>
<div id="myRelease" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Info</h4>
</div>
<div class="modal-body">
<div class="alert alert-danger alert-dismissable" role="alert" align="center">

Pledged Release waiting for Authorization

</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>
</div>
</div>
<?php

if(isset($_GET['release_blocked_share'])){

?>

<div class="alert alert-success alert-dismissable">
<i class="fa fa-ban"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<b>Request sent to authorization</a>
</div>

<?php } ?>
<div id="myPledged" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Info</h4>
</div>
<div class="modal-body">
<div class="alert alert-danger alert-dismissable" role="alert" align="center">

You can't pledge Share , Shareholder Blocked!

</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>
</div>
</div>
</div>
<script language="javascript" type="text/javascript">

function popitup(url) {
newwindow=window.open(url,'name','height=600,width=1300');
if (window.focus) {newwindow.focus()}
return false;
}

// -->
</script>
<?php

if(isset($_GET[1])){

?>

<div class="alert alert-success alert-dismissable">
<i class="fa fa-ban"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<b>Success!</b> Shareholder Released Successfully!.
</div>

<?php } ?>

<?php

if(isset($_GET[5])){

?>

<div class="alert alert-success alert-dismissable">
<i class="fa fa-ban"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<b>Success!</b> Shareholder Blocked Successfully!.
</div>

<?php } ?>

<?php

if(isset($_GET['dividend'])){

?>

<div class="alert alert-success alert-dismissable">
<i class="fa fa-ban"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<b>Success!</b> Dividend Capitalized!.
</div>

<?php } ?>
<?php if($role == 'user'){?>
<!-- Main content -->
<div id="createshareholder"><a href="<?php echo base_url();?>shareholder/choose_shareholder" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create New Shareholder</a></div>
<?php } ?>
<?php

/*$query = mysqli_query($conn,"SELECT *,count(id) from shareholders where status = 1") or die(mysqli_error($conn));

while($row = mysqli_fetch_array($query)){*/

?>

<?php //echo $row['count(id)']; } ?>

<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="col-xs-2">

<form method="POST" action="<?php echo base_url('');?>shareholder/shareholder_excel" id="form">

<button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Download Shareholder Data</button>

</form>
</div>
<div id="homepage_search">

<form method="post" action=""><br>

<?php echo $this->load->view('shareholder/year1'); ?><br>                          

<div class="col-xs-6">
<label for="ex3">Please Enter Account No or Shareholder name </label>
<input class="form-control" id="ex3" type="text" name="key"><br/>
<button type="submit" name="search" id="homepage_search_btn" class="btn btn-primary btn-sm">Search</button>

</div>
<div class="col-xs-6">
</div>                           

</form>

</div>

<div class="box-body table-responsive">
<form action="" method="POST">                               

<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <th></th>                                              
    <th>No.</th>                                               
    <th>Account number</th>
    <th>Shareholder Name</th>
    <th>Total share subscribed</th>
    <th>Total paid up capital in birr</th>
    <th></th>
    <th></th>
    <?php if($role == 2){?>
    <th></th>
    <th></th>
    <th></th>
    <?php } if($role == 3){?>
        <th></th>
        <?php }?>
    </tr>
</thead>
<tbody>

<?php

if(isset($_POST['search'])){


$budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
$budget_resualt = mysqli_fetch_array($budget_query);

$from="";
$to="";
$year=0;
if($budget_resualt){
$from = $budget_resualt['budget_from'];
$to = $budget_resualt['budget_to'];
$year=$budget_resualt['id'];
}

$key = $_POST['key'];

if($key){
$query = mysqli_query($conn,"SELECT * from shareholders where  currentYear_status = 1 AND name LIKE '$key%' || account_no LIKE '$key%'") or die(mysqli_error($conn));
}else{
    $query = mysqli_query($conn,"SELECT * from shareholders where  currentYear_status  = 1 ") or die(mysqli_error($conn));
    
}
$a = 0;
$shareValue_query = mysqli_query($conn,"SELECT * from share_value") or die(mysqli_error($conn));
$shareValue_resualt = mysqli_fetch_array($shareValue_query);
$shareValue=$shareValue_resualt?$shareValue_resualt['share_value']:0;
while ($rows = mysqli_fetch_array($query)) {
    
$a = $a + 1;

$acct = $rows['account_no'];

$blocked_query = mysqli_query($conn,"SELECT count(id)  from blocked where account = '$acct' and blocked_status in (5,8) ") or die(mysqli_error($conn));
$blocked_resualt = mysqli_fetch_array($blocked_query);


$pledge_query = mysqli_query($conn,"SELECT count(id) from pludge where account = '$acct' and pledged_status in (6,9)") or die(mysqli_error($conn));
$pledge_resualt = mysqli_fetch_array($pledge_query);

$query2 = mysqli_query($conn,"SELECT * from allotment where account = '$acct' order by id ASC") or die(mysqli_error($conn));
$rows2 = mysqli_fetch_array($query2);
$allotment_update=$rows2?$rows2['allotment_update']:0;

$balance_query = mysqli_query($conn,"SELECT total_paidup_capital_inbirr from balance where account = '$acct' and year=$year") or die(mysqli_error($conn));
$balance_resualt = mysqli_fetch_array($balance_query);
$balance=$balance_resualt?$balance_resualt['total_paidup_capital_inbirr']:0.00;
$share_subscribed=0;
if($shareValue){
    $share_subscribed=$balance/$shareValue;
}
?>
<tr>

<td></td>
    <td><?php echo $a; ?></td>
    
    <td><?php echo $rows['account_no']; ?></td>
    <td><?php echo $rows['name']; ?></td>
    <td><?php echo $allotment_update+ $share_subscribed; ?></td>    
    <td><?php echo number_format($balance); ?></td>  
    <td><a href="<?php echo base_url();?>shareholder/viewdetail?id=<?php echo $rows['account_no']; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/viewdetail?id=<?php echo $rows['account_no']; ?>')">View detail</td>
        
                                                        
    <?php if($role == 2) { ?>
    <td>

        <?php

       if($share_subscribed == 0) { ?>

        Transfer

        <?php }  else { ?>
        
        <a href="<?php echo base_url();?>shareholder/transfer?id=<?php echo $rows['account_no']; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/transfer?id=<?php echo $rows['account_no']; ?>')">Transfer</a>
    
    </td>
    
    <?php } ?>
    <td>
    <?php
  
   if($blocked_resualt['count(id)'] > '0'){       
       ?>
         <a href="<?php echo base_url();?>shareholder/blockconfirm?id=<?php echo $rows['account_no']; ?>">
            <span class="badge bg-red"> blocked </span>
         </a>
        <a href="<?php echo base_url();?>shareholder/release_blocked_share?acct=<?php echo $rows['account_no']; ?>">
            <span class="badge bg-info"> release </span>
        </a>

<?php } else { ?> 

            <a href="<?php echo base_url();?>shareholder/blockconfirm?id=<?php echo $rows['account_no']; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/blockconfirm?id=<?php echo $rows['account_no']; ?>')" onClick="deleteImage(<?php echo $rows['id']; ?>)">
           block
         </a>
        <?php } ?> 
        </td>
    <td>
 
<?php

if($pledge_resualt['count(id)'] > '0'){ ?>

    <a href="<?php echo base_url();?>shareholder/pledgeconfirm?id=<?php echo $rows['account_no']; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/pledgeconfirm?id=<?php echo $rows['account_no']; ?>')">
            <span class="badge bg-blue"> Pledge</span>
        </a>
      <a href="<?php echo base_url();?>shareholder/release_pledge?acct_no=<?php echo $rows['account_no']; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/release_pledge?acct_no=<?php echo $rows['account_no']; ?>')">
      <span class="badge bg-info"> Release</span>
      </a>

<?php }  else {  ?>

        <a href="<?php echo base_url();?>shareholder/pledgeconfirm?id=<?php echo $rows['account_no']; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/pledgeconfirm?id=<?php echo $rows['account_no']; ?>')">

        Pledge
    </a>

        <?php }  ?>

        </td>
        
     <?php }?>
     <td><a href="<?php echo base_url();?>shareholder/statement?acct=<?php echo $rows['account_no']; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/statement?acct=<?php echo $rows['account_no']; ?>')">Statement</a></td>  
     <?php if($role==3){?>  
    <td><a href="<?php echo base_url();?>shareholder/edit_shareholder?acc=<?php echo $rows['account_no']; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/edit_shareholder?acc=<?php echo $rows['account_no']; ?>')">Edit</a></td>                               
        <?php }?>
    </tr>
<?php }} ?>
</tbody>
<tfoot>
        <tr >
            <td></td>
            <td></td>
            <td></td>
            <td align="right">Total subscribed in birr</td>
            <td>
<?php
    $balance = mysqli_query($conn,"SELECT sum(total_paidup_capital_inbirr) from balance") or die(mysqli_error($conn));
    $balance_resualt = mysqli_fetch_array($balance);
    $total_balance=$balance_resualt?$balance_resualt['sum(total_paidup_capital_inbirr)']:0;
    
     $shareValue_query = mysqli_query($conn,"SELECT * from share_value") or die(mysqli_error($conn));
     $shareValue_resualt = mysqli_fetch_array($shareValue_query);
     $shareValue=$shareValue_resualt?$shareValue_resualt['share_value']:0;
     $subscribe_total=0;
     if($shareValue){
        $subscribe_total=$total_balance/$shareValue;
     }
    $allt = mysqli_query($conn,"SELECT sum(allotment) from allotment") or die(mysqli_error($conn));
    $allt_total = mysqli_fetch_array($allt);
    $allt_total =$allt_total?$allt_total['sum(allotment)']:0;
    $total_subscr = $allt_total*$shareValue+$total_balance;
    echo number_format($total_subscr,2);
?>
</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td align="right">Paid up capital</td>
            <td>
<?php
    echo number_format($total_balance,2); 
?>
</td>
            <td> </td>
            <td> </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>                                                    
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td align="right">Unpaid balance</td>
            <td>
            <?php             
$unpaid_balance=$total_subscr -$total_balance;
echo number_format($unpaid_balance);

?>
</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>            
                                    
</tfoot>
</table>
</form> 
</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>

</section><!-- /.content -->

