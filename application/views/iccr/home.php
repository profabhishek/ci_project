<style type="text/css">
.loginbox_mission
{
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: 1px solid #cecece;
    margin: 3% auto;
    padding: 23px;
    width: 50%;
    box-shadow: 4px 4px 4px green;
}

</style>
<section class="meacontent">
			<div  class="container">				
				<div class="loginbox_mission">
					<div class="loginarea">
						<form action="<?php echo site_url();?>user/login" enctype="multipart/form-data" method="post">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						
						<div class="form-group">
							<label>Login ID</label>
							<div class="input-rig">
							<input type="text" required="true" name="username" id="username" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label>Password</label>
							<div class="input-rig">
							<input type="password" name="pass" id="pass" required="true" class="form-control" />
							</div>
						</div>
						<div class="form-group">
						<label>Captcha</label>
						   <div class="captcha input-rig">
							 <img src="<?php echo $captcha['image_src']; ?>"/>
							 <input type="text" required="true" id="captchatext" name="captchatext" class="form-control" />
							</div>
						</div>
						<div class="form-group btn-sec">
						    <div class="submit-sec input-rig">
							<input type="submit" class="form-control sbmt" value="Submit" />
							<input type="submit" class="form-control reset" value="Reset" />
							</div>
						</div>
						</form>
					</div>
				</div>				
			</div>
		</section>
	