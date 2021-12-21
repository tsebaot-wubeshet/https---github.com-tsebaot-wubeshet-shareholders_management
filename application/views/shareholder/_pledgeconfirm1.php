<?php
		
		$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {
			
		$username = $this->session->userdata['logged_in']['username'];
    $userId = $this->session->userdata['logged_in']['id'];
			
		} 
		
	?>
  
	<?php

  

    $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
    $budget_result = mysqli_fetch_array($budget_query);
    $endd="";
    $startd="";
    $year=0;
    if($budget_result){
      $endd = $budget_result['budget_to']; 
      $startd = $budget_result['budget_from']; 
      $year=$budget_result['id'];
    }

    if(isset($_POST['Pledgesubmit'])){
      // $select_budget_year = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
      // $budget_row = mysqli_fetch_array($select_budget_year);
      
      $pledged="";
      $account_no=$_POST['account'];
      $pledged_date = date('Y-m-d');
      $pledged_date = date('Y-m-d', strtotime($pledged_date));
 
      if(($pledged_date < $startd) || ($pledged_date > $endd) ){
        
        $pledged="date";
      } else {
        $rf_no="";
        if(isset($_POST['rf_no'])){
          $rf_no=$_POST['rf_no'];
        }
        $pledged_amount  = floatval($_POST['pledged_amount']);
        $account_no = $_POST['account'];
        $total_capital_can_pledge=floatval($_POST['total_capital_can_pledge']);
        $reason = $_POST['reason'];
       
        

      if($total_capital_can_pledge >= $pledged_amount){
        $query = mysqli_query($conn,"INSERT INTO pludge (account,pledged_amount,pledged_reason,pledged_date,pledged_status,pledge_letter_rf_no,year,maker) 
         VALUES ('$account_no',$pledged_amount,'$reason','$pledged_date',9,'$rf_no',$year,$userId)"
        ) or die(mysqli_error($conn));
        $pledged="yes";
      }else{
        $pledged="amount";
      }
      
      
      }
      header('location:/shareholder_new/shareholder/pledgeconfirm?pledge='.$pledged);
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
    
    <?php if(isset($_GET['pledge'])){
           if($_GET['pledge']=="yes"){
    
          ?>
    <div class="alert alert-success alert-dismissable" role="alert">
    <div class='message'>
    Share pledged succesfully
    </div>
      </div> 
          <?php
          }elseif($_GET['pledge']=="date"){
      ?>
    
    <div class="alert alert-danger alert-dismissable" role="alert">
        <div class='message'>
       pledged date is out of budget year! try again or contact  system admin.
      </div>
    </div>
         <?php
          }
        else{
          ?>
        
        <div class="alert alert-danger alert-dismissable" role="alert">
            <div class='message'>
             The pledged (in birr) amount must be less or equal to the seller total paid up capital (free from plugged and blocked)
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
 
    $result = mysqli_query($conn,"SELECT * FROM shareholders WHERE account_no ='$id'");
    $row = mysqli_fetch_array($result);
    if($row ){
        
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
        $sold = mysqli_query($conn,"SELECT sum(total_transfered_in_birr) as sold_amount from transfer where seller_account = '$acct'  AND year = $year and status_of_transfer !=11 ") or die(mysqli_error($conn));                         
        $sold_amount = mysqli_fetch_array($sold); 
        $total_sold=$sold_amount['sold_amount']?$sold_amount['sold_amount']:0;
    
        $bought = mysqli_query($conn,"SELECT sum(total_transfered_in_birr) as bought_amount from transfer where buyer_account = '$acct'  AND year = $year and status_of_transfer !=11 ") or die(mysqli_error($conn));                         
        $bought_amount = mysqli_fetch_array($bought); 
        $total_bought=$bought_amount['bought_amount']?$bought_amount['bought_amount']:0;
    
        $capitalized = mysqli_query($conn,"SELECT sum(capitalized_in_birr) as capitalized_amount from capitalized where account = '$acct'  AND year = $year and capitalized_status !=11") or die(mysqli_error($conn));                         
        $capitalized_amount = mysqli_fetch_array($capitalized);
        $total_capitalized=$capitalized_amount['capitalized_amount']?$capitalized_amount['capitalized_amount']:0;
    
        $total_capital_can_pledge=$initial_paidup+$total_capitalized+$total_bought-$total_sold-$total_blocked-$total_plugged;
    
          ?>
        <div class="form-group">
            
            <label>pledged From </label>
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
                <label>Total blocked share(in birr)</label>
            <input type="text" required readonly name="blocked" autofocus class="form-control" value="<?php echo $total_blocked; ?>">
            </div>
            <?php }?>
            <div class="form-group">
                <label>Maximum Capital can pledge </label>
            <input type="text" required readonly name="total_capital_can_pledge" autofocus class="form-control" value="<?php echo $total_capital_can_pledge; ?>">
            </div>
            <?php echo form_error('from'); ?>
    
        </div>
                                       <div class="form-group">
                                            <label>Pledged amount in birr</label>
                                            <input type="text" required name="pledged_amount"  value="" class="form-control" placeholder="Enter ..."/>
                                 			<?php echo form_error('pledged_amount'); ?>
                                      
                                        <div>
                                        <div class="form-group">
                                            
                                            <label>Reason</label>
                                            <textarea name="reason" required autofocus value="" class="form-control">  </textarea>
                                            <?php echo form_error('reason'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Pledge Letter Rf No</label>
                                            <input type="text" name="rf_no"  value="" class="form-control" placeholder="Enter ..."/>
                                 		   	<?php echo form_error('rf_no'); ?>
                                        </div>
                                         <div>
                                        <div class="box-footer">
                                     
                                        <button type="submit" class="btn btn-primary" name="Pledgesubmit">Pledge Shareholder</button>
                                    </div>
                                         </div>
                                    
                                    
                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
                    <?php }} ?>
             