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
		$this->load->model('store_model', 'store');
		$this->load->model('chart_model','chart');
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
			$r = $this->chart->get_popular_product();
			$k = $this->chart->get_income_detail();
			$o = $this->chart->order_detail();

			$this->load->view('dashboard',[ 'data' => $r , 'rec' => $k , 'statics'=>$o]);

		}
		else{
			redirect('login','refresh');
		}
	}
	
	public function catagories(){
		if($this->session->userdata('id')) {
			$r = $this->cat->get_all_catagories();
			$msg = "A continuación se muestra la lista de categorías de productos";
			$this->load->view('catagories', ['data'=>$r, 'status'=>true,'message'=>$msg]);
		}
		else{
			redirect('login','refresh');
		}

	}

	public function products(){
		if($this->session->userdata('id')) {
			$r = $this->pro->get_all_products_for_admin();
			$msg = "A continuación se muestra la lista de productos";
			$this->load->view('products', ['data'=>$r,'status'=>true,'message'=>$msg]);
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
			 $msg = "Lista de orden";
			 $this->load->view('orders', ['data'=>$r ,'status'=>true,'message'=>$msg]);
			
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

	public function store_address(){
		if($this->session->userdata('id')) {
			$r = $this->store->getalladdress();
			$this->load->view('stores', ['data'=>$r]);
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
					$r = $this->user->getallfarmers();
					$this->load->view('farmers', ['data'=>$r]);
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
	public function deactivatefarmer(){
		if($this->session->userdata('id')) {
			$data_id = $this->uri->segment(2);
			$r = $this->user->deactivateFarmerById($data_id);
				if($r['status']){
					$r = $this->user->getallfarmers();
					$this->load->view('farmers', ['data'=>$r]);	
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
