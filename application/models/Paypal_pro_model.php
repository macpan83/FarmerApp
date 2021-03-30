<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paypal_pro_model extends CI_Model{

    public function __construct(){ 
        $this->tb_name = 'tbl_products';
    }

    //get and return product rows
    // public function getProducts($id = ''){

    //     $this->db->select('pid');
    //     $this->db->select('cid');
    //     $this->db->select('(SELECT name FROM tbl_categories WHERE tbl_categories.cid = tbl_products.cid) as category');
    //     $this->db->select('type');
    //     $this->db->select('image');
    //     $this->db->select(['name', 'description', 'cost_price', 'sell_price', 'unit', 'total_qty', 'approve', 'created_at', 'updated_at', 'created_by']);
    //     $this->db->from($this->tb_name);
    //     if($id){
    //     $this->db->where('pid', $id);
    //     }
     
    //     // $this->db->order_by('pid', 'desc');
    //     $res = $this->db->get();

    //     if(!empty($res->result())){
    //         return ['status'=>true, 'message'=>'Productos cargados con éxito.', 'count'=>count($res->result_array()), 'data'=>$res->result_array()];
    //         // return ['status'=>true, 'message'=>'Products loaded successfully.', 'data'=>$res->result_array()];
    //     }
    //     else{
    //         return ['status'=>false, 'message'=>'Falla para cargar todos los productos.'];
    //         // return ['status'=>false, 'message'=>'Failed to load all the products.'];
    //     }
       
    // }
    public function getAccessToken(){
    $curl = curl_init();
    $PAYPAL_CLIENT_ID = "Ac1T6Iyg8qg2MdCUkBK0uAnddKhFFx1OCbe-3LjuQ7FdIflXSPRvZIrRLuLOYvLUA28UZNYj3SnAFyMI";
    $PAYPAL_SECRET = "EF1xf7B8mxvY7fWwI-2Apc4SMsgRprP6XcBw06y78E5zNBxTp9G11XjVyIOJCIgIW2q0_qJyV8x5r4vN";

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api-m.sandbox.paypal.com/v1/oauth2/token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_USERPWD => $PAYPAL_CLIENT_ID.":".$PAYPAL_SECRET,
    CURLOPT_POSTFIELDS => "grant_type=client_credentials",
    CURLOPT_HTTPHEADER => array(
    "Accept: application/json",
    "Accept-Language: en_US"
    ),
    ));

    $result = curl_exec($curl);

    $array=json_decode($result, true); 
    return $array;    
    }

    public function sendPayment($param){  
    $logic = new Paypal_pro_model();

    $paypalArray = $logic->getAccessToken();

    $token=$paypalArray['access_token'];

    $email= "mayankpan3012@gmail.com";
    $fname= "mayank";
    $lname= "pandey";
    $address= "Street no 3 usa";
    $city= "Wahington";
    $country= "US";

    $zip="99501";
    $state="Alaska";
    $phone="011554454";

    $ccnum= "4012888888881881";
    $credit_card_type= "visa";
    $ccmo= "02";
    $ccyr= "2022";
    $cvv2_number= "123";
    $first_name= $fname;
    $last_name= $lname;
    $cost= "2";


    $data = '{
    "intent": "sale",
        "payer": {
        "payment_method": "credit_card",
        "payer_info": {
        "email": "'.$email.'",
        "shipping_address": {
        "recipient_name": "'.$fname.' '.$lname.'",
        "line1": "'.$address.'",
        "city": "'.$city.'",
        "country_code": "'.$country.'",
        "postal_code": "'.$zip.'",
        "state": "'.$state.'",
        "phone": "'.$phone.'"
    },
    "billing_address": {
    "line1": "'.$address.'",
    "city": "'.$city.'",
    "state": "'.$state.'",
    "postal_code": "'.$zip.'",
    "country_code": "'.$country.'",
    "phone": "'.$phone.'"
    }
    },
    "funding_instruments": [{
    "credit_card": {
    "number": "'. $ccnum.'",
    "type": "'.$credit_card_type.'",
    "expire_month": "'.$ccmo.'",
    "expire_year": "'.$ccyr.'",
    "cvv2": "'.$cvv2_number.'",
    "first_name": "'.$first_name.'",
    "last_name": "'.$last_name.'",
    "billing_address": {
    "line1": "'.$address.'",
    "city": "'.$city.'",
    "country_code": "'.$country.'",
    "postal_code": "'.$zip.'",
    "state": "'.$state.'",
    "phone": "'.$phone.'"
                }
            }
        }]
    },
    "transactions": [{
    "amount": {
    "total": "'.$cost.'",
    "currency": "USD"
    },
    "description": "This is member subscription payment at Thecodehelpers.",
    "item_list": {
    "shipping_address": {
    "recipient_name": "'.$fname.' '.$lname.'",
    "line1": "'.$address.'",
    "city": "'.$city.'",
    "country_code": "'.$country.'",
    "postal_code": "'.$zip.'",
    "state": "'.$state.'",
    "phone": "'.$phone.'"
                }
            }
        }]
    }';

// $data1 = '{
//   "intent": "CAPTURE",
//   "purchase_units": [
//     {
//       "amount": {
//         "currency_code": "USD",
//         "value": "100.00"
//       }
//     }
//   ]
// }';


   $PAYPAL_API_URL = 'https://api-m.sandbox.paypal.com/v1/payments/payment';
   // $PAYPAL_API_URL = 'https://api-m.sandbox.paypal.com/v2/checkout/orders';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $PAYPAL_API_URL);
    /*curl_setopt($ch, CURLOPT_URL, “https://api.paypal.com/v1/payments/payment”);*/
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: Bearer ".$token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($result);
 
    // $state=$json->state;
    echo "<pre>";
 print_r($json);
 echo "<br><br><br><br>";
// print_r($json);
//    die();
 // echo "</pre>";
//     $approveUrl = $json->links[0]->href;
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $approveUrl);
//     /*curl_setopt($ch, CURLOPT_URL, “https://api.paypal.com/v1/payments/payment”);*/
//    // curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//   //  curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: Bearer ".$token));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $result = curl_exec($ch);
//     curl_close($ch);
//     $approvejson = json_decode($result);
 
//     // $state=$json->state;
//     echo "<pre>";
//    // print_r($json->links[0]);
// print_r($approvejson);

 }
    //insert transaction data
    public function storeTransaction($data = array()){
        $insert = $this->db->insert('payments',$data);
        return $insert?true:false;
    }
}

?>
