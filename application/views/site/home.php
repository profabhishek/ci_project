<?php if (!function_exists('a2a_t')) { $this->load->helper('a2a_i18n'); } ?>
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


		
		
<section class="meacontent a2a-home" style="margin:0;padding-top:0;">
	<?php $todate = date('Y-m-d'); ?>
	<?php $notifications = $this->common_model->getActiveNotification($todate); ?>

	<!-- Announcements -->
	<div class="a2a-announce" role="region" aria-label="<?php echo a2a_e('a2a_announcements'); ?>">
		<div class="a2a-wrap">
			<span class="a2a-announce__label"><span class="a2a-dot" aria-hidden="true"></span><span class="a2a-label-text"><?php echo a2a_e('a2a_announcements'); ?></span></span>
			<div class="a2a-announce__track marqWrap">
				<?php if(!empty($notifications)){ ?>
				<div class="lower-menu marquee">
					<ul>
						<?php foreach($notifications as $notval){
							// Hidden from the admin panel (status 0) -> not shown on the home page
							if (isset($notval['status']) && (string)$notval['status'] === '0') { continue; } ?>
						<li><a href="<?php echo site_url('home/notificationList/'.$notval['id']);?>"><?php echo $notval['title']?></a></li>
						<?php } ?>
					</ul>
				</div>
				<?php } else { ?>
				<span class="a2a-announce__welcome"><?php echo a2a_e('a2a_welcome'); ?></span>
				<?php } ?>
			</div>
		</div>
	</div>

	<?php if($this->session->flashdata('message_type') == "success") { ?>
	<div class="a2a-alert a2a-alert--success" role="status">
		<i class="fa fa-check-circle" aria-hidden="true"></i>
		<div><strong>Success.</strong> <?php echo $this->session->flashdata('success');?></div>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<?php } ?>
	<?php if($this->session->flashdata('message_type') == "error") { ?>
	<div class="a2a-alert a2a-alert--error" role="alert">
		<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
		<div><strong>Could not sign in.</strong> <?php echo $this->session->flashdata('error');?></div>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<?php } ?>

	<?php
	$user = $this->session->userdata('user_data');
	if($user == '' || $user['user_type'] < 1)
	{
		$ldocs = site_url().'assets/site/docs/';
	?>
	<div class="a2a-login" id="myLogin">

		<!-- Left: welcome panel -->
		<aside class="a2a-login__aside">
			<span class="a2a-eyebrow"><i class="fa fa-university" aria-hidden="true"></i> <?php echo a2a_e('a2a_eyebrow'); ?></span>
			<h1><?php echo a2a_t('a2a_hero_title'); ?></h1>
			<p><?php echo a2a_e('a2a_hero_text'); ?></p>
			<ul class="a2a-steps">
				<li><span class="a2a-step-ico"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span><span><strong><?php echo a2a_e('a2a_j1_t'); ?></strong><?php echo a2a_e('a2a_j1_d'); ?></span></li>
				<li><span class="a2a-step-ico"><i class="fa fa-search" aria-hidden="true"></i></span><span><strong><?php echo a2a_e('a2a_track'); ?></strong><?php echo a2a_e('a2a_track_d'); ?></span></li>
				<li><span class="a2a-step-ico"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span><span><strong><?php echo a2a_e('a2a_j4_t'); ?></strong><?php echo a2a_e('a2a_j4_d'); ?></span></li>
			</ul>
			<div class="a2a-quicklinks">
				<a href="<?php echo $ldocs;?>Policy_Guidelines.pdf" target="_blank" rel="noopener"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo a2a_e('a2a_guidelines'); ?></a>
				<a href="<?php echo $ldocs;?>Timeline-AY-2026-27.pdf" target="_blank" rel="noopener"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo a2a_e('a2a_q_timeline'); ?></a>
				<a href="<?php echo site_url();?>home/contactus"><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo a2a_e('a2a_help'); ?></a>
			</div>
		</aside>

		<!-- Right: sign-in form (field names and ids unchanged; used by custom.js and User::login) -->
		<div class="a2a-login__form">
			<h2><?php echo a2a_e('a2a_signin'); ?></h2>
			<p class="a2a-sub"><?php echo a2a_e('a2a_signin_sub'); ?></p>

			<form action="<?php echo site_url();?>user/login" enctype="multipart/form-data" method="post" id="a2aLoginForm">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

				<div class="a2a-field">
					<label for="username"><?php echo a2a_e('a2a_email_id'); ?></label>
					<div class="a2a-control">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
						<input type="email" required name="username" id="username" class="form-control a2a-input" placeholder="name@example.com" maxlength="50" autocomplete="username" inputmode="email" />
					</div>
				</div>

				<div class="a2a-field">
					<label for="pass"><?php echo a2a_e('a2a_password'); ?></label>
					<div class="a2a-control">
						<i class="fa fa-lock" aria-hidden="true"></i>
						<input type="password" name="pass" id="pass" required class="form-control a2a-input a2a-input--pw" placeholder="<?php echo a2a_e('a2a_pw_ph'); ?>" maxlength="50" autocomplete="current-password" />
						<button type="button" class="a2a-reveal" id="a2aReveal" aria-controls="pass" aria-pressed="false" data-show="<?php echo a2a_e('a2a_show'); ?>" data-hide="<?php echo a2a_e('a2a_hide'); ?>"><?php echo a2a_e('a2a_show'); ?></button>
					</div>
				</div>

				<div class="a2a-field options">
					<span class="a2a-label" id="a2aApplicantLabel"><?php echo a2a_e('a2a_are_applicant'); ?></span>
					<div class="a2a-segment" role="radiogroup" aria-labelledby="a2aApplicantLabel">
						<input type="radio" id="app_r" name="optradio" value="1">
						<label for="app_r"><?php echo a2a_e('a2a_yes'); ?></label>
						<input type="radio" id="app_no" name="optradio" value="2" checked>
						<label for="app_no"><?php echo a2a_e('a2a_no'); ?></label>
					</div>
					<span class="a2a-hint"><?php echo a2a_e('a2a_applicant_hint'); ?></span>
				</div>

				<div id="app_div" style="display:none">
					<div class="a2a-applicant">
						<div class="a2a-field">
							<label for="courses_types"><?php echo a2a_e('a2a_apply_for'); ?></label>
							<select id="courses_types" name="courses_types" class="form-control a2a-input">
								<option value=""><?php echo a2a_e('a2a_select'); ?></option>
								<option value="1">UG(Ayush Scholarship)</option>
								<option value="2">PG(Ayush Scholarship)</option>
								<option value="4">PhD</option>
								<option value="8">PhD(Ayush Scholarship)</option>
								<option value="12">Diploma (only for Languages and Performing Arts) </option>
								<option value="13">Certificate (only for Languages and Performing Arts) </option>
							</select>
						</div>
						<div class="a2a-field">
							<label for="year"><?php echo a2a_e('a2a_reg_year'); ?></label>
							<select id="year" name="year" class="form-control a2a-input">
								<option value=""><?php echo a2a_e('a2a_select'); ?></option>
								<option value="2026">2026-27</option>
							</select>
						</div>
					</div>
				</div>

				<div class="a2a-field">
					<label for="captchatext"><?php echo a2a_e('a2a_captcha'); ?></label>
					<div class="a2a-captcha">
						<img id="captid" alt="Captcha: characters to type in the next box" width="150" height="50" src="<?php echo $captcha['image_src']; ?>"/>
						<button type="button" id="refreshImg" class="a2a-iconbtn reload-captcha" title="<?php echo a2a_e('a2a_captcha_new'); ?>" aria-label="<?php echo a2a_e('a2a_captcha_new'); ?>"><i class="fa fa-refresh" aria-hidden="true"></i></button>
						<input type="text" required id="captchatext" name="captchatext" class="form-control a2a-input" maxlength="7" autocomplete="off" autocapitalize="off" spellcheck="false" placeholder="Captcha" aria-describedby="a2aCaptHelp" />
					</div>
					<span class="a2a-hint" id="a2aCaptHelp"><?php echo a2a_e('a2a_captcha_help'); ?></span>
				</div>

				<div class="a2a-form-actions">
					<button type="submit" class="a2a-submit"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp; <?php echo a2a_e('a2a_signin'); ?></button>
					<button type="button" class="a2a-reset" onclick="refresh_login();"><?php echo a2a_e('a2a_reset'); ?></button>
				</div>

				<div class="a2a-login__links">
					<span class="a2a-login__new"><?php echo a2a_e('a2a_new_here'); ?></span>
					<a class="a2a-btnlink a2a-btnlink--primary" href="<?php echo site_url();?>home/register"><i class="fa fa-user-plus" aria-hidden="true"></i> <?php echo a2a_e('a2a_create_account'); ?></a>
					<a class="a2a-btnlink" href="<?php echo site_url();?>home/forgotPassword"><i class="fa fa-key" aria-hidden="true"></i> <?php echo a2a_e('a2a_forgot'); ?></a>
				</div>
				<div class="a2a-secure"><i class="fa fa-shield" aria-hidden="true"></i> <?php echo a2a_e('a2a_secure'); ?></div>
			</form>
		</div>
	</div>
	<?php $this->load->view('site/home_public'); ?>
	<?php } ?>
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
        var $b = $(this).addClass('is-spinning');
        setTimeout(function(){ $b.removeClass('is-spinning'); }, 650);
        refreshCapt();
    })

// Hash the password only when the form is really being submitted
// (after the browser's required-field checks pass). Previously this ran on
// the button click, so a failed check left the hash in the box and a second
// click hashed it again.
$('#a2aLoginForm').on('submit', function() {
    $('#pass').attr('type', 'password');
    $('#a2aReveal').text($('#a2aReveal').data('show')).attr('aria-pressed', 'false');
    getPass();
});

// Show / hide password
$('#a2aReveal').on('click', function() {
    var $p = $('#pass');
    var show = $p.attr('type') === 'password';
    $p.attr('type', show ? 'text' : 'password');
    $(this).text(show ? $(this).data('hide') : $(this).data('show')).attr('aria-pressed', show ? 'true' : 'false');
    $p.trigger('focus');
});


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
	