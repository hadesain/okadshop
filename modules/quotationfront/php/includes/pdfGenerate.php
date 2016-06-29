<?php 
define('WSDIR','okadshop/');
define("ROOTPATH",$_SERVER["DOCUMENT_ROOT"] . '/' . WSDIR);
require_once ROOTPATH.'/classes/mpdf/mpdf.php';
//var_dump($_POST);
try
{
	/*$html ="<h1>hello</h1>";
	$footer ="<h1>heldsgfdsglo</h1>";
	$code ="<h1>fgdf</h1>";
    //A4 paper
    $mpdf = new mPDF('utf-8' , 'A4' , '' , '' , 15 , 15 , 10 , 10 , 10 , 5); 
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $mpdf->setDefaultFont("Arial");
    $mpdf->WriteHTML($html);
    $mpdf->SetHTMLFooter($footer);
    $mpdf->Output($code.'.pdf','I');*/
    $mpdf = new mPDF();
    $mpdf->WriteHTML('<h1>hello</h1>');
    $mpdf->Output('mypdf.pdf','D');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>