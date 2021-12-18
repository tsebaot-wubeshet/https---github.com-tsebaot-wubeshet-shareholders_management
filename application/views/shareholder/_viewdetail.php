<?php

$conn=mysqli_connect('localhost','root','','shareholder'); if (isset($this->session->userdata['logged_in'])) {

$username = $this->session->userdata['logged_in']['username'];

} 

?> 
<?php

if(isset($_GET['active'])){

?>

<div class="alert alert-success alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Success!</b> Shareholder Released Successfully!.
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
                <th>No.</th>                                               
                <th>Account number</th>
                <th>Shareholder Name</th>
                <th>Share subscribed</th>
                <th>Allotment</th>                                                
                <th>Total Share Subscribed</th>
                <th>Total paid up capital in share</th>
                <th>Total share Subscribed in Birr</th>                                                  
                <th>Total paid up capital in birr</th>                                                
                <th>Unpaid balance</th>
                <th>New Request </th>
                                                        
        </thead>
        <tbody>
            
    <?php
            
            $id = $_GET['id'];
            $shareValue_query = mysqli_query($conn,"SELECT * from share_value") or die(mysqli_error($conn));
            $shareValue_row = mysqli_fetch_array($shareValue_query);
            $shareValue=$shareValue_row?$shareValue_row['share_value']:0;
            $select_budget_year = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status =  1");
		$budget_row = mysqli_fetch_array($select_budget_year);
		$from="";
		$to="";
		$year=0;
		if($budget_row){
			$from = $budget_row['budget_from'];
			$to = $budget_row['budget_to'];
			$year = $budget_row['id'];
		}

            $query = mysqli_query($conn,"SELECT * from shareholders left join shareholder_address on shareholders.account_no=shareholder_address.account  where shareholders.account_no = '$id'  order by id ASC") or die(mysqli_error($conn));
            $a=0;
            while ($rows = mysqli_fetch_array($query)) {           
            $a = $a + 1;         
            $acct =$_GET['id'];
            $allotment_query = mysqli_query($conn,"SELECT * from allotment where account = '$acct' and year=$year and allot_status=4 order by id ASC") or die(mysqli_error($conn));
            $allotment_row = mysqli_fetch_array($allotment_query);
            $allotment=$allotment_row?$allotment_row['allotment']:0;
            
            $balance_query = mysqli_query($conn,"SELECT * from balance where account = '$acct' and year=$year order by id ASC") or die(mysqli_error($conn));
            $balance_row = mysqli_fetch_array($balance_query);
            $balance=$balance_row?$balance_row['total_paidup_capital_inbirr']:0;

            $capitalized_query = mysqli_query($conn,"SELECT sum(capitalized_in_birr) as capitalized_in_birr from capitalized where account = '$acct'and year=$year order by id ASC") or die(mysqli_error($conn));
            $capitalized_row = mysqli_fetch_array($capitalized_query);
            $capitalized=$capitalized_row?$capitalized_row['capitalized_in_birr']:0;

            $query_new_request = mysqli_query($conn,"SELECT * from share_request where account = '$acct' order by id ASC") or die(mysqli_error($conn));           
            $request_rows = mysqli_fetch_array($query_new_request);
            $newShare_request=$request_rows?$request_rows['total_share_request']:0;
         
            $share_subscribed=0;
            if($shareValue){
                $share_subscribed=$balance/$shareValue;
            }
            $total_share_subscribed=$share_subscribed+$allotment;
            ?>
            <tr>
                <td></td>
                
                <td><?php echo $a; ?></td>

                <td><?php echo $rows['account_no']; ?></td>

                <td><?php echo $rows['name']; ?></td>

                <td><?php echo number_format($share_subscribed); ?></td>

                <td><?php echo number_format($allotment);?></td>

                <td><?php echo  number_format($total_share_subscribed); ?></td>

                <td><?php echo number_format(($capitalized+$balance)/$shareValue); ?></td>

                <td><?php echo number_format($total_share_subscribed*$shareValue,2); ?></td>
            
                <td><?php echo number_format($capitalized+$balance,2); ?></td>

                <?php 
                        $unpaid_balance = ($total_share_subscribed*$shareValue)-($capitalized+$balance);
                        
                        $unpaid_balance2 = $unpaid_balance; 

                ?>

                <td><?php echo number_format($unpaid_balance2,2); ?></td>                
                <td><?php echo $newShare_request; ?></td>
                <?php }  ?>
            </tr>
            
        </tbody>
        
    </table>


        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th></th>                          
                <th>city </th>
                <th>Sub city </th>
                <th>Woreda</th>
                <th>House no </th>
                <th>P.O.Box</th>
                <th>Telephone Residence</th>
                <th>Telephone Office</th>
                <th>Mobile</th>
                <th>Member</th>
                <th>Reason</th>
                <th>Status</th>                                               
        </thead>
        <tbody>
            
    <?php
  
            $id = $_GET['id'];

            $query = mysqli_query($conn,"SELECT * from shareholders left join shareholder_address on shareholders.account_no=shareholder_address.account  where shareholders.account_no = '$id' order by id ASC") or die(mysqli_error($conn));
            
            $a = 0;
            
            while ($rows = mysqli_fetch_array($query)) {
            
            $a = $a + 1;
            
            $acct =$_GET['id'];

            $status=$rows['currentYear_status'];
            $query2 = mysqli_query($conn,"SELECT * from status where id = $status") or die(mysqli_error($conn));
            $status = mysqli_fetch_array($query2);
            
            ?>
            <tr>
                <td></td>
                <td><?php echo $rows['city']; ?></td>
                <td><?php echo $rows['sub_city']; ?></td>
                <td><?php echo $rows['woreda']; ?></td>                
                <td><?php echo $rows['house_no']; ?></td>                
                <td><?php echo $rows['pobox']; ?></td>
                <td><?php echo $rows['telephone_residence']; ?></td>
                <td><?php echo $rows['telephone_office']; ?></td>                
                <td><?php echo $rows['mobile']; ?></td>                
                <td><?php echo $rows['member']; ?></td>
                <td><?php echo $rows['remark']; ?></td>
                
                <td><?php
                    if($rows['currentYear_status'] == 2){
                        
                        ?>
                        
                        <span class="badge bg-blue"><?php echo $status['status']; ?></span>
                        
                        <?php
                        
                    } else {
                        
                        ?>
                        
                        <span class="badge bg-red"><?php echo $status['status']; ?></span>
                        
                        <?php
                        
                        }
                        
                        ?></td>
                        
                    
                    
                <?php }  ?>
            </tr>
            
        </tbody>
        
    </table>
    
    
    </form> 
</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>

</section><!-- /.content -->

