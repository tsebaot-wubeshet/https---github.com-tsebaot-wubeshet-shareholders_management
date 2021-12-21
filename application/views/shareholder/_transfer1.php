<?php
$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {     
      $username = $this->session->userdata['logged_in']['username'];
      $userId = $this->session->userdata['logged_in']['id'];
    } 
  ?>
<?php 
$budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
$budget_result = mysqli_fetch_array($budget_query);
if(isset($_POST['submitTransfer']) && $budget_result){
  // $select_budget_year = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
  // $budget_row = mysqli_fetch_array($select_budget_year);
  $endd = $budget_result['budget_to']; 
  $startd = $budget_result['budget_from']; 
  $year=$budget_result['id'];
  $value_date = $_POST['value_date'];
  $currentDate = date('Y-m-d', strtotime($value_date));
  $transfered="";
  $account_no=$_POST['account'];
  $transfer_date = date('Y-m-d');
  $transfer_date = date('Y-m-d', strtotime($transfer_date));
  $howmany  = $_POST['howmany'];
  //if((($currentDate < $startd) || ($currentDate-1 > $endd)) ||(($transfer_date <= $startd) || ($transfer_date >= $endd)) ){
  if(($currentDate < $startd) || (date('Y-m-d', strtotime($value_date)-1) > $endd)){
    
    $transfered="date";
  }elseif($_POST['account']==$_POST['raccount']){
    $transfered="account";
  }elseif( floatval($howmany) <= 0.00){
    $transfered="amount";
  } else {
    
    
    $account_no = $_POST['account'];
    $raccount_no = $_POST['raccount'];
    $total_transfered_in_birr = $howmany;
    $total_capital_can_transfer=$_POST['total_capital_can_transfer'];
    $agreement = $_POST['agreement'];
    $transfer_type = $_POST['transfer_type'];
    $total_fromIntially_can_transfer=$_POST['total_fromIntially_can_transfer'];
    $total_can_fullTransfer_bothAgreement=$_POST['total_can_fullTransfer_bothAgreement'];
    if(($total_capital_can_transfer == $howmany)){
      if($agreement==3){
      $shareholdersUpdate = mysqli_query($conn,"UPDATE shareholders set currentYear_status = 2, closed_date='$transfer_date', closed_year=$year WHERE account_no = '$acct'") or die(mysqli_error($conn));
     //will update here
      }elseif($agreement==1 && $total_can_fullTransfer_bothAgreement < $howmany){
        $transfered="amount";
      }else{
        $shareholdersUpdate = mysqli_query($conn,"UPDATE shareholders set nextYear_status = 2, closed_date='$transfer_date', closed_year=$year WHERE account_no = '$acct'") or die(mysqli_error($conn));
      }
//will update here
      $query = mysqli_query($conn,"INSERT INTO transfer (seller_account,buyer_account,total_transfered_in_birr,transfer_date,value_date,status_of_transfer,year,agreement,transfer_type,maker,full_transfer) 
      VALUES ('$account_no','$raccount_no',$total_transfered_in_birr,'$transfer_date','$value_date',3,$year,$agreement,$transfer_type,$userId,true)"
     ) or die(mysqli_error($conn));
     $transfered="yes";
    }
  elseif($total_capital_can_transfer > $howmany){
    if($agreement==3 && $total_fromIntially_can_transfer < $howmany){
      $transfered="amount";
    }else{
      $query = mysqli_query($conn,"INSERT INTO transfer (seller_account,buyer_account,total_transfered_in_birr,transfer_date,value_date,status_of_transfer,year,agreement,transfer_type,maker,full_transfer) 
      VALUES ('$account_no','$raccount_no',$total_transfered_in_birr,'$transfer_date','$value_date',3,$year,$agreement,$transfer_type,$userId,false)"
      ) or die(mysqli_error($conn));
      $transfered="yes";
    }
  }else{
    $transfered="amount";
  }
  
  
  }
  header("location:/shareholder_new/shareholder/transfer?id=".$account_no."&transfer=".$transfered);
  }

?>

                            <!-- general form elements disabled -->
<div class="box box-warning">
      <div class="col-md-12">
<div class="col-md-6">
  <div class="box-body">

<?php if($this->session->flashdata('flashError')): ?>
<p class='flashMsg flashError alert alert-danger alert-dismissable'> <?php echo $this->session->flashdata('flashError')?> </p>
<?php endif ?>

<?php if(isset($_GET['transfer'])){
       if($_GET['transfer']=="yes"){

      ?>
<div class="alert alert-success alert-dismissable" role="alert">
<div class='message'>
Share transfered succesfully
</div>
  </div> 
      <?php
      }elseif($_GET['transfer']=="date"){
  ?>

<div class="alert alert-danger alert-dismissable" role="alert">
    <div class='message'>
    Value date / transfer date is out of budget year! try again or contact  system admin.
  </div>
</div>
<?php }
elseif($_GET['transfer']=="account"){
  ?>

<div class="alert alert-danger alert-dismissable" role="alert">
    <div class='message'>
    Self transfer is forbidden! try again for an othe account.
  </div>
</div>
<?php }
    else{
      ?>
    
    <div class="alert alert-danger alert-dismissable" role="alert">
        <div class='message'>
         The transfered paid up share (in birr) amount must be less or equal to the seller total paid up capital (free from plugged and blocked)
      </div>
    </div>
    <?php }
        } ?>
