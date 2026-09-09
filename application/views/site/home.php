<span id="meacontent" class="meacontent"></span>
<script src="<?php echo base_url();?>assets/site/main/js/jquery.vticker-min.js"></script>
<style>
.home-hero-slider {
	position: relative;
	width: 100%;
	height: 480px;
	overflow: hidden;
	background: #111;
}
.hero-slide {
	position: absolute;
	inset: 0;
	opacity: 0;
	transition: opacity 0.8s ease;
}
.hero-slide.active { opacity: 1; z-index: 2; }
.hero-bg {
	position: absolute;
	inset: 0;
	background-size: cover;
	background-position: center;
	filter: blur(25px) brightness(0.6);
	transform: scale(1.15);
}
.hero-slide img {
	width: 100%;
	height: 100%;
	object-fit: contain;
	position: absolute;
	inset: 0;
	margin: auto;
	z-index: 2;
	border-radius: 6px;
}
.hero-slide::after {
	content: "";
	position: absolute;
	left: 0; right: 0; bottom: 0;
	height: 42%;
	z-index: 2;
	pointer-events: none;
	background: linear-gradient(to top,
		rgba(0,0,0,0.72) 0%,
		rgba(0,0,0,0.45) 38%,
		rgba(0,0,0,0.18) 68%,
		rgba(0,0,0,0) 100%);
}
.hero-slide-content {
	position: absolute;
	left: 20px;
	bottom: 25px;
	z-index: 3;
	max-width: 80%;
	color: #fff;
}
.hero-slide-content h2 {
	font-size: 20px !important;
	line-height: 1.3;
	margin-bottom: 6px;
	color: #fff !important;
	font-family: 'Open Sans', sans-serif;
	font-weight: 400;
}
.hero-slide-content p {
	font-size: 14px !important;
	color: #fff !important;
	font-family: 'Open Sans', sans-serif;
	margin: 0;
}
.hero-slide-content h2:empty,
.hero-slide-content p:empty { display: none; }
.hero-nav {
	position: absolute;
	bottom: 18px;
	z-index: 5;
	width: 42px;
	height: 42px;
	border: none;
	border-radius: 50%;
	background: rgba(255,255,255,0.18);
	color: #fff;
	cursor: pointer;
	font-size: 20px;
	backdrop-filter: blur(10px);
}
.hero-prev { right: 110px; }
.hero-next { right: 10px; }
.hero-slide-controls {
	position: absolute;
	right: 60px;
	bottom: 18px;
	z-index: 5;
}
.hero-pause {
	width: 42px;
	height: 42px;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	background: rgba(255,255,255,0.18);
	color: #fff;
	cursor: pointer;
	backdrop-filter: blur(10px);
}
@media (max-width: 900px) {
	.home-hero-slider { height: 300px; }
	.hero-slide-content h2 { font-size: 12px !important; line-height: 1.2; }
	.hero-nav, .hero-slide-controls { bottom: 8px; }
}
</style>
<?php if (false): ?>
<section class="bannerarea" style="background:#111;padding:0;">

