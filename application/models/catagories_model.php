<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catagories_model extends CI_Model {

    private $tb_name;

    public function __construct(){ 
        $this->tb_name = 'tbl_categories';
    }

    public function get_all_catagories(){
        $res = $this->db->get($this->tb_name);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Categorías Cargadas con Éxito.', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Category loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para Cargar Categorías.'];
            // return ['status'=>false, 'message'=>'Failed to load categories'];
        }

    }
    
    public function get_catagory_by_id($params){
        $res = $this->db->get_where($this->tb_name, ['cid'=>$params['id']]);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Categorías Cargadas con Éxito.', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Category loaded successfully.', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para Cargar Categoría'];
            // return ['status'=>false, 'message'=>'failed to load a category.'];
        }

    }

    public function add_catagory($params){
        $chk_user = $this->db->get_where($this->tb_name, ['name'=>$params['name']]);

        if(empty($chk_user->result_array())){
            $res = $this->db->insert($this->tb_name, $params);
            if($res){
                return ['status'=>true, 'message'=>'Categoría Agregada con Éxito.', 'data'=>$res];
                // return ['status'=>true, 'message'=>'Category added successfully.', 'data'=>$res];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para Agregar Categoría.', 'data'=>$res];
                // return ['status'=>false, 'message'=>'Failed to add a category.', 'data'=>$res];
            }
        }
        else{
            return ['status'=>false, 'message'=>'Categoría ya Existente.'];
            // return ['status'=>false, 'message'=>'Catagory already existed.'];
        }

    }
    
    public function upd_catagory_by_id($params){
        $data = $params['data'];

        $chk_user = $this->db->get_where($this->tb_name, ['cid'=>$params['id']]);

        if(!empty($chk_user->result_array())){
            $this->db->where('cid', $params['id']);
            $res = $this->db->update($this->tb_name, $data);

            if($res){
                return ['status'=>true, 'message'=>'Categoría actualizada con éxito.'];
                // return ['status'=>true, 'message'=>'Category updated successfully.'];
            }
            else {
                return ['status'=>false, 'message'=>'Falla al Actualizar Categoría.'];
                // return ['status'=>false, 'message'=>'Failed to update category.'];
            }
            
        }
        else{
            return ['status'=>false, 'message'=>'Categoría no existente.'];
            // return ['status'=>false, 'message'=>'Catagory doesn\'t exists.'];
        }
        
    }

    public function del_catagory_by_id($params){
        $chk_user = $this->db->get_where($this->tb_name, ['cid'=>$params['id']]);

        if(!empty($chk_user->result_array())){
            $res = $this->db->delete($this->tb_name, array('cid' => $params['id']));

            if($res){
                return ['status'=>true, 'message'=>'Categoría borrada con éxito.', 'data'=>$res];
                // return ['status'=>true, 'message'=>'Categroy deleted successfully.', 'data'=>$res];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para borrar categoría.', 'data'=>$res];
                // return ['status'=>false, 'message'=>'failed to delete the category.', 'data'=>$res];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Categoría no existente.'];
            // return ['status'=>false, 'message'=>'Catagory doesnot exists.'];
        }

    }
    
}


