<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_info extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('products_model', 'pro');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('order_model', 'ord');
		$this->load->model('email_model', 'mai');
		
		$this->load->helper('form');

		$this->load->library('session');
	}

	public function getOrderDetail(){
		$order_id =	$this->uri->segment('3');
		
			 $r = $this->ord->get_order_detail($order_id);
			
// echo "<pre>";
// print_r($r);
// die();
//$data = ['data'=>$r['data'], 'order_id' =>$r['order_id'], 'customerName'=>$r['order_from'] ];

$this->load->view('orderdetail', $r);
		//	$this->load->view('orderdetail', $r);
			
	}

}