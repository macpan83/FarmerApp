<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class order extends CI_Controller {

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
	
	public function addcart(){
		// Here one product will be added in tbl_cart.
		
		// Pass JSON data 
		$inputs = json_decode($this->input->raw_input_stream, true);

		$data = [
		        'pid'           => $inputs['pid'],
		      //  'cid'         => $inputs['cid'],
		        'qty'           => $inputs['qty'],
		      //  'unit'          => $inputs['unit'],
		      //  'price'         => $inputs['price'],
		      //  'total_price'   => $inputs['qty'] * $inputs['price'],
		        'created_by'    => $inputs['uid']
		    ];
		
		$res = $this->ord->addcart($data);
		if($res['status']){
		    exit(json_encode($res));
		}
		else{
		    exit(json_encode($res));
		}
	}

	public function addmultiplecart(){
		// Here mutiple product willl be added in the tbl_cart
		
		// Pass JSON data 
		$inputs = json_decode($this->input->raw_input_stream, true);

        // here a loop need to be created for multiple file upload.
        
        foreach($inputs as$key => $val){
    		$data[$key] = [
    		        'pid'           => $val['pid'],
    		      //  'cid'         => $val['cid'],
    		        'qty'           => $val['qty'],
    		        'unit'          => $val['unit'],
    		        'price'         => $val['price'],
    		        'total_price'   => $val['qty'] * $val['price'],
    		        'created_by'    => $val['uid']
    		    ];            
        }

		$res = $this->ord->addmultiplecart($data);
		if($res['status']){
		    exit(json_encode($res));
		}
		else{
		    exit(json_encode($res));
		}
	}

	public function updatecart(){
		// Here both one product ormultiple products will be updated 
	}
	
	// Here both one product ormultiple products will be updated 
	public function updatecartbyid(){
		// Pass JSON data 
		$inputs = json_decode($this->input->raw_input_stream, true);
        
        $res = $this->ord->updatecartbyid($inputs);
        exit(json_encode($res));
	}
	
	public function deletecartbyid(){
		// Pass JSON data 
        // $inputs = json_decode($this->input->raw_input_stream, true);
        
        $res = $this->ord->deletecartbyid(['cart_id'=>$this->input->get('cartid')]);
        exit(json_encode($res));
	}
	
	public function showcart(){
	    $res = $this->ord->showcart();
	    exit(json_encode($res));
	}
	
	public function getorder_userpurchase(){
	    $res = $this->ord->getorder_userpurchase($this->input->get('uid'));
	    exit(json_encode($res));
	}

	public function showcart_byuid(){
	    $uid = $this->input->get('uid');
	    $res = $this->ord->showcart_byid($uid);
	    exit(json_encode($res));
	}

	public function addorder(){

	    $inputs = json_decode($this->input->raw_input_stream, true);

	    $data = [
		        'cart_id'   => json_encode($inputs['cart_id']),
		        'tot_price' => $inputs['tot_price'],
		        'status'    => $inputs['status'],
		        'remarks'    => $inputs['remarks'],
		        'created_by'=> $inputs['created_by']
		    ];

        $res = $this->ord->addorder($data);
        if($res['status']){


        // Notification for Farmer through mail 
            // $t = true;
            if(count($res['data']) > 1){
                foreach($res['data'] as $key => $val){
                    // This will be required for sending mail to customer
                    $cust_email[$key] = $this->db->get_where('tbl_users', ['uid'=>$val['cust_id']])->row()->email;
                    $cust_name[$key] = $this->db->get_where('tbl_users', ['uid'=>$val['cust_id']])->row()->name;
                    
                    
                    // Credentials to send mail to farmer
                    $to[$key]     = $val['email'];
                    $subject[$key]= 'Product has been purchased by '.$cust_name[$key];//$val['prod_name'];
                    $message[$key]= $cust_name[$key]. ' has purchased '.$val['qty'].' '.$val['prod_name'].($val['qty']==1?'':'s');
                    
                    $send_mail[$key] = $this->mai->send_otp_mail(['to'=>$to[$key], 'subject'=>$subject[$key], 'message'=>$message[$key]]);
                    // if($send_mail[$key]['status']){
                    //   $t = $send_mail[$key]['status']; 
                    // }
                    // else{
                    //   $t = $send_mail[$key]['status']; 
                    // }
                
                // echo $val['email'];
                    
                }
            }
            else{
                // This will be required for sending mail to customer
                $cust_email = $this->db->get_where('tbl_users', ['uid'=>$res['data'][0]['cust_id']])->row()->email;
                $cust_name = $this->db->get_where('tbl_users', ['uid'=>$res['data'][0]['cust_id']])->row()->name;
                
                
                // Credentials to send mail to farmer
                $to     = $res['data'][0]['email'];
                $subject= 'El producto ha sido comprado por '.$cust_name;//$val['prod_name'];
                // $subject= 'Product has been purchased by '.$cust_name;//$val['prod_name'];
                $message= $cust_name. ' ha comprado '.$res['data'][0]['qty'].' '.$res['data'][0]['prod_name'].($res['data'][0]['qty']==1?'':'s');
                // $message= $cust_name. 'has purchased '.$res['data'][0]['qty'].' '.$res['data'][0]['prod_name'].($res['data'][0]['qty']==1?'':'s');
                
                $send_mail = $this->mai->send_otp_mail(['to'=>$to, 'subject'=>$subject, 'message'=>$message]);
                // if($send_mail['status']){
                //   $t = $send_mail['status']; 
                // }
                // else{
                //   $t = $send_mail['status']; 
                // }
            }
            
        // -------------------------------------------
        
        // Notification for Customer through mail
        
        $str = '';
        foreach($res['data'] as $key => $val){
            $str .= $val['qty'] .' '. $val['prod_name'].'<br/>';
        }
        
        $custmr_mail = $this->db->get_where('tbl_users', ['uid'=>$inputs['created_by']])->row()->email;
        // if(!empty($custmr_mail)){
            
            $to      = $custmr_mail;
            $subject = 'Your\'s Orders';
            $message = 'Some of the orders are : <br/>'.$str;
            
            $send_mail = $this->mai->send_otp_mail(['to'=>$to, 'subject'=>$subject, 'message'=>$message]);
        //     if($send_mail['status']){
        //       $t = $send_mail['status']; 
        //     }
        //     else{
        //       $t = $send_mail['status']; 
        //     }
            
        // }
        // else{
        //     echo 'Customer email empty';
        // }
            
        // --------------------------------------------
            
            // if($t){
                exit(json_encode($res)); 
            // }
            
        }
        else{
            exit(json_encode($res));
        }

	}

}


