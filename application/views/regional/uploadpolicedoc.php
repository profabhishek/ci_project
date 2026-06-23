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
		<h3 class="text-center caps">Upload Residential Permit of Applicant</h3>
		<h4 class="text-center caps">APPLICATION NUMBER <?php echo $appno; ?></h4>		
	</div>
	<div class="headsec container">Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal </div>
	<div  class="container" style="min-height:101px;padding:0px;">		
	<div class="tab-content footr" style="min-height:300px;">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-visa" action="<?php echo site_url();?>regional/createPolicedoc/<?php echo $appno; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	     <div class="box-body">
	     <input type = "hidden" name = "app_id" id="app_id" value = "<?php echo $appno;?>">
	       	<div class="form-group col-xs-10">
					    <label for="inputEmail3" class="col-sm-3 control-label">Academic Year</label>
					    <div class="col-sm-3">
					      <select id="acdemic_year" name="acdemic_year" class="selectpicker form-control FY_DATEPICKER" required>
					      		<option value=''>--Select--</option>
							   <?php 
								  
								 
									   
								   	echo '<option value="2017-2018">2017-2018</option>';
									echo '<option value="2018-2019">2018-2019</option>';
									echo '<option value="2019-2020">2019-2020</option>';
									echo '<option value="2020-2021">2020-2021</option>';
									echo '<option value="2021-2022">2021-2022</option>';
									echo '<option value="2022-2023">2022-2023</option>';
									
								   
								  ?>
							</select>
					    </div>
					</div>
	     
	     
	    <div class="form-group col-xs-10">
					    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Upload Residential Permit</label>
					    <div class="col-sm-3">
					      <!----<input type="file"  name="police_doc" id="police_doc" required="true"/>--->
						  <input type="file" name="police_doc" id="files"  multiple/ required>
					    </div>
					
					    <!----<div class="col-sm-2 pull-right">
					      <input type="submit" class="form-control sbmt" value="Submit"/>
					    </div>-->	
					</div> 
						</div>	
	   
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	<script>
$(document).ready(function(){
 $('#files').change(function(){
	 //alert('ok');
  var files = $('#files')[0].files;
//alert(files);
  var appno = $('#app_id').val();
   var acdemicyear = $('#acdemic_year').val();
  //alert(appno);
  //var serializeformdata = $("form").serializeArray();
  //alert(JSON.stringify(serializeformdata));
  var error = '';
  var form_data = new FormData();
  
  for(var count = 0; count<files.length; count++)
  {
   var name = files[count].name;
   var extension = name.split('.').pop().toLowerCase();
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','pdf']) == -1)
   {
	   
	BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: error += "Invalid" + count + "Image File" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
    
   }
   else
   {
    form_data.append("files[]", files[count]);
	//alert(JSON.stringify(form_data));
   }
  }
  form_data.append("appid", appno);
  form_data.append("acdemic_year", acdemicyear);
  //alert(JSON.stringify(form_data));
  if(error == '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>regional/rpUpload",
    method:"POST",
    data:form_data,
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
     $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
    },
    success:function(data)
    {
		//alert(data);
		 if(data){
			window.location.href = "<?php echo base_url(); ?>regional/issueDocuments";
		} 
     //$('#uploaded_images').html(data);
     //$('#files').val('');
    }
   })
  }
  else
  {
   alert(error);
  }
 });
});
</script>	