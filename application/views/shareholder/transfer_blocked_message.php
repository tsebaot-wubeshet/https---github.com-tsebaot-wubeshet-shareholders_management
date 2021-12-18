
    <?php echo $this->load->view('layouts/header1');?>
    
    <body class="skin-blue">

		<?php //echo $this->load->view('shareholder/menu');?>
                  
                  </section>
           </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                      
                 	<?php echo $this->load->view('shareholder/_transfer_blocked_message'); ?>
                                 
               </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        
       <?php echo $this->load->view('layouts/footer');?>
