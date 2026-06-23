<style type="text/css">
.bor-bgx{
 margin-top:65px; border:#CCCCCC solid 1px; padding:15px;
 text-align:center;
}

.bor-bgx h2{
 margin:0;
 padding:7px 0;
 font-size:26px;
 font-weight:600;
 text-transform:uppercase;
 background:#003F74;
 color:#FFFFFF;
 text-align:center;
 margin-bottom:15px;
 }
 
 .bor-bgx p{
  margin-bottom:15px;
  padding:0;
  }


</style>

<section class="account-p" style='margin-top:0;margin-bottom:52px;'>
  <div class="container">
  <div class="col-lg-6 col-lg-offset-3 bor-bgx">
    <h2>Almost There!</h2>
    <h5>Hello <span><?php echo $firstName; ?></span>. Your username is <span><strong><?php echo $email;?></strong></span></h5>
    <p>Please enter a password to begin using the site.</p>
<?php 
    $fattr = array('class' => 'form-signin');
    echo form_open(site_url().'home/complete/token/'.$token, $fattr); ?>
    <div class="form-group">
      <?php echo form_password(array('name'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control', 'value' => set_value('password'))); ?>
      <?php echo form_error('password') ?>
    </div>
    <div class="form-group">
      <?php echo form_password(array('name'=>'passconf', 'id'=> 'passconf', 'placeholder'=>'Confirm Password', 'class'=>'form-control', 'value'=> set_value('passconf'))); ?>
      <?php echo form_error('passconf') ?>
    </div> 
    <?php echo form_submit(array('value'=>'Complete', 'class'=>'form-control sbmt')); ?>
    <?php echo form_close(); ?>
   
</div>
    </div>
</section>
