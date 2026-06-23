<style type="text/css">
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
.backbtn
{
	top:9px;
}
.divider{
	margin:0;
}
marquee{
	
    border: 1px solid #cecece;
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto 5px;
    padding: 7px 5px 0 !important;
    text-align: left;
}
.pops
{
	background: white none repeat scroll 0 0;
    border: 2px solid rgba(0, 0, 0, 0.3);
    min-height: 150px;
    padding: 20px;
    text-align: center;
}
</style>
<script>
</script>
<style>
	.icssr-filter{margin-left:10px;}
	</style>
<script type="text/javascript">
	function forwardtouniverstiychoice(id,appno)
	{
		var valu = $('#' + id).val();		
		if(valu != "")
		{
			var cls = $('#' + id + ' option:selected').attr("class");
			location.href = baseURL + "regional/forwardtouniversity/" + appno + "/" + cls;	
		}
		else
		{
			BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error" ,message: "Select Preference.!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]}); 
		}
	}
</script>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:15px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal, The Last date for submission of application for the session 2019-2020 has been extended up to 31st March 
		</marquee>	
		<div class="blue-heading col-md-12 ">
			 <h3 style="float:left;">Application Received</h3>
			
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>regional/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		
		<div class="container">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>
		<div class = "table-responsive">
		<table id="customTable" class ="table table-striped table-bordered detailpagepdf newApplication">
			<thead>
				<th>S.No.</th>		
				<th>Application No</th>	
				<th>Applicant Name</th>	
				<th>Email</th>	
				<th>Country</th>
				<th>Scheme</th>
				<th>Course</th>
				<th>Universities Options</th>				
				
				<th>Date of Registration</th>
			    <th>Date of Submission</th>	
				<th>View</th>
				<!----<th>Process</th>--->
				<th>Status</th>
			</thead>
			<tbody>
		</table>
		</div>
		<hr/>
	</div>
	<div id="universtiyLetterdiv" class="modal fade" role="dialog">
	  	<div id="universtiyLetter" class="modal-dialog popup dropzone">
	  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
	  		</div>
	  </div>
	  <!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">STATUS</h4>
                        </div>
                        <div class="modal-body">
     
						</div>
	<div class="modal-footer">
	<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
	<!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
           
	
	</div>
                    </div>
                  
                </div>
            </div>
			
			
			<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">STATUS</h4>
                        </div>
                        <div class="modal-body">
     
						</div>
	<div class="modal-footer">
	<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
	<!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
           
	
	</div>
                    </div>
                  
                </div>
            </div>
</section>
<script>
 $(document).ready(function(){
	
	 reprottable = $('.newApplication').DataTable( {
		
        "order": [[1, "desc" ]],
        "processing": true,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":"<?php echo site_url('regional/getNewApplicaitonsDemo')?>",
        	"type": "POST",
            "data": function ( data ) {
               data.MinDate = $('#min-date').val();
               data.MaxDate = $('#max-date').val();
			   data.ApplicantName = $('#applicant_name').val();         
               data.Programme = $('#programmes').val();                
               data.Counrse = $('#courses_mission').val();
               data.Universtiy = $('#university').val();
			   data.Scheme = $('#schemes').val();
			   data.Country = $('#country').val();
            }
        },
         
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/images/loader.gif'></div>"}
    } );
	
	
$('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});

// Set up your table


// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[2] || 0; // Our date column in the table
	
	//console.log(min+'--'+max);
	
    if (
      (min == "" || max == "") ||
      (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
    ) {
      return true;
    }
    return false;
  }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change(function() {
  reprottable.draw();
});

$('#my-table_filter').hide();
}); 

function openStatus(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/openUniversityStatus')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}
</script>