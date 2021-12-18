<?php $this->load->view('tender/_header'); ?>
			  	  <div class="forTexts" id="topmenu">
		<?php echo $this->load->view('tender/main_menu');?>
	  </div>
			</div>
			<div id="userbartop" class="forBoldTexts" align="left">
					  <div align="right">
				<a href="<?php echo base_url();?>user_authentication/index" class="toptab">Log In</a>
			  </div>
				  
		</div>
	<div id="maincontent">
	<div id="contentleft">
					<div class="categoryheader"></div>
						<table width="100%" border="0" align="left" class="categorytable">
				
							<?php $this->load->view('tender/list_category');?>	
							
						</table>	  
	</div>
    <div id="contentmiddle" align="left">
		
        	
	          				<script>
		$(document).ready(function(){
			$(".singletender").hover(
			  function () {
				$(this).addClass("singletenderhover");
			  }, 
			  function () {
				$(this).removeClass("singletenderhover");
			  }
			);
			
		});
		
		
		var tenderlist = new Array();
		var tenderlistcount = 0;
		
		</script>
		<style>
		.singletender {
			margin: 0px;
			padding: 5px;	
		}
		
		.singletenderparts {
			margin: 5px 0px 0px 0px;
		}
		
		.singletendermenu {
			font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
			font-size: 11px;
			color: #999999;
			margin: 5px 0px 0px 0px;
			text-align: right;
		}
		
		.singletendermenu ul {
			list-style-type: none;
			margin: 0px;
		} 
		
		.singletendermenu li {
			list-style: none;
			display: inline;
			margin: 0px 10px 0px 0px;
			color: #3b7db2;
		}
		
		.singletendermenu li a {
			color: #3b7db2;
			font-weight: normal;
			text-decoration: none;
		}
		
		</style>
			<script>
                    	tenderlist[tenderlistcount++] = "615fa448160d3132859fb27667fdfd26";
			</script>                   
                    <div class="singletender ">
						<?php 	
						echo '<h3>'.$tender->title.'</h3>';
						echo '<div id="tender_desc">'.$tender->description.'</div>';
						echo $tender->posted_date;
						echo $tender->closing_date;
						echo $tender->comp_name;
						echo $tender->comp_address;		
                       ?>				
				</div>
        </div>
</div>

<?php $this->load->view('tender/_footer'); ?>
