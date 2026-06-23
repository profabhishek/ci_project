   <!-- Content Wrapper. Contains page content -->
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
</style>  
   <?php 

function sortByName($a, $b)
{
	$a = $a['uni'];
	$b = $b['uni'];

	if ($a == $b)
	{
		return 0;
	}

	return ($a < $b) ? -1 : 1;
}
$stateuniversities = $this->common_model->getStateUniversities();

//

$centraluniversities = $this->common_model->getCentralUniversities();

$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states =  $this->common_model->getAllStates();

$statewiseUniversites = array();
foreach($states as $st)
{
	if(!array_key_exists($st['id'],$statewiseUniversites))
	{
		$statewiseUniversites[$st['id']] = array();
	}
}

$stateuniversities_one = str_replace("'","\'",json_encode($stateuniversities));
$centraluniversities_one = str_replace("'","\'",json_encode($centraluniversities));
$nits_one = str_replace("'","\'",json_encode($nits));
$yogas_one = str_replace("'","\'",json_encode($yogas));
$states_array = json_encode($statewiseUniversites);
?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
var centralUniversities = JSON.parse('<?php echo $centraluniversities_one;?>');
var nits = JSON.parse('<?php echo $nits_one;?>');
var yogas = JSON.parse('<?php echo $yogas_one;?>');
var statesarray = JSON.parse('<?php echo $states_array;?>');
</script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Application 
        <small>Country-wise(Africa)Confirmation</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Schemes List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
<form id="form-filter" class="form-horizontal">
			<div class="filters col-md-12 form-group">
					
				
			
				
				
			
			</div>
			<div class="filters col-md-12 form-group">
				
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Country</label>
					<div class="col-md-6 pdright pdleft">
						<select id="country" name="country" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						  <?php
						  $nationalities = $this->admin_model->getAfricanCountries();
						  foreach($nationalities as $na)
						  {
						  	echo '<option value="'.$na['id'].'">'.$na['country_name'].'</option>';
						  }
						  ?>
						</select>
					</div>
				</div>
				
			
				
				
			</div>	
		
			<div class="filters col-md-12 form-group">
				<div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button>
                 </div>
			</div>

		<hr style="float: left;width:98%;"/>
		<div class="row">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>
</form>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">

    	<div class="box">
			<div class="box-header">Total Confirmation
			<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadTotalafricanConfirmationPdf" target = "__blank">
			<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/></a></div>
			</div>
			
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>				
				<th>Country</th>	
				<th>Total</th>	    		
	       	</thead>
	       	<tbody>
	       		<?php	       		 
	       		$counter = 1;
				$sum = 0;
	       		foreach($confirmation as $confirm)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $confirm['country_name'];?></td>
					<td>
					<?php 
					 echo $confirm['Total'];
					 
					 ?>
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
  
<script>

$(document).ready(function() {
    $('.myMissions').DataTable( {
		alert('ok');
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],
        columnDefs: [ {
            targets: -1,
            visible: false
        } ]
    } );
} );
</script>-->
<script type="text/javascript">
		

$(document).ready(function() {
 	 table = $('#myreporttable').DataTable({ 
	 
	 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "searching": false,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/getAfricaReports')?>",
            "type": "POST",
            "data": function ( data ) {
				data.MinDate = $('#min-date').val();
                data.MaxDate = $('#max-date').val();
                
                data.Country = $('#country').val();
                data.Programme = $('#programmes').val();
                data.Region = $('#region').val();
                data.Counrse = $('#courses').val();
                data.Universtiy = $('#university').val();
                data.Scheme = $('#schemes').val();
				data.Status = $('#status').val();
            }
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 $('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});
    $('#btn-filter').click(function(){ 
	//alert('okkkkk');
	//button filter event click
        table.ajax.reload(null,false);  //just reload table
    });
    $('#btn-reset').click(function(){
		//alert('ok');
		//button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload(null,false);  //just reload table
    });   
});
</script>