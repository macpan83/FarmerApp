<?php
use Phppot\Order;
require_once __DIR__ . '/Model/Order.php';

$order_id = $_GET["id"];

$orderModel = new Order();


$OrderResult = $orderModel->getPdfGenerateValues($order_id);


$OrderId = $OrderResult[0]['ord_no'];
$CustomerId = $OrderResult[0]['created_by'];
$OrderDate =  $OrderResult[0]['created_at'];

// echo "customer id = ".$CustomerId;
$result= $orderModel->customerDetail($CustomerId);
     // $customerName =  $re[0]['name'];
     //  $customerEmail=  $re[0]['email'];
     //  $customerCompany=  $re[0]['cname'];
     //  $customerAdd=  $re[0]['address'];

               $k = 0;
                    foreach($OrderResult as $rs){
                    	$pIds = $rs['pids'];
                   		$productDetail = $orderModel->productDetail($pIds);
                   $orderItemResult[$k]['order_invoice']  = $rs['ord_no'];
    				  $orderItemResult[$k]['product_title']  = $productDetail[0]['name'];
    				  $orderItemResult[$k]['item_price']  = $productDetail[0]['sell_price'];
                      $orderItemResult[$k]['quantity'] = $rs['qty'];
                      $orderItemResult[$k]['unit'] = $productDetail[0]['unit'];
                      $orderItemResult[$k]['order_at'] =  $rs['created_at'];
          //             $data[$k]['customerEmail'] = $customerEmail ;
          //             $data[$k]['status'] = $rs->status ;
          //             $data[$k]['item_price'] = $rs->tot_price ;
          //             $data[$k]['remark'] = $rs->remarks ;  
           $k++;  
                } 
            
           

//$orderItemResult = $orderModel->getOrderItems($result[0]["oid"]);

//print_r($orderItemResult);

if (! empty($result)) {
    require_once __DIR__ . "/lib/PDFService.php";
    $pdfService = new PDFService();
    $pdfService->generatePDF($result,$orderItemResult );
}