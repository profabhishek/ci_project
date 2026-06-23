<span id="meacontent" class="meacontent"></span>
<section class="bannerarea" style="margin:0px auto;max-height: 440px;">
			<div class="banner" style="max-height: 440px;">
				<div id="myCarousel" class="carousel slide" data-ride="carousel" style="max-height: 440px;">
					<div class="carousel-inner" role="listbox">
					<div class="item active">
					  <img class="first-slide" src="<?php echo base_url();?>assets/site/main/images/banner/004.jpg" alt="ICCR  Banner" />
					</div>
                                        <!--<div class="item">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/Banner2.jpg" alt="ICCR Banner" />
					</div>
					<div class="item">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/Banner3.jpg" alt="ICCR  Banner" />
					</div>
					<div class="item ">
					  <img class="first-slide" src="<?php echo base_url();?>assets/site/main/images/banner/Banner5.jpg" alt="ICCR  Banner" />
					</div>
					<div class="item ">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner3.jpg" alt="ICCR  Banner" />
					</div>
					<div class="item">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner2.jpg" alt="ICCR Banner" />
					</div>
					<div class="item ">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner1.jpg" alt="ICCR  Banner" />
					</div>
					<div class="item">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner4.jpg" alt="ICCR  Banner" />
					</div>
					<div class="item">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner5.jpg" alt="ICCR Banner" />
					</div>
					<div class="item ">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner6.jpg" alt="ICCR  Banner" />
					</div>
					<div class="item ">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/001.jpg" alt="ICCR  Banner" />
					</div>
					
					<div class="item">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/003.jpg" alt="ICCR  Banner" />
					</div>-->
					
										
					
				
					</div>
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</section>
<section class="meacontent" style="margin: 0px; padding-top: 0px;">
			<div  class="container" style="border-left:1px solid #cecece;border-right:1px solid #cecece;padding-top:10px;">
			 <?php $todate = date('Y-m-d');?>
			<?php $notifications = $this->common_model->getActiveNotification($todate);?>
			
				<div class="marqHold">
			Welcome to Indian Council for Cultural Relations Scholarship Portal
		
			<!----<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" ><a href="<?php echo base_url();?>assets/site/docs/A2A_Portal_Admission_2019-20.pdf" target = "_blank" >Admissions Through A2A Portal 2019-2O20</a>--->
		
			</div>
			

   <div class="marqWrap">
	 <?php 
		if(!empty($notifications)){
			?>
	<div class="lower-menu marquee">
	<ul class="ml-auto">
	<?php 
		
		foreach($notifications as $notval){?>
		
		 <li>
		<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" ><a href="<?php echo site_url('home/notificationList/'.$notval['id']);?>"><?php echo $notval['title']?></a>
		</li>
		<?php  
		}
		?>
		
	</ul>

	
</div>
<?php }  ?>	
<button class="form-control sbmt allnotification" onclick="location.href='<?php echo site_url();?>home/getAllActiveNotification/'">View All Notifications</button>
		
