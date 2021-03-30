<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class order extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('products_model', 'pro');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('order_model', 'ord');
		$this->load->model('email_model', 'mai');
		
		$this->load->helper('form');

		$this->load->library('session');
	}
	
	public function addcart(){
        // Here one product will be added in tbl_cart.
        
        // Pass JSON data 
        $inputs = json_decode($this->input->raw_input_stream, true);

        $data = [
                'pid'           => $inputs['pid'],
              //  'cid'         => $inputs['cid'],
                'qty'           => $inputs['qty'],
              //  'unit'          => $inputs['unit'],
              //  'price'         => $inputs['price'],
              
                'created_by'    => $inputs['uid']
            ];
        
        $res = $this->ord->addcart($data);
        if($res['status']){
            exit(json_encode($res));
        }
        else{
            exit(json_encode($res));
        }
    }

    public function addmultiplecart(){
        // Here mutiple product willl be added in the tbl_cart
        
        // Pass JSON data 
        $inputs = json_decode($this->input->raw_input_stream, true);

        // here a loop need to be created for multiple file upload.
        
        foreach($inputs as$key => $val){
            $data[$key] = [
                    'pid'           => $val['pid'],
                  //  'cid'         => $val['cid'],
                    'qty'           => $val['qty'],
                    'unit'          => $val['unit'],
                    'price'         => $val['price'],
                    'total_price'   => $val['qty'] * $val['price'],
                    'created_by'    => $val['uid']
                ];            
        }

        $res = $this->ord->addmultiplecart($data);
        if($res['status']){
            exit(json_encode($res));
        }
        else{
            exit(json_encode($res));
        }
    }

    public function updatecart(){
        // Here both one product ormultiple products will be updated 
    }
    
    // Here both one product ormultiple products will be updated 
    public function updatecartbyid(){
        // Pass JSON data 
        $inputs = json_decode($this->input->raw_input_stream, true);
        
        $res = $this->ord->updatecartbyid($inputs);
        exit(json_encode($res));
    }
    
    public function deletecartbyid(){
        // Pass JSON data 
        // $inputs = json_decode($this->input->raw_input_stream, true);
        
        $res = $this->ord->deletecartbyid(['cart_id'=>$this->input->get('cartid')]);
        exit(json_encode($res));
    }
    
    public function showcart(){
        $res = $this->ord->showcart();
        exit(json_encode($res));
    }
    
    public function getorder_userpurchase(){
        $res = $this->ord->getorder_userpurchase($this->input->get('uid'));
        exit(json_encode($res));
    }

    public function showcart_byuid(){
        $uid = $this->input->get('uid');
        $res = $this->ord->showcart_byid($uid);
        exit(json_encode($res));
    }

	public function addorder(){
        // exit($this->input->raw_input_stream);
        $inputs = json_decode($this->input->raw_input_stream, true);
        $data = [
                'cart_id'   => json_encode($inputs['cart_id']),
                'tot_price' => $inputs['tot_price'],
                'status'    => $inputs['status'],
                'remarks'    => $inputs['remarks'],
                'created_by'=> $inputs['created_by'],
                'delivery_address'=> $inputs['delivery_address'],
                'delivery_time'=> $inputs['delivery_time'],
                'payment_id'=> $inputs['payment_id']
            ]; 
            
          

        $res = $this->ord->addorder($data);        
        // echo json_encode($res);      
        
       
      
        $ord_sts = ['Ordered','Deliver in transit','Partial delivery','Delivered','Cancelled'];        
        if($res['status']){            
            // Get the farmers and customer information through Order_number
            $order_num = $res['order_no'];            
            $get_order_details = $this->db->get_where('tbl_order', ['ord_no'=>$order_num])->result_array();
            
            $html_text_product_list = '';

            foreach($get_order_details as $key => $value){
            
                $pname[$key]    = $this->db->get_where('tbl_products', ['pid'=>$value['pids']])->row()->name;
                $pimage[$key]   = $this->db->get_where('tbl_products', ['pid'=>$value['pids']])->row()->image;
                $pqty[$key]     = $value['qty'];
                $pprice[$key]   = $this->db->get_where('tbl_products', ['pid'=>$value['pids']])->row()->sell_price;
                $ptotal[$key]   = $value['tot_price'];
    
                $user_email   = $this->db->get_where('tbl_users', ['uid'=>$value['created_by']])->row()->email;
                $user_name    = $this->db->get_where('tbl_users', ['uid'=>$value['created_by']])->row()->name;
                $farmer_email[$key] = $this->db->get_where('tbl_users', ['uid'=>$value['fids']])->row()->email;
                $farmer_name[$key]  = $this->db->get_where('tbl_users', ['uid'=>$value['fids']])->row()->name;
                
                $order_status  = $value['status'];                
                
                // Credentials to send mail to Customer
               
               
                $html_text_product_list .= '<tr>
                    <td><img src="'.$pimage[$key].'" width="30%" class="img-thumbnail" /></td>
                    <td><p>'.$pname[$key].'</p></td>
                    <td><b>'.$pqty[$key].'</b></td>
                    <td><b>'.$pprice[$key].'</b></td>
                    <td><b>'.$ptotal[$key].'</b></td>
                </tr>';

               
            
            }
              $to    = $user_email;
              // $to    = 'mayank.pandey@cynoteck.com';
                $subject= 'Product has been purchased with '.$order_num;//$val['prod_name'];

                $html_text_customer = '<div class="container" width="50%"><div class="row"><div class="col-md-12"> <br/><br/> <img src="https://image.winudf.com/v2/image1/Y29tLnBpeG5hYmlsYWIuZnJlc2hvbnRoZWdvX2ljb25fMTU4ODY1OTc3N18wMDE/icon.png?w=170&fakeurl=1" class="img-thumbnail" width="10%" /></div><div class="col-md-12"> <br/><br/><p>Hi '.$user_name.',</p><p>Greetings from Fresh on the go.</p><p>We rae mailing you the current status of your open fresh on the go order as requested.</p><p>Your order status : '.$ord_sts[$order_status].'</p></div><table cellpadding="5" cellspacing="5" align="center"><thead><th align="left" width="20%">Image</th><th align="left" width="20%">Products</th><th align="left" width="20%">Quantity</th><th align="left" width="20%">Price</th><th align="left" width="20%">Total</th></thead>';
                $html_text_customer .= $html_text_product_list;
                $html_text_customer .='</table></div></div>';
                 $html_text_customer .='<div style="margin-top:50px;padding:10px;border:1px solid #000;color:#000">Please click on the link to download you purchase slip : <a href="http://farmerappportal.cynotecksandbox.com/po/invoice.php?id='.$order_num.'">Purchase slip</a></div>';
                 $message =  $html_text_customer;
$send_mail = $this->mai->send_otp_mail(['to'=>$to, 'subject'=>$subject, 'message'=>$message]);
                if($send_mail['status']){
                  exit(json_encode(['status'=>true, 'message'=>'order placed sucessfully and mail was sent.']));
                }
                else{
                  exit(json_encode(['status'=>false, 'message'=>'order placed sucessfully and mail was not sent.']));
                }
        }
            

    }

}


