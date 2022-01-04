<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
    $username = $this->session->userdata['logged_in']['username'];
    $role = $this->session->userdata['logged_in']['role'];
}
?>
<?php if (isset($_GET['authorize'])) { ?>

    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Success!</b> Transfer Authorized Successfully!.
    </div>

<?php } ?>
<?php

if (isset($_GET['reject_transfer'])) {

?>

    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b></b> Transfer Rejected!.
    </div>

<?php } ?>

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
                                    <th></th>
                                    <th></th>
                                    <th>No.</th>
                                    <th>Account number</th>
                                    <th>Transfer From</th>
                                    <th>Total Share Transfered</th>
                                    <th>Total Share Transfer To</th>
                                    <th>Transfer Date</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $query = mysqli_query($conn, "SELECT * from transfer_from_bank where 
        status_of_transfer = 'pending'") or die(mysqli_error($conn));

                                $a = 0;

                                while ($rows = mysqli_fetch_array($query)) {
                                    $a = $a + 1;

                                ?>
                                    <tr>
                                        <input type="hidden" name="account_no" value="<?php echo $rows['account_no']; ?>">
                                        <input type="hidden" name="new_share_subscribed" value="<?php echo $rows['new_share_subscribed']; ?>">
                                        <input type="hidden" name="total_share" value="<?php echo $rows['total_share']; ?>">
                                        <input type="hidden" name="paidup" value="<?php echo $rows['paidup']; ?>">
                                        <input type="hidden" name="username" value="<?php echo $username; ?>">


                                        <td></td>
                                        <td><input type="checkbox" name="applist[]" value="<?php echo $rows['account_no']; ?>"></td>

                                        <td><?php echo $a; ?></td>

                                        <td><?php echo $rows['account_no']; ?></td>
                                        <td>NIB </td>
                                        <td><?php echo $rows['new_share_subscribed']; ?></td>



                                        <td><?php

                                            $query2 = mysqli_query($conn, "SELECT * from shareholders where 
        account_no = " . $rows['account_no'] . "") or die(mysqli_error($conn));
                                            $rows2 = mysqli_fetch_array($query2);
                                            echo $rows2['name']; ?></td>

                                        <td><?php echo $rows['transfer_date']; ?></td>

                                        <td><?php
                                            if ($rows['status_of_transfer'] == 'active') {

                                            ?>

                                                <span class="badge bg-blue"><?php echo $rows['status_of_transfer']; ?></span>

                                            <?php

                                            } else {

                                            ?>

                                                <span class="badge bg-red"><?php echo $rows['status_of_transfer']; ?></span>

                                            <?php

                                            }

                                            ?>
                                        </td>


                                    <?php } ?>

                                    </tr>

                            </tbody>

                            <?php if ($role == 3) { ?>
                                <fieldset>
                                    <button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
                                    <button type="submit" name="reject" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Reject</button>
                                </fieldset>
                            <?php } ?> <br><br>
                        </table>

                        <?php
                        if (isset($_POST['reject'])) {

                            $rejected_authorized_date = date("Y-m-d");
                            $username = $_POST['username'];

                            $id = $_POST['applist'];

                            $N = count($id);

                            for ($i = 0; $i < $N; $i++) {

                                $result = mysqli_query($conn, "UPDATE transfer_from_bank SET status_of_transfer = 'rejected',rejected_by = '$username',rejected_authorized_date = '$rejected_authorized_date' where id='$id[$i]'") or die(mysqli_error($conn));

                                header('location:authorize_transfer_from_nib?reject_transfer=true');
                            }
                        }

                        if (isset($_POST['authorize'])) {

                            $total_share = $_POST['total_share'];
                            $username = $_POST['username'];
                            $paidup = $_POST['paidup'];
                            $per_value = $_POST['per_value'];
                            $new_share_subscribed = $_POST['new_share_subscribed'];
                            $authorized_by = $_POST['authorized_by'];
                            $account_no = $_POST['account_no'];
                            $rejected_authorized_date = date("Y-m-d");

                            $id = $_POST['applist'];

                            $N = count($id);

                            for ($i = 0; $i < $N; $i++) {

                                $query1 = mysqli_query($conn, "SELECT * FROM shareholders WHERE account_no='$id[$i]'") or die(mysqli_error($conn));

                                while ($rows = mysqli_fetch_array($query1)) {

                                    $updated_share = $rows['total_share_subscribed'] + $new_share_subscribed;

                                    $update_paidup = $rows['total_paidup_capital_inbirr'] + $paidup;

                                    $query = mysqli_query($conn, "UPDATE shareholders SET total_share_subscribed = '$updated_share',total_paidup_capital_inbirr = '$update_paidup' where account_no='$id[$i]'") or die(mysqli_error($conn));

                                    $result = mysqli_query($conn, "UPDATE transfer_from_bank SET status_of_transfer = 'authorized',authorized_by = '$username',rejected_authorized_date = '$rejected_authorized_date' where account_no='$id[$i]'") or die(mysqli_error($conn));

                                    header('location:authorize_transfer_from_nib?authorize=true');
                                }
                            }
                        }
                        ?>

                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

</section><!-- /.content -->