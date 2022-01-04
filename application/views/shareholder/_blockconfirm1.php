<?php
		
		$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
			
		$username = $this->session->userdata['logged_in']['username'];
    $userId = $this->session->userdata['logged_in']['id'];
			
		} 
		
	?>
  
	<?php

  

    $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
    $budget_result = mysqli_fetch_array($budget_query);
    if(isset($_POST['blocksubmit']) && $budget_result){
      // $select_budget_year = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
      // $budget_row = mysqli_fetch_array($select_budget_year);
      $endd = $budget_result['budget_to']; 
      $startd = $budget_result['budget_from']; 
      $year=$budget_result['id'];
      $blocked="";
      $account_no=$_POST['account'];
      $blocked_date = date('Y-m-d');
      $blocked_date = date('Y-m-d', strtotime($blocked_date));
 
      if(($blocked_date < $startd) || ($blocked_date > $endd) ){
        
        $blocked="date";
      } else {
        $rf_no="";
        $blocked_amount=0.00;
        
         if(isset($_POST['rf_no'])){
        $rf_no  = $_POST['rf_no'];
         }
         $blocked_type=$_POST['blocked_type'];
        $account_no = $_POST['account'];
        $total_capital_can_block=floatval($_POST['total_capital_can_block']);
        if(isset($_POST['blocked_amount'])){
          $blocked_amount  = floatval($_POST['blocked_amount']);
           }
        $reason="";
        if(isset($_POST['reason'])){
          $reason = $_POST['reason'];
        }
        
       
        

      if($total_capital_can_block >= $blocked_amount){
        $query = mysqli_query($conn,"INSERT INTO blocked (account,blocked_amount,block_remark,blocked_date,blocked_type,blocked_letter_rf_no,blocked_status ,year,maker) 
         VALUES ('$account_no',$blocked_amount,'$reason','$blocked_date','$blocked_type','$rf_no',8,$year,$userId)"
        ) or die(mysqli_error($conn));
        $blocked="yes";
      }else{
        $blocked="amount";
      }
      
      
      }
      header('location:/shareholder_new/shareholder/blockconfirm?block='.$blocked);
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
    
    <?php if(isset($_GET['block'])){
           if($_GET['block']=="yes"){
    
          ?>
    <div class="alert alert-success alert-dismissable" role="alert">
    <div class='message'>
    Share blocked successfully
    </div>
      </div> 
          <?php
          }elseif($_GET['block']=="date"){
      ?>
    
    <div class="alert alert-danger alert-dismissable" role="alert">
        <div class='message'>
       blocked date is out of budget year! try again or contact  system admin.
      </div>
    </div>
         <?php
          }
        else{
          ?>
        
        <div class="alert alert-danger alert-dismissable" role="alert">
            <div class='message'>
             The blocked (in birr) amount must be less or equal to the seller total paid up capital (free from pledged and blocked)
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
    
        $pludge = mysqli_query($conn,"SELECT *,sum(pledged_amount) as pludged_amount from pludge where account = '$acct'  AND pledged_status not in(10,11) ") or die(mysqli_error($conn));                         
        $pludge_amount = mysqli_fetch_array($pludge);  
        $total_plugged=$pludge_amount['pludged_amount']?$pludge_amount['pludged_amount']:0;
    
        $blocked = mysqli_query($conn,"SELECT *,sum(blocked_amount) as blocked_amount from blocked where account = '$acct'  AND blocked_status not in(10,11) ") or die(mysqli_error($conn));                         
        $blocked_amount = mysqli_fetch_array($blocked); 
        $total_blocked=$blocked_amount['blocked_amount']?$blocked_amount['blocked_amount']:0;
        $sold = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) as sold_amount from transfer where seller_account= ' $acct'  AND year = $year and status_of_transfer !=11") or die(mysqli_error($conn));                         
        $sold_amount = mysqli_fetch_array($sold); 
        $total_sold=$sold_amount['sold_amount']?$sold_amount['sold_amount']:0;
    
        $bought = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) as bought_amount from transfer where buyer_account = '$acct'  AND year = $year and status_of_transfer !=11") or die(mysqli_error($conn));                         
        $bought_amount = mysqli_fetch_array($bought); 
        $total_bought=$bought_amount['bought_amount']?$bought_amount['bought_amount']:0;
    
        $capitalized = mysqli_query($conn,"SELECT *,sum(capitalized_in_birr) as capitalized_amount from capitalized where account = '$acct'  AND year = $year and capitalized_status !=11 ") or die(mysqli_error($conn));                         
        $capitalized_amount = mysqli_fetch_array($capitalized);
        $total_capitalized=$capitalized_amount['capitalized_amount']?$capitalized_amount['capitalized_amount']:0;
        $total_capital_can_block=$initial_paidup+$total_capitalized+$total_bought-$total_sold-$total_blocked-$total_plugged;
        
        $blocked = mysqli_query($conn,"SELECT account from blocked where account = '$acct' and blocked_type='full' AND blocked_status not in(10,11) ") or die(mysqli_error($conn));                         
        $blocked_amount = mysqli_fetch_array($blocked); 
        if($total_capital_can_block > 0 && isset($blocked_amount['account'])){
          $total_capital_can_block=0;
        }
        
          ?>
        <div class="form-group">
            
            <label>Blocked From </label>
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
                <label>Maximum Capital can block </label>
            <input type="text" required readonly name="total_capital_can_block" autofocus class="form-control" value="<?php echo $total_capital_can_block; ?>">
            </div>
            <?php echo form_error('from'); ?>
    
        </div>    
                <div class="form-group">
                    
                    <label>Block Type</label> 
                    <select name="blocked_type" required id="select_blockedType" class="form-control" onchange="blockedAmount(this.value)">
                      <option>--select Blocked Type--</option>
                      <option value="full">Block Fully</option>
                      <option value="partial">Block Bartially</option>
                  </select>
              </div> 
                                       <div style="display: none;" class="form-group"  id='dv_amount'>
                                            <label>Blocked amount in birr</label>
                                            <input type="text" name="blocked_amount"  value="" id="input_amount" class="form-control" placeholder="Enter ..."/>
                                 			<?php echo form_error('blocked_amount'); ?>
                                        </div>

                                        <div class="form-group">
                                            
                                            <label>Reason</label>
                                            <textarea name="reason" required autofocus value="" class="form-control">  </textarea>
                                            <?php echo form_error('reason'); ?>
                                        </div>
                                         <div class="form-group">
                                            <label>Blocked Letter Rf No</label>
                                            <input type="text" name="rf_no"  value="" class="form-control" placeholder="Enter ..."/>
                                 		   	<?php echo form_error('rf_no'); ?>
                                        </div>
                                        <div class="box-footer">
                                     
                                        <button type="submit" class="btn btn-primary" name="blocksubmit">Block Shareholder</button>
                                    </div>
                                    
                                    
                                    
                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
                    <?php }} ?>
                    <script type="text/javascript">
function blockedAmount(typeValue){
    if(typeValue == "partial"){
      console.log(typeValue);
      document.getElementById("dv_amount").style.display = 'block';;
      document.getElementById("input_amount").required=true;
    } else {
        document.getElementById("dv_amount").style.display = 'none';;
        document.getElementById("input_amount").required=false;
    }
}
</script>
             