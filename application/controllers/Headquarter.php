<?php

defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(E_ALL);
	ini_set('display_errors', 0); 
class Headquarter extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public $ids = array();

	
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        //$this->load->library('encryption');
        $this->load->helper('date');
		$this->load->helper('status_helper');
       // $this->load->library('zip');
        $this->load->model('user_model');
        $this->load->model('common_model');
		$this->load->model('mission_model');
		$this->load->model('regional_model');
        $this->load->model('hqrs_model');
        $this->load->model('reports');
		// Moved out of the constructor for performance: 'excel' is now loaded only inside the methods that use it.
        // Moved out of the constructor for performance: 'mpdf60/Mpdf' is now loaded only inside the methods that use it.
        $userdata = $this->session->userdata('user_data');

        if (!$this->session->userdata('user_data')) {
            redirect('home');
        } else {
            $roles = $this->config->item('roles_id');
            $role = $roles[$userdata['user_type']];

            switch ($role) {
                case "Mission":
                    redirect(site_url() . 'mission/dashboard');
                    break;
                case "Regional Office":
                    redirect(site_url() . 'regional/dashboard');
                    break;
                case "Super Admin":
                    redirect(site_url() . 'admin/dashboard');
                    break;
                case "Student":
                    redirect(site_url() . 'applicant/dashboard');
                    break;
            }
        }
        $division = $userdata['state'];
        if ($division == 0 || $division == -10 || $division == -20) {
            $division = 1;
        }
       
        $divisionInfo = $this->common_model->getDivisionById($division);
     
        
        $schemids = explode(',',  $divisionInfo[0]['scheme_ids']);
    
        if(count($schemids) > 1){
			$this->ids = $schemids;
		}else{
			$schemstring = $divisionInfo[0]['scheme_ids'];
			$this->ids = $schemstring;
		}
      
        
    }
	
	
	
	function getNewApplicaitons()
    {
		$year = $this->uri->segment(3);
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];		 	
		$vars = $this->input->post();
		
		$result = $this->hqrs_model->getHqrsNewApplication($this->ids,$vars,$year);
		$totalResult = $this->hqrs_model->getHqrsTotalNewApplication($this->ids,$vars,$year);
		
		$response = array();
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				$gender = "";
				$output= array();	
				$output[] = $counter;
				$output[] = $applicationDetails[0]['fullname'];
				$output[] = $applicationDetails[0]['email'];
				$output[] = $r['application_no'];
						
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$course = $this->common_model->getCoursesById($applicationDetails[0]['course']);
					$course1 = $this->common_model->getCoursesById($applicationDetails[0]['course_two']);
					$course2 = $this->common_model->getCoursesById($applicationDetails[0]['course_three']);
					$fullCourse ="";
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'<br/>';
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'<br/>';
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'<br/>';
					$output[] = $fullCourse;
				}
				
				$universityDetails = "";
				$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				$universityDetails .= '1) '.$uni1[0]['name'].'<br/>';
				$universityDetails .= '2) '.$uni2[0]['name'].'<br/>';
				$universityDetails .= '3) '.$uni3[0]['name'].'<br/>';
				$output[] = $universityDetails;			
				$scheme = $this->common_model->getSchemeById($r['scholarship_id']);
				$output[] =	$scheme[0]['scheme_name'];		
				$output[] = $country[0]['country_name'];
				$output[] = date("Y-m-d", $r['created']);
				$output[] = '<a target="_blank"  href="'.site_url().'headquarter/applicationForm/'.$r['application_no'].'">Download</a>';
				$output[] = '<a target="_blank" href="'.site_url().'headquarter/contactForm/'.$r['application_no'].'">Download</a>';
				$response[] = $output;
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
    public function complaints() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 0 || $division == 1) {
                $data['complaints'] = $this->common_model->getAllComplaints($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/complaints', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
  public function ayushsfsprocess() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');

            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getAYUSHUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
            $data['listofacceptance'] = $this->common_model->applicantAcceptance($this->ids);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/ayushsfsprocess', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
    public function ayushprocess() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');

            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getAYUSHUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
            $data['listofacceptance'] = $this->common_model->applicantAcceptance($this->ids);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/ayushprocess', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function icarprocess() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');

            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
            $data['listofacceptance'] = $this->common_model->applicantAcceptance($this->ids);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/icarprocess', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function ayush_processed() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == -20) {
                $data['icar_applications'] = $this->common_model->getHQRSAYUSHProcessedApplication($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_processed', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }


 public function ayush_sfs_processed() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == -20) {
                $data['icar_applications'] = $this->common_model->getHQRSAYUSHProcessedApplicationsfs();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_sfs_processed', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
    public function ayush_applications() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == -20) {
                $data['ayush_applications'] = $this->common_model->getHQRSAYUSHApplication($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_applications', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	    public function ayush_received_applications() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];

            if ($division == -20) {
                $data['ayush_applications'] = $this->common_model->getHQRSAYUSHReceivedApplication();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_received_applications', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
    public function ayush_received_applications_2023() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];

            if ($division == -20) {
                $data['ayush_applications'] = $this->common_model->getHQRSAYUSHReceivedApplication2023();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_received_applications_2023', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
    public function ayush_received_applications_2024() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];

            if ($division == -20) {
                $data['ayush_applications'] = $this->common_model->getHQRSAYUSHReceivedApplication2024();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_received_applications_2024', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function ayush_received_applications_2025() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];

            if ($division == -20) {
                $data['ayush_applications'] = $this->common_model->getHQRSAYUSHReceivedApplication2025();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_received_applications_2025', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function ayush_received_applications_2026() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];

            if ($division == -20) {
                $data['ayush_applications'] = $this->common_model->getHQRSAYUSHReceivedApplication2026();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_received_applications_2026', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function ayush_sfs_applications() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == -20) {
                $data['ayush_sfs_applications'] = $this->common_model->getHQRSAYUSHApplicationsfs();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/ayush_sfs_applications', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
    public function icar_processed() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == -10) {
                $data['icar_applications'] = $this->common_model->getHqrsICARProcessedApplication();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/icar_processed', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function icar_applications() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == -10) {
                $data['icar_applications'] = $this->common_model->getHqrsICARApplication($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/icar_applications', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function getExpenditureDetails() {
        try {
            $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $schemmesArray = array();
            $regionalArray = array();
            $allAppId = $this->common_model->getAllExpenditureAppId();
            $allSchemes = $this->common_model->getAllSchemes();
            $allregions = $this->common_model->getAllRegions();
            $fy = $clean["fy"];
            $schemes = $clean["schemes"];
            $region = $clean["region"];
            $quarter = $clean["quarter"];
            $qrtMonth = $clean['qrtMonth'];
            foreach ($allregions as $regions) {
                if (!array_key_exists($regions['id'], $regionalArray)) {
                    $ar = array('id' => $regions['id'], "r" => $regions['name'], 'schemes' => array(), 'expenditure' => 0);
                    $regionalArray[$regions['id']] = $ar;

                    foreach ($allSchemes as $scheme) {
                        if (!array_key_exists($scheme['id'], $regionalArray[$regions['id']]['schemes'])) {
                            $ar = array('id' => $scheme['id'], "name" => $scheme['scheme_name'], 'code' => $scheme['code'], 'expenditure' => 0);
                            $regionalArray[$regions['id']]['schemes'][$scheme['id']] = $ar;
                        }
                    }
                }
            }
            foreach ($allSchemes as $scheme) {
                if (!array_key_exists($scheme['id'], $schemmesArray)) {
                    $ar = array('id' => $scheme['id'], 'name' => $scheme['scheme_name'], 'code' => $scheme['code'], 'expenditure' => 0);
                    $schemmesArray[$scheme['id']] = $ar;
                }
            }
            $aca = $this->common_model->getACAExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $advstipendDetails = $this->common_model->getAdvStipendExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $stipendDetails = $this->common_model->getStipendExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $hraDetails = $this->common_model->gethraExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $studyTourDetails = $this->common_model->getStudyTourExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $MRDetails = $this->common_model->getMedicalReimbrusmentExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $ThesisDetails = $this->common_model->getThesisExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $TravelDetails = $this->common_model->getTravelDetailsExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $tfDetails = $this->common_model->getTFExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $getEnglishBridgeByFY = $this->common_model->getEnglishBridgeExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $hostelDetails = $this->common_model->getHostelChargesExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $oreientDetails = $this->common_model->getOrientChargesExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $getCampsByFY = $this->common_model->getCampsExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $getISAByFY = $this->common_model->getISAExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $getSumptuaryByFY = $this->common_model->getSumptuaryExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $getEmergencyFundByFY = $this->common_model->getEmergencyFundExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);
            $getStudentDayByFY = $this->common_model->getStudentDayExpenditure($fy, $schemes, $region, $quarter, $qrtMonth);

            if (count($aca) > 0) {
                foreach ($aca as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($advstipendDetails) > 0) {
                foreach ($advstipendDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($stipendDetails) > 0) {
                foreach ($stipendDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($hraDetails) > 0) {
                foreach ($hraDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($studyTourDetails) > 0) {
                foreach ($studyTourDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($MRDetails) > 0) {
                foreach ($MRDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($ThesisDetails) > 0) {
                foreach ($ThesisDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($TravelDetails) > 0) {
                foreach ($TravelDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($tfDetails) > 0) {
                foreach ($tfDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($getEnglishBridgeByFY) > 0) {
                foreach ($getEnglishBridgeByFY as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($hostelDetails) > 0) {
                foreach ($hostelDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($oreientDetails) > 0) {
                foreach ($oreientDetails as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($getCampsByFY) > 0) {
                foreach ($getCampsByFY as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($getISAByFY) > 0) {
                foreach ($getISAByFY as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($getSumptuaryByFY) > 0) {
                foreach ($getSumptuaryByFY as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($getEmergencyFundByFY) > 0) {
                foreach ($getEmergencyFundByFY as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if (count($getStudentDayByFY) > 0) {
                foreach ($getStudentDayByFY as $exp) {
                    if ($exp['scheme'] != "") {
                        $schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                        $regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
                    }
                }
            }

            if ($schemes > 0) {
                $schemmesAr = array();
                $regionalAr = array();
                $schemmesAr[$schemes] = $schemmesArray[$schemes];
                if ($region > 0) {
                    $regionalAr[$region] = $regionalArray[$region];
                    $sr = $regionalArray[$region]['schemes'][$schemes];
                    $regionalAr[$region]['schemes'] = array();
                    $regionalAr[$region]['schemes'][$schemes] = $sr;
                } else {
                    foreach ($regionalArray as $key => $regionAr) {
                        $srr = array();
                        $srr = $regionAr['schemes'][$schemes];
                        $regionAr['schemes'] = array();
                        $regionalArray[$key]['schemes'] = $srr;
                    }
                }
                if ($region > 0) {
                    echo json_encode(array('region' => $regionalAr, 'schemes' => $schemmesAr));
                } else {
                    echo json_encode(array('region' => $regionalArray, 'schemes' => $schemmesAr));
                }
            } else {
                $regionalAr = array();
                if ($region > 0) {
                    $regionalAr[$region] = $regionalArray[$region];
                    echo json_encode(array('region' => $regionalAr, 'schemes' => $schemmesArray));
                } else {
                    echo json_encode(array('region' => $regionalArray, 'schemes' => $schemmesArray));
                }
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
public function forwardtohqrssfs() {
        try {
            $user_data = $this->session->userdata('user_data');
            $name = "";
            $appno = $this->uri->segment(3);

            if (!empty($_FILES)) {
                $files = $_FILES['inputfile_regional'];
                $imgname = "";
                if ($files["name"] != "") {
                    $name = str_replace(" ", "_", $files['name']);
                    $imgname = time() . '_university_approval_' . $appno . '_' . $name;

                    $target_file = 'assets/site/main/university_approval/' . $imgname;
                    move_uploaded_file($_FILES["inputfile_regional"]["tmp_name"], $target_file);
                }
            }
            $regionsdata = $this->common_model->getUniversityStateById($this->input->post("universty_choice"));
            $data = array(
                'region_one_status' => $regionsdata[0]['state'],
                'region_one_status_date' => time(),
                'region_one_doc' => $imgname,
                'regional_university' => $this->input->post("universty_choice"),
                'university_is_accept' => $this->input->post("university_is_accept"),
                'application_id' => $appno,
                'status' => 9
            );
            $sts = $this->common_model->ForwardToHqrsFourthOption($data, $appno);
            if ($sts > 0) {
                $data1 = array(
                    'iccr_status' => 1,
                    'status' => 10,
					'scholarship_id'=>$this->input->post("scholarship")
                );
                $sts1 = $this->common_model->ConfirmationForwardToMissionByHqrs($data1, $appno);
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('success', 'Application Forwarded Successfully !');
                redirect(site_url() . 'headquarter/dashboard');
            } else {
                $this->session->set_flashdata('message_type', 'error');
                $this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
                redirect(site_url() . 'headquarter/dashboard');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
    public function forwardtohqrs() {
        try {
            $user_data = $this->session->userdata('user_data');
            $name = "";
            $appno = $this->uri->segment(3);

            if (!empty($_FILES)) {
                $files = $_FILES['inputfile_regional'];
                $imgname = "";
                if ($files["name"] != "") {
                    $name = str_replace(" ", "_", $files['name']);
                    $imgname = time() . '_university_approval_' . $appno . '_' . $name;

                    $target_file = 'assets/site/main/university_approval/' . $imgname;
                    move_uploaded_file($_FILES["inputfile_regional"]["tmp_name"], $target_file);
                }
            }
            $regionsdata = $this->common_model->getUniversityStateById($this->input->post("universty_choice"));
            $data = array(
                'region_one_status' => $regionsdata[0]['state'],
                'region_one_status_date' => time(),
                'region_one_doc' => $imgname,
                'regional_university' => $this->input->post("universty_choice"),
                'university_is_accept' => $this->input->post("university_is_accept"),
                'application_id' => $appno,
                'status' => 9,
                'course' => $this->input->post("course"),
            );
            $sts = $this->common_model->ForwardToHqrsFourthOption($data, $appno);
            if ($sts > 0) {
                $data1 = array(
                    'iccr_status' => 1,
                    'status' => 10
                );
                $sts1 = $this->common_model->ConfirmationForwardToMissionByHqrs($data1, $appno);
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('success', 'Application Forwarded Successfully !');
                redirect(site_url() . 'headquarter/dashboard');
            } else {
                $this->session->set_flashdata('message_type', 'error');
                $this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
                redirect(site_url() . 'headquarter/dashboard');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
public function forwardAyuushtohqrs() {
        try {
            $user_data = $this->session->userdata('user_data');
            $name = "";
            $appno = $this->uri->segment(3);
            if (!empty($_FILES)) {
                $files = $_FILES['inputfile_regional'];
                $imgname = "";
                if ($files["name"] != "") {
                    $name = str_replace(" ", "_", $files['name']);
                    $imgname = time() . '_university_approval_' . $appno . '_' . $name;

                    $target_file = 'assets/site/main/university_approval/' . $imgname;
                    move_uploaded_file($_FILES["inputfile_regional"]["tmp_name"], $target_file);
                }
            }
            $regionsdata = $this->common_model->getUniversityStateById($this->input->post("universty_choice"));
            $data = array(
                'region_one_status' => $regionsdata[0]['state'],
                'region_one_status_date' => time(),
                'region_one_doc' => $imgname,
                'regional_university' => $this->input->post("universty_choice"),
                'university_is_accept' => $this->input->post("university_is_accept"),
                'application_id' => $appno,
                'status' => 9,
                'course' => $this->input->post("course"),
            );
            $sts = $this->common_model->ForwardToHqrsFourthOption($data, $appno);
            if ($sts > 0) {
                $data1 = array(
                    'iccr_status' => 1,
                    'status' => 10,
					'scholarship_id'=>$this->input->post('scheme_id'),
                );
				
		
                $sts1 = $this->common_model->ConfirmationForwardToMissionByHqrs($data1, $appno);
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('success', 'Application Forwarded Successfully !');
                redirect(site_url() . 'headquarter/dashboard');
            } else {
                $this->session->set_flashdata('message_type', 'error');
                $this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
                redirect(site_url() . 'headquarter/dashboard');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
		
		
		
    }
    public function status() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');

            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
            $data['accepteduniversity'] = $this->common_model->getconfirmationData($applicationId);
            
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/status', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
public function universityAyushLetter()
	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);

		// Same guard as universityLetter(): no application, no letter.
		if(!is_array($stepOne) || count($stepOne) == 0)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'No application found for '.$applicationId.'.');
			redirect(site_url().'headquarter/dashboard');
			return;
		}

		$this->load->file('fpdi/PdfHTMLTable.php');
		// Unused mpdf60 load removed - see the explanation in universityLetter().
		// This method also builds its PDF entirely with PdfHTMLTable (FPDF), so
		// instantiating mPDF only pulled the server's broken font installation
		// into the request and killed it with a blank 500.
		$pdf = new PdfHTMLTable();
		$pdf->AddPage('P');
		$pdf->SetXY(10.0,5.0);
		$pdf->SetDisplayMode('fullwidth');
		$pdf->SetLeftMargin(15.0);
		$pdf->SetFont('Arial','',7);
		$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
		$pdf->MultiCell(180,5,'Date: '.date('d M Y h:i:s'),'','R');

		// Academic year, reference number and addressee are handled exactly as
		// in universityLetter() - see the comments there for why each was wrong.
		$acadYear = isset($stepOne[0]['acedemic_year']) ? trim((string) $stepOne[0]['acedemic_year']) : '';
		if($acadYear === '')
		{
			$thisYear = (int) date('Y');
			$acadYear = $thisYear.'-'.substr((string) ($thisYear + 1), -2);
		}
		$acadYearWords = $acadYear;
		if(preg_match('/^(\d{4})\s*-\s*(\d{2,4})$/', $acadYear, $m))
		{
			$acadEnd = (strlen($m[2]) == 2) ? substr($m[1], 0, 2).$m[2] : $m[2];
			$acadYearWords = $m[1].' to '.$acadEnd;
		}

		$pdf->SetXY(10.0,45.0);
		$pdf->SetTitle('Indian Council For Cultural Relations',false);
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(2);
		$pdf->MultiCell(180,5,'Ref No  '.$applicationId.'/'.$acadYear,'','L');
		$pdf->Ln(3);
		$pdf->MultiCell(180,5,'To,','','L');
		$addresseeId = 0;
		foreach(array('universty_choice','universty_choice_two','universty_choice_three','universty_choice_fourth','universty_choice_fifth') as $choiceCol)
		{
			if(!empty($stepOne[0][$choiceCol]))
			{
				$addresseeId = $stepOne[0][$choiceCol];
				break;
			}
		}
		$addresseeName = '';
		if($addresseeId)
		{
			$addresseeRow = $this->common_model->getUniversityById($addresseeId);
			if(is_array($addresseeRow) && count($addresseeRow) > 0 && isset($addresseeRow[0]['name']))
			{
				$addresseeName = trim((string) $addresseeRow[0]['name']);
			}
		}
		if($addresseeName !== '')
		{
			$pdf->MultiCell(180,5,'The Registrar,','','L');
			$pdf->MultiCell(180,5,$addresseeName,'','L');
			$pdf->Ln(10);
		}
		else
		{
			$pdf->Ln(20);
		}
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(180,5,'Subject : Request for the admission of International Students for the Academic Year '.$acadYearWords,'','L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(180,5,'Dear Sir/Madam,','','L');		
		
		$pdf->MultiCell(170,5,'The Indian Council for Cultural Relations (Ministry of External Affairs) proposes to award scholarship to:','','J');						
		$pdf->Ln(5);
		$uniid = array();
		if($stepOne[0]['university_choice_one_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice']);
			//$uniid = $stepOne[0]['universty_choice'];
		}
		if($stepOne[0]['university_choice_two_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice_two']);
			//$uniid = $stepOne[0]['universty_choice_two'];
		}
		if($stepOne[0]['university_choice_three_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice_three']);
			//$uniid = $stepOne[0]['universty_choice_three'];
		}
		if($stepOne[0]['university_choice_fourth_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice_fourth']);
			//$uniid = $stepOne[0]['universty_choice_three'];
		}
		// Same country/scheme handling as universityLetter() - see the comment
		// there. 'country' is empty on these records; the rest of the system
		// resolves the applicant's country from 'postal_address_country'.
		$countryId = '';
		if(!empty($stepOne[0]['postal_address_country']))
		{
			$countryId = $stepOne[0]['postal_address_country'];
		}
		elseif(!empty($stepOne[0]['country']))
		{
			$countryId = $stepOne[0]['country'];
		}
		$country = $countryId !== '' ? $this->common_model->getCountryById($countryId) : array();
		$countryName = (is_array($country) && count($country) > 0 && isset($country[0]['country_name'])) ? $country[0]['country_name'] : '';

		$schemeId = $this->common_model->getMappingData($applicationId);
		$schemename = (is_array($schemeId) && count($schemeId) > 0 && isset($schemeId[0]['scholarship_id']))
			? $this->common_model->getSchemeById($schemeId[0]['scholarship_id'])
			: array();
		$schemeNameText = (is_array($schemename) && count($schemename) > 0 && isset($schemename[0]['scheme_name'])) ? $schemename[0]['scheme_name'] : '';

		if($countryName == "Afghanistan")
		{
			$pdf->MultiCell(175,5,'Name                     : '.$stepOne[0]['fullname'],'','L');
			$pdf->Ln(2);	
			$pdf->MultiCell(175,5,'Fathers Name        : '.$stepOne[0]['guardian_name'],'','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,'Country                  : '.$countryName,'','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,'Scheme                 : '.$schemeNameText,'','L');
			$pdf->Ln(2);
			$courseDetails = 'Course    : ';
			if(count($uniid)>1)
			{
				foreach($uniid as $unid)
				{
					$course1=$this->common_model->getCourseDetails($applicationId,$unid);
					// Guarded for the same reason as the single-choice branch
					// below: a university id with no matching course row made
					// this a fatal error on PHP 8 rather than a blank entry.
					if(is_array($course1))
					{
						$courseName = $this->_courseNameToText(isset($course1['course_name']) ? $course1['course_name'] : '');
						$courseSubj = $this->_courseNameToText(isset($course1['subject']) ? $course1['subject'] : '');
						if($courseName !== '')
						{
							$courseDetails = $courseDetails.$courseName.($courseSubj !== '' ? ' ('.$courseSubj.')' : '').', ';
						}
					}
				}
			}
			else
			{
				// $uniid is only filled for university choices whose state
				// matches the logged-in user's state, so it is frequently
				// EMPTY - count($uniid) <= 1 reaches this branch at zero as
				// well as one. Reading $uniid[0] then produced an undefined
				// index, getCourseDetails() returned no usable row, and
				// $course1['course_name'] raised a fatal error on PHP 8,
				// blanking the letter. Fall back to the first university
				// choice on the application so the letter still names a
				// course, and only add the text once it is known good.
				$courseUniId = isset($uniid[0]) ? $uniid[0] : (isset($stepOne[0]['universty_choice']) ? $stepOne[0]['universty_choice'] : 0);
				$course1 = $this->common_model->getCourseDetails($applicationId,$courseUniId);
				if(is_array($course1))
				{
					$courseName = $this->_courseNameToText(isset($course1['course_name']) ? $course1['course_name'] : '');
					$courseSubj = $this->_courseNameToText(isset($course1['subject']) ? $course1['subject'] : '');
					$courseDetails = $courseDetails.$courseName.($courseSubj !== '' ? ' ('.$courseSubj.')' : '');
				}
			}
				
			$pdf->MultiCell(175,5,'Embassy Ref No.  : ','','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,$courseDetails ,'','L');
		}
		else
		{
			$pdf->MultiCell(175,5,'Name     : '.$stepOne[0]['fullname'],'','L');				
			$pdf->MultiCell(175,5,'Country  : '.$countryName,'','L');
			$pdf->MultiCell(175,5,'Scheme  : '.$schemeNameText,'','L');
			$course=$this->common_model->getCoursesById($stepOne[0]['course']);			
			$courseDetails = 'Course    : ';		
			if(count($uniid)>1)
			{
				foreach($uniid as $unid)
				{
					$course1=$this->common_model->getCourseDetails($applicationId,$unid);
					// Guarded for the same reason as the single-choice branch
					// below: a university id with no matching course row made
					// this a fatal error on PHP 8 rather than a blank entry.
					if(is_array($course1))
					{
						$courseName = $this->_courseNameToText(isset($course1['course_name']) ? $course1['course_name'] : '');
						$courseSubj = $this->_courseNameToText(isset($course1['subject']) ? $course1['subject'] : '');
						if($courseName !== '')
						{
							$courseDetails = $courseDetails.$courseName.($courseSubj !== '' ? ' ('.$courseSubj.')' : '').', ';
						}
					}
					
				}
			}
			else
			{
				// $uniid is only filled for university choices whose state
				// matches the logged-in user's state, so it is frequently
				// EMPTY - count($uniid) <= 1 reaches this branch at zero as
				// well as one. Reading $uniid[0] then produced an undefined
				// index, getCourseDetails() returned no usable row, and
				// $course1['course_name'] raised a fatal error on PHP 8,
				// blanking the letter. Fall back to the first university
				// choice on the application so the letter still names a
				// course, and only add the text once it is known good.
				$courseUniId = isset($uniid[0]) ? $uniid[0] : (isset($stepOne[0]['universty_choice']) ? $stepOne[0]['universty_choice'] : 0);
				$course1 = $this->common_model->getCourseDetails($applicationId,$courseUniId);
				if(is_array($course1))
				{
					$courseName = $this->_courseNameToText(isset($course1['course_name']) ? $course1['course_name'] : '');
					$courseSubj = $this->_courseNameToText(isset($course1['subject']) ? $course1['subject'] : '');
					$courseDetails = $courseDetails.$courseName.($courseSubj !== '' ? ' ('.$courseSubj.')' : '');
				}
			}
			
			$pdf->MultiCell(175,5,$courseDetails ,'','L');
		}
		
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Copy of his/her application along with copies of certificates and marks sheet are enclosed herewith for your perusal.  The applicant would be awarded scholarship by ICCR provided he/she is accepted for admission to the said course at your University/Institute.','','J');		
		$pdf->Ln(5);		
		$pdf->MultiCell(170,5,'Kindly confirm his/her admission at the earliest along and also confirm whether Hostel accommodation would be provided to the student.','','J');	
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Name of the College may also be mentioned if possible in the confirmation letter. ICCR will pay the tuition fee, admission fee & other compulsory fees (excluding refundable caution/security money etc.) and hostel charges to the University/Institute after receiving the joining report of the applicant countersigned by the appropriate authority in the University/Institute. ','','J');	
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'If admission is confirmed kindly indicate last date by which candidate is required to join the course, allowing him/her at least one/two months preparation time to obtain visas & make necessary travel arrangements for India.','','J');
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Please note that in case of scholar pursuing science courses the expenditure on chemicals and other related incidental charges will be borne by the scholar himself/herself.  ','','J');
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'We would appreciate receiving confirmation as early as possible.','','L');
		$pdf->Ln(2);
		$pdf->MultiCell(170,5,'Thanking you,','','C');	
		$pdf->MultiCell(170,5,'Yours faithfully,','','R');		
		$pdf->Ln(8);		
		$pdf->MultiCell(170,5,'Regional Director','','R');
		$pdf->Ln(2);	
		$pdf->MultiCell(170,5,'Date: '.date('d M Y'),'','L');
		
		$filename = $applicationId."_University_Letter_".date('jS-F-Y-h-i-s').'.pdf';
		// "I" sends Content-Disposition: inline, so the letter opens in the
		// browser's built-in PDF viewer at this URL instead of downloading as a
		// file. "D" (attachment) forced a download and closed the tab straight
		// away, which meant staff had to open the file from disk just to check
		// it. The filename is still sent, so "Save as" from the viewer keeps the
		// same name. The arguments are also now in FPDF's declared order,
		// Output($dest, $name); the previous call passed them reversed and
		// relied on FPDF silently swapping them.
		$pdf->Output("I", $filename);
	}
// The blank HTTP 500 on this URL was a compile error in
	// application/libraries/fpdi/htmlparser.inc (curly-brace string offset,
	// removed in PHP 8) - see the comment at line 225 of that file. The
	// diagnostic wrapper that found it has been removed.
	//
	// The try/catch is kept deliberately: PDF generation reaches into old
	// FPDF code, and a failure here should show staff a message on the
	// listing page rather than a white screen.
	public function universityLetter()
	{
		try
		{
			$this->_universityLetterBuild();
		}
		catch (Throwable $e)
		{
			log_message('error', 'universityLetter failed: '.get_class($e).': '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'The university letter could not be generated for this application.');
			redirect(site_url().'headquarter/ayush_processed');
			return;
		}
	}

	// getCourseDetails() does not return a consistent shape. For most
	// programme types it sets $response['course_name'] to a plain string, but
	// for programme 1/2/4/8/12/13 with course_type 1 or 2 it sets it to an
	// ARRAY of five course titles (Common_model.php lines 518 and 570). The
	// letter concatenated that value straight into the text, so those
	// applicants got the literal word "Array" printed where their course
	// should be. This flattens either shape into readable text and drops the
	// empty slots, since most applicants name fewer than five choices.
	private function _courseNameToText($courseName)
	{
		if(is_array($courseName))
		{
			$parts = array();
			foreach($courseName as $one)
			{
				if(is_array($one)) { continue; }
				$one = trim((string) $one);
				if($one !== '') { $parts[] = $one; }
			}
			return implode(', ', $parts);
		}
		return trim((string) $courseName);
	}

	private function _universityLetterBuild()
	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);

		// If the application number does not exist there is nothing to build a
		// letter from. Without this check the code below indexed $stepOne[0] on
		// an empty result and died with a fatal error and a blank page.
		if(!is_array($stepOne) || count($stepOne) == 0)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'No application found for '.$applicationId.'.');
			redirect(site_url().'headquarter/dashboard');
			return;
		}

		$this->load->file('fpdi/PdfHTMLTable.php');
		// The mpdf60 library was loaded here but never used - this letter is
		// built entirely with PdfHTMLTable (FPDF) and finishes with
		// $pdf->Output() on that object - so the unused load has been removed.
		$pdf = new PdfHTMLTable();
		$pdf->AddPage('P');
		$pdf->SetXY(10.0,5.0);
		$pdf->SetDisplayMode('fullwidth');
		$pdf->SetLeftMargin(15.0);
		$pdf->SetFont('Arial','',7);
		$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
		$pdf->MultiCell(180,5,'Date: '.date('d M Y h:i:s'),'','R');

		// The academic year was hard-coded as "2020 to 2021" and "/2020-21" in
		// the three places below, so every letter printed since 2021 has stated
		// the wrong year. The application record carries the real value in
		// acedemic_year (the column name is misspelled in the schema), which
		// for this scheme reads like "2026-27". Fall back to the current cycle
		// only if the record has no value, so the letter is never blank.
		$acadYear = isset($stepOne[0]['acedemic_year']) ? trim((string) $stepOne[0]['acedemic_year']) : '';
		if($acadYear === '')
		{
			$thisYear = (int) date('Y');
			$acadYear = $thisYear.'-'.substr((string) ($thisYear + 1), -2);
		}
		// "2026-27" also has to read as "2026 to 2027" in the subject line.
		$acadYearWords = $acadYear;
		if(preg_match('/^(\d{4})\s*-\s*(\d{2,4})$/', $acadYear, $m))
		{
			$acadEnd = (strlen($m[2]) == 2) ? substr($m[1], 0, 2).$m[2] : $m[2];
			$acadYearWords = $m[1].' to '.$acadEnd;
		}

		$pdf->SetXY(10.0,45.0);
		$pdf->SetTitle('Indian Council For Cultural Relations',false);
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(2);
		// The reference number was printed as an empty space before the year.
		// Use the application number, which already appears top-right, so the
		// letter is traceable back to the record.
		$pdf->MultiCell(180,5,'Ref No  '.$applicationId.'/'.$acadYear,'','L');
		$pdf->Ln(3);
		// The letter printed "To," followed by 20mm of blank space: it is a
		// letter addressed TO a university, but it never named one. Print the
		// university this letter concerns - the applicant's first recorded
		// choice - so the recipient is on the document.
		$pdf->MultiCell(180,5,'To,','','L');
		$addresseeId = 0;
		foreach(array('universty_choice','universty_choice_two','universty_choice_three','universty_choice_fourth','universty_choice_fifth') as $choiceCol)
		{
			if(!empty($stepOne[0][$choiceCol]))
			{
				$addresseeId = $stepOne[0][$choiceCol];
				break;
			}
		}
		$addresseeName = '';
		if($addresseeId)
		{
			$addresseeRow = $this->common_model->getUniversityById($addresseeId);
			if(is_array($addresseeRow) && count($addresseeRow) > 0 && isset($addresseeRow[0]['name']))
			{
				$addresseeName = trim((string) $addresseeRow[0]['name']);
			}
		}
		if($addresseeName !== '')
		{
			$pdf->MultiCell(180,5,'The Registrar,','','L');
			$pdf->MultiCell(180,5,$addresseeName,'','L');
			$pdf->Ln(10);
		}
		else
		{
			// No university on the record - keep the original blank space so
			// the address can still be written in by hand.
			$pdf->Ln(20);
		}
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(180,5,'Subject : Request for the admission of International Students for the Academic Year '.$acadYearWords,'','L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(180,5,'Dear Sir/Madam,','','L');		
		
		$pdf->MultiCell(170,5,'The Indian Council for Cultural Relations (Ministry of External Affairs) proposes to award scholarship to:','','J');						
		$pdf->Ln(5);
		$uniid = array();
		if($stepOne[0]['university_choice_one_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice']);
			//$uniid = $stepOne[0]['universty_choice'];
		}
		if($stepOne[0]['university_choice_two_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice_two']);
			//$uniid = $stepOne[0]['universty_choice_two'];
		}
		if($stepOne[0]['university_choice_three_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice_three']);
			//$uniid = $stepOne[0]['universty_choice_three'];
		}
		if($stepOne[0]['university_choice_fourth_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice_fourth']);
			//$uniid = $stepOne[0]['universty_choice_three'];
		}
		// The Country line printed blank on the letter. This read the 'country'
		// column, but the application screens resolve the applicant's country
		// from 'postal_address_country' (see viewFullApplication.php line 374),
		// and 'country' is empty on these records. Try the column the rest of
		// the system uses, and fall back to the old one so nothing that did
		// work before stops working.
		$countryId = '';
		if(!empty($stepOne[0]['postal_address_country']))
		{
			$countryId = $stepOne[0]['postal_address_country'];
		}
		elseif(!empty($stepOne[0]['country']))
		{
			$countryId = $stepOne[0]['country'];
		}
		$country = $countryId !== '' ? $this->common_model->getCountryById($countryId) : array();
		$countryName = (is_array($country) && count($country) > 0 && isset($country[0]['country_name'])) ? $country[0]['country_name'] : '';

		$schemeId = $this->common_model->getMappingData($applicationId);
		$schemename = (is_array($schemeId) && count($schemeId) > 0 && isset($schemeId[0]['scholarship_id']))
			? $this->common_model->getSchemeById($schemeId[0]['scholarship_id'])
			: array();
		$schemeNameText = (is_array($schemename) && count($schemename) > 0 && isset($schemename[0]['scheme_name'])) ? $schemename[0]['scheme_name'] : '';

		if($countryName == "Afghanistan")
		{
			$pdf->MultiCell(175,5,'Name                     : '.$stepOne[0]['fullname'],'','L');
			$pdf->Ln(2);	
			$pdf->MultiCell(175,5,'Fathers Name        : '.$stepOne[0]['guardian_name'],'','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,'Country                  : '.$countryName,'','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,'Scheme                 : '.$schemeNameText,'','L');
			$pdf->Ln(2);
			$courseDetails = 'Course    : ';
			if(count($uniid)>1)
			{
				foreach($uniid as $unid)
				{
					$course1=$this->common_model->getCourseDetails($applicationId,$unid);
					// Guarded for the same reason as the single-choice branch
					// below: a university id with no matching course row made
					// this a fatal error on PHP 8 rather than a blank entry.
					if(is_array($course1))
					{
						$courseName = $this->_courseNameToText(isset($course1['course_name']) ? $course1['course_name'] : '');
						$courseSubj = $this->_courseNameToText(isset($course1['subject']) ? $course1['subject'] : '');
						if($courseName !== '')
						{
							$courseDetails = $courseDetails.$courseName.($courseSubj !== '' ? ' ('.$courseSubj.')' : '').', ';
						}
					}
				}
			}
			else
			{
				// $uniid is only filled for university choices whose state
				// matches the logged-in user's state, so it is frequently
				// EMPTY - count($uniid) <= 1 reaches this branch at zero as
				// well as one. Reading $uniid[0] then produced an undefined
				// index, getCourseDetails() returned no usable row, and
				// $course1['course_name'] raised a fatal error on PHP 8,
				// blanking the letter. Fall back to the first university
				// choice on the application so the letter still names a
				// course, and only add the text once it is known good.
				$courseUniId = isset($uniid[0]) ? $uniid[0] : (isset($stepOne[0]['universty_choice']) ? $stepOne[0]['universty_choice'] : 0);
				$course1 = $this->common_model->getCourseDetails($applicationId,$courseUniId);
				if(is_array($course1))
				{
					$courseName = $this->_courseNameToText(isset($course1['course_name']) ? $course1['course_name'] : '');
					$courseSubj = $this->_courseNameToText(isset($course1['subject']) ? $course1['subject'] : '');
					$courseDetails = $courseDetails.$courseName.($courseSubj !== '' ? ' ('.$courseSubj.')' : '');
				}
			}
				
			$pdf->MultiCell(175,5,'Embassy Ref No.  : ','','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,$courseDetails ,'','L');
		}
		else
		{
			$pdf->MultiCell(175,5,'Name     : '.$stepOne[0]['fullname'],'','L');				
			$pdf->MultiCell(175,5,'Country  : '.$countryName,'','L');
			$pdf->MultiCell(175,5,'Scheme  : '.$schemeNameText,'','L');
			$course=$this->common_model->getCoursesById($stepOne[0]['course']);			
			$courseDetails = 'Course    : ';		
			if(count($uniid)>1)
			{
				foreach($uniid as $unid)
				{
					$course1=$this->common_model->getCourseDetails($applicationId,$unid);
					// Guarded for the same reason as the single-choice branch
					// below: a university id with no matching course row made
					// this a fatal error on PHP 8 rather than a blank entry.
					if(is_array($course1))
					{
						$courseName = $this->_courseNameToText(isset($course1['course_name']) ? $course1['course_name'] : '');
						$courseSubj = $this->_courseNameToText(isset($course1['subject']) ? $course1['subject'] : '');
						if($courseName !== '')
						{
							$courseDetails = $courseDetails.$courseName.($courseSubj !== '' ? ' ('.$courseSubj.')' : '').', ';
						}
					}
					
				}
			}
			else
			{
				// $uniid is only filled for university choices whose state
				// matches the logged-in user's state, so it is frequently
				// EMPTY - count($uniid) <= 1 reaches this branch at zero as
				// well as one. Reading $uniid[0] then produced an undefined
				// index, getCourseDetails() returned no usable row, and
				// $course1['course_name'] raised a fatal error on PHP 8,
				// blanking the letter. Fall back to the first university
				// choice on the application so the letter still names a
				// course, and only add the text once it is known good.
				$courseUniId = isset($uniid[0]) ? $uniid[0] : (isset($stepOne[0]['universty_choice']) ? $stepOne[0]['universty_choice'] : 0);
				$course1 = $this->common_model->getCourseDetails($applicationId,$courseUniId);
				if(is_array($course1))
				{
					$courseName = $this->_courseNameToText(isset($course1['course_name']) ? $course1['course_name'] : '');
					$courseSubj = $this->_courseNameToText(isset($course1['subject']) ? $course1['subject'] : '');
					$courseDetails = $courseDetails.$courseName.($courseSubj !== '' ? ' ('.$courseSubj.')' : '');
				}
			}
			
			$pdf->MultiCell(175,5,$courseDetails ,'','L');
		}
		
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Copy of his/her application along with copies of certificates and marks sheet are enclosed herewith for your perusal.  The applicant would be awarded scholarship by ICCR provided he/she is accepted for admission to the said course at your University/Institute.','','J');		
		$pdf->Ln(5);		
		$pdf->MultiCell(170,5,'Kindly confirm his/her admission at the earliest along and also confirm whether Hostel accommodation would be provided to the student.','','J');	
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Name of the College may also be mentioned if possible in the confirmation letter. ICCR will pay the tuition fee, admission fee & other compulsory fees (excluding refundable caution/security money etc.) and hostel charges to the University/Institute after receiving the joining report of the applicant countersigned by the appropriate authority in the University/Institute. ','','J');	
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'If admission is confirmed kindly indicate last date by which candidate is required to join the course, allowing him/her at least one/two months preparation time to obtain visas & make necessary travel arrangements for India.','','J');
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Please note that in case of scholar pursuing science courses the expenditure on chemicals and other related incidental charges will be borne by the scholar himself/herself.  ','','J');
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'We would appreciate receiving confirmation as early as possible.','','L');
		$pdf->Ln(2);
		$pdf->MultiCell(170,5,'Thanking you,','','C');	
		$pdf->MultiCell(170,5,'Yours faithfully,','','R');		
		$pdf->Ln(8);		
		$pdf->MultiCell(170,5,'Regional Director','','R');
		$pdf->Ln(2);	
		$pdf->MultiCell(170,5,'Date: '.date('d M Y'),'','L');
		
		$filename = $applicationId."_University_Letter_".date('jS-F-Y-h-i-s').'.pdf';
		// "I" sends Content-Disposition: inline, so the letter opens in the
		// browser's built-in PDF viewer at this URL instead of downloading as a
		// file. "D" (attachment) forced a download and closed the tab straight
		// away, which meant staff had to open the file from disk just to check
		// it. The filename is still sent, so "Save as" from the viewer keeps the
		// same name. The arguments are also now in FPDF's declared order,
		// Output($dest, $name); the previous call passed them reversed and
		// relied on FPDF silently swapping them.
		$pdf->Output("I", $filename);
	}
    public function universityResponse() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');

            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
            $data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/universityResponse', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function getReports() {
        try {
            $list = $this->common_model->get_datatables($this->ids);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $customers->fullname;
                $row[] = $customers->email;
                if ($customers->gender == 1) {
                    $row[] = "Male";
                } elseif ($customers->gender == 2) {
                    $row[] = "Female";
                }
                $row[] = $customers->country_name;
                $uni = $this->common_model->getUniversityById($customers->universty_choice);
                $uni1 = $this->common_model->getUniversityById($customers->universty_choice_two);
                $uni2 = $this->common_model->getUniversityById($customers->universty_choice_three);
                $r = "";
                $reg1 = $this->common_model->getRegionById($uni[0]['state']);
                $reg2 = $this->common_model->getRegionById($uni1[0]['state']);
                $reg3 = $this->common_model->getRegionById($uni2[0]['state']);

                if ($uni[0]['state'] == $this->input->post("Region")) {
                    $r .= '<b>' . $reg1[0]['name'] . '</b><br/>';
                } else {
                    $r .= $reg1[0]['name'] . '<br/>';
                }
                if ($uni1[0]['state'] == $this->input->post("Region")) {
                    $r .= '<b>' . $reg2[0]['name'] . '</b><br/>';
                } else {
                    $r .= $reg2[0]['name'] . '<br/>';
                }
                if ($uni2[0]['state'] == $this->input->post("Region")) {
                    $r .= '<b>' . $reg3[0]['name'] . '</b><br/>';
                } else {
                    $r .= $reg3[0]['name'] . '<br/>';
                }
                $row[] = $r;
                $course = $this->common_model->getCoursesById($customers->course);
                $row[] = $course[0]['title'];

                $u = "";
                if ($customers->universty_choice == $this->input->post("Universtiy")) {
                    $u .= '<b>' . $uni[0]['name'] . '</b><br/>';
                } else {
                    $u .= $uni[0]['name'] . '<br/>';
                }
                if ($customers->universty_choice_two == $this->input->post("Universtiy")) {
                    $u .= '<b>' . $uni1[0]['name'] . '</b><br/>';
                } else {
                    $u .= $uni1[0]['name'] . '<br/>';
                }
                if ($customers->universty_choice_three == $this->input->post("Universtiy")) {
                    $u .= '<b>' . $uni2[0]['name'] . '</b><br/>';
                } else {
                    $u .= $uni2[0]['name'] . '<br/>';
                }
                if ($u != "") {

                    $row[] = $u;
                } else {
                    $row[] = "NA";
                }
                $scheme = $this->common_model->getSchemeById($customers->scholarship_id);
                if ($scheme[0]['scheme_name'] != "") {
                    $row[] = $scheme[0]['scheme_name'];
                } else {
                    $row[] = "NA";
                }
                $sts = $this->common_model->getApplicationUnderStatus($customers->status);
                $row[] = $sts[0]['status'];
				$row[] = date("Y-m-d",$customers->created);
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->common_model->count_all(),
                "recordsFiltered" => $this->common_model->count_filtered($this->ids),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function getCourseByPrgrammeold() {
        $response = array('status' => FALSE, 'data' => array(), 'csrfName' => '', 'csrfHash' => '');
        try {
            $id = $this->input->post('programme');
            $courses = $this->common_model->getCourseByPrgramme($id);

            if (count($courses) > 0) {
                $response['status'] = TRUE;
                foreach ($courses as $row) {
                    $response['data'][] = $row;
                }
            }
        } catch (Exception $e) {
            echo json_encode($response);
        }
        echo json_encode($response);
    }

    public function studentDetails() {
        try {
            $divs = array(2, 3, 4, 5, 6, 7, 8, 9, 10);
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if (in_array($division, $divs)) {
               
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/studentDetails');
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function reports() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division > 0) {
                $data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
                $data['schemes'] = $this->ids;
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/reports', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function expenditurereports() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division > 0) {
                $current = date('Y-m-d', strtotime('-2 years'));
                $data['fy'] = $this->getFinancialYears($current, 4);
                $data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/expenditureReports', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function demands() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 0 || $division == 1) {
                $data['demands'] = $this->common_model->getAllDemands();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/demands', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function processDemand() {
        try {
            $data['demandId'] = $this->uri->segment(3);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/createdemand', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function processeddemands() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 0 || $division == 1) {
                $data['demands'] = $this->common_model->getAllProcessedDemands();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/processeddemands', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function updateDemand() {
        try {
            $demadArray = array();
            $user_data = $this->session->userdata('user_data');
            $demandId = $this->uri->segment(3);
            $files = $_FILES['demand_doc'];
            if ($files["name"] != "") {
                $name = str_replace(" ", "_", $files['name']);
                $imgname = $demandId . '_' . time() . '_demands_' . $name;
                $target_file = 'assets/site/main/demands/' . $imgname;
                if (move_uploaded_file($_FILES["demand_doc"]["tmp_name"], $target_file)) {

                    $demadArray['demand_id'] = $demandId;
                    $demadArray['status_remarks'] = $this->input->post('remarks');
                    $demadArray['status'] = $this->input->post('status');
                    $demadArray['status_doc'] = $imgname;
                    $demadArray['status_date'] = time();
                    $sts = $this->common_model->updateDemand($demadArray);
                    if ($sts) {
                        $data['message']['type'] = 1;
                        $data['message']['text'] = "Demand Updated Successfully";
                        $data['message']['redirect'] = site_url() . 'regional/demands/';
                        $this->load->view("regional/msg", $data);
                    } else {
                        $data['message']['type'] = 2;
                        $data['message']['text'] = "Error Occur While Updating Demand";
                        $data['message']['redirect'] = site_url() . 'regional/demands/';
                        $this->load->view("regional/msg", $data);
                    }
                } else {
                    $data['message']['type'] = 2;
                    $data['message']['text'] = "Error Occur While Updating Demand";
                    $data['message']['redirect'] = site_url() . 'regional/demands/';
                    $this->load->view("regional/msg", $data);
                }
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function index() {

        try {

            $data['newapplication'] = $this->common_model->getHqrsNewApplication($this->ids);
            $data['underprocess'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
            $confapps = $this->common_model->getRegionalApplicationsConfirmationtoHqrs($this->ids);
            $confirms = 0;
            $notconfirms = 0;
            if (count($confapps) > 0) {
                foreach ($confapps as $app) {
                    $response = $this->common_model->getUniversityResponses($app['application_no']);
                    $resp = explode(',', $response[0]['response']);
                    if ($response[0]['response'] != "2,2,2") {
                        $confirms++;
                    } elseif ($response[0]['response'] == "2,2,2") {
                        $notconfirms++;
                    }
                }
            }
            $data['confirmationfromROs'] = $confirms;
            $data['confirmationfromallROs'] = $notconfirms;
            $data['acceptance'] = $this->common_model->applicantAcceptance($this->ids);
            $data['studentexpenditure'] = count($this->common_model->getAllStudentsApplications($this->ids));
            $data['demands'] = count($this->common_model->getAllDemands());
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/dashboard', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function addfund() {
        try {
            $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $this->form_validation->set_rules('fin_year', 'Financial Year', 'required');
            $this->form_validation->set_rules('regiion', 'Region', 'required');
            $this->form_validation->set_rules('quarter', 'Quarter', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $actual_link = $_SERVER['HTTP_REFERER'];
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message_type', 'error');
                $this->session->set_flashdata('error', 'Invalid Data!');
                redirect(site_url() . 'headquarter/fundmonitoring');
            }

            $updateData['financial_year'] = $clean['fin_year'];
            $updateData['regional_office'] = $clean['regiion'];
            $updateData['quarter'] = $clean['quarter'];
            $updateData['amount_released'] = $clean['amount'];
            $updateData['created'] = time();
            $fund = $this->common_model->isExistsFund($clean['fin_year'], $clean['regiion'], $clean['quarter']);
            if (count($fund) <= 0) {
                $status = $this->common_model->insertFund($updateData);
                if ($status) {
                    $this->session->set_flashdata('message_type', 'success');
                    $this->session->set_flashdata('success', 'Fund Updated to RO!');
                    redirect(site_url() . 'headquarter/fundmonitoring');
                } else {
                    $this->session->set_flashdata('message_type', 'error');
                    $this->session->set_flashdata('error', 'Some Error Occur While Updating Fund!');
                    redirect(site_url() . 'headquarter/fundmonitoring');
                }
            } else {
                $this->session->set_flashdata('message_type', 'error');
                $this->session->set_flashdata('error', 'Fund Already Sent for This Quarter to RO!');
                redirect(site_url() . 'headquarter/fundmonitoring');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function downloadFundMonitoringList() {
        try {
            $appno = $this->uri->segment(3);
            $content = $this->input->post("myHTML");
            $this->load->library('mpdf60/Mpdf');
            $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
            $mpdf->SetFont('Arial', 'B', 12);
            $mpdf->SetWatermarkText('Indian Council For Cultural Relations');
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Fund Monitoring List RO and Financial Year Wise</h3><br/>";
            $html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";
            $html = $content;
            $imgArray = $this->common_model->getUserImage($data[0]['uid']);

            $mpdf->SetDisplayMode('fullpage');
            // LOAD a stylesheet
            $stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css');

            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
            $mpdf->WriteHTML($stylesheet1, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css');
            $mpdf->WriteHTML($stylesheet2, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
            $mpdf->WriteHTML($stylesheet3, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
            $mpdf->WriteHTML($stylesheet4, 1); // The parameter 1 tells that this is css/style only and no body/html/text

            $stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
            $mpdf->WriteHTML($stylesheet5, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $mpdf->WriteHTML($html1, 2);
            $mpdf->WriteHTML($content);
            $mpdf->Output();
        } catch (HTML2PDF_exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
            exit;
        }
    }

    function viewExpenditureDetails() {
        try {
			
            $user_data = $this->session->userdata('user_data');
            $fy = $this->uri->segment(3);
			 $current = date('Y-m-d');
             $current1 = date('Y-m-d', strtotime('-3 years'));
             $data['fy'] = $this->getFinancialYears($current, 1);
             $data['ofy'] = $this->getFinancialYears($current1, 5);
            $yearArray = explode('-', $fy);
            $user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			$data['schemeName'] = $this->common_model->getScheme();
            $regionid = $this->uri->segment(4);
			
			
            $data['regionName'] = $this->common_model->getRegionById($regionid);
            $data['openingBalance'] = $this->common_model->isAlreadyUpdatedbalance($fy, $regionid);
            $data['advstipendDetails'] = $this->common_model->getAdvStipendByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['stipendDetails'] = $this->common_model->getStipendByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['hraDetails'] = $this->common_model->gethraByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['acaDetails'] = $this->common_model->getACAbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['studyTourDetails'] = $this->common_model->getStudyTourbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['MRDetails'] = $this->common_model->getMedicalReimbrusmentbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['ThesisDetails'] = $this->common_model->getThesisbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['MiscDetails'] = $this->common_model->getMiscbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['TravelDetails'] = $this->common_model->getTravelDetailsbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['ocfDetails'] = $this->common_model->getOCFByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['tfDetails'] = $this->common_model->getTFByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['miscUniDetails'] = $this->common_model->getMiscUniByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getEnglishBridgeByFY'] = $this->common_model->getEnglishBridgeByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['hostelDetails'] = $this->common_model->getHostelChargesByFY($yearArray[0], $yearArray[1], $regionid,$division);

            $data['oreientDetails'] = $this->common_model->getOrientChargesByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getCampsByFY'] = $this->common_model->getCampsByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getISAByFY'] = $this->common_model->getISAByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getSumptuaryByFY'] = $this->common_model->getSumptuaryByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getEmergencyFundByFY'] = $this->common_model->getEmergencyFundByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getStudentDayByFY'] = $this->common_model->getStudentDayByFY($yearArray[0], $yearArray[1], $regionid,$division);

            $data['totalFund'] = $this->common_model->getTotalFundtoRegionbyFY($regionid, $fy);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/viewExpenditureDetails', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	function viewExpenditureSchemeWiseDetails() {
        try {
			
            $user_data = $this->session->userdata('user_data');
			$vars = $this->input->post();
			$fyear = $vars['fin_year'];
			$regionid = $vars['region'];
			$division = $vars['schemes'];
			$current = date('Y-m-d');
            $current1 = date('Y-m-d', strtotime('-3 years'));
            $data['fy'] = $this->getFinancialYears($current, 1);
            $data['ofy'] = $this->getFinancialYears($current1, 5);
            $yearArray = explode('-', $fyear);
            $user_data = $this->session->userdata('user_data');
			$data['schemeName'] = $this->common_model->getScheme();
            $data['regionName'] = $this->common_model->getRegionById($regionid);
            $data['openingBalance'] = $this->common_model->isAlreadyUpdatedbalance($fyear, $regionid);
            $data['advstipendDetails'] = $this->common_model->getAdvStipendByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['stipendDetails'] = $this->common_model->getStipendByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['hraDetails'] = $this->common_model->gethraByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['acaDetails'] = $this->common_model->getACAbyFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['studyTourDetails'] = $this->common_model->getStudyTourbyFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['MRDetails'] = $this->common_model->getMedicalReimbrusmentbyFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['ThesisDetails'] = $this->common_model->getThesisbyFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['MiscDetails'] = $this->common_model->getMiscbyFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['TravelDetails'] = $this->common_model->getTravelDetailsbyFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['ocfDetails'] = $this->common_model->getOCFByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['tfDetails'] = $this->common_model->getTFByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['miscUniDetails'] = $this->common_model->getMiscUniByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getEnglishBridgeByFY'] = $this->common_model->getEnglishBridgeByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['hostelDetails'] = $this->common_model->getHostelChargesByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);

            $data['oreientDetails'] = $this->common_model->getOrientChargesByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getCampsByFY'] = $this->common_model->getCampsByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getISAByFY'] = $this->common_model->getISAByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getSumptuaryByFY'] = $this->common_model->getSumptuaryByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getEmergencyFundByFY'] = $this->common_model->getEmergencyFundByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getStudentDayByFY'] = $this->common_model->getStudentDayByFYScheme($yearArray[0], $yearArray[1], $regionid,$division);

            $data['totalFund'] = $this->common_model->getTotalFundtoRegionbyFY($regionid, $fy);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/viewExpenditureDetails', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
    public function fundmonitoring() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 0 || $division == 1 || $division == 2) {
                $current = date('Y-m-d', strtotime('-1 years'));
                $data['fy'] = $this->getFinancialYears($current, 9);
                $data['totalFund'] = $this->common_model->getTotalFundtoAllRegion();
				$fund = $this->common_model->getTotalFundtoAllRegion();
				$i=0;
				$dataaaray = array();
				foreach($fund as $fn){
					$yearArray = explode('-', $fn['FY']); 
					 $regionid = $fn['RO'];
					 
					 
					 
					 
            $data['advstipendDetails'] = $this->common_model->getAdvStipendByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['stipendDetails'] = $this->common_model->getStipendByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['hraDetails'] = $this->common_model->gethraByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['acaDetails'] = $this->common_model->getACAbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['studyTourDetails'] = $this->common_model->getStudyTourbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['MRDetails'] = $this->common_model->getMedicalReimbrusmentbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['ThesisDetails'] = $this->common_model->getThesisbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['MiscDetails'] = $this->common_model->getMiscbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['TravelDetails'] = $this->common_model->getTravelDetailsbyFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['ocfDetails'] = $this->common_model->getOCFByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['tfDetails'] = $this->common_model->getTFByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['miscUniDetails'] = $this->common_model->getMiscUniByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getEnglishBridgeByFY'] = $this->common_model->getEnglishBridgeByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['hostelDetails'] = $this->common_model->getHostelChargesByFY($yearArray[0], $yearArray[1], $regionid,$division);

            $data['oreientDetails'] = $this->common_model->getOrientChargesByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getCampsByFY'] = $this->common_model->getCampsByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getISAByFY'] = $this->common_model->getISAByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getSumptuaryByFY'] = $this->common_model->getSumptuaryByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getEmergencyFundByFY'] = $this->common_model->getEmergencyFundByFY($yearArray[0], $yearArray[1], $regionid,$division);
            $data['getStudentDayByFY'] = $this->common_model->getStudentDayByFY($yearArray[0], $yearArray[1], $regionid,$division);
					//Three Month Advance Stipned
					
						/* $First = (int)$data['advstipendDetails'][0]['First_Quarter'];
						$Second = (int)$data['advstipendDetails'][0]['Second_Quarter'];
						$Third = (int)$data['advstipendDetails'][0]['Third_Quareter'];
						$Fourth = (int)$data['advstipendDetails'][0]['Fourth_Quarter'];
						$finalAdvTotal = $First + $Second + $Third + $Fourth; */
						//echo "<pre>"; print_r($data['advstipendDetails']);
						//echo "<pre>"; print_r($data['advstipendDetails']);
						/* if($regionid=='23' && $fn['FY']=='2018-2019'){
							echo $fn['FY'].'<br/>';
							echo "<pre>"; print_r($data['advstipendDetails']);
							echo "<pre>"; print_r($data['stipendDetails']);
							echo "<pre>"; print_r($data['hraDetails']);
							echo "<pre>"; print_r($data['acaDetails']);
							echo "<pre>"; print_r($data['MRDetails']);
							echo "<pre>"; print_r($data['ThesisDetails']);
							echo "<pre>"; print_r($data['MiscDetails']);
							echo "<pre>"; print_r($data['TravelDetails']);
							echo "<pre>"; print_r($data['ocfDetails']);
							echo "<pre>"; print_r($data['tfDetails']);
							echo "<pre>"; print_r($data['miscUniDetails']);
							echo "<pre>"; print_r($data['getSumptuaryByFY']);
							echo "<pre>"; print_r($data['getEnglishBridgeByFY']);
							echo "<pre>"; print_r($data['getISAByFY']);
							echo "<pre>"; print_r($data['hostelDetails']);
							echo "<pre>"; print_r($data['oreientDetails']);
							echo "<pre>"; print_r($data['getCampsByFY']);
							echo "<pre>"; print_r($data['getEmergencyFundByFY']);
							echo "<pre>"; print_r($data['getStudentDayByFY']); */
 							$data['ddrr'][$fn['FY']][$regionid]['First_Quarter']=$data['advstipendDetails'][0]['First_Quarter'] + $data['stipendDetails'][0]['First_Quarter']+$data['hraDetails'][0]['First_Quarter']+$data['hraDetails'][0]['First_Quarter']+$data['acaDetails'][0]['First_Quarter']+$data['studyTourDetails'][0]['First_Quarter']+$data['MRDetails'][0]['First_Quarter']+$data['ThesisDetails'][0]['First_Quarter']+$data['MiscDetails'][0]['First_Quarter']+$data['TravelDetails'][0]['First_Quarter']+$data['ocfDetails'][0]['First_Quarter']+$data['tfDetails'][0]['First_Quarter']+$data['miscUniDetails'][0]['First_Quarter']+$data['getSumptuaryByFY'][0]['First_Quarter']+$data['getEnglishBridgeByFY'][0]['First_Quarter']+$data['getISAByFY'][0]['First_Quarter']+$data['hostelDetails'][0]['First_Quarter']+$data['oreientDetails'][0]['First_Quarter']+$data['getCampsByFY'][0]['First_Quarter']+$data['getEmergencyFundByFY'][0]['First_Quarter']+$data['getStudentDayByFY'][0]['First_Quarter'];
							
							$data['ddrr'][$fn['FY']][$regionid]['Second_Quarter']=$data['advstipendDetails'][0]['Second_Quarter'] + $data['stipendDetails'][0]['Second_Quarter']+$data['hraDetails'][0]['Second_Quarter']+$data['hraDetails'][0]['Second_Quarter']+$data['acaDetails'][0]['Second_Quarter']+$data['studyTourDetails'][0]['Second_Quarter']+$data['MRDetails'][0]['Second_Quarter']+$data['ThesisDetails'][0]['Second_Quarter']+$data['MiscDetails'][0]['Second_Quarter']+$data['TravelDetails'][0]['Second_Quarter']+$data['ocfDetails'][0]['Second_Quarter']+$data['tfDetails'][0]['Second_Quarter']+$data['miscUniDetails'][0]['Second_Quarter']+$data['getSumptuaryByFY'][0]['Second_Quarter']+$data['getEnglishBridgeByFY'][0]['Second_Quarter']+$data['getISAByFY'][0]['Second_Quarter']+$data['hostelDetails'][0]['Second_Quarter']+$data['oreientDetails'][0]['Second_Quarter']+$data['getCampsByFY'][0]['Second_Quarter']+$data['getEmergencyFundByFY'][0]['Second_Quarter']+$data['getStudentDayByFY'][0]['Second_Quarter'];
							
							$data['ddrr'][$fn['FY']][$regionid]['Third_Quarter']=$data['advstipendDetails'][0]['Third_Quarter'] + $data['stipendDetails'][0]['Third_Quarter']+$data['hraDetails'][0]['Third_Quarter']+$data['hraDetails'][0]['Third_Quarter']+$data['acaDetails'][0]['Third_Quarter']+$data['studyTourDetails'][0]['Third_Quarter']+$data['MRDetails'][0]['Third_Quarter']+$data['ThesisDetails'][0]['Third_Quarter']+$data['MiscDetails'][0]['Third_Quarter']+$data['TravelDetails'][0]['Third_Quarter']+$data['ocfDetails'][0]['Third_Quarter']+$data['tfDetails'][0]['Third_Quarter']+$data['miscUniDetails'][0]['Third_Quarter']+$data['getSumptuaryByFY'][0]['Third_Quarter']+$data['getEnglishBridgeByFY'][0]['Third_Quarter']+$data['getISAByFY'][0]['Third_Quarter']+$data['hostelDetails'][0]['Third_Quarter']+$data['oreientDetails'][0]['Third_Quarter']+$data['getCampsByFY'][0]['Third_Quarter']+$data['getEmergencyFundByFY'][0]['Third_Quarter']+$data['getStudentDayByFY'][0]['Third_Quarter'];
							$data['ddrr'][$fn['FY']][$regionid]['Fourth_Quarter']=$data['advstipendDetails'][0]['Fourth_Quarter'] + $data['stipendDetails'][0]['Fourth_Quarter']+$data['hraDetails'][0]['Fourth_Quarter']+$data['hraDetails'][0]['Fourth_Quarter']+$data['acaDetails'][0]['Fourth_Quarter']+$data['studyTourDetails'][0]['Fourth_Quarter']+$data['MRDetails'][0]['Fourth_Quarter']+$data['ThesisDetails'][0]['Fourth_Quarter']+$data['MiscDetails'][0]['Fourth_Quarter']+$data['TravelDetails'][0]['Fourth_Quarter']+$data['ocfDetails'][0]['Fourth_Quarter']+$data['tfDetails'][0]['Fourth_Quarter']+$data['miscUniDetails'][0]['Fourth_Quarter']+$data['getSumptuaryByFY'][0]['Fourth_Quarter']+$data['getEnglishBridgeByFY'][0]['Fourth_Quarter']+$data['getISAByFY'][0]['Fourth_Quarter']+$data['hostelDetails'][0]['Fourth_Quarter']+$data['oreientDetails'][0]['Fourth_Quarter']+$data['getCampsByFY'][0]['Fourth_Quarter']+$data['getEmergencyFundByFY'][0]['Fourth_Quarter']+$data['getStudentDayByFY'][0]['Fourth_Quarter'];
						
						$data['totalFund'][$i]['Total_Quarter']=$finalAdvTotal;
						$i++;
				}
				
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/fundmonitoring', $data);
                $this->load->view('iccr/footer');

            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	public function fundmonitoringSchemeWise() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 0 || $division == 1 || $division == 2) {
                $current = date('Y-m-d', strtotime('-1 years'));
                $data['fy'] = $this->getFinancialYears($current, 9);
                $data['totalFund'] = $this->common_model->getTotalFundtoAllRegion();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/fundmonitoringSchemeWise', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	 public function fundmonitoringDemo() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 0 || $division == 1 || $division == 2) {
                $current = date('Y-m-d', strtotime('-2 years'));
                $data['fy'] = $this->getFinancialYears($current, 5);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/fundmonitoringDemo', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	public function getfundmonitoring(){
	        try {
			$vars = $this->input->post();
			$fyear = $vars['FinancialYear'];
			$regionid = $vars['RO'];
			$scheme = $vars['Scheme'];
			$division = $user_data['state'];
            if ($division == 0 || $division == 1 || $division == 2) {
                $current = date('Y-m-d', strtotime('-1 years'));
                $data['fy'] = $this->getFinancialYears($current, 9);
			$totalExpenditure = $this->hqrs_model->getTotalExpenditure($vars);
			$counter=1;$finalTotal=0;
			
					if(count($totalExpenditure)>0)
				{
					foreach($totalExpenditure as $app)
					{
						$row = array();
						$row[] = $counter;

						$row[] =  $app['fy'];
						$regi = $this->common_model->getRegionById($app['regionId']); 
						$row[] = $regi[0]['name'];

			
					
					
							
						$row[] = '<a class="form-control sbmt1" style="height:35px;width:140px;" target="_blank"  href="'.site_url().'headquarter/viewExpenditureDetails/'.$app['fy'].'/'.$app['regionId'].'">View Details</</a>';
						
						// $upload  = '<a class="form-control sbmt1" style="height:35px;width:140px;" href="'.site_url().'headquarter/viewExpenditureDetails/'.$app['FY'].'/'.$app['RO']>'View Details</a>';
              // $row[] = $upload;
			   $data[] = $row;
              
						$counter++;	
						
					}
					
				}
				
			
				
 
               
            
	
			$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = count($totalFundsCount);
		$returnJson['recordsFiltered'] = $totalFundsCount[0]['total'];
		$returnJson['data'] = $data;
		echo json_encode($returnJson);
            //output to json format
			}
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }	
		
	}
    function getFinancialYears($from, $nexttoyears) {
        $currentDate = $from;
        $lastFY = date('Y-m-d', strtotime('+' . $nexttoyears . ' years'));
        return $this->calcFY($currentDate, $lastFY);
    }
	public function viewAyushFullApplication() {
        try {
			
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $userId = $user_data['userid'];
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }

            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			
			$ayushType  =  $data['registerData'][0]['apply_course_type'];
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();


            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);

            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);


			$data['applicaitonOther'] = $this->common_model->getApplicationOtherDetailsbyAppNo($data['applicaitonStepOne'][0]["uid"]);
			$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyAppNo($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/viewAyushFullApplication', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	 public function viewProcessedApplication() {
        try {
            $applicationId = $this->uri->segment(3);
            $data['applicaitonStepOne'] = $this->common_model->getHeadquarterApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = !empty($data['applicaitonStepOne']) ? $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']) : [];
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = !empty($data['applicaitonStepOne']) ? $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]) : [];
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/acceptanceHistory', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	 public function viewFullApplication() {
        try {
			
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $userId = $user_data['userid'];
            $data['applicaitonStepOne'] = $this->common_model->getHeadquarterApplicationStepOneByAppno($applicationId);
			//print_r($data['applicaitonStepOne']);die;
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }

            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			
			$ayushType  =  $data['registerData'][0]['apply_course_type'];
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['applicaitonOther'] = $this->common_model->getApplicationOtherDetailsbyAppNo($data['applicaitonStepOne'][0]["uid"]);
			$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyAppNo($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/viewFullApplication', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
			function confirmationReceivedWithNewFormat()
	{
		try
		{
			$doc = array();
			$applicationId = $this->uri->segment(3);
			$uniid = $this->uri->segment(4);
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);
			$userd = $this->common_model->getUserInfo( $stepOne[ 0 ][ 'uid' ] ); 
			$currentyear = date('Y');
			$ar = explode('/',$userd->dir);
			$oldYear = isset($ar[2]) ? $ar[2] : '';
			$uniid = $this->uri->segment(4);
			// if($stepOne[0]['course_type']== 2)
			// {
			// 	$response = $this->common_model->isAyurvedaApplication($applicationId);
				
			// }
			// else
			// {
			// 	$response = $this->common_model->getconfirmationDataByMission($applicationId);
				
			// }
			
			// if($stepOne[0]['course_type']== 2)
			// {
			// $course = $response[0]['course'];
			// }
			// else
			// {
			// 	$course = $response[0]['final_course'];
			// }
            
            $response = $this->common_model->getconfirmationDataByMission($applicationId);		
            $course = isset($response[0]['final_course']) ? $response[0]['final_course'] : '';
			
			$current = date('d-m-Y');
			$fy = $this->getFinancialYears($current,1);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);
			$nomenid = $response[0]['nomenclature'];
			$nomclature = $this->common_model->getnomenclatureByid($nomenid);
			$nomenclature=$nomclature[0]['title'];
			$studentOther = $this->common_model->getStudentOtherDetails($applicationId);
			$missionDetails = $this->common_model->getMissionDetails($applicationId);
			$missionPersonName = $missionDetails[0]['mission_person_name'];
			
			$missionDate = $missionDetails[0]['mission_status_date'];
			
			$imgPath = site_url().'assets/site/main/mission_signature/'.$missionDetails[0]['mission_person_signature'];
			
			$new='<img src="'.$imgPath.'" style="max-width:100px; max-height:60px;">';

            $image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$logo = '<img src="' . $image . '" style="width:auto;">';
			
			
			$mission = $this->common_model->getMissionInfo($studentOther[0]['application_through']);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$region = isset($region) ? $region : null;
			$regionInfo = $this->common_model->getRegionById($region);
			$uninmae = $this->common_model->getUniversityStateById($uniid);
			ob_start();
?>
        <html>
    <style>
        .sign_align {
            text-align: right;
        }
		body {
			font-family: Arial;
		}
        @media print {
			@page {
				margin-top: 0;
				margin-bottom: 0;
			}
			body {
				padding-top: 72px;
				padding-bottom: 72px ;
			}
		}
		/* body{margin:0px;}
		.pdf_div{width:80%; margin:auto; border:3px solid #f3f3f3; padding:10px 25px 0 25px; font-size:15px;}
		@media print{
			.pdf_div{width:100%; margin:auto;  padding:0px; font-size:15px; padding:10px 15; border:0px;}

		} */
    </style>

    <body>
		<div class="pdf_div" style="font-size: 13px;">
        <p style="text-align: right;"><small>Ref. No. <?php echo $applicationId; ?> <br/>Date: <?php echo $missionDate; ?> </small></p>
		<div style="text-align: center;"><?php echo $logo;?></div>
        <h3 style="text-align: center;">Indian Council For Cultural Relations (ICCR)</h3>
		<h2 style="color: #d8d5d5;opacity: 0.3;font-family: arial;font-size: 36px;margin: -20px;transform(rotate(45deg));transform-origin(0 0);transform: rotate(328deg);position: relative;top: 300px;text-align: center;">Indian Council For Cultural Relations</h2>
        <p style="text-align: right;"><?php echo  $mission[0]['mission_type'] . ': ' . $mission[0]['mission_name'].',<br>'.$mission[0]['country_name']; ?></p>
        <p><b>Subject:-</b> Offer of Provisional admission with award of ICCR Scholarship for A.Y 2026-27</p>
        <p>Dear: Mr./Ms./Mrs. <?php echo  $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname']; ?></p>
        <p style="text-align: justify;">1)  We are pleased to inform you that you have been provisionally selected to pursue Nomenclature "<?php echo $nomenclature . '" at under ' . (isset($uninmae[0]['name']) ? $uninmae[0]['name'] : '') . ' ' . (isset($schemename[0]['scheme_name']) ? $schemename[0]['scheme_name'] : '') . ' for the Academic Year 2026-2027. You are requested to report ' . (isset($regionInfo[0]['name']) ? $regionInfo[0]['name'] : '') . ' University physically along with all original certificate and testimonials latest by '   . (isset($response[0]['date_of_joining']) ? $response[0]['date_of_joining'] : '') . ' and also to Regional Office through Email.'; ?></p>
        <p style="text-align: justify;">2)  Hostel accommodation will be provided to you subject to its availability by University authorities. You are required to report at the nearest “Foreign Regional Registration Office” within fourteen days of arrival in India.</p>
        <p style="text-align: justify;">3)  You are advised to contact the Education Wing of this Mission immediately along with your passport for grant of visa and finalization of your date of departure. You are also hereby directed to obtain your final departure letter from the Mission before joining the concerned Institution in India failing which this offer letter stands cancelled. Furthermore no request of change of course and University will be entertained.</p>
        <p style="text-align: justify;">4)  Scholarship expenses will be managed into two parts, which are as follows:-</p>
        <p style="text-align: justify;">(A)	Hostel dues:- On arrival, all these expenses are to be managed by the scholar.</p>

	    <p>i) Hostel fee, Mess fee, Electricity charges, Caution money and Application fee </br>ii) Health insurance </br>iii) FRRO registration fee/late fee</p>

        <p style="text-align: justify;">(B)	Stipend/OCF/other dues – After completion of procedural formalities (dues can be released by ICCR but it takes minimum two months time to complete the process).</p>

        <p>i) Stipend, HRA, ACA and thesis charges (to be paid directly to scholar) </br>ii) Tuition Fee/OCF (to be paid to university/institute on receipt of demand) </br>iii) Air-Tickets (as per admissibility)</p>

        <p style="text-align: justify;">5)  You are also advised to carry with you joining report form and a Minimum of INR 50,000/- equivalent to $700 to meet incidental expenses on arrival in India. There could also be some miscellaneous expanses, so please carry some extra amount to meet the same.</p>
        <p style="text-align: justify;">6)  Please complete all pre-departure formalities such as preparation of passport  and getting the student/research visa.</p>
        <p style="text-align: justify;">7)  Please carry original documents for confirming the provisional admission at the time of reporting at University. Please note that admission is granted provisionally and needs to be confirmed on the basis of submission of original documents at the time of first reporting at the University. In case of discrepancies in documentation, University reserves the right to cancel provisional admission offered to student. ICCR/Mission will not be responsible for cancellation of provisional admission on the above grounds and will not be liable to pay scholarship or expenses  incurred on return air-tickets by the student.</p>
        <!--<p><b>NOTE:-</b> Due to ongoing Covid-19 Pandemic, students will take up online classes and once the situation is better students will be invited to India as and when University allows to report and join physical classes. For any update, please be in touch with University and Mission.</p>-->
		<!-- </br> -->
		<p style="text-align: right;"><?php echo $new;?></p>
		<p style="text-align: right;">Yours Sincerely <br><?php echo $missionPersonName; ?></p>
		
	</div>
    </body>
</html>     
<?php	


die;

      $html = ob_get_clean();		
			$this->load->library('GenPdf');
			
			$dompdf = new GenPdf();
			//$canvas = $dompdf->get_canvas();
			$dompdf->set_option('isHtml5ParserEnabled', true);
			$dompdf->set_option('isRemoteEnabled', true);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream("welcome.pdf", array("Attachment"=>0));

			//$pdf->debug = true;
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');

			redirect(site_url() . 'mission/dashboard');
		}
		
	}

    
    public function viewApplication() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $userId = $user_data['userid'];
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/viewFullApplication', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function academicDetails() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division > 0) {
                $data['allarrived'] = $this->common_model->getAcademicDetailsForhqrs($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/academicDetails', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
 public function viewAlumaniDetails() {
        try {
            $user_data = $this->session->userdata('user_data');
            $missionId = $user_data['user_country'];
            $appno = $this->uri->segment(3);
            $data['misionData'] = $this->common_model->getMissionInfo($missionId);
            $data['alunamiapplication'] = $this->common_model->getAlumaniApplicationbyId($appno);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/viewAlumaniApplication', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	public function downloadAlumniApplication()
	{
		try
	    {
	    	$appno = $this->uri->segment(3);
	    	$content = $this->input->post("myHTML");
			$this->load->library('mpdf60/Mpdf');
			$mpdf = new Mpdf('s','A4','','',7,7,05,10,10,10);			
			$mpdf->SetFont('Arial','B',8);
			$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
			$mpdf->watermark_font = 'DejaVuSansCondensed';
			$mpdf->showWatermarkText = true;
			$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Alumni Details For Scholarship through ICCR</h3><br/>";       	 				
	    	$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>Ref. No.".$appno.'<br/>'.date("jS F Y h:i:s")."</div>";
$html = $content;
 			$imgArray = $this->common_model->getUserImage($data[0]['uid']);		  
			 
			$mpdf->SetDisplayMode('fullpage');			 
			// LOAD a stylesheet
			$stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css'); 
			
			$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
			$mpdf->WriteHTML($stylesheet1,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css'); 
			$mpdf->WriteHTML($stylesheet2,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
			$mpdf->WriteHTML($stylesheet3,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
			$mpdf->WriteHTML($stylesheet4,1); // The parameter 1 tells that this is css/style only and no body/html/text
			
			$stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
			$mpdf->WriteHTML($stylesheet5,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($html1,2);
			$mpdf->WriteHTML($content);	
			$mpdf->Output();
	    }
	    catch(HTML2PDF_exception $e) {
	       	$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Downloading!');
			redirect(site_url().'mission/dashboard');	
	        exit;
	    }
	}
    function alumani() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division > 0) {
                $data['alunamiapplication'] = $this->common_model->getAllAlumaniApplications();
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/alumani', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function createregionalExpenditure() {
        try {
            $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
            $status = $this->common_model->createregionalExpenditure($clean);
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function expenditureReportofStudent() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
           
            $fy = $this->uri->segment(4);
            $yearArray = explode('-', $fy);
            $user_data = $this->session->userdata('user_data');
            $regionid = $user_data['state'];
            $user_data = $this->session->userdata('user_data');
            $regionid = $user_data['state'];
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }

            $data['userImage'] = $image;
            $data['academicDetails'] = $this->common_model->getAcademicDetailsDataforReport($applicationId);
            $ro = $this->common_model->getTravelPlanArrived($applicationId);
            $regionid = $ro[0]['regional_office_contacted'];
            if(count($regionid)>0)
            {
				$data['regionName'] = $this->common_model->getRegionById($regionid);	
			}
			else
			{
				$data['regionName'] = "";
			}
            
            $data['bankDetails'] = $this->common_model->getBankingDetails($applicationId, "");
            $data['permitDetails'] = $this->common_model->getPermitDetails($applicationId, "");
            $data['advstipendDetails'] = $this->common_model->getAdvStipendByFYofAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['stipendDetails'] = $this->common_model->getStipendByFYByAppno($yearArray[0], $yearArray[1], $applicationId);
            $data['hraDetails'] = $this->common_model->gethraByFYByAppno($yearArray[0], $yearArray[1], $applicationId);
            $data['acaDetails'] = $this->common_model->getACAbyFYByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['studyTourDetails'] = $this->common_model->getStudyTourbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
            $data['MRDetails'] = $this->common_model->getMedicalReimbrusmentbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
            $data['ThesisDetails'] = $this->common_model->getThesisbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
            $data['TravelDetails'] = $this->common_model->getTravelDetailsbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
            $data['ocfDetails'] = $this->common_model->getOCFByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['tfDetails'] = $this->common_model->getTFByByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['hostelDetails'] = $this->common_model->getHostelChargesByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getEnglishBridgeByFY'] = $this->common_model->getEnglishBridgeByappid($yearArray[0], $yearArray[1], $applicationId);
            $data['oreientDetails'] = $this->common_model->getOrientChargesByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getCampsByFY'] = $this->common_model->getCampsByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getISAByFY'] = $this->common_model->getISAByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getSumptuaryByFY'] = $this->common_model->getSumptuaryByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getEmergencyFundByFY'] = $this->common_model->getEmergencyFundByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getStudentDayByFY'] = $this->common_model->getStudentDayByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getStudentDayByFY'] = $this->common_model->getStudentDayByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['totalFund'] = $this->common_model->getTotalFundtoRegionbyFY($regionid, $fy);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/viewExpenditureDetailsofStudent', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function downloadAllExpenditureReport() {
        try {
            $appno = $this->uri->segment(3);
            $content = $this->input->post("myHTML");
            $this->load->library('mpdf60/Mpdf');
            $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
            $mpdf->SetFont('Arial', 'B', 12);
            $mpdf->SetWatermarkText('Indian Council For Cultural Relations');
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:15px;font-weight:normal;'>Expenditure Statement of Student </h3><br/>";
            $html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";
            $html = $content;
            $imgArray = $this->common_model->getUserImage($data[0]['uid']);

            $mpdf->SetDisplayMode('fullpage');
            // LOAD a stylesheet
            $stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css');

            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
            $mpdf->WriteHTML($stylesheet1, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css');
            $mpdf->WriteHTML($stylesheet2, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
            $mpdf->WriteHTML($stylesheet3, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
            $mpdf->WriteHTML($stylesheet4, 1); // The parameter 1 tells that this is css/style only and no body/html/text

            $stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
            $mpdf->WriteHTML($stylesheet5, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $mpdf->WriteHTML($html1, 2);
            $mpdf->WriteHTML($content);
            $mpdf->Output();
        } catch (HTML2PDF_exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
            exit;
        }
    }

    public function regionalExpenditure() {
        try {
            $data['newApplication'] = $this->common_model->getHqrsNewApplication();
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/new_applications', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function downloadList() {
        ini_set("pcre.backtrack_limit", "1000000");
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 900);
        try {
            $appno = $this->uri->segment(3);
            $title = $this->input->post('pdftitle');
            $content = $this->input->post("myHTML");
            $this->load->library('mpdf60/Mpdf');
            $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
            $mpdf->SetFont('Arial', 'B', 18);
            $mpdf->SetWatermarkText('Indian Council For Cultural Relations');
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>$title</h3><br/>";
            $html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";
            $html = $content;
            $imgArray = $this->common_model->getUserImage($data[0]['uid']);

            $mpdf->SetDisplayMode('fullpage');
            // LOAD a stylesheet
            $stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css');

            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
            $mpdf->WriteHTML($stylesheet1, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css');
            $mpdf->WriteHTML($stylesheet2, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
            $mpdf->WriteHTML($stylesheet3, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
            $mpdf->WriteHTML($stylesheet4, 1); // The parameter 1 tells that this is css/style only and no body/html/text

            $stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
            $mpdf->WriteHTML($stylesheet5, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $mpdf->WriteHTML($html1, 2);
            $mpdf->WriteHTML($content);
            $mpdf->Output();
        } catch (HTML2PDF_exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
            exit;
        }
    }

    public function applicantExpenditure() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division >= 0) {
                $current = date('Y-m-d');
                $current1 = date('Y-m-d', strtotime('-7 years'));
                $data['fy'] = $this->getFinancialYears($current, 1);
                $data['ofy'] = $this->getFinancialYears($current1, 5);
               
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/studentExpenditurelist', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	//DEMO VIPIN
	
		public function new_applicationsDemoOne()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];		
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			//$data['newApplication'] = $this->common_model->getRegionalApplications($regionid);
			$data['region'] = $regionid;
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/new_applicationsDemoOne',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	
		function getHqrsDemoNewApplication()
    {
    	$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];		
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$data['region'] = $regionid;	 	
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->hqrs_model->getHqrsDemoNewApplication($vars);
		$totalResult = $this->hqrs_model->getHqrsTotalDemoNewApplication($vars);
		$response = array();
		$counter++;
		
		if(!empty($result))
		{
			
			foreach($result as $r)
			{
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				        $gender = "";
				        $output= array();	
				        $output[] = $counter;	
						
						$date1 = '2019-12-01';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						$studentyreg = strtotime($r['created']);
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
						//}
						$output[] = $applicationDetails[0]['application_no'];
					    $output[]= $applicationDetails[0]['fullname'].$new;
							
						$output[] = $applicationDetails[0]['email'];
                       
						$output[] = $country[0]['country_name'];
						$sch = $this->common_model->getSchemeById($r['scholarship_id']);
						if(!empty($sch))
						{
							$output[] = $sch[0]['scheme_name'];
						}
						else
						{
							$output[] = 	'NA';
							}
									
						if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
							$output[] =  $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
						}
						else
						{
												$nomenclature = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature']);
					$nomenclature1 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_two']);
					$nomenclature2 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_three']);
					$nomenclature3 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fourth']);
					$nomenclature4 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					if(!empty($nomenclature[0]['title'])){
					$fullCourse .= '1) '.$nomenclature[0]['title'].'<br/>';
					}
					if(!empty($nomenclature1[0]['title'])){
					$fullCourse .= '2) '.$nomenclature1[0]['title'].'<br/>';
					}
					if(!empty($nomenclature2[0]['title'])){
					$fullCourse .= '3) '.$nomenclature2[0]['title'].'<br/>';
					}
					if(!empty($nomenclature3[0]['title'])){
					$fullCourse .= '4) '.$nomenclature3[0]['title'].'<br/>';
					}
					if(!empty($nomenclature4[0]['title'])){
					$fullCourse .= '5) '.$nomenclature4[0]['title'].'<br/>';
					}
					$output[] = $fullCourse;
				
						}
						$universityDetails = '';
						$uname1 ="";$array_uni_id = array();
						
						if($regionid == $applicationDetails[0]['university_choice_one_state']){
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);		
							$uname1 = $university[0]['name'];
							array_push($array_uni_id,1);
						}
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);		
							$uname1 = $university[0]['name'];
						}
						
						$uname2 ="";					
						if($regionid == $applicationDetails[0]['university_choice_two_state']){						
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
							$uname2 = $university[0]['name'];
							array_push($array_uni_id,2);
						}						
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);	
							$uname2 = $university[0]['name'];
						}
						
						
						$uname3 ="";
						
						if($regionid == $applicationDetails[0]['university_choice_three_state']){							
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
							$uname3 = $university[0]['name'];
							array_push($array_uni_id,3);
						}
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
							$uname3 = $university[0]['name'];
						}
							$uname4 ="";
						
						if($regionid == $applicationDetails[0]['university_choice_fourth_state']){							
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fourth']);
							$uname4 = $university[0]['name'];
							array_push($array_uni_id,4);
						}
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fourth']);
							$uname4 = $university[0]['name'];
						}
						$uname5 ="";
						
						if($regionid == $applicationDetails[0]['university_choice_fifth_state']){							
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fifth']);
							$uname5 = $university[0]['name'];
							array_push($array_uni_id,5);
						}
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fifth']);
							$uname5 = $university[0]['name'];
						}
						
						$universityDetails .= '1) '.$uname1.'<br/>';
				        $universityDetails .= '2) '.$uname2.'<br/>';
				        $universityDetails .= '3) '.$uname3.'<br/>';
						$universityDetails .= '4) '.$uname4.'<br/>';
						$universityDetails .= '5) '.$uname5.'<br/>';
				        $output[] = $universityDetails;	
						$output[] =  $r['created'];	
						$output[] = date("Y-m-d", $r['SubmitDate']);
						$output[] = '<a style="float:left;width:104px;" href="'.site_url().'headquarter/viewsfullApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt1" target = "_blank">View</a>';
						
						$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =openStatus("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Status</a>';
							
							}
							
						$response[] = $output;	
						$counter++;	
					
					
				}

		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = count($totalResult);
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}

function openUniversityStatus(){

		echo openUniversityStatus();
	}
	
function openHqrsStatus(){
		
		echo openHqrsStatus();
		
	}
	
	public function viewsfullApplication()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}		
			
			
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
			if(count($imgArray)> 0)
			{
				$image = $imgArray[0]['name'];
			}		
			else
			{
				$image = '';
			}
			$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			$data['userImage'] = $image;
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);	
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/viewsFullApplication',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}		
	}
	
	
    public function new_applications() {
        try {
			$data['year']= $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 1) {
                $data['newApplication'] = $this->common_model->getHqrsNewApplication($this->ids);
                $this->load->view('iccr/header_mission');
				
                $this->load->view('iccr/new_applications', $data);
				
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }




  public function newapplications() {
        try {
			$data['year'] = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 1) {
                $data['newApplication'] = $this->common_model->getHqrsNewApplication($this->ids);

                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/newapplications', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	public function generate_zip($files, $path)
	{
	    if (empty($files)) {
	        throw new Exception('Archive should\'t be empty');
	    }
	    $this->load->library('zip');
	    foreach ($files as $file) {
	        $this->zip->read_file($file);
	    }
	    $this->zip->archive($path);
	}
	public function downloadStudent_zip($path)
	{	
		$applicationId = $this->uri->segment(3);
		$studentsDetails = $this->common_model->getApplicationDocumentsByAppId($applicationId);
		$userd = $this->common_model->getUserInfo($studentsDetails[0]['uid']); 
		if( $studentsDetails >0)
		{
			$path = FCPATH.'/'.$userd->dir.'/';
            
			foreach($studentsDetails as $stDetails)
			{
				// echo "<pre>";print_r($stDetails['document_name']);
				if($stDetails['document_name'] != "")
				{
					$filename =  $stDetails['document_name'];
					$this->load->library('zip');
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$this->zip->download($applicationId.'_documents'.'.zip');
		
	}
	function getNewAllApplicaitons()
    {
		// This is a DataTables server-side-processing endpoint: the browser only
		// ever expects JSON back. Previously, any uncaught error anywhere below
		// (a failed query, a missing related record, etc.) killed the script
		// with zero output, which the DataTables JS reports as a cryptic
		// "Invalid JSON response" with no indication of what actually broke.
		// Wrapping the whole thing means a real failure now logs the actual
		// error and still returns a validly-shaped (empty) table instead of a
		// dead response.
		try {
			$this->_getNewAllApplicaitonsResponse();
		} catch (\Throwable $e) {
			log_message('error', 'Headquarter::getNewAllApplicaitons() failed: ' . $e->getMessage());
			echo json_encode(array(
				'draw' => isset($_POST['draw']) ? $_POST['draw'] : 0,
				'recordsTotal' => 0,
				'recordsFiltered' => 0,
				'data' => array(),
			));
		}
	}

	private function _getNewAllApplicaitonsResponse()
    {
		$year = $this->uri->segment(3);
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];
		$vars = $this->input->post();
		$result = $this->hqrs_model->getHqrsAllNewApplication($this->ids,$vars,$year);
		$totalResult = $this->hqrs_model->getHqrsAllTotalNewApplication($this->ids,$vars,$year);
		$response = array();
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				$gender = "";
				$output= array();	
				$output[] = $counter;
				$output[] = $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'];
				$output[] = $applicationDetails[0]['email'];
				$output[] = $r['application_no'];
						
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					/*$course = $this->common_model->getCoursesById($applicationDetails[0]['course']);
					$course1 = $this->common_model->getCoursesById($applicationDetails[0]['course_two']);
					$course2 = $this->common_model->getCoursesById($applicationDetails[0]['course_three']);
					$course3 = $this->common_model->getCoursesById($applicationDetails[0]['course_fourth']);
					$course4 = $this->common_model->getCoursesById($applicationDetails[0]['course_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'<br/>';
					
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'<br/>';
					
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'<br/>';
					
					$fullCourse .= $course3[0]['title'].' '.$applicationDetails[0]['course_option_name_fourth'].'<br/>';
					
					$fullCourse .= $course4[0]['title'].' '.$applicationDetails[0]['course_option_name_fifth'].'<br/>';
					$output[] = $fullCourse;*/
					$nomenclature = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature']);
					$nomenclature1 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_two']);
					$nomenclature2 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_three']);
					$nomenclature3 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fourth']);
					$nomenclature4 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					if(!empty($nomenclature[0]['title'])){
					$fullCourse .= '1) '.$nomenclature[0]['title'].'<br/>';
					}
					if(!empty($nomenclature1[0]['title'])){
					$fullCourse .= '2) '.$nomenclature1[0]['title'].'<br/>';
					}
					if(!empty($nomenclature2[0]['title'])){
					$fullCourse .= '3) '.$nomenclature2[0]['title'].'<br/>';
					}
					if(!empty($nomenclature3[0]['title'])){
					$fullCourse .= '4) '.$nomenclature3[0]['title'].'<br/>';
					}
					if(!empty($nomenclature4[0]['title'])){
					$fullCourse .= '5) '.$nomenclature4[0]['title'].'<br/>';
					}
					$output[] = $fullCourse;
				}
				
				$universityDetails = "";
				$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				$uni4 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fourth']);
				$uni5 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fifth']);
				if($r['apply_course_type'] == 11){
				        $universityDetails .= '1) '.(isset($uni1[0]['name']) ? $uni1[0]['name'] : '').'<br/>';
                   
				}else{
                        $universityDetails .= '1) '.(isset($uni1[0]['name']) ? $uni1[0]['name'] : '').'<br/>';
                        $universityDetails .= '2) '.(isset($uni2[0]['name']) ? $uni2[0]['name'] : '').'<br/>';
                        $universityDetails .= '3) '.(isset($uni3[0]['name']) ? $uni3[0]['name'] : '').'<br/>';
                        $universityDetails .= '4) '.(isset($uni4[0]['name']) ? $uni4[0]['name'] : '').'<br/>';
                        $universityDetails .= '5) '.(isset($uni5[0]['name']) ? $uni5[0]['name'] : '').'<br/>';
                   
				}
				$output[] = $universityDetails;

				// "Confirmed University" - the view's <thead> in
				// views/iccr/newapplications.php has a "Confirmed University"
				// column (between University and Scheme) that this array wasn't
				// populating, so every row was one element short of what the
				// table expected and DataTables threw "Requested unknown
				// parameter '11' for row 0, column 11" as soon as any data
				// actually loaded. Shows the one university (if any) that has
				// actually accepted this applicant AND been confirmed onward to
				// the mission - i.e. the real outcome, as opposed to the
				// "University" column above which just lists all 5 preferences
				// the applicant originally submitted.
				$confirmedUniversityName = 'NA';
				$confirmedResponse = $this->common_model->getconfirmationDataByMission($r['application_no']);
				if (!empty($confirmedResponse)) {
					$confirmedUniversity = $this->common_model->getFinalUniversityById($confirmedResponse[0]['regional_university']);
					if (!empty($confirmedUniversity)) {
						$confirmedUniversityName = $confirmedUniversity[0]['name'];
					}
				}
				$output[] = $confirmedUniversityName;

				$scheme = $this->common_model->getSchemeById($r['scholarship_id']);
				if(!empty($scheme)){
					$output[] =	$scheme[0]['scheme_name'];
				}else{
					$output[] =	'NA';
				}

				$output[] = $country[0]['country_name'];

				$date2 = $r['SubmitDate'];
				$output[] = date('d-m-Y',$date2);
				
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'headquarter/viewFullApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt1" target = "_blank">View</a>';
				
					/* if($r['universities_status'] == 1)
				{
					
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" title = "hello" href="'.site_url().'headquarter/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt">Process</a>';
				}
				else{
					//$output[] = 'Not Allowed';
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" title = "This button will be enabled once admission is confirmed by University." href="javascript:void(0);" class="btn btn-block btn-default sbmt disabled">Process</a>';
				}  */
				$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =openStatus("'.$r['application_no'].'") class="form-control sbmt1">Status</a>';
				// $output[] = '<a target="_blank" href="'.site_url().'headquarter/downloadStudent_zip/'.$r['application_no'].'" target="_blank"><span class = "label label-success">Download</span></a>';
				$response[] = $output;
				$counter++;
			}
		}
		
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
	
		echo json_encode($returnJson);
	}

    public function forward() {
        $appno = $this->uri->segment(3);
        try {
            $status = $this->common_model->ApplicationForwardFromHeadquarter($appno);
            if ($status) {
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('success', 'Application Forwarded to RO Successfully!');
                redirect(site_url() . 'headquarter/new_applications');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function underprocess() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 1) {
                $data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/underprocess', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function confirmationfromallROs() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 1) {
                $data['confirmationfromROs'] = $this->common_model->getRegionalApplicationsConfirmationtoHqrs($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/confirmationfromallROs', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function savenotconfirmedcourse() {
        $sts1 = 0;
        $appno = $this->uri->segment(3);
        $unid = $this->uri->segment(4);
        $postData = $this->input->post(NULL, TRUE);
        $data = array(
            'iccr_status' => 1,
            'status' => 10,
			'iccr_status_date'=>time()
        );
        $data1 = array(
            'reason' => $postData['reason'],
            'application_id' => $appno,
            'regional_university' => $unid
			
        );
        $sts1 = $this->common_model->NOTConfirmationofCourseToMissionByHqrs($data1, $appno);
        $sts = $this->common_model->ConfirmationForwardToMissionByHqrs($data, $appno);
        if ($sts) {
            $this->session->set_flashdata('message_type', 'success');
            $this->session->set_flashdata('success', 'Application Forwarded Successfully!');
            redirect(site_url() . 'headquarter/confirmationfromROs');
        } else {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
            redirect(site_url() . 'headquarter/confirmationfromROs');
        }
    }

    function saveconfirmedcourse() {
        $sts1 = 0;
        $appno = $this->uri->segment(3);
        $unid = $this->uri->segment(4);
        $postData = $this->input->post(NULL, TRUE);
        $data = array(
            'iccr_status' => 1,
            'status' => 10,
			'iccr_status_date' =>time()
        );
        $data1 = array(
            'course' => $postData['confirmedCourse'],
            'confirmed_to_mission'=>1,
            'application_id' => $appno,
            'regional_university' => $unid
			
        );
        $sts1 = $this->common_model->ConfirmationofCourseToMissionByHqrs($data1, $appno);
        $sts = $this->common_model->ConfirmationForwardToMissionByHqrs($data, $appno);
        if ($sts) {
            $this->session->set_flashdata('message_type', 'success');
            $this->session->set_flashdata('success', 'Application Forwarded Successfully!');
            redirect(site_url() . 'headquarter/confirmationfromROs');
        } else {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
            redirect(site_url() . 'headquarter/confirmationfromROs');
        }
    }

    public function beforerejectiontoMission() {
        $applicationId = $this->uri->segment(3);
        $user_data = $this->session->userdata('user_data');

        $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
        if (count($data['applicaitonStepOne']) > 0) {
            $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
        } else {
            $data['get_application_number'] = $this->random_num(15);
        }
        $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
        if (count($imgArray) > 0) {
            $image = $imgArray[0]['name'];
        } else {
            $image = '';
        }
        $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
        $data['userImage'] = $image;
        $data['missions'] = $this->common_model->getAllMissions();
        $data['univercities'] = $this->common_model->getUnivercities();
        $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
        $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
        $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
        $data['mappingData'] = $this->common_model->getMappingData($applicationId);
        $data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);

        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/beforerejectiontoMission', $data);
        $this->load->view('iccr/footer');
    }

    public function beforeconfirmtoMission() {
        $applicationId = $this->uri->segment(3);
        $user_data = $this->session->userdata('user_data');

        $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
        if (count($data['applicaitonStepOne']) > 0) {
            $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
        } else {
            $data['get_application_number'] = $this->random_num(15);
        }
        $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
        if (count($imgArray) > 0) {
            $image = $imgArray[0]['name'];
        } else {
            $image = '';
        }
        $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
        $data['userImage'] = $image;
        $data['missions'] = $this->common_model->getAllMissions();
        $data['univercities'] = $this->common_model->getUnivercities();
        $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
        $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
        $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
        $data['mappingData'] = $this->common_model->getMappingData($applicationId);
        $data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);

        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/beforeconfirmtoMission', $data);
        $this->load->view('iccr/footer');
    }

    public function confirmationfromROs() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 1) {
                $data['confirmationfromROs'] = $this->common_model->getRegionalApplicationsConfirmationtoHqrs($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/confirmationfromROs', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

	public function confirmationfromROsDemo() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 1) {
                $data['confirmationfromROs'] = $this->common_model->getRegionalApplicationsConfirmationtoHqrs($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/confirmationfromROsDemo', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	public function saveforwardtoRo(){
		try {
		 $applicationId = $this->uri->segment(3);
         $user_data = $this->session->userdata('user_data');
		 $postData = $this->input->post(NULL, TRUE);
		 $data = array(
		 'status' =>4,
		 'iccr_status'=>-1,
		 'iccr_status_updtae_date'=>time(),
		 'forward_reason'=>$postData['forward_reason']
		 );
		 $sts = $this->common_model->ForwardToRo($applicationId,$data);
		   if ($sts) {
            $this->session->set_flashdata('message_type', 'success');
            $this->session->set_flashdata('success', 'Application Forwarded Successfully!');
            redirect(site_url() . 'headquarter/confirmationfromROs');
        } else {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
            redirect(site_url() . 'headquarter/confirmationfromROs');
        }
		  } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
		
	}
	
	public function forwardtoRo(){
		$applicationId = $this->uri->segment(3);
        $user_data = $this->session->userdata('user_data');

		
        $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
        if (count($data['applicaitonStepOne']) > 0) {
            $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
        } else {
            $data['get_application_number'] = $this->random_num(15);
        }
        $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
        if (count($imgArray) > 0) {
            $image = $imgArray[0]['name'];
        } else {
            $image = '';
        }
        $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
        $data['userImage'] = $image;
        $data['missions'] = $this->common_model->getAllMissions();
        $data['univercities'] = $this->common_model->getUnivercities();
        $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
        $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
        $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
        $data['mappingData'] = $this->common_model->getMappingData($applicationId);
        $data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);

        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/beforeForwardtoRo', $data);
        $this->load->view('iccr/footer');
		
	}
    public function instructions() {
        try {
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/instructions');
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function ro_guidlines() {
        try {
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/regional_guidlines');
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function applicant_guidlines() {
        try {
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/applicant_guidlines');
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function mission_guidlines() {
        try {
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/mission_guidlines');
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function hqrs_guidlines() {
        try {
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/hqrs_guidlines');
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function checklist() {
        try {
            $data['applicaitonStepOne'] = $this->common_model->getMissionApplications();
            $this->load->view('mission/header_mission');
            $this->load->view('mission/checklist');
            $this->load->view('mission/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function travel_applications() {
        try {
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/travel_applications');
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function applicationForm() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $userId = $user_data['userid'];
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);

            // The allotment actually made for this application - the confirmed
            // university and the nomenclature (held in the course column) - so
            // the form can show what was granted, not only what was requested.
            // Read from iccr_university_response_by_hqrs, which is where the
            // allotment is recorded.
            $data['universityResponses'] = $this->common_model->getconfirmationDataforfourthoptionHqrs($applicationId);

            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/applicationForm', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	   public function applicationFormsfs() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $userId = $user_data['userid'];
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
          
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/applicationFormsfs', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function contactForm() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $userId = $user_data['userid'];
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
           
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/contactForm', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function profile() {
        try {
            $user_data = $this->session->userdata('user_data');
            $postData = $this->input->post(NULL, TRUE);
            if (count($postData) > 0) {
                $cleanData = $this->security->xss_clean($postData);
                $profileData = array(
                    'uid' => $cleanData['id'],
                    'mobile_no' => $cleanData['mobile_no'],
                    'office_address' => $cleanData['office_address'],
                    'telephone_number' => $cleanData['telephone_number'],
                    'fax_number' => $cleanData['fax_number']
                );
                $userData = array(
                    'username' => $cleanData['username'],
                    'id' => $cleanData['id']
                );
                $status = $this->common_model->updateProfileHeadquarter($profileData);
                $status1 = $this->common_model->updateProfileHeadquarterName($userData);
                if ($status) {
                    $this->session->set_flashdata('message_type', 'success');
                    $this->session->set_flashdata('success', 'Profile Successfully Updated!');
                } else {
                    $this->session->set_flashdata('message_type', 'error');
                    $this->session->set_flashdata('error', 'Error Occur While Updating Profile! Try Again Later.');
                }
            }
            $data['head'] = $this->common_model->getHeadquarterInfo($user_data['uid']);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/profile', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function changepassword() {
        try {
            $user_data = $this->session->userdata('user_data');
            $postData = $this->input->post(NULL, TRUE);
            if (count($postData) > 0) {
                $cleanData = $this->security->xss_clean($postData);
                if (count($this->common_model->oldPasswordMatched($cleanData['id'], $cleanData['oldpassword']))) {
                    $profileData = array(
                        'id' => $cleanData['id'],
                        'password' => $cleanData['newpassword']
                    );
                    $message = '';
                    $message .= '<strong>Your Password has been updated Sucessfully.</strong><br><br>';
                    $data = array(
                        'content' => $message
                    );
                    $config = Array(
                        'mailtype' => 'html'
                    );
                    $content = $this->load->view('change_password', $data, true);
                    $from_email = "yashpal.sharma@velocis.co.in";
                    $to_email = $user_data['email'];
                    /* Load email library */
                    $this->load->library('email', $config);
                    $this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)');
                    $this->email->to($to_email);
                    $this->email->subject('Indian Council for Cultural Relations (ICCR)');
                    $this->email->message($content);
                    if ($this->email->send()) {
                        $status = $this->common_model->updateProfilePassword($profileData);
                        if ($status) {
                            $this->session->set_flashdata('message_type', 'success');
                            $this->session->set_flashdata('success', 'Password Successfully Updated!');
                        } else {
                            $this->session->set_flashdata('message_type', 'error');
                            $this->session->set_flashdata('error', 'Error Occur While Updating Password! Try Again Later.');
                        }
                    } else {
                        $this->session->set_flashdata('message_type', 'error');
                        $this->session->set_flashdata('error', 'Error Occur While Email not send! Try Again Later.');
                    }
                } else {
                    $this->session->set_flashdata('message_type', 'error');
                    $this->session->set_flashdata('error', 'Old Password Not Matched.');
                }
            }
            $data['head'] = $this->session->userdata('user_data');
            $data['salt'] = $this->random_string();
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/changepassword', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function random_string() {
        $character_set_array = array();
        $character_set_array[] = array('count' => 4, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
        $character_set_array[] = array('count' => 4, 'characters' => '0123456789');
        $temp_array = array();
        foreach ($character_set_array as $character_set) {
            for ($i = 0; $i < $character_set['count']; $i++) {
                $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
            }
        }
        shuffle($temp_array);
        return implode('', $temp_array);
    }

    public function logout() {
       $userInfo =$this->session->userdata('user_data');
		$lastLoginHistry = $this->user_model->updateLogoutHistry($userInfo);
        $this->session->unset_userdata('salt');
        $this->session->sess_destroy();
        redirect('home');
    }

    public function dashboard() {
        try {
		$user_data = $this->session->userdata('user_data');
		$division = $user_data['state'];

		switch ($division){
			case "0":
			 $data['demands'] = $this->common_model->getCountAllDemands();
			break;
			case "1":

			$data['newapplicationTwenty'] = $this->common_model->getCountHqrsNewApplication($this->ids);
			// getCountHqrsNineteenApplication()/getCountHqrsEighteenApplication() removed:
			// both fed spans that only ever render inside an HTML comment block
			// ("Commented Start Manoj 27-02-2025" in dashboard.php), so the values
			// were computed every request but never actually shown to the user.
			// Each was a multi-second query. Kept as 0 so nothing breaks if referenced.
			$data['newapplicationNineteen'] = 0;
			$data['newapplicationEighteen'] = 0;
			$data['newallapplication'] = $this->common_model->getCountAllHqrsNewApplication($this->ids);

            	$data['countresponseSetByHqToMission'] = $this->common_model->getCountUniversityResponseSentByHqrsToMission();

                // getCountUniversityResponseSentByRoToMissions()/...ToMission() removed:
                // same dead-comment pattern as above, each a multi-second query feeding
                // spans that only render inside HTML comments in dashboard.php.
                $data['countresponseSetByRoToMissions'] = 0;
                $data['countresponseSetByRoToMission'] = 0;

            	$data['underprocess'] = $this->common_model->getCountPendingUnderRegionalApplications($this->ids);

            	$confapps = $this->common_model->getAppNoRegionalApplicationsConfirmationtoHqrs($this->ids);

	            $confirms = 0;
	            $notconfirms = 0;
	            if (count($confapps) > 0) {
	                // Batched: one query for all applications instead of one query
	                // per application (was a severe N+1 loop here).
	                $responsesByApp = $this->common_model->getUniversityResponsesBatch(array_column($confapps, 'application_no'));
	                foreach ($confapps as $app) {
	                    $responseStr = $responsesByApp[$app['application_no']]['response'] ?? null;
	                    if ($responseStr != "2,2,2") {
	                        $confirms++;
	                    } elseif ($responseStr == "2,2,2") {
	                        $notconfirms++;
	                    }
	                }
	            }
	            $data['confirmationfromROs'] = $confirms;


	            $data['confirmationfromallROs'] = $notconfirms;

	            $data['acceptance'] = $this->common_model->countApplicantAcceptance($this->ids);

	            $data['alunamiapplication'] = $this->common_model->getCountAllAlumaniApplications();

            	$data['demands'] = $this->common_model->getCountAllDemands();

			break;

			case "2": case "3": case "4": case "5": case "6": case "7": case "8": case "9": case "10":
            
			$vars = array();
				if(is_array($this->ids))
				{
					$ids = implode(",",$this->ids);	
				}
				else
				{
					$ids = $this->ids;
				}


               
			$d = $this->reports->getTotalStudentDetailsReport($vars,$ids);
           
			$data['students'] = $d[0]['total'];
			$data['alunamiapplication'] = $this->common_model->getCountAllAlumaniApplications();
			break;
			case "-10":
			$data['icar_applications'] = $this->common_model->getCountHqrsICARApplication($this->ids);
            	$data['icar_processed'] = $this->common_model->getCountHqrsICARProcessedApplication($this->ids);
			break;
			case "-20":
			$data['ayush_applications'] = $this->common_model->getCountHQRSAYUSHApplication($this->ids);
			$data['ayush_sfs_applications'] = $this->common_model->getCountHQRSAYUSHApplicationsfs();
            	$data['ayush_processed'] = $this->common_model->getCountHQRSAYUSHProcessedApplication($this->ids);
				$data['ayush_sfs_processed'] = $this->common_model->getCountHQRSAYUSHProcessedApplicationsfs();
			break;
			default:
			$data['newapplication'] = $this->common_model->getCountHqrsNewApplication($this->ids);
			
            	$data['underprocess'] = $this->common_model->getCountPendingUnderRegionalApplications($this->ids); 
            	$confapps = $this->common_model->getAppNoRegionalApplicationsConfirmationtoHqrs($this->ids);
	            $confirms = 0;
	            $notconfirms = 0;
	            if (count($confapps) > 0) {
	                // Batched: one query for all applications instead of one query
	                // per application (was a severe N+1 loop here).
	                $responsesByApp = $this->common_model->getUniversityResponsesBatch(array_column($confapps, 'application_no'));
	                foreach ($confapps as $app) {
	                    $responseStr = $responsesByApp[$app['application_no']]['response'] ?? null;
	                    if ($responseStr != "2,2,2") {
	                        $confirms++;
	                    } elseif ($responseStr == "2,2,2") {
	                        $notconfirms++;
	                    }
	                }
	            }
	            $data['confirmationfromROs'] = $confirms;
	            $data['acceptance'] = $this->common_model->countApplicantAcceptance($this->ids);
	            $data['alunamiapplication'] = $this->common_model->getCountAllAlumaniApplications();
			break;
			}
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/dashboard', $data);
            $this->load->view('iccr/footer');

        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');

        }
    }

    function savefourthchoice() {
        $applicationId = $this->uri->segment(3);
    }

    function processfourthchoice() {
        try {
            $applicationId = $this->uri->segment(3);
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
            $data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/processfourthchoice', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function forwardtoMission() {
        try {
            $appno = $this->uri->segment(3);
            $data = array(
                'iccr_status' => 1,
                'status' => 10
            );
            $sts = $this->common_model->ConfirmationForwardToMissionByHqrs($data, $appno);
            if ($sts) {
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('success', 'Application Forwarded Successfully!');
                redirect(site_url() . 'headquarter/confirmationfromROs');
            } else {
                $this->session->set_flashdata('message_type', 'error');
                $this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
                redirect(site_url() . 'headquarter/confirmationfromROs');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function payexpendituretoregion() {
        try {
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/payexpendituretoregion');
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function applicantAcceptanceStatus() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');

            $data['applicaitonStepOne'] = $this->common_model->getHeadquarterApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }
            $data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
            $data['userImage'] = $image;
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $data['mappingData'] = $this->common_model->getMappingData($applicationId);
            $data['listofacceptance'] = $this->common_model->applicantAcceptance($applicationId);
            $data['universityData'] = $this->common_model->getConfirmationofApplicationIds($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/applicantAcceptanceView', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            show_404();
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function viewAcademicdetialsold() {
        try {
            $applicationId = $this->uri->segment(3);
            $data['academic'] = $this->common_model->getAcademicDataforReport($applicationId);
            $data['academicStatus'] = $this->common_model->getAcademicStatusDataforReport($applicationId);
            $data['academic_data'] = $this->common_model->getAcademicDataforReport($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/accademicReportofOldStudent', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function viewAcademicdetials() {
        try {
            $applicationId = $this->uri->segment(3);
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            $data['mapdata'] = $this->common_model->getMappingData($applicationId);
            $data['academic'] = $this->common_model->getAcademicStatusDataforReport($applicationId);
            $data['academic_data'] = $this->common_model->getHeadquarterAcademicDataforReport($applicationId,$this->ids);
            $userId = $data['applicaitonStepOne'][0]['uid'];
            $data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
            $imgArray = $this->common_model->getUserImage($userId);
            if (count($imgArray) > 0) {
                $data['userImage'] = $imgArray[0]['name'];
            } else {
                $data['userImage'] = '';
            }
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/accademicReportofStudent', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function applicantAcceptance() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 1 || $division == -20) {
                $data['listofacceptance'] = $this->common_model->applicantAcceptance($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/listofacceptance', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	   function applicantAyushAcceptance() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division == 1 || $division == -20) {
                $data['listofacceptance'] = $this->common_model->applicantAyushAcceptance($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/listofAyushAcceptance', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
    function confirmationForwardtoMissionbyHqrs() {
        try {
            $data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getconfirmationForwardtoMissionbyHqrs();
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/confirmationForwardtoMissionbyHqrs', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function application() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $userId = $this->common_model->getUserIdbyApplicationNo($applicationId);
            $imgArray = $this->common_model->getUserImage($userId[0]['uid']);
            if (count($imgArray) > 0) {
                $data['userImage'] = $imgArray[0]['name'];
            } else {
                $data['userImage'] = '';
            }
            $data['missions'] = $this->common_model->getAllMissions();
            $data['univercities'] = $this->common_model->getUnivercities();
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            if (count($data['applicaitonStepOne']) > 0) {
                $data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
            } else {
                $data['get_application_number'] = $this->random_num(15);
            }
            $data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
            $data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
            $data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/applicant_personal_info', $data);
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    function Expenditure() {
        try {
            $this->load->view('iccr/header_mission');
            $this->load->view('iccr/expenditure');
            $this->load->view('iccr/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }

    public function downloadApplication() {
        try {
            $appno = $this->uri->segment(3);

            $content = $this->input->post("myHTML");
            $this->load->library('mpdf60/Mpdf');
            $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
            $mpdf->SetFont('Arial', 'B', 9);
            $mpdf->SetWatermarkText('Indian Council For Cultural Relations');
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Application Form For Scholarship through ICCR</h3><br/>";
            $html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>Ref. No." . $appno . '<br/>' . date("jS F Y h:i:s") . "</div>";
            $html = $content;
            $imgArray = $this->common_model->getUserImage($data[0]['uid']);

            $mpdf->SetDisplayMode('fullpage');
            // LOAD a stylesheet
            $stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css');

            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
            $mpdf->WriteHTML($stylesheet1, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css');
            $mpdf->WriteHTML($stylesheet2, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
            $mpdf->WriteHTML($stylesheet3, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
            $mpdf->WriteHTML($stylesheet4, 1); // The parameter 1 tells that this is css/style only and no body/html/text

            $stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
            $mpdf->WriteHTML($stylesheet5, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $mpdf->WriteHTML($html1, 2);
            $mpdf->WriteHTML($content);
            $mpdf->Output();
        } catch (HTML2PDF_exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
            exit;
        }
    }

    public function createCaptcha($config = array()) {
        if (!function_exists('gd_info')) {
            throw new Exception('Required GD library is missing');
        }

        $bg_path = dirname(__FILE__) . 'assets/site/main/images/captcha_bg/backgrounds/';
        $font_path = dirname(__FILE__) . 'assets/site/main/fonts/captcha_fonts/';

        // Default values
        $captcha_config = array(
            'code' => '',
            'min_length' => 5,
            'max_length' => 5,
            'backgrounds' => array(
                $bg_path . '45-degree-fabric.png',
                $bg_path . 'cloth-alike.png',
                $bg_path . 'grey-sandbag.png',
                $bg_path . 'kinda-jean.png',
                $bg_path . 'polyester-lite.png',
                $bg_path . 'stitched-wool.png',
                $bg_path . 'white-carbon.png',
                $bg_path . 'white-wave.png'
            ),
            'fonts' => array(
                $font_path . 'times_new_yorker.ttf'
            ),
            'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
            'min_font_size' => 28,
            'max_font_size' => 28,
            'color' => '#666',
            'angle_min' => 0,
            'angle_max' => 10,
            'shadow' => true,
            'shadow_color' => '#fff',
            'shadow_offset_x' => -1,
            'shadow_offset_y' => 1
        );

        // Overwrite defaults with custom config values
        if (is_array($config)) {
            foreach ($config as $key => $value)
                $captcha_config[$key] = $value;
        }

        // Restrict certain values
        if ($captcha_config['min_length'] < 1)
            $captcha_config['min_length'] = 1;
        if ($captcha_config['angle_min'] < 0)
            $captcha_config['angle_min'] = 0;
        if ($captcha_config['angle_max'] > 10)
            $captcha_config['angle_max'] = 10;
        if ($captcha_config['angle_max'] < $captcha_config['angle_min'])
            $captcha_config['angle_max'] = $captcha_config['angle_min'];
        if ($captcha_config['min_font_size'] < 10)
            $captcha_config['min_font_size'] = 10;
        if ($captcha_config['max_font_size'] < $captcha_config['min_font_size'])
            $captcha_config['max_font_size'] = $captcha_config['min_font_size'];

        // Generate CAPTCHA code if not set by user
        if (empty($captcha_config['code'])) {
            $captcha_config['code'] = '';
            $length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
            while (strlen($captcha_config['code']) < $length) {
                $captcha_config['code'] .= substr($captcha_config['characters'], mt_rand() % (strlen($captcha_config['characters'])), 1);
            }
        }
        $image_src = site_url() . 'home/getCaptcha?_CAPTCHA&amp;t=' . urlencode(microtime());

        $cnfg = array('config' => serialize($captcha_config));
        $this->session->set_userdata('captcha', $cnfg);
        return array(
            'code' => $captcha_config['code'],
            'image_src' => $image_src
        );
    }

    function random_num($size) {
        $alpha_key = '';
        $keys = range('A', 'Z');

        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }
        $length = $size - 2;
        $key = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $alpha_key . $key;
    }

    public function getCaptcha() {

        $captcha_cnf = array();
        $cnf = $this->session->userdata('captcha');
        $captcha_config = unserialize($cnf['config']);

        if (!$captcha_config)
            exit();

        //$this->session->unset_userdata('captcha');	    
        // Pick random background, get info, and start captcha
        $background = $captcha_config['backgrounds'][mt_rand(0, count($captcha_config['backgrounds']) - 1)];
        list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);

        $captcha = imagecreatefrompng($background);

        $color = $this->hex2rgb($captcha_config['color']);
        $color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);

        // Determine text angle
        $angle = mt_rand($captcha_config['angle_min'], $captcha_config['angle_max']) * (mt_rand(0, 1) == 1 ? -1 : 1);

        // Select font randomly
        $font = $captcha_config['fonts'][mt_rand(0, count($captcha_config['fonts']) - 1)];

        // Verify font file exists
        if (!file_exists($font))
            throw new Exception('Font file not found: ' . $font);

        //Set the font size.
        $font_size = mt_rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
        $text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);

        // Determine text position
        $box_width = abs($text_box_size[6] - $text_box_size[2]);
        $box_height = abs($text_box_size[5] - $text_box_size[1]);
        $text_pos_x_min = 0;
        $text_pos_x_max = ($bg_width) - ($box_width);
        $text_pos_x = mt_rand($text_pos_x_min, $text_pos_x_max);
        $text_pos_y_min = $box_height;
        $text_pos_y_max = ($bg_height) - ($box_height / 2);
        if ($text_pos_y_min > $text_pos_y_max) {
            $temp_text_pos_y = $text_pos_y_min;
            $text_pos_y_min = $text_pos_y_max;
            $text_pos_y_max = $temp_text_pos_y;
        }
        $text_pos_y = mt_rand($text_pos_y_min, $text_pos_y_max);

        // Draw shadow
        if ($captcha_config['shadow']) {
            $shadow_color = $this->hex2rgb($captcha_config['shadow_color']);
            $shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
            imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);
        }

        // Draw text
        imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);

        // Output image
        header("Content-type: image/png");
        imagepng($captcha);
    }

    function hex2rgb($hex_str, $return_string = false, $separator = ',') {
        $hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
        $rgb_array = array();
        if (strlen($hex_str) == 6) {
            $color_val = hexdec($hex_str);
            $rgb_array['r'] = 0xFF & ($color_val >> 0x10);
            $rgb_array['g'] = 0xFF & ($color_val >> 0x8);
            $rgb_array['b'] = 0xFF & $color_val;
        } elseif (strlen($hex_str) == 3) {
            $rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
            $rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
            $rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
        } else {
            return false;
        }
        return $return_string ? implode($separator, $rgb_array) : $rgb_array;
    }

    public function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    function calcFY($startDate, $endDate) {

        $prefix = '';

        $ts1 = strtotime($startDate);
        $ts2 = strtotime($endDate);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        //get months
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        /**
         * if end month is greater than april, consider the next FY
         * else dont consider the next FY
         */
        $total_years = ($month2 > 4) ? ceil($diff / 12) : floor($diff / 12);

        $fy = array();

        while ($total_years >= 0) {

            $prevyear = $year1 - 1;

            //We dont need 20 of 20** (like 2014)
            //  $fy[] = $prefix.substr($prevyear,-2).'-'.substr($year1,-2);
            $fy[] = $prevyear . '-' . $year1;

            $year1 += 1;

            $total_years--;
        }
        /**
         * If start month is greater than or equal to april, 
         * remove the first element
         */
        if ($month1 >= 4) {
            unset($fy[0]);
        }
        /* Concatenate the array with ',' */
        return $fy;
    }

    public function download_zip($path) {
        $applicationId = $this->uri->segment(3);
        $fy = $this->uri->segment(4);
        $yearArray = explode('-', $fy);
        $bankDetails = $this->common_model->getBankingDetails($applicationId, "");
        if (count($bankDetails) > 0) {
            $path = FCPATH . "assets/site/main/bank_docs/";
            foreach ($bankDetails as $bankDetail) {
                if ($bankDetail['bank_doc'] != "") {
                    $filename = $bankDetail['bank_doc'];
                    $this->load->library('zip');
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $permitDetails = $this->common_model->getPermitDetails($applicationId, "");
        if (count($permitDetails) > 0) {
            $path = FCPATH . "assets/site/main/permit_docs/";
            foreach ($permitDetails as $permit) {
                if ($permit['permit_doc'] != "") {
                    $filename = $permit['permit_doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $advstipendDetails = $this->common_model->getAdvStipendByFYofAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($advstipendDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($advstipendDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $stipendDetails = $this->common_model->getStipendByFYByAppno($yearArray[0], $yearArray[1], $applicationId);
        if (count($stipendDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($stipendDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $hraDetails = $this->common_model->gethraByFYByAppno($yearArray[0], $yearArray[1], $applicationId);
        if (count($hraDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($hraDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $acaDetails = $this->common_model->getACAbyFYByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($acaDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($acaDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $studyTourDetails = $this->common_model->getStudyTourbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
        if (count($studyTourDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($studyTourDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $MRDetails = $this->common_model->getMedicalReimbrusmentbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
        if (count($MRDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($MRDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $ThesisDetails = $this->common_model->getThesisbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
        if (count($ThesisDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($ThesisDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $TravelDetails = $this->common_model->getTravelDetailsbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
        if (count($TravelDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($TravelDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $ocfDetails = $this->common_model->getOCFByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($ocfDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($ocfDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $tfDetails = $this->common_model->getTFByByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($tfDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($tfDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $hostelDetails = $this->common_model->getHostelChargesByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($hostelDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($hostelDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getEnglishBridgeByFY = $this->common_model->getEnglishBridgeByappid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getEnglishBridgeByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getEnglishBridgeByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $oreientDetails = $this->common_model->getOrientChargesByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($oreientDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($oreientDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getCampsByFY = $this->common_model->getCampsByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getCampsByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getCampsByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getISAByFY = $this->common_model->getISAByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getISAByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getISAByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getSumptuaryByFY = $this->common_model->getSumptuaryByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getSumptuaryByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getSumptuaryByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getEmergencyFundByFY = $this->common_model->getEmergencyFundByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getEmergencyFundByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getEmergencyFundByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getStudentDayByFY = $this->common_model->getStudentDayByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getStudentDayByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getStudentDayByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getJoiningDoc = $this->common_model->getJoiningDoc($applicationId);
        if (count($getJoiningDoc) > 0) {
            $path = FCPATH . "assets/site/main/joining_doc/";
            foreach ($getJoiningDoc as $joind) {
                if ($joind['joining_doc'] != "") {
                    $filename = $joind['joining_doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $this->zip->download($applicationId . '_documents' . '.zip');
    }
function getUniversityResponseSentByHqToMission() {      
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      
      
        $data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByHqrsToMission($res);
        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/getUniversityResponseSentByHqToMission', $data);
        $this->load->view('iccr/footer');
      
    }
	
	//vipin
	function getUniversityResponseSentByHqarsToMission() {      
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      
      
        $data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByRoToMission($res);
        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/getUniversityResponseSentByRoToMission', $data);
        $this->load->view('iccr/footer');
      
    }
	
	function getUniversityResponseSentByHqToMission5() {      
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      
      
        $data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByHqrsToMission5($res);
        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/getUniversityResponseSentByHqToMission5', $data);
        $this->load->view('iccr/footer');
      
    }
	
	function getUniversityResponseSentByHqToMission7() {      
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      
      
        $data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByHqrsToMission7($res);
        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/getUniversityResponseSentByHqToMission5', $data);
        $this->load->view('iccr/footer');
      
    }
	
	function getUniversityResponseSentByHqarsToMissiondemo() {     

		$data['year'] = $this->uri->segment(3);
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      
      
        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/getUniversityResponseSentByHqToMission1', $data);
        $this->load->view('iccr/footer');
      
    }


	function downloadcsv(){
		
	 $file_name = 'student_details_on_'.date('Ymd').'.csv'; 
     header("Content-Description: File Transfer"); 
     header("Content-Disposition: attachment; filename=$file_name"); 
     header("Content-Type: application/csv;");
   
     // get data 
	 		$year = $this->uri->segment(3);
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->hqrs_model->getUniversityResponseSentByHqrsToMission($year,$vars,$res);
		$totalResult = $this->hqrs_model->getTotalUniversityResponseSentByHqrsToMission($year,$vars,$res);

     // file creation 
     $file = fopen('php://output', 'w');
 
     $header = array("Sr.No.","Applicant No","Applicant Name","Email Id","Country","Mission","Scheme","Programme","Course","University","Region","Year","Mobile No.","WhasApp No.","Passport No.","Passport Date of Issue","Passport Date of Expiry","Passport Place of Issue","Academic Year","Place of Birth","Visa No","Visa Date of Issue","Visa Date of Expiry","Date of Arrival","Joining Date of Course","Total Duration","Created Date"); 
     fputcsv($file, $header);
       $cnt=1;
		if(!empty($result))
		{
			foreach($result as $r)
			{
				$output= array();
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($r['application_no']);
				$country = $this->common_model->getCountryById($r['nationality']);
				$missions = $this->common_model->getAllMissions();
				$missionname="";
				foreach($missions as $mission)
	       						{
	       							
										if($applicaitonStepThree[0]['application_through'] == $mission['id'])
										{
											$missionname = $mission['mission_name'];
										}										
										
	       						}
				$sch = $this->common_model->getSchemeById($r['scholarship_id']);
                                $scheme = $sch[0]['scheme_name'];
				$confirmData = $this->common_model->getFinalUniversityById($r['regional_university']);	
				
				//echo '<pre>';print_r($confirmData);die;
				
			$program = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
			$region = $this->common_model->getRegionById($r['region_one_status']);
            //$undetaking = date('d-m-Y',$date2)
            if($r['undertaking_doc']!=""){
                $undertaking_date=date('d-m-Y',$r['undertaking_doc']);
               }else{
                  $undertaking_date="";
               }

               $visa_isuue_date="";
               if($r['visa_isuue_date']!=null){
                 $visa_isuue_date=date_format(date_create($r['visa_isuue_date']),'d-m-Y');
              }
              
              $visa_to_date="";
              if($r['visa_to_date']!=null){
                $visa_to_date=date_format(date_create($r['visa_to_date']),'d-m-Y');
             }


			$date2 = $r['SubmitDate'];	
             if($r['travel_arrival_date']!=""){
              $ariable_date=$r['travel_arrival_date'];
             }else{
                $ariable_date="";
             }
			 $narray=array($cnt,$r['application_no'],$r['fullname'].' '.$r['middlename'].' '.$r['familyname'],
			 $r['email'],$r['country_name'],$missionname,$scheme,$program[0]['name'],$r['final_course'],$confirmData[0]['name'],$region[0]['name'],
			 date('d-m-Y',$date2),$r['phone_number'],$r['whatsapp_number'],strtoupper($r['passport_no']),$r['passport_issue_date'],$r['passport_expiry_date'],$r['passport_issue_place'],$r['acedemic_year'],$r['city'],$r['visa_no'],$visa_isuue_date,$visa_to_date,$ariable_date,$r['date_of_joining'],$r['duration_of_course']
             ,$undertaking_date
			 );	 
			 $cnt++;
			fputcsv($file, $narray); 		
			}
			
		}
	 
     fclose($file); 
     exit; 

	}
	
	function confirmationReceivedWithFormat()
	{
		try
		{
			$doc = array();
			$applicationId = $this->uri->segment(3);
			$uniid = $this->uri->segment(4);
			$response = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$region = 0;$coursename = "";$respFile="";
			if(count($response)>0)
			{
				foreach($response as $resp)
				{
					if($resp['university_is_accept'] == 1 && $resp['regional_university'] == $uniid)
					{
						$respFile = $resp['region_one_doc'];
						$region = $resp['region_one_status'];
						$coursename = $resp['course'];
						array_push($doc,$resp['region_one_doc']);
					}
				}
			}
			
			$student_registerDate = $this->common_model->getStudentRegistratioYear($applicationId);
			$registerDate = $student_registerDate[0]['created'];
			$studentRegisterYear= date('d-m-Y', $registerDate);
			$compareDate = '15-12-2018';
			$date = date_create($studentRegisterYear);
			$array =  (array) $date;
			$miss = date("Y-m-d", strtotime($array['date']));
			$date1=date_create($miss);
            $date2=date_create($compareDate);
            $diff=date_diff($date1,$date2);
            $intDiff = $diff->format("%R%a");
			
            $intDiff = intval($intDiff);
	
			 if ($intDiff > 0){
				 
				 $current  = '15-12-2018';
					$fy = $this->getFinancialYears($current,1);
					 }
                 else 
				 {
					$current = date('d-m-Y');
					$fy = $this->getFinancialYears($current,1);
				 }
			
			
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$studentOther = $this->common_model->getStudentOtherDetails($applicationId);
			$mission = $this->common_model->getMissionInfo($studentOther[0]['application_through']);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$regionInfo = $this->common_model->getRegionById($region);
			$uninmae = $this->common_model->getUniversityStateById($uniid);
			$this->load->file('fpdi/PdfHTMLTable.php');
			
			
			$this->load->library('mpdf60/Mpdf');
			$pdf = new PdfHTMLTable();
			$pdf->AddPage('P');
			$pdf->SetXY(10.0,5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial','',7);
			$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
			$pdf->MultiCell(180,5,'Date: '.date('d M Y h:i:s'),'','R');
			
			$pdf->SetXY(10.0,45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations',false);		
			$pdf->SetFont('Arial','',10);	
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',35);
			$pdf->SetTextColor(221,221,255);
			$pdf->RotatedText(35,190,'Indian Council For Cultural Relations',45);
			$pdf->SetFont('Arial','',10);	
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(180,5,$mission[0]['mission_type'].': '.$mission[0]['mission_name'],'','L');
			
			$pdf->MultiCell(180,5,$mission[0]['country_name'],'','L');
			
			$pdf->MultiCell(180,5,'To     :	HoC / Education Wing / Culture Wing','','L');
			
			$pdf->MultiCell(180,5,'From :	Scholarship Division, ICCR, '.$regionInfo[0]['name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year 2020-2021. Mr./Ms. '.$stepOne[0]['fullname'].' is provisionally confirmed for '.$coursename.' course at '.$uninmae[0]['name'].', Regional Office '.$regionInfo[0]['name'].' subject to production of all original documents at the time of joining','','J');
			
			
		    $pdf->Ln(5);		
			$pdf->MultiCell(180,5,'Mission is requested to immediately take the following action:-','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'a)	Inform the candidate & convey his/her acceptance or rejection of the offer to ICCR at the earliest.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'b)	Obtain a written Undertaking from the student in the attached Proforma & email/fax it to ICCR. isd1section.iccr@nic.in / isd2section.iccr@nic.in / poafghan.iccr@nic.in','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'c)	Issue appropriate fulltime Student Visa (Research Visa in case of Ph.D.) to the student in accordance with the latest guidelines. The mission must issue the appropriate visa.','','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'d) 	Inform the scholars to report to Scholarship Division, Indian Council for Cultural Relations  (ICCR),'.$regionInfo[0]['name'].' or The Head, Department of '.$coursename.', '.$uninmae[0]['name'].', Regional Office '.$regionInfo[0]['name'].' alongwith all original certificates and testimonials and academic transcript in English  or prescribed date in the attached acceptance letter of the university, failing which admission will be cancelled.','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'e)	Please ensure that the student brings all his/her documents/Credentials/Mark Sheets in English language only.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'f)	Also inform him/her of the requirement to register with the local FRO/FRRO within 7/14 days of arrival in India or as per Indian Mission’s instruction on his/her passport.','','J');		
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'g)	Advice the scholar to carry with him/her some money to meet incidental expenses on arrival (a minimum of INR 35,000/- is recommended) also brief the scholar on living conditions in India and the Terms & Conditions of ICCR’s scholarship.  Including the fact that living in hostel accommodation is compulsory.','','J');	
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'h)	You may inform to the candidate he/she is entitled for scholarship dues upto declaration of result only.','','J');
			
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'i)	To carry all original documents with them.','','J');		
			$pdf->Ln(5);	
			$pdf->SetFont('Arial','B');	
			$pdf->MultiCell(170,5,'Note:	Please do not send us acceptances which exceed the number of slots allotted to your country under specific scheme.','','L');	
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Regards,','','L');	
			
			$pdf->MultiCell(170,5,'Scholarship Division','','R');
			
			$pdf->MultiCell(170,5,'ICCR,'.$regionInfo[0]['name'],'','R');
			
			$pdf->MultiCell(170,5,'File No. ('.$applicationId.')/'.$fy[0] ,'','L');
			
			$filename = $applicationId."_University_Response_".date('jS-F-Y-h-i-s').'.pdf';
			
			$filenamePath = FCPATH."assets/site/main/accept/".$filename;
			$pdf->Output($filename,"D");
		}
		catch(Throwable $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');

			redirect(site_url().'headquarter/dashboard');
		}

	}
        function counts()
        {
			$data = array();
			$fy = "2018-2019";
			
		if(is_array($this->ids))
		{
			$ids = implode(",",$this->ids);	
		}
		else
		{
			$ids = $this->ids;
		}
	        $res = $this->common_model->getTotalCountReport($ids);
	        foreach ($res as $val)  
	        {
                $nestedData['totalCount'] = $val['totalCount'];
                $nestedData['totalAccepted'] = $val['totalAccepted'];
                $nestedData['totalRejected'] = $val['totalRejected'];
                $nestedData['totalMale'] = $val['totalMale'];
                $nestedData['totalFemale'] = $val['totalFemale'];
                $nestedData['totalUG'] = $val['totalUG'];
                $nestedData['totalPG'] = $val['totalPG'];
                $nestedData['totalMphil'] = $val['totalMphil'];
                $nestedData['totalPHD'] = $val['totalPHD'];
                $nestedData['totalAdmitted'] = $val['totalAdmitted'];
                
                
                $totalExp = 0;
                
                $aca = $this->reports->getACATotalExp($ids,$fy);
                $getAdvanceStipnedTotalExp = $this->reports->getAdvanceStipnedTotalExp($ids,$fy);
                $getCamps = $this->reports->getCamps($ids,$fy);
                $getDeduction = $this->reports->getDeduction($ids,$fy);
                $getEmergencyFund = $this->reports->getEmergencyFund($ids,$fy);
                $getEngBridgeCourse = $this->reports->getEngBridgeCourse($ids,$fy);
                $getHostel = $this->reports->getHostel($ids,$fy);
                $getHRA = $this->reports->getHRA($ids,$fy);
                $getisaMeeting = $this->reports->getisaMeeting($ids,$fy);
                $getmedicalReEmbust = $this->reports->getmedicalReEmbust($ids,$fy);
                $getMicsellanious = $this->reports->getMicsellanious($ids,$fy);
                $getMisUniversity = $this->reports->getMisUniversity($ids,$fy);
                $getNationalDay = $this->reports->getNationalDay($ids,$fy);
                $getOrientProg = $this->reports->getOrientProg($ids,$fy);
                $getOtherFee = $this->reports->getOtherFee($ids,$fy);
                $getStipned = $this->reports->getStipned($ids,$fy);
                $getStudentDay = $this->reports->getStudentDay($ids,$fy);
                $getStudyTour = $this->reports->getStudyTour($ids,$fy);
                $getSump = $this->reports->getSump($ids,$fy);
                $getthesis = $this->reports->getthesis($ids,$fy);
                $getTravel = $this->reports->getTravel($ids,$fy);
                $getTutFee = $this->reports->getTutFee($ids,$fy);
                
               
           
                
                if(count($aca)>0){$totalExp = $totalExp + $aca[0]['totalamount'];}
                
				if(count($getAdvanceStipnedTotalExp)>0){$totalExp = $totalExp + $getAdvanceStipnedTotalExp[0]['totalamount'];}
				if(count($getCamps)>0){$totalExp = $totalExp + $getCamps[0]['totalamount'];}
				if(count($getDeduction)>0){$totalExp = $totalExp + $getDeduction[0]['totalamount'];}
				if(count($getEmergencyFund)>0){$totalExp = $totalExp + $getEmergencyFund[0]['totalamount'];}
				if(count($getEngBridgeCourse)>0){$totalExp = $totalExp + $getEngBridgeCourse[0]['totalamount'];}
				if(count($getHostel)>0){$totalExp = $totalExp + $getHostel[0]['totalamount'];}
				if(count($getHRA)>0){$totalExp = $totalExp + $getHRA[0]['totalamount'];}
				if(count($getisaMeeting)>0){$totalExp = $totalExp + $getisaMeeting[0]['totalamount'];}
				if(count($getmedicalReEmbust)>0){$totalExp = $totalExp + $getmedicalReEmbust[0]['totalamount'];}
				if(count($getMicsellanious)>0){$totalExp = $totalExp + $getMicsellanious[0]['totalamount'];}
				if(count($getMisUniversity)>0){$totalExp = $totalExp + $getMisUniversity[0]['totalamount'];}
				if(count($getNationalDay)>0){$totalExp = $totalExp + $getNationalDay[0]['totalamount'];}
				if(count($getOrientProg)>0){$totalExp = $totalExp + $getOrientProg[0]['totalamount'];}
				if(count($getOtherFee)>0){$totalExp = $totalExp + $getOtherFee[0]['totalamount'];}
				if(count($getStipned)>0){$totalExp = $totalExp + $getStipned[0]['totalamount'];}
				if(count($getStudentDay)>0){$totalExp = $totalExp + $getStudentDay[0]['totalamount'];}
				if(count($getStudyTour)>0){$totalExp = $totalExp + $getStudyTour[0]['totalamount'];}
				if(count($getSump)>0){$totalExp = $totalExp + $getSump[0]['totalamount'];}
				if(count($getthesis)>0){$totalExp = $totalExp + $getthesis[0]['totalamount'];}
				if(count($getTravel)>0){$totalExp = $totalExp + $getTravel[0]['totalamount'];}
				if(count($getTutFee)>0){$totalExp = $totalExp + $getTutFee[0]['totalamount'];}
				
                $nestedData['totalamount'] = $totalExp;
                
                $data[] = $nestedData; 
	        }
	        $result['totalrecords'] = $data;
	       
	        $this->load->view('iccr/header_mission');
	        $this->load->view('iccr/counts', $result);
	        $this->load->view('iccr/footer');
		}
        function getSchemewiseApplicantReport() {
        $data = array();
        $res = $this->common_model->getTotalApplicantStatusReport($this->ids);
        foreach ($res as $val)  
         {
                $nestedData['fullname'] = $val['fullname'];
                $nestedData['application_no'] = $val['application_no'];
                $nestedData['email'] = $val['email'];
                $nestedData['scheme_name'] = $val['scheme_name'];
                $nestedData['university_is_accept'] = $val['university_is_accept'];
				$nestedData['created'] = $val['created'];
                $data[] = $nestedData; 
         }
      
        
        $result['totalrecords'] = $data;
       
        $this->load->view('iccr/header_mission');
        $this->load->view('iccr/getSchemewiseApplicantRecord', $result);
        $this->load->view('iccr/footer');
    }
    /* Reports Section */
    public function getStudentDetails()
    {
		$vars = $this->input->post();
		if(is_array($this->ids))
		{
			$ids = implode(",",$this->ids);	
		}
		else
		{
			$ids = $this->ids;
		}
		$result = $this->reports->getStudentDetailsReport($vars,$ids);
		$totalResult = $this->reports->getTotalStudentDetailsReport($vars,$ids);
		
		$response = array();
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				$gender = "";
				$output= array();	
				$output[] = $counter;
				$output[] = $r['fullname'];
				$output[] = $r['email'];
				if($r['gender'] == 1)
				{
					$gender = "Male";
				}
				else if($r['gender'] == 2)
				{
					$gender = "Female";
				}
				
				$output[] = $gender;
				$programme = $this->common_model->getProgrammeById($r['programme']);
				$output[] = $programme[0]['name'];	
				$schem = $this->common_model->getSchemeById($r['scholarship_id']);			
				$output[] = $schem[0]['scheme_name'];
				$country = $this->common_model->getCountryById($r['country']);
				$output[] = $country[0]['country_name'];
				$output[] = '<a target="_blank"  href="'.site_url().'headquarter/applicationForm/'.$r['application_no'].'">Download</a>';
				$output[] = '<a target="_blank"  href="'.site_url().'headquarter/contactForm/'.$r['application_no'].'">Download</a>';
				$output[] = date("Y-m-d",$r['created']);
				$response[] = $output;
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	
	
	public function getExpStudentDetails()
	{
		// $data['studentexpenditure'] = $this->common_model->getReportOfAllStudentsApplications($this->ids);
        // $data['studentexpenditureold'] = $this->common_model->getOldReceivedApplication($this->ids);
		$vars = $this->input->post();
		if(count($this->ids)>1)
		{
			$ids = implode(",",$this->ids);	
		}
		else
		{
			$ids = $this->ids;
		}
		
		
		$result = $this->reports->getReportOfAllStudentsApplications($vars,$ids);
		
		$totalResult = $this->reports->getAllStudentDetailsReport($vars,$ids);
		$filted = count($totalResult);
		$response = array();
		if(!empty($result))
		{
			$counter = $vars['start']+1;
			foreach($result as $r)
			{
				$gender = "";
				$output= array();	
				$output[] = $counter;
				$output[] = $r['application_no'];
				$output[] = $r['fullname'];
				
				$output[] = $r['email'];
				if($r['gender'] == 1)
				{
					$gender = "Male";
				}
				else if($r['gender'] == 2)
				{
					$gender = "Female";
				}
				
				$output[] = $gender;
				$programme = $this->common_model->getProgrammeById($r['programme']);
				$output[] = $programme[0]['name'];	
				
				$country = $this->common_model->getCountryById($r['country']);
				
				$output[] = $country[0]['country_name'];
				$schem = $this->common_model->getSchemeById($r['scholarship_id']);			
				$output[] = $schem[0]['scheme_name'];				
				$fn = date('Y-m-d',strtotime($r['created']));
				$fy = $this->getFinancialYears($fn, 0);	
					
				if(count($fy)>1)
				{
					$output[] = $fy[0];	
				}
				else
				{
					$output[] = $fy[1];	
				}
				$region1 = $this->common_model->getRegionById($r['region_one_status']);
				//$region2 = $this->common_model->getRegionById($r['university_choice_two_state']);
				//$region3 = $this->common_model->getRegionById($r['university_choice_three_state']);
				$AllRegions = $region1[0]['name'];
				$output[] = $AllRegions;
				$status = $this->common_model->getApplicationUnderStatus($r['status']);
				$output[] = $status[0]['status'];
				$expenditureDatail = $this->common_model->isExpenditureReady($r['application_no']);
				$sts = "";
				if(count($expenditureDatail)>0)
				{								
				
				$sts ="<a class='form-control sbmt1' style='height:35px;width:140px;' href='javascript:void(0);' onclick=showExpenditureList('".$r['application_no']."');>View Details</a>";
	
				}
				else
				{
					$sts = "Not Released";
				}
				$output[] = $sts;
				$response[] = $output;
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	
	
	public function applicantExpenditureDemo() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division >= 0) {
                $current = date('Y-m-d');
                $current1 = date('Y-m-d', strtotime('-2 years'));
                $data['fy'] = $this->getFinancialYears($current, 1);
                $data['ofy'] = $this->getFinancialYears($current1, 5);
               
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/studentExpenditurelistDemo', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	public function getExpStudentDetailsDemo()
	{
		// $data['studentexpenditure'] = $this->common_model->getReportOfAllStudentsApplications($this->ids);
        // $data['studentexpenditureold'] = $this->common_model->getOldReceivedApplication($this->ids);
		$vars = $this->input->post();
		if(count($this->ids)>1)
		{
			$ids = implode(",",$this->ids);	
		}
		else
		{
			$ids = $this->ids;
		}
		
		
		$result = $this->reports->getReportOfAllStudentsApplications1($vars,$ids);
		$totalResult = $this->reports->getAllStudentDetailsReport1($vars,$ids);
		$filted = count($totalResult);
		$response = array();
		if(!empty($result))
		{
			$counter = $vars['start']+1;
			foreach($result as $r)
			{
				$gender = "";
				$output= array();	
				$output[] = $counter;
				$output[] = $r['application_no'];
				$output[] = $r['fullname'];
				
				$output[] = $r['email'];
				if($r['gender'] == 1)
				{
					$gender = "Male";
				}
				else if($r['gender'] == 2)
				{
					$gender = "Female";
				}
				
				$output[] = $gender;
				
				$programme = $this->common_model->getProgrammeById($r['programme']);
				$output[] = $programme[0]['name'];	
				
				$country = $this->common_model->getCountryById($r['country']);
				
				$output[] = $country[0]['country_name'];
				$schem = $this->common_model->getSchemeById($r['scholarship_id']);			
				$output[] = $schem[0]['scheme_name'];				
				$fn = date('Y-m-d',strtotime($r['created']));
				$fy = $this->getFinancialYears($fn, 0);	
					
				if(count($fy)>1)
				{
					$output[] = $fy[0];	
				}
				else
				{
					$output[] = $fy[1];	
				}
				$region1 = $this->common_model->getRegionById($r['region_one_status']);
				//$region2 = $this->common_model->getRegionById($r['university_choice_two_state']);
				//$region3 = $this->common_model->getRegionById($r['university_choice_three_state']);
				$AllRegions = $region1[0]['name'];
				$output[] = $AllRegions;
				$status = $this->common_model->getApplicationUnderStatus($r['status']);
				$output[] = $status[0]['status'];
				$expenditureDatail = $this->common_model->isExpenditureReady($r['application_no']);
				$sts = "";
				if(count($expenditureDatail)>0)
				{								
				
				$sts ="<a class='form-control sbmt1' style='height:35px;width:140px;' href='javascript:void(0);' onclick=showExpenditureList('".$r['application_no']."');>View Details</a>";
	
				}
				else
				{
					$sts = "Not Released";
				}
				$output[] = $sts;
				$response[] = $output;
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	
	
			 public function admittStudents() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
				if(is_array($this->ids))
			{
				$ids = implode(",",$this->ids);	
			}
			else
			{
				$ids = $this->ids;
				
			}
			
			
            if ($division > 0) {
				
				$current = date('Y-m-d');
                $current1 = date('Y-m-d', strtotime('-1 years'));
                $data['fy'] = $this->getFinancialYears($current, 1);
                $data['ofy'] = $this->getFinancialYears($current1, 5);
                $data['totalAdmitt'] = $this->common_model->getAllAdmittedStudents($this->ids);
                $data['schemes'] = $this->ids;
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/admittStudents', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	 public function getAdmittReports() {
        try {
			
				if(is_array($this->ids))
			{
				$ids = implode(",",$this->ids);	
			}
			else
			{
				$ids = $this->ids;
			}
			$vars = $this->input->post();
			$result = $this->common_model->getAllAdmittStudents($this->ids,$vars);
		    $totalResult = $this->common_model->getTotalAllAdmittStudents($this->ids,$vars);
            //$list = $this->common_model->get_student_admit_datatables($this->ids);

            $response = array();
            $no = $_POST['start'];
			$counter = 1;
            foreach ($result as $customers) {
                $no++;
                $output = array();
                $output[] = $no;
                $output[] = $customers['fullname'];
                $output[] = $customers['email'];
				$data = $this->common_model->getConfirmationofApplicationIds($customers['application_id']);
				$output[] = $data[0]->course;
				$scheme = $this->common_model->getSchemeById($customers['scholarship_id']);
				$output[] = $scheme[0]['scheme_name'];
			    $data = $this->common_model->getConfirmationofApplicationIds($customers['application_id']);
				$uni = $this->common_model->getUniversityById($data[0]->regional_university);
				$output[] = $uni[0]['name'];
                $output[] = $customers['country_name'];
                $output[] = date("Y-m-d",$customers['created']);				
                $sts = $this->common_model->getApplicationUnderStatus($customers['status']);
				
                $output[] = $sts[0]['status'];
				$expenditureDatail = $this->common_model->isExpenditureReady($customers['application_id']);
				$sts = "";
				if(count($expenditureDatail)>0)
				{								
				
				$sts ="<a class='form-control sbmt1' style='height:35px;width:140px;' href='javascript:void(0);' onclick=showExpenditureList('".$customers['application_id']."');>View Details</a>";
	
				}
				else
				{
					$sts = "Not Released";
				}
				$output[] = $sts;
				$output[] = '<a class="form-control sbmt1" style="height:30px;width:90px;margin-bottom: 8px;" href="'.site_url().'headquarter/scholarStatusView/'.$customers['application_id'].'" target = "__blank">View</a>';
				
				
                $response[] = $output;
            }
            $returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
			$returnJson['recordsTotal'] = $totalResult[0]['total'];
			$returnJson['recordsFiltered'] = $totalResult[0]['total'];
			$returnJson['data'] = $response;
			echo json_encode($returnJson);
            //output to json format
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	function scholarStatusView()
	{
		try{
			$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];			
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
		if(count($data['applicaitonStepOne'])>0)
		{
			$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
		}
		else
		{
			$data['get_application_number'] = $this->random_num(15);
		}	
		$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
		if(count($imgArray)> 0)
		{
			$image = $imgArray[0]['name'];
		}		
		else
		{
			$image = '';
		}
		$data['regionId'] =  $user_data['state'];	
		$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
		$data['userImage'] = $image;
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();	
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
		$data['mappingData'] = $this->common_model->getMappingData($applicationId);
		$data['universityData'] = $this->common_model->getconfirmationData($applicationId);
		$data['travelplan'] = $this->common_model->getAllTravelPlan($applicationId);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/scholarArrivedstatusView',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	//===============================Added by Rahul Dey 24-01-2019====================================
	
	public function getFeedbackList()
	{
		$data['feedback'] = $this->common_model->getAllFeedback();
		$this->load->view('iccr/header_mission');		
		$this->load->view('iccr/feedBackList',$data);
		$this->load->view('iccr/footer');	
	}
	
	function deleteFeedback()
	{
		$id = $_REQUEST['feedBackId'];
		$sts = $this->common_model->deleteFeedback($id);
		if($sts)
		{
			$response['status'] = TRUE;
		}
		else
		{
			 $response['status'] = FALSE;
		}
		echo json_encode($response);
	}
	
	
	function get_universityResponseSentByHqToMission() {   
		$year = $this->uri->segment(3);
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      
	
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->hqrs_model->getUniversityResponseSentByHqrsToMission($year,$vars,$res);
		$totalResult = $this->hqrs_model->getTotalUniversityResponseSentByHqrsToMission($year,$vars,$res);
		$response = array();
		$counter++;
		if(!empty($result))
		{
			foreach($result as $r)
			{
				$output= array();
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($r['application_no']);
				// $country removed: was never used in this function (result set
				// already provides $r['country_name'] directly), and $r['nationality']
				// doesn't exist in this query's result, so it only ever threw warnings.
				//$response1 = $this->common_model->getconfirmationDataByMission($r['application_no']);
				
					            $output[] = $counter;	
								$output[] = $r['application_no'];	
                                $output[] = $r['fullname'].' '.$r['middlename'].' '.$r['familyname']; 
                                $output[] = $r['email']; 
                                $output[] = $r['country_name'];
								$missions = $this->common_model->getAllMissions();
								$missionName = 'NA';
								foreach($missions as $mission)
	       						{

										if($applicaitonStepThree[0]['application_through'] == $mission['id'])
										{
											$missionName = $mission['mission_name'];
											break;
										}

	       						}
								$output[] = $missionName;
								$sch = $this->common_model->getSchemeById($r['scholarship_id']);
                                $output[] = $sch[0]['scheme_name'];
								
								$confirmData = $this->common_model->getFinalUniversityById($r['regional_university']);
								//print_r($confirmData);die;
								// $course = $r['subject'];
                                 $nomenclature = !empty($r['nomenclature']) ? $this->common_model->getnomenclatureByid($r['nomenclature']) : [];
                                 $course = $nomenclature[0]['title'] ?? '';
								 $output[] =  $course;
								 $output[] =  $confirmData[0]['name']; 
                                 
								 $region = $this->common_model->getRegionById($r['region_one_status']);
								 $output[] = !empty($region) ? $region[0]['name'] : 'NA';
                           
									$date2 = $r['SubmitDate'];	
				                    $output[] = date('d-m-Y',$date2);  
									 
									$userd = $this->common_model->getUserInfo($r['uid']); 
                                   //echo "<pre>";print_r($userd);die;
                                   $currentyear = date('Y');
                                    // $currentyear = 2023;
                                   //$ar = explode('/',$userd->dir);
                                    //$oldYear = $ar[2];
									//$file_path_un = '../../'.$currentyear.'/university_fee_structure/'.$r['fee_structure'];
									//echo $file_path_un;die;
									//$output[] = '<a target="_blank" href="'.site_url().'headquarter/downloadDocs/'.base64url_encode($file_path_un);'" target="_blank"><span class = "label label-success">Download</span></a>';
									if($r['university_is_accept'] == 1) {
						if(file_exists('./'.$currentyear.'/university_approval/'.$r['region_one_doc'])){

                   $file_path_un = './'.$currentyear.'/university_approval/'.$r['region_one_doc'];
                           if(strpos($r['region_one_doc'],'.pdf')){
							 $output[] = '<a href="'.site_url().'headquarter/downloadDocs/'.base64url_encode($file_path_un).'" target = "_blank"><span class = "label label-success">Download</span></a>';
						   }
                            else {
						$file_path_un = './'.$currentyear.'/university_approval/'.$r['region_one_doc'];
						if(file_exists($file_path_un)){
						     $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
				   $output[] = '<a download="'.rand().time().'" href="data:'.$mime_type.';base64,'.$data.'" target = "_blank"><span class = "label label-success">Download </span></a>';
						}else{
							$output[] = 'NA';
						}
							}

										}else{
								$output[] = '<a href="'.site_url().'assets/site/main/university_approval/'.$r['region_one_doc'].'" target = "_blank"><span class = "label label-success">Download</span></a>';
										}


                                        }else{
											$output[] = 'NA';
										}

									if ($r['university_is_accept'] == 1) {

    $output[] = '<a target="_blank" href="'.site_url().'headquarter/confirmationReceivedWithNewFormat/'.$r['application_no'].'/'.$r['regional_university'].'" target="_blank"><span class = "label label-success">Download</span></a>';


                                        }else{
											$output[] = 'NA';
										}
				if ($r['scholar_acceptance'] == 1 ) {
		$output[] = '<a target="_blank" href="'.site_url().'headquarter/undertakingFromStudent/'.base64url_encode($r['application_no']).'/'.base64url_encode($r['regional_university']).'" target="_blank"><span class = "label label-success">Download</span></a>';
											}
											elseif($r['scholar_acceptance'] == 2){
												$output[] = 'Decline';
											}
											else{
												$output[] = 'NA';
											}
												if(!empty($r['undertaking_doc'])){
										
									$date2 = $r['undertaking_doc'];	
									 $output[] = date('d-m-Y',$date2);
									}
									else
									{
				                    $output[] = "NA";
									}
									$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =openHqrsStatus("'.$r['application_no'].'") class="form-control sbmt1">Status</a>';
									$output[] = '<a target="_blank" href="'.site_url().'headquarter/viewProcessedApplication/'.$r['application_no'].'" class="form-control sbmt1">View</a>';

                        $response[] = $output;
				        $counter++;
					
			}
			
				
			
			
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	  
        //$data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByHqrsToMission($res);
      
    
}

function confirmationReceivedWithFormatIcar()
	{
		try
		{
			$doc = array();
			$applicationId = $this->uri->segment(3);
			$uniid = $this->uri->segment(4);
			$response = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$student_registerDate = $this->common_model->getStudentRegistratioYear($applicationId);
			$registerDate = $student_registerDate[0]['created'];
			$studentRegisterYear= date('d-m-Y', $registerDate);
			$compareDate = '15-12-2018';
			$date = date_create($studentRegisterYear);
			$array =  (array) $date;
			$miss = date("Y-m-d", strtotime($array['date']));
			$date1=date_create($miss);
            $date2=date_create($compareDate);
            $diff=date_diff($date1,$date2);
//now convert the $diff object to type integer
            $intDiff = $diff->format("%R%a");
			
            $intDiff = intval($intDiff);
	
			 if ($intDiff > 0){
				 
				 $current  = '15-12-2018';
					$fy = $this->getFinancialYears($current,1);
					 }
                 else 
				 {
					$current = date('d-m-Y');
					$fy = $this->getFinancialYears($current,1);
				 }
			
		
			
			
			
			
			$region = 0;$coursename = "";$respFile="";
			if(count($response)>0)
			{
				foreach($response as $resp)
				{
					if($resp['university_is_accept'] == 1 && $resp['regional_university'] == $uniid)
					{
						$respFile = $resp['region_one_doc'];
						$region = $resp['region_one_status'];
						$coursename = $resp['course'];
						array_push($doc,$resp['region_one_doc']);
					}
				}
			}
			
			//$fy = $this->getFinancialYears($current,1);
			
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$studentOther = $this->common_model->getStudentOtherDetails($applicationId);
			$mission = $this->common_model->getMissionInfo($studentOther[0]['application_through']);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$regionInfo = $this->common_model->getRegionById($region);
			$uninmae = $this->common_model->getUniversityStateById($uniid);
			$this->load->file('fpdi/PdfHTMLTable.php');
			
			
			$this->load->library('mpdf60/Mpdf');
			$pdf = new PdfHTMLTable();
			$pdf->AddPage('P');
			$pdf->SetXY(10.0,5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial','',7);
			$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
			$pdf->MultiCell(180,5,'Date: '.date('d M Y h:i:s'),'','R');
			
			$pdf->SetXY(10.0,45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations',false);		
			$pdf->SetFont('Arial','',10);	
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',35);
			$pdf->SetTextColor(221,221,255);
			$pdf->RotatedText(35,190,'Indian Council For Cultural Relations',45);
			$pdf->SetFont('Arial','',10);	
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(180,5,$mission[0]['mission_type'].': '.$mission[0]['mission_name'],'','L');
			
			$pdf->MultiCell(180,5,$mission[0]['country_name'],'','L');
			
			$pdf->MultiCell(180,5,'To     :	HoC / Education Wing / Culture Wing','','L');
			
			$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year '.$fy[0].'. Mr./Ms. '.$stepOne[0]['fullname'].' is provisionally confirmed for '.$coursename.' course at '.$uninmae[0]['name'].', reference ICAR Delhi,'  .$regionInfo[0]['name'].' subject to production of all original documents at the time of joining','','J');
			
			
		    $pdf->Ln(5);		
			$pdf->MultiCell(180,5,'Mission is requested to immediately take the following action:-','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'a)	Inform the candidate & convey his/her acceptance or rejection of the offer to ICCR at the earliest.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'b)	Obtain a written Undertaking from the student in the attached Proforma & email/fax it to ICCR. isd1section.iccr@nic.in / isd2section.iccr@nic.in / poafghan.iccr@nic.in','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'c)	Issue appropriate fulltime Student Visa (Research Visa in case of Ph.D.) to the student in accordance with the latest guidelines. The mission must issue the appropriate visa.','','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'d) 	Inform the scholars to report to Scholarship Division, Indian Council for Cultural Relations  (ICCR),'.$regionInfo[0]['name'].' or The Head, Department of '.$coursename.', '.$uninmae[0]['name'].', reference ICAR Delhi, ' .$regionInfo[0]['name'].' alongwith all original certificates and testimonials and academic transcript in English  or prescribed date in the attached acceptance letter of the university, failing which admission will be cancelled.','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'e)	Please ensure that the student brings all his/her documents/Credentials/Mark Sheets in English language only.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'f)	Also inform him/her of the requirement to register with the local FRO/FRRO within 7/14 days of arrival in India or as per Indian Mission’s instruction on his/her passport.','','J');		
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'g)	Advice the scholar to carry with him/her some money to meet incidental expenses on arrival (a minimum of INR 35,000/- is recommended) also brief the scholar on living conditions in India and the Terms & Conditions of ICCR’s scholarship.  Including the fact that living in hostel accommodation is compulsory.','','J');	
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'h)	You may inform to the candidate he/she is entitled for scholarship dues upto declaration of result only.','','J');
			
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'i)	To carry all original documents with them.','','J');		
			$pdf->Ln(5);	
			$pdf->SetFont('Arial','B');	
			$pdf->MultiCell(170,5,'Note:	Please do not send us acceptances which exceed the number of slots allotted to your country under specific scheme.','','L');	
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Regards,','','L');	
			
			$pdf->MultiCell(170,5,'Scholarship Division','','R');
			
			$pdf->MultiCell(170,5,'ICCR,'.$regionInfo[0]['name'],'','R');
			
			$pdf->MultiCell(170,5,'File No. ('.$applicationId.')/'.$fy[1] ,'','L');
			
			$filename = $applicationId."_University_Response_".date('jS-F-Y-h-i-s').'.pdf';
			
			$filenamePath = FCPATH."assets/site/main/accept/".$filename;
			$pdf->Output($filename,"D");
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			
			redirect(site_url().'mission/dashboard');
		}
		
	}

	public function countsiccr() {
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division > 0) {
				
				//print_r($this->ids);die;
                //$data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
                $data['schemes'] = $this->ids;
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/countsiccr', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	 public function getCountIccr() {
        try {
			
			
			$vars = $this->input->post();
			//print_r($vars);
			if($vars['Fyear'] == ''){
				$fy = "2018-2019";
			}else{
				$fy = $vars['Fyear'];
			}
			
			//$fy = "2018-2019";
			
		if(is_array($this->ids))
		{
			$ids = implode(",",$this->ids);	
		}
		else
		{
			$ids = $this->ids;
			//print_r($ids);die;
		}
			$vars = $this->input->post();
            $list = $this->common_model->get_iccr_datatables_query($this->ids,$vars);
            //print_r($list);die;
			//print_r($list[0]['totalCount']);die;
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $customers['totalCount'];
				$row[] = $customers['totalMale'];
				$row[] = $customers['totalFemale'];
				$row[] = $customers['totalUG'];
				$row[] = $customers['totalPG'];
				$row[] = $customers['totalMphil'];
				$row[] = $customers['totalPHD'];
				$row[] = $customers['totalAccepted'];
				$row[] = $customers['totalRejected'];
				//$row[] = $customers['totalAdmitted'];
				$row[]  = '<a href="'.site_url().'headquarter/admittStudents">'.$customers['totalAdmitted'].'</a>';
				
                $totalExp = 0;
                $aca = $this->reports->getACATotalExp($ids,$fy,$vars);
                $getAdvanceStipnedTotalExp = $this->reports->getAdvanceStipnedTotalExp($ids,$fy,$vars);
                $getCamps = $this->reports->getCamps($ids,$fy,$vars);
                $getDeduction = $this->reports->getDeduction($ids,$fy,$vars);
                $getEmergencyFund = $this->reports->getEmergencyFund($ids,$fy,$vars);
                $getEngBridgeCourse = $this->reports->getEngBridgeCourse($ids,$fy,$vars);
                $getHostel = $this->reports->getHostel($ids,$fy,$vars);
                $getHRA = $this->reports->getHRA($ids,$fy,$vars);
                $getisaMeeting = $this->reports->getisaMeeting($ids,$fy,$vars);
                $getmedicalReEmbust = $this->reports->getmedicalReEmbust($ids,$fy,$vars);
                $getMicsellanious = $this->reports->getMicsellanious($ids,$fy,$vars);
                $getMisUniversity = $this->reports->getMisUniversity($ids,$fy,$vars);
                $getNationalDay = $this->reports->getNationalDay($ids,$fy,$vars);
                $getOrientProg = $this->reports->getOrientProg($ids,$fy,$vars);
                $getOtherFee = $this->reports->getOtherFee($ids,$fy,$vars);
                $getStipned = $this->reports->getStipned($ids,$fy,$vars);
                $getStudentDay = $this->reports->getStudentDay($ids,$fy,$vars);
                $getStudyTour = $this->reports->getStudyTour($ids,$fy,$vars);
                $getSump = $this->reports->getSump($ids,$fy,$vars);
                $getthesis = $this->reports->getthesis($ids,$fy,$vars);
                $getTravel = $this->reports->getTravel($ids,$fy,$vars);
                $getTutFee = $this->reports->getTutFee($ids,$fy,$vars);
                
               
           
                
                if(count($aca)>0){$totalExp = $totalExp + $aca[0]['totalamount'];}
                
				if(count($getAdvanceStipnedTotalExp)>0){$totalExp = $totalExp + $getAdvanceStipnedTotalExp[0]['totalamount'];}
				if(count($getCamps)>0){$totalExp = $totalExp + $getCamps[0]['totalamount'];}
				if(count($getDeduction)>0){$totalExp = $totalExp + $getDeduction[0]['totalamount'];}
				if(count($getEmergencyFund)>0){$totalExp = $totalExp + $getEmergencyFund[0]['totalamount'];}
				if(count($getEngBridgeCourse)>0){$totalExp = $totalExp + $getEngBridgeCourse[0]['totalamount'];}
				if(count($getHostel)>0){$totalExp = $totalExp + $getHostel[0]['totalamount'];}
				if(count($getHRA)>0){$totalExp = $totalExp + $getHRA[0]['totalamount'];}
				if(count($getisaMeeting)>0){$totalExp = $totalExp + $getisaMeeting[0]['totalamount'];}
				if(count($getmedicalReEmbust)>0){$totalExp = $totalExp + $getmedicalReEmbust[0]['totalamount'];}
				if(count($getMicsellanious)>0){$totalExp = $totalExp + $getMicsellanious[0]['totalamount'];}
				if(count($getMisUniversity)>0){$totalExp = $totalExp + $getMisUniversity[0]['totalamount'];}
				if(count($getNationalDay)>0){$totalExp = $totalExp + $getNationalDay[0]['totalamount'];}
				if(count($getOrientProg)>0){$totalExp = $totalExp + $getOrientProg[0]['totalamount'];}
				if(count($getOtherFee)>0){$totalExp = $totalExp + $getOtherFee[0]['totalamount'];}
				if(count($getStipned)>0){$totalExp = $totalExp + $getStipned[0]['totalamount'];}
				if(count($getStudentDay)>0){$totalExp = $totalExp + $getStudentDay[0]['totalamount'];}
				if(count($getStudyTour)>0){$totalExp = $totalExp + $getStudyTour[0]['totalamount'];}
				if(count($getSump)>0){$totalExp = $totalExp + $getSump[0]['totalamount'];}
				if(count($getthesis)>0){$totalExp = $totalExp + $getthesis[0]['totalamount'];}
				if(count($getTravel)>0){$totalExp = $totalExp + $getTravel[0]['totalamount'];}
				if(count($getTutFee)>0){$totalExp = $totalExp + $getTutFee[0]['totalamount'];}
				
                $row[] = $totalExp;
                $row[] = $sts[0]['status'];
                $data[] = $row;
            }
			
            $output = array(
                //"draw" => $_POST['draw'],
                //"recordsTotal" => $this->common_model->count_all(),
                //"recordsFiltered" => $this->common_model->count_filtered($this->ids),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	 public function admittStudent() {
		 //echo "sdsadas";die;
        try {
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
            if ($division > 0) {
				
				$current = date('Y-m-d');
                $current1 = date('Y-m-d', strtotime('-1 years'));
                $data['fy'] = $this->getFinancialYears($current, 1);
                $data['ofy'] = $this->getFinancialYears($current1, 5);
				//print_r($this->ids);die;
                //$data['totalAdmitt'] = $this->common_model->getTotalAdmitApplications($this->ids);
				//echo "<pre>";
				//print_r($data['totalAdmitt']);die;
                $data['schemes'] = $this->ids;
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/admittStudent', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	
	public function countshqrs() {
        try {
			
				
                $user_data = $this->session->userdata('user_data');
				//echo "<pre>";
				//print_r($user_data);die;
				$regionid = $user_data['state'];
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/countshqrs', $data);
                $this->load->view('iccr/footer');
            
        } catch (Exception $e) {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
				redirect(site_url() . 'iccr/dashboard');
        }
    }
	
	
	
		 public function getCountHqrs() {
        try {
			
			$fy = "2018-2019";
			$user_data = $this->session->userdata('user_data');
			//$regionid = $user_data['state'];
			$vars = $this->input->post();
			$regionid = $vars['region'];
			//echo "<pre>";
			//print_r($vars);die;
            $list = $this->Regional_model->get_iccr_datatables_query($regionid,$vars);
            //print_r($list);die;
			
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no;
               $row[] = $customers['totalCount'];
				$row[] = $customers['totalMale'];
				$row[] = $customers['totalFemale'];
				$row[] = $customers['totalUG'];
				$row[] = $customers['totalPG'];
				$row[] = $customers['totalMphil'];
				$row[] = $customers['totalPHD'];
				$row[] = $customers['totalAccepted'];
				$row[] = $customers['totalRejected'];
				//$row[] = $customers['totalAdmitted'];
				$row[]  = '<a href="'.site_url().'regional/admittStudents">'.$customers['totalAdmitted'].'</a>';
               
               $totalExp = 0;
                
                $aca = $this->Regional_model->getACATotalExp($regionid,$fy,$vars);
                $getAdvanceStipnedTotalExp = $this->Regional_model->getAdvanceStipnedTotalExp($regionid,$fy,$vars);
                $getCamps = $this->Regional_model->getCamps($regionid,$fy,$vars);
                $getDeduction = $this->Regional_model->getDeduction($regionid,$fy,$vars);
                $getEmergencyFund = $this->Regional_model->getEmergencyFund($regionid,$fy,$vars);
                $getEngBridgeCourse = $this->Regional_model->getEngBridgeCourse($regionid,$fy,$vars);
                $getHostel = $this->Regional_model->getHostel($regionid,$fy,$vars);
                $getHRA = $this->Regional_model->getHRA($regionid,$fy,$vars);
                $getisaMeeting = $this->Regional_model->getisaMeeting($regionid,$fy,$vars);
                $getmedicalReEmbust = $this->Regional_model->getmedicalReEmbust($regionid,$fy,$vars);
                $getMicsellanious = $this->Regional_model->getMicsellanious($regionid,$fy,$vars);
                $getMisUniversity = $this->Regional_model->getMisUniversity($regionid,$fy,$vars);
                $getNationalDay = $this->Regional_model->getNationalDay($regionid,$fy,$vars);
                $getOrientProg = $this->Regional_model->getOrientProg($regionid,$fy,$vars);
                $getOtherFee = $this->Regional_model->getOtherFee($regionid,$fy,$vars);
                $getStipned = $this->Regional_model->getStipned($regionid,$fy,$vars);
                $getStudentDay = $this->Regional_model->getStudentDay($regionid,$fy,$vars);
                $getStudyTour = $this->Regional_model->getStudyTour($regionid,$fy,$vars);
                $getSump = $this->Regional_model->getSump($regionid,$fy,$vars);
                $getthesis = $this->Regional_model->getthesis($regionid,$fy,$vars);
                $getTravel = $this->Regional_model->getTravel($regionid,$fy,$vars);
                $getTutFee = $this->Regional_model->getTutFee($regionid,$fy,$vars);
                
               
           
                
                if(count($aca)>0){$totalExp = $totalExp + $aca[0]['totalamount'];}
                
				if(count($getAdvanceStipnedTotalExp)>0){$totalExp = $totalExp + $getAdvanceStipnedTotalExp[0]['totalamount'];}
				if(count($getCamps)>0){$totalExp = $totalExp + $getCamps[0]['totalamount'];}
				if(count($getDeduction)>0){$totalExp = $totalExp + $getDeduction[0]['totalamount'];}
				if(count($getEmergencyFund)>0){$totalExp = $totalExp + $getEmergencyFund[0]['totalamount'];}
				if(count($getEngBridgeCourse)>0){$totalExp = $totalExp + $getEngBridgeCourse[0]['totalamount'];}
				if(count($getHostel)>0){$totalExp = $totalExp + $getHostel[0]['totalamount'];}
				if(count($getHRA)>0){$totalExp = $totalExp + $getHRA[0]['totalamount'];}
				if(count($getisaMeeting)>0){$totalExp = $totalExp + $getisaMeeting[0]['totalamount'];}
				if(count($getmedicalReEmbust)>0){$totalExp = $totalExp + $getmedicalReEmbust[0]['totalamount'];}
				if(count($getMicsellanious)>0){$totalExp = $totalExp + $getMicsellanious[0]['totalamount'];}
				if(count($getMisUniversity)>0){$totalExp = $totalExp + $getMisUniversity[0]['totalamount'];}
				if(count($getNationalDay)>0){$totalExp = $totalExp + $getNationalDay[0]['totalamount'];}
				if(count($getOrientProg)>0){$totalExp = $totalExp + $getOrientProg[0]['totalamount'];}
				if(count($getOtherFee)>0){$totalExp = $totalExp + $getOtherFee[0]['totalamount'];}
				if(count($getStipned)>0){$totalExp = $totalExp + $getStipned[0]['totalamount'];}
				if(count($getStudentDay)>0){$totalExp = $totalExp + $getStudentDay[0]['totalamount'];}
				if(count($getStudyTour)>0){$totalExp = $totalExp + $getStudyTour[0]['totalamount'];}
				if(count($getSump)>0){$totalExp = $totalExp + $getSump[0]['totalamount'];}
				if(count($getthesis)>0){$totalExp = $totalExp + $getthesis[0]['totalamount'];}
				if(count($getTravel)>0){$totalExp = $totalExp + $getTravel[0]['totalamount'];}
				if(count($getTutFee)>0){$totalExp = $totalExp + $getTutFee[0]['totalamount'];}
				
                $row[] = $totalExp;
                $row[] = $sts[0]['status'];
                $data[] = $row;
            }
			
            $output = array(
                //"draw" => $_POST['draw'],
                //"recordsTotal" => $this->common_model->count_all(),
                //"recordsFiltered" => $this->common_model->count_filtered($this->ids),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
			//Mission Popup
	
		function ajaxfile()
    {
    	$user_data = $this->session->userdata('user_data');
		//$missionId = $user_data['user_country'];
		//$countryid = $misionData[0]['country']; 
		//$vars = $this->input->post();
		//$nowtime = time();
		
			$data['user_data'] = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
		$result = $this->common_model->getRegionalApplicationsCountAlert($regionid);
		
		$roFrdAppRes = $this->common_model->getRegionalApplicationsCountConfirmationAlert($regionid);
		
		//$confirmationReceive = $this->common_model->countgetConfirmationofHqrsAlert($this->ids);
		
		
		//$totalAcceptance = $this->common_model->countgetConfirmationofCandidatesAlert($this->ids);
		//$RoTotalApplicationRes = $this->hqrs_model->getRoTotalApplication($nowtime);
		//echo "<pre>";
		//print_r($missionFrdAppRes);die;
		//$TotalApplicationApplicationForwordMissionRes = $this->hqrs_model->getTotalApplicationForwordMission($nowtime);
		//echo "<pre>";
		//print_r($TotalApplicationApplicationForwordMissionRes);die;
		/* if(!empty($result)){
			$missiomSum = 0;
			foreach($result as $mr){
				
				$missiomSum+= $mr['Total'];
			}
		} */
		/* if(!empty($RoTotalApplicationRes)){
			$RoTotalApplicationSum = 0;
			foreach($RoTotalApplicationRes as $ro){
				
				$RoTotalApplicationSum+= $ro['total'];
			}
		} */
		/* if(!empty($missionFrdAppRes)){
			$missiomFrdResSum = 0;
			foreach($missionFrdAppRes as $mrps){
				
				$missiomFrdResSum+= $mrps['Total'];
			}
			
		} */
		
		$response = array();
		//if(!empty($result))
		//{
			$counter = 1;
			$sum = 0;
			$htm = "<table class='customTable1 table table-striped table-bordered'>";
			
				$htm .= "<thead>";

				$htm .= "<tr>";
				$htm .= "<td>Application Received : </td><td>".$result."</td>";
				$htm .= "</tr>";

				 $htm .= "<tr>";
				$htm .= "<td>Confirmation sent to Mission  : </td><td>".$roFrdAppRes."</td>";
				$htm .= "</tr>"; 
				

				
				$htm .="</thead>";
      $htm .= "</table>";
      echo $htm;
      exit;
				
				
				
			//}
			
			
		}
		
	    function undertakingFromStudent()
	    {
		try
		{
			// NOTE: application numbers are passed as plain, unencoded segments
			// everywhere else in the codebase (mission/university/regional's
			// undertakingFromStudent all use $this->uri->segment(3) directly).
			// This used to run the segment through base64url_decode(), but no
			// view actually base64url_encodes the appno before building this
			// link, so the decode corrupted the application number and made
			// every lookup below fail silently, which triggered the "Application
			// record not found" redirect for every request. Reverted to match
			// the convention used by every other stakeholder's implementation.
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			//$applicationId = $this->common_model->getApplicationAppnoByUserId($userId);	
			//$applicationId =  $applicationId[0]['application_no'];
			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if (empty($stepOne)) {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Application record not found for this undertaking letter.');
				redirect(site_url() . 'headquarter/dashboard');
			}
			$country = $this->common_model->getCountryById($stepOne[0]['nationality']);
            //echo '<pre>'; print_r($country); die;
            //echo '<pre>'; print_r($stepOne[0]['nationality']);die;
			$schemeId = $this->common_model->getMappingData($applicationId);
			$response = $this->common_model->getconfirmationDataByMission($applicationId);
			$applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$userd = $this->common_model->getUserInfo($applicaitonStepThree[0]['uid']); 
			$applicantAcceptanceDate = $schemeId[0]['undertaking_doc'];
			// $date1 removed: was read from undefined $applicaitonSubmitData and
			// never used anywhere below (only threw warnings).
			$acDate =  date('d-m-Y',$applicantAcceptanceDate);
			// The block that used to be here (file_get_contents + base64-encode
			// into a temp file) was entirely dead: $imgPath gets reassigned
			// immediately below regardless, so none of that work was ever used.
			// It also threw "file not found" warnings whenever $userd->dir was
			// empty or the file was missing. Removed; the fallback-aware logic
			// below is what's actually used.

			if(empty($userd->dir)){
				$imgPath = site_url().'assets/site/main/profile_signature/'.$applicaitonStepThree[0]['signature_doc'];
			}else{
				$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			}
			$new = '<img src="'.$imgPath.'" style="width:100px;">';

			$image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$logo = '<img src="' . $image . '" style="width:auto;">';
			// die('hj');
			//echo "<pre>";print_r($imgPath);die;
			$uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
			//echo $uni1[0]['name'];
			// $course removed: was read from a 'final_course' key that doesn't
			// exist on $response (only threw warnings), and never used below.
			$nomenid = $response[0]['nomenclature'];
			$nomclature = $this->common_model->getnomenclatureByid($nomenid);
			$nomenclature = $nomclature[0]['title'];
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			ob_start();
        ?>
        <html>
    <style>
        .sign_align {
            text-align: right;
        }
		body {
			font-family: Arial;
		}
        @media print {
			@page {
				margin-top: 0;
				margin-bottom: 0;
			}
			body {
				padding-top: 72px;
				padding-bottom: 72px ;
			}
		}
    </style>

    <body>
		<div class="pdf_div" style="font-size: 14px;">
        <p style="text-align: right;"><small>Ref. No. <?php echo $applicationId; ?> <br/>Date: <?php echo $acDate; ?> </small></p>
		<div style="text-align: center;"><?php echo $logo;?></div>
        <h3 style="text-align: center;">Indian Council For Cultural Relations (ICCR)</h3>
		<h2 style="color: #d8d5d5;opacity: 0.3;font-family: arial;font-size: 40px;margin: 0;transform(rotate(45deg));transform-origin(0 0);transform: rotate(328deg);position: relative;top: 300px;text-align: center;">Indian Council For Cultural Relations</h2>

        <p><b>ACCEPTANCE TO OFFER OF ADMISSION WITH ICCR SCHOLARSHIP/Undertaking</b></p>
		<br>
		<p>Acceptance of <?php echo $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname'] . ' to offer of admission at  ' . $uni1[0]['name'] . ' to pursue nomenclature  ' . $nomenclature;?>
    	<p style="text-align: justify;">1.  That I have accepted the award of scholarship for the Course and University as mentioned above and will not ask for the change of course or University at any later stage.</p>
        <p style="text-align: justify;">2.  That I have read and understood fully the Guidelines/Rules of the scholarship as provided on the A2A Portal and undertake to abide by the same.</p>
        <p style="text-align: justify;">3.  That I have also understood that the said Guidelines/Rules are subject to change at the discretion of ICCR and I undertake to abide by the Guidelines/Rules as amended from time to time. I have also noted and understand the provisions regarding deductions from scholarship dues, including the quarterly submission of attendance records, the half-yearly submission of academic progress reports, compliance with medical insurance and so on.</p>
        <p style="text-align: justify;">4.  That I have understood the following norms regarding ex-India period and any violation of these norms will attract deduction of my scholarship dues- Student must note that the paid ex-India period for students of any levels of courses will not exceed 60 days in an academic year with the conditions that (a) Ex-India period can be availed maximum twice in an academic year; (b) Ex-India period upto 30 days at a time will not attract any deduction in scholarship allowances; (c) Any number of days of continuous ex-India period beyond 30 days and upto 60 days will attract 50% deduction on the amount of stipend; (d) Any number of days beyond 60 days limit will attract deduction of entire scholarship allowances excluding HRA; (e) Any number of days beyond the second time even if it is within the total 60 days limit will attract deduction of entire scholarship allowances excluding HRA.</p>
        <p style="text-align: justify;">5.  That I will complete the entire course of study and abide by all the rules, regulations, guidelines or any instructions of the University/Institution as prevalent at the time of admission or amended from time to time.</p>
        <p style="text-align: justify;">6.  That I certify that documents related to my eligibility for study in India with regard age and educational qualification are correct and in case of any discrepancy the award of admission and scholarship will be terminated without any notice and that I will go back to my country on my own expenses within the permissible duration as per the law of India.</p>
        <p style="text-align: justify;">7.  That I will respect and abide by the laws of India and not indulge in any illegal, unlawful, anti-social, criminal, political, religious, demonstrations, protest activities and any violation will attract termination of my scholarship at the discretion of ICCR.</p>
		<p style="text-align: justify;">8.  That I will abide by all the rules, regulations, guidelines, laws of the Government of India or any other Indian authorities in its entirety. I will be sensible in using social media handles and will not post/comment any content against India, its people, culture, institutions or any entity and/or the content/post that can disturb relations between India and other countries. Any violation will attract termination of my scholarship at the discretion of ICCR.</p>
		<p style="text-align: justify;">9.  That I undertake to follow visa / immigration rules and keep my registration as temporary foreign resident in India valid during my entire stay in India. I also undertake to pay any charges, penalties, fines etc. involved in keeping my Visa/residential permit status valid all the time. In case of any violation of Visa/immigration norms, I will be prosecuted under the laws of India and its authorities which may lead to heavy penalties/charges/fines, deportation, detention/confinement/imprisonment etc. as per prevailing laws.</p>
		<p style="text-align: justify;">10.  That I certify that I am physically and mentally fit, not suffering from any chronic contagious/non-communicable diseases, terminal illness or ailments affecting vital organs, not pregnant (applicable for a female candidate) and having undergone mandatory and obligatory vaccinations.</p>
		<p style="text-align: justify;">11.  That I will be responsible for my health and purchase Medical Health Insurance Policy with a minimum cover of Rs.5,00,000/- (Rupees Five Lacs) to cover my medical expenses. I also undertake that the expenses not covered under the Medical Insurance Policy will be borne by me and I will not raise any claim for the same to ICCR or University or any other authorities of India and understand that in absence of sufficient medical cover or funds, I myself would be responsible for any repercussions on account of my health conditions. I will return to my country on my own expenses in case of any illness requiring long absence from course of study and in that case the scholarship will be terminated. I also undertake to keep my insurance cover valid during my entire stay in India and submit the copy of valid insurance to the concerned Zonal Office annually for their records.</p>
		<p style="text-align: justify;">12.  That I undertake to be regular in attendance and academics, failing which ICCR, University and other authorities have the right to terminate my scholarship and under any such circumstances, I shall bear all my expenses on my return to my native country. I will also submit the self-declaration, signed by the Dean FSR every month, in this regard in December and June by email for the release of my stipend.</p>
		<p style="text-align: justify;">13.  That in case I fail in an academic year, my scholarship will be suspended and will be re-instated only after I will pass my examination and during such intervening period, I will study an self-finance basis.</p>
		<p style="text-align: justify;">14.  That I understood that the Indian Mission and ICCR have the right to terminate my scholarship at any stage without assigning any reason whatsoever.</p>
		<p style="text-align: justify;">15.  That I undertake to refund voluntarily in case any excess or over disbursement is made to me on account of scholarship allowances to ICCR in India or through the Indian Mission in my country if such wrong disbursement is noticed after completion of my course in India.</p>
		<p style="text-align: justify;">16.  That I undertake to pay, in a timely manner and/or as per the schedule of the demanding authority, any dues payable by me on account of any charges of the University, which are not covered by ICCR under the tuition fees and other compulsory fees, such as Library fee, security deposit, caution money, lab charges, hostel/utility charges, private accommodation/utility charges, any other charges etc. Any violation will attract suspension of my scholarship dues till the pending dues are settled by me.</p>
		<p style="text-align: justify;">17.  That I understand that the admission granted to me is provisional and confirmed only after my arrival in India on the basis of original documents with transcripts and if I am not found eligible, I will go back to my country on my own expenses.</p>
	</br>

		<p style="text-align: left;"><?php echo $new;?></p>

		<p style="text-align: left;">Name: <?php echo $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname']; ?></p>
		<p style="text-align: left;">Country: <?php echo $country[0]['country_name'];?> </p>
		<p style="text-align: left;">Date: <?php echo $acDate;?> </p>
		<p style="text-align: left;">Passport No: <?php echo $stepOne[0]['passport_no']; ?></p>

	</div>
    </body>
</html>
<?php


      $html = ob_get_clean();
			$this->load->library('GenPdf');

			$dompdf = new GenPdf();
			//$canvas = $dompdf->get_canvas();
			$dompdf->set_option('isHtml5ParserEnabled', true);
			$dompdf->set_option('isRemoteEnabled', true);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream("welcome.pdf", array("Attachment"=>0));

			//$pdf->debug = true;
		} catch (Throwable $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');

			redirect(site_url() . 'headquarter/dashboard');
		}

	}


	function downloadTotalConfirmation()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
		$this->excel->getActiveSheet()->setTitle('S.No');
        $this->excel->getActiveSheet()->setTitle('Application No');
		$this->excel->getActiveSheet()->setTitle('Email');
		$this->excel->getActiveSheet()->setTitle('Country');
		$this->excel->getActiveSheet()->setTitle('Scheme');
		$this->excel->getActiveSheet()->setTitle('Course');
		$this->excel->getActiveSheet()->setTitle('University');
		$this->excel->getActiveSheet()->setTitle('Course');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'University');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Total');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
				$res = array(
            'iccr_status' => 1,
            'status' => 10
        ); 
		        $rs = $this->hqrs_model->getUniversityResponseSentByHqrsToMission($vars =NULL,$res);
				//echo "<pre>";print_r($rs);die;
		     
					$exceldata = array();
		$counter++;
		$allTotal = 0;	
		$counter = 1;
		foreach ($rs as $r){		
			$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($r['nationality']);
				//$response1 = $this->common_model->getconfirmationDataByMission($r['application_no']);
				//echo "<pre>";
				//print_r($r);
				
					            $output[] = $counter;	
								$output[] = $r['application_no'];	
                                $output[] = $r['fullname'].$r['middlename'].$r['familyname']; 
                                $output[] = $r['email']; 
                                $output[] = $r['country_name'];	
								$sch = $this->common_model->getSchemeById($r['scholarship_id']);
                                $output[] = $sch[0]['scheme_name'];
								
								//echo "<pre>";
								//print_r($universties);die;
								$confirmData = $this->common_model->getFinalUniversityById($r['regional_university']);
								//print_r($confirmData);die;
								 $course = $r['confirmed_course'];
								 $output[] =  $course;
								 $output[] =  $confirmData[0]['name']; 
                                   
                            
			
			$exceldata[] = $output;
			 $counter++;
		}

		
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalConfirmation.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	
	public function studentsAcceptance() {
        try {
			$year = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');
            $division = $user_data['state'];
			$data['year'] = $this->uri->segment(3);
            if ($division == 1) {
                //$data['newApplication'] = $this->common_model->getHqrsNewApplication($this->ids);
                $this->load->view('iccr/header_mission');
                $this->load->view('iccr/studentsAcceptance', $data);
                $this->load->view('iccr/footer');
            } else {
                $this->load->view('iccr/header_mission');
                $this->load->view('errors/html/error_403');
                $this->load->view('iccr/footer');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	function getApplicaitonsAcceptance() {      
       
	   
	   
		$year = $this->uri->segment(3);
		//echo $year;die;
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->hqrs_model->getAcceptance($this->ids,$vars,$year);
		$totalResult = $this->hqrs_model->getAcceptanceCount($this->ids,$vars,$year);
		//$response1 = array();
		$response = array();
		$counter++;
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				$output= array();
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($r['application_no']);
				$country = $this->common_model->getCountryById($r['nationality']);
				//$response1 = $this->common_model->getconfirmationDataByMission($r['application_no']);
				//echo "<pre>";
				//print_r($r);
				
					            $output[] = $counter;	
								$output[] = $r['application_no'];	
                                $output[] = $r['fullname'].' '.$r['middlename'].' '.$r['familyname']; 
                                $output[] = $r['email']; 
                                $output[] = $r['country_name'];	
								/* $missions = $this->common_model->getAllMissions();
								foreach($missions as $mission)
	       						{
	       							
										if($applicaitonStepThree[0]['application_through'] == $mission['id'])
										{
											$output[] = $mission['mission_name'];
										}										
										
	       						} */	
								$sch = $this->common_model->getSchemeById($r['scholarship_id']);
                                $output[] = $sch[0]['scheme_name'];
								
								//echo "<pre>";
								//print_r($universties);die;
							
								$confirmData = $this->common_model->getFinalUniversityById($r['regional_university']);
								//print_r($confirmData);die;
								if($year == '2021')
								{
								$course = $r['confirmed_course'];
								 $output[] =  $course;
								}
								else
								{
							    $course = $this->common_model->getCoursesById($r['course']);
                                 $output[] =  $course[0]['title']; 
								}
								 
						if($year == '2021')
								{
								 $output[] = '<a target="_blank" href="'.site_url().'headquarter/viewFullApplication/'.base64_encode($r['application_no']).'" class = "form-control sbmt1" target="_blank">View</a>';	
								}
								else
								{
									$output[] = '<a target="_blank" href="'.site_url().'headquarter/applicantAcceptanceStatus/'.base64_encode($r['application_no']).'" class = "form-control sbmt1" target="_blank">View</a>';	
								}
                        $response[] = $output;
				        $counter++;
					
			}
			
				
			
			
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	  
        //$data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByHqrsToMission($res);
      
    
}

		public function downloadDocs(){
			//echo base64_decode($this->uri->segment(3));die;
			$file_name = base64url_decode($this->uri->segment(3));
			fileForceDownload($file_name);
		}

		/**
		 * ---------------------------------------------------------------
		 * Bulk "Download All (ZIP)" export for the newapplications/<year> list.
		 * ---------------------------------------------------------------
		 * Three-step flow, driven from JS on views/iccr/newapplications.php, so a
		 * single HTTP request never has to process hundreds of students (this
		 * host has no SSH/CLI access, so a synchronous "click and wait" button
		 * risks the web server's own request timeout regardless of what
		 * set_time_limit() is set to in PHP):
		 *
		 *   1. exportZipStart()  - resolves the exact same filtered
		 *      application_no list the on-screen table is showing (same
		 *      filters, same year, no pagination limit) and writes it to a
		 *      small manifest file. Returns an export_id + total count.
		 *   2. exportZipBatch()  - processes a small batch of application_nos
		 *      per call: renders each student's application as a PDF and
		 *      copies their uploaded documents into
		 *      assets/exports/<export_id>/files/<application_no>/. The browser
		 *      calls this repeatedly (advancing offset) to drive a progress bar.
		 *   3. exportZipFinish() - zips the accumulated per-student folders
		 *      into one file, streams it back as the download, then cleans up.
		 *
		 * export_id is always validated against a strict hex pattern before
		 * being used in any filesystem path, to rule out path traversal.
		 */

		private function _exportIdIsValid($exportId)
		{
			return is_string($exportId) && preg_match('/^[a-f0-9]{16,40}$/', $exportId) === 1;
		}

		/**
		 * Emit a JSON response that always carries a currently-valid CSRF
		 * token. config.php has csrf_protection ON with csrf_regenerate ON,
		 * so the token rotates on every accepted POST - and cookie_httponly
		 * is TRUE, so the browser's JS cannot read the rotated value out of
		 * the cookie itself. Without handing the fresh token back in the
		 * response body, only the very first POST of the export would pass
		 * and every subsequent batch would be rejected with a 403 (which
		 * jQuery surfaces only as a generic "Network error"). Error
		 * responses include it too, so a retry after a failure still works.
		 */
		private function _jsonWithCsrf($payload)
		{
			$payload['csrf_name'] = $this->security->get_csrf_token_name();
			$payload['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($payload));
		}

		private function _exportBaseDir($exportId)
		{
			return FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $exportId . DIRECTORY_SEPARATOR;
		}

		public function exportZipStart()
		{
			try {
				set_time_limit(0);
				$year = $this->uri->segment(3);
				$vars = $this->input->post();
				// Same fields the DataTables ajax() call on newapplications.php
				// always sends, defaulted so a direct/older POST that omits one
				// doesn't throw a PHP notice inside the model's filter checks.
				$defaults = array('ApplicantName'=>'','Mail'=>'','Programme'=>'','Counrse'=>'','Universtiy'=>'','Country'=>'','Scheme'=>'','Confirmed'=>'','Application'=>'','MinDate'=>'','MaxDate'=>'','Region'=>'');
				$vars = array_merge($defaults, is_array($vars) ? $vars : array());

				$rows = $this->hqrs_model->getHqrsAllApplicationNosForExport($this->ids, $vars, $year);
				$applicationNos = array();
				foreach ($rows as $r) {
					if (!empty($r['application_no'])) {
						$applicationNos[] = $r['application_no'];
					}
				}
				$applicationNos = array_values(array_unique($applicationNos));

				$exportsRoot = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR;
				if (!is_dir($exportsRoot)) {
					@mkdir($exportsRoot, 0755, true);
				}
				// This directory only ever holds temporary per-export files
				// (application PDFs + copies of uploaded documents) that are
				// meant to be fetched through exportZipFinish(), never browsed
				// to directly - export_id is a random 128-bit hex token, but
				// block direct web access too as defense in depth.
				if (!is_file($exportsRoot . '.htaccess')) {
					@file_put_contents($exportsRoot . '.htaccess', "Require all denied\nDeny from all\n");
				}

				// Sweep exports older than 6 hours. Each run can leave
				// hundreds of MB behind if the user closes the tab midway, so
				// without this the assets/exports directory grows unbounded.
				foreach ((array) glob($exportsRoot . '*', GLOB_ONLYDIR) as $old) {
					$marker = $old . DIRECTORY_SEPARATOR . 'manifest.json';
					if (is_file($marker) && (time() - filemtime($marker)) > 21600) {
						$this->_recursiveDelete($old);
					}
				}

				$exportId = bin2hex(random_bytes(16));
				$dir = $this->_exportBaseDir($exportId);
				@mkdir($dir . 'files', 0755, true);
				file_put_contents($dir . 'manifest.json', json_encode(array(
					'year' => $year,
					'created' => time(),
					'application_nos' => $applicationNos,
				)));

				$this->_jsonWithCsrf(array('status' => true, 'export_id' => $exportId, 'total' => count($applicationNos)));
			} catch (\Throwable $e) {
				log_message('error', 'Headquarter::exportZipStart() failed: ' . $e->getMessage());
				$this->_jsonWithCsrf(array('status' => false, 'message' => 'Could not start export.'));
			}
		}

		public function exportZipBatch()
		{
			try {
				set_time_limit(0);
				$exportId = (string) $this->input->post('export_id');
				$offset = (int) $this->input->post('offset');
				$batchSize = (int) $this->input->post('batch');
				// Deliberately small: each student now renders the full
				// viewFullApplication page through mPDF, which is far heavier
				// than a plain text summary. Keeping the per-request work
				// short is what stops the gateway timing the request out.
				if ($batchSize < 1 || $batchSize > 10) {
					$batchSize = 3;
				}

				if (!$this->_exportIdIsValid($exportId)) {
					$this->_jsonWithCsrf(array('status' => false, 'message' => 'Invalid export id.'));
					return;
				}
				$dir = $this->_exportBaseDir($exportId);
				$manifestPath = $dir . 'manifest.json';
				if (!is_file($manifestPath)) {
					$this->_jsonWithCsrf(array('status' => false, 'message' => 'Export not found or expired.'));
					return;
				}
				$manifest = json_decode(file_get_contents($manifestPath), true);
				$applicationNos = isset($manifest['application_nos']) ? $manifest['application_nos'] : array();
				$total = count($applicationNos);
				$batch = array_slice($applicationNos, $offset, $batchSize);

				$problems = array();
				$produced = 0;
				foreach ($batch as $appno) {
					$outcome = $this->_exportOneApplication($dir . 'files' . DIRECTORY_SEPARATOR, $appno);
					if ($outcome['pdf'] || $outcome['docs'] > 0) {
						$produced++;
					}
					if (!empty($outcome['errors'])) {
						$problems[] = $outcome['appno'] . ': ' . implode('; ', $outcome['errors']);
					}
				}

				$done = min($offset + count($batch), $total);

				// If a whole batch produced nothing, stop rather than run the
				// bar to 100% and fail at the end with no explanation.
				if ($produced === 0 && !empty($batch)) {
					$this->_jsonWithCsrf(array(
						'status' => false,
						'message' => 'No files could be produced for these applications. ' . implode(' | ', array_slice($problems, 0, 3)),
					));
					return;
				}

				$this->_jsonWithCsrf(array(
					'status' => true,
					'done' => $done,
					'total' => $total,
					'problems' => array_slice($problems, 0, 5),
				));
			} catch (\Throwable $e) {
				log_message('error', 'Headquarter::exportZipBatch() failed: ' . $e->getMessage());
				$this->_jsonWithCsrf(array('status' => false, 'message' => 'Export batch failed.'));
			}
		}

		/**
		 * Zip the per-student folders built by exportZipBatch(), a few
		 * students at a time.
		 *
		 * This used to happen in one shot inside exportZipFinish(), which is
		 * what made the download appear to hang forever: ZipArchive does all
		 * of its actual work in close(), so a 700-student export sat in a
		 * single request for many minutes and the web server's own gateway
		 * timeout killed it. set_time_limit(0) does NOT help there - it only
		 * raises PHP's limit, not Apache/FastCGI's. So packing is now driven
		 * in small batches by the same JS progress loop that builds the files.
		 *
		 * Output is split into numbered parts once a part passes
		 * MAX_PART_BYTES. A filtered export of a few dozen students still
		 * produces exactly one zip; a full 700-student run produces several,
		 * which is deliberate - a single multi-gigabyte download is very
		 * likely to fail partway through with nothing to show for it.
		 */
		public function exportZipPack()
		{
			try {
				set_time_limit(0);
				$exportId = (string) $this->input->post('export_id');
				$packBatch = (int) $this->input->post('batch');
				if ($packBatch < 1 || $packBatch > 50) {
					$packBatch = 15;
				}

				if (!$this->_exportIdIsValid($exportId)) {
					$this->_jsonWithCsrf(array('status' => false, 'message' => 'Invalid export id.'));
					return;
				}
				$dir = $this->_exportBaseDir($exportId);
				$filesDir = $dir . 'files';
				$manifestPath = $dir . 'manifest.json';
				if (!is_file($manifestPath) || !is_dir($filesDir)) {
					$this->_jsonWithCsrf(array('status' => false, 'message' => 'Export not found or expired.'));
					return;
				}

				// ~1.2 GB per part. Large enough that normal exports stay in
				// one file, small enough that a part stays downloadable.
				$maxPartBytes = 1200 * 1024 * 1024;

				$statePath = $dir . 'pack_state.json';
				$state = is_file($statePath)
					? json_decode(file_get_contents($statePath), true)
					: array('offset' => 0, 'parts' => array());
				if (!is_array($state)) {
					$state = array('offset' => 0, 'parts' => array());
				}

				$studentDirs = glob($filesDir . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
				sort($studentDirs);
				$total = count($studentDirs);
				$offset = (int) $state['offset'];
				$slice = array_slice($studentDirs, $offset, $packBatch);

				if (!empty($slice)) {
					$partIndex = count($state['parts']);
					if ($partIndex === 0) {
						$state['parts'][] = array('file' => 'part1.zip');
						$partIndex = 0;
					} else {
						// Continue filling the last part unless it's already
						// over the size cap, in which case start a new one.
						$lastPath = $dir . $state['parts'][$partIndex - 1]['file'];
						if (is_file($lastPath) && filesize($lastPath) >= $maxPartBytes) {
							$state['parts'][] = array('file' => 'part' . (count($state['parts']) + 1) . '.zip');
							$partIndex = count($state['parts']) - 1;
						} else {
							$partIndex = count($state['parts']) - 1;
						}
					}

					$zipPath = $dir . $state['parts'][$partIndex]['file'];
					$zip = new ZipArchive();
					if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
						$this->_jsonWithCsrf(array('status' => false, 'message' => 'Could not open zip file for writing.'));
						return;
					}

					// The payload is overwhelmingly PDFs and JPG/PNG scans,
					// which are already compressed - re-deflating them costs
					// a lot of CPU for almost no size saving, and CPU time is
					// exactly what we're trying not to spend here.
					$alreadyCompressed = array('pdf','jpg','jpeg','png','gif','zip','rar','7z','docx','xlsx','pptx');

					foreach ($slice as $studentDir) {
						$appno = basename($studentDir);
						$iterator = new RecursiveIteratorIterator(
							new RecursiveDirectoryIterator($studentDir, FilesystemIterator::SKIP_DOTS)
						);
						foreach ($iterator as $file) {
							if (!$file->isFile()) continue;
							$localPath = $appno . '/' . substr($file->getPathname(), strlen($studentDir) + 1);
							$localPath = str_replace('\\', '/', $localPath);
							$zip->addFile($file->getPathname(), $localPath);
							$ext = strtolower(pathinfo($file->getPathname(), PATHINFO_EXTENSION));
							if (in_array($ext, $alreadyCompressed, true) && method_exists($zip, 'setCompressionName')) {
								@$zip->setCompressionName($localPath, ZipArchive::CM_STORE);
							}
						}
					}
					$zip->close();

					$state['offset'] = $offset + count($slice);
					file_put_contents($statePath, json_encode($state));
				}

				$done = (int) $state['offset'];
				$complete = ($done >= $total);

				if ($total === 0) {
					$this->_jsonWithCsrf(array(
						'status' => false,
						'message' => 'Nothing to zip - no student folders were created during the previous step.',
					));
					return;
				}

				$parts = array();
				if ($complete) {
					foreach ($state['parts'] as $i => $p) {
						$path = $dir . $p['file'];
						if (is_file($path)) {
							$parts[] = array(
								'index' => $i,
								'size' => filesize($path),
								'size_human' => $this->_humanBytes(filesize($path)),
							);
						}
					}
				}

				$this->_jsonWithCsrf(array(
					'status' => true,
					'done' => $done,
					'total' => $total,
					'complete' => $complete,
					'parts' => $parts,
				));
			} catch (\Throwable $e) {
				log_message('error', 'Headquarter::exportZipPack() failed: ' . $e->getMessage());
				$this->_jsonWithCsrf(array('status' => false, 'message' => 'Packing failed: ' . $e->getMessage()));
			}
		}

		private function _humanBytes($bytes)
		{
			$units = array('B','KB','MB','GB','TB');
			$i = 0;
			$bytes = (float) $bytes;
			while ($bytes >= 1024 && $i < count($units) - 1) {
				$bytes /= 1024;
				$i++;
			}
			return round($bytes, 1) . ' ' . $units[$i];
		}

		/**
		 * Stream one already-built zip part.
		 * URL: headquarter/exportZipDownload/<export_id>/<part index>
		 *
		 * Streamed in chunks rather than via readfile() so that a multi-
		 * hundred-megabyte part doesn't have to sit in memory, and so output
		 * starts flowing immediately instead of after a long silent pause.
		 */
		public function exportZipDownload()
		{
			try {
				set_time_limit(0);
				$exportId = $this->uri->segment(3);
				$partIndex = (int) $this->uri->segment(4);
				if (!$this->_exportIdIsValid($exportId)) {
					show_error('Invalid export id.', 400);
					return;
				}
				$dir = $this->_exportBaseDir($exportId);
				$statePath = $dir . 'pack_state.json';
				$manifestPath = $dir . 'manifest.json';
				if (!is_file($statePath) || !is_file($manifestPath)) {
					show_error('Export not found or expired.', 404);
					return;
				}
				$state = json_decode(file_get_contents($statePath), true);
				if (!isset($state['parts'][$partIndex]['file'])) {
					show_error('Export part not found.', 404);
					return;
				}
				$zipPath = $dir . $state['parts'][$partIndex]['file'];
				if (!is_file($zipPath)) {
					show_error('Export part not found.', 404);
					return;
				}

				$manifest = json_decode(file_get_contents($manifestPath), true);
				$year = isset($manifest['year']) ? $manifest['year'] : date('Y');
				$totalParts = count($state['parts']);
				$suffix = $totalParts > 1 ? '_part' . ($partIndex + 1) . 'of' . $totalParts : '';
				$downloadName = 'applications_' . $year . $suffix . '.zip';

				while (ob_get_level()) { ob_end_clean(); }
				header('Content-Description: File Transfer');
				header('Content-Type: application/zip');
				header('Content-Disposition: attachment; filename="' . $downloadName . '"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: ' . filesize($zipPath));
				header('X-Accel-Buffering: no');

				$fh = fopen($zipPath, 'rb');
				if ($fh === false) {
					show_error('Could not read export part.', 500);
					return;
				}
				while (!feof($fh)) {
					echo fread($fh, 1024 * 1024);
					flush();
				}
				fclose($fh);
				exit;
			} catch (\Throwable $e) {
				log_message('error', 'Headquarter::exportZipDownload() failed: ' . $e->getMessage());
				show_error('Download failed.', 500);
			}
		}

		/**
		 * Delete an export's temp files. Called by the browser once every
		 * part has been downloaded. Cleanup is no longer done inside the
		 * download response itself - with multiple parts, deleting after the
		 * first one would break the rest.
		 */
		public function exportZipCleanup()
		{
			try {
				$exportId = (string) $this->input->post('export_id');
				if ($this->_exportIdIsValid($exportId)) {
					$this->_recursiveDelete($this->_exportBaseDir($exportId));
				}
				$this->_jsonWithCsrf(array('status' => true));
			} catch (\Throwable $e) {
				log_message('error', 'Headquarter::exportZipCleanup() failed: ' . $e->getMessage());
				$this->_jsonWithCsrf(array('status' => false));
			}
		}

		private function _recursiveDelete($path)
		{
			if (!file_exists($path)) return;
			if (is_file($path) || is_link($path)) { @unlink($path); return; }
			$items = @scandir($path);
			if ($items === false) return;
			foreach ($items as $item) {
				if ($item === '.' || $item === '..') continue;
				$this->_recursiveDelete($path . DIRECTORY_SEPARATOR . $item);
			}
			@rmdir($path);
		}

		/**
		 * Build one student's export folder: <destDir>/<application_no>/ with
		 * application_info.pdf (the same information shown on
		 * viewFullApplication, rendered as a PDF) plus a documents/ subfolder
		 * holding every file they uploaded.
		 */
		private function _exportOneApplication($destDir, $appno)
		{
			// Returns a per-student outcome instead of swallowing problems.
			// Previously any failure here was logged and discarded, so the
			// progress bar could run to 100% having produced nothing at all,
			// and the only symptom was an empty zip at the very end.
			$outcome = array('appno' => $appno, 'pdf' => false, 'docs' => 0, 'errors' => array());
			$studentDir = $destDir . $appno . DIRECTORY_SEPARATOR;

			if (!is_dir($studentDir) && !@mkdir($studentDir, 0755, true)) {
				$outcome['errors'][] = 'could not create folder (check write permission on assets/exports)';
				return $outcome;
			}

			try {
				$outcome['pdf'] = (bool) $this->_writeApplicationPdf($studentDir . 'application_info.pdf', $appno);
				if (!$outcome['pdf']) {
					$outcome['errors'][] = 'PDF was not produced';
				}
			} catch (\Throwable $e) {
				$outcome['errors'][] = 'PDF: ' . $e->getMessage();
				log_message('error', 'Headquarter export PDF failed for ' . $appno . ': ' . $e->getMessage());
			}

			try {
				$documents = $this->common_model->getApplicationDocumentsbyAppNo($appno);
				if (!empty($documents)) {
					$docsDir = $studentDir . 'documents' . DIRECTORY_SEPARATOR;
					@mkdir($docsDir, 0755, true);
					$doctypes = $this->config->item('doc_types');
					$labelByTypeId = array();
					foreach ($doctypes as $key => $meta) {
						// The configured titles carry an upload hint in a
						// <span> ("(Document size must be less than 2 MB)").
						// Drop the span *with* its text - stripping tags alone
						// would bake that hint into every filename - along with
						// any other parenthesised aside.
						// Note: only the <span> is removed, not parenthesised
						// text generally - "(Synopsis)" and "(Research Paper)"
						// are what distinguish the two Doctorate entries, and
						// collapsing them would make one silently overwrite
						// the other.
						$label = preg_replace('#<span\b[^>]*>.*?</span>#is', '', $meta['title']);
						$label = preg_replace('/<[^>]*>/', '', $label);
						$label = trim(preg_replace('/\s+/', ' ', $label));
						$label = preg_replace('/[^A-Za-z0-9]+/', '_', $label);
						$label = trim($label, '_');
						// Keep filenames manageable for Windows path limits.
						if (strlen($label) > 60) {
							$label = rtrim(substr($label, 0, 60), '_');
						}
						$labelByTypeId[$meta['type']] = $label !== '' ? $label : $key;
					}

					$seenTypes = array();
					foreach ($documents as $doc) {
						$path = isset($doc['doc_path']) ? $doc['doc_path'] : '';
						if ($path === '') continue;
						$resolved = $this->_resolveSafeFilePath($path);
						if ($resolved === null) continue;

						$typeId = isset($doc['doc_type']) ? $doc['doc_type'] : 0;
						if (isset($seenTypes[$typeId])) continue; // dedupe, same as viewFullApplication's $docsArray
						$seenTypes[$typeId] = true;

						$label = isset($labelByTypeId[$typeId]) ? $labelByTypeId[$typeId] : ('doc_' . $typeId);
						$ext = strtolower(pathinfo($resolved, PATHINFO_EXTENSION));
						$destName = $label . ($ext !== '' ? '.' . $ext : '');
						// Never let one document overwrite another if two
						// labels ever collide after sanitising.
						if (file_exists($docsDir . $destName)) {
							$destName = $label . '_' . $typeId . ($ext !== '' ? '.' . $ext : '');
						}
						if (@copy($resolved, $docsDir . $destName)) {
							$outcome['docs']++;
						}
					}
				}
			} catch (\Throwable $e) {
				$outcome['errors'][] = 'documents: ' . $e->getMessage();
				log_message('error', 'Headquarter export documents failed for ' . $appno . ': ' . $e->getMessage());
			}

			// An empty folder would make ZipArchive produce a zero-entry
			// archive, which it silently declines to write to disk at all -
			// that is exactly how "packing finished but no zip was produced"
			// happened. Drop it and let the caller report the reason.
			if (!$outcome['pdf'] && $outcome['docs'] === 0) {
				$this->_recursiveDelete($studentDir);
			}

			return $outcome;
		}

		/**
		 * Same confinement rule as fileForceDownload() in status_helper.php:
		 * only hand back a path if it resolves to a real, non-executable file
		 * inside the web root. doc_path values come straight from the
		 * database, so this is the only thing standing between a bad row and
		 * reading an arbitrary file off the server.
		 */
		private function _resolveSafeFilePath($path)
		{
			$resolved = @realpath($path);
			if ($resolved === false) return null;
			$root = @realpath(FCPATH);
			if ($root === false) return null;
			$root = rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
			if (strncasecmp($resolved, $root, strlen($root)) !== 0) return null;
			$blocked = array('php','php3','php4','php5','php7','phtml','phps','inc','htaccess','ini','env','sql');
			if (in_array(strtolower(pathinfo($resolved, PATHINFO_EXTENSION)), $blocked, true)) return null;
			if (!is_file($resolved)) return null;
			return $resolved;
		}

		/**
		 * Render one student's application to PDF.
		 *
		 * Built from clean markup rather than by re-rendering the
		 * iccr/viewFullApplication view. That view was tried first, but its
		 * table structure is invalid in ways a browser silently repairs and a
		 * PDF engine cannot: cells outside rows, blocks inside <tbody>, and a
		 * main table left unclosed across whole sections. Dompdf ends up with
		 * a cell whose parent table is missing and aborts with "Call to a
		 * member function get_cellmap() on null", producing no PDF at all.
		 * Generating the document here keeps the export deterministic and
		 * independent of that page's markup.
		 *
		 * Content mirrors the on-screen application: the same numbered
		 * sections, the same field values, and both images (profile photo and
		 * passport scan).
		 */
		private function _writeApplicationPdf($destPath, $appno)
		{
			$html = $this->_buildApplicationHtml($appno);
			if ($html === null) {
				return false;
			}

			$this->load->library('GenPdf');
			$dompdf = new GenPdf();
			$dompdf->set_option('isHtml5ParserEnabled', true);
			$dompdf->set_option('isRemoteEnabled', false);
			$dompdf->set_option('chroot', FCPATH);
			$dompdf->set_option('defaultFont', 'DejaVu Sans');
			$dompdf->loadHtml($html, 'UTF-8');
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			file_put_contents($destPath, $dompdf->output());
			return is_file($destPath);
		}

		/** Read an image off disk as a data URI, or null if unusable. */
		private function _imageDataUri($path)
		{
			$resolved = $this->_resolveSafeFilePath($path);
			if ($resolved === null) {
				return null;
			}
			$bytes = @file_get_contents($resolved);
			if ($bytes === false || $bytes === '') {
				return null;
			}
			$ext = strtolower(pathinfo($resolved, PATHINFO_EXTENSION));
			$mimes = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif');
			if (!isset($mimes[$ext])) {
				return null;
			}
			return 'data:' . $mimes[$ext] . ';base64,' . base64_encode($bytes);
		}

		private function _buildApplicationHtml($appno)
		{
			$stepOne = $this->common_model->getHeadquarterApplicationStepOneByAppno($appno);
			if (empty($stepOne)) {
				return null;
			}
			$s = $stepOne[0];
			$uid = $s['uid'];

			$two   = $this->common_model->getApplicationStepTwoByAppno($appno);
			$edu   = !empty($two) ? $two[0] : array();
			$three = $this->common_model->getApplicationStepThreebyAppNo($appno);
			$oth   = !empty($three) ? $three[0] : array();
			$reg   = $this->common_model->getUserData($uid);
			$r     = !empty($reg) ? $reg[0] : array();

			$v = function ($arr, $key, $default = '') {
				return (is_array($arr) && isset($arr[$key]) && $arr[$key] !== null && $arr[$key] !== '')
					? $arr[$key] : $default;
			};
			$e = function ($x) { return htmlspecialchars((string) $x, ENT_QUOTES, 'UTF-8'); };
			$yn = function ($x) { return ((string) $x === '1') ? 'Yes' : (((string) $x === '2' || (string) $x === '0') ? 'No' : ''); };

			// ---- lookups -------------------------------------------------
			$countryName = function ($id) {
				if (empty($id)) return '';
				$c = $this->common_model->getCountryById($id);
				return isset($c[0]['country_name']) ? $c[0]['country_name'] : (isset($c[0]['name']) ? $c[0]['name'] : '');
			};
			$nationality = $countryName($v($s, 'nationality'));

			$missionName = '';
			if ($v($oth, 'application_through') !== '') {
				$mi = $this->common_model->getMissionInfo($oth['application_through']);
				if (!empty($mi[0])) {
					$missionName = trim($v($mi[0], 'mission_type') . ' ' . $v($mi[0], 'mission_name')
						. (($v($mi[0], 'country_name') !== '') ? ', ' . $mi[0]['country_name'] : ''));
				}
			}

			$programmeName = '';
			if ($v($s, 'programme') !== '') {
				$p = $this->common_model->getProgrammeById($s['programme']);
				$programmeName = isset($p[0]['name']) ? $p[0]['name'] : '';
			}

			$streamName = '';
			if ($v($s, 'course_type') !== '') {
				$row = $this->db->get_where('iccr_course_type', array('id' => $s['course_type']))->row();
				if ($row && isset($row->course_type)) $streamName = $row->course_type;
			}

			$titleMap = array('1' => 'Mr', '2' => 'Ms', '3' => 'Mrs');
			$title = isset($titleMap[(string) $v($s, 'student_title')]) ? $titleMap[(string) $s['student_title']] : '';
			$fullName = trim($title . ' ' . $v($s, 'fullname') . ' ' . $v($s, 'middlename') . ' ' . $v($s, 'familyname'));
			$gender = ((string) $v($s, 'gender') === '1') ? 'Male' : (((string) $v($s, 'gender') === '2') ? 'Female' : '');

			// ---- images --------------------------------------------------
			$photo = null;
			$userInfo = $this->common_model->getUserInfo($uid);
			$imgArr = $this->common_model->getUserImage($uid);
			$imgName = isset($imgArr[0]['name']) ? $imgArr[0]['name'] : '';
			if ($imgName !== '') {
				$dir = ($userInfo && isset($userInfo->dir)) ? $userInfo->dir : '';
				if ($dir !== '') {
					$photo = $this->_imageDataUri(rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . $imgName);
				}
				if ($photo === null) {
					$photo = $this->_imageDataUri(FCPATH . 'assets/site/main/profile_pics/' . $imgName);
				}
			}
			$passportImg = null;
			if ($userInfo && !empty($userInfo->passport_file)) {
				$passportImg = $this->_imageDataUri(FCPATH . ltrim($userInfo->passport_file, '/\\'));
			}
			$signatureImg = null;
			if ($v($oth, 'signature_doc') !== '') {
				$signatureImg = $this->_imageDataUri(FCPATH . 'assets/site/main/profile_signature/' . $oth['signature_doc']);
			}

			// ---- course / university preferences -------------------------
			$nomKeys = array('nomenclature','nomenclature_two','nomenclature_three','nomenclature_fourth','nomenclature_fifth');
			$uniKeys = array('universty_choice','universty_choice_two','universty_choice_three','universty_choice_fourth','universty_choice_fifth');
			$choices = array();
			for ($i = 0; $i < 5; $i++) {
				$nom = ''; $uni = '';
				if ($v($s, $nomKeys[$i]) !== '') {
					$n = $this->common_model->getnomenclatureByid($s[$nomKeys[$i]]);
					$nom = isset($n[0]['title']) ? $n[0]['title'] : '';
				}
				if ($v($s, $uniKeys[$i]) !== '') {
					$u = $this->common_model->getUniversityById($s[$uniKeys[$i]]);
					$uni = isset($u[0]['name']) ? $u[0]['name'] : '';
				}
				if ($nom !== '' || $uni !== '') {
					$choices[] = array($i + 1, $nom, $uni);
				}
			}

			// ---- education ----------------------------------------------
			$eduRows = array();
			$eduSpec = array(
				array('Grade X (equivalent to Grade X in India)', 'school_leaving_country_x', 'school_leaving_university_x', 'school_leaving_year_x', 'school_leaving_percentage_x'),
				array('Grade XII (equivalent to Grade XII in India)', 'school_leaving_country', 'school_leaving_university', 'school_leaving_year', 'school_leaving_percentage'),
				array('Under Graduate', 'ug_leaving_country', 'ug_leaving_university', 'ug_leaving_year', 'ug_leaving_percentage'),
				array('Post Graduate', 'pg_leaving_country', 'pg_leaving_university', 'pg_leaving_year', 'pg_leaving_percentage'),
			);
			foreach ($eduSpec as $row) {
				list($label, $ck, $uk, $yk, $pk) = $row;
				if ($v($edu, $uk) === '' && $v($edu, $yk) === '' && $v($edu, $pk) === '') continue;
				$eduRows[] = array($label, $v($edu, $ck), $v($edu, $uk), $v($edu, $yk), $v($edu, $pk));
			}
			if ($v($edu, 'other_course') !== '' || $v($edu, 'other_course_university') !== '') {
				$eduRows[] = array($v($edu, 'other_course', 'Other'), '', $v($edu, 'other_course_university'), $v($edu, 'other_course_year'), '');
			}

			// ---- documents ----------------------------------------------
			$documents = $this->common_model->getApplicationDocumentsbyAppNo($appno);
			$doctypes = $this->config->item('doc_types');
			$docTitleById = array();
			foreach ($doctypes as $meta) {
				$t = preg_replace('#<span\b[^>]*>.*?</span>#is', '', $meta['title']);
				$t = trim(preg_replace('/\s+/', ' ', preg_replace('/<[^>]*>/', '', $t)));
				$docTitleById[$meta['type']] = $t;
			}
			$docRows = array(); $seenDoc = array();
			foreach ($documents as $d) {
				$tid = isset($d['doc_type']) ? $d['doc_type'] : 0;
				if (isset($seenDoc[$tid])) continue;
				$seenDoc[$tid] = true;
				$docRows[] = array(
					isset($docTitleById[$tid]) ? $docTitleById[$tid] : ('Document type ' . $tid),
					!empty($d['added_on']) ? date('d-m-Y H:i', $d['added_on']) : '',
				);
			}

			// ---- university status --------------------------------------
			$confirmRows = array();
			$confirmed = $this->common_model->getconfirmationDataByMission($appno);
			if (!empty($confirmed)) {
				foreach ($confirmed as $cr) {
					$un = '';
					if (!empty($cr['regional_university'])) {
						$u = $this->common_model->getFinalUniversityById($cr['regional_university']);
						$un = isset($u[0]['name']) ? $u[0]['name'] : '';
					}
					$confirmRows[] = array($un, $v($cr, 'final_course', $v($cr, 'course')), $v($cr, 'date_of_joining'));
				}
			}

			// ---- assemble -------------------------------------------------
			$row = function ($label, $value) use ($e) {
				if (trim((string) $value) === '') return '';
				return '<tr><td class="k">' . $e($label) . '</td><td class="v">' . $e($value) . '</td></tr>';
			};

			$h = array();
			$h[] = '<!DOCTYPE html><html><head><meta charset="utf-8"><style>'
				. '@page{margin:12mm 10mm;}'
				. 'body{font-family:"DejaVu Sans",sans-serif;font-size:9.5px;color:#000;}'
				. 'h1{font-size:14px;text-align:center;margin:0 0 2px;}'
				. 'h2{font-size:10.5px;background:#e9e9e9;padding:4px 6px;margin:12px 0 5px;border-left:3px solid #666;}'
				. '.sub{text-align:center;font-size:9px;margin:0 0 8px;}'
				. '.appno{text-align:right;font-size:9px;margin-bottom:4px;}'
				. 'table{width:100%;border-collapse:collapse;margin-bottom:4px;}'
				. 'td,th{border:1px solid #bbb;padding:3px 5px;vertical-align:top;}'
				. 'th{background:#f2f2f2;text-align:left;font-weight:bold;}'
				. 'td.k{width:34%;font-weight:bold;background:#fafafa;}'
				. '.plain td{border:none;padding:2px 0;}'
				. '.photo{width:104px;height:124px;object-fit:cover;border:1px solid #999;}'
				. '.scan{max-width:210px;max-height:120px;border:1px solid #999;}'
				. '.essay{white-space:pre-wrap;text-align:justify;border:1px solid #bbb;padding:5px;}'
				. '.note{font-size:8.5px;color:#444;margin:3px 0 0;}'
				. '</style></head><body>';

			$h[] = '<div class="appno">Application No. <b>' . $e($appno) . '</b></div>';
			$h[] = '<h1>APPLICATION FORM FOR SCHOLARSHIP THROUGH ICCR</h1>';
			$h[] = '<p class="sub">TO BE FILLED BY APPLICANT</p>';

			// header block: details + photo side by side
			$h[] = '<table class="plain"><tr><td style="width:78%">';
			$h[] = '<table>';
			$h[] = $row('Application Made Through', $missionName);
			$h[] = $row('1. Full name (IN BLOCK LETTERS)', $fullName);
			$h[] = $row('2. Gender', $gender);
			$h[] = $row('3. Date of Birth', $v($s, 'dob'));
			$h[] = $row('Age', $v($s, 'age'));
			$h[] = $row('4. Place of Birth', trim($v($s, 'city') . (($v($s,'birth_country')!=='') ? ', ' . $countryName($s['birth_country']) : '')));
			$h[] = $row('5. Location', $nationality);
			$h[] = '</table></td><td style="width:22%;text-align:right">';
			$h[] = ($photo !== null) ? '<img class="photo" src="' . $photo . '">' : '';
			$h[] = '</td></tr></table>';

			$h[] = '<h2>Passport Details</h2><table>';
			$h[] = $row('6. Passport No', $v($s, 'passport_no', 'NA'));
			$h[] = $row('7. Issue of Passport (City, Country)', trim($v($s,'passport_issue_place') . (($v($s,'passport_issue_country')!=='') ? ', ' . $countryName($s['passport_issue_country']) : '')));
			$h[] = $row('8. Passport Issue Date', $v($s, 'passport_issue_date'));
			$h[] = $row('9. Passport Expiry Date', $v($s, 'passport_expiry_date'));
			$h[] = '</table>';
			if ($passportImg !== null) {
				$h[] = '<div><img class="scan" src="' . $passportImg . '"></div>';
			}

			$h[] = '<h2>Contact &amp; Address</h2><table>';
			$h[] = $row('10. Postal Address', $v($s, 'postal_address'));
			$h[] = $row('a) City', $v($s, 'postal_address_city'));
			$h[] = $row('b) State', $v($s, 'postal_address_state'));
			$h[] = $row('c) Country', $v($s, 'postal_address_country'));
			$h[] = $row('d) Zipcode', $v($s, 'postal_address_pincode'));
			$h[] = $row('11. Mobile Number', trim($v($s, 'tel_country_code') . ' ' . $v($s, 'phone_number')));
			$h[] = $row('12. WhatsApp Number', $v($s, 'whatsapp_number'));
			$h[] = $row('13. Email Id', $v($s, 'email'));
			$h[] = $row('14. Unique Identifcation No.', $v($s, 'unique_id'));
			$h[] = '</table>';

			$h[] = '<h2>15. Details of Father / Mother / Guardian</h2>';
			$h[] = '<table><tr><th>Name</th><th>Relation</th><th>Phone Number</th><th>Email ID</th></tr>';
			$people = array(
				array(trim($v($r,'father_fname').' '.$v($r,'father_mname').' '.$v($r,'father_lname')), 'Father', $v($s,'father_number'), $v($s,'father_email')),
				array(trim($v($r,'mother_fname').' '.$v($r,'mother_mname').' '.$v($r,'mother_lname')), 'Mother', $v($s,'mother_number'), $v($s,'mother_email')),
				array(trim($v($r,'gurdian_fname').' '.$v($r,'gurdian_mname').' '.$v($r,'gurdian_lname')), 'Guardian', $v($s,'gurdian_number'), $v($s,'gurdian_email')),
			);
			$anyPerson = false;
			foreach ($people as $p) {
				if (trim($p[0]) === '' && trim($p[2]) === '' && trim($p[3]) === '') continue;
				$anyPerson = true;
				$h[] = '<tr><td>' . $e($p[0]) . '</td><td>' . $e($p[1]) . '</td><td>' . $e($p[2]) . '</td><td>' . $e($p[3]) . '</td></tr>';
			}
			if (!$anyPerson) $h[] = '<tr><td colspan="4">NA</td></tr>';
			$h[] = '</table>';
			$gAddr = trim(implode(', ', array_filter(array($v($s,'guardian_address'), $v($s,'gardiuan_address_city'), $v($s,'gardiuan_address_state'), $v($s,'gardiuan_address_country'), $v($s,'gardiuan_address_pincode')))));
			if ($gAddr !== '') $h[] = '<table>' . $row('Address', $gAddr) . '</table>';

			$h[] = '<h2>English Proficiency</h2><table>';
			$h[] = $row('16. English as a subject in School/College', $yn($v($s, 'is_english_as_subject')));
			$h[] = $row('Till What Level', $v($s, 'english_level'));
			$h[] = $row('TOEFL Score', ((string) $v($s,'is_toefl') === '1') ? $v($s, 'toefl_score', 'NA') : '');
			$h[] = $row('IELTS Score', ((string) $v($s,'is_ielts') === '1') ? $v($s, 'ielts_score', 'NA') : '');
			$h[] = $row('Duolingo Score', ((string) $v($s,'is_duolingo') === '1') ? $v($s, 'duolingo_score', 'NA') : '');
			$h[] = $row('GMAT Score', $v($s, 'gmat_score'));
			$h[] = '</table>';

			if ($v($s, 'english_test_essay') !== '') {
				$h[] = '<h2>18. Essay</h2><div class="essay">' . $e($s['english_test_essay']) . '</div>';
			}

			$h[] = '<h2>Academic Programme</h2><table>';
			$h[] = $row('19. Academic Year', $v($s, 'acedemic_year'));
			$h[] = $row('20. Level of Course', $programmeName);
			$h[] = $row('21. Course Main Stream', $streamName);
			$h[] = '</table>';

			if (!empty($choices)) {
				$h[] = '<p class="note"><b>22. Universities/Institutes in India where you wish to seek admission:</b></p>';
				$h[] = '<table><tr><th style="width:6%">#</th><th style="width:44%">Nomenclature</th><th>University</th></tr>';
				foreach ($choices as $c) {
					$h[] = '<tr><td>' . $e($c[0]) . '</td><td>' . $e($c[1]) . '</td><td>' . $e($c[2]) . '</td></tr>';
				}
				$h[] = '</table>';
				$h[] = '<p class="note">Note: Once admission is confirmed, no change in either course or University/Institute will be permitted by the Council. Allotment of colleges is done by the respective Universities.</p>';
			}

			if (!empty($eduRows)) {
				$h[] = '<h2>23. Previous Educational Qualifications</h2>';
				$h[] = '<table><tr><th>Certificate/Degree</th><th>Country</th><th>Name of School/University/Board</th><th>Year</th><th>%/Grade</th></tr>';
				foreach ($eduRows as $er) {
					$h[] = '<tr><td>' . $e($er[0]) . '</td><td>' . $e($er[1]) . '</td><td>' . $e($er[2]) . '</td><td>' . $e($er[3]) . '</td><td>' . $e($er[4]) . '</td></tr>';
				}
				$h[] = '</table>';
			}

			$refs = array(
				array($v($oth,'enq_ref_one_name'), $v($oth,'enq_ref_one_designation'), $v($oth,'enq_ref_one_email'), $v($oth,'enq_ref_one_phone'), $v($oth,'enq_ref_one_address')),
				array($v($oth,'enq_ref_two_name'), $v($oth,'enq_ref_two_designation'), $v($oth,'enq_ref_two_email'), $v($oth,'enq_ref_two_phone'), $v($oth,'enq_ref_two_address')),
			);
			$hasRef = false;
			foreach ($refs as $rf) { if (trim($rf[0]) !== '') $hasRef = true; }
			if ($hasRef) {
				$h[] = '<h2>24. References</h2>';
				$h[] = '<table><tr><th>Name</th><th>Occupation</th><th>Email</th><th>Telephone</th><th>Postal Address</th></tr>';
				foreach ($refs as $rf) {
					if (trim($rf[0]) === '') continue;
					$h[] = '<tr><td>' . $e($rf[0]) . '</td><td>' . $e($rf[1]) . '</td><td>' . $e($rf[2]) . '</td><td>' . $e($rf[3]) . '</td><td>' . $e($rf[4]) . '</td></tr>';
				}
				$h[] = '</table>';
			}

			if ($v($oth, 'relative_ref_name') !== '') {
				$h[] = '<h2>25. Close relative(s) or friends in India</h2>';
				$h[] = '<table><tr><th>Name</th><th>Relationship</th><th>Occupation</th><th>Telephone</th><th>Email</th><th>Postal Address</th></tr>';
				$h[] = '<tr><td>' . $e($v($oth,'relative_ref_name')) . '</td><td>' . $e($v($oth,'relative_ref_relation'))
					. '</td><td>' . $e($v($oth,'relative_ref_designation')) . '</td><td>' . $e($v($oth,'relative_ref_contact'))
					. '</td><td>' . $e($v($oth,'relative_ref_email')) . '</td><td>' . $e($v($oth,'relative_ref_address')) . '</td></tr>';
				$h[] = '</table>';
			}

			$h[] = '<h2>Additional Declarations</h2><table>';
			$h[] = $row('26. Have you travelled or lived in India in the past?', $yn($v($oth, 'is_travel_or_live_in_india_before')));
			$h[] = $row('27. Have you ever availed of ICCR Scholarship earlier?', $yn($v($oth, 'is_iccr_scholarship_avail_before')));
			if ((string) $v($oth, 'is_iccr_scholarship_avail_before') === '1') {
				$h[] = $row('   Year', $v($oth, 'iccr_scholar_year'));
				$h[] = $row('   Course', $v($oth, 'iccr_scholar_course'));
				$h[] = $row('   Institute', $v($oth, 'iccr_scholar_institute'));
				$h[] = $row('   Duration', trim($v($oth,'iccr_scholar_duration_from') . ' - ' . $v($oth,'iccr_scholar_duration_to'), ' -'));
			}
			$h[] = $row('28. Are you currently a resident in India?', $yn($v($oth, 'currently_non_nri')));
			$h[] = $row('   Postal Address', $v($oth, 'currently_non_nri_address'));
			$h[] = $row('29. Are you married to an Indian national?', $yn($v($oth, 'is_married')));
			$h[] = $row('30. Do you have an International driving licence?', $yn($v($oth, 'is_international_lic')));
			$h[] = $row('   Licence No.', $v($oth, 'is_international_lic_no'));
			$h[] = $row('   Issuing Authority', $v($oth, 'is_international_lic_auth'));
			$h[] = $row('31. Any Other Information', $v($oth, 'any_other_info'));
			$h[] = '</table>';

			if (!empty($confirmRows)) {
				$h[] = '<h2>University Status</h2>';
				$h[] = '<table><tr><th>University Name</th><th>Confirmed Course</th><th>Date of Joining</th></tr>';
				foreach ($confirmRows as $cr) {
					$h[] = '<tr><td>' . $e($cr[0]) . '</td><td>' . $e($cr[1]) . '</td><td>' . $e($cr[2]) . '</td></tr>';
				}
				$h[] = '</table>';
			}

			if (!empty($docRows)) {
				$h[] = '<h2>Uploaded Documents</h2>';
				$h[] = '<p class="note">The files themselves are in the <b>documents</b> folder alongside this PDF.</p>';
				$h[] = '<table><tr><th style="width:6%">S.No.</th><th>Document Name</th><th style="width:22%">Uploaded</th></tr>';
				$i = 1;
				foreach ($docRows as $dr) {
					$h[] = '<tr><td>' . $i++ . '</td><td>' . $e($dr[0]) . '</td><td>' . $e($dr[1]) . '</td></tr>';
				}
				$h[] = '</table>';
			}

			$h[] = '<h2>Declaration</h2>';
			$h[] = '<p style="text-align:justify">I hereby declare that the particulars given above are true to the best of my knowledge and belief and that I have understood the financial terms and conditions of the Scholarship Scheme. I hereby undertake to abide by them, and I also undertake to return to my country after completion of my studies in India.</p>';
			$h[] = '<table class="plain"><tr><td>Date: ' . $e($v($oth, 'created') !== '' ? date('d-m-Y', (int) $oth['created']) : '') . '</td><td style="text-align:right">';
			$h[] = ($signatureImg !== null) ? '<img src="' . $signatureImg . '" style="max-width:150px;max-height:50px;"><br>Signature' : 'Signature';
			$h[] = '</td></tr></table>';

			$h[] = '</body></html>';
			return implode("\n", $h);
		}

		public function __destruct() {
    $this->db->close();
    }
public function loginHistory()
		{

			$user_data = $this->session->userdata('user_data');

			$data['loginHistorys'] = $this->common_model->getloginHistory();

			$this->load->view('iccr/header_mission');
               $this->load->view('iccr/list_of_lgin_history',$data);
                $this->load->view('iccr/footer');
		}

}
