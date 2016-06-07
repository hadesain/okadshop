<?php


require_once('class/paypal.php'); 
require_once('class/httprequest.php'); 
require_once "../../config/bootstrap.php";
require_once('php/function.php'); 

$paypalexpress_option = getPaypalOption();
if (isset($paypalexpress_option['username']) &&  isset($paypalexpress_option['password']) && isset($paypalexpress_option['signature'])) {
    $r = new PayPal($paypalexpress_option);
    if (isset($_POST['paypal'])) {
        $totalPayment = MontantGlobal(); 
        $ret = $r->doExpressCheckout($totalPayment, 'Reglement De commande','','EUR');
    }
    $final = $r->doPayment();
    if ($final['ACK'] == 'Success') {
        $return = $r->getCheckoutDetails($final['TOKEN']);
       // $res = saveData('paypal_module',$return);
       // var_dump($return);
    }
}


//header('location: '.WebSite);
?>

<html>
<head>
	<title></title>
	<!-- CSS -->
  <link href="<?=$themeDir;?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?=$themeDir;?>css/font-awesome.min.css" rel="stylesheet">

	<style type="text/css">

body {padding-top:50px;}

.box {
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    padding: 10px 25px;
    text-align: right;
    display: block;
    margin-top: 60px;
}
.box-icon {
   // background-color: #57a544;
    border-radius: 50%;
    display: table;
    height: 100px;
    margin: 0 auto;
    width: 100px;
    margin-top: -61px;
}
.box-icon span {
    color: #002F86;
    display: table-cell;
    text-align: center;
    vertical-align: middle;
}
.info h4 {
    font-size: 26px;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.info > p {
    color: #717171;
    font-size: 16px;
    padding-top: 10px;
    text-align: justify;
}
.info > a {
    background-color: #03a9f4;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
}
.info > a:hover {
    background-color: #0288d1;
    box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.16), 0 2px 5px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
}
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="" style="text-align: center;margin: auto;width: 500px;">
            <div class="box">
                <div class="box-icon">
                    <span class="fa fa-5x fa-paypal"></span>
                </div>
                <div class="info">
                    <h4 class="text-center">PayPal Express <?= l('Payment','paypalexpress');?></h4>
                    <?php if ($final['ACK'] == 'Success'): ?>
                    	<p>
                    	 	<div class="alert alert-success" role="alert">
                    	 		<?= l('Félicitation, le paiement à éte bien effectué.','paypalexpress');?> <br>
                    	 	</div>
                    	</p>
                    	<a href="<?= WebSite ?>" class="btn"><?= l('Retour au site','paypalexpress');?></a>
                   	<?php else: ?>
                   	<p>
                   		<div class="alert alert-danger" role="alert">
                   			<?= l('malheureusement, le paiement est incomplète','paypalexpress');?>
                   		</div>
                   	</p>
                   	<a href="<?= WebSite ?>" class="btn"><?= l('Retour au site','paypalexpress');?></a>
                    <?php endif ?>
                </div>
            </div>
        </div>
	</div>
</div>
</body>
</html>