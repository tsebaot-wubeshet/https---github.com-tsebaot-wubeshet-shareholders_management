<?php
$conn=mysqli_connect('localhost','root','','shareholder'); 
if (isset($this->session->userdata['logged_in'])) {

$username = $this->session->userdata['logged_in']['username'];
$role = $this->session->userdata['logged_in']['role'];  
$userId = $this->session->userdata['logged_in']['id'];    
} 
?> 
<?php
  if(isset($_POST['transfer'])){
    if(isset($_POST['account_to']) && isset($_POST['account_from']) && isset($_POST['id_from']) && isset($_POST['transfer'])){
      $id=$_POST['id_from'];
  
      $transfer_from= $_POST['account_from'];
      $capitalized_in_birr_from= $_POST['capitalized_in_birr_from'];
      $capitalized_in_birr= $_POST['capitalized_in_birr'];

      if($capitalized_in_birr_from >= $capitalized_in_birr)
      {  
        $account= $_POST['account_to'];        
        $updatedCapital=$capitalized_in_birr_from- $capitalized_in_birr;
        $value_date= $_POST['value_date'];
        $type= $_POST['type'];
       
        $result1 = mysqli_query($conn,"INSERT INTO capitalized (account,capitalized_in_birr,value_date,capitalized_status,type,transfer_from,maker,checker,year) values('$account',$capitalized_in_birr, '$value_date',4,$type,'$transfer_from',$userId,$userId, $year)") or die(mysqli_error($conn));               
        $result4 = mysqli_query($conn,"UPDATE capitalized SET capitalized_in_birr = $updatedCapital, checker=$userId where id=$id ")or die(mysqli_error($conn));            ?>
        <div class="alert alert-success alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>Success!</b> capitalized transfer was Successful!.
</div>
<?php
       // header('location:/shareholder_new/shareholder/transfer_cap_cash_pay?transfer=ok');
      }else{
        ?> 
         <div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>Error!</b> capitalized transfer was not Successful!.
</div>
        <?php
       // header('location:/shareholder_new/shareholder/transfer_cap_cash_pay?acct='.$transfer_from.'&id='.$id.'&transfer=error');  
      }
    }
  }
  
                      
  ?>
