<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Otp_model extends CI_Model {

    private $tb_name;

    public function __construct(){ 
        $this->tb_name = 'tbl_otp';
    }
    
    public function get_details_by_otp($params){
        
        $res = $this->db->get_where($this->tb_name, ['otp'=>$params['otp']]);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Validación OTP con éxito.'];
            // return ['status'=>true, 'message'=>'OTP validation successful.'];
        }
        else{
            return ['status'=>false, 'message'=>'Validación OTP con falla.'];
            // return ['status'=>false, 'message'=>'OTP validation failed.'];
        }

    }

    public function get_details_by_email($params){
        
        $res = $this->db->get_where($this->tb_name, ['email'=>$params['email']]);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Validación OTP con éxito.', 'total_rec'=>count($res->result()), 'data'=>$res->result()];
            // return ['status'=>true, 'message'=>'OTP validation successful.', 'total_rec'=>count($res->result()), 'data'=>$res->result()];
        }
        else{
            return ['status'=>false, 'message'=>'Validación OTP con falla.'];
            // return ['status'=>false, 'message'=>'OTP validation failed.'];
        }

    }

    public function get_details_by_otp_email($params){
        
        $res = $this->db->get_where($this->tb_name, ['otp'=>$params['otp'], 'email'=>$params['email']]);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Validación OTP con éxito.'];
            // return ['status'=>true, 'message'=>'OTP validation successful.'];
        }
        else{
            return ['status'=>false, 'message'=>'Validación OTP con falla.'];
            // return ['status'=>false, 'message'=>'OTP validation failed.'];
        }

    }

    public function add_otp($params){
        
        // $this->db->truncate($this->tb_name);
        $res = $this->db->insert($this->tb_name, $params);
        if($res){
            return ['status'=>true, 'message'=>'OTP agregado con éxito mensaje correo enviado al email.'];
            // return ['status'=>true, 'message'=>'OTP added successfully and a mail has been sent to respective email.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para agregar OTP.'];
            // return ['status'=>false, 'message'=>'Failed to add OTP.'];
        }

    }
    
    public function del_otp($params){
        $res = $this->db->delete($this->tb_name, array('email' => $params['email']));
        if($res){
            return ['status'=>true, 'message'=>'OTP borrado con éxito.'];
            // return ['status'=>true, 'message'=>'otp deleted successfully.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para borrar.'];
            // return ['status'=>false, 'message'=>'Failed to delete.'];
        }
    }
    
}


