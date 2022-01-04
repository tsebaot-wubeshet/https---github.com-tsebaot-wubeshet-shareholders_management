<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {

    $username = $this->session->userdata['logged_in']['username'];
}

?>
<script>
    function format(input) {
        var num = input.value.replace(/\,/g, '');
        if (!isNaN(num)) {
            if (num.indexOf('.') > -1) {
                num = num.split('.');
                num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1').split('').reverse().join('').replace(/^[\,]/, '');
                if (num[1].length > 2) {
                    alert('You may only enter two decimals!');
                    num[1] = num[1].substring(0, num[1].length - 1);
                }
                input.value = num[0] + '.' + num[1];
            } else {
                input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1').split('').reverse().join('').replace(/^[\,]/, '')
            };
        } else {
            alert('You may enter only Decimal numbers in this field!');
            input.value = input.value.substring(0, input.value.length - 2);
        }
    }
</script>
<script>
    function showUser(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "<?php echo base_url(); ?>shareholder/getuserdetail?q=" + str, true);
            xmlhttp.send();
        }
    }
</script>
<?php

if (isset($_POST['reject']) && isset($_POST['id'])) {

    //$account_no = $_POST['selector'];

    foreach ($_POST['id'] as $cap_del) {

        $id = array();
        array_push($id, $cap_del);

        $N = count($id);

        $query_cap = mysqli_query($conn, "SELECT * from capitalized where 
    capitalized_status = 'pending' AND type = 'cash' AND id = '$cap_del'") or die(mysqli_error($conn));

        $row_cap1 = mysqli_fetch_array($query_cap);
        $value_date = $row_cap1['value_date'];

        $capitalized_in_birr = $row_cap1['capitalized_in_birr'];
        $capitalized_in_share = $row_cap1['capitalized_in_share'];
        $name = $row_cap1['name'];
        $account_no2 = $row_cap1['account_no'];
        $type = $row_cap1['type'];
        $year = $row_cap1['year'];
        $capitalized_status = $row_cap1['capitalized_status'];


        for ($i = 0; $i < $N; $i++) {

            $result_cap = mysqli_query($conn, "INSERT INTO rejected_capitalized (value_date,capitalized_in_birr,capitalized_in_share,name,account_no,type,year,capitalized_status) VALUES ('$value_date','$capitalized_in_birr','$capitalized_in_share','$name','$account_no2','$type','$year','$capitalized_status')") or die(mysqli_error($conn));

            $result_delete = mysqli_query($conn, "DELETE FROM capitalized WHERE capitalized_status = 'pending' AND id='$cap_del'") or die(mysqli_error($conn));

            header('location:authorize_cashpayment?reject=true');
        }
    }
}
?>
<?php
if (isset($_GET['cash'])) {
?>
    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Data added to the pool for authorization </b> .
    </div>
<?php } ?>
<!-- general form elements disabled -->
<div class="box box-warning">
    <div class="col-md-12">
        <div class="col-md-4">
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

                <?php if ($this->session->flashdata('flashError')) : ?>

                    <p class='flashMsg flashError alert alert-danger alert-dismissable'> <?php echo $this->session->flashdata('flashError') ?> </p>
                <?php endif ?>

                <form action="" method="POST" role="form" name='myForm'>
                    <?php
                    $id = $_GET['id'];
                    $account = $_GET['account'];
                    $amount = $_GET['amount'];
                    $type = $_GET['type'];
                    $transfer_value_date = $_GET['vd'];

                    ?>
                    <input type="hidden" readonly="" value="<?php echo $account; ?>" name="transfer_from_account_no" class="form-control" />
                    <input type="hidden" readonly="" value="<?php echo $amount; ?>" name="amount" class="form-control" />
                    <input type="hidden" readonly="" value="<?php echo $type; ?>" name="type" class="form-control" />
                    <input type="hidden" readonly="" value="<?php echo $transfer_value_date; ?>" name="transfer_value_date" class="form-control" />


                    <div class="form-group">
                        <label>Transfer From Account Number</label>
                        <input type="text" readonly onkeyup="javascript:this.value=Comma(this.value);" value="<?php echo $account; ?>" name="transfer_from" class="form-control" placeholder="Enter ..." required />

                    </div>
                    <div class="form-group">
                        <label>Amount in birr</label>
                        <input type="text" readonly onkeyup="javascript:this.value=Comma(this.value);" value="<?php echo $amount; ?>" name="transfer_from_amount" class="form-control" placeholder="Enter ..." required />

                    </div>
                    <div class="form-group">
                        <label>Type of Payment</label>
                        <input type="text" readonly onkeyup="javascript:this.value=Comma(this.value);" value="<?php echo $type; ?>" name="type_of_payment" class="form-control" placeholder="Enter ..." required />

                    </div>
                    <div class="form-group">
                        <label>Value date</label>
                        <input type="text" readonly onkeyup="javascript:this.value=Comma(this.value);" value="<?php echo $transfer_value_date; ?>" name="value_of_payment" class="form-control" placeholder="Enter ..." required />

                    </div>

                    <div class="form-group">

                        <label> Transfer to </label>

                        <select name="transfer_to_account" class="form-control" required onchange="showUser(this.value)">
                            <option value="">Select Shareholder Name</option>
                            <?php

                            $result = mysqli_query($conn, "SELECT * FROM shareholders WHERE status != 2 order by account_no");
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="' . $row['account_no'] . '">';
                                echo $row['account_no'] . "-" . $row['name'];
                                echo '</option>';
                            }
                            ?>

                        </select>

                    </div>
                    <div id="txtHint"></div>
                    <div class="form-group">
                        <label>Cash Amount to be transfered</label>
                        <input type="text" onkeyup="javascript:this.value=Comma(this.value);" name="cash_tobe_transfered" class="form-control" placeholder="Enter ..." required />

                    </div>

                    <input type="hidden" readonly="" value="<?php echo $username; ?>" name="blocked_by" class="form-control" />
                    <input type="text" readonly="" value="<?php echo $id; ?>" name="id" class="form-control" />

                    <div class="box-footer">

                        <button type="submit" class="btn btn-primary" name="submit">Add</button>
                    </div>



                    <?php
                    if (isset($_POST['submit'])) {

                        $name = $_POST['name'];

                        $transfer_from_amount = $_POST['transfer_from_amount'];

                        $capitalized_in_birr_result = $_POST['cash_tobe_transfered'];

                        $capitalized_in_birr = preg_replace('/[ ,]+/', '', trim($capitalized_in_birr_result));

                        $capitalized_share = $capitalized_in_birr / 500;

                        $transfer_to_account_no = $_POST['transfer_to_account_no'];

                        $transfer_from_account_no = $_POST['transfer_from_account_no'];

                        $transfer_to_value_date = $_POST['transfer_value_date'];

                        $type = $_POST['type'];

                        $year = date('Y-m-d');

                        $id = $_POST['id'];

                        mysqli_query($conn, "INSERT into capitalized (name,capitalized_in_share,capitalized_in_birr,value_date,type,account_no,year,capitalized_status,status_type,authorized_by,transfer_from) values 
                                            ('$name','$capitalized_share','$capitalized_in_birr','$transfer_to_value_date','$type','$transfer_to_account_no','$year','distribute','tobededuct','$username','$transfer_from_account_no')") or die(mysqli_error($conn));

                        //mysqli_query($conn,"UPDATE shareholders set total_share_subscribed = total_share_subscribed + '$capitalized_share',total_share_subscribed_inbirr = total_share_subscribed_inbirr + '$capitalized_in_birr' where name = '$name'") or die(mysqli_error($conn));
                        //mysqli_query($conn,"UPDATE shareholders set total_paidup_capital_inbirr = total_paidup_capital_inbirr + '$capitalized_in_birr' where name = '$name'") or die(mysqli_error($conn));

                        header('location:edit_distribute?cash=paid&id=' . $id . '&account=' . $transfer_from_account_no . '&amount=' . $transfer_from_amount . '&type=' . $type . '&vd=' . $transfer_to_value_date . '');
                    }
                    ?>


                </form>
            </div><!-- /.box-body -->

        </div>








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
                                            <th></th>
                                            <th>Account no</th>
                                            <th>Value Date</th>
                                            <th>Cash paid</th>
                                            <th>Shareholder Name</th>
                                            <th>Payment type</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $query = mysqli_query($conn, "SELECT * from capitalized where 
        capitalized_status = 'distribute' and status_type='tobededuct' ") or die(mysqli_error($conn));

                                        $a = 0;

                                        while ($rows = mysqli_fetch_array($query)) {
                                            $a = $a + 1;

                                            $id = $rows['id'];

                                        ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><input type="checkbox" name="id[]" value="<?php echo $rows['id']; ?>"></td>

                                                <td><?php echo $rows['account_no']; ?></td>
                                                <td><?php echo $rows['value_date']; ?></td>
                                                <td><?php echo $rows['capitalized_in_birr']; ?></td>
                                                <td><?php echo $rows['name']; ?></td>
                                                <td><?php echo $rows['type']; ?></td>

                                                <input type="hidden" name="value_date[]" value="<?php echo $rows['value_date']; ?>">
                                                <input type="hidden" name="name[]" value="<?php echo $rows['name']; ?>">

                                                <input type="hidden" name="capitalized_in_share[]" value="<?php echo $rows['capitalized_in_share']; ?>">
                                                <input type="hidden" name="account_no[]" value="<?php echo $rows['account_no']; ?>">

                                                <input type="hidden" name="type[]" value="<?php echo $rows['type']; ?>">
                                                <input type="hidden" name="capitalized_in_birr[]" value="<?php echo $rows['capitalized_in_birr']; ?>">
                                                <input type="hidden" name="year[]" value="<?php echo $rows['year']; ?>">
                                                <input type="hidden" name="capitalized_status[]" value="<?php echo $rows['capitalized_status']; ?>">
                                                <input type="hidden" name="transfer_from" value="<?php echo $rows['transfer_from']; ?>">
                                                <input type="hidden" name="typeofpay" value="<?php echo $rows['type']; ?>">

                                                <input type="hidden" name="cap[]" value="<?php echo $rows['capitalized_in_birr']; ?>">
                                                <input type="hidden" name="id" value="<?php echo $rows['id']; ?>">

                                                <td><a href="">edit</a></td>
                                                <td><a href="">delete</a></td>


                                            <?php } ?>

                                            </tr>

                                    </tbody>



                                    <fieldset>
                                        <button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
                                        <button type="submit" name="reject" class="btn btn-danger"><i class="glyphicon glyphicon-ok"></i> Reject</button>
                                    </fieldset>
                                    <br><br>
                                </table>

                                <?php

                                if (isset($_POST['authorize']) && isset($_POST['id']) && isset($_POST['transfer_from'])) {

                                    $acct = $_POST['transfer_from'];
                                    $typeof = $_POST['typeofpay'];
                                    $id = $_POST['id'];
                                    /*
    echo "*******top data *********".'<br/>';
        echo "acct".$acct.'<br/>';//1824
        echo "typeof".$typeof.'<br/>';//cash
        echo "id".$id.'<br/>';//cash
        */
                                    $cap_query = mysqli_query($conn, "SELECT * FROM capitalized where capitalized_status = 'distribute' and status_type = 'tobededuct' and type='$typeof' and transfer_from='$acct'");

                                    while ($cap_row = mysqli_fetch_array($cap_query)) {

                                        //echo "id from distriubte and tobededuct result".$id.'<br/>';//4832id
                                        $id = $cap_row['id'];
                                        $result1 = mysqli_query($conn, "SELECT * FROM capitalized where capitalized_status = 'distribute' and transfer_from='$acct'");
                                        $buyyer_row = mysqli_fetch_array($result1);
                                        /*
        echo "captalized status - ".$buyyer_row['capitalized_status'].'<br/>'; 
       echo "transfer from - ".$buyyer_row['transfer_from'].'<br/>';
       echo "status type - ".$buyyer_row['status_type'].'<br/>';
       echo "id - ".$buyyer_row['id'].'<br/>';
        */
                                        $result = mysqli_query($conn, "UPDATE capitalized SET capitalized_status = 'authorized',status_type='' WHERE id='$id' ");

                                        //$result = mysqli_query($conn,"SELECT * FROM capitalized where capitalized_status = 'distribute' and transfer_from='$acct'");

                                        //$buyyer_row = mysqli_fetch_array($result);
                                        $buyyer_acct_no = $cap_row['account_no'];
                                        $capitalize_in_birr = $cap_row['capitalized_in_birr'];
                                        $capitalize_in_share = $capitalize_in_birr / 500;
                                        /*
        echo "*******capitalize *********".'<br/>';
        echo "buyyer acct no".$buyyer_acct_no.'<br/>';//5763
        echo "capitalized in birr".$capitalize_in_birr.'<br/>';//17500
        echo "capitalize in share".$capitalize_in_share.'<br/>';//35
        */
                                        /************************************************************/
                                        // manage shareholder table data 
                                        /************************************************************/

                                        $buyyer_shareholder = mysqli_query($conn, "SELECT * FROM shareholders where status = 'active' and account_no='$buyyer_acct_no'");
                                        $buyyer_share_row = mysqli_fetch_array($buyyer_shareholder);
                                        $buyyer_total_share_subscribed = $buyyer_share_row['total_share_subscribed'];
                                        $buyyer_total_share_paidup = $buyyer_share_row['total_paidup_capital_inbirr'];
                                        $buyyer_subscribe_diff = $buyyer_total_share_subscribed - $capitalize_in_share;
                                        $buyyer_paidup_diff = $buyyer_total_share_paidup - $capitalize_in_birr;
                                        /*
        echo "*******sharedata *********".'<br/>';
        echo "buyyer total share subscribed".$buyyer_total_share_subscribed.'<br/>';
        echo "buyyer total share paidup".$buyyer_total_share_paidup.'<br/>';
        echo "capitalize in share".$capitalize_in_share.'<br/>';
        echo "capitalize in birr".$capitalize_in_birr.'<br/>';
        echo "buyyer_paidup_diff". $buyyer_paidup_diff.'<br/>';
        */
                                        $updated_shareholder_result = mysqli_query($conn, "UPDATE shareholders SET total_share_subscribed = '$buyyer_subscribe_diff',total_paidup_capital_inbirr = '$buyyer_paidup_diff' where account_no = '$buyyer_acct_no' ");

                                        /************************************************************/
                                        // manage transfer table data 
                                        /************************************************************/

                                        $buyyer_transfer = mysqli_query($conn, "SELECT * FROM transfer where status_of_transfer = 'authorized' and account_no='$acct' and raccount_no = '$buyyer_acct_no' and status_of_seller = 2");
                                        $buyyer_transfer_row = mysqli_fetch_array($buyyer_transfer);

                                        $buyyer_total_share_transfered = $buyyer_transfer_row['total_share_transfered'];
                                        $buyyer_total_transfer_diff = $buyyer_total_share_transfered - $capitalize_in_share;
                                        $buyyer_total_transfer_diff_in_birr = $buyyer_total_transfer_diff * 500;

                                        $updated_transfer_result = mysqli_query($conn, "UPDATE transfer SET total_share_transfered = '$buyyer_total_transfer_diff',total_transfered_in_birr = '$buyyer_total_transfer_diff_in_birr' where raccount_no = '$buyyer_acct_no' and account_no = '$acct' and status_of_transfer = 'authorized' ");
                                        /*
        echo "*******transfer data*********".'<br/>';
        echo "acct".$acct.'<br/>';
        echo "buyyer_acct_no".$buyyer_acct_no.'<br/>';
        
        echo "buyyer total share transfered".$buyyer_total_share_transfered.'<br/>';
        echo "capitalize in share".$capitalize_in_share.'<br/>';
        echo "buyyer_total_transfer_diff".$buyyer_total_transfer_diff.'<br/>';
        */


                                        //$select_transferer = mysqli_query($conn,"SELECT * FROM capitalized where capitalized_status = 'authorized' and type ='$typeof' and account_no ='$acct' ");
                                        //$seller_result = mysqli_query($conn,"UPDATE capitalized SET capitalized_status = 'already_transfered' WHERE account_no = '$acct' and id='$id'");
                                        /*   
    echo "id----".$id.'<br/>'; 
    echo "acct----".$acct.'<br/>';   
    $result34 = mysqli_query($conn,"SELECT * FROM capitalized where id='$id'")or die(mysqli_error($conn));
    $buy = mysqli_fetch_array($result34);
    $account_num =  $buy['transfer_from'];
    */
                                    }
                                    /*
    echo "account no from transfer from buy  ----".$buy['transfer_from'].'<br/>';  
    $seller_id = $_GET['id'];
    echo "id from seller ----".$seller_id.'<br/>';
    $result54 = mysqli_query($conn,"SELECT * FROM capitalized WHERE account_no = '$account_num'")or die(mysqli_error($conn));   
   */
                                    $seller_id = $_GET['id'];
                                    $result2 = mysqli_query($conn, "UPDATE capitalized SET capitalized_status = 'already_transfered',status_type='' WHERE id='$seller_id'");

                                    /*
    $id = $_POST['id'];
    foreach ($_POST['id'] as $ids) {
              
        $query_cap = mysqli_query($conn,"SELECT * from capitalized where 
            capitalized_status = 'pending' and type = 'cash' AND id = '$ids'") or die(mysqli_error($conn));
        
        $row_cap = mysqli_fetch_array($query_cap);

        $capitalized_in_birr = $row_cap['capitalized_in_birr'];
        $account_no = $row_cap['account_no'];        
                      
        $result1 = mysqli_query($conn,"UPDATE shareholders set total_paidup_capital_inbirr = total_paidup_capital_inbirr + '$capitalized_in_birr' where account_no='$account_no'") or die(mysqli_error($conn));
        $result = mysqli_query($conn,"UPDATE capitalized SET capitalized_status = 'authorized' where id='$ids'");
            
           header('location:http://172.23.2.174/shareholder_dividend/shareholder/authorize_cashpayment?authorize=ok');
 
    }
    */
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
            capitalized_status = 'pending' and type = 'cash' AND id = '$id[$i]'") or die(mysqli_error($conn));
        
        $row_cap = mysqli_fetch_array($query_cap);

        $capitalized_in_birr = $row_cap['capitalized_in_birr'];        

                      
            $result1 = mysqli_query($conn,"UPDATE shareholders set total_paidup_capital_inbirr = total_paidup_capital_inbirr + '$capitalized_in_birr' where account_no='$account_no[$i]'") or die(mysqli_error($conn));

            $result = mysqli_query($conn,"UPDATE capitalized SET capitalized_status = 'authorized' where id='$id[$i]'");
            
           header('location:http://172.23.2.174/shareholder_dividend/shareholder/authorize_cashpayment?authorize=ok');
 
    }
}
      */  ?>





                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>

        </section><!-- /.content -->