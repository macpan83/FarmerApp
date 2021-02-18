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
        
        // This condition will check the status with the created_by
        
        // $chk_ord = $this->db->get_where('tbl_order', ['created_by'=>$params['created_by', 'status'=>'1']])->result();
        // if(!count($chk_ord)){
        if(1){
            // This condition of code will add the record to tbl_order
            
            // Here we need to aquire all the product id from their respective cart ids 
            if(!empty($params['cart_id'])){

                foreach(json_decode($params['cart_id'], true) as $key => $val){
                    
                    $pid = $this->db->get_where($this->tb_cart, ['cart_id'=>$val])->row()->pid;
                    $__p[$key]['pid'] = $pid;
                    // $__p[$key]['pid'] = $this->db->get_where($this->tb_products, ['pid'=>$pid])->row()->created_by;
                    $__p[$key]['qty'] = $this->db->get_where($this->tb_cart, ['cart_id'=>$val])->row()->qty;

                    $uid = $this->db->get_where($this->tb_products, ['pid'=>$pid])->row()->created_by;
                    $__uid[$key]['fid'] = $uid;
                    // $farmer[$key]['name'] = $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->name != ""? $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->name: "";
                    // $farmer[$key]['phone'] = $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->phone != ""? $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->phone: "";
                    // $farmer[$key]['email'] = $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->email != ""? $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->email: "";
                    // $farmer[$key]['address'] = $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->address != ""? $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->address: "";
                    // $farmer[$key]['image'] = $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->profile_img != ""? $this->db->get_where($this->tb_user, ['uid'=>$uid])->row()->profile_img: "";
                }
                
                $params['pids'] = json_encode($__p);
                $params['fids'] = json_encode($__uid);
            }
            else{
                $params['pids'] = '';
                $params['fids'] = '';
            }
            
            
            $params['status'] = 0;
            $params['updated_at'] = date('Y-m-d H;i:s');
            
            
            $res = $this->db->insert($this->tb_order, $params);
            $last_oid = $this->db->insert_id();
    
            if($res){
            
                $carts = json_decode($params['cart_id'], true);
                foreach($carts as $key => $val){
                    $dd[$key] = $val;
                    
                    // Update the cart status to 1.
                    $this->db->where('cart_id', $val);
                    $res1[$key] = $this->db->update('tbl_cart', ['status'=>'1']);
                    
                    
                    // Get product id from tbl_cart
                    $g_pid[$key] = $this->db->get_where($this->tb_cart, ['cart_id'=>$val])->result();
                    $data[$key]['qty'] = $g_pid[$key][0]->qty;
                    $data[$key]['cust_id'] = $g_pid[$key][0]->created_by;
                    
                    $data[$key]['pid'] = $g_pid[$key][0]->pid;
                    
                    if(count($g_pid[$key])){
                        // Get User id from tbl_product
                        $g_uid[$key] = $this->db->get_where('tbl_products', ['pid'=>$g_pid[$key][0]->pid])->result();
                        $data[$key]['prod_name'] = $g_uid[$key][0]->name;
                        $data[$key]['prod_image'] = $g_uid[$key][0]->image;

                        if(count($g_uid[$key])){
                            // Get Email from tbl_user
                            $g_email[$key] = $this->db->get_where('tbl_users', ['uid'=>$g_uid[$key][0]->created_by])->result();
                            
                            if(count($g_email[$key])){
                                // Send Mail to that email.
                                $data[$key]['email'] = $g_email[$key][0]->email;
                            }
                            else{
                                $data[$key]['error'] = ['status'=>false, 'message'=>'Falla al buscar email.'];
                                // $data[$key]['error'] = ['status'=>false, 'message'=>'Failed to fetch email'];
                            }
                            
                        }
                        else{
                            $data[$key]['error'] = ['status'=>false, 'message'=>'Falla al buscar llave de usuario'];
                            // $data[$key]['error'] = ['status'=>false, 'message'=>'Failed to fetch user key'];
                        }
                        
                    }
                    else{
                        $data[$key]['error'] = ['status'=>false, 'message'=>'Falla para buscar Producto'];
                        // $data[$key]['error'] = ['status'=>false, 'message'=>'Failed to fetch Product'];
                    }

                    // Update the total quantity in tbl_product.
                    $total_qty_prod = $this->db->get_where('tbl_products', ['pid'=>$data[$key]['pid']])->row()->total_qty;
                    $current_stock = ($total_qty_prod - $data[$key]['qty']);
                    $this->db->where('pid', $data[$key]['pid']);
                    $res2[$key] = $this->db->update('tbl_products', ['total_qty'=>$current_stock]);
                    if($res2[$key]){
                        $this->db->delete($this->tb_cart, array('cart_id'=>$val));
                    }
                    else{
                        echo 'Cantidad Total no actualizada.';
                        // echo 'Total quantity not updated.';
                    }

                }


                // To save the data in notification table 
                $noti_data = [
                        'cust_id'=>$params['created_by'],
                        'farm_id'=>json_encode($__uid),
                        'order_id'=>$last_oid
                    ];
                $res_noti = $this->db->insert($this->tb_notification, $noti_data);
                
                if($res_noti){
                    // Get created_at from tbl_order
                    $ordrd_at = $this->db->get_where('tbl_order', ['oid'=>$last_oid])->result();
    
                    return [
                        'status'=>true, 
                        'message'=>'Pedido procesado con éxito.', 
                        // 'message'=>'Ordered successfully.', 
                        'order_id'=>$last_oid, 
                        'order_date'=>$ordrd_at[0]->created_at, 
                        'total_price'=>$ordrd_at[0]->tot_price,
                        'customer_mail'=>$this->db->get_where('tbl_users', ['uid'=>$params['created_by']])->row()->email,
                        'data'=>$data,
                        // 'farmer_details'=>$farmer
                    ];
                    
                }
                else{
                    return ['status'=>false, 'message'=>'Falla para agregar en Notificación.'];
                    // return ['status'=>false, 'message'=>'Failed to add in Notification.'];
                }

            }
            else{
                return ['status'=>false, 'message'=>'Falla para agregar Orden.'];
                // return ['status'=>false, 'message'=>'Failed to add Order.'];
            }
            
            
        }
        // else{
        //     // This condition of code will add the record to tbl_order
            
        //     $res = $this->db->insert($this->tb_order, $params);
        //     $last_oid = $this->db->insert_id();
    
        //     // Update the cart status to 1.
        //     $this->db->where('cart_id', $val);
        //     $res1[$key] = $this->db->update('tbl_order', ['status'=>'1']);
                        
        //     if($res){
                
        //         if(true){
                    
        //             $carts = json_decode($params['cart_id'], true);
        //             foreach($carts as $key => $val){
        //                 $dd[$key] = $val;
                        
        //                 // Update the cart status to 1.
        //                 $this->db->where('cart_id', $val);
        //                 $res1[$key] = $this->db->update('tbl_cart', ['status'=>'1']);
                        
        //                 // Get product id from tbl_cart
        //                 $g_pid[$key] = $this->db->get_where($this->tb_cart, ['cart_id'=>$val])->result();
        //                 $data[$key]['qty'] = $g_pid[$key][0]->qty;
        //                 $data[$key]['cust_id'] = $g_pid[$key][0]->created_by;
                        
        //                 if(count($g_pid[$key])){
        //                     // Get User id from tbl_product
        //                     $g_uid[$key] = $this->db->get_where('tbl_products', ['pid'=>$g_pid[$key][0]->pid])->result();
        //                     $data[$key]['prod_name'] = $g_uid[$key][0]->name;
        //                     $data[$key]['prod_image'] = $g_uid[$key][0]->image;
    
        //                     if(count($g_uid[$key])){
        //                         // Get Email from tbl_user
        //                         $g_email[$key] = $this->db->get_where('tbl_users', ['uid'=>$g_uid[$key][0]->created_by])->result();
                                
        //                         if(count($g_email[$key])){
        //                             // Send Mail to that email.
        //                             $data[$key]['email'] = $g_email[$key][0]->email;
        //                         }
        //                         else{
        //                             $data[$key]['error'] = ['status'=>false, 'message'=>'Failed to fetch email'];
        //                         }
                                
        //                     }
        //                     else{
        //                         $data[$key]['error'] = ['status'=>false, 'message'=>'Failed to fetch user key'];
        //                     }
                            
        //                 }
        //                 else{
        //                     $data[$key]['error'] = ['status'=>false, 'message'=>'Failed to fetch Product'];
        //                 }
                        
        //             }
    
        //             // Get created_at from tbl_order
        //             $ordrd_at = $this->db->get_where('tbl_order', ['oid'=>$last_oid])->result();
    
        //             return [
        //                 'status'=>true, 
        //                 'message'=>'Ordered successfully.', 
        //                 'order_date'=>$ordrd_at[0]->created_at, 
        //                 'total_price'=>$ordrd_at[0]->tot_price,
        //                 'data'=>$data
        //             ];
        //         }
        //         else{
        //             return ['status'=>false, 'message'=>'Order not successful.'];
        //         }
    
        //     }
        //     else{
        //         return ['status'=>false, 'message'=>'Failed to add Order.'];
        //     }
            
        // }
        

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
                            return ['status'=>false, 'message'=>'Failed to fetch data with oid and uid.'];
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
   $res = $this->db->get_where($this->tb_order, ['oid'=>$parms])->result();

