<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
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
</style>
<div id="main-wrapper" class="clearfix">
	<div id="main" class="clearfix">
		<a name="MainContent" id="MainContent">&nbsp;</a>
		<?php //$this->load->view('nma/leftsidebar');?>
		<div class="content column">
			<div class="nnc enform">
			
			<?php if($this->session->flashdata('success')){ ?>
			<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
			</div>
			<?php }else if($this->session->flashdata('error')){  ?>
			<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
			</div>
			<?php }else if($this->session->flashdata('warning')){  ?>
			<div class="alert alert-warning">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
			</div>
			<?php }else if($this->session->flashdata('info')){  ?>
			<div class="alert alert-info">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
			</div>
			<?php } ?>
				<h1 class="title" id="page-title">Login History</h1>
					 
			 
				
					
					
						<table class="table custm-stript display " id="example">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>User Name</th>
										<th>User Type</th>
										<th style="width: 14%;">Date & Time</th>
										<th>IP Address</th>
										<th>Login/Logout</th>
										<th style="width: 44%;">User Agent</th>
										
										</tr>
								</thead>
								<tbody>
								
								<?php 
								$i=1;
								foreach($loginHistorys  as $item)
								{
									//print_r($item);
								
								?>
									<tr>
										<tbody>
											<td><?php echo $i++ ;?> </td>
											<td><?php echo $item['first_name'];?></td>
											<td><?php 
											if($item['user_type']==1)
											{
												echo "Applicant";
											}
											if($item['user_type']==2)
											{
												echo "Mission";
											}if($item['user_type']==3)
											{
												echo "Head Quarter";
											}
											if($item['user_type']==4)
											{
												echo "Regional Office";
											}
											if($item['user_type']==8)
											{
												echo "University";
											}
											
											
											?></td>
											<td><?php echo $item['when'];?></td>
											<td><?php echo $item['ip_address'];?></td>
											<td><?php echo $item['action'];?></td>
											<td><?php echo $item['uri'];?></td>
											
											

										</tbody>
										<tr>
								<?php }?>
									</table>
				
			</div>
		</div>
	</div>
</div>
	








			
			<script>
				$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
           'csv', 'excel', 'pdf'
        ]
    } );
} );

		

			</script>