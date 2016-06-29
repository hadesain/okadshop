<?php
if (!defined('_OS_VERSION_'))
  exit;


require_once 'php/function.php';

//register module infos
global $hooks;
$data = array(
	"name" => "Products viewed",
	"description" => "Products viewed.",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
);
$hooks->register_module('productviewed', $data);


function productviewed_display(){
	$viewed_product = pv_getViewedProduct(4);
	if (!$viewed_product || empty($viewed_product)) {
		return;
	}
	$output = "";
	$output .= '<div class="panel">
				  <div class="panel-heading">
				    <h3 class="panel-title"><a href="'.WebSite.'views/viewed-products">'.l("Produits déjà vus",'productviewed').'</a></h3>
				  </div>
				  <div class="panel-body">';
	if (isset($viewed_product) && $viewed_product && !empty($viewed_product)){
        foreach ($viewed_product as $key => $value){
        	$img = getThumbnail($value['id'],'45x45');
        	if($img) 
        		$imgsrc =  WebSite.$img; 
        	else 
        		$imgsrc = WebSite.'modules/productviewed/assets/images/no-image-sm.jpg';

        	$output .= '<div class="media">
				          <div class="media-left media-middle">
				            <a href="'. WebSite.'product/'.$value['id'].'">
				              <img class="media-object" src="'.$imgsrc.'" alt="" style="width: 45px;height: 45px;">
				            </a>
				          </div>
				          <div class="media-body">
				            <h5 class="media-heading"><a href="'.WebSite.'product/'.$value['id'].'">'.substr(strip_tags($value['name']),0,15).'...</a></h5>
				            <p>'.substr(htmlspecialchars_decode(strip_tags($value['short_description'])), 0,20).'...</p>
				            <p><a href="'.WebSite.'category/'.$value['id_category_default'].'" >'.l("afficher tous les produits",'productviewed').'</a></p>
				            <p></p>
				          </div>
				        </div>';
        }
    }

	$output .="</div>
			</div>";		  
	echo $output;
}
add_hook('sec_sidebar', 'productviewed', 'productviewed_display', 'Display viewed products');

function productviewed_productdisplay(){
	$pid = pv_getCorrectId($_GET['ID']);
	if ($pid) {
		pv_setViewdProduct(pv_getCorrectId($_GET['ID']));
	}
}
add_hook('sec_top_product', 'productviewed', 'productviewed_productdisplay', 'Display last viewed products');