<?php 

?>
                       
<form action="" method="POST" role="form" name="myForm" id="myForm" >
                    
<?php
//$this->load->view('shareholder/year');
if(isset($_GET['id'])){          
$id = $_GET['id'];
// $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
// $budget_result = mysqli_fetch_array($budget_query);
$from="";
$to="";
$year=0;
$result = mysqli_query($conn,"SELECT * FROM shareholders WHERE account_no ='$id'");
$row = mysqli_fetch_array($result);
if($row && $budget_result){
    $from = $budget_result['budget_from'];
    $to = $budget_result['budget_to'];
    $year = $budget_result['id'];  
    $acct = $row['account_no'];     
    $balance = mysqli_query($conn,"SELECT * from balance where account = '$acct' AND year = $year ") or die(mysqli_error($conn));
    $balance_amount = mysqli_fetch_array($balance);     
    $initial_paidup=$balance_amount?$balance_amount['total_paidup_capital_inbirr']:0;

    $query2 = mysqli_query($conn,"SELECT * from allotment where account = '$acct' ") or die(mysqli_error($conn));                         
    $rows2 = mysqli_fetch_array($query2);

    $pludge = mysqli_query($conn,"SELECT sum(pledged_amount) as pludged_amount from pludge where account = '$acct'  AND pledged_status not in(10,11) ") or die(mysqli_error($conn));                         
    $pludge_amount = mysqli_fetch_array($pludge);  
    $total_plugged=$pludge_amount['pludged_amount']?$pludge_amount['pludged_amount']:0;

    $blocked = mysqli_query($conn,"SELECT sum(blocked_amount) as blocked_amount from blocked where account = '$acct'  AND blocked_status not in(10,11) ") or die(mysqli_error($conn));                         
    $blocked_amount = mysqli_fetch_array($blocked); 
    $total_blocked=$blocked_amount['blocked_amount']?$blocked_amount['blocked_amount']:0;
    
    $sold = mysqli_query($conn,"SELECT sum(total_transfered_in_birr) as sold_amount from transfer where seller_account = '$acct'  AND year = $year and status_of_transfer !=11") or die(mysqli_error($conn));                         
    $sold_amount = mysqli_fetch_array($sold); 
    $total_sold=$sold_amount['sold_amount']?$sold_amount['sold_amount']:0;

    $bought = mysqli_query($conn,"SELECT sum(total_transfered_in_birr) as bought_amount from transfer where buyer_account = '$acct'  AND year = $year and status_of_transfer !=11") or die(mysqli_error($conn));                         
    $bought_amount = mysqli_fetch_array($bought); 
    $total_bought=$bought_amount['bought_amount']?$bought_amount['bought_amount']:0;

    $boughtForBothAdjustment = mysqli_query($conn,"SELECT sum(total_transfered_in_birr) as bought_amount from transfer where buyer_account = '$acct'  AND year = $year and agreement=3 and status_of_transfer !=11") or die(mysqli_error($conn));                         
    $bought_amountForBothAdjustment = mysqli_fetch_array($boughtForBothAdjustment); 
    $total_boughtForBothAdjustment=$bought_amountForBothAdjustment['bought_amount']?$bought_amountForBothAdjustment['bought_amount']:0;

    $fromIntiallyBought = mysqli_query($conn,"SELECT sum(total_transfered_in_birr) as bought_amount from transfer where buyer_account = '$acct' and agreement='buyer' AND year = $year and status_of_transfer !=11") or die(mysqli_error($conn));                         
    $fromIntiallyBought_amount = mysqli_fetch_array($fromIntiallyBought); 
    $total_fromIntiallyBought=$fromIntiallyBought_amount['bought_amount']?$fromIntiallyBought_amount['bought_amount']:0;

    $capitalized = mysqli_query($conn,"SELECT sum(capitalized_in_birr) as capitalized_amount from capitalized where account = '$acct'  AND year = $year and capitalized_status !=11") or die(mysqli_error($conn));                         
    $capitalized_amount = mysqli_fetch_array($capitalized);
    $total_capitalized=$capitalized_amount['capitalized_amount']?$capitalized_amount['capitalized_amount']:0;

    $total_capital_can_transfered=$initial_paidup+$total_capitalized+$total_bought-$total_sold-$total_blocked-$total_plugged;
    $total_fromIntially_can_transfer=$initial_paidup+$total_fromIntiallyBought-$total_sold-$total_blocked-$total_plugged;
    $total_can_fullTransfer_bothAgreement=$total_capital_can_transfered-$total_boughtForBothAdjustment;
      ?>
    <div class="form-group">
        
        <label>Transfer From </label>
        <div class="form-group">
            <label>Account No</label>
        <input type="text" required readonly name="account" autofocus class="form-control" value="<?php echo $row['account_no']; ?>">
        </div>
        <div class="form-group">
            <label>Name</label>
        <input type="text" required readonly name="name" autofocus class="form-control" value="<?php echo $row['name']; ?>">
        </div>
        <?php 
            if($initial_paidup!=0){?>
        <div class="form-group">
            <label>Intial Paidup Capital</label>
        <input type="text" required readonly name="intial_paidup" autofocus class="form-control" value="<?php echo $initial_paidup; ?>">
        </div>
        <?php }if($total_capitalized!=0){ ?>
        <div class="form-group">
            <label>Total Capitalized</label>
        <input type="text" required readonly name="capitalized" autofocus class="form-control" value="<?php echo $total_capitalized; ?>">
        </div>
        <?php }if($total_bought!=0){ ?>
        <div class="form-group">
            <label>Total Bought share(in birr)</label>
        <input type="text" required readonly name="bought" autofocus class="form-control" value="<?php echo $total_bought; ?>">
        </div>
        <?php }if($total_sold!=0){ ?>
        <div class="form-group">
            <label>Total Sold share(in birr)</label>
        <input type="text" required readonly name="sold" autofocus class="form-control" value="<?php echo $total_sold; ?>">
        </div>
        <?php }if($total_plugged!=0){ ?>
        <div class="form-group">
            <label>Total plugged share(in birr)</label>
        <input type="text" required readonly name="plugged" autofocus class="form-control" value="<?php echo $total_plugged; ?>">
        </div>
        <?php }if($total_blocked!=0){ ?>
        <div class="form-group">
            <label>Total plugged share(in birr)</label>
        <input type="text" required readonly name="blocked" autofocus class="form-control" value="<?php echo $total_blocked; ?>">
        </div>
        <?php }?>
        <div class="form-group">
            <label>Maximum Capital can partial(some) amount of Transfer for buyer agreement  </label>
        <input type="text" required readonly name="total_fromIntially_can_transfer" autofocus class="form-control" value="<?php echo $total_fromIntially_can_transfer; ?>">
        </div>
        <div class="form-group">
            <label>Maximum Capital can Transfer for both agreement  </label>
        <input type="text" required readonly name="total_can_fullTransfer_bothAgreement" autofocus class="form-control" value="<?php echo $total_can_fullTransfer_bothAgreement; ?>">
        </div>
        <div class="form-group">
            <label>Maximum Capital can Transfer for seller and buyer agreement </label>
        <input type="text" required readonly name="total_capital_can_transfer" autofocus class="form-control" value="<?php echo $total_capital_can_transfered; ?>">
        </div>
        <?php echo form_error('from'); ?>

    </div>
    
          <div class="form-group">
            
            <label>Transfer to</label> 
            <select name="raccount" required class="form-control">
              <option value="">Select Name of Shareholder</option>
            <?php
    
            $name = $row['name'];
            $result = mysqli_query($conn,"SELECT * FROM shareholders where currentYear_status = 1 group by name order by cast(account_no as int)");
            while($row2 = mysqli_fetch_array($result))
              {
                echo '<option value="'.$row2['account_no'].'">';
                echo $row2['account_no']." - ".$row2['name'];
                echo '</option>';
              }
              ?>
      </select>
      </div> 
    <!-- onkeyup = "javascript:this.value=Comma(this.value);" -->                      
    <div class="form-group">
          <label>How many paidup capital to be transfered (birr)</label>
          <input type="text" required onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="howmany" value="<?php echo set_value('howmany'); ?>" class="form-control" placeholder="Enter ..."/>
    <?php echo form_error('howmany'); ?>
    </div>

    <div class="form-group">
        <label> Value Date:</label>
        <input type="text" required readonly onKeyPress="return event.charCode > 47 && event.charCode < 58;" class="tcal" value="<?php echo set_value('transfer_date'); ?>" name="value_date">
      </div>
    <?php echo form_error('transfer_date'); ?>

    <label>Dividend Agreement</label>
    <div class="form-group">
                      <div class="radio">
                        <label>
                          <input type="radio" name="agreement" value="2" required>
                          For Seller
                        </label>
                      </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="agreement" value="3">
                          For Buyer
                        </label>
                      </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="agreement" value="1">
                          For Both
                        </label>
                      </div>
                    </div>

    <label>Kind of transfer</label>
    <div class="form-group">
                      <div>
                        <label>
                          <input type="radio" name="transfer_type" value="1" required>
                          Sale
                        </label>
                      </div>
                    <div>
                        <label>
                          <input type="radio" name="transfer_type" value="4">
                          Heir
                        </label>
                      </div>
                      <div>
                        <label>
                          <input type="radio" name="transfer_type" value="2">
                          Court
                        </label>
                      </div>
                      <div>
                        <label>
                          <input type="radio" name="transfer_type" value="5">
                          Other
                        </label>
                      </div>
                    </div>
    </div>  
      
    <div class="box-footer">
        <button type="submit" class="btn btn-primary" name="submitTransfer">Transfer Share</button>
    </div>
                
    <?php 
    }
}  

?>
                 </form>
            </div><!-- /.box-body -->
       
 </div>
