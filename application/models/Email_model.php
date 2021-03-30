<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
	}
	
	public function send_otp_mail($params){
        $from_email = "mercadosagricola@4897219.mercadosagricolaspr.com";
        // $from_email = "_mainaccount@mercadosagricolaspr.com";
        $to_email = $params['to']; //"alokdas4all@gmail.com";
        $list = array('ops@mercadoaricolaspr.com');

        $subject = $params['subject']; //"Test message ..asa.";
        $message = $params['message']; //"This is a test message for Farmers. PORTO RICO";
	    
	   // Load email library
        $this->load->library('email');
        
       // Setting the config
        $config = array();
        $config['protocol'] = 'smtp';
        $config['SMTPAuth'] = 'true';
        $config['smtp_host'] = 'mail.mercadosagricolaspr.com';  //'mail.my-demo.xyz';
        $config['smtp_user'] = '_mainaccount@mercadosagricolaspr.com';
        $config['smtp_pass'] = '#Xyz@2021';
        $config['smtp_port'] = 587;
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype('html');
        
        $this->email->from($from_email, "Fresh");
        $this->email->to($to_email);
        $this->email->cc($list);
        $this->email->subject($subject);
        $this->email->message($message);
	   
	   //Send mail
        if($this->email->send()){
            $res = ["status"=>"true", "message"=>"Email enviado con éxito.", 'data'=>$this->email->print_debugger()];
            // $res = ["status"=>"true", "message"=>"Mail sent successfully.", 'data'=>$this->email->print_debugger()];
        }
        else{
            $res = ["status"=>"false", "message"=>"Falla envío Email.", 'error'=>$this->email->print_debugger()];
            // $res = ["status"=>"false", "message"=>"Mail sending failed.", 'error'=>$this->email->print_debugger()];
        }
        
        return $res;

	}


    public function product_rejected_mail($params){
        $from_email = "mercadosagricola@4897219.mercadosagricolaspr.com";
        // $from_email = "_mainaccount@mercadosagricolaspr.com";
        $to_email = $params['to']; //"alokdas4all@gmail.com";
        $subject = $params['subject']; //"Test message ..asa.";
        $message = $params['message']; //"This is a test message for Farmers. PORTO RICO";
        $list = array('ops@mercadoaricolaspr.com');

       // Load email library
        $this->load->library('email');
        
       // Setting the config
        $config = array();
        $config['protocol'] = 'smtp';
        $config['SMTPAuth'] = 'true';
        $config['smtp_host'] = 'mail.mercadosagricolaspr.com';  //'mail.my-demo.xyz';
        $config['smtp_user'] = '_mainaccount@mercadosagricolaspr.com';
        $config['smtp_pass'] = '#Xyz@2021';
        $config['smtp_port'] = 587;
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype('html');
        
        $this->email->from($from_email, "Fresh");
        $this->email->to($to_email);
         $this->email->cc($list);
        $this->email->subject($subject);
        $this->email->message($message);
       
       //Send mail
        if($this->email->send()){
            $res = ["status"=>"true", "message"=>"Email enviado con éxito.", 'data'=>$this->email->print_debugger()];
            // $res = ["status"=>"true", "message"=>"Mail sent successfully.", 'data'=>$this->email->print_debugger()];
        }
        else{
            $res = ["status"=>"false", "message"=>"Falla envío Email.", 'error'=>$this->email->print_debugger()];
            // $res = ["status"=>"false", "message"=>"Mail sending failed.", 'error'=>$this->email->print_debugger()];
        }
        
        return $res;

    }

}