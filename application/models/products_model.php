<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

    private $tb_name;

    public function __construct(){ 
        $this->tb_name = 'tbl_products';
    }

    public function get_all_products_for_admin(){
        
        $this->db->select('pid');
        $this->db->select('cid');
        $this->db->select('(SELECT name FROM tbl_categories WHERE tbl_categories.cid = tbl_products.cid) as category');
        $this->db->select('type');
        $this->db->select('image');
        $this->db->select(['name', 'description', 'cost_price', 'sell_price', 'unit', 'total_qty', 'approve', 'created_at', 'updated_at', 'created_by']);
        $this->db->from($this->tb_name);
        // $this->db->where('approve', '1');
        $this->db->order_by('pid', 'desc');
        $res = $this->db->get();

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Productos cargados con éxito.', 'count'=>count($res->result_array()), 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Products loaded successfully.', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar todos los productos.'];
            // return ['status'=>false, 'message'=>'Failed to load all the products.'];
        }

    }
    
    public function get_all_products(){
        
        $this->db->select('pid');
        $this->db->select('cid');
        $this->db->select('(SELECT name FROM tbl_categories WHERE tbl_categories.cid = tbl_products.cid) as category');
        $this->db->select('type');
        $this->db->select('image');
        $this->db->select(['name', 'description', 'cost_price', 'sell_price', 'unit', 'total_qty', 'created_at', 'updated_at', 'created_by']);
        $this->db->from($this->tb_name);
        $this->db->where('approve', '1');
        $this->db->order_by('pid', 'desc');
        $res = $this->db->get();

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Productos cargados con éxito.', 'count'=>count($res->result_array()), 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Products loaded successfully.', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar todos los productos.'];
            // return ['status'=>false, 'message'=>'Failed to load all the products.'];
        }

    }
    
    public function get_product_by_id($params){
        $res = $this->db->get_where($this->tb_name, ['pid'=>$params['id']]);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Productos cargados con éxito.', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Products loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar producto.'];
            // return ['status'=>false, 'message'=>'Failed to load all the products.'];
        }

    }
    
    public function get_product_by_name($params){
        $res = $this->db->order_by('pid', 'DESC')->get_where($this->tb_name, ['name'=>$params['name'], 'approve'=>'1']);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Productos cargados con éxito.', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Products loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar producto.'];
            // return ['status'=>false, 'message'=>'Failed to load all the products.'];
        }

    }

    public function get_product_by_names($params){
        $this->db->select('*');
        $this->db->from($this->tb_name);
        $this->db->where('name LIKE "'.$params['name'].'%"');
        $this->db->where('approve', '1');
        $this->db->order_by('pid', 'DESC');
        $res = $this->db->get();
        
        

        if(!empty($res->result())){
            foreach($res->result() as $key => $val){
                $data[$key]['pid']          = $val->pid;
                $data[$key]['cid']          = $val->cid;
                $data[$key]['category']     = $this->db->get_where('tbl_categories', ['cid'=>$val->cid])->row()->name;
                $data[$key]['type']         = $val->type;
                $data[$key]['image']        = $val->image;
                $data[$key]['name']         = $val->name;
                $data[$key]['description']  = $val->description;
                $data[$key]['cost_price']   = $val->cost_price;
                $data[$key]['sell_price']   = $val->sell_price;
                $data[$key]['unit']         = $val->unit;
                $data[$key]['total_qty']    = $val->total_qty;
                $data[$key]['approve']      = $val->approve;
                $data[$key]['created_at']   = $val->created_at;
                $data[$key]['updated_at']   = $val->updated_at;
                $data[$key]['created_by']   = $val->created_by;
            }
            return ['status'=>true, 'message'=>'Productos cargados con éxito.', 'total_rec'=>count($res->result()), 'data'=>$data];
            // return ['status'=>true, 'message'=>'loaded successfully', 'total_rec'=>count($res->result()) , 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar producto.'];
            // return ['status'=>false, 'message'=>'failed to load all the products'];
        }

    }
    
    public function get_product_by_catagory($params){
        $res = $this->db->order_by('pid', 'DESC')->get_where($this->tb_name, ['cid'=>$params['cid'], 'approve'=>'1'])->result();

        if(!empty($res)){
            
            foreach($res as $key => $val){
                $data[$key]['pid']      = $val->pid;
                $data[$key]['cid']      = $val->cid;
                $data[$key]['category'] = $this->db->get_where('tbl_categories', ['cid'=>$val->cid])->row()->name;
                $data[$key]['type']     = $val->type;
                $data[$key]['image']    = $val->image;
                $data[$key]['name']     = $val->name;
                $data[$key]['description']  = $val->description;
                $data[$key]['cost_price']   = $val->cost_price;
                $data[$key]['sell_price']   = $val->sell_price;
                $data[$key]['unit']         = $val->unit;
                $data[$key]['total_qty']    = $val->total_qty;
                $data[$key]['approve']      = $val->approve;
                $data[$key]['created_at']   = $val->created_at;
                $data[$key]['updated_at']   = $val->updated_at;
                $data[$key]['created_by']   = $val->created_by;
            }
            
            return ['status'=>true, 'message'=>'Productos cargados con éxito', 'total_rec'=>count($data), 'data'=>$data];
            // return ['status'=>true, 'message'=>'Products loaded successfully.', 'total_rec'=>count($data), 'data'=>$data];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar Producto por categoría.'];
            // return ['status'=>false, 'message'=>'Failed to load the product as per category.'];
        }

    }

    public function get_product_by_catagory_limit_prod($params){
        $this->db->limit($params['limit']);
        $res = $this->db->order_by('pid', 'DESC')->get_where($this->tb_name, ['cid'=>$params['cid'], 'approve'=>'1']);

        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Productos cargados con éxito.', 'total_rec'=>count($res->result()), 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Products loaded successfully', 'total_rec'=>count($res->result()), 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar producto'];
            // return ['status'=>false, 'message'=>'failed to load the products.'];
        }

    }

    public function get_product_by_catagory_6prod($params){
        
        $this->db->select('cid');
        $this->db->select('(SELECT name from tbl_categories WHERE tbl_categories.cid = tbl_products.cid) as cname');
        $this->db->select('(SELECT c_img from tbl_categories WHERE tbl_categories.cid = tbl_products.cid) as c_img');
        $this->db->from($this->tb_name);
        $this->db->group_by('cid');
        $res = $this->db->get();

        if(!empty($res->result())){
            
            foreach($res->result() as $key => $val){
                $data[$key]['cid'] = $val->cid;
                $data[$key]['category'] = $val->cname;
                $data[$key]['c_img'] = $val->c_img;
                
                $this->db->limit($params['limit']);
                $res1 = $this->db->order_by('pid', 'DESC')->get_where($this->tb_name, ['cid'=>$val->cid]);

                $data[$key]['cdata'] = $res1->result();
            }
            
            return [
                'status'=>true, 
                'message'=>'Productos cargados con éxito.', 
                // 'message'=>'Products loaded successfully', 
                'total_rec'=>count($res->result()), 
                'data'=>$data //$res->result_array()
            ];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar producto'];
            // return ['status'=>false, 'message'=>'failed to load the products.'];
        }

    }

    public function add_product($params){
        $chk_user = $this->db->get_where($this->tb_name, ['name'=>$params['name']]);

        if(empty($chk_user->result_array())){
            $res = $this->db->insert($this->tb_name, $params);
            if($res){
                return ['status'=>true, 
                        'message'=>'Producto agregado con éxito.', 
                        'pid'=>$this->db->insert_id(), 
                        'pname'=>$params['name'], 
                        'qty'=>$params['total_qty'], 
                        'user'=>$this->db->get_where('tbl_users', ['uid'=>$params['created_by']])->row()->name
                ];
                // return ['status'=>true, 'message'=>'Product added successfully.', 'pid'=>$this->db->insert_id()];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para agregar producto.'];
                // return ['status'=>false, 'message'=>'Failed to add the product.'];
            }
        }
        else{
            return ['status'=>false, 'message'=>'Producto ya existente.'];
            // return ['status'=>false, 'message'=>'Product already existed.'];
        }

    }
    
    public function upd_product_by_id($params){

        // echo '<pre>'; print_r($params);

        $data = $params['data'];



       
        $chk_user = $this->db->get_where($this->tb_name, ['pid'=>$params['id']]);

        if(!empty($chk_user->result_array())){
            $this->db->where('pid', $params['id']);
            $res = $this->db->update($this->tb_name, $data);

            if($res){
               
                return ['status'=>true, 'message'=>'Producto actualizado con éxito.'];
                // return ['status'=>true, 'message'=>'Product updated successfully.'];

            }
            else {
                return ['status'=>false, 'message'=>'Producto no actualizado.'];
                // return ['status'=>false, 'message'=>'Product was not updated.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Producto no existente.'];
            // return ['status'=>false, 'message'=>'Product doesn\'t exists.'];
        }

    }

    public function upd_product_by_name($params){

        // echo '<pre>'; print_r($params);

        $data = $params['data'];

        $chk_user = $this->db->get_where($this->tb_name, ['name'=>$params['pname']]);

        if(!empty($chk_user->result_array())){
            $this->db->where('name', $params['pname']);
            $res = $this->db->update($this->tb_name, $data);

            if($res){
                return ['status'=>true, 'message'=>'Producto actualizado con éxito.'];
                // return ['status'=>true, 'message'=>'updated successfully.'];
            }
            else {
                return ['status'=>false, 'message'=>'Producto no actualizado.'];
                // return ['status'=>false, 'message'=>'added successfully.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Producto no existente.'];
            // return ['status'=>false, 'message'=>'Product doesn\'t exists.'];
        }

    }

    public function upd_prod_img_by_pid($params){
        $chk_user = $this->db->get_where($this->tb_name, ['pid'=>$params['pid']]);

        if(!empty($chk_user->result_array())){
            $this->db->where('pid', $params['pid']);
            $res = $this->db->update($this->tb_name, ['image'=>$params['file_name']]);

            if($res){
                return ['status'=>true, 'message'=>'Imagen y detalles Producto actualizados con éxito.'];
                // return ['status'=>true, 'message'=>'Product image uploaded and details updated successfully.'];
            }
            else {
                return ['status'=>false, 'message'=>'Producto no actualizado.'];
                // return ['status'=>false, 'message'=>'Failed to update the product.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Producto no existente.'];
            // return ['status'=>false, 'message'=>'Product doesn\'t exists.'];
        }
    }

    public function del_product_by_id($params){
        $chk_user = $this->db->get_where($this->tb_name, ['pid'=>$params['id']]);

        if(!empty($chk_user->result_array())){
            $res = $this->db->delete($this->tb_name, array('pid' => $params['id']));

            if($res){
                return ['status'=>true, 'message'=>'Producto borrado con éxito.'];
                // return ['status'=>true, 'message'=>'Product deleted successfully.'];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para borrar Productos.'];
                // return ['status'=>false, 'message'=>'Failed to delete the product.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Producto no existente.'];
            // return ['status'=>false, 'message'=>'Product doesnot exists.'];
        }

    }

    public function del_product_by_name($params){
        $chk_user = $this->db->get_where($this->tb_name, ['name'=>$params['pname']]);

        if(!empty($chk_user->result_array())){
            $res = $this->db->delete($this->tb_name, array('name' => $params['pname']));

            if($res){
                return ['status'=>true, 'message'=>'Todos los productos borrados con éxito.'];
                // return ['status'=>true, 'message'=>'All products deleted successfully.'];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para borrar todos los productos.'];
                // return ['status'=>false, 'message'=>'Failed to delete all the products.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Producto no existente.'];
            // return ['status'=>false, 'message'=>'Product doesnot exists.'];
        }

    }
    
    public function del_all_products(){

        $res = $this->db->delete($this->tb_name);

        if($res){
            return ['status'=>true, 'message'=>'Todos los productos borrados con éxito.'];
            // return ['status'=>true, 'message'=>'All products deleted successfully.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para borrar todos los productos.'];
            // return ['status'=>false, 'message'=>'failed to delete all the products.'];
        }

    }
    
    
    public function get_uploaded_prod_by_farmer($uid){
        $res = $this->db->get_where($this->tb_name, ['created_by'=>$uid])->result();
        
        if(count($res)){
            
            foreach($res as $key => $val){
                $data[$key]['pid']          = $val->pid;
                $data[$key]['cid']          = $val->cid;
                $data[$key]['category']     = $this->db->get_where('tbl_categories', ['cid'=>$val->cid])->row()->name;
                $data[$key]['type']         = $val->type;
                $data[$key]['image']        = $val->image;
                $data[$key]['name']         = $val->name;
                $data[$key]['description']  = $val->description;
                $data[$key]['cost_price']   = $val->cost_price;
                $data[$key]['sell_price']   = $val->sell_price;
                $data[$key]['unit']         = $val->unit;
                $data[$key]['total_qty']    = $val->total_qty;
                $data[$key]['approve']      = $val->approve;
                $data[$key]['created_at']   = $val->created_at;
                $data[$key]['updated_at']   = $val->updated_at;
                $data[$key]['created_by']   = $val->created_by;
            }
            return ['status'=>true, 'message'=>'Lista productos cargados por Agricultores.', 'total_rec'=>count($res), 'data'=>$data];
            // return ['status'=>true, 'message'=>'List of products uploaded by farmers.', 'total_rec'=>count($res), 'data'=>$data];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar lista productos cargados por Agricultores.'];
            // return ['status'=>false, 'message'=>'Failed to load the list of products uploaded by farmers.'];
        }
    }
    
}

