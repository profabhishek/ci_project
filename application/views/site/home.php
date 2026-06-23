<span id="meacontent" class="meacontent"></span>
<script src="<?php echo base_url();?>assets/site/main/js/jquery.vticker-min.js"></script>
<section class="bannerarea">


<div class="col-XS-12 col-sm-1 col-md-1 col-lg-1 newscontainer">
</div>

<div class="col-12 col-sm-10 col-md-10 col-lg-10">
		
	<div class="banner">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img class="first-slide" src="<?php echo base_url();?>assets/site/main/images/banner/ICCR.jpeg" alt="ICCR  Banner" />
				</div>
                <div class="item">
					<img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/IMG_4075.JPG.jpeg" alt="ICCR Banner" />
				</div>
				<div class="item">
					<img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/IMG_9368.JPG.jpeg" alt="ICCR Banner" />
				</div>

				<div class="item">
					<img class="first-slide" src="<?php echo base_url();?>assets/site/main/images/banner/Summer_2.jpg" alt="ICCR  Banner" />
				</div>
				<div class="item ">
					<img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/Summer_9.jpg" alt="ICCR  Banner" />
				</div>
				<div class="item ">
					<img class="first-slide" src="<?php echo base_url();?>assets/site/main/images/banner/Summer_3.jpg" alt="ICCR  Banner" />
				</div>
				<div class="item ">
					<img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/Summer_6.jpg" alt="ICCR  Banner" />
				</div>
				<div class="item ">
					<img class="first-slide" src="<?php echo base_url();?>assets/site/main/images/banner/Summer_8.jpeg" alt="ICCR  Banner" />
				</div>
					<!----<div class="item">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner2.jpg" alt="ICCR Banner" />
					</div>---->
					<!----<div class="item ">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner1.jpg" alt="ICCR  Banner" />
					</div>
					<div class="item">
					  <img class="second-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner4.jpg" alt="ICCR  Banner" />
					</div>---->
					<!---<div class="item">
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
					</div>---->
					
				
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
	</div>

	<div class="col-XS-12 col-sm-1 col-md-1 col-lg-1 newscontainer">
	</div>

	
		</section>
		
		<script>
		$(function(){
			$('.news-container').vTicker({ 
				speed: 500,
				pause: 3000,
				animation: 'fade',
				mousePause: false,
				showItems: 6
			});
				$('.news-container1').vTicker({
				speed: 700,
				pause: 4000,
				animation: 'fade',
				mousePause: false,
				showItems: 6
			});
		});
	</script>


		
		
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
	
		<!-- <li style="font-size: 14px;">
			<img src="<?php echo base_url();?>assets/site/main/images/newnotification.gif" alt="Image" ><a href="<?php echo site_url('home/newnotification');?>">Stipend/ Joining Report of students who joined in Academic Year 2023-24.</a>
		</li> -->

	<?php 
		
		foreach($notifications as $notval){?>
		
		 <li style="font-size: 14px;">
		<img src="<?php echo base_url();?>assets/site/main/images/newnotification.gif" alt="new gif Image" ><a href="<?php echo site_url('home/notificationList/'.$notval['id']);?>"><?php echo $notval['title']?></a>
		</li>
		<?php  
		}
		?>
		
	</ul>

	
