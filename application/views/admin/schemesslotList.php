   <style type="text/css">
	#frm_details_ngo {
    float: right;
    position: absolute !important;
    right: 148px;
    top: 16px !important;
    z-index: 999999;
}
.blue-heading h3
{
	margin-top: 13px !important;
	font-weight: bold;
}
.export-btn
{
	 background: rgba(0, 0, 0, 0) url("../assets/site/main/images/pdf_icon.png") no-repeat scroll 0 0 / 100% auto;
    border: medium none;
    border-radius: 4px;
    color: #fff;
    font-size: 10px;
    height: 36px;
    padding: 3px 10px;
    width: 129px;
}

</style>
   <script type="text/javascript">
   	var slots = [];
   	
   	function updateSchemesSlots(id)
   	{
		var obj = slots[id];
		$('#schemes_one').val(obj.scheme_id);
		$('#schemecountry_one').val(obj.country_id);
		$('#seats_one').val(obj.slots);
		$('#schemesId').val(id);
	}
	$(document).ready(function(){
		$("#frm_schemes_update").submit(function() {   
		var  formID = $(this).attr('id');
		var formDetails = $('#'+formID);	
			
		$.ajax({
		    type: "POST",
		    url: baseURL +'admin/updateSeatsAllotment',
		    data: formDetails.serialize(),
		    dataType:'json',
		    success: function (data) {	
		    	if(data.status == true)
		    	{
		    		BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Update Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "admin/allUniversities";}}]});
				}
		      },
		        error: function(jqXHR, text, error){
		                
		      }
		   });
		        return false;
		  });
	});
   </script>
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Schemes Seats  
        <small>All Schemes Seats</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Schemes Seats List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
      	 <form method="post" action="<?php echo base_url();?>admin/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
    	<div class="box">
			<div class="box-header">Schemes Seats List<div class="pull-right"><a href="<?php echo site_url();?>admin/addSchemeSlot">Add Schemes Seats</a></div></div>
			<div class="box-body">
	      	<table id="tbl_schrls" class="table table-bordered table-striped myMissions detailpagepdf" style="width:100%;">
	       	<thead>
	       		<th>S.No.</th>
	       		<th>Code</th>
	       		<th>Scheme</th>	       		
	       		<th>Country</th>
	       		<th>Type</th>	       		
	       		<th>Action</th>       		
	       	</thead>
	       	<tbody>
	       		<?php	       		
	       		$counter = 1;
	       		foreach($schemesslot as $schslot)
	       		{
				?>
				<tr>
				<?php
					echo '<script type="text/javascript">';
	       			echo 'var schemeslist = [];';
	       			echo 'schemeslist["id"]='.$schslot["id"].';';
	       			echo 'schemeslist["country_id"]='.$schslot["country_id"].';';
	       			echo 'schemeslist["slots"]='.$schslot["slots"].';';	
	       			echo 'schemeslist["scheme_id"]='.$schslot["scheme_id"].';';	       			
	       			echo 'slots['.$schslot["id"].'] =schemeslist;';
	       			echo '</script>';
	       			
					?>
					<td><?php echo $counter;?></td>
					<td><?php echo $schslot['code'];?></td>
					<td><?php echo $schslot['scheme_name'];?></td>
					
					<td><?php
					$country_counter=0;
						$countryIds = explode("|",$schslot["country_id"]);		
						//asort($countryIds);				
						foreach($countryIds as $contid)
						{
							$contname = $this->common_model->getCountryById($contid);
							echo $contname[0]['country_name'];
							echo "<br/>";
							$country_counter++;
						}
						echo "<br/>";
						echo "<br/>";
						echo "<hr/>";
						echo "Total: ".$country_counter;
					?></td>
					<td><?php 
					if($schslot['slots'] == 1) echo "Non-Agency"; elseif($schslot['slots'] == 2) echo "Agency";?></td>
					
					 <td>
                  <a href="javascript:void(0);"  class="icon_link edit" data-toggle="modal" data-target="#updateSchemesSlots" onclick="updateSchemesSlots('<?php echo $schslot["id"];?>');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<span class="space">&nbsp;&nbsp;&nbsp;</span>
				<a href="javascript:void(0);" class="icon_link delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
								</td>
				</tr>
				<?php	
				$counter++;
				}
	       		?>
	       	</tbody>
	       </table>
      		</div>
       </div>
       </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <div id="updateSchemesSlots" class="modal fade" role="dialog">
  	<div class="modal-dialog popup">
  		 <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Update Seats Allotment for Different Schemes</div>
			<form id="frm_schemes_update" name="frm_schemes_update">
              <div class="box-body">
              	<input type="hidden" value="0" name="schemesId" id="schemesId"/>
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Schemes</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="schemes_one" name="schemes_one" required="true">
                    	 <option value="">---- Schemes ---</option>
						  <?php
						  $schemses = $this->common_model->getAllSchemes();
						  foreach($schemses as $scheme)
						  {
						  	echo '<option value="'.$scheme['id'].'">'.$scheme['scheme_name'].'</option>';
						  }
						  ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                    <select name="schemecountry_one" id="schemecountry_one" title="Please select Country" class="form-control" required="true">
						<option value="">---- Country ---</option>
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
						  }
						  ?>
					</select>
                  </div>
                </div>
             
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Seats</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="seats_one" name="seats_one" placeholder="Seats" required="true" type="text">
                  </div>
                </div>              
              </div>
              <!-- /.box-body -->
              <div class="box-footer">                
                <button type="submit" class="btn btn-success pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>
       </div>
       </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  	</div>
  </div>	