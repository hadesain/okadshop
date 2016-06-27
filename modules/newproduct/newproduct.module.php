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
	"config" => "newproduct_settings"
);
$hooks->register_module('newproduct', $data);


require_once 'php/function.php';
global $p_products;
$p_products->add( l("Nouveaux Produits", "newproduct"), '?module=modules&slug=newproduct&page=newproduct_settings' );
function newproduct_display(){
	$new_product = nv_getnewProduct(30,4);
	if (!$new_product || empty($new_product)) {
		return;
	}
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

add_hook('sec_sidebar', 'newproduct', 'newproduct_display', 'Display Futured products');



/**
 *=============================================================
 * LOAD PAGE BY CONDITION
 *=============================================================
 */
if( isset($_GET['slug']) && $_GET['slug'] == 'newproduct' ){

	//we have a page in url !!!
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'newproduct_settings'){
			include 'pages/newproduct_settings.php';
		}
	}

/*============================================================*/
} //END CONDITIONS
/*============================================================*/


function newproduct_displayProduct(){
	global $hooks;
	
  $active = $hooks->select_mete_value('newproduct_active');
  if ($active != "1") {
  	return;
  }
  $new_product_duration = select_mete_value('new_product_duration');
  $nbproduct = $hooks->select_mete_value('newproduct_nbproduct');
  if (!$new_product_duration || !$nbproduct ) {
  	return;
  }
	$condition = "WHERE DATEDIFF(now(),cdate) <= ".$new_product_duration ." ORDER BY reference ASC LiMIT ".$nbproduct;
	$homeProduct = $hooks->select('products',array('*'),$condition);
	$product = new product();
	$homeProduct = $product->oslang_migrate_product($homeProduct,true);
	$output = "";

	if (!$homeProduct || !is_array($homeProduct))
		return;

	$output .= '<div class="home-product product-list">
								<h4>'.l("Nouveautés",'newproduct').'</h4>
							<div class="row padding15">';

		$i=0;
		foreach ($homeProduct as $key => $value){
			$img = getThumbnail($value['id'],'200x200');
			$output .= '<div class="col-xs-6 col-sm-4 col-md-3 paddingleft0">
						  		<div class="product-item">
						  			<div class="box1">
						  				<div class="product_img_container">
						  					<a class="product_image"  href="'.WebSite.'product/'.$value['id'].'-'.$value['permalink'].'">';
			if($img) 
				$src = WebSite.$img; 
			else {
				$src =  themeDir.'images/no-image.jpg';	
			}	 
			$product_p = "";
			$product_btn = '<a l="'.$value['id'].'" t="'.$value['name'].'" q="1" href="#" class="exclusive ajax_add_to_cart_button" idproduct="'.$value['id'].'" p="'.$value['sell_price'].'">'.l("Ajouter au panier", "newproduct").'</a>';
			if (displayPrice()){
  				$product_p ='<div class="product-price">
		  			<p>'.$english_format_number = number_format($value['sell_price'], 2, '.', '').' '.CURRENCY.'</p>
		  		</div>';
  			}

			$output .= '<img src="'.$src.'">
								  			</a>
							  				
							  			</div>
								  		<div class="product_desc">
								  			<p>
								  				'.$value['name'].'</p>
								  			<div class="short-description">'.strip_tags($value['short_description']).'</div>
								  		</div>
						  			</div>
						  			<div class="box2">'.$product_p.'<p class="available">'.l('En stock','newproduct').'</p>
								  		<p class="compare"> 
								  			<input type="checkbox" onclick="checkForComparison(3)" id="comparator_item_1" class="comparator" value="1"> 
								  			<label for="comparator_item_1">'.l('Comparer','newproduct').'</label>
								  		</p>
								  		<div class="btns">
								  			<a class="button" href="'.WebSite.'product/'.$value['id'].'-'.$value['permalink'].'"><i class="fa fa-search"></i></a>
						  					'.$product_btn.'
								  		</div> 
						  			</div>
						  		</div>
						  	</div>';
			}
		$output .= '</div></div>';		

		echo $output;

}
add_hook('sec_home_center_buttom', 'newproduct', 'newproduct_displayProduct', 'Futured products display');