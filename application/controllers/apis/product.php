<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('products_model', 'pro');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('email_model', 'mai');
		
		$this->load->helper('form');

		$this->load->library('session');
	}

	public function searchallproduct(){
		$res = $this->pro->get_all_products();
        exit(json_encode($res));
    }

	public function searchproductbyid(){
		$params = [
			'id' => $this->input->get('pid')
		];
		$res = $this->pro->get_product_by_id($params);
        exit(json_encode($res));
    }

	public function searchproductbyname(){
		$params = [
			'name' => $this->input->get('pname')
		];
		$res = $this->pro->get_product_by_name($params);
        exit(json_encode($res));
    }
    
	public function searchproductbynames(){
		$params = [
			'name' => $this->input->get('pname')
		];
		$res = $this->pro->get_product_by_names($params);
        exit(json_encode($res));
    }

	public function searchproductbycatagory(){
		$params = [
			'cid' => $this->input->get('cid')
		];
		$res = $this->pro->get_product_by_catagory($params);
        exit(json_encode($res));
    }
    
	public function searchproductbycatagory_limit_prod(){
		$params = [
			'cid' => $this->input->get('cid'),
			'limit'=>$this->input->get('limit')
		];
		$res = $this->pro->get_product_by_catagory_limit_prod($params);
        exit(json_encode($res));
    }

	public function searchproductbycatagory_6prod(){
		$params = [
			'cid' => $this->input->get('cid'),
			'limit'=>$this->input->get('limit')
		];
		$res = $this->pro->get_product_by_catagory_6prod($params);
        exit(json_encode($res));
    }

	public function delproductbyid(){
		$params = [
			'id'=>$this->input->get('pid'),
		];
        $r = $this->pro->del_product_by_id($params);
        exit(json_encode($r));
    }

	public function delproductbyname(){
		$params = [
			'pname'=>$this->input->get('pname'),
		];
        $r = $this->pro->del_product_by_name($params);
        exit(json_encode($r));
    }

	public function delallproduct(){
        $r = $this->pro->del_all_products();
        exit(json_encode($r));
    }
    
    public function addproducts(){
        // Pass JSON data
        $res = $this->pro->add_product(json_decode($this->input->raw_input_stream, true));
        
        // Pass POST data
        // $res = $this->pro->add_product($this->input->post());
        
        if($res['status']){
            $admin_mail_id = 'sriparna.biswas@gmail.com';
            // Credentials to send mail to Admin regarding a farmer has added a product for approval.
            $to         = $admin_mail_id;
            $subject    = 'Product approval';
            
            $qty      = $res['qty'];
            $_product = $res['pname'];
            $_farmer  = $res['user'];
            $message    = $qty.' '.$_product.' has been uploaded by '.$_farmer;
            
            $send_mail  = $this->mai->send_otp_mail(['to'=>$to, 'subject'=>$subject, 'message'=>$message]);
            
            exit(json_encode($res));

        }

    }

    public function updproductsbyid(){
        // Pass JSON data
		$inputs = json_decode($this->input->raw_input_stream, true);
		
		// Pass POST data
		// $inputs = $this->input->post();
		$inputs['updated_at'] = date('Y-m-d H:i:s');
		$params = [
			'id'=>$inputs['pid'],
			'data'=>$inputs
		];
			
        $r = $this->pro->upd_product_by_id($params);
        exit(json_encode($r));
    }

    public function updproductsbyname(){
		$inputs = json_decode($this->input->raw_input_stream, true);
		$params = [
			'pname'=>$inputs['pname'],
			'data'=>$inputs  
		];
			
        $r = $this->pro->upd_product_by_name($params);
        exit(json_encode($r));
    }
    
    public function getallcategories(){
        $r = $this->cat->get_all_catagories();
        exit(json_encode($r));
    }
    
    public function product_img_up(){
        // to pass json inputs
        // $inputs = json_decode($this->input->raw_input_stream, true);
        
        $inputs = $this->input->post();
        
        $config['upload_path']          = './uploads/products/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $config['file_name']            = time().$_FILES['userfile']['name'];

        // $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        }
        else
        {
            $data = ['upload_data' => $this->upload->data()];
            
            // echo json_encode($data);
            
            $file_name = $data['upload_data']['file_name'];
            $r = $this->pro->upd_prod_img_by_pid(['pid'=>$this->input->post('pid'), 'file_name'=>site_url('uploads/products/').$config['file_name']]);
            
            if($r['status']){
                echo json_encode($r);
            }
            else{
                echo json_encode($r);
            }
                
        }
        
        
    }

}


