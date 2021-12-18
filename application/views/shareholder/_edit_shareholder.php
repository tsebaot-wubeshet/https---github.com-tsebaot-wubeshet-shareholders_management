<?php
$conn=mysqli_connect('localhost','root','','shareholder');
if (isset($this->session->userdata['logged_in'])) { 
$username = $this->session->userdata['logged_in']['username'];
$role = $this->session->userdata['logged_in']['role'];

} 
?>
<!-- general form elements disabled -->
<div class="box box-warning">
<div class="col-md-12">
<?php
if(isset($_GET['dividend'])){
?>
<div class="alert alert-success alert-dismissable">
      <i class="fa fa-ban"></i>
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <b>Success!</b> Data edited Succesfully!.
  </div>
<?php } ?>

<?php if(isset($_GET['edit'])){ ?>

<div class="alert alert-success alert-dismissable" role="alert">
<?php echo $_GET['edit']; ?>
</div>

<?php } ?>
<div class="box-body">
       <!-- display message -->

<?php if($this->session->flashdata('flashError')): ?>

<p class='flashMsg flashError alert alert-danger alert-dismissable'> <?php echo $this->session->flashdata('flashError')?> </p>
<?php endif ?>

<form action="<?php echo base_url('');?>shareholder/update_shareholder" method="POST" role="form">

<?php 
if(isset($_GET['acc'])){
$id = $_GET['acc'];

$query = mysqli_query($conn,"SELECT * from shareholders left outer join shareholder_address on shareholders.account_no = shareholder_address.account WHERE shareholders.account_no = '$id'")or die(mysqli_error($conn));; 

while($row = mysqli_fetch_array($query)){

?>
<div class="col-sm-6">                                           
    
<div class="form-group">
          <label>Shareholder Account No</label>
          <input type="text" name="account_no" class="form-control" value="<?php echo $row['account_no']; ?>" readonly/>
    <?php echo form_error('name'); ?>
      </div>
      <div class="form-group">
          <label>Shareholder Full names</label>
          <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('name'); ?>
      </div>
      
    <div class="form-group">
          <label>City </label>
          <input type="text" name="city" class="form-control" value="<?php echo $row['city']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('city'); ?>
      </div>
         <div class="form-group">
          <label>Sub City </label>
          <input type="text" name="sub_city" class="form-control" value="<?php echo $row['sub_city']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('sub_city'); ?>
      </div>

      <div class="form-group">
          <label>Woreda</label>
          <input type="text" name="woreda" class="form-control" value="<?php echo $row['woreda']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('woreda'); ?>
      </div>
      <div class="form-group">
          <label>House Number</label>
          <input type="text" name="house_no" class="form-control" value="<?php echo $row['house_no']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('house_no'); ?>
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
        <?php echo form_error('share_type'); ?>
    </div>

    </div>
     
    <div class="col-sm-6"> 
           <div class="form-group">
          <label>P.O.Box</label>
          <input type="text" name="pobox" class="form-control" value="<?php echo $row['pobox']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('pobox'); ?>
      </div>
          <div class="form-group">
          <label>Telephone Residence</label>
          <input type="text" name="telephone_residence" class="form-control" value="<?php echo $row['telephone_residence']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('telephone_residence'); ?>
      </div>
         <div class="form-group">
          <label>Telephone Office</label>
          <input type="text" name="telephone_office" class="form-control" value="<?php echo $row['telephone_office']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('telephone_office'); ?>
      </div>
      <div class="form-group">
          <label>Mobile</label>
          <input type="text" name="mobile" class="form-control" value="<?php echo $row['mobile']; ?>" placeholder="Enter ..."/>
    <?php echo form_error('mobile'); ?>
      </div>

       <input type="hidden" value="<?php echo $row['id']; ?>" name="id" class="form-control"/>

     <div class="box-footer">
      <button type="submit" name="submit" class="btn btn-primary">Update</button>
  </div>
 </div>  
       <?php   }} ?> 
</form>

</div><!-- /.box-body -->
</div>
</div>
