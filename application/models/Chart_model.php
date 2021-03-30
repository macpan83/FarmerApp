<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_model extends CI_Model {

    private $tb_cart;
    private $tb_order;
    private $tb_notification;
    private $tb_products;
    private $tb_user;

    
    // In english
    // private $ord_status = [0=>'Ordered', 1=>'Deliver in transit', 2=>'Partial delivery', 3=>'Delivered', 4=>'Cancelled'];
    
    // In Spanish
  //  private $ord_status = [0=>'Pedido Realizado', 1=>'Pedido en Processo', 2=>'Entrega parcial', 3=>'Entrega', 4=>'Cancelada'];

    public function __construct(){ 
        $this->tb_cart = 'tbl_cart';
        $this->tb_order = 'tbl_order';
        $this->tb_notification = 'tbl_notification';
        $this->tb_products = 'tbl_products';
        $this->tb_user = 'tbl_users';
    }
    
    public function random_color(){
    mt_srand((double)microtime()*1000000);
    $c = '';
    while(strlen($c)<6){
        $c .= sprintf("%02X", mt_rand(0, 255));
    }
    return $c;
}
    
    
    public function get_popular_product(){
          //  $this->db->group_by('ord_no');
          $query = "SELECT pids, COUNT('pids') AS dupe_cnt FROM tbl_order GROUP BY pids HAVING COUNT('pids') > 1 ORDER BY COUNT('pids') DESC";
           $result =$this->db->query($query); 
          $res = $result->result();
          if(!empty($res)){          
              foreach ($res as $key =>$value) {
              $producID = $value->pids;
                $this->db->select('name');
                $this->db->where('pid', $producID );
                $q = $this->db->get('tbl_products');
                $data = $q->result_array();
               if(!empty($data)){
                $lebels[$key] = $data[0]['name'];
                $count [$key] = (int)$value->dupe_cnt;
                $colors[$key] = "#" . $this->random_color();
                $record[$key]['y'] = (int)$value->dupe_cnt;
                 $record[$key]['name'] = $data[0]['name']; 
               }
               else{
                   $record = array();
               }
              }
            return $record;
          }else{
            return array();
          }
     }


     public function get_income_detail(){
       
        $this->db->where("status", '1'); 
        $this->db->order_by("created_at", "asc");
        $this->db->group_by("created_at");
        $this->db->group_by("ord_no");
        $this->db->select("created_at, sum(tot_price) as total, ord_no");
        $q = $this->db->get("tbl_order");
        $data = $q->result_array();
       if(!empty($data)){      
          foreach ($data as $key => $value) {
           $rec[$key]['date'] = date('d', strtotime($value['created_at']));
           $rec[$key]['month'] = date('m', strtotime($value['created_at']));
           $rec[$key]['year'] = date('Y', strtotime($value['created_at']));
           $rec[$key]['y'] = (int)$value['total'];
          }         
          return $rec;
         }
         else{
              return array();
            }
         }
     
   public function order_detail(){
       $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
      $this->db->group_by('ord_no');
      $this->db->order_by('oid', 'desc');
      $res = $this->db->get($this->tb_order)->result();
        if($res){
            foreach($res  as $rs){                 
                $OrderId = $rs->oid; 
                $CustomerId = $rs->created_by;
                $productDetail =  $rs->pids;              

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
                     $order_list_data= $data;
                     
        }
        $todaysDate = date("Y-m-d 00:00:00");

        $this->db->select('status,created_at');
         $this->db->where('created_at >=', $todaysDate);
        $orders = $this->db->get($this->tb_order)->result();
        
        $i = $j = $k = $l = $m = $n = 0;
        $todaysDate = date("Y-m-d");
        foreach ($orders as $key => $value) {

          $order_status = $value->status;
          $order_date = date("Y-m-d", strtotime($value->created_at));          
         
          if($order_status == 0){
            $i ++;
          }
          if(($order_status == 1)){
            $j ++;
          }
          if($order_status == 2){
            $k ++;
          }
          if(($order_status == 3)){
            $l ++;
          }
          if(($order_status == 4)){
            $m ++;
          }
          if(($order_status == 5)){
            $n ++;
          }
        }
       
      $this->db->select('YEAR(`created_at`)');
      $this->db->order_by("created_at", "DESC");     
      $this->db->distinct();
      $years = $this->db->get($this->tb_order)->result();
      if(!empty($years)){

          foreach ($years as $key => $value) {
       
              $yearVal[$key] =get_object_vars($value)['YEAR(`created_at`)'];
          }

           $parms = [
                      'order_recieved'=>$i,
                      'order_being_processed'=>$j,
                      'order_in_transit' => $k,
                      'ready_to_pickup'=>$l,
                      'delivered'=>$m,
                      'cancelled'=>$n,
                      'order_list_item' => $order_list_data,
                      'years' => $yearVal
                    ];  
            return $parms;
      }
      else{
        $parms = [    'order_recieved'=>'0',
                      'order_being_processed'=>'0',
                      'order_in_transit' => '0',
                      'ready_to_pickup'=>'0',
                      'delivered'=>'0',
                      'cancelled'=>'0',
                      'order_list_item' => array(),
                      'years' => array()
                    ];  
            return $parms;
      }
       
   }

    public function get_full_order_detail(){
       
            // $this->db->order_by('oid', 'desc');
             $res = $this->db->get($this->tb_order)->result();


             if($res){
                 foreach($res  as $rs){                 
                    $OrderId = $rs->oid; 
                    $CustomerId = $rs->created_by;
                    $productDetail =  $rs->pids;
                    $farmerId = $rs->fids;
                    $productId = $rs->pids;
                   // echo "product detail";

                $customerName = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('name');
                $customerEmail = $this->db->get_where($this->tb_user, ['uid'=>$CustomerId])->row('email');
                $farmerName = $this->db->get_where($this->tb_user, ['uid'=>$farmerId])->row('name');
                $farmerEmail = $this->db->get_where($this->tb_user, ['uid'=>$farmerId])->row('email'); 
                $productName = $this->db->get_where($this->tb_products, ['pid'=>$productId])->row('name'); 
                    
                      $data['order'.$rs->oid]['orderId']  = $OrderId;
                      $data['order'.$rs->oid]['poId']  = $rs->ord_no;
                      $data['order'.$rs->oid]['product_name']  = $productName;
                      $data['order'.$rs->oid]['customerName'] = $customerName ;
                      $data['order'.$rs->oid]['orderDate'] = date('y-m-d', strtotime($rs->created_at)) ;
                      $data['order'.$rs->oid]['customerEmail'] = $customerEmail ;
                      $data['order'.$rs->oid]['farmerName'] = $farmerName ;
                      $data['order'.$rs->oid]['farmerEmail'] = $farmerEmail ;
                      $data['order'.$rs->oid]['quantity'] = $rs->qty ;
                      $data['order'.$rs->oid]['delivery_add'] = $rs->delivery_address ;
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



public function order_detail_by_time($month,$year){
  if((int)$month < 9){
$selectMonth = '0'.$month;
  }
  $strdate = $year.'-'.$selectMonth.'-01';
 
$first_day_this_month = date("Y-m-01 00:00:00", strtotime($strdate));
$last_day_this_month  = date("Y-m-t 23:59:59", strtotime($strdate));

        $this->db->select('status,created_at');
        $this->db->where('created_at >=', $first_day_this_month);
      $this->db->where('created_at <=', $last_day_this_month);  

        $orders = $this->db->get($this->tb_order)->result();

        if(!empty($orders )){ 
        $i = $j = $k = $l = $m = $n = 0;
        $todaysDate = date("Y-m-d");
        foreach ($orders as $key => $value) {

          $order_status = $value->status;
          $order_date = date("Y-m-d", strtotime($value->created_at));          
         
          if($order_status == 0){
            $i ++;
          }
          if(($order_status == 1)){
            $j ++;
          }
          if($order_status == 2){
            $k ++;
          }
          if(($order_status == 3)){
            $l ++;
          }
          if(($order_status == 4)){
            $m ++;
          }
          if(($order_status == 5)){
            $n ++;
          }
        } 
       $parms = [
                  'order_recieved'=>$i,
                  'order_being_processed'=>$j,
                  'order_in_transit' => $k,
                  'ready_to_pickup'=>$l,
                  'delivered'=>$m,
                  'cancelled'=>$n,

                //  'order_list_item' => $order_list_data
                ];
      return $parms;
    }
    else{
       $parms = [
                  'order_recieved'=>'0',
                  'order_being_processed'=>'0',
                  'order_in_transit' => '0',
                  'ready_to_pickup'=>'0',
                  'delivered'=>'0',
                  'cancelled'=>'0',
                ];
    }
   }


}


