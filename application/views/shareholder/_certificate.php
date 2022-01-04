    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'shareholder');
    if (isset($this->session->userdata['logged_in'])) {

        $username = $this->session->userdata['logged_in']['username'];
        $userId = $this->session->userdata['logged_in']['id'];
    }
    $budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status =1");
    $budget_result = mysqli_fetch_array($budget_query);
    $from = "";
    $to = "";
    $year = 0;
    if ($budget_result) {
        $from = $budget_result['budget_from'];
        $to = $budget_result['budget_to'];
        $year = $budget_result['id'];
    }
    ?>


    <?php
    if (isset($_GET['status'])) {
    ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>Success!</b> certificate created successfully!.
        </div>
    <?php } ?>
    <!-- general form elements disabled -->
    <div class="box box-warning">
        <div class="col-md-12">
            <div class="col-md-6">
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

                        <div class="form-group">

                            <label> Shareholder Name</label>

                            <select name="account_no" class="form-control" required onchange="showUser(this.value)">
                                <option value="">Select Shareholder Name</option>

                                <?php

                                $result = mysqli_query($conn, "SELECT c.*, s.name FROM certificate c left join shareholders s on c.account = s.account_no  order by cast(s.account_no as int)");

                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['account'] . '">';
                                    echo $row['account'] . ' - ' . $row['name'];
                                    echo '</option>';
                                }

                                ?>

                            </select>

                        </div>

                        <div id="txtHint"></div>


                        <div class="form-group">
                            <label>Prepared Share Certificate</label>
                            <input type="text" onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="prepared_share_certificate" class="form-control" placeholder="Enter prepared certificate..." required />

                        </div>
                        <div class="form-group">
                            <label>Issued Share Certificate</label>
                            <input type="text" onKeyPress="return event.charCode > 47 && event.charCode < 58;" name="issued_share_certificate" class="form-control" placeholder="Enter prepared certificate..." required />

                        </div>
                        <div class="box-footer">

                            <button type="submit" class="btn btn-primary" name="submit">submit</button>
                        </div>

                        <?php
                        if (isset($_POST['submit'])) {

                            $issued_share = $_POST['issued_share_certificate'];

                            $prepared_share = $_POST['prepared_share_certificate'];

                            $account_no = $_POST['account_no'];

                            mysqli_query($conn, "INSERT into certificate (issued_share_certificate,prepared_share_certificate,account) 
                                                values ('$issued_share','$prepared_share',$account_no)") or die(mysqli_error($conn));

                            header('location:/shareholder_new/shareholder/certificate?status=success');


                        ?>

                        <?php
                        }

                        ?>

                    </form>
                </div><!-- /.box-body -->

            </div>