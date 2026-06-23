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
.lnk {
    background: #747474 none repeat scroll 0 0;
    border: 1px solid;
    border-radius: 38px;
    box-shadow: 0 0 5px #fff inset;
    color: #fff;
    cursor: pointer;
    float: right;
    font-size: 11px;
    font-weight: bold;
    height: 30px;
    position: relative;
    right: 3px;
    top: -34px;
    width: 120px;
}
.blue-heading h3 {
    color: #fff;
    font-size: 16px;
    text-align: right;
    width: 50%;
}
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
		<h4 class="text-center caps">Bank Details of Applicant</h4>
	</div>
	
	<div  class="container" style="min-height:150px;padding:0px;">	
	<div class="blue-heading col-md-12 ">
			 <h3>Bank Details</h3>	
			 <?php
			 if(count($bankDetails)<=0)
			 {
			 	?>
			 	 <a class="form-control lnk"  href="<?php echo site_url();?>applicant/addBankDetails/<?php echo $this->uri->segment(3);?>">Add Bank Details</a>
			 	<?php
			 }
			 ?>	
		
		</div>	
	<div class="tab-content">
	  <div id="step3" class="tab-pane fade in active">	 
	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <div class="box-body">
              	<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table class="table">
						<thead>
							<th>S.No.</th>
							<th>Regional Office</th>
							<th>Bank Name</th>
							<th>Account Number</th>
							<th>Bank Document</th>			
						</thead>
						<tbody>	
							<?php
							
							if(count($bankDetails)>0)
							{
								$counter = 1;								
								foreach($bankDetails as $bank)
								{
									?>
									<tr>
										<td><?php echo $counter;?></td>
										<td><?php $region =  $this->common_model->getRegionById($bank['regionId']); echo $region[0]['name'];?></td>
										<td><?php echo $bank['bankname'];?></td>
										<td><?php echo $bank['account_no'];?></td>
										<td><a download="true" href="<?php echo site_url();?>assets/site/main/bank_docs/<?php echo $bank['bank_doc'];?>">Downlaod</a></td>										
									</tr>
									<?php	
									$counter++;
								}
							}
							else
							{
							?>
								<tr>
									<td colspan="3">No Record Found!</td>
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

	