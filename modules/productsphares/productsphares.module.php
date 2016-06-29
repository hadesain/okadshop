<?php
if (!defined('_OS_VERSION_'))
  exit;


//register module infos
global $hooks;
$data = array(
	"name" => "Products phares",
	"description" => "Products phares.",
	"author" => "Moullablad",
	"website" => "http://moullablad.com",
	"category" => "front_office_features",
	"version" => "1.0.0",
	"config" => "productsphares_settings"
);
$hooks->register_module('productsphares', $data);


function productsphares_install(){

}

function productsphares_displayProduct(){
	global $hooks;

	$output = "";
	$home_product = $hooks->select('home_product',array('id_product'),' ORDER BY position ASC');
	if ($home_product)
		$home_product_ids = implode(",", array_column( $home_product,'id_product'));
	else
		$home_product_ids = "";
	$homeProduct = array();
	if (!empty($home_product_ids)) {
		$homeProduct = $hooks->select('products',array('*')," WHERE id in ($home_product_ids)");
		$product = new product();
		$homeProduct = $product->oslang_migrate_product($homeProduct,true);
	}
	
	$output .= '<div class="home-product product-list">
								<h4>'.l("NOTRE SÉLECTION",'productsphares').'</h4>
							<div class="row padding15">';
	
	if (isset($homeProduct) && $homeProduct){
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
			/**/
			if (displayAddToCart($value['qty'])){
				$product_btn = '<a l="'.$value['id'].'" t="'.$value['name'].'" q="1" href="#" class="exclusive ajax_add_to_cart_button" idproduct="'.$value['id'].'" p="'.$value['sell_price'].'">'.l("Ajouter au panier", "productsphares").'</a>';
			}else{
				$product_btn = '<a href="'.WebSite.'product/'.$value['id'].'-'.$value['permalink'].'" class="exclusive"> '.l("Voir ce produit",'productsphares').'</a>';
			}
			if (displayPrice()){
  				$product_p ='<div class="product-price">
		  			<p>'.$english_format_number = number_format($value['sell_price'], 2, '.', '').' '.CURRENCY.'</p>
		  		</div>';
		  		/*$product_btn = '<a href="#add_to_quoataion_form" class="exclusive add_to_quoataion_btn" idproduct="'.$value['id'].'">'.l("Ajouter au devis",'productsphares').'</a>';*/
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
						  			<div class="box2">'.$product_p.'<p class="available">'.l('En stock','productsphares').'</p>
								  		<p class="compare"> 
								  			<input type="checkbox" onclick="checkForComparison(3)" id="comparator_item_1" class="comparator" value="1"> 
								  			<label for="comparator_item_1">'.l('Comparer','productsphares').'</label>
								  		</p>
								  		<div class="btns">
								  			<a class="button" href="'.WebSite.'product/'.$value['id'].'-'.$value['permalink'].'"><i class="fa fa-search"></i></a>
						  					'.$product_btn.'
								  		</div> 
						  			</div>
						  		</div>
						  	</div>';
			}
		}
		  $output .= '</div>
										</div>';
/*
		$output .='<div id="add_to_quoataion_form" style="display:none">hello!</div>';		*/			

		echo $output;
	//var_dump($homeProduct);
}
add_hook('sec_home_center_buttom', 'productsphares', 'productsphares_displayProduct', 'Products phares display');


/**
 *=============================================================
 * LOAD PAGE BY CONDITION
 *=============================================================
 */
if( isset($_GET['slug']) && $_GET['slug'] == 'productsphares' ){

	//we have a page in url !!!
	if( isset($_GET['page']) ){
		if( $_GET['page'] == 'productsphares_settings'){
			include 'pages/productsphares_settings.php';
		}
	}

/*============================================================*/
} //END CONDITIONS
/*============================================================*/