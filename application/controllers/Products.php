<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');

		$this->load->model('users_model', 'user');
		$this->load->model('catagories_model', 'cat');
		$this->load->model('products_model', 'pro');
		$this->load->model('stocks_model', 'sto');
		$this->load->model('email_model', 'mail');
		$this->load->helper('form');
		// $this->load->model('user', '');
	}
	
	public function index(){
		// echo 'Product page will be displayed here with all the products.';
        // echo json_encode($this->pro->get_all_products());
	}
	
	public function addProducts(){
		
		// echo '<pre>';
		// print_r($this->input->post());
		// print_r($_FILES);

		if($this->session->userdata('id')){
			
			$r = $this->pro->add_product($this->input->post());
			// echo json_encode($r);

			if($r['status']){

				// $config['upload_path']          = './uploads/';
                // $config['allowed_types']        = 'gif|jpg|png';
                // $config['max_size']             = 100;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;

                // $this->load->library('upload', $config);

                // if ( ! $this->upload->do_upload('food_img'))
                // {
                //         $error = array('error' => $this->upload->display_errors());

				// 		echo '<pre>';
				// 		print_r($error);
				// 		// $this->load->view('upload_form', $error);
				// 		// redirect('products','refresh');
				// 	}
				// 	else
				// 	{
				// 		$data = array('upload_data' => $this->upload->data());
	
				// 		echo '<pre>';
				// 		print_r($data);
                //         // $this->load->view('upload_success', $data);
				// 		// redirect('products','refresh');
                // }
				
				redirect('products','refresh');
			
			}
			else{
				redirect('products','refresh');
			}
		}
		else{
			redirect('login','refresh');
		}

	}

	public function updProducts(){

		$params = [
			'id'=>$this->input->post('pid'),
			'data'=>$this->input->post()  
		];


$productName = $this->input->post('name');
$productDescription = $this->input->post('description');
$farmerId= $this->input->post('created_by');
$farmerData=$this->user->getfarmerbyid($farmerId);

if($farmerData['total_rec'] != 0){
$farmerInfo = $farmerData['data'][0];
$farmerEmail = $farmerInfo->email;
}
$productStatus = $this->input->post('approve');

		if($this->session->userdata('id')){
			
			$r = $this->pro->upd_product_by_id($params);
			// echo json_encode($r);

			if($r['status']){
				If($productStatus == 0){
				     $logo = base_url('uploads/logo-farm.png');$fb =  base_url('uploads/fb.png');$tw =  base_url('uploads/tt.png');$ln =  base_url('uploads/ln.png');
					$_mail['to'] = $farmerEmail;
				 		$_mail['to'] = $farmerEmail;
				 	//	$_mail['to'] = 'mayank.pandey@cynoteck.com';
        				$_mail['subject'] = "Lo sentimos, su producto ha sido rechazado";
        				$_mail['message'] = '<html><body style="font-size: 13pt; font-family: Arial, sans-serif;padding-top:10px;padding:bottom:10px">';        				
						$_mail['message'] .= 'Hola,<br><br>Lo sentimos Su producto <b>'.$productName.'</b> con descripci車n: <b>'.$productDescription.'</b>  <br> fue rechazado, comun赤quese con el administrador del sitio para m芍s comunicaciones<br><br></body>';
                        $_mail['message'] .= '<TABLE style="WIDTH: 640px" width="640" cellSpacing="0" cellPadding="0" border="0"><TBODY><TR><TD style="FONT-SIZE: 10pt; FONT-FAMILY: Arial, sans-serif;WIDTH: 290px; PADDING-BOTTOM: 5px; line-height:16pt;" width="290" vAlign="top">
		<STRONG><SPAN style="FONT-SIZE: 18pt; FONT-FAMILY: Arial, sans-serif; COLOR: #06333f;">John Doe</SPAN></STRONG><BR><SPAN style="FONT-SIZE: 11pt; FONT-FAMILY: Arial, sans-serif;; COLOR: #666666">Sales and Marketing Director</SPAN>
	</TD><TD vAlign="top" width="150" align="right" style="width:150px"><a href="" target="_blank" rel="noopener"><img border="0" src="'.$logo.'" alt="Logo" width="147" style="max-width:147px; height:auto; border:0;"></a></TD>
	</TR><TR><TD colspan="2" style="padding-top:10px; BORDER-TOP: #06333f 1px solid; font-size:10pt">
		<span  style="color:#666666;"><strong style="color:#06333f;;">Mobile:</strong> 9988776655</span>
		<span  style="color:#666666;"><span  style="color:#666666;">&nbsp;&nbsp;|&nbsp;&nbsp;</span><strong style="color:#06333f;;">Phone:</strong> +48 77 66 55 44<BR></span>
		<span  style="color:#666666;"><strong style="color:#06333f;;">Email:</strong> test@gmail.com</span>	
	</TD></TR><TR><TD style="font-size:10pt"><span style="font-size:10pt; color:#666666;"><br>address1, address2</span></TD>
		<td>&nbsp;</td>
	</TR><TR><TD style="line-height:12pt; FONT-SIZE: 9pt; FONT-FAMILY: Arial, sans-serif;;" valign="bottom">
		<span ><a href="http://{website}" target="_blank" rel="noopener" style=" text-decoration:none;"><strong style="color:#06333f; font-family:Arial, sans-serif;;">www.farmerapp.com</strong></a></span>
	</td><td align="right">
		<span ><a href="{facebookURL}" target="_blank" rel="noopener"><img border="0" width="13" src="'.$fb.'" alt="facebook icon" style="border:0; height:13px; width:13px"></a></span>&nbsp;&nbsp;
		<span ><a href="{twitterURL}" target="_blank" rel="noopener"><img border="0" width="13" src="'.$tw.'" alt="twitter icon" style="border:0; height:13px; width:13px"></a></span>&nbsp;&nbsp;
		<span ><a href="{linkedinURL}" target="_blank" rel="noopener"><img border="0" width="13" src="'.$ln.'" alt="linkedin icon" style="border:0; height:13px; width:13px"></a></span>&nbsp;
	</TD></TR><TR><TD  style="FONT-SIZE: 8pt; FONT-FAMILY: Arial, sans-serif;WIDTH: 640px; COLOR: #c0c0c0; PADDING-TOP: 10px; line-height:10pt" vAlign="top" colSpan="2">
"Somos un patrono con Igualdad de Oportunidades en el Empleo y tomamos acci車n afirmativa para reclutar a Mujeres, Minor赤as, Veteranos Protegidos y Personas con Impedimentos."<br>
"We are an Equal Employment Opportunity Employer and take Affirmative Action to recruit Women, Protected Veterans, and Individuals with Disabilities."<br><br>
**AVISO DE CONFIDENCIALIDAD** La informaci車n contenida en este mensaje y los archivos adjuntos pueden ser legalmente privilegiada y confidencial. Si usted no es un destinatario,
se le notifica que cualquier divulgaci車n, distribuci車n o copia de este mensaje est芍 estrictamente prohibida. Si usted ha recibido este mensaje por error,
por favor notifique al remitente y elimine permanentemente el correo electr車nico y los archivos adjuntos de inmediato. No se debe retener, 
copiar o utilizar este mensaje o los archivos adjuntos para cualquier prop車sito, ni divulgar toda o una parte de los contenidos a cualquier otra persona.<br><br>
**CONFIDENTIALITY NOTICE** The information contained in this email and any attachments may be legally privileged and confidential. If you are not an intended recipient,
you are hereby notified that any dissemination, distribution, or copying of this e-mail is strictly prohibited. If you have received this e-mail in error,
please notify the sender and permanently delete the e-mail and any attachments immediately. You should not retain, copy or use this e-mail or any attachments for any purpose,
nor disclose all or any part of the contents to any other person.<br></TD></TR></TBODY></TABLE>';
						$_mail['message'] .= '</html>';
          				$r = $this->mail->product_rejected_mail($_mail);
				}
				else{
				    $logo = base_url('uploads/logo-farm.png');$fb =  base_url('uploads/fb.png');$tw =  base_url('uploads/tt.png');$ln =  base_url('uploads/ln.png');
					$_mail['to'] = $farmerEmail;
				 	//	$_mail['to'] = 'mayank.pandey@cynoteck.com';
        				$_mail['subject'] = "Su producto ha sido aprobado";
        				$_mail['message'] = '<html><body style="font-size: 13pt; font-family: Arial, sans-serif;padding-top:10px;padding:bottom:10px">';        				
						$_mail['message'] .= 'Hola,<br><br> Su producto: <b>'.$productName.'</b> con la descripci車n: <b>'.$productDescription.'</b> <br> ha sido aprobado y agregado al sitio para la venta. <br><br></body>';
                        $_mail['message'] .= '<TABLE style="WIDTH: 640px" width="640" cellSpacing="0" cellPadding="0" border="0"><TBODY><TR><TD style="FONT-SIZE: 10pt; FONT-FAMILY: Arial, sans-serif;WIDTH: 290px; PADDING-BOTTOM: 5px; line-height:16pt;" width="290" vAlign="top">
		<STRONG><SPAN style="FONT-SIZE: 18pt; FONT-FAMILY: Arial, sans-serif; COLOR: #06333f;">John Doe</SPAN></STRONG><BR><SPAN style="FONT-SIZE: 11pt; FONT-FAMILY: Arial, sans-serif;; COLOR: #666666">Sales and Marketing Director</SPAN>
	</TD><TD vAlign="top" width="150" align="right" style="width:150px"><a href="" target="_blank" rel="noopener"><img border="0" src="'.$logo.'" alt="Logo" width="147" style="max-width:147px; height:auto; border:0;"></a></TD>
	</TR><TR><TD colspan="2" style="padding-top:10px; BORDER-TOP: #06333f 1px solid; font-size:10pt">
		<span  style="color:#666666;"><strong style="color:#06333f;;">Mobile:</strong> 9988776655</span>
		<span  style="color:#666666;"><span  style="color:#666666;">&nbsp;&nbsp;|&nbsp;&nbsp;</span><strong style="color:#06333f;;">Phone:</strong> +48 77 66 55 44<BR></span>
		<span  style="color:#666666;"><strong style="color:#06333f;;">Email:</strong> test@gmail.com</span>	
	</TD></TR><TR><TD style="font-size:10pt"><span style="font-size:10pt; color:#666666;"><br>address1, address2</span></TD>
		<td>&nbsp;</td>
	</TR><TR><TD style="line-height:12pt; FONT-SIZE: 9pt; FONT-FAMILY: Arial, sans-serif;;" valign="bottom">
		<span ><a href="http://{website}" target="_blank" rel="noopener" style=" text-decoration:none;"><strong style="color:#06333f; font-family:Arial, sans-serif;;">www.farmerapp.com</strong></a></span>
	</td><td align="right">
		<span ><a href="{facebookURL}" target="_blank" rel="noopener"><img border="0" width="13" src="'.$fb.'" alt="facebook icon" style="border:0; height:13px; width:13px"></a></span>&nbsp;&nbsp;
		<span ><a href="{twitterURL}" target="_blank" rel="noopener"><img border="0" width="13" src="'.$tw.'" alt="twitter icon" style="border:0; height:13px; width:13px"></a></span>&nbsp;&nbsp;
		<span ><a href="{linkedinURL}" target="_blank" rel="noopener"><img border="0" width="13" src="'.$ln.'" alt="linkedin icon" style="border:0; height:13px; width:13px"></a></span>&nbsp;
	</TD></TR><TR><TD  style="FONT-SIZE: 8pt; FONT-FAMILY: Arial, sans-serif;WIDTH: 640px; COLOR: #c0c0c0; PADDING-TOP: 10px; line-height:10pt" vAlign="top" colSpan="2">
"Somos un patrono con Igualdad de Oportunidades en el Empleo y tomamos acci車n afirmativa para reclutar a Mujeres, Minor赤as, Veteranos Protegidos y Personas con Impedimentos."<br>
"We are an Equal Employment Opportunity Employer and take Affirmative Action to recruit Women, Protected Veterans, and Individuals with Disabilities."<br><br>
**AVISO DE CONFIDENCIALIDAD** La informaci車n contenida en este mensaje y los archivos adjuntos pueden ser legalmente privilegiada y confidencial. Si usted no es un destinatario,
se le notifica que cualquier divulgaci車n, distribuci車n o copia de este mensaje est芍 estrictamente prohibida. Si usted ha recibido este mensaje por error,
por favor notifique al remitente y elimine permanentemente el correo electr車nico y los archivos adjuntos de inmediato. No se debe retener, 
copiar o utilizar este mensaje o los archivos adjuntos para cualquier prop車sito, ni divulgar toda o una parte de los contenidos a cualquier otra persona.<br><br>
**CONFIDENTIALITY NOTICE** The information contained in this email and any attachments may be legally privileged and confidential. If you are not an intended recipient,
you are hereby notified that any dissemination, distribution, or copying of this e-mail is strictly prohibited. If you have received this e-mail in error,
please notify the sender and permanently delete the e-mail and any attachments immediately. You should not retain, copy or use this e-mail or any attachments for any purpose,
nor disclose all or any part of the contents to any other person.<br></TD></TR></TBODY></TABLE>';
						$_mail['message'] .= '</html>';
          				$r = $this->mail->product_rejected_mail($_mail);
				}

				// redirect('products','refresh');
				$msg = 'El producto seleccionado ha sido actualizado';
				$r = $this->pro->get_all_products_for_admin();
				$this->load->view('products', ['data'=>$r,'message'=>$msg,'status'=>true]); 

			}
			else{
				$msg = 'Lo sentimos, el producto no se pudo actualizar';
				$r = $this->pro->get_all_products_for_admin();
				$this->load->view('products', ['data'=>$r,'status'=>false,'message'=>$msg]);
				// redirect('products','refresh');
			}
		}
		else{
			redirect('login','refresh');
		}

	}

	public function delProducts(){
		// echo '<pre>';
		// print_r($this->input->post());
		$params = [
			'id'=>$this->input->post('pid'),
		];

		if($this->session->userdata('type') == 1){
			
			$r = $this->pro->del_product_by_id($params);
			// echo json_encode($r);

			if($r['status']){
				$r = $this->pro->get_all_products_for_admin();
				$msg = 'El producto seleccionado ha sido eliminado';
				$this->load->view('products', ['data'=>$r,'status'=>true,'message'=>$msg]);
				// redirect('products','refresh');
			}
			else{
				$r = $this->pro->get_all_products_for_admin();
				$msg = 'Lo sentimos, el producto no se pudo eliminar';
				$this->load->view('products', ['data'=>$r,'status'=>false,'message'=>$msg]);
				// redirect('products','refresh');
			}
		}
		else{
			redirect('login','refresh');
		}
	}

}
