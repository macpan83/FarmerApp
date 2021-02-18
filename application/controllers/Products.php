<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		$this->load->model('email_model', 'mail');
		$this->load->helper('form');
		// $this->load->model('user', '');
	}
	
	public function index(){
		// echo 'Product page will be displayed here with all the products.';
        // echo json_encode($this->pro->get_all_products());
	}
	
	public function addProducts(){
		
		// echo '<pre>';
		// print_r($this->input->post());
		// print_r($_FILES);

		if($this->session->userdata('id')){
			
			$r = $this->pro->add_product($this->input->post());
			// echo json_encode($r);

			if($r['status']){

				// $config['upload_path']          = './uploads/';
                // $config['allowed_types']        = 'gif|jpg|png';
                // $config['max_size']             = 100;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;

                // $this->load->library('upload', $config);

                // if ( ! $this->upload->do_upload('food_img'))
                // {
                //         $error = array('error' => $this->upload->display_errors());

				// 		echo '<pre>';
				// 		print_r($error);
				// 		// $this->load->view('upload_form', $error);
				// 		// redirect('products','refresh');
				// 	}
				// 	else
				// 	{
				// 		$data = array('upload_data' => $this->upload->data());
	
				// 		echo '<pre>';
				// 		print_r($data);
                //         // $this->load->view('upload_success', $data);
				// 		// redirect('products','refresh');
                // }
				
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

	public function updProducts(){

		$params = [
			'id'=>$this->input->post('pid'),
			'data'=>$this->input->post()  
		];
$productName = $this->input->post('name');
$productDescription = $this->input->post('description');
$farmerId= $this->input->post('created_by');
$farmerData=$this->user->getfarmerbyid($farmerId);

if($farmerData['total_rec'] != 0){
$farmerInfo = $farmerData['data'][0];
$farmerEmail = $farmerInfo->email;
}
$productStatus = $this->input->post('approve');

		if($this->session->userdata('id')){
			
			$r = $this->pro->upd_product_by_id($params);
			// echo json_encode($r);

			if($r['status']){
				If($productStatus == 0){
				 		$_mail['to'] = $farmerEmail;
				 	//	$_mail['to'] = 'mayank.pandey@cynoteck.com';
        				$_mail['subject'] = "Lo sentimos, su producto ha sido rechazado";
        				$_mail['message'] = '<html><body>';        				
						$_mail['message'] .= 'Lo siento Su producto: <b>'.$productName.'</b> con descripción <br>: <b>'.$productDescription.'</b>  <br> o incluido en el sitio, póngase en contacto con el administrador del sitio para obtener más comunicaciones';

						$_mail['message'] .= '</body></html>';
          				$r = $this->mail->product_rejected_mail($_mail);
				}

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

	public function delProducts(){
		// echo '<pre>';
		// print_r($this->input->post());
		$params = [
			'id'=>$this->input->post('pid'),
		];

		if($this->session->userdata('id')){
			
			$r = $this->pro->del_product_by_id($params);
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

}
