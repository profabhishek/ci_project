<?php
error_reporting(0); ?>
<style type="text/css">
	.tab-content {
		border: 1px solid #cecece;
		padding: 10px 20px 20px;
	}

	.form_head {
		float: none;
		height: 132px;
		margin: 0 auto;
		text-align: center;
	}

	.form_head img {
		width: 32px;
	}

	.form_head h3 {
		height: 33px;
		margin: 0;
		width: 100%;
	}

	.form_head h5 {
		margin: 0 auto;
	}

	.caps {
		text-transform: uppercase;
	}

	.prfl {
		border: 4px double #cecece;
		height: 150px;
		width: 150px;
		text-align: center;
		padding: 0;
	}

	.prfl img {
		height: 143px;
		margin-bottom: 8px;
		width: 139px;
	}

	.note {
		font-size: 10px;
		font-weight: normal;
		margin-left: 15px;
	}

	.note strong {
		color: red;
		font-size: 11px;
		font-weight: normal;
		margin-left: 15px;
	}

	.note1 {
		font-size: 13px;
		font-weight: normal;
		margin-left: 0;
	}

	.undertake {
		margin-right: 5px !important;
		margin-top: 2px !important;
		float: left;
	}

	.upload_link {
		border-right: 1px solid #cecece;
		margin-right: 8px;
		padding-right: 12px;
	}

	.alert {
		margin: 12px auto 8px;
		width: 85.5%;
	}
