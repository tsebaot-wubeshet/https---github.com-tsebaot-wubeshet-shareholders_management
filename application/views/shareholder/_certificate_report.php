<?php
$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
    $username = $this->session->userdata['logged_in']['username'];
}
?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="col-xs-2">
                    <form method="POST" action="<?php echo base_url(''); ?>shareholder/certificate_share_excel" id="form">

                        <button id="submit" class="btn btn-success" name="save"><i class="icon-download icon-large"></i>Download Certificate Report</button>

                    </form>
                </div><br><br>

                <div id="homepage_search">

                    <form method="post" action=""><br>

                        <div class="col-xs-6">
                            <label for="ex3">Please Enter Account No </label>
                            <input class="form-control" id="ex3" type="text" name="certificate"><br />
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
                                    <th>No.</th>
                                    <th>Account number</th>
                                    <th>Shareholder Name</th>
                                    <th>Total paid up capital in birr</th>
                                    <th>Total paid up share</th>
                                    <th>Issued share certificate </th>
                                    <th>Prepared share certificate </th>
                                    <th>Remaining share to be prepared</th>

                                    <th></th>
                                    <th></th>

                            </thead>
                            <tbody>

                                <?php

                                if (isset($_POST['search'])) {

                                    $shareValue_query = mysqli_query($conn, "SELECT * from share_value") or die(mysqli_error($conn));
                                    $shareValue_row = mysqli_fetch_array($shareValue_query);
                                    $shareValue = $shareValue_row ? $shareValue_row['share_value'] : 0;

                                    $certificate = $_POST['certificate'];

                                    $query = mysqli_query($conn, "SELECT c.account,c.issued_share_certificate,c.prepared_share_certificate,s.name, b.total_paidup_capital_inbirr from certificate c left join shareholders s on c.account = s.account_no left join balance b on b.account = c.account where c.account LIKE '$certificate%' order by cast(c.account as int)") or die(mysqli_error($conn));

                                    $a = 0;

                                    while ($rows = mysqli_fetch_array($query)) {
                                        $a = $a + 1;

                                ?>
                                        <tr>
                                            <td><?php echo $a; ?></td>
                                            <td><?php echo $rows['account']; ?></td>
                                            <td><?php echo $rows['name']; ?></td>
                                            <td><?php echo number_format($rows['total_paidup_capital_inbirr']); ?></td>
                                            <td><?php echo $rows['total_paidup_capital_inbirr'] / $shareValue; ?></td>
                                            <td><?php echo $rows['issued_share_certificate']; ?></td>
                                            <td><?php echo $rows['prepared_share_certificate']; ?></td>
                                            <td><?php echo ($rows['total_paidup_capital_inbirr'] / $shareValue) - $rows['issued_share_certificate'] - $rows['prepared_share_certificate']; ?></td>

                                            <td><a href="<?php echo base_url(); ?>shareholder/edit_certificate?id=<?php echo $rows['account']; ?>">Update</td>

                                            <td><a href="<?php echo base_url(); ?>shareholder/update_certificate?id=<?php echo $rows['account']; ?>">Edit Error</td>
                                    <?php }
                                } ?>

                                        </tr>

                            </tbody>

                        </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

</section><!-- /.content -->