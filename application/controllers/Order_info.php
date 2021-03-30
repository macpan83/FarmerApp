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

			$this->load->view('orderdetail', $r);
		//	$this->load->view('orderdetail', $r);
			
	}


	public function updateOrderDetail(){

		$params = [
			'ord_no'=>$this->input->post('order_no'),
			'updateAt'=>$this->input->post('updated_at'),  
			'orderStatus'=>$this->input->post('or_status'),  
			'orderRemark'=>$this->input->post('order_remark')
		];

		$r = $this->ord->upd_order_by_id($params);
		if($r['status']){
		$msg = 'pedido actualizado con éxito';
		$re = $this->ord->all_order_detail();
		$this->load->view('orders', ['data'=>$re,'status'=>true,'message'=>$msg]);
		}else{
		$msg = 'Lo sentimos, orden no actualizada';	
		$re = $this->ord->all_order_detail();
		$this->load->view('orders', ['data'=>$re,'status'=>false,'message'=>$msg]);
		}
		
	}

}