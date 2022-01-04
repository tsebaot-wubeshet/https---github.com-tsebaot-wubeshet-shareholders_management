<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
    $username = $this->session->userdata['logged_in']['username'];
}
?>
<?php if (isset($_GET['result']) == 'success') { ?>
    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Success!</b> Password Has Been Reset Successfully!
    </div>
<?php } ?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form method="post" action="">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirm_reset_password_modal">
                        Reset Password
                    </button>
                    <div class="modal fade" id="confirm_reset_password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h4>Do you wish to reset the password?</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="reset_password" class="btn btn-primary">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <form method="post" action="">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>First Name</th>
                                        <th>User Name</th>
                                        <th>User Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn, "SELECT * from user_login order by id ASC") or die(mysqli_error($conn));

                                    $a = 0;

                                    while ($rows = mysqli_fetch_array($query)) {
                                        $a = $a + 1;
                                        $role = $rows['role'];
                                        $role_query = mysqli_query($conn, "SELECT * from role where id=$role order by id ASC") or die(mysqli_error($conn));
                                        $role = mysqli_fetch_array($role_query)
                                    ?>
                                        <tr>
                                            <td><input type="checkbox" name="id[]" value="<?php echo $rows['id']; ?>"></td>
                                            <td><?php echo $a; ?></td>
                                            <td><?php echo $rows['fullname']; ?></td>
                                            <td><?php echo $rows['user_name']; ?></td>
                                            <td><?php echo $role['role']; ?></td>
                                        <?php } ?>

                                        </tr>

                                </tbody>

                            </table>

                        </form>
                    </div><!-- /.box-body -->
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
<?php
if (isset($_POST['reset_password'])) {
    if (!isset($_POST['id'])) {
        echo '<script>alert("Select a user!");</script>';
    } else {
        $ids = $_POST['id'];
        foreach ($ids as $id) {
            $reset_query = mysqli_query($conn, "update user_login set user_password = '123456' where id = $id");
        }
        header('location:/shareholder_new/shareholder/list_user?result=success');
    }
}
?>