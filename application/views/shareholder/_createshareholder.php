  <?php
		$conn=mysqli_connect('localhost','root','','shareholder');
		if (isset($this->session->userdata['logged_in'])) {	
		$username = $this->session->userdata['logged_in']['username'];
		$userId	= $this->session->userdata['logged_in']['id'];	
		} 
	?>
  <script type="text/javascript">

        function validateForm() {
            
            //var a = parseInt(document.forms["myForm"]["total_share_subscribed"].value);

           var b = parseInt(document.forms["myForm"]["value_date"].value);

            if (b == "") {

                alert(" Value Date Required");
 
                return false;
            }           
        }

</script>
<script>function format(input){
    var num = input.value.replace(/\,/g,'');
    if(!isNaN(num)){
    if(num.indexOf('.') > -1){
    num = num.split('.');
    num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1').split('').reverse().join('').replace(/^[\,]/,'');
    if(num[1].length > 2){
    alert('You may only enter two decimals!');
    num[1] = num[1].substring(0,num[1].length-1);
    } input.value = num[0]+'.'+num[1];
    } else {
    input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1').split('').reverse().join('').replace(/^[\,]/,'') };
    } else {
    alert('You may enter only Decimal numbers in this field!');
    input.value = input.value.substring(0,input.value.length-2);
    }
    }
</script>
                            <!-- general form elements disabled -->
                      <div class="box box-warning">
                          <div class="col-md-12">
                        	
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

                  <?php if(isset($_GET['cash'])){
                             if($_GET['cash']=="yes"){
                    ?>
                    <div class="alert alert-success alert-dismissable" role="alert">Shareholder created succesfully</div>

                    <?php }else{ ?>
                      <div class="alert alert-danger alert-dismissable" role="alert">Shareholder is not created !!</div>
                    <?php }}if(isset($_GET['error_value'])){

                    ?>
                    <div class="alert alert-danger alert-dismissable" role="alert">value date is requred</div>

                    <?php } ?>

                     <?php if(isset($_GET['message_display'])){

                    ?>
                    <div class="alert alert-danger alert-dismissable" role="alert">
                      The account number already exists. please change the account no and try again or if the request is rejected contact the authorizer and delete the rejected requests first
                    </div>

                    <?php } ?>
                    <?php if(isset($_GET['message_warning'])){

                    ?>
                    <div class="alert alert-danger alert-dismissable" role="alert">
                      The subscribed share can not be less than the paid up share 
                    </div>

                    <?php } ?>
               
<form action="<?php echo base_url('');?>shareholder/new_shareholder" method="POST" role="form" name="myForm" id="myForm" onSubmit="return validateForm()">
                      
                         <div class="col-sm-6">                                           
                                       
     <div class="form-group">
        <label>Account Number </label>
        <input type="text" onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="account_no" class="form-control" value="<?php echo set_value('account_no'); ?>" placeholder="Enter ..."/>
  <?php echo form_error('account_no'); ?>
    </div>
     <div class="form-group">
        <label>Shareholder Full names</label>
        <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>" placeholder="Enter ..."/>
  <?php echo form_error('name'); ?>
    </div>
 
     <div class="form-group">
        <label>Total Paid UP Capital In Birr </label>
        <input type="text" onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="total_paidup_capital_inbirr" class="form-control" value="<?php echo set_value('total_paidup_capital_inbirr'); ?>" placeholder="Enter ..."/>
  <?php echo form_error('total_paidup_capital_inbirr'); ?>
    </div>

    <div class="form-group">
        <label>Value Date </label>
        <input type="text" maxlength="10" readonly onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="value_date" class="tcal"/>
  <?php echo form_error('value_date'); ?>
    </div>
   
     <div class="form-group">
        <label>Share Type </label>
            <select name="share_type" class="form-control" required>
            <?php
             $result = mysqli_query($conn,"SELECT * FROM share_type");
             while($row2 = mysqli_fetch_array($result))
               {
                 echo '<option value="'.$row2['id'].'">';
                 echo $row2['id']." - ".$row2['share_type'];
                 echo '</option>';
               }
             ?>
            </select>
        <?php echo form_error('unpaid_balance'); ?>
    </div>
       <div class="form-group">
        <label>City </label>
        <input type="text" name="city" class="form-control" value="<?php echo set_value('city'); ?>" placeholder="Enter ..."/>
  <?php echo form_error('city'); ?>
    </div>
       <div class="form-group">
        <label>Sub City </label>
        <input type="text" name="sub_city" class="form-control" value="<?php echo set_value('sub_city'); ?>" placeholder="Enter ..."/>
  <?php echo form_error('sub_city'); ?>
    </div>
                              </div>
<div class="col-sm-6"> 
            <div class="form-group">
          <label>Woreda</label>
          <input type="text" name="woreda" class="form-control" value="<?php echo set_value('woreda'); ?>" placeholder="Enter ..."/>
    <?php echo form_error('woreda'); ?>
      </div>
            <div class="form-group">
          <label>House Number</label>
          <input type="text" name="house_no" class="form-control" value="<?php echo set_value('house_no'); ?>" placeholder="Enter ..."/>
    <?php echo form_error('house_no'); ?>
      </div>
           <div class="form-group">
          <label>P.O.Box</label>
          <input type="text" name="pobox" class="form-control" value="<?php echo set_value('pobox'); ?>" placeholder="Enter ..."/>
    <?php echo form_error('pobox'); ?>
      </div>
          <div class="form-group">
          <label>Telephone Residence</label>
          <input type="text" name="telephone_residence" class="form-control" value="<?php echo set_value('telephone_residence'); ?>" placeholder="Enter ..."/>
    <?php echo form_error('telephone_residence'); ?>
      </div>
         <div class="form-group">
          <label>Telephone Office</label>
          <input type="text" name="telephone_office" class="form-control" value="<?php echo set_value('telephone_office'); ?>" placeholder="Enter ..."/>
    <?php echo form_error('telephone_office'); ?>
      </div>
      
      <div class="form-group">
          <label>Mobile</label>
          <input type="text" name="mobile" class="form-control" value="<?php echo set_value('mobile'); ?>" placeholder="Enter ..."/>
    <?php echo form_error('mobile'); ?>
      </div>

      <div class="form-group">
          <label>Member </label>
              <select name="member" class="form-control" required>
                <option value="true">Member</option>
                <option value="false">Not Member</option>
              </select>
          <?php echo form_error('member'); ?>
      </div>

      <div class="form-group">
          <label>Remark</label>
          <input type="text" name="remark" class="form-control" value="<?php echo set_value('remark'); ?>" placeholder="Enter ..."/>
    <?php echo form_error('remark'); ?>
      </div>
      <!-- <input type="hidden" readonly="" value="with_value" name="type_of_creation" class="form-control"/>   -->
      <input type="hidden" readonly name="maker"  value="<?php echo $userId; ?>" class="form-control"/>
      <div class="box-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
  </div>
                 </div>   
              </form>
         </div><!-- /.box-body -->
   </div>
  </div>
         