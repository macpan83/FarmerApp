<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    private $tb_name;

    public function __construct(){ 
        $this->tb_name = 'tbl_users';
    }

    public function get_all_users(){
        $res = $this->db->get($this->tb_name);
        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Usuario cargados con éxito.', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'User loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar usuario.'];
            // return ['status'=>false, 'message'=>'Failed to load user.'];
        }

    }
    
    public function getallfarmers(){
        $res = $this->db->get_where($this->tb_name, ['user_type'=>'2', 'status' => '1'])->result();
        if(count($res)){
            return ['status'=>true, 'message'=>'Agricultores cargados con éxito.', 'total_rec'=>count($res), 'data'=>$res];
            // return ['status'=>true, 'message'=>'Farmers loaded sucessfully.', 'total_rec'=>count($res), 'data'=>$res];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar Agricultor'];
            // return ['status'=>false, 'message'=>'Failed to load farmer.'];
        }

    }

    public function getInctiveFarmers(){
 $res = $this->db->get_where($this->tb_name, ['user_type'=>'2','status'=>'0'])->result();


        if(count($res)){
            return ['status'=>true, 'message'=>'Agricultores cargados con éxito.', 'total_rec'=>count($res), 'data'=>$res];
            // return ['status'=>true, 'message'=>'Farmers loaded sucessfully.', 'total_rec'=>count($res), 'data'=>$res];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar Agricultor' , 'total_rec'=>count($res), 'data'=>$res];
            // return ['status'=>false, 'message'=>'Failed to load farmer.'];
        }


    }

    public function activateFarmerById($uid){
        $data = ['status' => '1'];
        $this->db->where('uid' , $uid);
            $res = $this->db->update($this->tb_name, $data);

        if($res){
            return ['status'=>true, 'message'=>'Farmer Activated with id = '.$uid,];
            // return ['status'=>true, 'message'=>'Farmers loaded sucessfully.', 'total_rec'=>count($res), 'data'=>$res];
        }
        else{
            return ['status'=>false, 'message'=>'Update command failed'];
            // return ['status'=>false, 'message'=>'Failed to load farmer.'];
        }


    }

    public function activateNewFarmer(){
 $res = $this->db->get_where($this->tb_name, ['user_type'=>'2','status'=>'0'])->result();


        if(count($res)){
            return ['status'=>true, 'message'=>'Agricultores cargados con éxito.', 'total_rec'=>count($res), 'data'=>$res];
            // return ['status'=>true, 'message'=>'Farmers loaded sucessfully.', 'total_rec'=>count($res), 'data'=>$res];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar Agricultor'];
            // return ['status'=>false, 'message'=>'Failed to load farmer.'];
        }


    }
    
    public function getallcustomers(){
        $res = $this->db->get_where($this->tb_name, ['user_type'=>'3'])->result();
        if(count($res)){
            return ['status'=>true, 'message'=>'Agricultores cargados con éxito.', 'total_rec'=>count($res), 'data'=>$res];
            // return ['status'=>true, 'message'=>'Farmers loaded sucessfully.', 'total_rec'=>count($res), 'data'=>$res];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar Agricultor'];
            // return ['status'=>false, 'message'=>'Failed to load farmer.'];
        }
    }
    
    public function get_users_by_id($params){
        $res = $this->db->get_where($this->tb_name, ['uid'=>$params['id']]);
        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Cliente cargado con éxito', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Customer loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar Cliente'];
            // return ['status'=>false, 'message'=>'Failed to load the customer.'];
        }

    }
    
    public function get_customer_by_id($params){
        $res = $this->db->get_where($this->tb_name, ['uid'=>$params['uid'], 'user_type'=>'3']);
        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Cliente cargado con éxito', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Customer loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar Cliente.'];
            // return ['status'=>false, 'message'=>'Failed to load the customer.'];
        }

    }
    
    public function get_customer_by_email($params){
        $res = $this->db->get_where($this->tb_name, ['email'=>$params['email']]);
        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Email disponible.'];
            // return ['status'=>true, 'message'=>'Email available.', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Dirección email no existe.'];
            // return ['status'=>false, 'message'=>'The email address doesn\'t exists.'];
        }

    }
    
    public function upd_cust_code_by_email($params){
        $this->db->where('email', $params['email']);
        $res = $this->db->update($this->tb_name, ['code'=>$params['code']]);
        if($res){
            return ['status'=>true, 'message'=>'Código cargado con éxito.'];
            // return ['status'=>true, 'message'=>'Code changed successfully.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cambiar código.'];
            // return ['status'=>false, 'message'=>'Failed to change the code.'];
        }

    }
       
    public function upd_cust_status_by_email($params){
        $this->db->where('email', $params['email']);
        $res = $this->db->update($this->tb_name, ['status'=>$params['status']]);
        if($res){
            return ['status'=>true, 'message'=>'Estado cambiado con éxito. Usuario activo.'];
            // return ['status'=>true, 'message'=>'Status changed successfully. User is active.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cambiar estado.'];
            // return ['status'=>false, 'message'=>'Failed to change the status.'];
        }

    }
    
    public function chk_cust_code_by_email($params){
        $res = $this->db->get_where($this->tb_name, ['email'=>$params['email'], 'code'=>$params['code']]);
        if($res->result()){
            return ['status'=>true, 'message'=>'Código existe.'];
            // return ['status'=>true, 'message'=>'Code exists.'];
        }
        else{
            return ['status'=>false, 'message'=>'Código no existe.'];
            // return ['status'=>false, 'message'=>'Code doesn\'t exists. '];
        }

    }

    public function check_admin_login($params){
        $res = $this->db->get_where($this->tb_name, ['user_type' => $params['user_type'], 'email'=>$params['email'], 'password'=>sha1($params['password'])]);
        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Admin cargado con éxito', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Admin loaded successfully', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar detalles del Admin.'];
            // return ['status'=>false, 'message'=>'Failed to load admin details.'];
        }

    }

    public function check_farmer_login($params){
        $res = $this->db->get_where($this->tb_name, ['user_type' => $params['user_type'], 'email'=>$params['email'], 'password'=>sha1($params['password']), 'status'=>'1']);
        if(!empty($res->result())){
            return ['status'=>true, 'message'=>'Agricultor cargado con éxito.', 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'Farmer loaded successfully.', 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Disculpe, username o password errado.'];
            // return ['status'=>false, 'message'=>'sorry, wrong username or password.'];
        }

    }

    public function add_user($params){
        $chk_user = $this->db->get_where($this->tb_name, ['email'=>$params['email']]);
        if(empty($chk_user->result_array())){
            $res = $this->db->insert($this->tb_name, $params);
            if($res){
                return ['status'=>true, 'message'=>'Usuario creado con éxito.'];
                // return ['status'=>true, 'message'=>'User created successfully.'];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para agregar.'];
                // return ['status'=>false, 'message'=>'Failed to add.'];
            }
        }
        else{
            return ['status'=>true, 'message'=>'Usuario ya existente.'];
            // return ['status'=>true, 'message'=>'User already existed.'];
        }

    }
    
    public function add_farmer($params){
        $chk_user = $this->db->get_where($this->tb_name, ['email'=>$params['email']]);
        if(empty($chk_user->result_array())){
            $res = $this->db->insert($this->tb_name, $params);
            if($res){
                return ['status'=>true, 'message'=>'Usuario creado con éxito.'];
                // return ['status'=>true, 'message'=>'User created successfully.'];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para agregar.'];
                // return ['status'=>false, 'message'=>'Failed to add.'];
            }
        }
        else{
            return ['status'=>false, 'message'=>'Usuario ya existente.'];
            // return ['status'=>false, 'message'=>'User already existed.'];
        }

    }
    
    public function change_password($params){
        $data = [
                'password'=>sha1($params['new_pass'])
            ];

        $chk_user = $this->db->get_where($this->tb_name, ['email'=>$params['email'], 'password'=>sha1($params['old_pass'])]);

        if(!empty($chk_user->result_array())){
            $this->db->where('email', $params['email']);
            $res = $this->db->update($this->tb_name, $data);

            if($res){
                return ['status'=>true, 'message'=>'Password cambiado con éxito.'];
                // return ['status'=>true, 'message'=>'Password changed successfully.'];
            }
            else {
                return ['status'=>false, 'message'=>'Falla para cambiar password.'];
                // return ['status'=>false, 'message'=>'Failed to change the password.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Usuario no existente.'];
            // return ['status'=>false, 'message'=>'user doesn\'t exists.'];
        }
        
    }
    
    
    public function change_password_admin($params){
        $data = [
                'password'=>sha1($params['new_pass'])
            ];

        $chk_user = $this->db->get_where($this->tb_name, ['email'=>$params['email'], 'password'=>sha1($params['old_pass'])]);

        if(!empty($chk_user->result_array())){
            $this->db->where('email', $params['email']);
            $res = $this->db->update($this->tb_name, $data);

            if($res){
                return ['status'=>true, 'message'=>'Password cambiado con éxito.'];
                // return ['status'=>true, 'message'=>'Password changed successfully.'];
            }
            else {
                return ['status'=>false, 'message'=>'Falla para cambiar password.'];
                // return ['status'=>false, 'message'=>'Failed to change the password.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Usuario no existente.'];
            // return ['status'=>false, 'message'=>'user doesn\'t exists.'];
        }
        
    }


    public function forgot_change_pass($params){
        $data = [
                'password'=>sha1($params['new_pass']),
                'code'=>'0'
        ];

        $this->db->where('email', $params['email']);
        $res = $this->db->update($this->tb_name, $data);

        if($res){
            return ['status'=>true, 'message'=>'Password ha sido cambiado. Ahora puede autenticar con nuevo password.'];
            // return ['status'=>true, 'message'=>'Your password has been changed. Now you can login with your new password.'];
        }
        else {
            return ['status'=>false, 'message'=>'Falla para cambiar password olvidado.'];
            // return ['status'=>false, 'message'=>'Failed to change the forgot password.'];
        }
            
        
    }
    
    public function upd_user_by_id($params){
        $data = $params['data'];

        $chk_user = $this->db->get_where($this->tb_name, ['uid'=>$params['id']]);

        if(!empty($chk_user->result_array())){
            $this->db->where('uid', $params['id']);
            $res = $this->db->update($this->tb_name, $data);

            if($res){
                return ['status'=>true, 'message'=>'Cliente actualizado con éxito.'];
                // return ['status'=>true, 'message'=>'Customer updated successfully.'];
            }
            else {
                return ['status'=>false, 'message'=>'Falla para actualizar detalles Cliente.'];
                // return ['status'=>false, 'message'=>'Failed to update customer details.'];
            }
            
        }
        else{
            return ['status'=>false, 'message'=>'Usuario no existente.'];
            // return ['status'=>false, 'message'=>'user doesn\'t exists.'];
        }
        
    }

    public function del_user_by_id($params){
        $res = $this->db->delete($this->tb_name, array('uid' => $params['id']));

        if($res){
            return ['status'=>true, 'message'=>'Cliente borrado con éxito.'];
            // return ['status'=>true, 'message'=>'Customer deleted successfully.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para borrar Cliente.'];
            // return ['status'=>false, 'message'=>'Failed to delete a customer.'];
        }
        
    }
    
    public function del_user_by_username($params){
        // $sql = 'DELETE FROM '.$this->tb_name.' WHERE username = "'.$params.'"';
        // $res = $this->db->query($sql);
        $res = $this->db->delete($this->tb_name, array('username' => $params));

        if($res){
            return ['status'=>true, 'message'=>'Cliente borrado con éxito.'];
            // return ['status'=>true, 'message'=>'Customer deleted successfully.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para borrar Cliente.'];
            // return ['status'=>false, 'message'=>'failed to delete the customer.'];
        }
        
    }

    public function upd_img_by_email($params){
        if($this->db->get_where($this->tb_name, ['email'=>$params['email']])){
            $this->db->where('email', $params['email']);
            $res = $this->db->update($this->tb_name, ['profile_img'=>$params['file_name']]);
            
            if($res){
                return ['status'=>true, 'message'=>'Archivo cargado y actualizado con éxito.'];
                // return ['status'=>true, 'message'=>'File uploaded and updated successfully.'];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para actualizar nombre del archivo.'];
                // return ['status'=>false, 'message'=>'Failed to update the file name.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Usuario no existe.'];
            // return ['status'=>false, 'message'=>'User doesn\'t exists.'];
        }
    }
    
    public function upd_farmer_address($params){
        $data = ['address'=>$params['address']];
        $this->db->where('uid', $params['uid']);
        $res = $this->db->update($this->tb_name, $data);

        if($res){
            return ['status'=>true, 'message'=>'Dirección Agricultores actualizada con éxito.'];
            // return ['status'=>true, 'message'=>'Farmers address updated successfully.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para actualizar dirección Agricultor.'];
            // return ['status'=>false, 'message'=>'Failed to update farmers address.'];
        }

    }
    
    public function getfarmerbyid($uid){
        
        $res = $this->db->get_where($this->tb_name, ['uid'=>$uid])->result();



        if(count($res)){
            return ['status'=>true, 'message'=>'Detalles Agricultor cargado con éxito.', 'total_rec'=>count($res), 'data'=>$res];
            // return ['status'=>true, 'message'=>'Farmers details loaded successfully.', 'total_rec'=>count($res), 'data'=>$res];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para cargar detalles Agricultores.', 'total_rec'=>count($res)];
            // return ['status'=>false, 'message'=>'Failed to load.'];
        }

    }
    
}


