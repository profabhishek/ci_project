   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mission 
        <small>Create Missions</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Mission</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Create Mission</div>
			<?php echo form_open('admin/createMission',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                    <select name="missioncountry" id="missioncountry" title="Please select Country" class="form-control">
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Type</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="mission_type" name="mission_type">
                    		<option value="0">--Select Mission Type --</option>
							<option value="Assistant High Commission of India">Assistant High Commission of India</option>
							<option value="Consulate General of India">Consulate General of India</option>
							<option value="Embassy of India">Embassy of India</option>
							<option value="High Commission of India">High Commission of India</option>
							<option value="Honorary Consul General">Honorary Consul General</option>
							<option value="Honorary Consul of India">Honorary Consul of India</option>
							<option value="Other">Other</option>
							<option value="Permanent Mission of india">Permanent Mission of india</option>
                    </select>
                  </div>
                </div>
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Mission Name</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="mission_name" name="mission_name" placeholder="Mission Name" type="text">
                  </div>
                </div>               
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                   <input class="form-control" id="mission_email" name="mission_email" placeholder="Email Id" type="email">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">                
                <button type="submit" class="btn btn-success pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            <?php echo form_close(); ?>
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