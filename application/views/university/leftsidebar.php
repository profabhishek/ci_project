<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo site_url();?>assets/site/main/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Super Admin</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
       
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          	<li class="active"><a href="<?php echo site_url();?>admin/dashboard"><i class="fa fa-book"></i> Dashboard</a></li>
          	<li class="active"><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-book"></i> All Mission</a></li>
          	<li><a href="<?php echo site_url();?>admin/allregions"><i class="fa fa-book"></i> All Region</a></li>          	
             <li><a href="<?php echo site_url();?>admin/allUniversities"><i class="fa fa-book"></i> All Universities</a></li>
             <li><a href="<?php echo site_url();?>admin/allSchemes"><i class="fa fa-book"></i> All Schemes</a></li>
             <li><a href="<?php echo site_url();?>admin/allSchemeslots"><i class="fa fa-book"></i> All Schemes Slot</a></li>
             <li><a href="<?php echo site_url();?>admin/allStudents"><i class="fa fa-book"></i> All Students</a></li>
             <li><a href="<?php echo site_url();?>admin/adduniverstiyMapping"><i class="fa fa-book"></i>University Mapping</a></li>
            <li><a href="<?php echo site_url();?>admin/addMission"><i class="fa fa-book"></i> Create Mission</a></li>
            <li><a href="<?php echo site_url();?>admin/addRegion"><i class="fa fa-book"></i> Create Region</a></li>
            <li><a href="<?php echo site_url();?>admin/addUniversity"><i class="fa fa-book"></i> Create University</a></li>
            <li><a href="<?php echo site_url();?>admin/addSchemeSlot"><i class="fa fa-book"></i> Create Seat Allotment</a></li>
            <li><a href="<?php echo site_url();?>admin/addSchemeMapping"><i class="fa fa-book"></i> Create Schemes Mapping</a></li>
            <li><a href="<?php echo site_url();?>admin/addRegionalOffice"><i class="fa fa-book"></i> Create Regional Login</a></li>
            <li><a href="<?php echo site_url();?>admin/addMissionLogin"><i class="fa fa-book"></i> Create Mission Login</a></li>
			<li><a href="<?php echo site_url();?>admin/getFeedbackList"><i class="fa fa-book"></i> Feedback List</a></li>
            <li><a href="<?php echo site_url();?>admin/page/view"><i class="fa fa-book"></i> All Pages</a></li>
            <li><a href="<?php echo site_url();?>admin/page/add"><i class="fa fa-book"></i> Create Page</a></li>
			  <li><a href="<?php echo site_url();?>admin/allNotification"><i class="fa fa-book"></i> All Notification</a></li>
            <li><a href="<?php echo site_url();?>admin/addNotification"><i class="fa fa-book"></i> Create Notification</a></li>
			<li><a href="<?php echo site_url();?>admin/totalApplicationMission"><i class="fa fa-book"></i>Total Application Mission</a></li>
			<li><a href="<?php echo site_url();?>admin/totalCountryWiseApplicationMission"><i class="fa fa-book"></i>Total Country Wise Application Mission</a></li>
			
			<li><a href="<?php echo site_url();?>admin/totalForwordApplicationMission"><i class="fa fa-book"></i>Total Application Forword</a></li>
			<li><a href="<?php echo site_url();?>admin/totalApplicationRo"><i class="fa fa-book"></i>Total Application Ro</a></li>
			<li><a href="<?php echo site_url();?>admin/reports"><i class="fa fa-book"></i>Report</a></li>
			<li><a href="<?php echo site_url();?>admin/CountryWiseConfirmation"><i class="fa fa-book"></i>Report1</li>
			<li><a class="btn btn-block btn-default" id ="notification" data-toggle="modal" data-target="#notificationModal">Final Submit</a></li>
			<li><a href="<?php echo site_url();?>admin/AfricanCountry"><i class="fa fa-book"></i>African Country</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>