<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_management extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		$this->load->model('email_model', 'mail');
		$this->load->model('otp_model', 'otp');
		$this->load->model('chart_model', 'chart');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		
		// $this->load->model('user', '');
	}

	public function login(){
		$params = [
			'email'=>$this->input->post('email'),
			'password'=>$this->input->post('upass')
		];

		
		$r = $this->user->check_admin_login($params);
		// echo json_encode( $this->user->check_farmer_login($params) );
	
		if($r['status']){
			$newdata = array(
					'id' 	=> $r['data'][0]['uid'],
					'type' 	=> $r['data'][0]['user_type'],
					'email' => $r['data'][0]['email'],
					'name'     => $r['data'][0]['name'],
			);
			if($newdata['type'] == 5){
				$this->session->set_userdata($newdata);
			
				redirect('dashboard','refresh');
			}
			else{
				$this->session->set_userdata($newdata);
				redirect('dashboard','refresh');
			}						
		}
		else{	
		    	$this->session->set_flashdata('msg', $r['message']);
			redirect('login','refresh');
			
		}

	}

	public function add_cordinator(){
		if($this->session->userdata('type') == 1){
				 $this->load->view('create_coordinator');
		}
	}

	public function register(){
		$this->load->helper(array('form', 'url'));

                $this->load->library('form_validation');

	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
	$this->form_validation->set_rules('upass', 'Password', 'trim|required|min_length[5]');
	$this->form_validation->set_rules('cupass', 'Confrim password', 'trim|required|min_length[5]|matches[upass]');

		if ($this->form_validation->run() == FALSE)
                {
                        $this->load->view('create_coordinator');
                }
                else
                {
                       

		$params = [
			'user_type' => $this->input->post('utype'),			
			'password' 	=> sha1($this->input->post('upass')),
			'name' 		=> $this->input->post('name'),
// 			'age' 		=> $this->input->post('age'),
// 			'gender' 	=> $this->input->post('gender'),
			'email' 	=> $this->input->post('email'),
			'phone' 	=> $this->input->post('phone'),
			'address' 	=> $this->input->post('address'),
			'town' 		=> $this->input->post('town'),
			'country' 	=> $this->input->post('country')
		];

        $username = $this->input->post('email');
        $pass = $this->input->post('upass');
        $_mail['to'] = $params['email'];
        $_mail['subject'] = "Cordinator account created in Fresh on the Go";
        $_mail['message'] = 'Your username is '.$username.' and password is '.$pass;
        
        $r = $this->mail->send_otp_mail($_mail);
        if($r['status']){           
                $res = $this->user->add_user($params);
                if($res['status']){
		          //  echo json_encode($res);
		            redirect(site_url('dashboard'));
                }
                else{
                    echo json_encode($res);
                } 	   
        }
        else{
            echo json_encode($r);
        }
    }
	
	}

	public function createXLS() {
    // create file name
      $orders = $this->chart->get_full_order_detail();
	  $this->load->view('downloadExFile',['data' => $orders]);
    }

    public function getDataFromTime(){
    	if(!empty($_POST)){
    		$month = $_POST['month'];
    		$year = $_POST['year'];
	        if($this->session->userdata('id')) {
				// $r = $this->chart->get_popular_product();
				// $k = $this->chart->get_income_detail();
				$o = $this->chart->order_detail_by_time($month, $year);
				//$this->load->view('dashboard',[ 'data' => $r , 'rec' => $k , 'statics'=>$o]);
				$param =  json_encode($o);
				print_r($param);
				die();

			}
			else{
				redirect('login','refresh');
			}

        }else{
            $this->data['subview'] = 'customer/dashboard/index';  
            $this->load->view('customer/_layout_main',$this->data);
        }
    }
}