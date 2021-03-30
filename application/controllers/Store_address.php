<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_address extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('products_model', 'pro');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('email_model', 'mai');
		$this->load->model('store_model', 'store');
		$this->load->helper('form');
		$this->load->library('session');
	}

    public function add_store_address(){
        $params = [
            'store_addresses'=>$this->input->post('add_store_address'),
            'address_type'=>$this->input->post('add_store_type')            
        ];
        
        $r = $this->store->add_store_address($params);
        $result = $this->store->getalladdress();
        $this->load->view('stores',['data'=>$result]);
    }

    public function update_store_address(){
        $params = [
            'store_addresses'=>$this->input->post('up_store_address'),
            'address_type'=>$this->input->post('up_store_type')   ,
            'add_id'=>$this->input->post('add_id')            
        ];
        
        $r = $this->store->update_store_address($params);
        
           $result = $this->store->getalladdress();
        $this->load->view('stores',['data'=>$result]);    
        

    }

}


