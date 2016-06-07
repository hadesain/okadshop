<?php
//register module infos
global $hooks;
$module_id = dirname(__DIR__);
$data = array(
	"name" => "Futured products",
	"description" => "Futured products.",
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
);
$hooks->register_module('newproduct', $data);


require_once 'php/function.php';
function newproduct_display(){
	$new_product = nv_getnewProduct(30,4);
	$new_product = fixProduct($new_product);
	$output = "";
	$output .= '<div class="panel">
				  <div class="panel-heading">
				    <h3 class="panel-title"><a href="'.WebSite.'views/new-products">'.l("Nouveautés",'newproduct').'</a></h3>
				  </div>
				  <div class="panel-body">';
	if (isset($new_product) && $new_product && !empty($new_product)){
        foreach ($new_product as $key => $value){
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
				            <p>'.substr(strip_tags($value['short_description']), 0,20).'...</p>
				            <p></p>
				          </div>
				        </div>';
        }
    }

	$output .="</div>
			</div>";		  
	echo $output;
}
add_hook('sec_sidebar','newproduct_display', 'Display Futured products');