</div>
				
	</div>		
				
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
			<?php 
			$user = $this->session->userdata('user_data');			
			if($user == '' || $user['user_type'] < 1)
			{
			?>
			<div class="httext text-left loginhead" style="background:#F18F2E;color:#fff;">ICCR SCHOLARSHIP PORTAL LOGIN</div>
				<div class="col-xs-12 col-sm-6 col-md-12 pdleft pdright">
					<div class="loginarea" style="width:50%;margin:0 auto; padding: 27px;" id="myLogin">
						<form action="<?php echo site_url();?>user/login" enctype="multipart/form-data" method="post">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						
						<div class="form-group">
							<label>Login ID</label>
							<div class="input-rig">
							<input type="text" required name="username" id="username" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label>Password</label>
							<div class="input-rig">
							<input type="password" name="pass" id="pass" required class="form-control" />
							</div>
						</div>
						<div class="form-group options">
							<label>Are you applicant</label>
							<div class="input-rig">
							<label class="radio-inline"><input type="radio" id = "app_r" name="optradio" value = "1" style="margin:10px 0 0 -20px" >Yes</label>
							<label class="radio-inline"><input type="radio" style="margin:10px 0 0 -20px" value = "2" name="optradio" checked>No</label>
							</div>
						</div>
						<div id = "app_div" style="display:none">
						<div class="form-group">
							<label>Apply For</label>
							<div class="input-rig">
							<select id="course_type" name="course_type" class="form-control">
							<option value="">Select</option>
							<!----<option value="2017">2017-2018</option>
							<option value="2018">2018-2019</option>--->
							<!-----<option value="2019">2019-2020</option>----->
							<option value="2">Under all Scholarship Schemes for ICCR</option>
							<option value="1">Ph.D(Under all Scholarship Schemes for ICCR)</option>
							<option value="2">Ayush Scholarship Scheme(UG/PG/PHD in Ayuerveda,Yoga,Unani,Siddha and Homoeopathy)</option>
							<option value="2">SFS(Self Finance Student) Under Ayush Scholarship Scheme</option>
							</select>
							</div>
						</div>
						<div class="form-group">
							<label>Registation Year</label>
							<div class="input-rig">
							<select id="year" name="year" class="form-control">
							<option value="">Select</option>
							<!----<option value="2017">2017-2018</option>
							<option value="2018">2018-2019</option>--->
							<!-----<option value="2019">2019-2020</option>----->
							<option value="2020">2020-2021</option>
							</select>
							</div>
						</div>
						</div>
						<div class="form-group">
						<label>Captcha</label>
						   <div class="captcha input-rig">
							 <img alt="captcha" src="<?php echo $captcha['image_src']; ?>"/>
							 <input type="text" required id="captchatext" name="captchatext"  class="form-control" />
							</div>
						</div>
						<div class="form-group btn-sec">
						    <div class="submit-sec input-rig">
							<input type="submit" class="form-control sbmt" value="Submit" onclick="getPass();" />
							<input type="button" class="form-control sbmt" onclick="refresh_login();" value="Reset" />
							</div>
						</div>
						<br/>
						<div class="col-xs-12 col-sm-6 col-md-6 pdleft text-left">
							<a title="Sign Up" href="<?php echo site_url();?>home/register">Don't Have Account Please Sign Up</a>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 pdleft text-right">
							<a title="Forgot Password" href="<?php echo site_url();?>home/forgotPassword">Forgot Password</a>
						</div>
						
						</form>
					</div>
				</div>
					<div class="footerlogo">
				<div class="logoCentre">
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle front" alt="Iccr"/></a>
						<a title="External site that open in new window" target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle back" alt="Iccr"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle front" alt="Ministry-of-External-Affairs"/></a>
						<a title="External site that open in new window" target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle back" alt="Ministry-of-External-Affairs"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" class="img-circle front" alt="I day of yoga"/></a>							
						<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png"  class="img-circle back" alt="I day of yoga"/></a>
					</div>
					
					
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle back" /></a>
					</div>
					
									
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle front" alt="Incredible India"/></a>
						<a title="External site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle back" alt="Incredible India"/></a>
					</div>
				</div>
				</div>
			<?php	
			}	
			else
			{
				
			?>
				<div class="footerlogo">
				<div class="logoCentre">
				<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="external site that open in new window" target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle front" alt="Iccr"/></a>
						<a title="external site that open in new window" target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle back" alt="Iccr"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="external site that open in new window" target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle front" alt="Internship Ministry of External Affairs"/></a>
						<a title="external site that open in new window" target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle back" alt="Internship Ministry of External Affairs"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="external site that open in new window" target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" class="img-circle front" /></a>
						<a title="external site that open in new window" target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="external site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle front" /></a>
						<a title="external site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="external site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" class="img-circle front" alt="I day of yoga"/></a>							
						<a title="external site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png"  class="img-circle back" alt="I day of yoga"/></a>
					</div>
					
					
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="external site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Make in India" class="img-circle front" /></a>
						<a title="external site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Make in India" class="img-circle back" /></a>
					</div>
					
									
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="external site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle front" alt="Incredible India"/></a>
						<a title="external site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle back" alt="Incredible India"/></a>
					</div>
				</div>
				</div>
			<?php	
			}		
			?>
				
			
			</section>		

		
		
		<?php $_SESSION['salt'] = $salt;?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/site/main/js/sha.js"></script>
<script src="<?php echo base_url(); ?>assets/site/main/js/jquery.marquee.min.js"></script>
<script>
	$( '.marquee' ).marquee( {
		//speed in milliseconds of the marquee
		duration: 20000,
		//gap in pixels between the tickers
		gap: 150,
		//time in milliseconds before the marquee will start animating
		delayBeforeStart: 0,
		//'left' or 'right'
		direction: 'left',
		//true or false - should the marquee be duplicated to show an effect of continues flow
		duplicated: false,
		pauseOnHover: true,
	} );
	//# sourceURL=pen.js
</script>
<script type="text/javascript">
                            var salt = '<?php echo $salt ?>';
                            var exp = /((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,15})/;
							
function getPass()
{
    
	var password = $('#pass').val();
	var secret = $('#pass').val();
	var shaObj = new jsSHA("SHA-1", "TEXT");
    shaObj.update(secret); 
   	
    var hashPass = shaObj.getHash("HEX");
	
	var shaObj1 = new jsSHA("SHA-1", "TEXT");
     shaObj1.update(hashPass+salt);   
	
     var hashSalt = shaObj1.getHash("HEX");
	if(password !=""){
	$('#pass').val(hashSalt);
	}	
	
	
}

</script>
	