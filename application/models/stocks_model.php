<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocks_model extends CI_Model {

    private $tb_name, $tb_orders;

    public function __construct(){ 
        $this->tb_name = 'tbl_stocks';
           $this->tb_orders = 'tbl_order';
    }

    public function get_all_stocks(){
        // $res = $this->db->get($this->tb_name);

        $sql = 'SELECT sid, (SELECT name FROM tbl_products WHERE tbl_products.pid = tbl_stocks.pid) as pid, stock_in_dt, stock_out_dt, unit, qnty, remain_qty, total_qty, created_at, created_by FROM tbl_stocks';
        $res = $this->db->query($sql);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'failed to load'];
        }

    }
    
    public function get_stock_by_id($params){
        $res = $this->db->get_where($this->tb_name, ['sid'=>$params['id']]);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'failed to load'];
        }

    }

    public function add_stock($params){

        $res = $this->db->insert($this->tb_name, $params);
        if($res){
            return ['status'=>true, 'message'=>'added successfully.'];
        }
        else{
            return ['status'=>false, 'message'=>'Failed to add.'];
        }

    }
    
    public function upd_stock_by_id($params){
        $data = $params['data'];

        $chk_user = $this->db->get_where($this->tb_name, ['sid'=>$params['id']]);

        if(!empty($chk_user->result_array())){
            $this->db->where('sid', $params['id']);
            $res = $this->db->update($this->tb_name, $data);

            if($res){
                return ['status'=>true, 'message'=>'updated successfully.'];
            }
            else {
                return ['status'=>false, 'message'=>'added successfully.'];
            }
            
        }
        else{
            return ['status'=>false, 'message'=>'Stock doesn\'t exists.'];
        }
        
    }

       // public function get_all_orders(){
       //      $res = $this->db->get($this->tb_orders);
       //      if(!empty($res->result())){
       //          return ['status'=>true, 'message'=>'Usuario cargados con éxito.', 'data'=>$res->result_array()];
       //      // return ['status'=>true, 'message'=>'User loaded successfully', 'data'=>$res->result_array()];
       //      }
       //      else{
       //      return ['status'=>false, 'message'=>'Falla para cargar usuario.'];
       //      // return ['status'=>false, 'message'=>'Failed to load user.'];
       //      }
       // }

    public function del_stock_by_id($params){
        $chk_user = $this->db->get_where($this->tb_name, ['sid'=>$params['id']]);

        if(!empty($chk_user->result_array())){
            $res = $this->db->delete($this->tb_name, array('sid' => $params['id']));

            if($res){
                return ['status'=>true, 'message'=>'deleted successfully.'];
            }
            else{
                return ['status'=>false, 'message'=>'failed to delete.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Stock doesnot exists.'];
        }

    }
    
}


