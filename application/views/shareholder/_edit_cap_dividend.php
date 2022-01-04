<?php

$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {

  $username = $this->session->userdata['logged_in']['username'];
}

?>
<?php

if (isset($_GET['active'])) {

?>

  <div class="alert alert-success alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>Success!</b> Shareholder Released Successfully!.
  </div>

<?php } ?>

<?php

if (isset($_GET['dividend'])) {

?>

  <div class="alert alert-success alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>Success!</b> Dividend Capitalized!.
  </div>

<?php } ?>



<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">

        <div align="center">
          <form method="post" action="">

            <select name="account" required>
              <option value="">Select Shareholder</option>
              <?php

              $result = mysqli_query($conn, "SELECT * FROM shareholders group by name order by name");
              while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['account_no'] . '">';
                echo $row['name'];
                echo '</option>';
              }
              ?>
            </select>

            <button type="submit" name="search" class="btn btn-primary btn-sm">Search</button>

          </form>

        </div>
        <div class="box-body table-responsive">
          <form action="" method="POST">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th></th>

                  <th>No.</th>

                  <th>Account number</th>
                  <th>Shareholder Name</th>
                  <th>Value Date</th>
                  <th>Capitilized in birr</th>
                  <th>Capitilized in share</th>

              </thead>
              <tbody>

                <?php

                if (isset($_POST['search'])) {

                  $account = $_POST['account'];

                  $query = mysqli_query($conn, "SELECT * from capitalized where type = 'capitalized' and account_no = '$account' order by id ASC") or die(mysqli_error($conn));

                  $a = 0;

                  while ($rows = mysqli_fetch_array($query)) {

                    $a = $a + 1;

                ?>
                    <tr>

                      <td><input type="checkbox" name="selector[]" value="<?php echo $rows['id']; ?>"></td>

                      <td><?php echo $a; ?></td>

                      <td><?php echo $rows['account_no']; ?></td>
                      <td><?php echo $rows['name']; ?></td>

                      <input type="hidden" name="account_no" value="<?php echo $rows['account_no']; ?>">

                      <td><?php echo $rows['value_date']; ?></td>
                      <td><?php echo $rows['capitalized_in_birr']; ?></td>

                      <input type="hidden" name="capitalized_in_birr" value="<?php echo $rows['capitalized_in_birr']; ?>">
                      <td><?php echo $rows['capitalized_in_share']; ?></td>

                      <input type="hidden" name="capitalized_in_share" value="<?php echo $rows['capitalized_in_share']; ?>">

                  <?php }
                } ?>

                    </tr>

              </tbody>

              <fieldset>

                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>

              </fieldset><br><br>

            </table>

            <?php

            if (isset($_POST['delete'])) {

              $id = $_POST['selector'];

              $capitalized_in_birr = $_POST['capitalized_in_birr'];

              $capitalized_in_share = $_POST['capitalized_in_share'];

              $account_no = $_POST['account_no'];
              //$user = $_POST['user'];
              $N = count($id);
              for ($i = 0; $i < $N; $i++) {
                $result = mysqli_query($conn, "UPDATE capitalized SET type = 'Deleted' where id='$id[$i]'");

                $result1 = mysqli_query($conn, "UPDATE shareholders SET 
              total_share_subscribed = total_share_subscribed - '$capitalized_in_share',
              total_paidup_capital_inbirr = total_paidup_capital_inbirr - '$capitalized_in_birr'
              WHERE 
              account_no = '$account_no'
              ");
              }

              header("location: /shareholder/edit_cap_dividend");
            }
            ?>

          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>

</section><!-- /.content -->