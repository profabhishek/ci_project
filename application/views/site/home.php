<script src="<?php echo base_url();?>assets/site/main/js/jquery.vticker-min.js"></script>
<script src="<?php echo base_url(); ?>assets/site/main/js/jquery.marquee.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/site/main/js/sha.js"></script>

<style>
/* ─── RESET & BASE ─────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: #f4f6fb; }

/* ─── HERO CAROUSEL ────────────────────────────────── */
.hero-section {
    position: relative;
    width: 100%;
    height: 520px;
    overflow: hidden;
}

.hero-section .carousel,
.hero-section .carousel-inner,
.hero-section .item {
    height: 100%;
}

.hero-section .item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.72);
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(13,27,62,0.72) 0%, rgba(26,58,125,0.45) 60%, transparent 100%);
    z-index: 2;
    pointer-events: none;
}

.hero-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 3;
    text-align: center;
    width: 90%;
    max-width: 720px;
}

.hero-text .badge-pill {
    display: inline-block;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.35);
    color: #fff;
    font-size: 12px;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 5px 18px;
    border-radius: 50px;
    margin-bottom: 16px;
    backdrop-filter: blur(6px);
}

.hero-text h1 {
    color: #fff;
    font-size: clamp(24px, 4vw, 46px);
    font-weight: 800;
    line-height: 1.15;
    text-shadow: 0 2px 20px rgba(0,0,0,0.4);
    margin-bottom: 12px;
}

.hero-text p {
    color: rgba(255,255,255,0.88);
    font-size: 16px;
    font-weight: 400;
}

.hero-section .carousel-control {
    z-index: 4;
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.35);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 1;
    backdrop-filter: blur(6px);
    display: flex !important;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}
.hero-section .carousel-control:hover { background: rgba(255,255,255,0.35); }
.hero-section .left.carousel-control  { left: 20px; }
.hero-section .right.carousel-control { right: 20px; }

/* ─── NOTIFICATION TICKER ──────────────────────────── */
.notif-bar {
    background: linear-gradient(90deg, #0d1b3e 0%, #1a3a7d 100%);
    padding: 0 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    height: 44px;
    overflow: hidden;
    position: relative;
    z-index: 10;
}

.notif-label {
    background: #f59e0b;
    color: #1a1a1a;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 4px;
    white-space: nowrap;
    flex-shrink: 0;
}

.notif-bar .marquee-wrapper {
    flex: 1;
    overflow: hidden;
}

.notif-bar .marquee {
    white-space: nowrap;
    display: inline-block;
}

.notif-bar .marquee li {
    display: inline-block;
    margin-right: 60px;
    list-style: none;
}

.notif-bar .marquee li img {
    width: 16px;
    margin-right: 4px;
    vertical-align: middle;
}

.notif-bar .marquee li a {
    color: rgba(255,255,255,0.92);
    font-size: 13px;
    text-decoration: none;
    transition: color 0.2s;
}
.notif-bar .marquee li a:hover { color: #f59e0b; }

/* ─── MAIN CONTENT AREA ────────────────────────────── */
.main-content {
    max-width: 1200px;
    margin: 48px auto;
    padding: 0 20px;
}

/* ─── ALERTS ───────────────────────────────────────── */
.modern-alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-radius: 10px;
    margin-bottom: 24px;
    font-size: 14px;
    font-weight: 500;
}
.modern-alert.success { background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; }
.modern-alert.error   { background: #fef2f2; border-left: 4px solid #ef4444; color: #7f1d1d; }
.modern-alert .close-btn { margin-left: auto; cursor: pointer; font-size: 18px; opacity: 0.6; }
.modern-alert .close-btn:hover { opacity: 1; }

/* ─── TWO-COLUMN LAYOUT ────────────────────────────── */
.home-grid {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 36px;
    align-items: start;
}

@media (max-width: 900px) {
    .home-grid { grid-template-columns: 1fr; }
}

/* ─── INFO PANEL (left) ────────────────────────────── */
.info-panel {}

.info-panel h2 {
    font-size: 26px;
    font-weight: 800;
    color: #0d1b3e;
    margin-bottom: 8px;
}

.info-panel p {
    color: #64748b;
    font-size: 15px;
    line-height: 1.7;
    margin-bottom: 28px;
}

.stat-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}

.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 18px;
    text-align: center;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    border: 1px solid #e8edf5;
    transition: transform 0.2s, box-shadow 0.2s;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(13,27,62,0.1); }

