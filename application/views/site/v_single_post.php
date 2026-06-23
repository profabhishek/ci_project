	<style type="text/css">
.hd{
	text-align: center; border-bottom: 1px solid rgb(206, 206, 206); padding-bottom: 14px; margin-bottom: 20px;
}
.srilanka-scheme ul li a {
    color: #f18f2e;
    font-size: 16px;
    font-weight: bold;
}

p
{ padding: 0 0 20px 0;
  line-height: 1.5em;
  font-size: 107%;}
</style>
	<section class="meacontent" id="meacontent">
			<div  class="container">
				 <h2 class="hd">Blogs</h2>
				 
				<div class="col-xs-12 col-sm-6 col-md-12 pdleft pdright">
					     <!-- insert the page content here -->
        <?php if(!isset($post))
            {echo "This page was accessed incorrectly";}
            else //display the post
            {?>
                <h2><?=$post['post_title']?></h2>
                <p><?=$post['post']?></p>
                
                <hr>
                <h3>Comments</h3>
    <?php       //if there is comments then print the comments
                if(count($comments) > 0)
                {
                    foreach ($comments as $row)
                    {?>
                <p><strong><?=$row['username']?></strong> said at <?= date('d-m-Y h:i A',strtotime($row['date_added']))?><br>
                <?=$row['comment'];?></p><hr>
            <?php   }
                }
                else //when there is no comment
                {
                    echo "<p>Currently, there are no comment.</p>";
                }
                
                if($this->session->userdata('user_id'))//if user is loged in, display comment box
                {?>
                    <form action="<?=  base_url()?>index.php/comments/add_comment/<?=$post['post_id']?>" method="post">
                        <div class="form_settings">
                            <p>
                                <span>Comment</span>
                                <textarea class="textarea" rows="8" cols="100" name="comment"></textarea>
                            </p>
                            <p style="padding-top: 15px">
                                <span>&nbsp;</span>
                                <input class="submit" type="submit" name="add" value="Add comment" />
                            </p>
                        </div>
                    </form>
               <?php 
               
                }
                else {//if no user is loged in, then show the loged in button
                ?>
                <a href="<?=  base_url()?>home">Login to comment</a>
        <?php    }
            }?>   
				</div>
			<div  style="width: 76%;margin: 0 auto;">
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle front"/></a>
						<a target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle back"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle front"/></a>
						<a target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle back"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Incredible India" class="img-circle front" /></a>
						<a target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Incredible India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle front" /></a>
						<a target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" class="img-circle front" /></a>							
						<a target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png"  class="img-circle back" /></a>
					</div>
					
					
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle front" /></a>
						<a target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle back" /></a>
					</div>
					
									
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle front"/></a>
						<a target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle back"/></a>
					</div>
				</div>
			</div>
		</section>