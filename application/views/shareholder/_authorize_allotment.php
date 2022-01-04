<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
    $username = $this->session->userdata['logged_in']['username'];
    $role = $this->session->userdata['logged_in']['role'];
    $userId = $this->session->userdata['logged_in']['id'];
}
?>
<?php if (isset($_GET['authorize'])) { ?>

    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Success!</b> Allotment Authorized Successfully!.
    </div>

<?php } ?>
<?php

if (isset($_GET['reject'])) {

?>

    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Success!</b> Allotment Rejected Successfully!.
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
                                    <th>Account no</th>
                                    <th>Shareholder Name</th>
                                    <th>Start date</th>
                                    <th>Due date</th>
                                    <th>Alloted Amount</th>
                                    <th>Alloted Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $query = mysqli_query($conn, "SELECT a.id,a.account,a.allot_date,a.due_date,a.allotment,a.allot_status, s.name from allotment a left join shareholders s on a.account= s.account_no where allot_status =3") or die(mysqli_error($conn));

                                $a = 0;

                                while ($rows = mysqli_fetch_array($query)) {
                                    $allotment_status_id = $rows['allot_status'];
                                    $allotment_status_query = mysqli_query($conn, "SELECT status FROM status WHERE id = $allotment_status_id");
                                    $allotment_status = mysqli_fetch_object($allotment_status_query)->status;
                                    $a = $a + 1;

                                    $id = $rows['id'];
                                    $account_no = $rows['account'];

                                ?>
                                    <tr>

                                        <td><input type="checkbox" name="id[]" value="<?php echo $rows['id']; ?>"></td>

                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $rows['account']; ?></td>
                                        <td><?php echo $rows['name']; ?></td>
                                        <td><?php echo $rows['allot_date']; ?></td>
                                        <td><?php echo $rows['due_date']; ?></td>
                                        <td><?php echo $rows['allotment']; ?></td>
                                        <td><span class="badge bg-red"><?php echo $allotment_status; ?></span></td>
                                    <?php } ?>

                                    </tr>

                            </tbody>

                            <?php if ($role == 3) { ?>

                                <fieldset>
                                    <button type="submit" name="authorize" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Authorize</button>
                                    <button type="submit" name="reject" class="btn btn-danger"><i class="glyphicon glyphicon-ok"></i> Reject</button>
                                </fieldset>
                            <?php } ?> <br><br>
                        </table>

                        <?php
                        if (isset($_POST['authorize'])) {
                            if (!isset($_POST['id'])) {
                                echo '<script>alert("Either data not selected or no data to authorize !");</script>';
                            } else {
                                $id = $_POST['id'];
                                foreach ($id as $ids) {
                                    $result = mysqli_query($conn, "UPDATE allotment SET allot_status = 4,checker=$userId where id='$ids'") or die(mysqli_error($conn));
                                    header('location:/shareholder_new/shareholder/authorize_allotment?authorize=ok');
                                }
                            }
                        }
                        if (isset($_POST['reject'])) {
                            //$account_no = $_POST['selector'];
                            if (!isset($_POST['id'])) {
                                echo '<script>alert("Either data not selected or no data to reject !");</script>';
                            } else {
                                foreach ($id as $ids) {
                                    $result = mysqli_query($conn, "UPDATE allotment SET allot_status = 11,checker=$userId where id='$ids'") or die(mysqli_error($conn));
                                    header('location:authorize_allotment?reject=true');
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