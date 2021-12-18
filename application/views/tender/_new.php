       <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">General Elements</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                         <!-- display message -->
								   	<?php
										if (isset($message_display)) { ?>
									<div class="alert alert-info" role="alert">
										<?php 
											echo "<div class='message'>";
											echo $message_display;
											echo "</div>";
										?>
				   					</div> 
				   					<?php } ?> 
				   						     
                          <form action="<?php echo base_url('');?>tenders/new_tender_registration" method="POST" role="form">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control" placeholder="Enter ..."/>
                                        </div>
                                       
                                        <!-- textarea -->
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="desc" rows="3" placeholder="Enter ..."></textarea>
                                        </div>
                                  
                                        <div class="form-group">
                                       
                                        <label>Posted Date:</label>
	                                        <div class="input-group">
	                                            <div class="input-group-addon">
	                                                <i class="fa fa-calendar"></i>
	                                            </div>
	                                            
	                                            <div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
										              
	                                            <input type="text" class="form-control pull-right" name="posted_date" value="" readonly>
	                                            <span class="add-on"><i class="icon-remove"></i></span>
												<span class="add-on"><i class="icon-th"></i></span>
												</div>
												
	                                            </div
	                                        </div><!-- /.input group -->
	                                   		 </div><!-- /.form group -->
                             
    <!-- closing date-->
    									<div class="form-group">
                                          <label>Closing Date:</label>
	                                        <div class="input-group">
	                                            <div class="input-group-addon">
	                                                <i class="fa fa-calendar"></i>
	                                            </div>
	                                            
	                                            <div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
										                    
	                                            <input type="text" class="form-control pull-right" name="closing_date" value="" readonly>
	                                            <span class="add-on"><i class="icon-remove"></i></span>
												<span class="add-on"><i class="icon-th"></i></span>
												</div>
												
	                                            </div
	                                        </div><!-- /.input group -->
	                                   		 </div><!-- /.form group -->
                                                                      
                                       		<div class="form-group">
                                            <label>Category</label>
                                                                                        
                                             <select class="form-control" name="category_id">
												<?php foreach($records as $row) { ?>
													<option value="<?php echo $row->id?>"><?php echo $row->category_name?></option>
												<?php } ?>
												</select>
                                        	</div>
                                       

                                        <div class="form-group">
                                            <label>Source</label>
                                            <select class="form-control" name="source">
                                                <option>Ethiopian Reporter</option>
                                                <option>Addis Admas</option>
                                                <option>Addis Lisan </option>
                                                <option>Addis Zemen</option>
                                              
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control" name="comp_name" placeholder="Enter ..."/>
                                        </div>
                                       <div class="form-group">
                                            <label>Company Address</label>
                                            <textarea class="form-control" rows="3" name="comp_address" placeholder="Enter ..."></textarea>
                                        </div>
                                        
                                        <div class="box-footer">
                                     
                                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                    </div>
                                    
                                     </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->