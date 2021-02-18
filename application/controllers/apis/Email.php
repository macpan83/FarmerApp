<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// include REST_Controler library
// require APPPATH. '/libraries/REST_Controller.php';

class Email extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('email_model', 'em');
		$this->load->helper(['form', 'utility']);
	}

	public function test(){
	   // echo generateRandomString(6);
	    $inputs = json_decode($this->input->raw_input_stream, true);

	    $token = generateRandomString(6);
        $_mail['to'] = $inputs['email'];
        $_mail['subject'] = "CHECKK";
        $_mail['message'] = 'CHECK  Your generated token is '.$token;
        
        // Token sent in mail.
        $r = $this->em->send_otp_mail($_mail);
        
        if($r['status']){
            echo json_encode($r);
        }
        else{
            echo json_encode($r);
        }
        
	}
	
}