</div>
<?php }  ?>	
<!-- <button class="form-control sbmt allnotification" onclick="location.href='<?php echo site_url();?>home/getAllActiveNotification/'">View All Notifications</button> -->
<!-- <marquee style="color: #fff!important; font-weight: normal; padding: 0px!important; font-size:14px; height: auto;">In case of any issue while applying for ICCR scholarship, please contact Mr. Manoj Saini (email: saini.manoj@velocis.co.in) and Mr. Arvind Srivastav (email: ccd2.iccr@gov.in).</marquee> -->
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
			<div class="httext text-left loginhead" style="background:#F18F2E;color:#fff;text-align:center;">ICCR SCHOLARSHIP PORTAL LOGIN</div>
				<div class="col-xs-12 col-sm-6 col-md-12 pdleft pdright">
					<div class="loginarea" style="width:50%;margin:0 auto; padding: 27px;" id="myLogin">
						<form action="<?php echo site_url();?>user/login" enctype="multipart/form-data" method="post">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						
						<div class="form-group">
							<label>Login ID</label>
							<div class="input-rig">
							<input type="text" required name="username" id="username" class="form-control" Placeholder="Email Id" maxlength="50" />
							</div>
						</div>
						<div class="form-group">
							<label>Password</label>
							<div class="input-rig">
							<input type="password" name="pass" id="pass" required class="form-control" Placeholder="Password" maxlength="50" />
							</div>
						</div>
						<div class="form-group options">
							<label>Are you an applicant?</label>
							<div class="input-rig">
							<label class="radio-inline"><input type="radio" id = "app_r" name="optradio" value = "1" style="margin:10px 0 0 -20px" >Yes</label>
							<label class="radio-inline"><input type="radio" style="margin:10px 0 0 -20px" value = "2" name="optradio" checked>No</label>
							</div>
						</div>
						<div id = "app_div" style="display:none">
						<div class="form-group">
							<label>Apply For</label>
							<div class="input-rig">
							<select id="courses_types" name="courses_types" class="form-control">
							<option value="">Select</option>
							<option value="1">UG(Ayush Scholarship)</option>
							<option value="2">PG(Ayush Scholarship)</option>
							<option value="4">PhD</option>
							<option value="8">PhD(Ayush Scholarship)</option>
							<!--<option value="10">Ayush Scholarship Scheme (UG/PG/PHD)</option>-->
							<option value="12">Diploma (only for Languages and Performing Arts) </option>
							<option value="13">Certificate (only for Languages and Performing Arts) </option>
							<!----<option value="2017">2017-2018</option>
							<option value="2018">2018-2019</option>--->
							<!-----<option value="2019">2019-2020</option>----->
							<!-- <option value="2">UG(Under all Scholarship Schemes for ICCR)</option>
							<option value="1">PG(Under all Scholarship Schemes for ICCR)</option>
							<option value="1">Ph.D(Under all Scholarship Schemes for ICCR)</option>
							<option value = "1">M.Phil(Under all Scholarship Schemes for ICCR)</option>
							<option value = "1">Dance and Music(with Gurus)</option> -->
							<!-----<option value = "1">Music (with Guru's)</option>--->
							<!-- <option value = "1">Cetificate Course</option> -->
							<!----<option value="2">Ayush Scholarship Scheme(UG/PG/PHD in Ayuerveda,Yoga,Unani,Siddha and Homoeopathy)</option>
							<option value="2">SFS(Self Finance Student) Under Ayush Scholarship Scheme</option>--->
							</select>
							</div>
						</div>
						<div class="form-group">
							<label>Registration Year</label>
							<div class="input-rig">
							<select id="year" name="year" class="form-control">
							<option value="">Select</option>
							<!----<option value="2017">2017-2018</option>
							<option value="2018">2018-2019</option>--->
							<!-----<option value="2019">2019-2020</option>----->
							<!-----<option value="2020">2020-2021</option>---->
							<!-- <option value="2021">2021-22</option>
							<option value="2022">2022-23</option>
							<option value="2023">2023-24</option> -->
							<!-- <option value="2024">2024-25</option> -->
							<option value="2026">2026-27</option>
							</select>
							</div>
						</div>
						</div>
						<div class="form-group">
						   <label>Captcha</label>
						   <div class="captcha input-rig">
							 <!-- <img alt="captcha" src="<?php echo $captcha['image_src']; ?>"/> -->
							 <img id="captid" alt="captcha"  src="<?php echo $captcha['image_src']; ?>"/>
                             <a href="javascript:void(0);" id="refreshImg" class="reload-captcha">&nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></a>
							 <input type="text" required id="captchatext" name="captchatext"  class="form-control" maxlength="7" />
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
							<a title="Sign Up" href="<?php echo site_url();?>home/register" onclick ="reg()";>Don't have account? Please Sign Up here.</a>
							<!-------<a title="Sign Up" href="#" onclick ="reg()";>Don't have account? Please Sign Up here.</a>---->
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 pdleft text-right">
							<a title="Forgot Password" href="<?php echo site_url();?>home/forgotPassword">Forgot Password</a>
						</div>
						
						</form>
					</div>
				</div>
					<div class="footerlogo text-center">
				<div class="logoCentre">
					<div class="goals card">
						<a title="External site that open in new window" target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle front" alt="Iccr"/></a>
						<a title="External site that open in new window" target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle back" alt="Iccr"/></a>
					</div>
					<div class="goals card">
						<a title="External site that open in new window" target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle front" alt="Ministry-of-External-Affairs"/></a>
						<a title="External site that open in new window" target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle back" alt="Ministry-of-External-Affairs"/></a>
					</div>
					<div class="goals card">
						<a title="External site that open in new window" target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" class="img-circle back" /></a>
					</div>
					<div class="goals card">
						<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle back" /></a>
					</div>
					<div class="goals card">
						<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" class="img-circle front" alt="I day of yoga"/></a>							
						<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png"  class="img-circle back" alt="I day of yoga"/></a>
					</div>
					
					
					<div class="goals card">
						<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle back" /></a>
					</div>
					
									
					<div class="goals card">
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

$('#refreshImg').click(function() {
        refreshCapt();
    })


    function refreshCapt() {
        $.ajax({
            url: baseURL + 'home/refreshCaptcha',
            dataType: "html",
            success: function(data) {
                $('#captid').attr('src', data);
            }
        });
    }

//  function reg(){
// 	bootbox.alert("Registration for A.Y 2022-23 closed.", function(){ 
//     console.log('This was logged in the callback!'); 
// });
		
// 		}

</script>
	