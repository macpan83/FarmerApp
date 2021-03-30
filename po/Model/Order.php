<?php
namespace Phppot;

use Phppot\DataSource;

class Order
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . './../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    function getAllOrders()
    {
        $query = "SELECT * FROM tbl_order";
        $result = $this->ds->select($query);
        return $result;
    }

    function getPdfGenerateValues($id)
    {
        $query = "SELECT * FROM tbl_order WHERE ord_no='" . $id . "'";
        $result = $this->ds->select($query);
               return $result;
    }

    function getOrderItems($order_id)
    {
        $sql = "SELECT tbl_order_items.*,tbl_product.product_title FROM tbl_order_items
                JOIN tbl_product ON tbl_order_items.product_id=tbl_product.id WHERE tbl_order_items.order_id='" . $order_id . "'";
        $query = "SELECT * FROM tbl_order_items WHERE order_id='" . $order_id . "'";
        $result = $this->ds->select($query);
        return $result;
    }

    function getProduct($product_id)
    {
        $query = "SELECT * FROM tbl_product WHERE id='" . $product_id . "'";
        $result = $this->ds->select($query);
        return $result;
    }

    function customerDetail($custId){
        $query = "SELECT name,email,cname,address FROM tbl_users WHERE uid='" . $custId . "'";
        $result = $this->ds->select($query);
            return $result;
    }

    function productDetail($productId){
   

$query = "SELECT name,description,sell_price,cost_price,unit FROM tbl_products WHERE pid ='". $productId . "'";
        $result = $this->ds->select($query);

          return $result;
    }
}
