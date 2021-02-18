<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocks extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		
		$this->load->helper('form');
		// $this->load->model('user', '');
	}
	
	public function index(){
		// echo 'Product page will be displayed here with all the products.';
        // echo json_encode($this->pro->get_all_products());
	}
	
	public function addStocks(){

        // echo '<pre>';
        // print_r($this->input->post());
		
		if($this->session->userdata('id')){
			
			$r = $this->pro->add_product($this->input->post());
			// echo json_encode($r);

			if($r['status']){
				redirect('products','refresh');
			}
			else{
				redirect('products','refresh');
			}
		}
		else{
			redirect('login','refresh');
		}

	}

	public function updStocks(){
		// echo '<pre>';
		// print_r($this->input->post());
	}

}
