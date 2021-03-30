<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_addresses extends CI_Controller {

	public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->model('users_model', 'user');
        $this->load->model('products_model', 'pro');
        $this->load->model('catagories_model', 'cat');
        $this->load->model('email_model', 'mai');
        $this->load->model('store_model', 'store');
        $this->load->helper('form');
        $this->load->library('session');
    }

	public function get_customer_delivery_options(){
        $params = [
            'uid' => $this->input->get('uid')
        ];

        $userDetail = $this->user->get_customer_by_id($params);
        $userAddress = $userDetail['data'][0]['address'];
        $userTown = $userDetail['data'][0]['town'];
        $userCountry = $userDetail['data'][0]['country'];
        $userHomeAddress = $userAddress.' ,'.$userTown.' ,'.$userCountry;


        $delivery_timing = $this->store->get_delivery_timings();

		$res = $this->store->getalladdress();
        $address = $res['data'];
      //  print_r($address );
        $j =0;
foreach($address as $key =>$val){
$data[$key][$val['address_type']] =  $val['store_addresses'];

}
foreach($delivery_timing as $val){
$data1[$j] = $val->delivery_timing;
$j++;
}

$params = ['customer_home_address' => $userHomeAddress, 'delivery_address' => $data , 'home_delivery_timing' => $data1];


        exit(json_encode($params));
        //exit(json_encode($address));
    }

	public function get_farmer_delivery_options(){
        $res = $this->store->getalladdress();
        $address = $res['data'];
        foreach($address as $key =>$val){
            $data[$key][$val['address_type']] =  $val['store_addresses'];
        }

        $params = [ 'delivery_address' => $data ];
         exit(json_encode($params));

    }

}