.stat-card .icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    font-size: 22px;
}
.stat-card:nth-child(1) .icon { background: #ede9fe; color: #7c3aed; }
.stat-card:nth-child(2) .icon { background: #dbeafe; color: #1d4ed8; }
.stat-card:nth-child(3) .icon { background: #dcfce7; color: #15803d; }

.stat-card .num  { font-size: 28px; font-weight: 800; color: #0d1b3e; line-height: 1; }
.stat-card .lbl  { font-size: 12px; color: #94a3b8; margin-top: 4px; font-weight: 500; }

/* Partner logos */
.partners-section { margin-top: 8px; }
.partners-section h3 { font-size: 13px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; }

.partners-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}

.partner-logo {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: box-shadow 0.2s, transform 0.2s;
    text-decoration: none;
}
.partner-logo:hover { box-shadow: 0 4px 14px rgba(13,27,62,0.12); transform: translateY(-2px); }
.partner-logo img { height: 44px; width: auto; object-fit: contain; }

/* ─── LOGIN CARD (right) ───────────────────────────── */
.login-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 32px rgba(13,27,62,0.1);
    overflow: hidden;
    border: 1px solid #e8edf5;
}

.login-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a3a7d 100%);
    padding: 28px 32px;
    position: relative;
    overflow: hidden;
}

.login-card-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.login-card-header::after {
    content: '';
    position: absolute;
    bottom: -30px; left: -20px;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}

.login-card-header h3 {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    position: relative;
    z-index: 1;
    margin-bottom: 4px;
}
.login-card-header p {
    color: rgba(255,255,255,0.65);
    font-size: 13px;
    position: relative;
    z-index: 1;
}

.login-card-body { padding: 28px 32px; }

/* Form fields */
.field-group { margin-bottom: 18px; }

.field-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 7px;
}

.field-group input[type="text"],
.field-group input[type="password"],
.field-group select {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    color: #0f172a;
    background: #f8fafc;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    appearance: none;
    -webkit-appearance: none;
}
.field-group input:focus,
.field-group select:focus {
    border-color: #1a3a7d;
    box-shadow: 0 0 0 3px rgba(26,58,125,0.1);
    background: #fff;
}

/* Radio toggle */
.radio-toggle {
    display: flex;
    gap: 0;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    background: #f8fafc;
}

.radio-toggle label {
    flex: 1;
    text-align: center;
    padding: 10px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    color: #64748b;
    text-transform: none;
    letter-spacing: 0;
    margin: 0;
    transition: background 0.2s, color 0.2s;
    border-radius: 0;
}

.radio-toggle input[type="radio"] { display: none; }
.radio-toggle input[type="radio"]:checked + label {
    background: #0d1b3e;
    color: #fff;
}

