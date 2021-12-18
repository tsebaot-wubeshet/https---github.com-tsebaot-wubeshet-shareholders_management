<?php
  require_once('OLEwriter.php');
  require_once('BIFFwriter.php');
  require_once('Worksheet.php');
  require_once('Workbook.php');
 // require_once(base_url('application/views/shareholder/conn.php'));
  $conn=mysqli_connect('localhost','root','','shareholder'); 
    function HeaderingExcel($filename) {
      header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=$filename" );
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
      header("Pragma: public");
      }
	  
	  // HTTP headers
	HeaderingExcel('Shareholder_Ledger.csv');// Creating a workbook
	$workbook = new excel("-");
	// Creating the first worksheet
	$worksheet1 =& $workbook->add_worksheet('SHAREHOLDER MANAGEMENT SYSTEM');
	$worksheet1->freeze_panes(1, 1);
  $worksheet1->set_column(0, 0, 25);
  $worksheet1->set_column(1, 1, 20);
  $worksheet1->set_column(1, 2, 20);
  $worksheet1->set_column(1, 3, 20);
  $worksheet1->set_column(1, 4, 20);
  $worksheet1->set_column(1, 5, 20);
  $worksheet1->set_column(1, 6, 20);
  
   $worksheet1->write_string(1,6.15,"NIB International Bank S.C");
      
   $worksheet1->write_string(4,6.15,"Shareholder Leger");
   
   $worksheet1->write_string(7,0,"A/C No.");
   
   $worksheet1->write_string(7,1,"Name");

   $worksheet1->write_string(7,2,"Total share subscribed in birr");
   
   $worksheet1->write_string(7,3,"Allotement");

   $worksheet1->write_string(7,4,"Total paidup capital in birr");
   
   $worksheet1->write_string(7,5,"Unpaid balance");
   
   $worksheet1->write_string(7,6,"Additional share request");

   $worksheet1->write_string(7,7,"City ");

   $worksheet1->write_string(7,8,"Kifle Ketema ");

   $worksheet1->write_string(7,9,"Woreda/Kebele ");

   $worksheet1->write_string(7,10,"House No ");

   $worksheet1->write_string(7,11,"P.O.Box ");

   $worksheet1->write_string(7,12,"Telephone Residence");

   $worksheet1->write_string(7,13,"Telephone Office ");

   $worksheet1->write_string(7,14,"Mobile ");
   
   
/////////////////
	

	$qryreport = mysqli_query($conn,"SELECT shareholders.id,shareholders.account_no,shareholders.name,shareholders.total_share_subscribed,shareholders.total_paidup_capital_inbirr,new_request.total_share,allotment.allotment,shareholders.city,shareholders.sub_city,Shareholders.woreda,Shareholders.house_no,Shareholders.pobox,Shareholders.telephone_residence,Shareholders.telephone_office,shareholders.mobile FROM shareholders LEFT JOIN allotment ON shareholders.account_no = allotment.account_no LEFT JOIN share_request ON shareholders.account_no = share_request.account_no WHERE shareholders.status = 'active' order by shareholders.account_no ASC") or die(mysqli_error($conn));
	
	$sqlrows=mysqli_num_rows($qryreport);
	
	$j=8;
	
	while ($reportdisp=mysqli_fetch_array($qryreport)) { $id=$reportdisp['id'];
	
	$j=$j+1;
		
			$account_no = $reportdisp['account_no'];

			$name = $reportdisp['name'];

			$total_share_subscribed = $reportdisp['total_share_subscribed'];

			$allotement = $reportdisp['allotment'];

			$total_paidup_capital_inbirr = $reportdisp['total_paidup_capital_inbirr'];

			$unpaid_balance = ($allotement*500) + ($total_share_subscribed*500)-$total_paidup_capital_inbirr;

			$new_share = $reportdisp['total_share'];

			$city = $reportdisp['city'];

			$subcity = $reportdisp['sub_city'];

			$woreda = $reportdisp['woreda'];

			$house_no = $reportdisp['house_no'];

			$pobox = $reportdisp['pobox'];

			$telephone_residence = $reportdisp['telephone_residence'];

			$telephone_office = $reportdisp['telephone_office'];

			$mobile = $reportdisp['mobile'];
			


		 $votes_query=mysqli_query($conn,"SELECT * from Shareholders where status = 'active'");

	$vote_count=mysqli_num_rows($votes_query);

			$worksheet1->write_string($j,0,"$account_no");
				
			 $worksheet1->write_string($j,1,"$name");
			 
			 $worksheet1->write_string($j,2,"$total_share_subscribed");

			 $worksheet1->write_string($j,3,"$allotement");
			 
			 $worksheet1->write_string($j,4,"$total_paidup_capital_inbirr");
			
			 $worksheet1->write_string($j,5,"$unpaid_balance");

			 $worksheet1->write_string($j,6,"$new_share");
			 
			 $worksheet1->write_string($j,7,"$city");

			 $worksheet1->write_string($j,8,"$subcity");

			 $worksheet1->write_string($j,9,"$woreda");

			 $worksheet1->write_string($j,10,"$house_no");

			 $worksheet1->write_string($j,11,"$pobox");

			 $worksheet1->write_string($j,12,"$telephone_residence");

			 $worksheet1->write_string($j,13,"$telephone_office");

			 $worksheet1->write_string($j,14,"$mobile");
			 
	 
	}
	
	
	
/////////////////
 
  
$workbook->close();
?>