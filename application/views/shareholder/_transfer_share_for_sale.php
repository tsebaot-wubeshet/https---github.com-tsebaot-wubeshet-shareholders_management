  <?php
$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {     
      $username = $this->session->userdata['logged_in']['username'];
    } 
  ?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#myModal").modal('show');
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
                       
                          The transfered paid up share amount must be less or equal to the seller paid up capital
                        
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>


<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","<?php echo base_url();?>shareholder/getusers?q="+str,true);
        xmlhttp.send();
    }
}
</script>

<script type="text/javascript">

        function validateForm() {
            
            var a = parseInt(document.forms["myForm"]["t_seller_paidup"].value);

            var b = parseInt(document.forms["myForm"]["howmany"].value);

            if (b > a) {

                bootbox.alert(" Transfer not allowed. The transfered share amount must be less than the seller paid up or please check the pledged amount");
 
                return false;
            }
        }

</script>
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

<?php if(isset($_GET['transfer'])){ ?>

<div class="alert alert-danger alert-dismissable" role="alert">
    Share transfered sent succesfully for authorization
</div>

<?php } ?>

                       
<form action="" method="POST" role="form" name="myForm" id="myForm" onSubmit="return validateForm()">
                    
<?php
//$this->load->view('shareholder/year');

  
if(isset($_GET['id'])){
                    
$id = $_GET['id'];
$from = $_GET['from']; 
$to = $_GET['to'];   

$result = mysqli_query($conn,"SELECT * FROM shareholders");

while($row = mysqli_fetch_array($result))
{

$acct =$_GET['id'];
$year = date('Y');                          
$query2 = mysqli_query($conn,"SELECT * from allotment where account_no = '$acct' and allot_year = '$year' order by id ASC") or die(mysqli_error($conn));                         
$rows2 = mysqli_fetch_array($query2);
$query4 = mysqli_query($conn,"SELECT *,sum(pledged_amount) from pludge where account_no = '$acct' and pledged_status = 'pledged' AND year = '$year' order by id ASC") or die(mysqli_error($conn));                         
$rows4 = mysqli_fetch_array($query4);     

  ?>
<div class="form-group">
    
    <label>Transfer From </label>
    <input type="text" required readonly name="name" autofocus class="form-control" value="<?php echo $row['name']; ?>">
    <input type="hidden" name="total_share_of_seller" class="form-control" value="<?php echo $row['total_share_subscribed']; ?>">
    <input type="hidden" name="seller_paidup" class="form-control" value="<?php echo $row['total_paidup_capital_inbirr']; ?>">
    
    <?php echo form_error('from'); ?>

</div>
    
    <div class="form-group">
        <label>Total Subscribed Share</label>
        
        <input type="hidden" readonly required name="pledged_amount" value="<?php echo $rows4['sum(pledged_amount)']; ?>" class="form-control" placeholder="Enter ..."/>

        <input type="hidden" readonly required name="t_seller_paidup" value="<?php $t_paid_up = ($row['total_paidup_capital_inbirr'] / 500);
        $t_calc = ($t_paid_up - $rows4['sum(pledged_amount)']); echo $t_calc; ?>" class="form-control" placeholder="Enter ..."/>

        <input type="text" readonly required name="total_share_subscribed" value="<?php echo $row['total_share_subscribed'] + $row['allot'];?>" class="form-control" placeholder="Enter ..."/>
    <?php echo form_error('total_share_subscribed'); ?>
    </div>
   
     <div class="form-group">
        <label>Account No</label>
        <input type="text" readonly required name="account_no" value="<?php echo $row['account_no']; ?>" class="form-control" placeholder="Enter ..."/>
    <?php echo form_error('account_no'); ?>
    </div>
    <div class="form-group">
        <label>Allotment</label>
         <input type="text" readonly name="allot" class="form-control" value="<?php echo $row['allot']; ?>">

    </div>
<div class="form-group">
        
        <label>Transfer to</label> 
        <select name="account_noof_buyyer" required class="form-control" onchange="showUser(this.value)">
          <option value="">Select Name of Shareholder</option>
<?php
 
$name = $row['name'];
$result = mysqli_query($conn,"SELECT * FROM shareholders where status != 2 AND (year BETWEEN '$from' and '$to') group by name order by account_no");
while($row2 = mysqli_fetch_array($result))
  {
    echo '<option value="'.$row2['account_no'].'">';
    echo $row2['account_no']." - ".$row2['name'];
    echo '</option>';
  }
  ?>
  </select>
  </div>
 <?php } } ?> 
