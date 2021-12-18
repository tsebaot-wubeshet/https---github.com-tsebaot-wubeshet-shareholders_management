<?php
$conn=mysqli_connect('localhost','root','','shareholder');
if (isset($this->session->userdata['logged_in'])) {
$username = $this->session->userdata['logged_in']['username'];
} 

?> <style type="text/css">
#searchengine{
margin-left: 40px;
margin-top: 10px;
width: 80%;
float: left;
}
#dividend_top{
margin-left: 300px;
}
#dividend_search{
margin-left: 40px;
margin-top: 10px;

}
</style>
<!-- Main content -->                

<section class="content">
<div class="row" style="width:100%">
<div class="col-sm-12">
<div class="box"><div class="col-sm-4"></div>
<div class="col-sm-6">
<form method="post" action=""><br>
<?php $this->load->view('shareholder/year1'); ?>                         
<select name="name" id="searchengine" class="form-control" required>
<option value="">Select Shareholder</option>
<?php

$budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 'active'");
$budget_result = mysqli_fetch_array($budget_query);

$from="";
$to="";
if($budget_result){
$from = $budget_result['budget_from'];
$to = $budget_result['budget_to'];
}

$result = mysqli_query($conn,"SELECT * FROM shareholders order by account_no");
while($row = mysqli_fetch_array($result))
{
echo '<option value="'.$row['account_no'].'">';
echo $row['account_no']." - ".$row['name'];
echo '</option>';
}
?>

</select>
<button type="submit" name="search" class="btn btn-primary btn-sm" id="dividend_search">Search</button>
</form>
</div>
<div class="box-body table-responsive">
<div class="col-md-12">
<form action="" method="POST">
<table id="example1" class="table table-bordered" style="width:100%">
<thead>
  <tr>

      <th>Account number</th>

      <th>Shareholder Name</th>

      <th>Total Paidup Capital in Birr</th>

      <th>Amount Transfered</th>

      <th>Adjusted Balance</th>

      <th>Adjusted Balance for Dividend</th>

      <th>Dividend Capitalized</th>

      <th>Dividend Payable Capitalized</th>

      <th>Cash Payment</th>

      <th>Total Raised</th>

      <th>Total Paid-Up Capital</th>

      
</thead>
<tbody>

<?php

