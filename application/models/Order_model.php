<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    private $tb_cart;
    private $tb_order;
    private $tb_notification;
    private $tb_products;
    private $tb_user;
    
    // In english
    // private $ord_status = [0=>'Ordered', 1=>'Deliver in transit', 2=>'Partial delivery', 3=>'Delivered', 4=>'Cancelled'];
    
    // In Spanish
    private $ord_status = [0=>'Pedido Realizado', 1=>'Pedido en Processo', 2=>'Entrega parcial', 3=>'Entrega', 4=>'Cancelada'];

    public function __construct(){ 
        $this->tb_cart = 'tbl_cart';
        $this->tb_order = 'tbl_order';
        $this->tb_notification = 'tbl_notification';
        $this->tb_products = 'tbl_products';
        $this->tb_user = 'tbl_users';
    }
    
    public function showcart_byid($uid){
        $total_price = 0;
        $total_qty = 0;
        
        $res = $this->db->get_where($this->tb_cart, ['created_by'=>$uid]);
        if(count($res->result())){
            
            $cart_ids = [];

            foreach($res->result() as $key => $val){
                // $c = $res->result();

                @$pid[$key] = $val->pid;
                $total_price += $val->price;
                $total_qty += $val->qty;
                $prod_det[$key] = $this->db->get_where('tbl_products', ['pid'=>$val->pid])->result();

                array_push($cart_ids, $val->cart_id);

                $final_data[$key] = [
                        "cart_id"   =>$val->cart_id,
                        "pid"       =>$prod_det[$key][0]->pid,
                        "pname"     =>$prod_det[$key][0]->name,
                        "description"=>$prod_det[$key][0]->description,
                        "image"     =>$prod_det[$key][0]->image,
                        "unit"      =>$prod_det[$key][0]->unit,
                        "qty"       =>$val->qty,
                        "price"     =>$val->price,
                        "status"    =>$val->status,
                        "created_by"=>$val->created_by,
                        "updated_by"=>$val->updated_by
                    ];

            }
            
            return [
                'status'=>true, 
                'message'=>'Todos los detalles carro de compra.', 
                // 'message'=>'All cart details.', 
                'total_price'=>$total_price,
                'total_qty'=>$total_qty,
                'cart_ids'=>$cart_ids,
                'total_rec'=>count($res->result()),
                'data'=>$final_data,
                // 'data'=>$res->result_array(), 
                // 'product details'=>$prod_det
                ];

        }
        else{
            return ['status'=>false, 'message'=>'Carro de compra vacío.'];
            // return ['status'=>false, 'message'=>'Your cart is empty.'];
        }
    }
    
    public function showcart(){
        $res = $this->db->get($this->tb_cart);
        if(count($res->result())){
            return ['status'=>true, 'message'=>'Todos los detalles carro de compra.', 'total_rec'=>count($res->result()), 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'All cart details.', 'total_rec'=>count($res->result()), 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla al cargar detalles carro de compras.'];
            // return ['status'=>false, 'message'=>'Failed to load cart detials.'];
        }
    }
    
    public function getorder_userpurchase($uid){
        $res = $this->db->get_where($this->tb_order, ['created_by'=>$uid]);
        if(count($res->result())){
            return ['status'=>true, 'message'=>'Detalles Orden del usuario cargada con éxito.', 'total_rec'=>count($res->result()), 'data'=>$res->result_array()];
            // return ['status'=>true, 'message'=>'User order details loaded successfully.', 'total_rec'=>count($res->result()), 'data'=>$res->result_array()];
        }
        else{
            return ['status'=>false, 'message'=>'Falla al cargar detalles del usuario.'];
            // return ['status'=>false, 'message'=>'Failed to load user details.'];
        }
    }

    public function addcart($params){
        
        // Checks the product has sufficient quantity
        $res = $this->db->get_where($this->tb_products, ['pid'=>$params['pid'], 'total_qty>='=>$params['qty']]);
        if(count($res->result())){
            
            // Checks whether that perticular user has added to cart or not
            $chk_cart = $this->db->get_where($this->tb_cart, ['pid'=>$params['pid'], 'created_by'=>$params['created_by']])->result();
            
          

            if(count($chk_cart)){
                // Here we are gathering all the Products detail from tbl_products
                $p = $res->result();

                @$pid    = $p[0]->pid;
                @$sp     = $p[0]->sell_price;
                @$unit   = $p[0]->unit;
                @$image  = $p[0]->image;
                @$name   = $p[0]->name;    
    
                $cart_chk = $this->db->get_where($this->tb_cart, ['pid'=>$pid])->result();
                
        
                if(count($cart_chk) != 0){
                    $ck = $cart_chk;
                    $data['pid'] = $params['pid'];
                    $data['qty'] = $ck[0]->qty + $params['qty'];
                    $data['price'] = $ck[0]->price + ($sp * $params['qty']);
                    $data['created_by'] = $params['created_by'];
                    
                    $this->db->where('pid', $data['pid']);
                    $res1 = $this->db->update($this->tb_cart, $data);
                    if($res1){
                        return ['status'=>true, 'message'=>'Carro Compras actualizado con éxito.'];
                        // return ['status'=>true, 'message'=>'Cart updated successfully.'];
                    }
                    else{
                        return ['status'=>false, 'message'=>'Falla al actualizar carro de compras.'];
                        // return ['status'=>false, 'message'=>'Failed to update a cart.'];
                    }
                }
                else{
                    return ['status'=>false, 'message'=>'Producto no disponible en Carro Compras.'];
                    // return ['status'=>false, 'message'=>'Product is not available in the cart.'];

                }

            }
            else{
                $p = $res->result();

                @$pid    = $p[0]->pid;
                @$sp     = $p[0]->sell_price;
                @$unit   = $p[0]->unit;
                @$image  = $p[0]->image;
                @$name   = $p[0]->name;    
    
                $cart_chk = $this->db->get_where($this->tb_cart, ['pid'=>$pid])->result();
                
                if(count($cart_chk) != 0){
                    
                    $ck = $cart_chk;
    
                    $data['pid'] = $params['pid'];
                    $data['qty'] = $ck[0]->qty + $params['qty'];
                    $data['price'] = $ck[0]->price + ($sp * $params['qty']);
                    $data['created_by'] = $params['created_by'];
                    
                    // $this->db->where('pid', $data['pid']);
                    $res1 = $this->db->insert($this->tb_cart, $data);
                    if($res1){
                        return ['status'=>true, 'message'=>'Carro Compras agregado con éxito.'];
                        // return ['status'=>true, 'message'=>'Cart added successfully.'];
                    }
                    else{
                        return ['status'=>false, 'message'=>'Falla para agregar en carro de compras.'];
                        // return ['status'=>false, 'message'=>'Failed to add into cart.'];
                    }

                }
                else{
                    
                    $ck = $cart_chk;
    
                    $data['pid'] = $params['pid'];
                    $data['qty'] = $params['qty'];
                    $data['price'] = ($sp * $params['qty']);
                    $data['created_by'] = $params['created_by'];
                    
                    // $this->db->where('pid', $data['pid']);
                    $res1 = $this->db->insert($this->tb_cart, $data);
                    if($res1){
                        // return ['status'=>true, 'message'=>'Cart added successfully in empty table.'];
                        // return ['status'=>true, 'message'=>'POR FAVOR SELECCIONE LA CANTIDAD.'];
                        return ['status'=>true, 'message'=>'Producto agregado con éxito.'];
                    }
                    else{
                        return ['status'=>false, 'message'=>'Falla para agregar en carro de compras una tabla vacía.'];
                        // return ['status'=>false, 'message'=>'Failed to add in cart in empty table.'];
                    }

                }

            }

        }
        else{
            return ['status'=>false, 'message'=>'Producto con disponibilidad insuficiente en almacén.'];
            // return ['status'=>false, 'message'=>'Product has insufficient stock.'];
        }

    }

    public function addmultiplecart($params){

        $res = $this->db->insert_batch($this->tb_cart, $params);
        if($res){
            return ['status'=>true, 'message'=>'Carro de compras múltiple agregado con éxito.'];
            // return ['status'=>true, 'message'=>'Multiple cart added successfully.'];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para agregar en carro de compras.'];
            // return ['status'=>false, 'message'=>'Failed to add into cart.'];
        }

    }
    
    public function updatecartbyid($params){
        // Get the current quantity of that cart_qty, cart_price, cart_pid
        $cart_qty = $this->db->get_where($this->tb_cart, ['cart_id'=>$params['cart_id']])->row()->qty;

        if($cart_qty > 0){
            
            $cart_price = $this->db->get_where($this->tb_cart, ['cart_id'=>$params['cart_id']])->row()->price;
            $pid = $this->db->get_where($this->tb_cart, ['cart_id'=>$params['cart_id']])->row()->pid;

            // Get the price from tbl_products
            $p_price = $this->db->get_where($this->tb_products, ['pid'=>$pid])->row()->sell_price * $params['qty'];
    
            $chq_qty = $this->db->get_where($this->tb_cart, ['cart_id'=>$params['cart_id']])->row()->qty;
            
            if($chq_qty > 0){
               
                $this->db->where('cart_id', $params['cart_id']);
            
                if($params['mode'] === '+'){
                    
                    $data = array(
                            'qty' => ($cart_qty + $params['qty']),
                            'price' => ($p_price + $cart_price)
                    );
                    $this->db->where('cart_id', $params['cart_id']);
                    $res = $this->db->update($this->tb_cart, $data);
                    
                    if($res){
                        $msg = "Cantidad aumentada.";
                        // $msg = "Quantity increased.";
                    }
    
                }
                else{
    
                    $ch = $this->db->get_where($this->tb_cart, ['cart_id'=>$params['cart_id']])->row()->qty;
                    
                    if($ch == 1){
                        $res = $this->db->delete($this->tb_cart, array('cart_id' => $params['cart_id']));
            
                        if($res){
                            $msg = 'Carro compras borrado.';
                            // $msg = 'Cart deleted.';
                        }
                        else{
                            $msg = 'Carro compras no borrado.';
                            // $msg = 'Cart not deleted.';
                        }

                    }
                    else{
                        $data = array(
                            'qty' => abs($cart_qty - $params['qty']),
                            'price' => abs($p_price - $cart_price)
                        );
                        $this->db->where('cart_id', $params['cart_id']);
                        $res = $this->db->update($this->tb_cart, $data);
        
                        if($res){
                            $msg = "Cantidad reducida.".$ch;
                            // $msg = "Quantity reduced .".$ch;
                        }

                    }
                    
                    
                    
                }

            }
            else{
                $msg = "Carro compras borrado.";
                // $msg = "Cart deleted...";
            }
 
 
            if($res){
                return ['status'=>true, 'message'=>$msg];
            }
            else{
                return ['status'=>false, 'message'=>$msg];
            }

        }
        
        else{

            $res = $this->db->delete($this->tb_cart, array('cart_id' => $params['cart_id']));
            
            if($res){
                return ['status'=>true, 'message'=>'Carro compras borrado..'];
                // return ['status'=>true, 'message'=>'Cart deleted.'];
            }
            else{
                return ['status'=>false, 'message'=>'Carro compras no borrado.'];
                // return ['status'=>false, 'message'=>'Cart not deleted.'];
            }
            
        }

    }
    
    public function deletecartbyid($params){

        $r = $this->db->get_where($this->tb_cart, ['cart_id' => $params['cart_id']])->result();
        if(count($r)){
            $res = $this->db->delete($this->tb_cart, array('cart_id' => $params['cart_id']));
            if($res){
                return ['status'=>true, 'message'=>'Carro compras borrado con éxito.'];
                // return ['status'=>true, 'message'=>'Cart deleted successfully.'];
            }
            else{
                return ['status'=>false, 'message'=>'Falla para borrar este carro de compras.'];
                // return ['status'=>false, 'message'=>'Failed to delete that cart.'];
            }
        }
        else{
            return ['status'=>false, 'message'=>'Detalles carro compras no existen.'];
            // return ['status'=>false, 'message'=>'Cart details doesn\'t exists.'];
        }        

    }
    
   public function addorder($params){
        // This condition of code will add the record to tbl_order
        // Here we need to aquire all the product id from their respective cart ids
        // Cart id will be used to get all the products info.
        if(!empty($params['cart_id'])){
            
            $ord_num = '';
           $car_id = json_decode($params['cart_id'], true);
           $delivery_address = $params['delivery_address'];
           $delivery_time = $params['delivery_time'];
      
      
      
            foreach($car_id as $key => $val){
             
               // $val1 = str_replace('"', ' ', $val);
                $r[$key] = $this->db->get_where($this->tb_cart, ['cart_id'=> $val])->result();
    
                // All the fields for order table.
                $data_ord[$key]['p_id'] = $r[$key][0]->pid;
                $data_ord[$key]['qty'] = $r[$key][0]->qty;
                $data_ord[$key]['total'] = $r[$key][0]->price;
                $data_ord[$key]['status'] = $params['status'];
                $data_ord[$key]['remarks'] = $params['remarks'];
                $data_ord[$key]['created_by'] = $params['created_by'];
                $data_ord[$key]['updated_by'] = $this->db->get_where($this->tb_products, [ 'pid'=>$r[$key][0]->pid ])->row()->created_by;
    
                // Combination for order no.
                $ord_num .= $r[$key][0]->pid.$data_ord[$key]['updated_by'];
            }
   
            // Order no that will be same for this order.
            $order_no = strtoupper('ORD'.substr(sha1($ord_num), 6, 6).rand(0, 10000));

            // Now insert into tbl_order
            foreach ($data_ord as $key => $value) {
                $ins_data[$key]['ord_no']       = $order_no;
                $ins_data[$key]['pids']         = $value['p_id'];
                $ins_data[$key]['fids']         = $value['updated_by'];
                $ins_data[$key]['qty']          = $value['qty'];
                $ins_data[$key]['tot_price']    = $value['total'];
                $ins_data[$key]['payment_id']   = $params['payment_id'];
                $ins_data[$key]['status']       = $value['status'];
                $ins_data[$key]['remarks']      = $value['remarks'];
                $ins_data[$key]['created_by']   = $value['created_by'];
                $ins_data[$key]['updated_by']   = $value['updated_by'];
                $ins_data[$key]['updated_at']   = date('Y-m-d H;i:s');
                $ins_data[$key]['delivery_address'] = $delivery_address;
                $ins_data[$key]['delivery_time'] = $delivery_time;
                
            }
            
    
    
            $res_ins_ord = $this->db->insert_batch($this->tb_order, $ins_data);
            
            if($res_ins_ord != 0){
                $p_upd_sts = false;
                // First the products quantity will be updated 
                foreach($data_ord as $key => $val){
                    $total_qty_prod = $this->db->get_where($this->tb_products, ['pid'=>$val['p_id']])->row()->total_qty;
                    $current_stock = ($total_qty_prod - $val['qty']);
                    $this->db->where('pid', $val['p_id']);
                    $res2[$key] = $this->db->update($this->tb_products, ['total_qty'=>$current_stock]);
                    if($res2[$key]){
                        $p_upd_sts = true;
                    }
                    else{
                        $p_upd_sts = false;
                    }
                    
                }
                
                
                if($p_upd_sts){
                    // All the details from tbl_cart need to be deleted.
                    $this->db->where_in('cart_id', json_decode($params['cart_id']));
                    $del_res_cart = $this->db->delete($this->tb_cart);
        
                    if($del_res_cart){
                        return ['status'=>true, 'message'=>'Order added successfully.and cart deleted.', 'order_no'=>$order_no];
                    }
                    else{
                        return ['status'=>false, 'message'=>'Order added successfully. but cart not deleted', 'order_no'=>$order_no];
                    }
                    
                }
                else{
                    return ['status'=>false, 'message'=>'product qty not updated.'];
                }
                

            }
            else{
                return ['status'=>true, 'message'=>'failed to add order.'];
            }
          
        }
        else{
            return ['status'=>false, 'message'=>'Sorry, there is insufficient cart ids.'];
        }

    }

    public function order_got_for_customer($param){
        $res = $this->db->get_where($this->tb_order, ['created_by'=>$param['uid']])->result();
        
        if(count($res)){
            
            if(count($res) > 1){

                foreach($res as $key => $value){
                    $data[$key]['oid'] = $value->oid;
                    $data[$key]['status'] = $this->ord_status[$value->status];;
                    $data[$key]['order_dt'] = date('d-M-Y', strtotime($value->updated_at));
                }

            }
            else{
                $data[0]['oid'] = $res[0]->oid;
                $data[0]['status'] = $this->ord_status[$res[0]->status];
                $data[0]['order_dt'] = date('d-M-Y', strtotime($res[0]->updated_at));
            }
            

            return ['status'=>true, 'message'=>'Ordenes por Cliente.', 'total_rec'=>count($res), 'data'=>$data];
            // return ['status'=>true, 'message'=>'Orders by customer.', 'total_rec'=>count($res), 'data'=>$data];
        }
        else{
            return ['status'=>false, 'message'=>'Falla para tomar Ordenes.'];
            // return ['status'=>false, 'message'=>'Failed to get orders.'];
        }
        
    }


    // Need to rectify 
    public function order_got_by_farmer($param){

        @$this->db->select(`SELECT * FROM tbl_order WHERE fids LIKE '%"fid":"`.$params['uid'].`"%'`);
        $res = $this->db->get($this->tb_order)->result();
        if(count($res)){
            
            // If an array
            if(count($res)){
                foreach($res as $key => $val){
                    $data[$key]['oid'] = $val->oid;
                    $data[$key]['status'] = $this->ord_status[$val->status];
                    $data[$key]['ordered_dt'] = date('d-M-Y', strtotime($val->updated_at));
                }
            }
            // Not an array
            else{
                $data[0]['oid'] = $res[0]->oid;
                $data[0]['status'] = $this->ord_status[$res[0]->status];
                $data[0]['ordered_dt'] = date('d-M-Y', strtotime($res[0]->updated_at));
            }
            
            // Will get the returned value in that array. 
            return ['status'=>true, 'message'=>'Ordenes por Agricultores.', 'total_rec'=>count($res), 'data'=>$data];
            // return ['status'=>true, 'message'=>'Order for farmers.', 'total_rec'=>count($res), 'data'=>$data];
        }
        else{
            return ['status'=>true, 'message'=>'Lo siento, aún no hay pedidos.', 'data'=>$res];
            // return ['status'=>true, 'message'=>'Sorry their are no orders yet.', 'data'=>$res];
        }
        
    }
    
    
    public function change_ord_status($params){

        $res = $this->db->get_where('tbl_order', ['oid'=>$params['oid']])->result();

        if(count($res)){
            $fids = json_decode($res[0]->fids, true);
            
            foreach($fids as $key => $val){
                if($val['fid'] == $params['uid']){
                    $f = true;
                }
                else{
                    $f = false;
                }
            }
            
            // This will check the farmers id
            if($f){
                
                // Now status will be updated.
                $this->db->where('oid', $params['oid']);
                $res = $this->db->update('tbl_order', ['status'=>$params['status']]);
                
                if($res){
                    return ['status'=>true, 'message'=>'Orden actualizada con éxito.'];
                    // return ['status'=>true, 'message'=>'Order updated successfully.'];
                }
                else{
                    return ['status'=>false, 'message'=>'Falla para actualizar.'];
                    // return ['status'=>false, 'message'=>'Failed to update.'];
                }
                
            }
            else{
                return ['status'=>false, 'message'=>'Esta orden no tiene productos.'];
                // return ['status'=>false, 'message'=>'This order doesnot have your products.'];
            }
            
        }
        else{
            return ['status'=>false, 'message'=>'Orden no disponible.'];
            // return ['status'=>false, 'message'=>'Order not available.'];
        }

    }
    
    public function customer_order_dets($params){
        if(isset($params)){
            // Checks the order with oid and uid.
            $res = $this->db->get_where($this->tb_order, ['oid'=>$params['oid'], 'created_by'=>$params['uid']])->result();
            if($res){
                
                // To get the product details
                $pids = json_decode($res[0]->pids, true);
                
                foreach($pids as $keys => $val){
    $data[$keys]['products']['pid'] = $this->db->get_where($this->tb_products, ['pid'=>$val['pid']])->row()->pid;
    $data[$keys]['products']['pname'] = $this->db->get_where($this->tb_products, ['pid'=>$val['pid']])->row()->name;
    $data[$keys]['products']['pdesc'] = $this->db->get_where($this->tb_products, ['pid'=>$val['pid']])->row()->description;
    $data[$keys]['products']['pimg'] = $this->db->get_where($this->tb_products, ['pid'=>$val['pid']])->row()->image;
    $data[$keys]['products']['ordered_qty'] = $val['qty'];
    $data[$keys]['products']['unit'] = $this->db->get_where($this->tb_products, ['pid'=>$val['pid']])->row()->unit;
    $data[$keys]['products']['sell_price'] = $this->db->get_where($this->tb_products, ['pid'=>$val['pid']])->row()->sell_price;
    $data[$keys]['products']['total_price'] = "".$val['qty'] * $data[$keys]['products']['sell_price'];
                }
                
                
                // To get the Farmers details
                $fids  = json_decode($res[0]->fids, true);
                if($fids){
                    foreach($fids as $fkeys => $fval){
    $data[$fkeys]['farmers']['fid']     = $fval['fid'];
    $data[$fkeys]['farmers']['fname']   = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row()->name;
    $data[$fkeys]['farmers']['femail'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row()->email;
    $data[$fkeys]['farmers']['fphone'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row()->phone;
    $data[$fkeys]['farmers']['faddress'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row()->address;
    $data[$fkeys]['farmers']['ftown'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row()->town;
    $data[$fkeys]['farmers']['fcountry'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row()->country;
                    }
                }
                else{
                    $data['farmers'] = 'Farmers doesnot exists.';
                }

                return [
                    'status'=>true, 
                    'message'=>'Los detalles del pedido se obtuvieron correctamente.', 
                    // 'message'=>'Order details fetched successfully.', 
                    'order_id'=>$params['oid'],
                    'total'=>count($pids),
                    'date'=>date('d.m.y', strtotime($res[0]->created_at)), 
                    'order_status'=>$this->ord_status[$res[0]->status],
                    'data'=>$data];
            }
            else{
                return ['status'=>false, 'message'=>'No se pudieron recuperar los datos con oid y uid..'];
                // return ['status'=>false, 'message'=>'Failed to fetch data with oid and uid.'];
            }

        }
        return ['status'=>false, 'message'=>'Establezca las variables correctamente.'];
        // return ['status'=>false, 'message'=>'Please set the variables properly.'];
    }
    
    
    public function all_order_detail(){
$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
            $this->db->group_by('ord_no');
            $this->db->order_by('oid', 'desc');
             $res = $this->db->get($this->tb_order)->result();


             if($res){
                 foreach($res  as $rs){                 
                    $OrderId = $rs->oid;
                   

                    $CustomerId = $rs->created_by;
                    $productDetail =  $rs->pids;
                   // echo "product detail";

                $customerName = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('name');
                $customerEmail = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('email');
                    
                      $data['order'.$rs->oid]['orderId']  = $OrderId;
                      $data['order'.$rs->oid]['poId']  = $rs->ord_no;
                      $data['order'.$rs->oid]['customerName'] = $customerName ;
                      $data['order'.$rs->oid]['orderDate'] = date('d.m.y', strtotime($rs->created_at)) ;
                      $data['order'.$rs->oid]['customerEmail'] = $customerEmail ;
                      $data['order'.$rs->oid]['status'] = $rs->status ;
                      $data['order'.$rs->oid]['price'] = $rs->tot_price ;
                      $data['order'.$rs->oid]['remark'] = $rs->remarks ;    
             
                    }  

            
                            return [
                                'status'=>true,                    
                                'data'=>$data];
                        }
                        else{
                            //return ['status'=>false, 'message'=>'No se pudieron recuperar los datos con oid y uid..'];
                            return ['status'=>false, 'message'=>'Failed to fetch data with oid and uid.','data'=>array()];
                        }

    }




    public function farmer_order_dets($params){
        if(isset($params)){
            
            $res = $this->db->get_where($this->tb_order, ['oid'=>$params['oid']])->result();
            if($res){
                
                // To search the farmers if in fids.
                $fids = json_decode($res[0]->fids, true);
                
        // ------------- Just to check the fid exists or not ---------------
                $t = false;
                foreach($fids as $fkey => $fval){
                    if($fval['fid'] == $params['uid']){
                        $t = true;
                        break;
                    }
                }
                if($t){
                    // $y = 'Matched';
                    // To retrieve all details of that perticular farmer.
$data['farmers']['name']   = $this->db->get_where($this->tb_user, ['uid'=>$params['uid']])->row()->name;
$data['farmers']['email'] = $this->db->get_where($this->tb_user, ['uid'=>$params['uid']])->row()->email;
$data['farmers']['phone'] = $this->db->get_where($this->tb_user, ['uid'=>$params['uid']])->row()->phone;
$data['farmers']['address'] = $this->db->get_where($this->tb_user, ['uid'=>$params['uid']])->row()->address;
$data['farmers']['town'] = $this->db->get_where($this->tb_user, ['uid'=>$params['uid']])->row()->town;
$data['farmers']['country'] = $this->db->get_where($this->tb_user, ['uid'=>$params['uid']])->row()->country;
                }
                
                
        // --------------- Check products part -----------------
                $pids = json_decode($res[0]->pids, true);
                foreach($pids as $pkey => $pval){
                    
                    $pi_chk = $this->db->get_where($this->tb_products, ['pid'=>$pval['pid']])->row()->created_by;
                    
                    if($params['uid'] == $pi_chk){
    $data['product'][$pkey]['pid'] = $pi_chk;
    $data['product'][$pkey]['name'] = $this->db->get_where($this->tb_products, ['pid'=>$pval['pid']])->row()->name;
    $data['product'][$pkey]['qty'] = $pval['qty'];
                    }

                }

                return [
                    'status'=>true, 
                    'message'=>'Los detalles del pedido se cargaron correctamente..', 
                    // 'message'=>'Order details loaded successfully.', 
                    'data'=>$data, 
                    // 'farmers'=>$data, 
                    // 'products'=>$pids, 
                    // 'f'=>$farmars
                ];

            }
            else{
                return ['status'=>false, 'message'=>'Lo sentimos, orden no disponible.'];
                // return ['status'=>false, 'message'=>'Sorry order not available.'];
            }

        }
        else{
            return ['status'=>false, 'message'=>'Establezca las variables correctamente.'];
            // return ['status'=>false, 'message'=>'Please set the variables properly.'];
        }

    }


 public function get_order_detail($parms){
   $result = $this->db->get_where($this->tb_order, ['ord_no'=>$parms])->result();

$CustomerId = $result[0]->created_by;
   
    $customerName = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('name');
    $customerEmail = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('email');
    $customerPhone = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('phone');
   
            if($result){
                // To get the product details
              //  $pids = json_decode($res[0]->pids, true);
                $k = $j = 0;
     foreach($result as $res ){ 
                 $data[$k]['products']['status'] = $res->status;
                 $data[$k]['products']['oid'] = $res->oid;
            $data[$k]['products']['pid'] = $res->pids;
            $data[$k]['products']['pname'] = $this->db->get_where($this->tb_products, ['pid'=>$res->pids])->row()->name;
            $data[$k]['products']['pdesc'] = $this->db->get_where($this->tb_products, ['pid'=>$res->pids])->row()->description;
            $data[$k]['products']['pimg'] = $this->db->get_where($this->tb_products, ['pid'=>$res->pids])->row()->image;
            $data[$k]['products']['ordered_qty'] = $res->qty;
            $data[$k]['products']['unit'] = $this->db->get_where($this->tb_products, ['pid'=>$res->pids])->row()->unit;
            $data[$k]['products']['sell_price'] = $this->db->get_where($this->tb_products, ['pid'=>$res->pids])->row()->sell_price;
            $data[$k]['products']['total_price'] = $res->tot_price;     
                        
                        // To get the Farmers details
                      //  $fids  = json_decode($res[0]->fids, true);               
                           
            $data[$j]['farmers']['fid']     = $res->fids;
            $data[$j]['farmers']['fname']   = $this->db->get_where($this->tb_user, ['uid'=>$res->fids])->row('name');
            $data[$j]['farmers']['femail'] = $this->db->get_where($this->tb_user, ['uid'=>$res->fids])->row('email');
            $data[$j]['farmers']['fphone'] = $this->db->get_where($this->tb_user, ['uid'=>$res->fids])->row('phone');
            $data[$j]['farmers']['faddress'] = $this->db->get_where($this->tb_user, ['uid'=>$res->fids])->row('address');
            $data[$j]['farmers']['ftown'] = $this->db->get_where($this->tb_user, ['uid'=>$res->fids])->row('town');
            $data[$j]['farmers']['fcountry'] = $this->db->get_where($this->tb_user, ['uid'=>$res->fids])->row('country');
                   
     
$j++;$k++;
     }
                // else{
                //     $data['farmers'] = 'Farmers doesnot exists.';
                // }
                         
        

                return [
                    'status'=>true,                     
                    'order_from'=> $customerName, 
                    'customerEmail' => $customerEmail,
                    'customerPhone' => $customerPhone,
                    'order_no'=>$parms,
                    // 'total'=>count($pids),
                    // 'date'=>date('d.m.y', strtotime($res[0]->created_at)), 
                    // 'order_status'=>$this->ord_status[$res[0]->status],
                    'data'=>$data];
            }
            else{
                return ['status'=>false, 'message'=>'No se pudieron recuperar los datos con oid y uid..'];
                // return ['status'=>false, 'message'=>'Failed to fetch data with oid and uid.'];
            }

       
     //   return ['status'=>false, 'message'=>'Establezca las variables correctamente.'];


 }


 public function upd_order_by_id($params){

     $this->db->where('ord_no', $params['ord_no']);
      $res = $this->db->update('tbl_order', ['status'=>$params['orderStatus'],'updated_at'=>$params['updateAt'],'remarks'=>$params['orderRemark']]);

      if($res){
  return ['status'=>true, 'message'=>'Your order is updated'];
      }
      else{
         return ['status'=>false, 'message'=>'Your order is not updated'];
      }

 }
    // TRUNCATE TABLE
    // $this->db->truncate($this->tb_name);
        
    // INSERT DATA
    // $res = $this->db->insert($this->tb_name, $params);

    // RETRIEVE DATA    
    //     $res = $this->db->get_where($this->tb_name, ['otp'=>$params['otp']]);
    
    // UPDATE DATA
    // $this->db->where('email', $params['email']);
    // $res = $this->db->update($this->tb_name, ['status'=>$params['status']]);
    
    // DELETE DATA
    //     $res = $this->db->delete($this->tb_name, array('email' => $params['email']));
}


