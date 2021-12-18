	<?php foreach($category as $row){ ?>
								<tr>
									<td class="forTextsEng" align="left" valign="middle">
					 				<a href="<?php echo base_url();?>tenders/view_tender_in_category/<?php echo $row->id;?>"> 						
					 					<?php echo $row->category_name;?> </a>
									</td>
								</tr> 
							<?php } ?>		 
									 
