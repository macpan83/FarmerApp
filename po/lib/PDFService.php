<?php
use Phppot\Config;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__ . '/../lib/Config.php';
$config = new Config();

class PDFService {

    function generatePDF($result, $orderItemResult) {

// echo "<pre>";
// echo "result";
// print_r($result);
// echo "orderItemResult";
// print_r($orderItemResult);
// die();

        require_once __DIR__ . '/../vendor/tcpdf/tcpdf.php';
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, '', '', array(
            0,
            0,
            0
        ), array(
            255,
            255,
            255
        ));
        $pdf->SetTitle('Invoice - ' . $orderItemResult[0]["order_invoice"]);
        $pdf->SetMargins(20, 10, 20, true);
     
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('helvetica', '', 11);
        $pdf->AddPage();
        $orderedDate = date('d F Y', strtotime($orderItemResult[0]["order_at"]));
        $due_date = date("d F Y", strtotime('+' . Config::DELIVERY_TIME . 'days', strtotime($orderedDate)));
 
        require_once __DIR__ . '/../Template/purchase-invoice-template.php';
        $html = getHTMLPurchaseDataToPDF($result, $orderItemResult, $orderedDate, $due_date);
        $filename = "Invoice-" . $orderItemResult[0]["order_invoice"];
        $pdf->writeHTML($html, true, false, true, false, '');
     //   ob_end_clean();
        $pdf->Output($filename . '.pdf', 'I');
    }
}

?>