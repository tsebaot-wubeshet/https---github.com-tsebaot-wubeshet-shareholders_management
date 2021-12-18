  <?php
    
    if (isset($this->session->userdata['logged_in'])) {
      
    $username = $this->session->userdata['logged_in']['username'];
      
    } 
  ?>
<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","<?php echo base_url();?>shareholder/getusers?q="+str,true);
        xmlhttp.send();
    }
}
</script>

<script type="text/javascript">


        function validateForm() {
            
            var a = parseInt(document.forms["myForm"]["seller_paidup"].value)/500;

            var b = parseInt(document.forms["myForm"]["howmany"].value);

            if (b > a) {

                alert("The transfered paid up share amount must be less or equal to the seller paid up capital");

                return false;
            }
        }

</script>
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

 
                    <?php if($this->session->flashdata('flashError')): ?>
                   
                  <p class='flashMsg flashError alert alert-danger alert-dismissable'> <?php echo $this->session->flashdata('flashError')?> </p>
                  <?php endif ?>

                  <?php if(isset($_GET['transfer'])){ ?>

                    <div class="alert alert-danger alert-dismissable" role="alert">
                        Share transfered sent succesfully for authorization
                    </div>

                  <?php } ?>

                       
                                <form action="" method="POST" role="form" name="myForm" id="myForm" onSubmit="return validateForm()">
                                    
                                        <?php
                                        
                                        $acct =$_GET['id'];

                    $result = mysqli_query($conn,"SELECT * FROM shareholders where account_no ='$acct'");
                    
                    while($row = mysqli_fetch_array($result))

                      {
                       
                        if($row['blocked_status'] == 'blocked') {

                        ?>

                          <div class="alert alert-danger alert-dismissable" role="alert" align="center">
                       
                            Shareholder Status Blocked and not Allowed to Transfer!
                        
                          </div>

                        <?php } } ?>
                                        

                                     </form>
                                </div><!-- /.box-body -->
                           
                     </div>
