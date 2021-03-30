<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customer extends CI_Controller {

	public function __construct(){
		parent::__construct();
		ob_start();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		$this->load->model('email_model', 'mail');
		$this->load->model('otp_model', 'otp');
		$this->load->model('order_model', 'ord');
		
		$this->load->helper(['form', 'utility']);

		$this->load->library('session');
		$this->load->library('upload');
		
		// $this->load->model('user', '');
	}

	public function login(){
		// Pass JSON data.
		$inputs = json_decode($this->input->raw_input_stream, true);
		
		// Pass POST data
 		// $inputs = $this->input->post();
		
		$params = [
			'user_type' => $inputs['user_type'],
			'email' => $inputs['email'],
			'password' => $inputs['password']
		];
		$res = $this->user->check_farmer_login($params);
		
		if($res['status']){
		    $this->session->set_userdata(
		        [
		            'uid'=>$res['data'][0]['uid'], 
		            'user_type'=>$res['data'][0]['user_type'], 
		            'email'=>$res['data'][0]['email'], 
		            'name'=>$res['data'][0]['name']
		        ]);
		    exit(json_encode($res));
		}
		else{
		    exit(json_encode($res));
		}
        
    }

    public function register(){

        // This is to get the inputs from json in insomnia.
		$inputs = json_decode($this->input->raw_input_stream, true);

        $params = [
			'user_type' => $inputs['user_type'],
			'name'      => $inputs['name'],  //Added now
			'address'   => $inputs['address'],  //Added now
			'email' 	=> $inputs['email'],
			'password' 	=> sha1($inputs['password'])
		];

        $token = generateRandomString(6);
        $_mail['to'] = $params['email'];
        $_mail['subject'] = "Token from Fresh on the Go";
        $_mail['message'] = 'Your generated token is '.$token;

        $chk_user = $this->user->get_customer_by_email(['email'=>$params['email']]);
        if(!$chk_user['status']){
            
            $a_u_c = $this->user->add_user($params);
            if($a_u_c['status']){
                // Token sent in mail.
                $r = $this->mail->send_otp_mail($_mail);
        
                if($r['status']){
                    $o = $this->otp->add_otp(['otp'=>$token, 'email'=>$params['email']]);
                    if($o['status']){
                        // $this->session->set_userdata('password', $params['password']);
                        
                        exit(json_encode(['status'=>'true', 'message'=>'Revisar email para contraseña de un solo uso']));
        		    }
        		    else{
        		        exit(json_encode($o));
        		    }
                }
                else{
                    exit(json_encode($r));
                }

            }
            else{
                exit(json_encode($a_u_c));
            }

        }
        else{
            exit(json_encode($chk_user));
        }

	}
	
    public function register_old(){

        // This is to get the inputs from json in insomnia.
		$inputs = json_decode($this->input->raw_input_stream, true);

        $params = [
			'user_type' => $inputs['user_type'],
			'email' 	=> $inputs['email'],
			'password' 	=> sha1($inputs['password'])
		];

        $token = generateRandomString(6);
        $_mail['to'] = $params['email'];
        $_mail['subject'] = "Token from Fresh on the Go";
        $_mail['message'] = 'Your generated token is '.$token;

        // Token sent in mail.
        $r = $this->mail->send_otp_mail($_mail);

        if($r['status']){
            $o = $this->otp->add_otp(['otp'=>$token, 'email'=>$params['email']]);
            if($o['status']){
                $this->session->set_userdata('password', $params['password']);
                exit(json_encode($o));
		    }
		    else{
		        exit(json_encode($o));
		    }
        }
        else{
            exit(json_encode($r));
        }

	}
	
	public function upd_usr_after_otp(){

		$inputs = json_decode($this->input->raw_input_stream, true);

        $params = [
			'user_type' => $inputs['user_type'],
			'email' 	=> $inputs['email'],
			'password' 	=> $this->session->userdata('password'),
			'otp' 	    => $inputs['otp']
		];
   
        $r = $this->otp->get_details_by_otp_email($params);

        if($r['status']){
            
            $p = [
                'user_type'=>$params['user_type'],
                'email'=>$params['email'],
                // 'password'=>$this->session->userdata('password'),
			    'status'    => '1'
                
            ];

            // $res = $this->user->add_user($p);
            $res = $this->user->upd_cust_status_by_email($p);  // update user with status 1

            if($res['status']){
                $d_otp = $this->otp->del_otp(['email'=>$params['email']]);
                if($d_otp['status']){
                    echo json_encode($res);
                }
                else{
                    echo json_encode($res);
                }

            }
            else{
                echo json_encode($res);
            }
            
        }
        else{
            echo json_encode($r);
        }
        
    }
	
    public function logout(){
        $this->load->driver('cache'); # add
        $this->session->sess_destroy(); # Change
        $this->cache->clean();  # add
        // redirect('home'); # Your default controller name 
        // ob_clean(); # add
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
		$res = $this->user->add_user($params);
		exit(json_encode($res));
	}
	
	public function send_forgot_pass_token(){
    	$inputs = json_decode($this->input->raw_input_stream, true);
	    
	    $params = [
	        'email' => $inputs['email']
        ];
        
		$res = $this->user->get_customer_by_email($params);
		if($res['status']){
		    
	        $token = generateRandomString(4);
            $_mail['to'] = $params['email'];
            $_mail['subject'] = "Se te olvidó tu contraseña";  // 'Forgot password';
            $_mail['message'] = 'Su token generado para la contraseña olvidada es <b>'.$token.'</b>';
            // $_mail['message'] = 'Your generated token for forgot password is <b>'.$token.'</b>';
            
            $r = $this->mail->send_otp_mail($_mail);
            if($r['status']){
                
                $param_user = ['email'=>$params['email'], 'code'=>$token];
                $cr = $this->user->upd_cust_code_by_email($param_user);
                
                if($cr['status']){
                    echo json_encode($cr);
                }
                else{
                    echo json_encode($cr);
                }

            }
            else{
                echo json_encode($r);
            }
		}
		else{
		    echo json_encode($res);
		}
	}
	
	public function forgot_change_pass(){
	    $inputs = json_decode($this->input->raw_input_stream, true);
	    
	    $params = [
	        'email'     => $inputs['email'],
	        'code'      => $inputs['code'],
	        'new_pass'  => $inputs['new_pass']
        ];
	    
        $chk1 = $this->user->chk_cust_code_by_email($params);
        if($chk1['status']){
            $res = $this->user->forgot_change_pass($params);
    		if($res['status']){
                echo json_encode($res);
    		}
    		else{
    		    echo json_encode($res);
    		}

        }
        else{
            echo json_encode($chk1);
        }

	}
	
	public function change_pass(){
	    
	    $inputs = json_decode($this->input->raw_input_stream, true);

	    $params = [
	        'email'     => $inputs['email'],
	        'old_pass'  => $inputs['old_pass'],
	        'new_pass'  => $inputs['new_pass']
        ];
	  
		$res = $this->user->change_password($params);
		if($res['status']){
            echo json_encode($res);
		}
		else{
		    echo json_encode($res);
		}
	}

	public function deladmin(){
		
	}

	public function get_details_by_id(){
		// Pass JSON data.
		// $inputs = json_decode($this->input->raw_input_stream, true);
		
		// Pass POST data
		$inputs = $this->input->get();
		
		$params = [
			'uid' => $inputs['id']
		];
		$res = $this->user->get_customer_by_id($params);
        echo json_encode($res);
    }

	public function get_details_by_email(){
		$params = ['email' => $this->input->post('email')];
		$res = $this->user->get_customer_by_email($params);
        echo json_encode($res);
    }
    
    public function cust_profile_img_up(){
        // to pass json inputs
        // $inputs = json_decode($this->input->raw_input_stream, true);
        
        $inputs = $this->input->post();
        
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $config['file_name']            = time().'-'.date("Y-m-d").'-'.$_FILES['userfile']['name'];

        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());

            echo json_encode($error);
            // $this->load->view('upload_form', $error);
        }
        else
        {
            $data = ['upload_data' => $this->upload->data()];
            // echo json_encode($data);
            
            
            $file_name = $data['upload_data']['file_name'];

            $r = $this->user->upd_img_by_email(['email'=>$this->input->post('email'), 'file_name'=>site_url('uploads/').$config['file_name']]);
            
            if($r['status']){
                echo json_encode($r);
            }
            else{
                echo json_encode($r);
            }
                
        }

    }
    
    public function order_got_for_customer(){
        exit(json_encode($this->ord->order_got_for_customer(['uid'=>$this->input->get('uid')])));
    }
    
    public function customer_order_dets(){
        exit(json_encode($this->ord->customer_order_dets($this->input->get())));
    }


    // Forgot password with web for customers.
	public function send_forgot_pass_token_cust_web(){
    	$inputs = json_decode($this->input->raw_input_stream, true);
	    
	    $params = [
	        'email' => $inputs['email']
        ];
        
		$res = $this->user->get_customer_by_email($params);
		if($res['status']){
		    
		    $pass_site_name = 'https://www.mercadosagricolaspr.com/farmer-new/forgot_change_pass';
	        $token = generateRandomString(4);
            $_mail['to'] = $params['email'];
            $_mail['subject'] = 'Se te olvidó tu contraseña';     //"Forgot password";
            $_mail['message'] = 'Su token generado para la contraseña olvidada es <b>'.$token.'</b>.<br/><br/>Por favor, vaya a este sitio web para establecer una nueva contraseña. <br/>'.$pass_site_name;
            // $_mail['message'] = 'Your generated token for forgot password is <b>'.$token.'</b>.<br/><br/>Please, goto this site to set a new password. <br/>'.$pass_site_name;
            
            $r = $this->mail->send_otp_mail($_mail);
            if($r['status']){
                
                $param_user = ['email'=>$params['email'], 'code'=>$token];
                $cr = $this->user->upd_cust_code_by_email($param_user);
                
                if($cr['status']){
                    echo json_encode($cr);
                }
                else{
                    echo json_encode($cr);
                }

            }
            else{
                echo json_encode($r);
            }
		}
		else{
		    echo json_encode($res);
		}
		
	}
	
}


