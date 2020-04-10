<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');

$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
require_once('inc/TCPDF-master/examples/tcpdf_include.php');
require_once('inc/TCPDF-master/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$action = true;
if(isset($_GET['id']) && $_GET['id']>0){
	$pay_id = (int)$_GET['id'];
	$row = $prop->get('*', PAYMENT, array('id'=>$pay_id));
	if(!empty($row)){
		
		if($row['invoice']!='' && $row['invoice']!=null){
			$invoice = $row['invoice'];
		}else{
			$invoice = date('Y',strtotime($row['created_date'])).'-'.str_pad($row['id'], 4, '0', STR_PAD_LEFT);
		}
	}
	if($invoice!=''){
		$action = false;
		
		
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(10, PDF_MARGIN_TOP, 10);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

		// set font
		$pdf->SetFont('times', 'B', 20);
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		$pdf->SetFont('helvetica', '', 9);
		$pdf->AddPage();

		$body = '<table>
					<tr>
						<th colspan="2" align="center" style="color:#099;"><h3>Transacation Detail</h3></th>
					</tr>
					<tr>
						<th colspan="2" align="left" style="background-color:#a0a0a0;">Order Information</th>
					</tr>
					<tr>
						<td>Invoice Number : </td>
						<td>'.$invoice.'</td>
					</tr>
					<tr>
						<th colspan="2" align="left" style="background-color:#a0a0a0;">Billing Information</th>
					</tr>
					<!--<tr>
						<td>billTo->firstName billTo->lastName</td>
					</tr>
					<tr>
						<td>billTo->address</td>
						<td></td>
					</tr>
					<tr>
						<td>billTo->city</td>
						<td></td>
					</tr>
					<tr>
						<td>billTo->state</td>
						<td></td>
					</tr>
					<tr>
						<td>billTo->zip</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>-->
					<tr>
						<td>'.$row['email'].'</td>
						<td></td>
					</tr>
					<!--<tr>
						<td>bill phone</td>
						<td></td>
					</tr>-->
					<tr>
						<th colspan="2" align="left" style="background-color:#a0a0a0;">Payment Information</th>
					</tr>
					<tr>
						<td>Date/Time : </td>
						<td>'.date('d/m/Y h:i A',strtotime($row['created_date'])).'</td>
					</tr>
					<tr>
						<td>Payment Method : </td>
						<td>'.$row['card_type'].' '.$row['card_number'].'</td>
					</tr>
					<tr>
						<td>Amount : </td>
						<td>$'.$row['amount'].'</td>
					</tr>
				</table>';
			$pdf->writeHTML($body, true, false, true, false, '');
			$pdf->Output('Invoice-'.$row['invoice'].'.pdf', 'I');
			/* header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.'Invoice-'.$row['invoice'].'.pdf"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($_SERVER['REQUEST_URI']));
			flush(); // Flush system output buffer
			//readfile($_SERVER['REQUEST_URI']); */
			exit;
	}
}
if($action){
	header('Location: manage-company.php'); die();
}
exit;

?>
