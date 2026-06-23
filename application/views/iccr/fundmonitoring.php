<?php //echo "<pre>";print_r($applicaitonStepOne);die;?>
<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:125px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
.form-horizontal .control-label {
    
    margin-bottom: 0;
    text-align: left;
    font-size: 12px;
    padding: 0;
    padding-top: 7px;
    width: 135px;
}
.form-group{
    margin-right: 0 !important;
    padding-left: 0;
    padding-right: 0;
    width: 100%;
}
.filter
{
	 border-bottom: 1px solid #cecece;
    border-top: 1px solid #cecece;
    margin-bottom: 36px;
    margin-top: 30px;
    padding-bottom: 15px;
    padding-top: 10px;
}
.filter1,.filter2
{
	border-bottom: 1px solid #cecece;
    border-top: 1px solid #cecece;
    margin-bottom: 36px;   
    padding-bottom: 15px;
    padding-top: 10px;
}
.filter label{padding-right:0;padding-top:10px;width:150px;}
.filter1 label{padding-right:0;padding-top:10px;width:150px;}
.filter2 label{padding-right:0;padding-top:10px;width:150px;}
.customdate{width:116px;}
input,select,label{font-size:14px !important;}
.tab-content input[type="text"], select {
    background: #fffdca none repeat scroll 0 0 !important;
    color: #747474 !important;
    font-size: 14px !important;
    font-weight: bold;
}
.rpt{
	 border: 1px solid #cecece;
    border-radius: 24px;
    color: #747474;
    float: right;
    font-weight: bold;
    padding: 6px;
    text-align: center;
    width: 129px;
}
	#frm_details_ngo {
    float: right;
    position: absolute !important;
    right: 0;
    top: 11px !important;
}
.blue-heading h3
{
	margin-top: 13px !important;
	font-weight: bold;
    
}
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
}
</style>

<script type="text/javascript">
	
	function fillYears(id)
	{
		var v = $('#' + id).val();
		var yrs = v.split('-');
		var ht = "<option value=''>Year</option>";
			ht += "<option value='"+ yrs[0] +"'>" + yrs[0] + "</option>";
			ht += "<option value='"+ yrs[1] +"'>" + yrs[1] + "</option>";
		$('#from_year').html(ht);
		$('#to_year').html(ht);	
	}
</script>

<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Fund Releases</h3>	
		<h4 class="text-center caps">Indian Council For Cultural Relations</h4>	
	</div>
	<?php
	    	if($this->session->flashdata('message_type') == "success")
	    	{
			?>
			<div class="alert alert-success" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
			</div>
			<?php	
			}
			if($this->session->flashdata('message_type') == "error")
	    	{
			?>
			<div class="alert alert-error" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>
			</div>
			<?php	
			}
	    	
	    	?>
	<div  class="container" style="min-height:289px;padding:0px;">		
	<div class="tab-content">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>headquarter/addfund" method="post" class="form-horizontal" enctype="multipart/form-data">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">				
					
              		<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Financial Year</label>
					    <div class="col-sm-8">
						     <select id="fin_year" name="fin_year" class="selectpicker form-control" required="true" >
						     <option value="">Select</option>
								  <?php
								  $counter =0;
								  foreach($fy as $fyear)
								  {
									echo '<option value="'.$fyear.'">'.$fyear.'</option>';
									 $counter++;
								  }
								  ?>
							</select>
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Regional Office</label>
					    <div class="col-sm-8">
					      <select id="regiion" name="regiion" class="selectpicker form-control" required="true">
					      		<option value="">Select</option>
								  <?php
								  $regionals = $this->common_model->getAllRegions();
								  print_r($regionals);
								  foreach($regionals as $reg)
								  {
								  	  echo '<option  value="'.$reg['id'].'">'.$reg['name'].'</option>';
											  
								  }
								  ?>
								  
							</select>
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Quarter</label>
					    <div class="col-sm-8">
					      <select id="quarter" name="quarter" class="selectpicker form-control" required="true">
					      		<option value="">Select</option>
								<option value="1">1st Quarter</option>
								<option value="2">2nd Quarter</option>
								<option value="3">3rd Quareter</option>
								<option value="4">4th Quarter</option>
							</select>
					    </div>
					</div>					
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Amount Released</label>
					    <div class="col-sm-8">
					     <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount Released" required="true">
					    </div>
					</div>
					
					<div class="form-group col-xs-9 pull-right pdlef signt">					    
					    <div class="col-sm-6 pull-left pdleft">
					      <input type="submit" class="form-control sbmt pull-right" id="submit" value="Submit"/>
					    </div>					    
					</div> 			
			</div>
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	


<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:15px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal 
		</marquee>	
		<div class="blue-heading col-md-12 ">
			 <h3> Fund Monitoring</h3>
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadFundMonitoringList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>headquarter/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf" style="width:100%;">
			<thead>
				<th>S.No.</th>
				<th>Financial Year</th>
				<th>Regional Office</th>
				<th>1st Quarter</th>
				<th>2nd Quarter</th>
				<th>3rd Quarter</th>
				<th>4th Quarter</th>
				<th>Total</th>
				<th>Expenditure Details</th>	
			</thead>
			<tbody>
				<?php 
				$counter=1;$finalTotal=0;
				if(count($totalFund)>0)
				{
					foreach($totalFund as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['FY'];?></td>
						<td><?php $regi = $this->common_model->getRegionById($app['RO']); echo $regi[0]['name'];?></td>
						<td><?php 
						if($app['First_Quarter'] == "") 
						{
							echo '0';
						}
						else
						echo $app['First_Quarter'];?></td>
						<td><?php 
							if($app['Second_Quareter'] == "") 
							{
								echo '0';
							}
							else
							 echo $app['Second_Quareter'];?></td>
						<td><?php if($app['Third_Quareter'] == "") echo '0';else echo $app['Third_Quareter'];?></td>
						<td><?php if($app['Fourth_Quareter'] == "") echo '0';else echo $app['Fourth_Quareter'];?></td>
						<td>
						<?php 
						$total = 0;
						$total = (int)$app['First_Quarter'];
						$total = $total + (int)$app['Second_Quareter'];
						$total = $total + (int)$app['Third_Quareter'];
						$total = $total + (int)$app['Fourth_Quareter'];
						$finalTotal = (int)$finalTotal + (int)$total;
						echo $total;
						//echo '<br/>';
						//echo $finalTotal;
						?></td>	
						<td><a class="form-control sbmt1" style="height:35px;width:140px;" href="<?php echo site_url();?>headquarter/viewExpenditureDetails/<?php echo $app['FY'];?>/<?php echo $app['RO'];?>">View Details</a></td>										
						</tr>
						<?php	
						$counter++;	
					}
					
				}
				?>
			</tbody>
		</table>
		<!--<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf" style="width:100%;"><tbody><tr><td colspan="7" align="right"><b>Total</b></td><td colspan="1"><?php echo $finalTotal;?></td></tr></tbody></table>-->
		<hr/>
	</div>
</section>
	