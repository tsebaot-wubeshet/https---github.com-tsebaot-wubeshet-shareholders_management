<?php
$conn=mysqli_connect('localhost','root','','shareholder');
if (isset($this->session->userdata['logged_in'])) {

$username = $this->session->userdata['logged_in']['username'];

} 
?> 


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
<th>No.</th>
<th>Account no</th>
<th>Shareholder Name</th>
<th>Start date</th>
<th>Due date</th>
<th>Alloted Amount</th>
<th>Allot Status</th>
</tr>
</thead>
<tbody>

<?php

$query = mysqli_query($conn,"SELECT * from allotment") or die(mysqli_error($conn));

$a = 0;

while ($rows = mysqli_fetch_array($query)) {
$a = $a + 1;

$id = $rows['id'];
$account_no = $rows['account_no'];
$query2 = mysqli_query($conn,"SELECT * from shareholders where account_no = '$account_no'") or die(mysqli_error($conn));
$rows2 = mysqli_fetch_array($query2);
?>
<tr>

<td><?php echo $a; ?></td>
<td><?php echo $rows['account_no']; ?></td>
<td><?php echo $rows2?$rows2['name']: ""; ?></td>
<td><?php echo $rows['allot_year']; ?></td>
<td><?php echo $rows?$rows['due_date']: ""; ?></td>
<td><?php echo $rows['allotment']; ?></td>
<td>
<?php 
if($rows){
     if($rows['allot_status'] == 'pending'){
        echo "<span class='badge bg-red'>Pending Authorization</span>";
 } elseif($rows['allot_status'] == '') { 
        echo "<span class='badge bg-blue'>No Allotment</span>";
 } else{ 
    echo "<span class='badge bg-green'>Active</span>";
} }?></td>

</tr>
<?php } ?>
</tbody>

<br><br>
</table>

</form> 
</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>

</section><!-- /.content -->
