<?php

$conn = mysqli_connect('localhost', 'root', '', 'shareholder');
if (isset($this->session->userdata['logged_in'])) {
  $username = $this->session->userdata['logged_in']['username'];
  $role = $this->session->userdata['logged_in']['role'];
}
?>
<style type="text/css">
  #homepage_search {
    margin-left: 400px;
  }

  #homepage_search_btn {
    margin-left: 200px;
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {
    $("#myRelease").modal('show');
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#myPledged").modal('show');
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#myReleaseblock").modal('show');
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#myModal").modal('show');
  });
</script>

<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-dismissable" role="alert" align="center">

          You can't transfer Share , Shareholder Blocked!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<div id="myReleaseblock" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-dismissable" role="alert" align="center">

          Blocked Request waiting for Authorization
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<div id="myRelease" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-dismissable" role="alert" align="center">

          Pledged Release waiting for Authorization

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<?php

if (isset($_GET['release_blocked_share'])) {

?>

  <div class="alert alert-success alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>Request sent to authorization</a>
  </div>

<?php } ?>
<div id="myPledged" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-dismissable" role="alert" align="center">

          You can't pledge Share , Shareholder Blocked!

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<script language="javascript" type="text/javascript">
  function popitup(url) {
    newwindow = window.open(url, 'name', 'height=600,width=1300');
    if (window.focus) {
      newwindow.focus()
    }
    return false;
  }

  // -->
</script>
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

if (isset($_GET['blocked'])) {

?>

  <div class="alert alert-success alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>Success!</b> Shareholder Blocked Successfully!.
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
        <div class="col-xs-2">

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
                  <th>Total share subscribed</th>
                  <th>Total paid up capital in birr</th>
                  <th>Allotment</th>
                  <?php if ($role == 3) { ?>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  <?php } ?>
                  <?php if ($role == 'user') { ?>
                    <th></th>
                    <th></th>
                  <?php } ?>
              </thead>
              <tbody>

                <?php
                $budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");
                $budget_resualt = mysqli_fetch_array($budget_query);

                $from = "";
                $to = "";
                $year = 0;
                if ($budget_resualt) {
                  $from = $budget_resualt['budget_from'];
                  $to = $budget_resualt['budget_to'];
                  $year = $budget_resualt['id'];
                }

                $query = mysqli_query($conn, "SELECT * from share_for_resale") or die(mysqli_error($conn));

                $a = 0;

                while ($rows = mysqli_fetch_array($query)) {

                  $a = $a + 1;

                  $acct = $rows['account_no'];

                  $query2 = mysqli_query($conn, "SELECT * from allotment where account_no = '100000' and (allot_year BETWEEN '$from' and '$to') order by id ASC") or die(mysqli_error($conn));

                  $rows2 = mysqli_fetch_array($query2);

                ?>
                  <tr>

                    <td></td>
                    <td><?php echo $a; ?></td>

                    <td><?php echo $rows['account_no']; ?></td>
                    <td><?php echo $rows['name']; ?></td>
                    <td><?php echo number_format($rows['total_share_subscribed']); ?></td>
                    <td><?php echo number_format($rows['total_paidup_capital_inbirr']); ?></td>
                    <?php

                    $query2 = mysqli_query($conn, "SELECT * from allotment where account_no = '$acct' and (allot_year BETWEEN '$from' and '$to') order by id ASC") or die(mysqli_error($conn));

                    $rows2 = mysqli_fetch_array($query2);
                    ?>
                    <td><?php echo number_format($rows2['allotment']); ?></td>


                    <?php if ($role == 'user') { ?>
                      <td>

                        <?php

                        if ($rows['total_share_subscribed'] == '0') { ?>

                          Transfer

                        <?php } else { ?>

                          <a href="<?php echo base_url(); ?>shareholder/transfer_share_for_sale?id=<?php echo $rows['account_no']; ?>&from=<?php echo $from; ?>&to=<?php echo $to; ?>" oncontextmenu="return false;" onclick="return popitup('<?php echo base_url(); ?>shareholder/transfer_share_for_sale?id=<?php echo $rows['account_no']; ?>&from=<?php echo $from; ?>&to=<?php echo $to; ?>')">Transfer</a>



                      </td>
                      <td></td>

                  <?php }
                      } ?>

                <?php } ?>

                  </tr>
              </tbody>
            </table>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>

</section><!-- /.content -->