   		<!-- jQuery 2.0.2 -->
        

        <script src="<?php echo base_url('public/ajax/jquery.min.js');?>"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url('public/js/bootstrap.min.js');?>" type="text/javascript"></script>
                 <!-- AdminLTE App -->
        <script src="<?php echo base_url('public/js/AdminLTE/app.js');?>" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        
		<script src="<?php echo base_url('public/js/plugins/daterangepicker/bootstrap-datetimepicker.fr.js');?>" type="text/javascript"></script>
		
		<script src="<?php echo base_url('public/js/plugins/datatables/jquery.dataTables.js');?>" type="text/javascript"></script>
		
        <script src="<?php echo base_url('public/js/plugins/datatables/dataTables.bootstrap.js');?>" type="text/javascript"></script>
          
        <script src="<?php echo base_url('public/js/bootstrap-datetimepicker.js');?>" type="text/javascript"></script>
        
        <script src="<?php echo base_url('public/js/tcal.js');?>" type="text/javascript"></script>
        
        <script src="<?php echo base_url('public/js/bootbox.min.js');?>" type="text/javascript"></script>
        


<script language="javascript" type="text/javascript">

                function Comma(Num) { //function to add commas to textboxes                                                    

                Num += '';
                Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
                Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');

                x = Num.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1))
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                return x1 + x2;
                
            }            

        </script>

         
  <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
 </script>
 
 <!-- odd color of a table-->
 
<script type="text/javascript" charset="utf-8">
			$('tr:odd').css('background','#e3e3e3');
</script>
 <script type="text/javascript">
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		format: "dd MM yyyy",
		forceParse: 0
    });

</script>
        <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

   
  })
</script>
<script src="<?php echo base_url('public/js/select2.full.min.js');?>"></script>