if(isset($_POST['search'])) {

  $name = $_POST['name'];
  //echo "<h1>".$name."</h1>";
  $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 'active'");
  $budget_result = mysqli_fetch_array($budget_query);
  $from="";
 $to="";
if($budget_result){
  $from = $budget_result['budget_from'];
  $to = $budget_result['budget_to'];
}

  //echo "from-".$from.'<br/>';
  //echo "to-".$to.'<br/>';

    $month = 7; $year1 = date('Y');
    $year1 = date("Y-m-t", mktime(0, 0, 0, $month -1, 1, $year1+1));       
    $month1 = 8; $year2 = date('Y') - 1;
    $year2 = date("Y-m-d", mktime(0, 0, 0, $month1 - 1, 1, $year2+1));
    $year = date('Y', strtotime($year2));
  
  //$year = date('Y');
$result_tra_tra = mysqli_query($conn,"SELECT * FROM transfer WHERE account_no = '$name' and (year BETWEEN '$from' and '$to') and agreement = 'buyer' and status_of_seller = 2 order by account_no");
$row_tra_tra = mysqli_fetch_array($result_tra_tra);
if($row_tra_tra){
?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <?php echo "SHAREHOLDER CLOSED"; ?>
</div>
  
<?php        }else{


$query = mysqli_query($conn,"SELECT * from shareholders where account_no = '$name' group by name order by id ASC") or die(mysqli_error($conn));
      $balance_query = mysqli_query($conn,"SELECT * from balance where account_no = '$name' group by name order by id ASC") or die(mysqli_error($conn));
      $balance_rows = mysqli_fetch_array($balance_query);
      $a = 0;      
   //does one person have more than one account_no?   
  while ($rows = mysqli_fetch_array($query)) {
          
        $a = $a + 1;
        $share_subscribed_inbirr2 = $balance_rows['total_paidup_capital_inbirr'];       
        
      ?>
  
  <tr>

      <td><?php echo $rows['account_no']; ?></td>
      <td><?php echo $rows['name']; ?></td>
      <td><?php echo number_format($share_subscribed_inbirr2,2); ?></td>
      <?php
      
      $result = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where account_no = '$name' and (value_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
      
      while($row = mysqli_fetch_array($result)){

      $result1 = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where raccount_no = '$name' and (value_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
//do sold and bought share have r/ship?
      while($fetch = mysqli_fetch_array($result1)){

      ?>

      <td>&nbsp;<?php echo number_format($fetch['sum(total_transfered_in_birr)'],2); ?><br>(<?php echo number_format($row['sum(total_transfered_in_birr)'],2); } } ?>)</td>

      <?php

      $name = $_POST['name'];

      $shar = mysqli_query($conn,"SELECT * from shareholders where account_no = '$name' and (year BETWEEN '$from' and '$to')") or die(mysqli_error($conn));

      while($shar_row = mysqli_fetch_array($shar)){

      $po_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where account_no = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

      while($po_row = mysqli_fetch_array($po_trans)){

      $neg_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where raccount_no = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

      while($neg_row = mysqli_fetch_array($neg_trans)){

        $share_subscribed_inbirr = ($shar_row['total_share_subscribed'] * 500);

        //print_r($share_subscribed_inbirr);
      ?>

      <td><?php echo number_format($share_subscribed_inbirr2 + $neg_row['sum(total_transfered_in_birr)'] - $po_row['sum(total_transfered_in_birr)'] ,2); } } } ?></td>
      
      <td><?php 

        $shar = mysqli_query($conn,"SELECT * from shareholders where account_no = '$name' and (year BETWEEN '$from' and '$to')") or die(mysqli_error($conn));

        while($shar_row = mysqli_fetch_array($shar)){

        $po_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where raccount_no = '$name' and (value_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
                        
        while($po_row = mysqli_fetch_array($po_trans)){
        
          $neg_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where account_no = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
    
      while($neg_row = mysqli_fetch_array($neg_trans)){

        ?>
        <?php 

        if($po_row['sum(total_transfered_in_birr)'] == '0' && $neg_row['sum(total_transfered_in_birr)'] =='0'){
            
            echo number_format($share_subscribed_inbirr2,2);

          } elseif($po_row['sum(total_transfered_in_birr)'] > '0' && $neg_row['sum(total_transfered_in_birr)'] =='0'){
            
            echo number_format($share_subscribed_inbirr2,2);

          } elseif($neg_row['sum(total_transfered_in_birr)'] > '0' && $share_subscribed_inbirr2 > '0' ) {

            //echo "share subscribed 2".$neg_row['sum(total_transfered_in_birr)'];
        
         echo number_format($share_subscribed_inbirr2 - $neg_row['sum(total_transfered_in_birr)'] ,2); 
        } 
         else {

      echo number_format($share_subscribed_inbirr2,2);

        } } } } ?>

      </td>

      <td><?php

      $result = mysqli_query($conn,"SELECT * from capitalized where account_no = '$name' and type = 'capitalized' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      while($cap = mysqli_fetch_array($result)){

      ?>

      <?php echo number_format($cap['capitalized_in_birr'],2)."<br>"; } ?></td>
    
      <td><?php

      $result = mysqli_query($conn,"SELECT * from capitalized where account_no = '$name' and type = 'payable' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      while($cap = mysqli_fetch_array($result)){

      ?><?php echo number_format($cap['capitalized_in_birr'],2)."<br>"; } ?></td>

      

      <td>
          <?php

      $result = mysqli_query($conn,"SELECT capitalized_in_birr from capitalized where account_no = '$name' and type = 'cash' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      while($cap = mysqli_fetch_array($result)){

      ?>
        <?php echo number_format($cap['capitalized_in_birr'],2)."<br>"; } ?></td>

      <?php

      $result = mysqli_query($conn,"SELECT *,sum(capitalized_in_birr) from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      while($cap = mysqli_fetch_array($result)){

      ?>

      <td><?php echo number_format($cap['sum(capitalized_in_birr)'],2); ?></td>
            
            <td><?php                                                 

            $result = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where account_no = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

            while($row = mysqli_fetch_array($result)){

            $result = mysqli_query($conn,"SELECT *,sum(capitalized_in_birr) from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

            while($cap = mysqli_fetch_array($result)){


            $result1 = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where raccount_no = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

            while($fetch = mysqli_fetch_array($result1)){

              ?>


            <?php echo number_format($share_subscribed_inbirr2 - $row['sum(total_transfered_in_birr)'] + $fetch['sum(total_transfered_in_birr)'] + $cap['sum(capitalized_in_birr)'],2);

              /*echo "Share Subsc".$share_subscribed_inbirr2."<br>";

              echo "Transfered".$row['sum(total_transfered_in_birr)']."<br>";

              echo "Received".$fetch['sum(total_transfered_in_birr)']."<br>";

              echo "Capitalized".$cap['sum(capitalized_in_birr)']."<br>";*/

            }
          }
        }

            ?></td>
            <td></td> 

</tr>
    
</tbody>

</table>
    </div>

      <div class="col-md-12">

<table id="example1" class="table table-bordered table-striped" style="cellspacing:0px" >
<thead>
    <tr>
        
      <th>Value Date</th>

      <th>Breakdown</th>

      <th>Average Paidup Capital</th>

      <th>Sum of the Average Paidup Capital</th>

      <th>Total Paid-up capital utilized during the Year</th>

      <th>Ratio</th>

      <th>Portion of Ordinary Dividend</th>
      
      <th></th>
      <th></th>
      <th></th>
        <!-- value date on dividend report-->
      </tr>
    </thead>
<tbody>

            
      <td><?php

      $result_transfer = mysqli_query($conn,"SELECT * from transfer where account_no = '$name' and agred_to = '$name' || raccount_no = '$name' || both_buyer = '$name' || both_seller = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
      
      while($value_trans = mysqli_fetch_array($result_transfer)) {

        //$account_no = $value_trans['account_no'];
        //print_r($value_trans);
        
      ?><br>__________<br><?php 

          if($value_trans['agreement'] == 'both' && $value_trans['both_seller'] == $name){

            echo $value_trans['transfer_date'];

          } elseif($value_trans['agreement'] == 'both' && $value_trans['both_buyer'] == $name){

            echo $value_trans['value_date'];
            
          } else{
                                                              
          echo $value_trans['value_date']; 

        }

        } 

      $resultv = mysqli_query($conn,"SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      while($value = mysqli_fetch_array($resultv)) {

      ?><br>__________<br><?php echo $value['value_date']; } ?></td> 

      
      <td>
        <?php

      $result_trans_value = mysqli_query($conn,"SELECT * from transfer where status_of_transfer = 'authorized' and account_no = '$name' and agred_to = '$name' or raccount_no = '$name' or both_buyer = '$name' or both_seller = '$name' and (year BETWEEN '$from' and '$to') ") or die(mysqli_error($conn));

      while($cash_trans = mysqli_fetch_array($result_trans_value)) {
        //echo "account number".$name.'<br/>';
        //echo "raccount_no number".$name.'<br/>';
        //echo "agred_to".$name.'<br/>';
        //echo "both_buyer".$name.'<br/>';  
        //echo "both_seller".$name.'<br/>';
        
        //print_r($cash_trans);
      ?><br>__________<br><?php echo number_format($cash_trans['total_transfered_in_birr'],2); } ?>

        <?php

      $resultp = mysqli_query($conn,"SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      while($cash = mysqli_fetch_array($resultp)) {

      ?><br>__________<br><?php echo number_format($cash['capitalized_in_birr'],2); } ?></td>  

      <td><?php

      $resultp = mysqli_query($conn,"SELECT * from transfer where account_no = '$name' and agred_to = '$name' || raccount_no = '$name' || both_buyer = '$name' || both_seller = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

      $results1 = array();

      while($cash = mysqli_fetch_array($resultp)) {

        if($cash['agreement'] == 'both' && $cash['both_seller'] == $name){

            $db_date = $cash['transfer_date'];

          //echo "db date".$db_date;

          } elseif($cash['agreement'] == 'both' && $cash['both_buyer'] == $name){

            $db_date = $cash['value_date'];

            //echo $db_date;
            
          } else {
                                                              
          $db_date = $cash['value_date']; 

          //echo $db_date;

        }

        $month = 7; 

        if($cash['agreement'] == 'both' && $cash['both_seller'] == $name){
            
            $datediff = date('d-m-Y', strtotime($cash['value_date']. ' - 1 days'));
            
          } else {

          $datediff = $to;

        }

          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
          $diff = abs($end_ts - $start_ts);
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        $dif = $diff + 1;
        

        $cap_cash = ($cash['total_transfered_in_birr'] * $dif) / 365;
      ?>
      <br>__________<br><?php echo number_format(round($cap_cash,3),2);  

        $results1[] = $cap_cash;
    } 

    // average paid up capital 
     //echo "SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'";
      $resultp = mysqli_query($conn,"SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      $results = array();

      while($cash = mysqli_fetch_array($resultp)) {

        $db_date = $cash['value_date'];        

        $month = 7; 

        $datediff = $to;
        
          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
          $diff = $end_ts - $start_ts;
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        $dif = $diff + 1;

        $cap_cash = $cash['capitalized_in_birr'] * $dif / 365;
      ?>
      <br>__________<br><?php echo number_format(round($cap_cash,3),2);  

        $results[] = $cap_cash;
    } 
      ?>
      
    </td>  

      <td> 
    <?php

      $resultp = mysqli_query($conn,"SELECT *,SUM(average) from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      while($cash = mysqli_fetch_array($resultp)) {

        $db_date = $cash['value_date'];

        $month = 7; 
        $datediff = $to;

          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
          $diff = $end_ts - $start_ts;
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        //echo $diff;

        $dif = $diff + 1;

        $sum = $cash['capitalized_in_birr'] * $dif / 365;

        $result_sum = $results1 + $results;

        //echo $results1;
        $total_result = array_sum($results1) + array_sum($results);
        ?>
        <?php echo number_format(round(array_sum($results1) + array_sum($results),2),2); 
        } ?></td>  

      <!-- total paid up capital utilized during the year -->

      


      <td><?php     
      

      $name = $_POST['name'];

      $shar = mysqli_query($conn,"SELECT * from shareholders where account_no = '$name' and (year BETWEEN '$from' and '$to')") or die(mysqli_error($conn));

      while($shar_row = mysqli_fetch_array($shar)){

        $share_subscribed_inbirr = ($shar_row['total_paidup_capital_inbirr']); //238,500

      $po_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where raccount_no = '$name' and (value_date BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
                        
        while($po_row = mysqli_fetch_array($po_trans)){
        
      $neg_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where account_no = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

      while($neg_row = mysqli_fetch_array($neg_trans)){             

        //$share_subscribed_inbirr2 - $po_row['sum(total_transfered_in_birr)'];

        //echo number_format($adjusted_balance ,2);

  if($po_row['sum(total_transfered_in_birr)'] == '0' && $neg_row['sum(total_transfered_in_birr)'] =='0'){
            
            $adjusted_balance = $share_subscribed_inbirr2;
            
          } elseif($po_row['sum(total_transfered_in_birr)'] > '0' && $neg_row['sum(total_transfered_in_birr)'] =='0'){
            
            $adjusted_balance = $share_subscribed_inbirr2;
            //echo number_format($adjusted_balance,2);
          } elseif($neg_row['sum(total_transfered_in_birr)'] > '0' && $share_subscribed_inbirr2 > '0' ) {
        
            $adjusted_balance = $share_subscribed_inbirr2 - $neg_row['sum(total_transfered_in_birr)'].'<br/>';
              
        
      } else{

            $adjusted_balance = $share_subscribed_inbirr2;
                        //echo number_format($adjusted_balance,2);

        } }                 
      //echo "SELECT *,SUM(average) from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'";
      //SUM(average) has no meaning
      $resultp = mysqli_query($conn,"SELECT *,SUM(average) from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      while($cash = mysqli_fetch_array($resultp)) {

        if($po_row['agreement'] == 'both' && $po_row['both_seller'] == $name){

            $db_date = $po_row['transfer_date'];

            //echo $db_date;

          } elseif($po_row['agreement'] == 'both' && $po_row['both_buyer'] == $name){

            $db_date = $po_row['value_date'];

            //echo $db_date;
            
          } else {
                                                              
          $db_date = $po_row['transfer_date']; 
      
        }

        $month = 7; 

        if($po_row['agreement'] == 'both' && $po_row['both_seller'] == $name){

                            
            $datediff = $po_row['value_date'];
          } else {

          $datediff = $to;
          

        }

          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
          $diff = $end_ts - $start_ts;
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        $dif = $diff + 1;

        $sum = $cash['capitalized_in_birr'] * $dif / 365;

        $array_result = array_sum($results);

        $po_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where account_no = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

      while($po_row = mysqli_fetch_array($po_trans)){

      $neg_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where raccount_no = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

      while($neg_row = mysqli_fetch_array($neg_trans)){

        $resultp = mysqli_query($conn,"SELECT * from transfer where account_no = '$name' || raccount_no = '$name' || agred_to = '$name' || both_buyer = '$name' || both_seller = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
//logical error
      $results1 = array();

      while($cash = mysqli_fetch_array($resultp)) {

        if($cash['agreement'] == 'both' && $cash['both_seller'] == $name){

            $db_date = $cash['transfer_date'];

            //echo $db_date;

          } elseif($cash['agreement'] == 'both' && $cash['both_buyer'] == $name){

            $db_date = $cash['value_date'];

            //echo $db_date;
            
          } else {
                                                              
          $db_date = $cash['value_date']; 

          //echo $db_date;

        }

        $month = 7; 

        if($cash['agreement'] == 'both' && $cash['both_seller'] == $name){

            
            $datediff = date('d-m-Y', strtotime($cash['value_date']. ' - 1 days'));   
            
          } else {

          $datediff = $to;

        }

          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
          $diff = $end_ts - $start_ts;
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        $dif = $diff + 1;

        //echo $cash['total_transfered_in_birr'];

        $cap_cash = ($cash['total_transfered_in_birr'] * $dif) / 365;
    // echo number_format(round($cap_cash,3),2);  

        $results1[] = $cap_cash;
    } 

    // average paid up capital 
      // echo "SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'";
      $resultp = mysqli_query($conn,"SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

      $results = array();

      while($cash = mysqli_fetch_array($resultp)) {

        $db_date = $cash['value_date'];

        $month = 7; 

        $datediff = $to;

          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
          $diff = $end_ts - $start_ts;
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        $dif = $diff + 1;

        $cap_cash = $cash['capitalized_in_birr'] * $dif / 365;

      ?>
      <?php //echo number_format(round($cap_cash,3),2);  

        $results[] = $cap_cash;

    } 

        $total_sum = $array_result + $share_subscribed_inbirr2 - $po_row['sum(total_transfered_in_birr)'];
        
        $total_paidup_value = round(array_sum($results),2) + $share_subscribed_inbirr2 - $po_row['sum(total_transfered_in_birr)'];
        
        //echo $po_row['sum(total_transfered_in_birr)'] + $neg_row['sum(total_transfered_in_birr)'];

        //echo number_format(round(array_sum($results),2),2);
        //echo "array sum".array_sum($results);
        //echo $share_subscribed_inbirr2 - $po_row['sum(total_transfered_in_birr)'] + $neg_row['sum(total_transfered_in_birr)'];
        //echo "po row".$po_row['sum(total_transfered_in_birr)'];
        ?>
        <?php echo number_format(round($total_result,2) + $adjusted_balance,2);
                
           ?></td>  

        <input type="hidden" name="total_paidup" value="<?php //echo $total_paidup_value; ?>">

      <td>

    <?php

    $total_final = mysqli_query($conn,"SELECT * from total_paidup_utilized where year = '$year'") or die(mysqli_error($conn));
    
    //$total_utilized= array_sum($results1) + array_sum($results);

    $total_utilized= array_sum($results1) + array_sum($results) + $adjusted_balance;

    //echo $total_utilized;

    $year = date("Y");    

    $total_row = mysqli_fetch_array($total_final);
    
    //echo number_format($total_row['value'],2);sprintf('%f', $var);

       
    $ratio = $total_utilized/$total_row['value'];

    //echo sprintf('%.10f',$ratio);
    
   } } } } } ?>    

      </td>  


      </td>  

      <td><?php

      $shar = mysqli_query($conn,"SELECT * from shareholders where account_no = '$name' and (year BETWEEN '$from' and '$to')") or die(mysqli_error($conn));

      while($shar_row = mysqli_fetch_array($shar)){

      $po_trans = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where agred_to = '$name' || both_buyer = '$name' || both_seller = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

      while($po_row = mysqli_fetch_array($po_trans)){
                                                  

      $paidup = mysqli_query($conn,"SELECT * from total_paidup_utilized where year = '$year'") or die(mysqli_error($conn));

      while($total_paidup_utilized = mysqli_fetch_array($paidup)) {

        $dividend_amt = mysqli_query($conn,"SELECT * from dividend_amount where year = '$year'") or die(mysqli_error($conn));

      while($div_amt = mysqli_fetch_array($dividend_amt)) {

        $paidup_capital = $total_paidup_utilized['value'];

        $dividend = $div_amt['dividend'];

        $db_date = $cash['value_date'];

        $month = 7; //$year = date('Y');

        $datediff = $to;

          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
          $diff = $end_ts - $start_ts;
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        //echo $diff;

        $dif = $diff + 1;

        $sum = $cash['capitalized_in_birr'] * $dif / 365;

        $dividend_portion = $ratio*$dividend;
        ?>

        

        <?php echo number_format($dividend_portion,2); } } } } ?></td>  

</td>  


      <td><?php

          $average = mysqli_query($conn,"SELECT * from transfer where account_no = '$name' and agred_to = '$name' || raccount_no = '$name' || both_buyer = '$name' || both_seller = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

          while($av = mysqli_fetch_array($average)){

          if($av['agreement'] == 'both' && $av['both_seller'] == $name){

            $db_date = $av['transfer_date'];

          } elseif($av['agreement'] == 'both' && $av['both_buyer'] == $name){

            $db_date = $av['value_date'];
            
          } elseif($av['agreement'] == 'buyer' && $av['agred_to'] == $name && $av['account_no'] == 'NIB') {
                                                              
          $db_date = $av['value_date']; 

        } else { 

        $db_date = $av['value_date'];
      }
      
          $month = 7; //$year = date('Y');

          if($av['agreement'] == 'both' && $av['both_seller'] == $name){
            
            $datediff = date('d-m-Y', strtotime($av['value_date']. ' - 1 days'));

          } elseif($av['agreement'] == 'buyer' && $av['agred_to'] == $name && $av['account_no'] == 'NIB'){

              $check_more_transfer1 = mysqli_query($conn,"SELECT * from transfer where account_no = '$name' and agreement = 'seller' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
      
      while($check_transfer1 = mysqli_fetch_array($check_more_transfer1)){

        $datediff = $check_transfer1['value_date'];  
        
      }
          
          } elseif($av['agreement'] == 'seller' && $av['agred_to'] == $name && $av['account_no'] == '$name'){

            $datediff = $av['value_date'];
          
          }else {

          $datediff = $to;

        }
//print_r($datediff);
          
          ?><br>__________<br><?php 

          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {

          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
          $diff = $end_ts - $start_ts;
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        echo $diff + 1;

          } 
          // echo "SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'";
          $average = mysqli_query($conn,"SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

          while($av = mysqli_fetch_array($average)){

          $db_date = $av['value_date'];

          
          
          $month = 7; //$year = date('Y');

          $datediff = $to;                  

          ?><br>__________<br><?php 

          if (!function_exists("dateDiff")){

          function dateDiff($start, $end) {
          $start_ts = strtotime($start);
          $end_ts = strtotime($end);
            $diff = $end_ts - $start_ts;
          return round($diff / 86400);
        }
      }

        $diff = dateDiff($db_date, $datediff);

        echo $diff + 1;  

          }

          ?></td>  

      <td>

      <?php 

      $month = 7; 
      
      $average = mysqli_query($conn,"SELECT * from transfer where account_no = '$name' and agred_to = '$name' || raccount_no = '$name' || both_buyer = '$name' || both_seller = '$name' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));

      while($av = mysqli_fetch_array($average)){

        //print_r($av['agreement']);

      if($av['agreement'] == 'both' && $av['both_seller'] == $name){

        $datediff = date('d-m-Y', strtotime($av['value_date']. ' - 1 days'));
            
      } elseif($av['agreement'] == 'both' && $av['both_buyer'] == $name){

            $datediff = $to;

      } elseif($av['agreement'] == 'buyer' && $av['agred_to'] == $name && $av['account_no'] == 'NIB'){

      $check_more_transfer = mysqli_query($conn,"SELECT * from transfer where account_no = '$name' and agreement = 'seller' and (year BETWEEN '$from' and '$to') and status_of_transfer = 'authorized'") or die(mysqli_error($conn));
      
      while($check_transfer = mysqli_fetch_array($check_more_transfer)){

        $datediff = $check_transfer['value_date'];  
        
      }
    } else {

            $datediff = $to;                                               

    }     

    ?><br>__________<br>

    <?php

    echo $datediff;

    //echo date("Y-m-t", mktime(0, 0, 0, $month - 1, 1, $year));;

    //echo $datediff;

    }

    $average_cash = mysqli_query($conn,"SELECT * from capitalized where account_no = '$name' and (year BETWEEN '$from' and '$to') and capitalized_status = 'authorized'") or die(mysqli_error($conn));

    while($cash = mysqli_fetch_array($average_cash)){           
                  

    ?><br>__________<br>

    <?php
    

      echo date("Y-m-t", mktime(0, 0, 0, $month - 1, 1, $year)); 
  
}
      ?>


</td>  

<td></td>   <?php } } }    } ?>
      
  </tr>
  
</tbody>
<tfoot>
<tr >
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td style="background-color: purple; color:white">
    <?php
    $year = date("Y")-3;
    $total_final = mysqli_query($conn,"SELECT * from total_paidup_utilized where year = '$year'") or die(mysqli_error($conn));
    $total_row = mysqli_fetch_array($total_final);
    //echo number_format($total_row['value'],2);

    ?>
  </td>
    <td></td>
    
  <td></td>
    
  <td></td>

  <td></td>
  <td></td>
            
  
</tr>
</tfoot>
</table>
</form> 
</div>
</div>
</div>
</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>

</section><!-- /.content -->