</style>
<section class="meacontent">
	<div class="col-xs-10 form_head">
		<img src="<?php echo site_url(); ?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<?php
		$user_data = $this->session->userdata('user_data');
		$student_type = $user_data['student_type'];

		if ($student_type == 2) {
		?>
			<h3 class="text-center caps">Application Form For SFS(Self Finance Student)</h3>
			<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
		<?php
		} else {
		?>
			<h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
			<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
		<?php
		}
		?>




	</div>
	<?php
	if ($this->session->flashdata('message_type') == "success") {
	?>
		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
		</div>
	<?php
	}
	if ($this->session->flashdata('message_type') == "error") {
	?>
		<div class="alert alert-error" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
		</div>
	<?php
	}

	?>
	<div class="container" style="min-height:380px;padding:0px;">
		<?php
		$docsArray = array();
		if (count($applicaitonDocuments) > 0) {
			foreach ($applicaitonDocuments as $docs) {
				/*if(!array_key_exists($docs['doc_type'],$docsArray))
			{
				$docsArray[$docs['doc_type']] = array();
			}
			$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
			$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];*/
				if (!array_key_exists($docs['doc_type'], $docsArray)) {
					$docsArray[$docs['doc_type']] = array();
					$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
					$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
				}
			}
		}
		?>
		<div class="tab-content">

			<div id="step3" class="tab-pane fade in active">
				<h5 class="text-center">Please Upload All Documents Listed Below <br/><span style="color:red;">Note: (All document should be in PDF format) <br /> All file names should be in english language like (Physical Fitness.pdf..etc.) not in other language like:-> غفران_حلبي_كشف.pdf.
						<br />


					</span></h5>

				<br /><br /><span style="color:red;"><b>Note: </b></span><span><b> <span class="text-red">*</span>Fields marked with * are mendatory.</b></span>
				<?php  //echo "<pre>";print_r($applicaitonStepOne);die;
				?>
				<form id="form-two-application" action="<?php echo site_url(); ?>applicant?appno=<?php echo $applicaitonStepOne[0]['application_no']; ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="box-body">
						<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
							<table class="table">
								<thead>
									<th>S.No.</th>
									<th>Document&nbsp;Name</th>
									<th>Upload&nbsp;Document</th>
									<th>Uploaded&nbsp;Time</th>
								</thead>
								<tbody>
									<?php


									$counter = 1;
									$upload = 0;
									$doctypes = $this->config->item('doc_types');
									$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']);
									//echo "<pre>";print_r($userd->dir);
									//$userd = $this->common_model->getUserInfo( $applicaitonStepOne[ 0 ][ 'uid' ] );
									//echo $userd->dir .'/'.$userImage;
									//$imgs = file_get_contents($userd->dir .'/'.$userImage);
									//echo $docsArray[$doctypes['id']['type']]['path'];
									//$imgs = file_get_contents($docsArray[$doctypes['id']['type']]['path']);
									//echo $imgs.'------------------';
									//$file = base64_encode($imgs);
									//echo $data;
									//$f = finfo_open();
									//$decoded = base64_decode($data);
									$file_path = $docsArray[$doctypes['id']['type']]['path'];
									$file_path_passport = $docsArray[$doctypes['passport']['type']]['path'];
									$file_path_school_leaving_x = $docsArray[$doctypes['school_leaving_x']['type']]['path'];
									$file_path_school_leaving = $docsArray[$doctypes['school_leaving']['type']]['path'];
									$file_path_ug = $docsArray[$doctypes['ug']['type']]['path'];
									$file_path_pg = $docsArray[$doctypes['pg']['type']]['path'];
									$file_path_phd = $docsArray[$doctypes['phd']['type']]['path'];
									$file_path_phdReseachPaper = $docsArray[$doctypes['phdReseachPaper']['type']]['path'];
									$file_path_indian_address = $docsArray[$doctypes['indian_address']['type']]['path'];
									$file_path_d1 = $docsArray[$doctypes['d1']['type']]['path'];
									$file_path_physical = $docsArray[$doctypes['physical']['type']]['path'];
									$file_path_tl = $docsArray[$doctypes['tl']['type']]['path'];
									$file_path_otherDoc = $docsArray[$doctypes['otherDoc']['type']]['path'];
									$file_path_toefl = $docsArray[$doctypes['toeflDoc']['type']]['path'];
									$file_path_ielts = $docsArray[$doctypes['ieltsDoc']['type']]['path'];
									$file_path_duolingo = $docsArray[$doctypes['duolingoDoc']['type']]['path'];
									$file_path_subject = $docsArray[$doctypes['subjectDoc']['type']]['path'];


									//$mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
									//echo $file;
									/* file_put_contents($file, $decoded);

								if (file_exists($file)) {
									header('Content-Description: File Transfer');
									header('Content-Type: application/octet-stream');
									header('Content-Disposition: attachment; filename="'.basename($file).'"');
									header('Expires: 0');
									header('Cache-Control: must-revalidate');
									header('Pragma: public');
									header('Content-Length: ' . filesize($file));
									readfile($file);
									//exit;
								} */
									?>
									<tr>
										<td><?php echo $counter;
											$counter++; ?></td>
										<td>Citizenship/Local ID/Domestic ID <span style="color:red;font-size:11px;">(Document size must be less than 1 MB)</span><span class="text-red">*</span></td>
										<td>
											<?php
											if (array_key_exists($doctypes['id']['type'], $docsArray)) {
												$upload++;
											?>
												<a href="#" data-toggle="modal" class="upload_link" data-target="#idProofDiv">Re-Upload</a>
												<a href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
											<?php
											} else {
											?>
												<a href="#" data-toggle="modal" class="upload_link" data-target="#idProofDiv">Upload</a>
											<?php
											}
											?>

										</td>
										<td>
											<?php
											if (array_key_exists($doctypes['id']['type'], $docsArray)) {
												echo date('d-m-y h:i:s a', $docsArray[$doctypes['id']['type']]['time']);
											} else {
											?>
												N/A
											<?php
											}
											?>
										</td>
									</tr>
									<?php
									if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['passport_no'] != "" || $applicaitonStepOne[0]['country'] == 10) {
									?>
										<tr>
											<td><?php echo $counter;
												$counter++; ?></td>
											<?php if ($applicaitonStepOne[0]['country'] == 10 && $applicaitonStepOne[0]['passport_no'] == "") {
											?>

												<td><?php echo 'Applicants to upload copy of the passport delivery slip against the mandatory passport related field'; ?><span class="text-red">*</span></td>
											<?php
											} else {
											?>
												<td><?php echo $doctypes['passport']['title']; ?><span class="text-red">*</span></td>
											<?php
											}
											?>


											<td>
												<?php
												if (array_key_exists($doctypes['passport']['type'], $docsArray)) {
													$upload++;
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#passportDiv">Re-Upload</a>
													<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_passport); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
												<?php
												} else {
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#passportDiv">Upload</a>
												<?php
												}
												?>

											</td>
											<td>
												<?php
												if (array_key_exists($doctypes['passport']['type'], $docsArray)) {
													echo date('d-m-y h:i:s a', $docsArray[$doctypes['passport']['type']]['time']);
												} else {
												?>
													N/A
												<?php
												}
												?>
											</td>

										</tr>
									<?php
									}
									?>
									<?php
									$programs = $this->config->item('programme');

									$program = $programs[$applicaitonStepOne[0]['programme']];
									switch ($program) {
										case "UG":
										case "Diploma":
										case "Certificate":
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country_x'] != "" && $applicaitonStepTwo[0]['school_leaving_country_x'] > 0) {
									?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['school_leaving_x']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving_x']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDivX">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_school_leaving_x); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDivX">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving_x']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['school_leaving_x']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}

											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['school_leaving']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_school_leaving); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['school_leaving']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}

											break;
										case "PG":
										case "Dance":
										case "Music":
										case "Yoga":
										case "CetificateCourse":
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country_x'] != "" && $applicaitonStepTwo[0]['school_leaving_country_x'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['school_leaving_x']['title']; ?><span class="text-red">*</span></td>

													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving_x']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDivX">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_school_leaving_x); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDivX">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving_x']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['school_leaving_x']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['school_leaving']['title']; ?><span class="text-red">*</span></td>

													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_school_leaving); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['school_leaving']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0) {
											?> <tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['ug']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_ug); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['ug']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											break;
										case "M.Phil":
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['school_leaving']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_school_leaving); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['school_leaving']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['ug']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_ug); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['ug']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['pg_leaving_country'] != "" && $applicaitonStepTwo[0]['pg_leaving_country'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['pg']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['pg']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#postGraduateDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_pg); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#postGraduateDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['pg']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['pg']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											break;
										case "Ph.D":
										case "Ph.D Ayurveda":
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country_x'] != "" && $applicaitonStepTwo[0]['school_leaving_country_x'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['school_leaving_x']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving_x']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDivX">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_school_leaving_x); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDivX">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving_x']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['school_leaving_x']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['school_leaving']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_school_leaving); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['school_leaving']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['ug']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_ug); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['ug']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											if (count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['pg_leaving_country'] != "" && $applicaitonStepTwo[0]['pg_leaving_country'] > 0) {
											?>
												<tr>
													<td><?php echo $counter;
														$counter++; ?></td>
													<td><?php echo $doctypes['pg']['title']; ?><span class="text-red">*</span></td>
													<td>
														<?php
														if (array_key_exists($doctypes['pg']['type'], $docsArray)) {
															$upload++;
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#postGraduateDiv">Re-Upload</a>
															<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_pg); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
														<?php
														} else {
														?>
															<a href="#" data-toggle="modal" class="upload_link" data-target="#postGraduateDiv">Upload</a>
														<?php
														}
														?>

													</td>
													<td>
														<?php
														if (array_key_exists($doctypes['pg']['type'], $docsArray)) {
															echo date('d-m-y h:i:s a', $docsArray[$doctypes['pg']['type']]['time']);
														} else {
														?>
															N/A
														<?php
														}
														?>
													</td>

												</tr>
											<?php
											}
											?>

											<tr>
												<td><?php echo $counter;
													$counter++; ?></td>
												<td><?php echo $doctypes['phd']['title']; ?><span class="text-red">*</span></td>
												<td>
													<?php
													if (array_key_exists($doctypes['phd']['type'], $docsArray)) {
														$upload++;
													?>
														<a href="#" data-toggle="modal" class="upload_link" data-target="#phdDiv">Re-Upload</a>
														<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_phd); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
													<?php
													} else {
													?>
														<a href="#" data-toggle="modal" class="upload_link" data-target="#phdDiv">Upload</a>
													<?php
													}
													?>

												</td>
												<td>
													<?php
													if (array_key_exists($doctypes['phd']['type'], $docsArray)) {
														echo date('d-m-y h:i:s a', $docsArray[$doctypes['phd']['type']]['time']);
													} else {
													?>
														N/A
													<?php
													}
													?>
												</td>

											</tr>


											<tr>
												<td><?php echo $counter;
													$counter++; ?></td>
												<td><?php echo $doctypes['phdReseachPaper']['title']; ?><span class="text-red">*</span></td>
												<td>
													<?php
													if (array_key_exists($doctypes['phdReseachPaper']['type'], $docsArray)) {
														$upload++;
													?>
														<a href="#" data-toggle="modal" class="upload_link" data-target="#phdResearchDiv">Re-Upload</a>
														<a target="_blank" href="<?php echo site_url(); ?><?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_phdReseachPaper); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
													<?php
													} else {
													?>
														<a href="#" data-toggle="modal" class="upload_link" data-target="#phdResearchDiv">Upload</a>
													<?php
													}
													?>

												</td>
												<td>
													<?php
													if (array_key_exists($doctypes['phdReseachPaper']['type'], $docsArray)) {
														echo date('d-m-y h:i:s a', $docsArray[$doctypes['phdReseachPaper']['type']]['time']);
													} else {
													?>
														N/A
													<?php
													}
													?>
												</td>
											</tr>
									<?php
											break;
									}
									?>
									<?php
									if (count($applicaitonStepThree) > 0 && $applicaitonStepThree[0]['currently_non_nri'] != "" && $applicaitonStepThree[0]['currently_non_nri'] > 0 && $applicaitonStepThree[0]['currently_non_nri'] == 1) {
									?>
										<tr>
											<td><?php echo $counter;
												$counter++; ?></td>
											<td><?php echo $doctypes['indian_address']['title']; ?><span class="text-red">*</span></td>
											<td>
												<?php
												if (array_key_exists($doctypes['indian_address']['type'], $docsArray)) {
													$upload++;
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#addressProofDiv">Re-Upload</a>
													<a target="_blank" href="<?php echo site_url(); ?><?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_indian_address); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
												<?php
												} else {
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#addressProofDiv">Upload</a>
												<?php
												}
												?>

											</td>
											<td>
												<?php
												if (array_key_exists($doctypes['indian_address']['type'], $docsArray)) {
													echo date('d-m-y h:i:s a', $docsArray[$doctypes['indian_address']['type']]['time']);
												} else {
												?>
													N/A
												<?php
												}
												?>
											</td>

										</tr>
									<?php
									}
									?>
									<?php
									 /*if (count($applicaitonStepThree) > 0 && $applicaitonStepThree[0]['is_international_lic'] != "" && $applicaitonStepThree[0]['is_international_lic'] > 0 && $applicaitonStepThree[0]['is_international_lic'] == 1) {
									?>
										<tr>
											<td><?php echo $counter;
												$counter++; ?></td>
											<td><?php echo $doctypes['dl']['title']; ?><span class="text-red">*</span></td>
											<td>
												<?php
												if (array_key_exists($doctypes['dl']['type'], $docsArray)) {
													$upload++;
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#licenceDiv">Re-Upload</a>
													<a target="_blank" href="<?php echo site_url(); ?><?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_d1); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
												<?php
												} else {
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#licenceDiv">Upload</a>
												<?php
												}
												?>

											</td>
											<td>
												<?php
												if (array_key_exists($doctypes['dl']['type'], $docsArray)) {
													echo date('d-m-y h:i:s a', $docsArray[$doctypes['dl']['type']]['time']);
												} else {
												?>
													N/A
												<?php
												}
												?>
											</td>

										</tr>
									<?php
									}*/
									?>
									<!--<tr>
										<td><?php /*echo $counter;
											$counter++; ?></td>
										<td><?php echo $doctypes['physical']['title']; ?><span class="text-red">*</span> &nbsp;<a href="<?php echo site_url(); ?>assets/site/docs/Fitness.pdf" target="_blank">Download Format</a></td>
										<td>
											<?php
											if (array_key_exists($doctypes['physical']['type'], $docsArray)) {
												$upload++;
											?>
												<a href="#" data-toggle="modal" class="upload_link" data-target="#physicalFitnessDiv">Re-Upload</a>
												<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_physical); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
											<?php
											} else {
											?>
												<a href="#" data-toggle="modal" class="upload_link" data-target="#physicalFitnessDiv">Upload</a>
											<?php
											}
											?>

										</td>
										<td>
											<?php
											if (array_key_exists($doctypes['physical']['type'], $docsArray)) {
												echo date('d-m-y h:i:s a', $docsArray[$doctypes['physical']['type']]['time']);
											} else {
											?>
												N/A
											<?php
											}*/
											?>
										</td>

									</tr>-->


									<tr>
										<td><?php echo $counter;
											$counter++; ?></td>
											<td><?php echo $doctypes['tl']['title']; ?> <span class="text-red">*</span> &nbsp;</b></td>
										<td>
											<?php
											if (array_key_exists($doctypes['tl']['type'], $docsArray)) {
												$upload++;
											?>
												<a href="#" data-toggle="modal" class="upload_link" data-target="#translationDiv">Re-Upload</a>
												<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_tl); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
											<?php
											} else {
											?>
												<a href="#" data-toggle="modal" class="upload_link" data-target="#translationDiv">Upload</a>
											<?php
											}
											?>

										</td>
										<td>
											<?php
											if (array_key_exists($doctypes['tl']['type'], $docsArray)) {
												echo date('d-m-y h:i:s a', $docsArray[$doctypes['tl']['type']]['time']);
											} else {
											?>
												N/A
											<?php
											}
											?>
										</td>

									</tr>
									
									<?php
									if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['is_toefl'] == 1 ) {
									?>
										<tr>
											<td><?php echo $counter;
												$counter++; ?></td>
											<td><?php echo $doctypes['toeflDoc']['title']; ?> &nbsp;<span class="text-red">*</span></td>


											<td>
												<?php
												//echo '<pre>';print_r($doctypes);die;
												if (array_key_exists($doctypes['toeflDoc']['type'], $docsArray)) {
													$upload++;
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#toeflDiv">Re-Upload</a>
													<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_toefl); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
												<?php
												} else {
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#toeflDiv">Upload</a>
												<?php
												}
												?>

											</td>
											<td>
												<?php
												if (array_key_exists($doctypes['toeflDoc']['type'], $docsArray)) {
													echo date('d-m-y h:i:s a', $docsArray[$doctypes['toeflDoc']['type']]['time']);
												} else {
												?>
													N/A
												<?php
												}
												?>
											</td>

										</tr>
									<?php
									}
									?>
									<?php
									if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['is_ielts'] == 1 ) {
									?>
										<tr>
											<td><?php echo $counter;
												$counter++; ?></td>
											<td><?php echo $doctypes['ieltsDoc']['title']; ?> &nbsp;<span class="text-red">*</span></td>


											<td>
												<?php
												//echo '<pre>';print_r($doctypes);die;
												if (array_key_exists($doctypes['ieltsDoc']['type'], $docsArray)) {
													$upload++;
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#ieltsDiv">Re-Upload</a>
													<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_ielts); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
												<?php
												} else {
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#ieltsDiv">Upload</a>
												<?php
												}
												?>

											</td>
											<td>
												<?php
												if (array_key_exists($doctypes['ieltsDoc']['type'], $docsArray)) {
													echo date('d-m-y h:i:s a', $docsArray[$doctypes['ieltsDoc']['type']]['time']);
												} else {
												?>
													N/A
												<?php
												}
												?>
											</td>

										</tr>
									<?php
									}
									?>
									
									<?php
									if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['is_duolingo'] == 1 ) {
									?>
										<tr>
											<td><?php echo $counter;
												$counter++; ?></td>
											<td><?php echo $doctypes['duolingoDoc']['title']; ?> &nbsp;<span class="text-red">*</span></td>


											<td>
												<?php
												//echo '<pre>';print_r($doctypes);die;
												if (array_key_exists($doctypes['duolingoDoc']['type'], $docsArray)) {
													$upload++;
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#duolingoDiv">Re-Upload</a>
													<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_duolingo); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
												<?php
												} else {
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#duolingoDiv">Upload</a>
												<?php
												}
												?>

											</td>
											<td>
												<?php
												if (array_key_exists($doctypes['duolingoDoc']['type'], $docsArray)) {
													echo date('d-m-y h:i:s a', $docsArray[$doctypes['duolingoDoc']['type']]['time']);
												} else {
												?>
													N/A
												<?php
												}
												?>
											</td>

										</tr>
									<?php
									}
									?>
									
									<?php
									if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['is_english_as_subject'] == 1 ) {
									?>
										<tr>
											<td><?php echo $counter;
												$counter++; ?></td>
											<td><?php echo $doctypes['subjectDoc']['title']; ?> &nbsp;<span class="text-red">*</span></td>


											<td>
												<?php
												//echo '<pre>';print_r($doctypes);die;
												if (array_key_exists($doctypes['subjectDoc']['type'], $docsArray)) {
													$upload++;
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#subjectDiv">Re-Upload</a>
													<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_subject); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
												<?php
												} else {
												?>
													<a href="#" data-toggle="modal" class="upload_link" data-target="#subjectDiv">Upload</a>
												<?php
												}
												?>

											</td>
											<td>
												<?php
												if (array_key_exists($doctypes['subjectDoc']['type'], $docsArray)) {
													echo date('d-m-y h:i:s a', $docsArray[$doctypes['subjectDoc']['type']]['time']);
												} else {
												?>
													N/A
												<?php
												}
												?>
											</td>

										</tr>
									<?php
									}
									?>
									<!--<tr>
										<td><?php echo $counter; ?></td>
										<td><?php echo $doctypes['otherDoc']['title']; ?> &nbsp;<b></b></td>
										<td>
											<?php
											if (array_key_exists($doctypes['otherDoc']['type'], $docsArray)) {
												//$upload++;
											?>
												<a href="#" data-toggle="modal" class="upload_link" data-target="#otherDocDiv">Re-Upload</a>
												<a target="_blank" href="<?php echo site_url() . 'applicant/downloadDocs/' . base64url_encode($file_path_otherDoc); ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
											<?php
											} else {
											?>
												<a href="#" data-toggle="modal" class="upload_link" data-target="#otherDocDiv">Upload</a>
											<?php
											}
											?>

										</td>
										<td>
											<?php
											if (array_key_exists($doctypes['otherDoc']['type'], $docsArray)) {
												echo date('d-m-y h:i:s a', $docsArray[$doctypes['otherDoc']['type']]['time']);
											} else {
											?>
												N/A
											<?php
											}
											?>
										</td>

										</tr>-->
								</tbody>
							</table>
							<br />

						</div>
						<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
							<div class="name-sec col-xs-12 col-sm-6 col-md-12">
								<div class="form-group">
									<!--<span class="note1"><input type="checkbox" id="undertaking" name="undertaking" class="undertake" required onchange = "notification();"/>I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Scholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.Any false information given in the application will be liable to cancellation of admission.</span>-->
									<span class=""><input type="checkbox" id="" name="undertaking" class="" required  /> &nbsp;<b>i.&nbsp; READ all the ICCR Terms and Conditions and New SOPs.</b></span> <br />
									<span class=""><input type="checkbox" id="" name="undertaking" class="" required  /> &nbsp;<b>ii.&nbsp; All the Entries/Information filled is correct and will be solely responsible the consequences if any of provided Information is found Incorrect or have applied more than once.<b></span>

									<br /><br /><span style="color:red;"><b>Note: </b></span><span><b>Kindly review your application before final submission. Details can't be changed after final submit.</b></span>
								</div>
 
							</div>
						</div>
						<!--<div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
							<div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
								<?php
								//print_r($applicaitonsResubmitStatus);
								//echo $upload;
								//die;
								$flag = false;
								if (!empty($applicaitonsResubmitStatus)) {

									foreach ($applicaitonsResubmitStatus as $unData) {
										if ($unData['ResumitStatus'] == 5) {

											$flag = true;
											break;
										}
									}
								}
								if ($upload == ($counter - 1)) {

									//echo $upload.'---------------';echo $counter;
									//echo $applicaitonStepOne[0]['status'];
									if ($applicaitonStepOne[0]['status'] == "Pending" || $flag == true) {
								?>
										<input type="submit" class="form-control sbmt" value="Re-Submit" />
									<?php
									} else {


									?>
										<input type="submit" class="form-control sbmt" value="Final Submit" />
									<?php
									}
								} else {

									if ($applicaitonStepOne[0]['status'] == "Pending" || $flag == true) {
									?>
										<a class="btn btn-block btn-default disabled">Re-Submit</a>
									<?php
									} else {
									?>
										<a class="btn btn-block btn-default disabled">Final Submit</a>
								<?php
									}
								}
								?>
							</div>


							<?php
							//echo "<pre>";print_r($applicaitonDocuments);
							if (!empty($applicaitonDocuments)) {
							?>
								<div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
									<a href="<?php echo site_url(); ?>applicant/applicant_documents_info_preview?appno=<?php echo $applicaitonStepOne[0]['application_no']; ?>" target="_blank" class="form-control sbmt"><span></span>&nbsp;&nbsp;Preview</a>
								</div>

							<?php
							} else {
							?>

								<div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
									<a href="javascript:void(0);" class="form-control sbmt" disabled><span></span>&nbsp;&nbsp;Preview</a>
								</div>
							<?php
							}
							?>


						</div>-->
					</div>
					<!-- /.box-body -->
				</form>
			</div>
		</div>
	</div>
