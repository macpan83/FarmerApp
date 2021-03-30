<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_model extends CI_Model {

    private $tb_name , $tb_delvery_timing;

    public function __construct(){ 
        $this->tb_name = 'tbl_store_address';
        $this->tb_delvery_timing = 'home_delivery_timing';
    }

    public function getalladdress(){

         $res = $this->db->get($this->tb_name);         
        // die();
        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Usuario cargados con éxito.', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'User loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar usuario.','data'=>$res->result_array()];
            // return ['status'=>false, 'message'=>'Failed to load user.'];
        }
    }

    public function add_store_address($params){
         $res = $this->db->insert($this->tb_name, $params);
         return $res;

    }

    public function update_store_address($params){
        $this->db->where('add_id', $params['add_id']);
        $res = $this->db->update($this->tb_name, $params);
    }
    

    public function get_delivery_timings(){
        $res = $this->db->get($this->tb_delvery_timing); 
         return $res->result();
// echo "inside delivery timing";
//         die();
    }
}

