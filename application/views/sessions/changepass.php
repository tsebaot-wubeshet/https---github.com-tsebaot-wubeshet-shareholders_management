<?php echo $this->load->view('layouts/header1'); ?>

<body class="skin-blue">

    <?php echo $this->load->view('shareholder/menu'); ?>

    </section>
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Change Password
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->

                <?php echo $this->load->view('sessions/change_password'); ?>

            </div> <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
    <!-- jQuery 2.0.2 -->

    <?php echo $this->load->view('layouts/footer'); ?>