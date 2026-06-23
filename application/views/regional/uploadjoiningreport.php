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
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Upload Joining Report of Applicant</h3>
		<h4 class="text-center caps">APPLICATION NUMBER <?php echo $appno; ?></h4>		
	</div>
	<div class="headsec container">Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal </div>
	<div  class="container" style="min-height:101px;padding:0px;">		
	<div class="tab-content footr" style="min-height:300px;">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-visa" action="<?php echo site_url();?>regional/createJoining/<?php echo $appno; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	     <div class="box-body">
	     
	       
	     
	     
	    <div class="form-group col-xs-10">
					    <label for="joining_doc" class="col-sm-3 control-label  pdright pdleft">Upload Joining Report</label>
					    <div class="col-sm-3">
					      <input type="file"  name="joining_doc" id="joining_doc" required="true"/>
					    </div>
					    </div>
					    <div class="form-group col-xs-10">
					    	<label for="joining_date" class="col-sm-3 control-label  pdright pdleft">Joining Date</label>
					     <div class="col-sm-3">
					      <input type="text" class="datepicker_joining_date"  name="joining_date" id="joining_date"/>
					    </div>
					    </div>
					    <div class="form-group col-xs-10">
					    <label for="completion_date"  class="col-sm-3 control-label  pdright pdleft">Date of Completion</label>
					 	<div class="col-sm-3">
					      <input type="text" class="datepicker_joining_date"  name="completion_date" id="completion_date"/>
					    </div>
					    
					</div> 
					<br/>
					<br/>
					<br/>
					<br/>
					<div class="col-sm-12 pdleft">
					      <input type="submit" class="form-control sbmt" value="Submit"/>
					    </div>	
						</div>	
	   
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	