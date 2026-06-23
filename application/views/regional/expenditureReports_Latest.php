<?php 
function getMode($id)
{
	$mode = array('1'=>'Cash','2'=>'Cheque','3'=>'NEFT','4'=>'RTGS','5'=>'Other');
	return $mode[$id];
}
?>
<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:93px;margin:0 auto;text-align:center;}
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
.filter1,.filter2,.filter3
{
	border-bottom: 1px solid #cecece;
    border-top: 1px solid #cecece;
    margin-bottom: 36px;   
    padding-bottom: 15px;
    padding-top: 10px;
}
.filter label{padding-right:0;padding-top:10px;width:180px;}
.filter1 label{padding-right:0;padding-top:10px;width:180px;}
.filter2 label{padding-right:0;padding-top:10px;width:180px;}
.filter3 label{padding-right:0;padding-top:10px;width:180px;}
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
.rptlbl{
	display: block;
    font-weight: bold;
    text-align: center;
}
.backgr{
	 background: #000 none repeat scroll 0 0;
    bottom: 0 !important;
    opacity: 0.5;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 111111;
    display: none;
}
.lod{
	  height: 100px;
    margin: 0 auto;
    position: absolute;
    text-align: center;
    top: 31%;
    width: 100%;
    z-index: 2147483647;
    display: none;
}
.lod img{
	 margin: 0 auto;
     width: 5%;
}
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Expenditure Report </h3>
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="blue-heading col-md-12 ">				 
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadAllExpenditureReport/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		</div>
	<div class="tab-content">		
	  <div id="home" class="tab-pane fade in active">	   
	   
	    <div class="box-body detailpagepdf">
	    <form id="form-filter" class="form-horizontal">
			<div class="filters col-md-12 form-group">
					
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Financial Year</label>
					<div class="col-md-6 pdright pdleft">
						<select id="fyear" name="fyear" class="form-control">
							<option value="">Select</option>
							<?php
								$i=0;
								foreach($fy as $financialYear)
								{
									echo '<option value="'.$financialYear.'">'.$financialYear.'</option>';
									$i++;
								}
							?>							
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Quarter</label>
					<div class="col-md-6 pdright pdleft">
						<select id="quarter" name="quarter" class="form-control">
							<option value="">Select</option>
							<option value="1">First Quarter</option>
							<option value="2">Second Quarter</option>
							<option value="3">Third Quarter</option>
							<option value="4">Fourth Quarter</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Month</label>
					<div class="col-md-6 pdright pdleft">
						<select id="qrtMonth" name="qrtMonth" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						 	<?php
						 		for($month=0; $month<=11;$month++)
						 		{
									echo '<option value="'.($month+1).'">'.date('F', mktime(0, 0, 0, ($month+1), 10)) .'</option>';
								}
						 	?>
						</select>
					</div>
				</div>					
			</div>
			<div class="filters col-md-12 form-group">
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Schemes</label>
					<div class="col-md-6 pdright pdleft">
						<select id="schemes" name="schemes" class="selectpicker form-control" required="true">
							<option value="">Select</option>
							<option value="all">All</option>
						  <?php
						  $schems = $this->common_model->getAllSchemes();
						  foreach($schems as $na)
						  {
						  	echo '<option value="'.$na['id'].'">'.$na['scheme_name'].'</option>';
						  }
						  ?>
						</select>
					</div>
				</div>				
			<div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button>
                 </div>
				
				
			</div>	
			
			<div class="filters col-md-12 form-group">
			
					
				
			</div>				
			</form>
			
					<hr style="width:100%;float:left;"/>
					<h4 style="text-decoration:underline;text-align:center;">INDIAN COUNCIL FOR CULTURAL RELATIONS</h4>
					<span class="rptlbl">Financial Year - <label class="lblfy">All</label></span>
					<span class="rptlbl">Quarter - <label class="lblqrt">1st/2nd/3rd/4th/ALL</label></span>
					<br/>
	     			<table id="tbl_report" class="table table-striped table-bordered tblexp" style="width:100%;">
				 		<thead>
				 			<th> Code</th>
					 		<th> Scheme Name</th>
					 		<th> Expenditure</th>
		 				</thead>
				 		<tbody>						 			
				 			<?php 
				 			if(count($expenditure)>0)
				 			{
								
							}
							else
							{
								echo '<tr><td colspan="3">No Record Found</td></tr>';
							}
				 			?>
				 		</tbody>
				 	</table>
					<hr/>
					<table id="tbl_report" class="table table-striped table-bordered tbl_reg" style="width:100%;">
				 		<thead>
				 			<th> Regional Office</th>
					 		<th> Scheme Name</th>					 		
		 				</thead>
				 		<tbody>						 			
				 			<?php 
				 			if(count($expenditure)>0)
				 			{
								
							}
							else
							{
								echo '<tr><td colspan="3">No Record Found</td></tr>';
							}
				 			?>
				 		</tbody>
				 	</table>
				<br/>				
			</div>
              <!-- /.box-body -->
           
	  </div>	   
	</div>
	</div>
</section>
	<script type="text/javascript">
$(document).ready(function(){
	
	$('#btn-filter').click(function(){
		$('.backgr').show();
		$('.lod').show();
		
		$.ajax({
			url: baseURL + "regional/getExpenditureDetails",
			type: "POST",		      
		    data: {"fy":$('#fyear').val(),"quarter":$("#quarter").val(),'qrtMonth':$("#qrtMonth").val(),'schemes':$('#schemes').val()},
		    dataType:'json',
		    success: function (josndat) {
		    	$('.lblfy').text($('#fyear').val());
		    	if(Object.keys(josndat.schemes).length > 0)
		    	{
		    		var ht = ""; var htr = "";
		    		for(key in josndat.schemes) {		    			    			
					  	var d = josndat.schemes[key];
					    ht += "<tr>";
						ht += "<td>" + d.code + "</td>";
						ht += "<td>" + d.name + "</td>";
						ht += "<td>" + d.expenditure + "</td>";
						ht += "</tr>";					  
					}
					for(key in josndat.region) {		    			    			
					  	var d = josndat.region[key];
					    htr += "<tr>";
						htr += "<td>" + d.r + "</td>";
						htr += "<td>";
						htr += "<table class='table'><tbody>";
						if($('#schemes').val()>0)
						{							
							d.schemes;
							htr += "<tr>";
							htr += "<td>" + d.schemes.name + "</td>";
							htr += "<td>" + d.schemes.expenditure + "</td>";
							htr += "</tr>"; 
						}
						else
						{
							for(s in d.schemes)
							{
								var ss = d.schemes[s];
								htr += "<tr>";
								htr += "<td>" + ss.name + "</td>";
								htr += "<td>" + ss.expenditure + "</td>";
								htr += "</tr>"; 							 
							}
						}
						
						htr += "</tbody></table>";
						htr += "</td>";						
						htr += "</tr>";					  
					}		
					$('.tbl_reg tbody').html(htr);			
					$('.tblexp tbody').html(ht);
				}
		    	$('.backgr').hide();
				$('.lod').hide();
		    },
		    error:function(){
				$('.backgr').hide();
				$('.lod').hide();
			}
		});
	});
	
	
	
});
</script>
<div class="backgr"></div>
<div class="lod"><img src="<?php echo site_url(); ?>assets/site/main/images/Calculator.gif"/></div>