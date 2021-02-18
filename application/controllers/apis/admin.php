<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// include REST_Controler library
// require APPPATH. '/libraries/REST_Controller.php';

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		
		$this->load->helper('form');

		$this->load->library('session');
		
		// $this->load->model('user', '');
	}

	public function login(){
		// Pass JSON data.
        // $inputs = json_decode($this->input->raw_input_stream, true);
		
        // Pass POST data
		$inputs = $this->input->post();
		
		$params = [
			'user_type' => $inputs['user_type'],
			'username' => $inputs['username'],
			'password' => $inputs['password']
		];
		$res = $this->user->check_farmer_login($params);
        exit(json_encode($res));
    }

    public function register(){

        // Pass JSON data
		$inputs = json_decode($this->input->raw_input_stream, true);
		
        // Pass POST data
        $inputs = $this->input->post();
		
		$params = [
			'user_type' => $inputs['user_type'],
			'username' => $inputs['username'],
			'password' => sha1($inputs['password']),
			'name' => $inputs['name'],
			'age' => $inputs['age'],
			'gender' => $inputs['gender'],
			'phone' => $inputs['phone'],
			'address' => $inputs['address'],
			'town' => $inputs['town'],
			'country' => $inputs['country'],
		];
		$res = $this->user->add_user($params);
		exit(json_encode($res));

	}
	
	public function updadmin(){
		$inputs = json_decode($this->input->raw_input_stream, true);
		
		$params = [
			'user_type' => $inputs['user_type'],
			'username' => $inputs['username'],
			'password' => sha1($inputs['password']),
			'name' => $inputs['name'],
			'age' => $inputs['age'],
			'gender' => $inputs['gender'],
			'phone' => $inputs['phone'],
			'address' => $inputs['address'],
			'town' => $inputs['town'],
			'country' => $inputs['country'],
		];
		$res = $this->user->upd_user_by_id($params);
		exit(json_encode($res));
	}

	public function deladmin(){
		$params = [
			'id'=>'1'
		];

		echo '<pre>';
		exit($this->user->del_user_by_id($params));
	}
	

}


