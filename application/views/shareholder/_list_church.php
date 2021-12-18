<?php
$conn=mysqli_connect('localhost','root','','shareholder');
        if (isset($this->session->userdata['logged_in'])) {
        $username = $this->session->userdata['logged_in']['username'];
        $role = $this->session->userdata['logged_in']['role'];  
        } 
    $budget_query = mysqli_query($conn,"SELECT * FROM budget_year WHERE budget_status = 1");
	 $budget_result = mysqli_fetch_array($budget_query);
	 $from="";
	 $to="";
	 $year= 0;
	 if($budget_result){
	 $from = $budget_result['budget_from'];
	 $to = $budget_result['budget_to'];
	 $year= $budget_result['id'];
	 }
?> 

    

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
                                                <th>initial paid up capital in birr</th>
                                                
                                            </thead>
                                        <tbody>
                
<?php 

 //$from = $_GET['from']; 
 //$to = $_GET['to'];

$query = mysqli_query($conn,"SELECT * from shareholders where share_type = 4 and currentYear_status = 1 order by id ASC") or die(mysqli_error($conn));
                                            
                                            $a = 0;
                                            
                                            while ($rows = mysqli_fetch_array($query)) {
                                                $a = $a + 1;
                                                $acct=$rows['account_no'];
                                                $balance_query = mysqli_query($conn,"SELECT total_paidup_capital_inbirr from balance where account = '$acct' and year=$year") or die(mysqli_error($conn));
                                                $balance_resualt = mysqli_fetch_array($balance_query);
                                                $balance=$balance_resualt?$balance_resualt['total_paidup_capital_inbirr']:0.00;
                                            ?>
                                            <tr>
                                                <td></td>

                                                <td><?php echo $a; ?></td>
                                                
                                                <td><?php echo $rows['account_no']; ?></td>

                                                <td><?php echo $rows['name']; ?></td>
                                                    
                                                <td><?php echo number_format($balance,2); ?></td>

                                               <?php } ?>
                                                
                                            </tr>
                                        </tbody>
       <br><br>
                                    </table>                     
                                    <br><br>
                                    </table>
                                   </form> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
         
