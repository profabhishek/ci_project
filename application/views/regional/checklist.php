<style type="text/css">
.tweaked-margin{margin-right:5px !important;}
.list-group {
	list-style: decimal inside;
}

.list-group-item {
	display: list-item;
}
</style>
<section class="meacontent">
	<div  class="container">
	<div class="field-item even" property="content:encoded">
	<form id="form-one-application" action="<?php echo site_url();?>mission/approve_application?appno=<?php echo $_GET['appno']; ?>" method="post">
		<h2>CHECK LIST FOR MISSION</h2>
		<ul class="list-group">
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/> Duly filled in application form with photograph and signature.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/> Copies of graduation certificates/ mark sheets for all educational qualifications listed
in form.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/>Certified copies of Passport.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/> Certified copies of translation of documents which are not in English .</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/> The application for B.E course, scholar must have studied Physics, Chemistry and
			Mathematics(PCM) in his/her school leaving examination with minimum of 60%.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/> Audio/ Video cassettes of those wishing to pursue courses in performing arts is
			attached.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/>Synopsis of proposed area of research when applying for M.Phil/ Doctoral/ Postdoctoral
			course is attached.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/>No original documents attached with this form.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/>Certificate that scholar has availed/ not availed of an ICCR scholarship earlier .</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/>Undertaking by students that he/she will abide by rules and regulations of the ICCR
			scholarship scheme.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/>Certificate of Physical fitness.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/>Certificate that scholar is not studying in India as a self- financing student.</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/>Certificate of proficiency in English based on test conducted by Mission and marks
			to be uploaded. Answer sheets to be sent to Council by post</li>
			<li class="list-group-item "><input type="checkbox" class="tweaked-margin" name="checklist_1" id="checklist_2"/> Mission to ensure Consular checks/local police verification on candidate before
			recommending. 
			</li>
		</ul>
		<p>It is certified that the application form is complete in every aspect. </p>
		<div class="dateof-birth col-xs-12 col-sm-12 col-md-5 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft">
					 <label for="comment">Name</label>
						<div class="form-group">
						  <input type="text" name="passport_no" class="form-control" placeholder="Passport No" id="passport_no" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '" required="true" value=""/>
						</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft">
					 <label for="comment">Designation</label>
						<div class="form-group">
						  <input type="text" class="form-control" id="passport_issue_date" name="passport_issue_date" placeholder="Designation" required="true" value=""/>
						</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft">
					 <label for="comment">Date</label>
						<div class="form-group">
						  <input type="text" class="form-control datepicker" id="passport_expiry_date" name="passport_expiry_date" placeholder="yy-mm-dd" required="true" value=""/>
						</div>
					</div>
					
				</div>
		<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft">
					 <label for="comment">Place</label>
						<div class="form-group col-md-5 pdleft">
						  <input type="text" class="form-control" id="passport_expiry_date" name="passport_expiry_date" placeholder="Place" required="true" value=""/>
						</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
					 <label for="comment">Signature</label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Place of Issue" id="passport_issue_place" name="passport_issue_place" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value=""/>
						</div>
					</div>
				</div>	
		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">				
		 	<input type="submit" id="step-one-application" name="step-one-application" class="form-control sbmt" value="Approve"/>
      	</div>
    </form>          	
	</div>
</div>
</section>		