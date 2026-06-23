<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 10px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
</style>
<style type="text/css">
.tweaked-margin{margin-right:5px !important;}
.list-group {
	list-style: decimal inside;
}

.list-group-item {
	display: list-item;
}
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Indian Concuil For Cultural Relations</h3>
		<h4 class="text-center caps">Application Status</h4>
	</div>
	
	<div  class="container" style="min-height:150px;padding:0px;">		
	<div class="blue-heading col-md-12 ">
			 <h3>Your Application Status</h3>	
		 
		</div>
	<div class="tab-content">
	  <div id="step3" class="tab-pane fade in active">	 
	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <div class="box-body">
              	<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table class="table">
						<thead>
							<th>S.No.</th>
							<th>Application Number</th>
							<th>Country</th>
							<th>Name</th>
							<th>Email Id</th>
							<th>Mobile</th>	
							<th>Status</th>			
						</thead>
						<tbody>	
							<?php 
							if(count($applicaitonStatus)>0)
							{
							?>
							<tr>
								<td>1</td>
								<td><?php echo $applicaitonStatus[0]['application_no'];?></td>
								<td><?php $ch = $this->common_model->getCountryById($applicaitonStatus[0]['nationality']); echo $ch[0]['country_name'];?></td>
								<td><?php echo $applicaitonStatus[0]['fullname'];?></td>
								<td><?php echo $applicaitonStatus[0]['email'];?></td>
								<td><?php echo $applicaitonStatus[0]['phone'];?></td>
								<td>
								<?php
								if($applicaitonStatus[0]['status'] == 1)
								{
									echo 'Pending At Mission';
								}
								elseif($applicaitonStatus[0]['status'] == 2)
								{
									echo 'Pending At ICCR';
								}
								elseif($applicaitonStatus[0]['status'] == -3)
								{
									echo 'Your Application is not processed due to these <a href="javascript:void(0);" data-toggle="modal" data-target="#reasons">Reasons</a>';
								}
								else
								{
									echo 'Under Process';
								}
								?>
								 <div id="reasons" class="modal fade" role="dialog">
  									<div class="modal-dialog popup">
  										<section class="content">
									      <!-- Small boxes (Stat box) -->
									      <div class="row">
									      	<div class="col-xs-12">
									    	<div class="box">
												<div class="box-header"><b>Resubmit your application before date:  <?php echo $this->config->item('Mission_Applicant_Pending_Date'); ?></b></div>
									              <div class="box-body">    
									              		<ul class="list-group">
									              	<?php
									              		$reasons = $this->common_model->getResons($applicaitonStatus[0]['application_no']);
									              		$resonsArray = explode(',',$reasons[0]['checklist_ids']);
									              	
									              		$counter = 1;
									              		if(count($resonsArray) > 0)
									              		{
															foreach($resonsArray as $res)
															{
																$item = $this->common_model->getChecklistItemById($res);
																echo '<li class="list-group-item">'.$item[0]['item'] .'</li>';
															}
														}
									              	?>  
									              	</ul>
									              </div>          
									       </div>
									       </div>
									      </div>
									      <!-- /.row -->
									      <!-- Main row -->
      
      <!-- /.row (main row) -->

    </section>
  									</div>
  								</div>	
								</td>
								
							</tr>
							<?php	
							}
							else
							{
							?>
								<tr>
									<td colspan="3">Application Not Submitted Yet!</td>
								</tr>
							<?php
							}
							?>					
														
						</tbody>
					</table>
				</div>				
              </div>
              <!-- /.box-body -->
		
	  </div>	   
	</div>
	</div>
</section>

	