<?php if(isset($_GET['transfer'])){ 
  if($_GET['transfer'] == 'ok') {?>
    

    
<?php } else { ?>
 
  <?php }} ?>
                <!-- Main content -->
                <section class="content">
                     <div class="row" style="width:100%">
                        <div class="col-xs-12">
                           <div class="box">
                           <div id="homepage_search">

                                    <form method="post" action=""><br/>

                                    <?php echo $this->load->view('shareholder/year1'); ?><br>                          

                                    <div class="col-xs-6">
                                        <label for="ex3">Please Enter Account No or Shareholder name </label>
                                        <input class="form-control" id="ex3" type="text" name="key"><br/>
                                        <button type="submit" name="search" id="homepage_search_btn" class="btn btn-primary btn-sm">Search</button>

                                    </div>
                                    <div class="col-xs-6">

                                    </div>                           

                                    </form>

                                    </div>
                                <div class="box-body table-responsive">
                                <form action="" method="POST">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>  
                                                <th></th>  
                                                <th>Account number</th>
                                                <th>Shareholder Name</th>
                                                <th>Value Date</th>                                                
                                                <th>Capitlized in Birr</th>
                                                <th>Payment Type</th>
                                                <th>Click the link to transfer</th>
                                               </tr>
                                        </thead>
                                        <tbody> 
                             
                           
                          <?php 
                               $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
                               $budget_result = mysqli_fetch_array($budget_query);
                               $from="";
                              $to="";
                              $year=0;
                             if($budget_result){
                               $from = $budget_result['budget_from'];
                               $to = $budget_result['budget_to'];
                               $year= $budget_result['id'];
                             }
                                    if(isset($_POST['search'])){

                                      if (isset($_GET['acct'])&& isset($_GET['id']) ){
                                        unset($_GET['id']);
                                        unset($_GET['acct']);
                                      }
                                          $key = $_POST['key'];
                                          $query = mysqli_query($conn,"SELECT capitalized.*, shareholders.name from capitalized left join shareholders on capitalized.account=shareholders.account_no  where capitalized.capitalized_status = 4  AND year = $year order by capitalized.id DESC") or die(mysqli_error($conn));
                                          if($key){
                                          $query = mysqli_query($conn,"SELECT capitalized.*, shareholders.name from capitalized left join shareholders on capitalized.account=shareholders.account_no  where capitalized.capitalized_status = 4 AND (shareholders.name LIKE '$key%' || capitalized.account LIKE '$key%') AND year = $year order by capitalized.id DESC") or die(mysqli_error($conn));
                                          }
                                         while ($rows = mysqli_fetch_array($query)) {

                                          $id = $rows['id'];
                                          $capitalized_type=$rows['type'];
                                          $capitalized_type_query = mysqli_query($conn,"SELECT * FROM capitalized_type where id=$capitalized_type");
                                          $capitalized_type_result = mysqli_fetch_array($capitalized_type_query);
  

                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            <!-- <td><input type="checkbox" name="applist[]" value="<?php //echo $rows['id'];?>"></td>
                                            <td><input type="checkbox" name="selector[]" value="<?php //echo $rows['account_no'];?>"></td> -->
                                            <td><?php echo $rows['account']; ?></td>
                                            <td><?php echo $rows['name']; ?></td>   
                    
                                                <td><?php echo $rows['value_date']; ?> </td>
                                
                                                <td><?php echo $rows['capitalized_in_birr']; ?></td>
                                                <td><?php echo $capitalized_type_result['type']; ?></td>

                                                 <td><a href="<?php echo base_url();?>shareholder/transfer_cap_cash_pay?acct=<?php echo $rows['account']; ?>&id=<?php echo $rows['id']; ?>">Transfer <?php echo $capitalized_type_result['type']; ?></a></td>
                                               
                                            </tr>

                             <?php  } }  ?>

                                        </tbody>
                                <br><br>

                                   </form> 
                                   <form action="" method="POST">
<?php 
  if (isset($_GET['acct'])&& isset($_GET['id']) ){
    $id=$_GET['id'];
    $account=$_GET['acct'];
    
    $query_cap = mysqli_query($conn,"SELECT * from capitalized where id=$id and account=$account and capitalized_status = 4 ") or die(mysqli_error($conn)); 
    $row_cap = mysqli_fetch_array($query_cap);

?>
<br/>
<br/>
<hr>
  <form>
      <div class="form-group">            
        <label>Transfer to</label> 
        <select name="account_to" required class="form-control">
          <option value="">Select Name of Shareholder</option>
          <?php
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

      <div class="form-group">
        <input type="hidden" readonly name="value_date" value="<?php echo $row_cap['value_date']; ?>"/>
        <input type="hidden" readonly name="account_from" value="<?php echo $row_cap['account']; ?>"/>
        <input type="hidden" readonly name="id_from" value="<?php echo $row_cap['id']; ?>"/>
        <input type="hidden" readonly name="type" value="<?php echo $row_cap['type']; ?>"/>
      </div>

      

      <div class="form-group">
      <label> Maximum capitalized can be transferred (birr)</label>
        <input type="text" readonly required name="capitalized_in_birr_from" value="<?php echo $row_cap['capitalized_in_birr']; ?>">
      </div>

      <div class="form-group">
      <label>How many capitalized to be transferred (birr)</label>
        <input type="text" required name="capitalized_in_birr" value="<?php echo set_value('capitalized_in_birr'); ?>" placeholder="Enter transfer amount..."/>
      </div>

      <div class="form-group">
        <button type="submit" name="transfer" class="btn btn-primary btn-sm">Transfer</button>
      </div>

      <input type="hidden" readonly name="id" value="<?php echo $id; ?>">
        
    <?php } ?>
  </form>                         
  
                                  
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         