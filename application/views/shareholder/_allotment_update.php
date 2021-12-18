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
            <b>Success!</b> Bulk Allotment Updated Successfully!.
</div>

<?php } ?>

<!-- Main content -->
<section class="content">
<div class="row" style="width:100%">
<div class="col-xs-12">
<div class="box">
    
    <div class="box-body table-responsive">
        <fieldset>
            <button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> BULK UPDATE ALLOTEMENT</button>
          
        </fieldset>
    </div><!-- /.box-body -->
<?php 

if (isset($_POST['authorize'])) {

$prepared_query = mysqli_query($conn,"SELECT * FROM allotment");

while($row = mysqli_fetch_array($prepared_query)){

$account_no = $row['account_no'];
$allotment = $row['allotment'];

mysqli_query($conn,"UPDATE shareholders SET total_share_subscribed = total_share_subscribed + $allotment WHERE account_no = '$account_no'");

header('location:/shareholder_new/shareholder/allotment?authorize=ok');

}
}
?>
</div><!-- /.box -->
</div>
</div>

</section><!-- /.content -->
