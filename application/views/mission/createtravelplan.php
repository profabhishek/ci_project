<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:133px;margin:0 auto;text-align:center;}
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
    padding-top: 7px;
    margin-bottom: 0;
    text-align: left;
    font-size: 12px;
}
.link_div{
	 border: 1px solid red;
    border-radius: 7px;
    display: block;
    float: left;
    margin-top: 1px;
    padding: 5px;
    width: 107px;
    text-align: center;
}
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
</style>
<script type="text/javascript">
	function showcityother(id)
	{
		var v = $('#'+ id).val();
		if(v==7)
		{
			$('.city_other').addClass("in");
		}
		else
		{
			$('.city_other').removeClass("in");
		}
	}
</script>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Travel Plan of Student</h3>
		<h4 class="text-center caps">APPLICATION NUMBER : <?php echo $appno; ?></h4>		
	</div>
	<div class="headsec container">Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal</div>
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active ">	   
	    <form id="form-visa" action="<?php echo site_url();?>mission/travelpaln/<?php echo $appno; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	     <div class="box-body">
	     
	       <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Name of Scholar</label>
		    <div class="col-sm-3">
		     	<?php
		     	//print_r($travel);
		     	
		     	 echo $applicaitonStepOne[0]['fullname']; ?>
		    </div>	
		  </div> 
		   <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Country</label>
		    <div class="col-sm-6">
		     	<?php $count = $this->common_model->getCountryById($applicaitonStepOne[0]['nationality']); echo $count[0]['country_name']; ?>
		    </div>	
		  </div> 		 
		   <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Scheme</label>
		    <div class="col-sm-6">
		     	<?php $scheme = $this->common_model->getSchemeById($travel[0]['scholarship_id']); echo $scheme[0]['scheme_name']; ?>
		    </div>	
		  </div> 
		   <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Course Admitted to</label>
		    <div class="col-sm-6">
		     	<?php $course = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']); echo $course[0]['title']; ?>
		    </div>	
		  </div> 
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" >University Admitted to</label>
		    <div class="col-sm-6">
		     	<?php
						//if(($app['programme'] == 1 && $app['course'] == 58) || ($app['programme'] == 2 && $app['course'] == 59))
						//{
						//	$data = $this->common_model->getconfirmationDataforfourthoptionHqrs($app['application_no']);
						//}
						//	else
						//{
							//$data = $this->common_model->getConfirmationofApplicationIds($appno);
						//}
						//print_r($data);
						$data = $this->common_model->getconfirmationDataByMission($appno);
						$uni = $this->common_model->getUniversityById($data[0]['regional_university']);
						echo $uni[0]['name'];?>
		    </div>	
		  </div> 
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Date of Departure</label>
		    <div class="col-sm-6">
			<!-- id="departure_date" class=datepicker_arrival-->
		     	<input type="date" name="departure_date"  required="true" class="form-control " placeholder="Date of Departure"/>
		    </div>	
		  </div> 
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Date of Arival in India</label>
		    <div class="col-sm-6">
				<!-- id="travel_arrival_date" class=datepicker_arrival -->
		     	<input type="date" name="travel_arrival_date" placeholder="Date of Arrival in India"  required="true" class="form-control " placeholder="Arival Date"/>
		    </div>	
		  </div> 
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Flight Number</label>
		    <div class="col-sm-6">
		     	<input type="text" name="flight_no" id="flight_no" placeholder="Flight Number" class="form-control" required="true"/>
		    </div>	
		  </div> 
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Final City of arrival</label>
		    <div class="col-sm-3">
		    	<select id="final_city_arrival" name="final_city_arrival" class="form-control" required="true" onchange="showcityother(this.id);">
		    		<option value="">Select</option>
		    		<?php
		    			$cities = $this->config->item('grade_cities');
		    			
		    			foreach($cities as $cityid=>$ctyName)
		    			{
							echo '<option value="'.$cityid.'">'.$ctyName.'</option>';
						}
		    		?>
		    	
		    	</select>
		    </div>
		    <div class="col-sm-3 fade city_other">
		    	<input type="text" name="city_other" id="city_other" placeholder="Other City" class="form-control"/>
		    </div>	
		  </div> 
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Regional Office to be contacted</label>
		    <div class="col-sm-6">
		    	<?php
					$reg = $this->common_model->getRegionById($data[0]->region_one_status);					
				?>
		     	<input type="text" class="form-control" value="<?php echo $reg[0]['name'];?>" readonly="true"/>
		     	<input type="hidden" name="regional_office_contacted" id="regional_office_contacted" class="form-control" value="<?php echo $reg[0]['id'];?>"/>
		    </div>	
		  </div>
		  <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Cost of Ticket (INR)</label>
		    <div class="col-sm-6"> 
		     	<input type="text" name="cost_of_ticket" id="cost_of_ticket"  placeholder="Cost of Ticket" class="form-control" required="true"/>
		    </div>	
		  </div> 
	     
	     
	    <div class="form-group col-xs-10">
					    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Upload Travel Schedule</label>
					    <div class="col-sm-3">
					      <input type="file"  name="travel_plan_doc" id="travel_plan_doc" required="true"  />
					    </div>
					
					   	
					</div> 
					<br/><br/>
					 <div class="col-md-12 pull-right pdleft">
					      <input type="submit" class="form-control sbmt" value="Submit"/>
					    </div>
						</div>	
	   
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	