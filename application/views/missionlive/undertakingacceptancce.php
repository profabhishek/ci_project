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
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
}
</style>
<section class="meacontent">	
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
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">UPLOAD UNDERTAKING OF STUDENT</h3>
		<h4 class="text-center caps">APPLICATION NUMBER : <b><?php echo $appno; ?></b></h4>		
	</div>
	
	<div  class="container" style="height:103px;padding:0px;">		
	<div class="tab-content">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-visa" action="<?php echo site_url();?>mission/UploadUnderTaking/<?php echo $appno; ?>" enctype="multipart/form-data" method="post" class="form-horizontal">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	   	 
            
              		
					<div class="form-group col-xs-10">
					    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Upload Undertaking Scanned Copy</label>
					    <div class="col-sm-3">
					      <input type="file"  name="undertaking" id="undertaking"/>
					    </div>
					    
					<?php
					if(count($undertaking)>0 && $undertaking[0]["undertaking_doc"] != "NULL" && $undertaking[0]["undertaking_doc"] != "")
					{
						//echo "<div class='col-sm-4'> <a class='link_div' download href='".site_url()."assets/site/main/undertakings/".$undertaking[0]['undertaking_doc']."'>Click to View</a></div>";
					}
					else
					{
						//echo "<div class='col-sm-4 link_div'> Not Uploaded</div>";
					} 
					 ?>	
					    <div class="col-sm-2 pull-right">
					      <input type="submit" class="form-control sbmt" value="Submit"/>
					    </div>	
					</div> 
								 	
					 			
			</div>
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	