</section>
<div id="schoolLivingDiv" class="modal fade" role="dialog">
	<div id="schoolLiving" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="schoolLivingDivX" class="modal fade" role="dialog">
	<div id="schoolLivingx" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="underGraduateDiv" class="modal fade" role="dialog">
	<div id="underGraduate" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="postGraduateDiv" class="modal fade" role="dialog">
	<div id="postGraduate" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="mphilDiv" class="modal fade" role="dialog">
	<div id="mphil" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="phdDiv" class="modal fade" role="dialog">
	<div id="phd" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="panCardDiv" class="modal fade" role="dialog">
	<div id="panCard" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="idProofDiv" class="modal fade" role="dialog">
	<div id="idProof" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="addressProofDiv" class="modal fade" role="dialog">
	<div id="addressProof" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="physicalFitnessDiv" class="modal fade" role="dialog">
	<div id="physicalFitness" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>

<div id="gmatScoreDiv" class="modal fade" role="dialog">
	<div id="gmatScore" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>

<div id="passportDiv" class="modal fade" role="dialog">
	<div id="passport" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="licenceDiv" class="modal fade" role="dialog">
	<div id="licenceUpload" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="translationDiv" class="modal fade" role="dialog">
	<div id="translationUpload" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="phdResearchDiv" class="modal fade" role="dialog">
	<div id="phdResearch" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>