<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">

	<div class="banner" style="margin:0;">
		<section class="home-hero-slider">
			<?php
			// Same photos as before, now served in compressed form (see
			// assets/site/main/images/banner/hero_optimized/) so the homepage
			// loads much faster: the two largest originals were 4MB+ each.
			// Title/date are left blank for now; fill them in here whenever
			// they're ready and they'll display automatically (blank ones
			// stay hidden).
			$heroSlides = array(
				array('img' => 'ICCR.jpg',         'bg' => 'ICCR_bg.jpg',         'title' => '', 'date' => ''),
				array('img' => 'IMG_4075.JPG.jpg', 'bg' => 'IMG_4075.JPG_bg.jpg', 'title' => '', 'date' => ''),
				array('img' => 'IMG_9368.JPG.jpg', 'bg' => 'IMG_9368.JPG_bg.jpg', 'title' => '', 'date' => ''),
				array('img' => 'Summer_2.jpg',     'bg' => 'Summer_2_bg.jpg',     'title' => '', 'date' => ''),
				array('img' => 'Summer_9.jpg',     'bg' => 'Summer_9_bg.jpg',     'title' => '', 'date' => ''),
				array('img' => 'Summer_3.jpg',     'bg' => 'Summer_3_bg.jpg',     'title' => '', 'date' => ''),
				array('img' => 'Summer_6.jpg',     'bg' => 'Summer_6_bg.jpg',     'title' => '', 'date' => ''),
				array('img' => 'Summer_8.jpg',     'bg' => 'Summer_8_bg.jpg',     'title' => '', 'date' => ''),
			);
			$heroBase = base_url() . 'assets/site/main/images/banner/hero_optimized/';
			foreach ($heroSlides as $i => $hs):
				$imgUrl = $heroBase . $hs['img'];
				$bgUrl  = $heroBase . $hs['bg'];
				$isFirst = ($i === 0);
			?>
			<div class="hero-slide<?php echo $isFirst ? ' active' : ''; ?>">
				<div class="hero-bg" <?php echo $isFirst ? 'style="background-image:url(\''.$bgUrl.'\')"' : 'data-bg="'.$bgUrl.'"'; ?>></div>
				<img src="<?php echo $imgUrl; ?>" alt="ICCR Banner"
					<?php echo $isFirst ? 'loading="eager" fetchpriority="high"' : 'loading="lazy"'; ?>
					decoding="async">
				<div class="hero-slide-content">
					<h2><?php echo $hs['title']; ?></h2>
					<p><?php echo !empty($hs['date']) ? '&#128197; '.$hs['date'] : ''; ?></p>
				</div>
			</div>
			<?php endforeach; ?>
			<button class="hero-nav hero-prev" type="button" aria-label="Previous slide">&#10094;</button>
			<button class="hero-nav hero-next" type="button" aria-label="Next slide">&#10095;</button>
			<div class="hero-slide-controls">
				<span class="hero-pause">&#10074;&#10074;</span>
			</div>
		</section>
	</div>

</div>


		</section>

<script>
(function() {
	var heroSlides = document.querySelectorAll('.home-hero-slider .hero-slide');
	var heroNext   = document.querySelector('.home-hero-slider .hero-next');
	var heroPrev   = document.querySelector('.home-hero-slider .hero-prev');
	var heroPause  = document.querySelector('.home-hero-slider .hero-pause');
	if (!heroSlides.length) { return; }

	var heroIndex = 0;
	var isPlaying = true;

	// Blurred backgrounds are only attached to the DOM lazily, right before
	// a slide is shown, so the browser doesn't fetch all 8 on page load.
	function loadHeroBg(slide) {
		var bg = slide.querySelector('.hero-bg');
		if (bg && bg.dataset.bg) {
			bg.style.backgroundImage = "url('" + bg.dataset.bg + "')";
			bg.removeAttribute('data-bg');
		}
	}
	function showHeroSlide(index) {
		heroSlides.forEach(function(slide) { slide.classList.remove('active'); });
		heroSlides[index].classList.add('active');
		loadHeroBg(heroSlides[index]);
		var nextSlide = heroSlides[(index + 1) % heroSlides.length];
		loadHeroBg(nextSlide);
	}
	function nextHeroSlide() {
		heroIndex = (heroIndex + 1) % heroSlides.length;
		showHeroSlide(heroIndex);
	}
	function prevHeroSlide() {
		heroIndex = (heroIndex - 1 + heroSlides.length) % heroSlides.length;
		showHeroSlide(heroIndex);
	}

	var heroAuto = setInterval(function() {
		if (isPlaying) { nextHeroSlide(); }
	}, 5000);

	if (heroNext) { heroNext.addEventListener('click', nextHeroSlide); }
	if (heroPrev) { heroPrev.addEventListener('click', prevHeroSlide); }
	if (heroPause) {
		heroPause.addEventListener('click', function() {
			isPlaying = !isPlaying;
			heroPause.innerHTML = isPlaying ? '&#10074;&#10074;' : '&#9654;';
		});
	}
})();
</script>
<?php endif; ?>
		
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
					</div>
			<?php	
			}	
			else
			{
				
			?>
				<div class="footerlogo">
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

</script>
	