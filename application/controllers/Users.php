<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		
		$this->load->helper('form');
    }

	public function index()
	{
		// $this->load->view('welcome_message');
		$this->load->view('farmers/index');
	}


	// -----Users models testing -----
	public function login(){
		echo '<pre>'; print_r($this->sto->get_all_products());
		
		// $params = [ 'id'=>'1' ];
        // echo '<pre>'; print_r($this->sto->get_stock_by_id($params));
	}

	public function register(){
		$params = [
			'name'=>'Dairy',
			'description'=>'Dairy items contains 10 items'
		];

		echo '<pre>'; 
		print_r($this->cat->add_catagory($params));
	}
	
	public function change_password(){
	    $r = $this->user->change_password_admin($this->input->post());
	    if($r['status']){
	        $this->session->set_flashdata('message', '<span class="text-success" style="font-size: 20px;">'.$r["message"].'</span>');
	        redirect('change_pass', 'refresh');
	    }
	    else{
	        $this->session->set_flashdata('message', '<span class="text-danger" style="font-size: 20px;">'.$r["message"].'</span>');
	        redirect('change_pass', 'refresh');
	    }
	}


}
