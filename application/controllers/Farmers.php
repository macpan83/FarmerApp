<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Farmers extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		$this->load->model('email_model', 'mail');
		$this->load->model('otp_model', 'otp');
		
		$this->load->helper('form');

		$this->load->library('session');
		
		// $this->load->model('user', '');
	}

	public function index(){}

	public function login(){
		$params = [
			'user_type'=>$this->input->post('utype'),
			'email'=>$this->input->post('email'),
			'password'=>$this->input->post('upass')
		];

		
		$r = $this->user->check_farmer_login($params);
		// echo json_encode( $this->user->check_farmer_login($params) );

		if($r['status']){
			$newdata = array(
					'id' 	=> $r['data'][0]['uid'],
					'type' 	=> $r['data'][0]['user_type'],
					'email' => $r['data'][0]['email'],
					'name'     => $r['data'][0]['name'],
			);

			$this->session->set_userdata($newdata);

			redirect('dashboard','refresh');			
		}
		else{
			
			redirect('login','refresh');
			
		}

	}
	
	public function register(){

		$params = [
			'user_type' => $this->input->post('utype'),
			'username' 	=> $this->input->post('uname'),
			'password' 	=> sha1($this->input->post('upass')),
			'name' 		=> $this->input->post('name'),
			'age' 		=> $this->input->post('age'),
			'gender' 	=> $this->input->post('gender'),
			'email' 	=> $this->input->post('email'),
			'phone' 	=> $this->input->post('phone'),
			'address' 	=> $this->input->post('address'),
			'town' 		=> $this->input->post('town'),
			'country' 	=> $this->input->post('country')
		];

        $token = $this->generateRandomString(6);
        $_mail['to'] = $params['email'];
        $_mail['subject'] = "Token from Fresh on the Go";
        $_mail['message'] = 'Your generated token is '.$token;
        
        $r = $this->mail->send_otp_mail($_mail);
        if($r['status']){
            $o = $this->otp->add_otp(['otp'=>$token]);
            if($o['status']){
                $res = $this->user->add_user($params);
                if($res['status']){
		          //  echo json_encode($res);
		            redirect('otp','refresh');
                }
                else{
                    echo json_encode($res);
                }
                
		    }
		    else{
		        echo json_encode($o);
		    }
        }
        else{
            echo json_encode($r);
        }
	
	}
 
    public function upd_usr_after_otp(){
        $params = [
            'user_type'=>'2',
            'username'=>$this->input->post('uname'),
            'otp'=>$this->input->post('otp')
        ];
        
        $r = $this->otp->get_details_by_otp($params);
        if($r['status']){
            redirect('login','refresh');
            echo '<script>alert("User registered successfully.")</script>';
        }
        else{
            $res = $this->user->del_user_by_username($params['username']);
            if($res['status']){
                redirect('register','refresh'); 
            }
            else{
                echo json_encode($res);
            }

        }
        
    }
    public function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    

// get farmer email for sending information of his regected product

    

	public function forgot_change_pass_web(){
	    extract($this->input->post());

	    $params = [
	        'email'     => $email,
	        'code'      => $code,
	        'new_pass'  => $new_pass
        ];
	           
// --------- Function to check the email and code in the user table.
        $chk1 = $this->user->chk_cust_code_by_email($params);
        if($chk1['status']){
            
            $this->session->set_flashdata('chk1status', $chk1['status']);
            $this->session->set_flashdata('chk1message', $chk1['message']);
            
            $res = $this->user->forgot_change_pass($params);
    		if($res['status']){
                // echo json_encode($res);
                $this->session->set_flashdata('status', $res['status']);
                $this->session->set_flashdata('flag', 1);
                $this->session->set_flashdata('message', $res['message']);
                redirect('forgot_change_pass', 'refresh');
    		}
    		else{
    		  //  echo json_encode($res);
    		    $this->session->set_flashdata('status', true/*$res['status']*/);
    		    $this->session->set_flashdata('flag', 0);
    		    $this->session->set_flashdata('message', $res['message']);
    		    redirect('forgot_change_pass', 'refresh');
    		}
    
        }
        else{
            // echo json_encode($chk1);
            $this->session->set_flashdata('chk1status', $chk1['status']);
            $this->session->set_flashdata('chk1message', $chk1['message']);
            redirect('forgot_change_pass', 'refresh');
        }

	}

}