$CustomerId = $res[0]->created_by;
   
    $customerName = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('name');
    $customerEmail = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('email');
    $customerPhone = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('phone');
   
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
    $data[$fkeys]['farmers']['fname']   = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row('name');
    $data[$fkeys]['farmers']['femail'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row('email');
    $data[$fkeys]['farmers']['fphone'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row('phone');
    $data[$fkeys]['farmers']['faddress'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row('address');
    $data[$fkeys]['farmers']['ftown'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row('town');
    $data[$fkeys]['farmers']['fcountry'] = $this->db->get_where($this->tb_user, ['uid'=>$fval['fid']])->row('country');
                    }
                }
                else{
                    $data['farmers'] = 'Farmers doesnot exists.';
                }


                return [
                    'status'=>true,                     
                    'order_from'=> $customerName, 
                    'customerEmail' => $customerEmail,
                    'customerPhone' => $customerPhone,
                    'order_id'=>$parms,
                    'total'=>count($pids),
                    'date'=>date('d.m.y', strtotime($res[0]->created_at)), 
                    'order_status'=>$this->ord_status[$res[0]->status],
                    'data'=>$data];
            }
            else{
                return ['status'=>false, 'message'=>'No se pudieron recuperar los datos con oid y uid..'];
                // return ['status'=>false, 'message'=>'Failed to fetch data with oid and uid.'];
            }

       
     //   return ['status'=>false, 'message'=>'Establezca las variables correctamente.'];


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


