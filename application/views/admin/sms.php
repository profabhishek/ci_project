   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
        <small>SMS</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> SMS</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Send SMS</div>
			<?php echo form_open('admin/sendSMSdemo1',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                
               
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Mobile No</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="mobile" name="mobile" placeholder="Mobile" type="text">
                  </div>
                </div>               
                <!----<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Message</label>
                  <div class="col-sm-10">
                   <input class="form-control" id="message" name="message" placeholder="Mesage" type="text">
                  </div>
                </div>-->
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