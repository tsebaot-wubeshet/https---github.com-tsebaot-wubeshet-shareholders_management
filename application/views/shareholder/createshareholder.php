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
				Create Shareholder
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url().'shareholder/home'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Request</a></li>

			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<!-- left column -->

				<?php echo $this->load->view('shareholder/_createshareholder'); ?>

			</div> <!-- /.row -->
		</section><!-- /.content -->
	</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
	<!-- jQuery 2.0.2 -->

	<?php echo $this->load->view('layouts/footer'); ?>