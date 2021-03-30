<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		//$this->load->library('upload');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('email_model', 'mai');		
		$this->load->helper('form');
		$this->load->library('session');
	}

    public function add_category(){       
               
                $config['upload_path']          = './uploads/products/';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                // $config['max_size']             = 100;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('cat_img'))
                {
                        $uploadedData = array('error' => $this->upload->display_errors());
                            $msg = 'Category anot added due to '.$uploadedData;
                            $res = $this->cat->get_all_catagories();
                           $this->load->view('catagories', ['data'=>$res,'message'=>$msg,'status'=>false]);  
                }
                else
                {
                        $uploadedData = array('upload_data' => $this->upload->data());
                         $fileName = base_url('uploads/products/').$uploadedData['upload_data']['file_name'];
                         $params = [
                                'name'=>$this->input->post('name'),
                                'description'=>$this->input->post('description'), 
                                'c_img'=>$fileName         
                                ];

                        $r = $this->cat->add_catagory($params);
                        if($r){
                            $msg = 'Category added sucessfully';
                            $res = $this->cat->get_all_catagories();
                            $this->load->view('catagories', ['data'=>$res,'message'=>$msg ,'status'=>true]); 
                        }
                        else{
                            $msg = 'Category was not added';
                            $res = $this->cat->get_all_catagories();
                            $this->load->view('catagories', ['data'=>$res,'message'=>$msg ,'status'=>false]); 
                        }
                }
               

        
    }

    public function update_category(){

        $config['upload_path']          = './uploads/products/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';                

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('cat_img'))
                {
                        $uploadedData = array('error' => $this->upload->display_errors());

                        $params = [
                                'cid'=>$this->input->post('cid'),
                                'name'=>$this->input->post('name'),
                                'description'=>$this->input->post('description'), 
                                // 'c_img'=>$fileName         
                                ];

                        $r = $this->cat->upd_catagory_by_id($params);
                        if($r){
                            $msg = 'Category updated successfully without image';
                            $res = $this->cat->get_all_catagories();
                            $this->load->view('catagories', ['data'=>$res,'message'=>$msg, 'status'=>true]);   
                        }
                        else{
                            $msg = 'Category not updated at all';
                            $res = $this->cat->get_all_catagories();
                            $this->load->view('catagories', ['data'=>$res,'message'=>$msg, 'status'=>false]); 
                        }

                        // $this->load->view('upload_form', $error);
                }
                else
                {
                        $uploadedData = array('upload_data' => $this->upload->data());
                         $fileName = base_url('uploads/products/').$uploadedData['upload_data']['file_name'];
                         $params = [
                                'cid'=>$this->input->post('cid'),
                                'name'=>$this->input->post('name'),
                                'description'=>$this->input->post('description'), 
                                'c_img'=>$fileName         
                                ];

                        $r = $this->cat->upd_catagory_by_id($params);
                        if($r){
                            $msg = 'Category updated successfully';
                            $res = $this->cat->get_all_catagories();
                            $this->load->view('catagories', ['data'=>$res,'message'=>$msg, 'status'=>true]); 
                        }
                        else{
                             $msg = 'Category not updated';
                            $res = $this->cat->get_all_catagories();
                             $this->load->view('catagories', ['data'=>$res,'message'=>$msg, 'status'=>false]); 
                          } 
                        }
    }

    public function delete_category(){
        $params = [
            'cid'=>$this->input->post('cid')                      
        ];
        
        $r = $this->cat->del_catagory_by_id($params);
        if($r){
            $msg = 'Category deleted sucessfully';
            $res = $this->cat->get_all_catagories();
            $this->load->view('catagories', ['data'=>$res,'message'=>$msg, 'status'=>true]);    
        }
        else{
            $msg = 'Category not deleted';
            $res = $this->cat->get_all_catagories();
            $this->load->view('catagories', ['data'=>$res,'message'=>$msg, 'status'=>false]);  
        }
    }

}


