<?php
//register module infos
global $hooks;
$module_id = dirname(__DIR__);
$data = array(
	"name" => "Cart Panel",
	"description" => "Cart Panel.",
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "administration",
	"version" => "1.0.0",
);
$hooks->register_module('cartpanel', $data);



function cartpanel_display(){

	$output = "";
	$output .='<!-- cart panel -->
				<div class="panel" id="cart_block">
				  <div class="panel-heading">
				    <h3 class="panel-title">Panier</h3>
				  </div>
				  <div class="panel-body">
				    <div class="expanded" id="cart_block_list">
				      <div id="product-cart-list"></div>
				      <p id="cart_block_no_products" class="hidden">Aucun produit</p>
				      <p id="cart-prices"> 
				        <span>Total</span> 
				        <span class="price ajax_block_cart_total" id="cart_block_total">0,00 €</span>
				      </p>
				      <p id="cart-buttons"> 
				        <a class="button_small" href="'.WebSite.'cart/" title="Panier">Panier</a> 
				        <a class="exclusive" href="'.WebSite.'cart/" id="button_order_cart" title="Commander">Commander</a>
				      </p>
				    </div>
				  </div>
				</div>';
	echo $output;
}
add_hook('sec_sidebar','cartpanel_display', 'display cart panel');
