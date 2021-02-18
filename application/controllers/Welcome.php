<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		$this->load->model('Order_model', 'ord');
		$this->load->helper('form');

		$this->load->library('session');
		
		// $this->load->model('user', '');
	}

	// This is the default page 
	public function index()
	{
		$this->load->view('login');
		
		// redirect('farmers/index','refresh');
		
	}

	public function login(){
		$this->load->view('login');
	}

	public function register(){
		$this->load->view('register');
	}

	public function otp(){
		$this->load->view('otp');
	}
	
	public function forgot_change_pass(){
	    $this->load->view('forgot_pass');
	}

	public function dashboard(){
		if($this->session->userdata('id')) {
			$this->load->view('dashboard');
		}
		else{
			redirect('login','refresh');
		}
	}
	
	public function catagories(){
		if($this->session->userdata('id')) {
			$r = $this->cat->get_all_catagories();
			$this->load->view('catagories', ['data'=>$r]);
		}
		else{
			redirect('login','refresh');
		}

	}

	public function products(){
		if($this->session->userdata('id')) {
			$r = $this->pro->get_all_products_for_admin();
			$this->load->view('products', ['data'=>$r]);
		}
		else{
			redirect('login','refresh');
		}

	}

	public function stocks(){
		if($this->session->userdata('id')) {
			$r = $this->sto->get_all_stocks();
			$this->load->view('stocks', ['data'=>$r]);
		}
		else{
			redirect('login','refresh');
		}

	}

	public function orders(){
		if($this->session->userdata('id')) {
			 $r = $this->ord->all_order_detail();
			//print_r($r);
		//	die();

			 $this->load->view('orders', ['data'=>$r]);
			//$this->load->view('orders');
		}
		else{
			redirect('login','refresh');
		}

	}

	public function users(){
		if($this->session->userdata('id')) {
			$r = $this->user->getallcustomers();
			$this->load->view('users', ['data'=>$r]);
		}
		else{
			redirect('login','refresh');
		}

	}

	public function farmers(){
		if($this->session->userdata('id')) {
			$r = $this->user->getallfarmers();
			$this->load->view('farmers', ['data'=>$r]);
		}
		else{
			redirect('login','refresh');
		}

	}

	public function newfarmers(){
		if($this->session->userdata('id')) {
			$r = $this->user->getInctiveFarmers();
			$this->load->view('inactivefarmer', ['data'=>$r, 'status' => 0]);
		}
		else{
			redirect('login','refresh');
		}

	}
	public function activatefarmer(){
		if($this->session->userdata('id')) {
			$data_id = $this->uri->segment(2);
			$r = $this->user->activateFarmerById($data_id);
				if($r['status']){
					$f = $this->user->getInctiveFarmers();
					$this->load->view('inactivefarmer', ['data'=>$f, 'msg' => $r['status']]);	
				}
				else{
					echo "record not updated";
					die();
				}	
			}
		else{
			redirect('login','refresh');
		}

	}

	public function change_pass(){
		if($this->session->userdata('id')) {
			// $r = $this->sto->get_all_orders();
			// $this->load->view('orders', ['data'=>$r]);
			$this->load->view('change_pass');
		}
		else{
			redirect('login','refresh');
		}

	}

	public function logout(){
		$this->session->unset_userdata('id');
		redirect('login','refresh');		
	}

}
