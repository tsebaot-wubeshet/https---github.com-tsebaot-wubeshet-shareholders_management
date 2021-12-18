<?php
	$conn=mysqli_connect('localhost','root','','shareholder');	
if (isset($this->session->userdata['logged_in'])) {
    $username = $this->session->userdata['logged_in']['username'];
} ?>

<?php
    $month = 7; $year = date('Y')-1;
    $from = date("Y-m-d", mktime(0, 0, 0, $month , 1, $year));

    $month = 7; $year = date('Y');
    $to = date("Y-m-t", mktime(0, 0, 0, $month - 1, 1, $year));
                                
?>
        </section>
<style type="text/css">
a {
    color: #ffffff; 
    text-decoration: none;
}
</style>
                <!-- /.sidebar -->
            </aside>
<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
             

                <!-- Main content -->
                
                  <br><br>
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                    <h3>               
                    <?php

                            
                            $query = mysqli_query($conn,"SELECT count(id) from shareholders where currentYear_status = 1 and account_no !='100000'") or die(mysqli_error($conn));

                            while($row = mysqli_fetch_array($query)){

                            ?>
                            
                    <?php echo $row['count(id)']; } ?>
                </h3>

                                    <p>
                                        Shareholders
                                    </p>
                                </div>
                                <div class="icon">
                                    
                                </div>
                                <a href="#" class="small-box-footer">
                                   
                                </a>
                            </div>
                        </div><!-- ./col -->
                          <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>               
                    <?php

                            $query = mysqli_query($conn,"SELECT count(id) from shareholders where share_type = 2 AND currentYear_status = 1") or die(mysqli_error($conn));

                            while($row = mysqli_fetch_array($query)){

                            ?>

                    <?php echo $row['count(id)']; } ?>
                </h3>
                                    <p>
                                       <a href="<?php echo base_url('');?>shareholder/list_company?keyword=company">COMPANY</a>
                                    
                                    </p>
                                </div>
                                <div class="icon">
                                    
                                </div>
                                <a href="#" class="small-box-footer">
                                   
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>               
                    <?php

                            $query = mysqli_query($conn,"SELECT count(id) from shareholders where share_type = 'edir' AND currentYear_status = 1") or die(mysqli_error($conn));

                            while($row = mysqli_fetch_array($query)){

                            ?>

                    <?php echo $row['count(id)']; } ?>
                </h3>
                                    <p>
                                        <a href="<?php echo base_url('');?>shareholder/edir">EDIR</a>
                                    </p>
                                </div>
                                <div class="icon">
                                    
                                </div>
                                <a href="#" class="small-box-footer">
                                  
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                           
                        </div><!-- ./col -->
                    </div><!-- /.row -->


                    <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3>               
                    <?php

                            $query = mysqli_query($conn,"SELECT count(id) from shareholders where share_type = 'church' AND currentYear_status = 1") or die(mysqli_error($conn));

                            while($row = mysqli_fetch_array($query)){

                            ?>

                    <?php echo $row['count(id)']; } ?>
                </h3>
                                    <p>
                                       <a href="<?php echo base_url('');?>shareholder/list_church">CHURCH</a>
                                   
                                    </p>
                                </div>
                                <div class="icon">
                                    
                                </div>
                                <a href="#" class="small-box-footer">
                                  
                                </a>
                            </div>
                        </div><!-- ./col -->
                    <!-- top row -->
                   
                    <!-- /.row -->


                    <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>               
                    <?php

                            $query = mysqli_query($conn,"SELECT count(id) from shareholders where share_type = 5 AND currentYear_status = 1") or die(mysqli_error($conn));

                            while($row = mysqli_fetch_array($query)){

                            ?>

                    <?php echo $row['count(id)']; } ?>
                </h3>
                                    <p>
                                        <a href="<?php echo base_url('');?>shareholder/ngo">NGO</a>
                                   
                                    </p>
                                </div>
                                <div class="icon">
                                    
                                </div>
                                <a href="#" class="small-box-footer">
                                  
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>               
                    <?php

                            $query = mysqli_query($conn,"SELECT count(id) from shareholders where share_type =1 AND currentYear_status = 1 and account_no != '100000' ") or die(mysqli_error($conn));

                            while($row = mysqli_fetch_array($query)){

                            ?>

                    <?php echo $row['count(id)']; } ?>
                </h3>
                                    <p>
                                        <a href="<?php echo base_url('');?>shareholder/individual">INDIVIDUAL</a>
                                   
                                    </p>
                                </div>
                                <div class="icon">
                                    
                                </div>
                                <a href="#" class="small-box-footer">
                                  
                                </a>
                            </div>
                        </div><!-- ./col -->
                    <!-- Main row -->
                    <br><br><br><br><br><br>
                   <h1 style="font-size: 40px;" align="center">Shareholder Management System</h1>
                    <h5 align="center">Nib International Bank</h5>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->