<div id="txtHint"></div>
<div class="form-group">
      <label>Per Value</label>
      <input type="text" required readonly name="per_value" value="500" class="form-control" placeholder="Enter ..."/>
  <?php echo form_error('per_value'); ?>
</div>                                       
<div class="form-group">
      <label>How many paidup shares to be transfered</label>
      <input type="text" required onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="howmany" value="<?php echo set_value('howmany'); ?>" class="form-control" placeholder="Enter ..."/>
<?php echo form_error('howmany'); ?>
</div>

<div class="form-group">
    <label> Date:</label>
    <input type="text" onKeyPress="return event.charCode > 47 && event.charCode < 58;" required class="tcal" value="<?php echo set_value('transfer_date'); ?>" name="transfer_date">
   </div>
<?php echo form_error('transfer_date'); ?>

<label>Dividend Agreement</label>
<div class="form-group">
                  
                 <div class="radio">
                    <label>
                      <input type="radio" checked name="agreement" value="buyer">
                      For Buyer
                    </label>
                  </div>
                 
<label>Kind of transfer</label>
<div class="form-group">
                  <div>
                    <label>
                      <input type="radio" name="tt" value="sale" required>
                      Sale
                    </label>
                  </div>
                 <div>
                    <label>
                      <input type="radio" name="tt" value="heir">
                      Heir
                    </label>
                  </div>
                  <div>
                    <label>
                      <input type="radio" name="tt" value="court">
                      Court
                    </label>
                  </div>
                   <div>
                    <label>
                      <input type="radio" name="tt" value="other">
                      Other
                    </label>
                  </div>
                </div>

                <input type="hidden" name="ag_year" value="<?php $month = 8; $year = date('Y');

  echo date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year)); ?>">
</div>  
   <input type="hidden" readonly="" value="<?php echo $username;?>" name="blocked_by" class="form-control"/>
   <input type="hidden" readonly="" value="<?php echo $_GET['id'];?>" name="id" class="form-control"/>

<div class="box-footer">
    <button type="submit" class="btn btn-primary" name="submit">Transfer Share</button>
</div>
            
<?php 
if(isset($_POST['submit'])){
                    
  $id = $_POST['id'];

  $seller_share = $_POST['total_share_of_seller'];

  $buyyer_account_no = $_POST['account_noof_buyyer'];

  $per_value = $_POST['per_value'];

  $howmany = $_POST['howmany'];

  $blocked_by = $_POST['blocked_by'];

  $account_no = $_POST['account_no'];

  $name = $_POST['name'];

  $rtotal_share = $_POST['tsubscribed_share'];

  $howmany_inbirr = $howmany * 500;

  $raccount_no = $_POST['taccount_no'];

  $rname = $_POST['rname'];

  $total_share_transfered = $_POST['howmany'];

  $buyyer_paidup_in_birr = $_POST['buyyer_paidup'];

  $total_transfered_in_birr = $total_share_transfered * 500;

  $pervalue = $_POST['per_value'];

  $seller_paidup = $_POST['seller_paidup'];

  $buyyer_paidup = $_POST['buyyer_paidup'];

  

if($_POST['agreement'] == 'buyer'){

    $transfer_date = $_POST['ag_year'];

    $agred_to = $raccount_no;

  } 

  $agreement = $_POST['agreement'];

  $tt = $_POST['tt'];

  $value_date = $_POST['transfer_date'];

  $year = date('Y');
  $transfer = mysqli_query($conn,"INSERT INTO transfer (account_no,total_share, name,raccount_no,rname,rtotal_share,total_share_transfered,total_transfered_in_birr,buyyer_paidup_in_birr,seller_paidup_in_birr,transfer_date,value_date,pervalue,status_of_transfer,year,agreement,agred_to,both_seller,both_buyer) 
                    VALUES ('NIB','$seller_share','NIB','$raccount_no','$rname','$rtotal_share','$total_share_transfered','$total_transfered_in_birr','$buyyer_paidup','$seller_paidup','$transfer_date','$value_date','500','pending','$year','buyer','$raccount_no','','')"
  ) or die(mysqli_error($conn));

  header("location:/shareholder_new/shareholder/transfer?id=".$id."&transfer=okay&from=$from&to=$to");

  } ?>

                 </form>
            </div><!-- /.box-body -->
       
 </div>
