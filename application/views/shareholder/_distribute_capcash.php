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
            <b>Success!</b> Capitilized Authorized Successfully!.
        </div>

<?php } ?>
<?php

if(isset($_GET['reject'])){

?>

<div class="alert alert-success alert-dismissable">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>Success!</b> Capitilized Rejected Successfully!.
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
                    <th>account No</th>  
                    <th>Value Date</th>
                    <th>Cash paid</th>                                           
                    <th>Type</th>
                    <th></th>
                   
                </tr>
            </thead>
            <tbody>
              <?php
               
$query = mysqli_query($conn,"SELECT * from capitalized where capitalized_status =4 ") or die(mysqli_error($conn));
                
                $a = 0;
                
                while ($rows = mysqli_fetch_array($query)) {
                    $a = $a + 1;

                   $id = $rows['id']; 
                ?>
                <tr>
                    <td></td>

                    <td><input type="checkbox" name="id[]" value="<?php echo $rows['id'];?>"></td>
                    
                    <td><?php echo $a; ?></td>
                    <td><?php echo $rows['account']; ?></td>
                    <td><?php echo $rows['value_date']; ?></td>
                    <td><?php echo $rows['capitalized_in_birr']; ?></td>
                   
                    <td><?php echo $rows['type']; ?></td>
                    
                    <input type="hidden" name="value_date[]" value="<?php echo $rows['value_date']; ?>">
                    <input type="hidden" name="name[]" value="<?php echo $rows['name']; ?>">

                    <input type="hidden" name="capitalized_in_share[]" value="<?php echo $rows['capitalized_in_share']; ?>">
                    <input type="hidden" name="account_no[]" value="<?php echo $rows['account_no']; ?>">

                    <input type="hidden" name="type[]" value="<?php echo $rows['type']; ?>">
                    <input type="hidden" name="capitalized_in_birr[]" value="<?php echo $rows['capitalized_in_birr']; ?>">
                    <input type="hidden" name="year[]" value="<?php echo $rows['year']; ?>">
                    <input type="hidden" name="capitalized_status[]" value="<?php echo $rows['capitalized_status']; ?>">

                    <input type="hidden" name="cap[]" value="<?php echo $rows['capitalized_in_birr']; ?>">
                    
                   
                    <?php if($role == 3){ ?>      
     
                    <td>
                    <a href="<?php echo base_url();?>shareholder/edit_distribute?account=<?php echo $rows['account_no']; ?>&id=<?php echo $rows['id']; ?>&amount=<?php echo $rows['capitalized_in_birr']?>&type=<?php echo $rows['type']; ?>&vd=<?php echo $rows['value_date'];?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url();?>shareholder/edit_distribute?id=<?php echo $rows['account_no']; ?>')">Distribute</a>
                                                
                    </td>
                                     
      <?php } ?> 

                    
                    
                   <?php } ?>
                    
                </tr>
                
            </tbody>
                                                        
         
        </table>

        <?php 

     if (isset($_POST['authorize'])) {
       
        $id = $_POST['id'];

        foreach ($_POST['id'] as $ids) {
              
        $query_cap = mysqli_query($conn,"SELECT * from capitalized where 
            capitalized_status = 'pending' and type = 'capitalized' AND id = '$ids'") or die(mysqli_error($conn));
        
        $row_cap = mysqli_fetch_array($query_cap);

        $capitalized_in_birr = $row_cap['capitalized_in_birr'];

        $account_no = $row_cap['account_no'];        
                      
            $result1 = mysqli_query($conn,"UPDATE shareholders set total_paidup_capital_inbirr = total_paidup_capital_inbirr + '$capitalized_in_birr' where account_no='$account_no'") or die(mysqli_error($conn));

            $result = mysqli_query($conn,"UPDATE capitalized SET capitalized_status = 'authorized' where id='$ids'");
        header('location:/shareholder_new/shareholder/authorize_cashpayment?authorize=ok');
 
    }
}
?>

        <?php 
/*
        if (isset($_POST['authorize'])){

        $N = count($_POST['applist']);

        $id = $_POST['applist'];
        
        $account_no = $_POST['selector'];

        for($i=0; $i < $N; $i++)
        {
        
        $query_cap = mysqli_query($conn,"SELECT * from capitalized where 
            capitalized_status = 'pending' and type = 'capitalized' AND id = '$id[$i]'") or die(mysqli_error($conn));
        
        $row_cap = mysqli_fetch_array($query_cap);

        $capitalized_in_birr = $row_cap['capitalized_in_birr'];        

                      
            $result1 = mysqli_query($conn,"UPDATE shareholders set total_paidup_capital_inbirr = total_paidup_capital_inbirr + '$capitalized_in_birr' where account_no='$account_no[$i]'") or die(mysqli_error($conn));

            $result = mysqli_query($conn,"UPDATE capitalized SET capitalized_status = 'authorized' where id='$id[$i]'");
            
           header('location:http://172.23.2.174/shareholder_dividend/shareholder/authorize_capitalized?authorize=true');

    }
}
       */
        ?>

        <?php 

        if (isset($_POST['reject'])){        
        
        foreach($_POST['id'] as $cap_del){ 

            $id = array();
            array_push($id, $cap_del);
          
            $N = count($id);
            
            $query_cap = mysqli_query($conn,"SELECT * from capitalized where 
            capitalized_status = 'pending' AND type = 'capitalized' AND id = '$cap_del'") or die(mysqli_error($conn));
        
            $row_cap1 = mysqli_fetch_array($query_cap);
            $value_date = $row_cap1['value_date'];

            $capitalized_in_birr = $row_cap1['capitalized_in_birr'];
            $capitalized_in_share = $row_cap1['capitalized_in_share'];
            $name = $row_cap1['name'];
            $account_no2 = $row_cap1['account_no'];
            $type = $row_cap1['type'];
            $year = $row_cap1['year'];
            $capitalized_status = $row_cap1['capitalized_status'];
            
           $result_cap = mysqli_query($conn,"INSERT INTO rejected_capitalized (value_date,capitalized_in_birr,capitalized_in_share,name,account_no,type,year,capitalized_status) VALUES ('$value_date','$capitalized_in_birr','$capitalized_in_share','$name','$account_no2','$type','$year','$capitalized_status')") or die(mysqli_error($conn));
           
           $result_delete = mysqli_query($conn,"DELETE FROM capitalized WHERE capitalized_status = 'pending' AND id='$cap_del'") or die(mysqli_error($conn));

           header('location:authorize_capitalized?reject=true');

        
    }
}
        ?>

       </form> 
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>

</section><!-- /.content -->












