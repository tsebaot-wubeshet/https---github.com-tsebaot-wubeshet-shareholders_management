<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Log in | Shareholder Management System</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url('public/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url('public/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url('public/css/AdminLTE.css');?>" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
    	

        <div class="form-box" id="login-box">
        	<?php
		if (isset($logout_message)) {
		echo "<div class='message'>";
		echo $logout_message;
		echo "</div>";
		}
		?>
		<?php
		if (isset($message_display)) {
		echo "<div class='message'>";
		echo $message_display;
		echo "</div>";
		}
		?>
            <div class="header">Sign In</div>
            <form action="<?php echo base_url('');?>user_authentication/user_login_process" method="post">

			<?php echo form_open('user_authentication/user_login_process'); ?>
			<?php
			echo "<div class='error_msg'>";
			if (isset($error_message)) {
			echo $error_message;
			}
			echo validation_errors();
			echo "</div>";
			?>
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" id="name" class="form-control" placeholder="username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="*****"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" name="submit" value="Login" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="#">I forgot my password</a></p>
                    
                   </div>
            </form>

			 
        </div>


        <!-- jQuery 2.0.2 -->
       <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
        <!-- Bootstrap -->
      <!--   <script src="<?php echo base_url('public/js/bootstrap.min.js');?>" type="text/javascript"></script>  -->      

    </body>
</html>