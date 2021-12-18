<?php
$conn=mysqli_connect('localhost','root','','shareholder'); 
if (isset($this->session->userdata['logged_in'])) {
$username = $this->session->userdata['logged_in']['username'];
} 

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Shareholder Management System</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url('public/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url('public/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('public/css/ionicons.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo base_url('public/css/morris/morris.css');?>" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo base_url('public/css/jvectormap/jquery-jvectormap-1.2.2.css');?>" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?php echo base_url('public/css/fullcalendar/fullcalendar.css');?>" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo base_url('public/css/daterangepicker/daterangepicker-bs3.css');?>" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo base_url('public/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url('public/css/AdminLTE.css');?>" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url('public/css/bootstrap.css');?>" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url('public/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="<?php echo base_url('public/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
        
       <link href="<?php echo base_url('public/css/pagination.css');?>" rel="stylesheet" type="text/css" />
       
         <link href="<?php echo base_url('public/css/tcal.css');?>" rel="stylesheet" type="text/css" />

         <link rel="stylesheet" href="<?php echo base_url('public/css/select2.min.css'); ?>">
         
        <style type="text/css">
        	
        	.error {
    background:#FBE6F2 none repeat scroll 0 0;
    border:1px solid #D893A1;
    color:#333333;
    margin:10px 0 5px;
    padding:10px;
    
			 }
            /*.header{
                position: fixed;
                 z-index: 1000;
            } */
            /* .content{
                
                position: relative;
                margin-top: 30px;   
    
            } */
            /* .content-header{
                 position: fixed;
                 margin-top: 50px; 
                
              
            } */
            /* .sidebar-menu{
                width: 13%;
                position: fixed; 
            } */
        	
        </style>
        
        <script language="javascript" type="text/javascript">

function ajaxFunction(){
 var ajaxRequest;  // The variable that makes Ajax possible!
    
     try{
       // Opera 8.0+, Firefox, Safari
       ajaxRequest = new XMLHttpRequest();
     }catch (e){
       // Internet Explorer Browsers
       try{
          ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
       }catch (e) {
          try{
             ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e){
             // Something went wrong
             alert("Your browser broke!");
             return false;
          }
       }
}

ajaxRequest.onreadystatechange = function(){
   if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('ajaxDiv');
      ajaxDisplay.value = ajaxRequest.responseText;
   }
 }
 
     var num1 = document.getElementById('num1').value;
     var queryString = "?num1=" + num1 ;
     ajaxRequest.open("GET", "<?php echo base_url();?>"+"index.php/foreign/convertnum" + queryString, true);
     ajaxRequest.send(null); 
}
//-->
</script>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header" >
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Shareholder Mgt
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $username;?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                
                                <!-- Menu Body -->
                                
                                <li class="user-footer">
                                    
                                    <div class="pull-right">
                                        <a href="logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->