/* Captcha row */
.captcha-row {
    display: flex;
    align-items: center;
    gap: 10px;
}
.captcha-row img { height: 42px; border-radius: 8px; border: 1px solid #e2e8f0; }
.captcha-row .refresh-btn {
    background: none;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #64748b;
    transition: background 0.2s, color 0.2s;
    flex-shrink: 0;
}
.captcha-row .refresh-btn:hover { background: #f1f5f9; color: #0d1b3e; }
.captcha-row input { flex: 1; }

/* Submit button */
.btn-login {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a3a7d 100%);
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.15s;
    margin-bottom: 12px;
}
.btn-login:hover { opacity: 0.92; transform: translateY(-1px); }

.btn-reset {
    width: 100%;
    padding: 11px;
    background: #f1f5f9;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.2s;
    margin-bottom: 18px;
}
.btn-reset:hover { background: #e2e8f0; }

.login-links {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
}
.login-links a { color: #1a3a7d; text-decoration: none; font-weight: 500; }
.login-links a:hover { text-decoration: underline; }

/* Collapsible applicant fields */
#app_div_modern { display: none; }
#app_div_modern.visible { display: block; }

/* ─── LOGGED IN PARTNER BAR ─────────────────────────── */
.loggedout-partners { margin-top: 36px; }
</style>

<!-- ══════════════════════════════════════════════════
     HERO CAROUSEL
══════════════════════════════════════════════════ -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-text">
        <div class="badge-pill">&#127470;&#127475; &nbsp;Government of India</div>
        <h1>ICCR Scholarship Portal</h1>
        <p>Indian Council for Cultural Relations &mdash; Empowering Global Scholars</p>
    </div>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="item active"><img src="<?php echo base_url();?>assets/site/main/images/banner/ICCR.jpeg" alt="ICCR Banner" /></div>
            <div class="item"><img src="<?php echo base_url();?>assets/site/main/images/banner/IMG_4075.JPG.jpeg" alt="ICCR Banner" /></div>
            <div class="item"><img src="<?php echo base_url();?>assets/site/main/images/banner/IMG_9368.JPG.jpeg" alt="ICCR Banner" /></div>
            <div class="item"><img src="<?php echo base_url();?>assets/site/main/images/banner/Summer_2.jpg" alt="ICCR Banner" /></div>
            <div class="item"><img src="<?php echo base_url();?>assets/site/main/images/banner/Summer_9.jpg" alt="ICCR Banner" /></div>
            <div class="item"><img src="<?php echo base_url();?>assets/site/main/images/banner/Summer_3.jpg" alt="ICCR Banner" /></div>
            <div class="item"><img src="<?php echo base_url();?>assets/site/main/images/banner/Summer_6.jpg" alt="ICCR Banner" /></div>
            <div class="item"><img src="<?php echo base_url();?>assets/site/main/images/banner/Summer_8.jpeg" alt="ICCR Banner" /></div>
        </div>
        <a class="left carousel-control"  href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        </a>
    </div>
</section>

<!-- ══════════════════════════════════════════════════
     NOTIFICATION TICKER
══════════════════════════════════════════════════ -->
<?php
    $todate        = date('Y-m-d');
    $notifications = $this->common_model->getActiveNotification($todate);
?>
<?php if (!empty($notifications)): ?>
<div class="notif-bar">
    <span class="notif-label">&#128276; Updates</span>
    <div class="marquee-wrapper">
        <div class="lower-menu marquee">
            <ul class="ml-auto" style="margin:0;padding:0;">
                <?php foreach ($notifications as $notval): ?>
                <li>
                    <img src="<?php echo base_url();?>assets/site/main/images/newnotification.gif" alt="" />
                    <a href="<?php echo site_url('home/notificationList/' . $notval['id']); ?>"><?php echo $notval['title']; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════════════ -->
<div class="main-content">

    <!-- Flash messages -->
    <?php if ($this->session->flashdata('message_type') == 'success'): ?>
    <div class="modern-alert success">
        <i class="fa fa-check-circle fa-lg"></i>
        <span><strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?></span>
        <span class="close-btn" onclick="this.closest('.modern-alert').remove()">&times;</span>
    </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('message_type') == 'error'): ?>
    <div class="modern-alert error">
        <i class="fa fa-exclamation-circle fa-lg"></i>
        <span><strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?></span>
        <span class="close-btn" onclick="this.closest('.modern-alert').remove()">&times;</span>
    </div>
    <?php endif; ?>

    <?php
    $user = $this->session->userdata('user_data');
    if ($user == '' || $user['user_type'] < 1):
    ?>

    <!-- ── LOGGED-OUT: two-column layout ── -->
    <div class="home-grid">

        <!-- LEFT: Info + Stats + Partners -->
        <div class="info-panel">
            <h2>Connecting Cultures,<br>Empowering Futures</h2>
            <p>The ICCR Scholarship Portal facilitates international students to apply for prestigious Indian government scholarships — from undergraduate programmes to doctoral research.</p>

            <div class="stat-cards">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-globe"></i></div>
                    <div class="num">150+</div>
                    <div class="lbl">Countries</div>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                    <div class="num">3,500+</div>
                    <div class="lbl">Scholarships</div>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-university"></i></div>
                    <div class="num">200+</div>
                    <div class="lbl">Universities</div>
                </div>
            </div>

            <div class="partners-section">
                <h3>Our Partners</h3>
                <div class="partners-grid">
                    <a class="partner-logo" href="http://www.iccr.gov.in/" target="_blank" title="ICCR">
                        <img src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" alt="ICCR" />
                    </a>
                    <a class="partner-logo" href="http://mea.gov.in/" target="_blank" title="Ministry of External Affairs">
                        <img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" alt="MEA" />
                    </a>
                    <a class="partner-logo" href="http://knowindia.gov.in/" target="_blank" title="Know India">
                        <img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" />
                    </a>
                    <a class="partner-logo" href="https://india.gov.in/" target="_blank" title="India.gov.in">
                        <img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="India Gov" />
                    </a>
                    <a class="partner-logo" href="http://idayofyoga.org/" target="_blank" title="International Day of Yoga">
                        <img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" alt="Yoga Day" />
                    </a>
                    <a class="partner-logo" href="http://www.makeinindia.com/home" target="_blank" title="Make in India">
                        <img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Make in India" />
                    </a>
                    <a class="partner-logo" href="https://incredibleindia.org/" target="_blank" title="Incredible India">
                        <img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" alt="Incredible India" />
                    </a>
                </div>
            </div>
        </div>

        <!-- RIGHT: Login Card -->
        <div class="login-card">
            <div class="login-card-header">
                <h3>Welcome Back</h3>
                <p>Sign in to your ICCR Scholarship account</p>
            </div>
            <div class="login-card-body">
                <form action="<?php echo site_url();?>user/login" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <!-- Are you an applicant? -->
                    <div class="field-group">
                        <label>Account Type</label>
                        <div class="radio-toggle">
                            <input type="radio" id="not_applicant" name="optradio" value="2" checked>
                            <label for="not_applicant">Staff / Admin</label>
                            <input type="radio" id="app_r" name="optradio" value="1">
                            <label for="app_r">Applicant</label>
                        </div>
                    </div>

                    <!-- Applicant-only fields -->
                    <div id="app_div_modern">
                        <div class="field-group">
                            <label>Apply For</label>
                            <select id="courses_types" name="courses_types">
                                <option value="">Select Programme</option>
                                <option value="1">UG (Ayush Scholarship)</option>
                                <option value="2">PG (Ayush Scholarship)</option>
                                <option value="4">PhD</option>
                                <option value="8">PhD (Ayush Scholarship)</option>
                                <option value="12">Diploma (Languages &amp; Performing Arts)</option>
                                <option value="13">Certificate (Languages &amp; Performing Arts)</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label>Registration Year</label>
                            <select id="year" name="year">
                                <option value="">Select Year</option>
                                <option value="2026">2026-27</option>
                            </select>
                        </div>
                    </div>

                    <div class="field-group">
                        <label>Login ID</label>
                        <input type="text" name="username" id="username" placeholder="Enter your email address" maxlength="50" required />
                    </div>

                    <div class="field-group">
                        <label>Password</label>
                        <input type="password" name="pass" id="pass" placeholder="Enter your password" maxlength="50" required />
                    </div>

                    <div class="field-group">
                        <label>Captcha Verification</label>
                        <div class="captcha-row">
                            <img id="captid" src="<?php echo $captcha['image_src']; ?>" alt="captcha" />
                            <button type="button" class="refresh-btn" id="refreshImg" title="Refresh captcha">
                                <i class="fa fa-refresh"></i>
                            </button>
                            <input type="text" name="captchatext" id="captchatext" placeholder="Enter captcha" maxlength="7" required />
                        </div>
                    </div>

                    <button type="submit" class="btn-login" onclick="getPass();">Sign In &nbsp;<i class="fa fa-arrow-right"></i></button>
                    <button type="button" class="btn-reset" onclick="refresh_login();">Reset Form</button>

                    <div class="login-links">
                        <a href="<?php echo site_url();?>home/register" onclick="reg()">Don't have an account? Sign Up</a>
                        <a href="<?php echo site_url();?>home/forgotPassword">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- /.home-grid -->

    <?php else: ?>

    <!-- ── LOGGED-IN: just partners ── -->
    <div class="partners-section loggedout-partners">
        <h3>Our Partners</h3>
        <div class="partners-grid">
            <a class="partner-logo" href="http://www.iccr.gov.in/" target="_blank"><img src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" alt="ICCR" /></a>
            <a class="partner-logo" href="http://mea.gov.in/" target="_blank"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" alt="MEA" /></a>
            <a class="partner-logo" href="http://knowindia.gov.in/" target="_blank"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" /></a>
            <a class="partner-logo" href="https://india.gov.in/" target="_blank"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="India Gov" /></a>
            <a class="partner-logo" href="http://idayofyoga.org/" target="_blank"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" alt="Yoga Day" /></a>
            <a class="partner-logo" href="http://www.makeinindia.com/home" target="_blank"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Make in India" /></a>
            <a class="partner-logo" href="https://incredibleindia.org/" target="_blank"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" alt="Incredible India" /></a>
        </div>
    </div>

    <?php endif; ?>

</div><!-- /.main-content -->

<?php $_SESSION['salt'] = $salt; ?>

<script type="text/javascript">
var salt = '<?php echo $salt ?>';

// ── Applicant radio toggle ──────────────────────────
document.querySelectorAll('input[name="optradio"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var div = document.getElementById('app_div_modern');
        if (this.value === '1') {
            div.classList.add('visible');
        } else {
            div.classList.remove('visible');
        }
    });
});

// ── SHA password hash ───────────────────────────────
function getPass() {
    var password = document.getElementById('pass').value;
    if (password !== '') {
        var shaObj = new jsSHA("SHA-1", "TEXT");
        shaObj.update(password);
        var hashPass = shaObj.getHash("HEX");

        var shaObj1 = new jsSHA("SHA-1", "TEXT");
        shaObj1.update(hashPass + salt);
        document.getElementById('pass').value = shaObj1.getHash("HEX");
    }
}

// ── Captcha refresh ─────────────────────────────────
document.getElementById('refreshImg').addEventListener('click', function() {
    $.ajax({
        url: baseURL + 'home/refreshCaptcha',
        dataType: 'html',
        success: function(data) { document.getElementById('captid').src = data; }
    });
});

// ── Notification marquee ────────────────────────────
$(function() {
    $('.marquee').marquee({
        duration: 22000,
        gap: 150,
        delayBeforeStart: 0,
        direction: 'left',
        duplicated: true,
        pauseOnHover: true
    });
});
</script>
