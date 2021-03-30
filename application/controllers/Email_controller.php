<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		$this->load->model('email_model', 'mail');
		$this->load->model('otp_model', 'otp');
		
		$this->load->helper('form');

		$this->load->library('session');
		
		// $this->load->model('user', '');
	}


public function sendEmail(){
  		$_mail['to'] = 'mayankpan3012@gmail.com';
        $_mail['subject'] = "Token from Fresh on the Go";
        $_mail['message'] = 'Your generated token is ';

         $r = $this->mail->send_otp_mail($_mail);

         print_r($r['status']);
         die();
}

}