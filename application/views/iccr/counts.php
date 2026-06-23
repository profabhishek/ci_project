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
    .alert
    {
        margin: 0 auto 1%;    
        width: 85.5%;
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
<script>
    var editor; 
    $(document).ready(function () {
        
        $('#example').dataTable({
            "destroy": true,
            "lengthMenu": [[10, 25, 50, 200, 500,  -1], [10, 25, 50, 200, 500, "All"]],
//            "processing": true,
//            "serverSide": true,
//            "ajax": {
//                "url": "<?php //echo base_url();?>headquarter/getSchemewiseApplicantReportAjax",
//                "dataType": "json",
//                "type": "GET"
//            },
//        "columns": [
//            { "data": "fullname" },
//            { "data": "application_no" },
//            { "data": "email" },
//            { "data": "scheme_name" },
//            { "data": "university_is_accept" }
//        ]
        });
    });

</script>
<section class="meacontent">

    <div  class="container" style="min-height:410px;padding-top:15px;">	
        <marquee style="margin-bottom:5px;padding-top:0;">
            Welcome <?php
            $user_data = $this->session->userdata('user_data');
            echo $user_data['fname'];
            ?> to ICCR Scholarship Portal 
        </marquee>
        <div class="blue-heading col-md-12 ">
            <h3>Summarize Report </h3>
            <?php $title = "Total Accepted/Rejected List of Applicant"; ?>
            <form method="post" action="<?php echo base_url(); ?>headquarter/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
                  ">
                <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
                <input id="pdftitle" name="pdftitle" value="<?php echo $title; ?>" type="hidden"/>
                <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
            </form>
            <a href="<?php echo site_url(); ?>headquarter/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
		<form id="form-filter" class="form-horizontal">
			<div class="filters col-md-12 form-group">
			<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5 pdleft">Academic Year</label>
					<div class="col-md-6 pdright pdleft">
						<select id="programmes" name="programmes" class="selectpicker form-control" required="true">
						<option value="">Select</option>
						  <?php
						  $programme = $this->common_model->getAllProgramme();
						  foreach($programme as $na)
						  {
						  	echo '<option value="'.$na['id'].'">'.$na['name'].'</option>';
						  }
						  ?>
						  </select>
					</div>
			</div>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Gender</label>
					<div class="col-md-6 pdright pdleft">
						<select id="gender" name="gender" class="form-control">
							<option value="">Select</option>
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Email Id</label>
					<div class="col-md-6 pdright pdleft">
						<input type="text" id="mail" name="mail" class="form-control" placeholder="Email Id"/>
					</div>
				</div>
			
				
				
			
			</div>
			<div class="filters col-md-12 form-group">
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5 pdleft">Academic Programme</label>
					<div class="col-md-6 pdright pdleft">
						<select id="programmes" name="programmes" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						  <?php
						  $programme = $this->common_model->getAllProgramme();
						  foreach($programme as $na)
						  {
						  	echo '<option value="'.$na['id'].'">'.$na['name'].'</option>';
						  }
						  ?>
						</select>
					</div>
				</div>
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Course</label>
					<div class="col-md-6 pdright pdleft">
						<select id="courses" name="courses" class="selectpicker form-control" required="true">
							<option value="">Select</option>						  
						</select>
					</div>
				</div>
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Country</label>
					<div class="col-md-6 pdright pdleft">
						<select id="country" name="country" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						  <?php
						  $nationalities = $this->common_model->getCountries();
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
			<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
			</form>
        <table  id="example" class="customTable table table-striped table-bordered detailpagepdf">
            <thead>
           <th>Serial Number</th>			
            <th>Total Applications</th>
                     
            <th>Total Male</th>           				
            <th>Total Female</th>
            <th>Total UG</th>
            <th>Total PG</th>
            <th>Total Mphil</th>
            <th>Total Phd</th>
             <th>Total Accepted</th>
            <th>Total Rejected</th>
            <th>Total Joined</th>
            <th>Total Expenditure</th>
            </thead>
            <tbody>
                <?php
                $counter = 1;

                if (count($totalrecords) > 0) {
                    foreach ($totalrecords as $app) {                    	
                    	
                        ?>
                        <tr>
                            <td><?php echo $counter;?></td>				
                            <td><?php echo $app['totalCount']; ?></td>
                           
                            <td><?php echo $app['totalMale']; ?></td>	
                            <td><?php echo $app['totalFemale']; ?></td>	
                            <td><?php echo $app['totalUG']; ?></td>		
                            <td><?php echo $app['totalPG']; ?></td>		
                            <td><?php echo $app['totalMphil']; ?></td>		
                            <td><?php echo $app['totalPHD']; ?></td>
                             <td><?php echo $app['totalAccepted']; ?></td>
                            <td><?php echo $app['totalRejected']; ?></td>
                            <td><?php echo $app['totalAdmitted']; ?></td>
                            <td><?php echo $app['totalamount']; ?></td>	
                        </tr>
                        <?php
                        
                        
                        $counter++;
                    }
                }
                ?>
            </tbody>
        </table>
        <hr/>
    </div>
</section>