<div id="otherDocDiv" class="modal fade" role="dialog">
	<div id="otherDoc" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="toeflDiv" class="modal fade" role="dialog">
	<div id="toeflDoc" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>
<div id="ieltsDiv" class="modal fade" role="dialog">
	<div id="ieltsDoc" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>

<div id="duolingoDiv" class="modal fade" role="dialog">
	<div id="duolingoDoc" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>

<div id="subjectDiv" class="modal fade" role="dialog">
	<div id="subjectDoc" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
	</div>
</div>

<script>
	//$('#profilePic').dropzone({ url: baseURL + "applicant/uploadProfilePic",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
	$('#phdResearch').dropzone({
		url: baseURL + "applicant/uploadPhdResearchPaper",
		uploadMultiple: false,
		dictDefaultMessage: "Click / Drop here to upload files"
	});
	$('#gmatScore').dropzone({
		url: baseURL + "applicant/uploadGmatScore",
		uploadMultiple: false,
		dictDefaultMessage: "Click / Drop here to upload files"
	});
	$('#otherDoc').dropzone({
		url: baseURL + "applicant/uploadOtherDocs",
		uploadMultiple: false,
		dictDefaultMessage: "Click / Drop here to upload files"
	});
	$('#toeflDoc').dropzone({
		url: baseURL + "applicant/uploadTOEFLDocs",
		uploadMultiple: false,
		dictDefaultMessage: "Click / Drop here to upload files"
	});
	$('#ieltsDoc').dropzone({
		url: baseURL + "applicant/uploadIELTSDocs",
		uploadMultiple: false,
		dictDefaultMessage: "Click / Drop here to upload files"
	});
	$('#duolingoDoc').dropzone({
		url: baseURL + "applicant/uploadDUOLINGODocs",
		uploadMultiple: false,
		dictDefaultMessage: "Click / Drop here to upload files"
	});
	$('#subjectDoc').dropzone({
		url: baseURL + "applicant/uploadSubjectDocs",
		uploadMultiple: false,
		dictDefaultMessage: "Click / Drop here to upload files"
	});
</script>