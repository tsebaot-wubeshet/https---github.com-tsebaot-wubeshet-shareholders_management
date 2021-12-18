<div class="col-md-12">
              <!-- general form elements disabled -->
              <div class="col-md-3"></div>
              <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header">
                  
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form role="form" method="POST">                
                    <!-- radio -->
                    <div class="form-group">
                      <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                           Create shareholder with value <br/>
                            </label>
                      </div><br><br>
                      <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                         Create shareholder with zero value
                        </label>
                      </div>
                      
                    </div><br/>
                    <button type="submit" name="submit" class="btn btn-primary">Choose</button>
                  </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <div class="col-md-3"></div>
            </div>

<?php

if(isset($_POST['submit'])){

$options = $_POST['optionsRadios'];

if($options == 'option1'){

header('location:/shareholder_new/shareholder/createshareholder');

}else{

header('location:/shareholder_new/shareholder/create_shareholder_from_existing');    

}
}

?>