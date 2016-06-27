<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */
function page_quote(){



//class instance
$os_devis = new OS_Devis();
$os_product = new OS_Product();

//check url for get
$id_quotation = intval( $_GET['id'] );
$id_customer  = intval( $_GET['id_customer'] );
$id_user  		= USER_ID;




//prepare vars
$quotation_status = $os_devis->get_quotation_status_list();
$customers				= $os_devis->get_users_infos_by_type(array('user'));
$employies  			= $os_devis->get_users_infos_by_type(array('admin', 'commercial'));
$carriers   			= $os_devis->get_carriers_list();
$payment_methodes = $os_devis->get_payment_methodes();
$messages  				= $os_devis->get_quotation_messages($id_quotation);

$products   			= $os_product->get_products_list();
$voucher_codes		= $os_product->select('cart_rule', array('code', 'reduction'));

$quotations_list  = "?module=modules&slug=os-quotations&page=quotations";
$module_path 			= "../modules/os-quotations/";
$ajax_url 				= "../modules/os-quotations/ajax/";
$currency_sign		= "€";




//quotation update mode
if( $id_quotation > 0 && $id_customer > 0 ){

	//quote has ordered
	$quote_ordered = $os_product->select('orders', array('id'), "WHERE id_quotation=".$id_quotation." ORDER BY id DESC LIMIT 1");
	$id_order = intval($quote_ordered[0]['id']);


	//get quoattion
	$q = $os_product->get_quotation($id_quotation, $id_customer);

	//quotation infos
	$name = $q['quotation']['name'];
	$quote_name = ($name != "") ? $name : 'Devis_'.$q['customer']['company'];
	$company = ($q['quotation']['company'] != "") ? $q['quotation']['company'] : $q['customer']['company'];
	$address_delivery = $q['quotation']['address_delivery'];
	$voucher_code = $q['quotation']['voucher_code'];
	$more_info = $q['quotation']['more_info'];
	$voucher_value = number_format((float)$q['quotation']['voucher_value'], 2, '.', ''); 
	$global_discount = number_format((float)$q['quotation']['global_discount'], 2, '.', ''); 
	$avoir = number_format((float)$q['quotation']['avoir'], 2, '.', '');

	//total
	$total_products = number_format((float)$q['total']['product_tht'], 2, '.', '');
	$total_ht = number_format((float)$q['total']['tht'], 2, '.', '');
	$global_weight  = floatval($q['total']['weight']);
	$total_purchases = number_format((float)$q['total']['total_purchases'], 2, '.', '');
	$profit_margin = number_format((float)$q['total']['profit_margin'], 2, '.', '');

	//carrier infos
	$shipping_costs = (isset($q['carrier']['shipping_costs'])) ? $q['carrier']['shipping_costs'] : '0.00';

	//customer infos
	$customer_email = $q['customer']['email'];
	$user_group = $q['customer']['user_group'];

}


/*echo '<pre>';
print_r($quote_ordered);
echo '</pre>';*/
?>
<div class="top-menu padding0">
	<div class="top-menu-title">
		<h3>
			<i class="fa fa-pencil-square-o"></i> 
			<?=(isset($id_quotation) && $id_quotation > 0) ? l('Modifier le devis', 'quotation') : l('Créer un devis', 'quotation');?>
		</h3>
	</div>
	<div class="top-menu-button">
    <a href="?module=modules&slug=os-quotations&page=quotations" type="button" class="btn btn-primary"><?=l("Liste des devis", "quotation");?></a>
    <?php if(isset($id_quotation) && $id_quotation > 0) : ?>
  		<a target="_blank" href="<?='../pdf/quotation.php?id_quotation='. $id_quotation .'&id_customer='. $id_customer;?>" class="btn btn-success" title="<?=l("Télécharger en PDF", "quotation");?>"><i class="fa fa-file-pdf-o"></i> <?=l("Télécharger en PDF", "quotation");?></a>
  	<?php endif; ?>
  </div>
</div><br>
<input type="hidden" value="<?=(isset($id_quotation)) ? $id_quotation : '';?>" id="id_quotation">
<input type="hidden" value="<?=(isset($id_customer)) ? $id_customer : '';?>" id="id_customer">

<style>
/*.input-group-btn select {
  line-height: 20px !important;
}*/
.input-group-btn .btn {
	padding: 7px 12px;
}
.refresh_qty {
  padding: 6px 12px !important;
  border-color: #ccc !important;
  border-bottom-color: #ccc !important;
}
</style>

<div class="col-sm-2 col-xs-12 padding0">
	<ul class="nav nav-pills nav-stacked">
		<li class="active"><a data-toggle="pill" href="#products"><?=l("Tableau (Résumé)", "quotation");?></a></li>
		<li><a data-toggle="pill" href="#config"><?=l("Configuration", "quotation");?></a></li>
		<li><a data-toggle="pill" href="#add-product"><?=l("Ajouter un produit", "quotation");?></a></li>
		<li><a data-toggle="pill" href="#promos"><?=l("Promotions", "quotation");?></a></li>
		<li><a data-toggle="pill" href="#carrier"><?=l("Transport", "quotation");?></a></li>
		<li><a data-toggle="pill" href="#terms"><?=l("Conditions de vente", "quotation");?></a></li>
		<li><a data-toggle="pill" href="#infos"><?=l("Informations complémentaires", "quotation");?></a></li>
		<li><a data-toggle="pill" href="#messages"><?=l("Statut et messages", "quotation");?></a></li>
	</ul>
</div><!--/ .col-sm-2 -->	

<div class="col-sm-10 col-xs-12">
	<div class="tab-content">

		<?php if( $id_order > 0 ) : ?>
		<style>
		.nav-pills>li>a, 
		.tab-content .btn
		{
			pointer-events: none;
		}
		</style>
		<div class="alert alert-info">
			<h4><?=l("Commande deja enrigestrer.", "quotation");?></h4>
	  	<a target="_blank" href="?module=orders&action=edit&id=<?=$id_order;?>" class="btn-success btn-xs"><?=l("Voir la commande", "quotation");?></a>
		</div>
		<?php endif; ?>

		<div class="tab-pane active" id="products">
		<?php if(isset($id_quotation) && $id_quotation > 0) : ?>
			<div class="panel panel-default">
				<div class="panel-heading"><?=l("Tableau des Produits", "quotation");?></div>
				<div class="panel-body">
					<table id="quotation_products" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th width="120"><?=l("Produit", "quotation");?></th>
								<th width="120"><?=l("Référence", "quotation");?></th>
								<th><?=l("Description", "quotation");?></th>
								<th width="120"><?=l("Prix unitaire", "quotation");?></th>
								<th width="120"><?=l("Qté", "quotation");?></th>
								<th width="120"><?=l("Prix total", "quotation");?></th>
								<th width="80"><?=l("Disponibilité", "quotation");?></th>
								<th width="95"><?=l("Actions", "quotation");?></th>
							</tr>
						</thead>
						<tbody>
						<?php if( !empty($q['products']) ) : ?>
							<?php foreach ($q['products'] as $key => $product) : ?>
							<tr id="<?=$product['id'];?>">
								<td class="text-center">
									<a href="#" class="pop">
										<?php $file_name = $os_product->get_file_name( $product['product_image'], "80x80" );
										$image_path = '../files/products/'.$product['id_product'].'/'.$file_name;
				  					if( file_exists($image_path) ){
				  						echo "<img class='img-thumbnail' src='".$image_path."' width='80'>";
				  					}else{
				  						echo "<img class='img-thumbnail' src='".$module_path."images/no-image45.png' width='80'>";
				  					}
						  			?>
									</a>
								</td>
								<td class="text-center"><?=$product['product_reference'];?></td>
								<td>
									<strong><a href="?module=products&action=edit&id=<?=$product['id_product'];?>" target="_blank"><?=stripslashes($product['product_name']);?></a></strong>
									<p>
										<?=l("Colisage :", "quotation");?> <?=$product['product_packing'];?> <?=l("unités", "quotation");?><br>
										<?=l("Poids (kg) :", "quotation");?> <?=$product['product_weight'];?><br>
										<?php if( $product['attributs'] != "" ){
											echo "Attributs : ".$product['attributs'];//Attributs quand renseignés 
										} ?>
									</p>
								</td>
								<td class="text-center"><?=$product['product_price'];?></td>
								<td>
									<div class="input-group">
							      <input type="number" min="1" step="1" placeholder="1" class="form-control product_qty" value="<?=$product['product_quantity'];?>">
							      <span class="input-group-btn">
							        <a class="btn btn-default refresh_qty" type="button"><i class="fa fa-refresh"></i></a>
							      </span>
							    </div>
								</td>
								<td class="text-center"><?=$product['total_ht'];?></td>
								<td class="text-center"><?=$product['product_stock'];?></td>
								<td class="text-center">
					      	<a href="javascript:;" class="btn btn-default update" title="<?=l("Mettre à jour", "quotation");?>">
					      		<i class="fa fa-pencil"></i>
					      	</a>
					      	<a href="javascript:;" class="btn btn-danger delete" title="<?=l("Supprimer ce produit", "quotation");?>">
					      		<i class="fa fa-trash"></i>
					      	</a>
					      </td>
							</tr>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>

					

					<div class="col-sm-4 col-xs-12 pull-right padding0">
						<table class="table table-striped table-bordered" id="quotation_total">
							<tbody>
								<tr>
									<th width="150"><?=l("Total produits HT", "quotation");?></th>
									<td><span class="total_products"><?=$total_products;?></span></td>
								</tr>
								<?php if( $global_discount > 0 ) : ?>
								<tr>
									<th width="150"><?=l("Remise globale", "quotation");?></th>
									<td><span class="discount"><?=$global_discount;?></span></td>
								</tr>
								<?php endif; ?>
								<?php if( $voucher_value > 0 ) : ?>
								<tr>
									<th width="150"><?=l("Bon de réduction", "quotation");?></th>
									<td><span class="reduction"><?=$voucher_value;?></span></td>
								</tr>
								<?php endif; ?>
								<?php if( $avoir > 0 ) : ?>
								<tr>
									<th width="150"><?=l("Avoir", "quotation");?></th>
									<td><span class="avoir"><?=$avoir;?></span></td>
								</tr>
								<?php endif; ?>
								<?php if( $voucher_code != "" ) : ?>
								<tr>
									<th width="150"><?=l("Code promo", "quotation");?></th>
									<td><span class="code"><?=$voucher_code;?></span></td>
								</tr>
								<?php endif; ?>
								<tr>
									<th width="150"><?=l("Frais de transport", "quotation");?></th>
									<td><span class="shipping"><?=$shipping_costs;?></span></td>
								</tr>
								<tr>
									<th width="150"><?=l("TOTAL HT", "quotation");?></th>
									<td><span class="tht"><?=$total_ht;?></span></td>
								</tr>
								<!--tr>
									<th width="150">Acompte</th>
									<td><span class="acompte"></span></td>
								</tr>
								<tr>
									<th width="150">Solde</th>
									<td><span class="solde"></span></td>
								</tr-->
								<tr>
									<th width="150"><?=l("Poids total", "quotation");?></th>
									<td><span class="weight"><?=$global_weight;?></span></td>
								</tr>
							</tbody>
						</table>
					</div><!--/ .col-sm-3 -->


					<div class="col-xs-12">
						<h4><?=l("CLIENT", "quotation");?></h4>
						<table id="quotation_customer">
							<tr>
								<th width="140"><?=l("Nom / Prénom", "quotation");?></th>
								<td>: <?=(isset($q['customer'])) ? $q['customer']['first_name'].' '.$q['customer']['last_name'] : '';?></td>
							</tr>
							<tr>
								<th><?=l("Société", "quotation");?></th>
								<td class="company">: <?=$company;?></td>
							</tr>
							<tr>
								<th align="top"><?=l("Adresse de livraison", "quotation");?></th>
								<td>: <?=$address_delivery;?></td>
							</tr>
							<tr>
								<th><?=l("Statut du client", "quotation");?></th>
								<td>: <span class="label label-success"><?=$user_group;?></span></td>
							</tr>
						</table><br>
						<?php if( $more_info != "" ) : ?>
						<center>
							<textarea cols="125" rows="5"><?=$more_info;?></textarea>
						</center>
						<?php endif; ?>
					</div>

				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<a href="<?=$quotations_list;?>" class="btn btn-default"><?=l("Annuler", "quotation");?></a>
					<button class="btn btn-primary pull-right" onclick="next_tab('config')"><?=l("Suivant", "quotation");?></button>
					<!--input type="submit" class="btn btn-success pull-right" value="Sauvegarder et rester"-->
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->
		<?php else: ?>
		<div class="alert alert-info">
			<h4><?=l("Il y a 1 avertissement.", "quotation");?></h4>
			<?=l("Vous devez enregistrer ce devis avant de consulter les produits.", "quotation");?>
		</div>
		<?php endif; ?>
		</div><!--/ .tab-pane -->

		<div class="tab-pane" id="config">
			<div class="panel panel-default">
			<form class="form-horizontal" id="config_form" method="post" action="<?=$ajax_url;?>form/config.php">
			<input type="hidden" value="<?=(isset($id_quotation)) ? $id_quotation : '';?>" name="id_quotation" id="id_quotation">
			<input type="hidden" value="<?=$customer_email?>" id="customer_email">
				<div class="panel-heading"><?=l("Configuration", "quotation");?></div>
				<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="quote_number"><?=l("N° de devis", "quotation");?></label>  
							<div class="col-sm-4">
								<input type="text" id="quote_number" class="form-control" value="<?=(isset($id_quotation)) ? $id_quotation : '';?>" disabled>
							</div>
						</div>
						<!--div class="form-group">
	            <label class="col-sm-3 control-label" for="reference">Référence du devis</label> 
	            <div class="col-sm-4">
	              <div class="input-group">
	              	<input id="reference" name="reference" type="text" class="form-control" value="<?//=(isset($q['quotation']['reference'])) ? $q['quotation']['reference'] : '';?>" required>
	                <span class="input-group-btn">
	                  <a href="javascript:gencode(8, '#reference');" class="btn btn-default" style="padding: 6px 12px;border-color: #ccc;border-bottom-color: #ccc;"><i class="fa fa-random"></i> Générer</a>
	                </span>
	              </div>
	            </div>
	          </div-->
						<div class="form-group" style="margin-bottom:5px;">
							<label class="col-sm-3 control-label" for="id_state"><?=l("Statut du devis", "quotation");?></label>  
							<div class="col-sm-4">
								<div class="input-group">
						      <select name="id_state" class="form-control" id="id_state">
										<?php foreach ($quotation_status as $key => $value) : ?>
				            	<option value="<?php echo $value['id'];?>" <?=( isset($q['quotation']['id_state']) && $q['quotation']['id_state'] == $value['id'] ) ? 'selected' : '';?>>
				            		<?php echo $value['name'];?>
				            	</option>
				            <?php endforeach;?>
				          </select>
						      <span class="input-group-btn">
						        <a class="btn btn-primary refresh_state" type="button"><i class="fa fa-send-o"></i> <?=l("Valider", "quotation");?></a>
						      </span>
						    </div>
						  </div>
						</div>
						<div class="form-group hidden" id="register_order">
							<div class="col-sm-3 col-sm-offset-3">
					    	<a class="btn btn-success btn-block"><?=l("Valider la Commande", "quotation");?></a>
					 		</div>
					  </div>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-3">
								<label>
									<input type="checkbox" id="send_state_email" value="1">
									<?=l("Envoi d'un mail au client à propos de ce statut.", "quotation");?>
								</label>
								<small><?=l("Si activé, une alert sera envoyé au client sur le statut du devis sélectionné; utile pour informer celui-ci sur les changements de statuts de son devis.", "quotation");?></small>
							</div>
						</div>
						<div class="form-group">
	            <label class="col-sm-3 control-label" for="name"><?=l("Nom du devis", "quotation");?></label>  
	            <div class="col-sm-4">
	              <div class="input-group">
	              	<input id="name" name="name" type="text" class="form-control" value="<?=$quote_name;?>" required>
	                <span class="input-group-btn">
	                  <a class="btn btn-default gen_name" style="padding: 6px 12px;border-color: #ccc;border-bottom-color: #ccc;"><i class="fa fa-random"></i> <?=l("Générer", "quotation");?></a>
	                </span>
	              </div>
	            </div>
	          </div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="id_customer"><?=l("Client", "quotation");?></label>  
							<div class="col-sm-4">
								<?php if( isset($id_quotation) && $id_quotation > 1 ) : ?>
									<input id="customer_name" type="text" value="<?= $q['customer']['first_name'] .' '. $q['customer']['last_name'];?>" class="form-control" disabled>
								<?php else : ?>
								<select name="id_customer" class="form-control">
									<?php foreach ($customers as $key => $value) : ?>
			            	<option value="<?php echo $value['id'];?>" <?=( isset($q['quotation']['id_customer']) && $q['quotation']['id_customer'] == $value['id'] ) ? 'selected' : '';?>>
			            		<?php echo $value['first_name'].' '.$value['last_name'];?>
			            	</option>
			            <?php endforeach;?>
			          </select>
			        <?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="company"><?=l("Société", "quotation");?></label>  
							<div class="col-sm-4">
								<input id="company" name="company" type="text" class="form-control" value="<?=$company;?>">
							</div>
						</div>
						<!--div class="form-group">
							<label class="col-sm-3 control-label" for="no"><?//=l("N° de", "quotation");?></label>  
							<div class="col-sm-4">
								<input id="no" name="no" type="text" class="form-control" value="<?//=(isset($q['no'])) ? $q['no'] : '';?>">
							</div>
						</div-->
						<div class="form-group">
							<label class="col-sm-3 control-label" for="address_invoice"><?=l("Adresse de facturation", "quotation");?></label>  
							<div class="col-sm-6">
								<input id="address_invoice" name="address_invoice" type="text" class="form-control" value="<?=(isset($q['quotation']['address_invoice'])) ? $q['quotation']['address_invoice'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="address_delivery"><?=l("Adresse de livraison", "quotation");?></label>  
							<div class="col-sm-6">
								<input id="address_delivery" name="address_delivery" type="text" class="form-control" value="<?=(isset($q['quotation']['address_delivery'])) ? $q['quotation']['address_delivery'] : '';?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="customer_state"><?=l("Statut du client", "quotation");?></label>  
							<div class="col-sm-4">
								<div class="input-group">
									<input id="customer_state" type="text" class="form-control" value="<?=$user_group;?>" disabled>
						      <span class="input-group-btn">
						        <a class="btn btn-primary" href="?module=Users&action=edit&id=<?=$q['customer']['id'];?>" target="_blank"><i class="fa fa-eye"></i> <?=l("Consulter", "quotation");?></a>
						      </span>
						    </div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="id_employee"><?=l("Lier à cet employé", "quotation");?></label>  
							<div class="col-sm-4">
								<select name="id_employee" class="form-control">
									<?php foreach ($employies as $key => $value) : ?>
			            	<option value="<?php echo $value['id'];?>" <?=( isset($q['quotation']['id_employee']) && $q['quotation']['id_employee'] == $value['id'] ) ? 'selected' : '';?>>
			            		<?php echo $value['first_name'].' '.$value['last_name'];?>
			            	</option>
			            <?php endforeach;?>
			          </select>
							</div>
						</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<a href="<?=$quotations_list;?>" class="btn btn-default"><?=l("Annuler", "quotation");?></a>
					<span class="pull-right">
						<input type="submit" name="" class="btn btn-success" value="<?=l("Sauvegarder et rester", "quotation");?>">
						<button class="btn btn-primary" onclick="next_tab('add-product')"><?=l("Suivant", "quotation");?></button>
					</span>
				</div><!--/ .panel-footer -->
			</form><!--/ form -->
			</div><!--/ .panel -->
		</div><!--/ .tab-pane -->

		<div class="tab-pane" id="add-product">
		<?php if(isset($id_quotation) && $id_quotation > 0) : ?>
			<div class="panel panel-default">
			<form class="form-horizontal" id="product_form" method="post" action="<?=$ajax_url;?>form/product.php">
				<div class="panel-heading"><?=l("Ajouter un produit", "quotation");?></div>
				<div class="panel-body">
					<input type="hidden" value="<?=$id_quotation;?>" name="id_quotation" id="id_quotation">
					<input type="hidden" value="" name="id_product" id="id_product">
					<input type="hidden" value="" name="id_declinaisons" id="id_declinaisons">
					<input type="hidden" value="" name="id_detail" id="id_detail">
					
					<div class="form-group">
						<label class="col-sm-3 control-label" for="based_product"><?=l("Nom du produit", "quotation");?></label>  
						<div class="col-sm-4">
							<select class="form-control" id="based_product"><!-- chosen -->
								<option value="" selected><?=l("Sélectionnez un produit", "quotation");?></option>
								<?php foreach ($products as $key => $value) : ?>
		            	<option value="<?php echo $value['id'];?>">
		            		<?php echo $value['name'];?>
		            	</option>
		            <?php endforeach;?>
		          </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="based_attributs"><?=l("Attributs", "quotation");?></label>  
						<div class="col-sm-4">
							<select class="form-control" id="based_attributs">
								<option value="" selected><?=l("Sélectionnez une attribut", "quotation");?></option>
							</select>
							<input type="hidden" value="" name="attributs" id="attributs">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3">
							<a href="javascript:;" class="btn btn-primary" id="load_product_infos" style="margin-left: 16px;"><?=l("Charger les informations de ce produit", "quotation");?></a>
							<a href="javascript:;" class="btn btn-danger" id="reset_product_infos"><?=l("Réinialiser", "quotation");?></a>
						</div>
					</div>
					<div class="form-group">
            <label class="col-sm-3 control-label" for="name"><?=l("Référence", "quotation");?></label>  
            <div class="col-sm-4">
              <div class="input-group">
              	<input name="product_reference" type="text" value="" class="form-control" id="product_reference" required>
                <span class="input-group-btn">
                	<a href="javascript:gencode(10, '#product_reference');" class="btn btn-default" style="padding: 6px 12px;border-color: #ccc;border-bottom-color: #ccc;"><i class="fa fa-random"></i> <?=l("Générer", "quotation");?></a>
                </span>
              </div>
            </div>
            <div class="col-sm-3 col-sm-offset-2 col-xs-12">
							<span id="product_img" style="position: absolute;">
								<img class="img-thumbnail" src="<?=$module_path.'images/no-image360.png';?>" width="180">
							</span>
						</div>
          </div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_name"><?=l("Nom du produit", "quotation");?></label>  
						<div class="col-sm-4">
							<input name="product_name" type="text" value="" class="form-control" id="product_name" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="filer_input"><?=l("Image du produit", "quotation");?></label>  
						<div class="col-sm-4">
		        	<input type="file" name="product_image" id="filer_input">
		        	<input type="hidden" value="" name="product_image" id="product_image">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_packing"><?=l("Colisage", "quotation");?></label>  
						<div class="col-sm-4">
							<input name="product_packing" type="number" min="0" step="1" placeholder="0" value="" class="form-control" id="product_packing">
						</div>
					</div><hr>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_min_quantity"><?=l("Quantité minimale", "quotation");?></label>  
						<div class="col-sm-4">
							<input name="product_min_quantity" type="number" min="1" step="1" placeholder="1" value="" class="form-control" id="product_min_quantity">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_quantity"><?=l("Quantité commandée", "quotation");?></label>  
						<div class="col-sm-4">
							<input name="product_quantity" type="number" min="1" step="1" placeholder="1" value="" class="form-control" id="product_quantity" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_stock"><?=l("Quantité disponible en stock", "quotation");?></label>  
						<div class="col-sm-4">
							<input name="product_stock" type="number" min="1" step="1" placeholder="1" value="" class="form-control" id="product_stock">
						</div>
					</div><hr>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_price"><?=l("Prix de vente de base", "quotation");?></label>  
						<div class="col-sm-4">
							<input name="product_price" type="number" min="0" step="0.01" placeholder="0.00" value="" class="form-control" id="product_price" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="discount"><?=l("Prix de vente remisé", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="text" placeholder="0.00" value="" class="form-control" id="discount" disabled>
							<input type="hidden" value="" class="form-control" id="product_discount">
						</div>
					</div>
					<div class="form-group hidden" id="hidden_buyprice">
						<label class="col-sm-3 control-label" for="product_buyprice"><?=l("Prix d’achat unitaire", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="number" step="0.01" min="0" name="product_buyprice" placeholder="0.00" value="" class="form-control" id="product_buyprice">
						</div>²
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="loyalty_points"><?=l("Points de fidélité", "quotation");?></label>  
						<div class="col-sm-4">
							<input id="loyalty_points" name="loyalty_points" type="number" min="0" step="1" placeholder="0" class="form-control" value="">
						</div>
					</div><hr>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_weight"><?=l("Poids", "quotation");?></label>  
						<div class="col-sm-4">
							<div class="input-group">
								<input name="product_weight" type="number" min="0" step="0.01" placeholder="0.00" value="" class="form-control" id="product_weight" required>
								<span class="input-group-addon"><?=l("KG", "quotation");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_height"><?=l("Hauteur", "quotation");?></label>  
						<div class="col-sm-4">
							<div class="input-group">
								<input name="product_height" type="number" min="0" step="0.01" placeholder="0.00" value="" class="form-control" id="product_height">
								<span class="input-group-addon"><?=l("CM", "quotation");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_width"><?=l("Largeur", "quotation");?></label>  
						<div class="col-sm-4">
							<div class="input-group">
								<input name="product_width" type="number" min="0" step="0.01" placeholder="0.00" value="" class="form-control" id="product_width">
								<span class="input-group-addon"><?=l("CM", "quotation");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="product_depth"><?=l("Profondeur", "quotation");?></label>  
						<div class="col-sm-4">
							<div class="input-group">
								<input name="product_depth" type="number" min="0" step="0.01" placeholder="0.00" value="" class="form-control" id="product_depth">
								<span class="input-group-addon"><?=l("m", "quotation");?></span>
							</div>
						</div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<a href="<?=$quotations_list;?>" class="btn btn-default"><?=l("Annuler", "quotation");?></a>
					<span class="pull-right">
						<input type="submit" name="" class="btn btn-success" value="<?=l("Sauvegarder et rester", "quotation");?>">
						<button class="btn btn-primary" onclick="next_tab('promos')"><?=l("Suivant", "quotation");?></button>
					</span>
				</div><!--/ .panel-footer -->
			</form><!--/ form -->
			</div><!--/ .panel -->
		<?php else: ?>
		<div class="alert alert-info">
			<h4><?=l("Il y a 1 avertissement.", "quotation");?></h4>
			<?=l("Vous devez enregistrer ce devis avant d'ajouter des produits.", "quotation");?>
		</div>
		<?php endif; ?>
		</div><!--/ .tab-pane -->

		<div class="tab-pane" id="promos">
		<?php if(isset($id_quotation) && $id_quotation > 0) : ?>
			<div class="panel panel-default">
			<form class="form-horizontal" id="promos_form" method="post" action="<?=$ajax_url;?>form/promos.php">
			<input type="hidden" value="<?=$id_quotation;?>" name="id_quotation" id="id_quotation">
				<div class="panel-heading"><?=l("Promotions", "quotation");?></div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label"><?=l("Total achats", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="text" value="<?=$total_purchases;?>" class="form-control" id="total_purchases" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?=l("Marge bénéficiaire estimée", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="text" value="<?=$profit_margin;?>" class="form-control" id="profit_margin" disabled>
						</div>	
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="loyalty_points"><?=l("Points de fidélité", "quotation");?></label>  
						<div class="col-sm-2">
							<div class="input-group">
					      <input id="loyalty_points" name="loyalty_points" placeholder="0" type="number" min="0" step="1" class="form-control" value="<?=(isset($q['quotation']['loyalty_points'])) ? $q['quotation']['loyalty_points'] : '0';?>" required>
					      <span class="input-group-btn">
					        <select class="btn loyalty_state">
					          <option value="0" selected><?=l("Activer", "quotation");?></option>
					          <option value="1"><?=l("Désactiver", "quotation");?></option>
					        </select>
					      </span>
					    </div>
						</div>
						<div class="col-sm-2 padding0">
							<div class="input-group">
								<span class="input-group-addon"><?=l("1 points", "quotation");?></span>
								<input id="loyalty_value" name="loyalty_value" placeholder="0" type="number" min="0" step="0.01" class="form-control" value="<?=(isset($q['quotation']['loyalty_value'])) ? $q['quotation']['loyalty_value'] : '0';?>">
								<span class="input-group-addon"><?=$currency_sign;?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="global_discount"><?=l("Remise globale", "quotation");?></label>  
						<div class="col-sm-4">
							<div class="input-group">
					      <input type="number" name="global_discount" id="global_discount" min="0" step="0.01" value="<?=(isset($q['quotation']['global_discount'])) ? $q['quotation']['global_discount'] : '0.00';?>" class="form-control">
					      <span class="input-group-btn">
					        <select name="discount_type" id="discount_type" class="btn btn-primary" style="padding: 8px 12px;">
					          <option value="0" selected="">%</option>
					          <option value="1"><?=$currency_sign;?></option>
					        </select>
					      </span>
					    </div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="voucher_value"><?=l("Bon de réduction", "quotation");?></label>  
						<div class="col-sm-2">
							<select name="voucher_code" id="voucher_code" class="form-control">
								<option value=""><?=l("Sélectionnez un code", "quotation");?></option>
								<?php if( !empty($voucher_codes) ) : ?>
									<?php foreach ($voucher_codes as $key => $code) : ?>
			            	<option value="<?=$code['code'];?>" data-red="<?=$code['reduction'];?>" <?=( $voucher_code == $code['code'] ) ? 'selected' : '';?>><?=$code['code'];?></option>
			            <?php endforeach;?>
			          <?php endif; ?>
		          </select>
						</div>
						<div class="col-sm-2 padding0">
							<div class="input-group">
					      <input type="number" name="voucher_value" id="voucher_value" min="0" step="0.01" value="<?=$voucher_value;?>" class="form-control">
					      <span class="input-group-btn">
					        <select name="voucher_type" id="voucher_type" class="btn btn-primary" style="padding: 8px 12px;">
					          <option value="0" selected="">%</option>
					          <option value="1" <?=($q['quotation']['voucher_type']=="1") ? 'selected' : '';?>><?=$currency_sign;?></option>
					        </select>
					      </span>
					    </div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="avoir"><?=l("Avoir", "quotation");?></label>  
						<div class="col-sm-4">
							<div class="input-group">
								<input type="number" name="avoir" id="avoir" min="0" step="0.01" value="<?=(isset($q['quotation']['avoir'])) ? $q['quotation']['avoir'] : '0.00';?>" class="form-control">
								<span class="input-group-addon"><?=$currency_sign;?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="total_saved"><?=l("Total économisé", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="number" name="total_saved" id="total_saved" min="0" step="0.01" value="<?=(isset($q['quotation']['total_saved'])) ? $q['quotation']['total_saved'] : '0.00';?>" class="form-control">
						</div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<a href="<?=$quotations_list;?>" class="btn btn-default"><?=l("Annuler", "quotation");?></a>
					<span class="pull-right">
						<input type="submit" name="" class="btn btn-success" value="<?=l("Sauvegarder et rester", "quotation");?>">
						<button class="btn btn-primary" onclick="next_tab('carrier')"><?=l("Suivant", "quotation");?></button>
					</span>
				</div><!--/ .panel-footer -->
			</form>
			</div><!--/ .panel -->
		<?php else: ?>
		<div class="alert alert-info">
			<h4><?=l("Il y a 1 avertissement.", "quotation");?></h4>
			<?=l("Vous devez enregistrer ce devis avant d'ajouter des promostions.", "quotation");?>
		</div>
		<?php endif; ?>
		</div><!--/ .tab-pane -->

		<div class="tab-pane" id="carrier">
		<?php if(isset($id_quotation) && $id_quotation > 0) : ?>
			<div class="panel panel-default">
			<form class="form-horizontal" id="carrier_form" method="post" action="<?=$ajax_url;?>form/carrier.php">
			<input type="hidden" value="<?=$id_quotation;?>" name="id_quotation" id="id_quotation">
				<input type="hidden" value="<?=$q['carrier']['id'];?>" name="id_quotation_carrier">
				<div class="panel-heading"><?=l("Transport", "quotation");?></div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label"><?=l("Formule", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="text" value="<?=(isset($q['quotation']['carrier_type'])) ? $q['quotation']['carrier_type'] : '';?>" class="form-control" id="formule" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?=l("Poids total hors emballage", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="text" value="<?=$global_weight?>" class="form-control" id="global_weight" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?=l("Pays", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="text" value="<?=(isset($q['customer']['user_country'])) ? $q['customer']['user_country'] : '';?>" class="form-control" id="country" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="based_carrier"><?=l("Transporteur", "quotation");?></label>  
						<div class="col-sm-4">
	            <select name="id_carrier" class="form-control" id="based_carrier" required>
	            	<option value=""><?=l("Sélectionnez un Transport", "quotation");?></option>
								<?php foreach ($carriers as $key => $carrier) : ?>
		            	<option data-min="<?=$carrier['min'];?>" data-max="<?=$carrier['max'];?>" value="<?=$carrier['id'];?>" <?=( isset($q['carrier']['id_carrier']) && $q['carrier']['id_carrier'] == $carrier['id'] ) ? 'selected' : '';?>><?=$carrier['name'];?></option>
		            <?php endforeach;?>
		            <option value="0" <?=($q['carrier']['id_carrier'] === "0" && $q['carrier']['carrier_name'] != "") ? 'selected' : '';?>>Autre</option>
		          </select>
						</div>
					</div>
					<div class="form-group hidden">
						<label class="col-md-3 control-label" for="carrier_name"><?=l("Nom de Transporteur", "quotation");?></label>  
						<div class="col-sm-4">
							<input type="text" name="carrier_name" id="carrier_name" class="form-control" value="<?=(isset($q['carrier']['carrier_name'])) ? $q['carrier']['carrier_name'] : '';?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="shipping_costs"><?=l("Frais de transport", "quotation");?></label>  
						<div class="col-sm-4">
							<input id="shipping_costs" name="shipping_costs" type="number" min="0" step="0.01" placeholder="0.00" class="form-control" required="" value="<?=$shipping_costs;?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=l("Délai de livraison", "quotation");?></label>
						<div class="col-sm-2 right0">
							<div class="input-group">
								<span class="input-group-addon"><?=l("Entre", "quotation");?></span>
								<input class="form-control" type="number" id="min_delay" name="min_delay" value="<?=(isset($q['carrier']['min_delay'])) ? $q['carrier']['min_delay'] : '';?>" placeholder="min" required>
							</div>
						</div>
						<div class="col-sm-2 left0 right0">
							<div class="input-group" style="left:-2px;">
								<span class="input-group-addon"><?=l("Et", "quotation");?></span>
								<input class="form-control" type="number" id="max_delay" name="max_delay" value="<?=(isset($q['carrier']['max_delay'])) ? $q['carrier']['max_delay'] : '';?>" placeholder="max" required>
							</div>
						</div>
						<div class="col-sm-2 left0" style="left:-4px;">
							<select name="delay_type" id="delay_type" class="form-control" style="width: auto;">
			          <option value="0" selected=""><?=l("Jours", "quotation");?></option>
			          <option value="1" <?=(isset($q['carrier']['delay_type']) && $q['carrier']['delay_type']=="1") ? 'selected' : '';?>><?=l("Semaines", "quotation");?></option>
			        </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=l("Délai de préparation", "quotation");?></label>
						<div class="col-sm-2 right0">
							<div class="input-group">
								<span class="input-group-addon"><?=l("Entre", "quotation");?></span>
								<input class="form-control" type="number" id="min_prepa" name="min_prepa" value="<?=(isset($q['carrier']['min_prepa'])) ? $q['carrier']['min_prepa'] : '';?>" placeholder="min" required>
							</div>
						</div>
						<div class="col-sm-2 left0 right0">
							<div class="input-group" style="left:-2px;">
								<span class="input-group-addon"><?=l("Et", "quotation");?></span>
								<input class="form-control" type="number" id="max_prepa" name="max_prepa" value="<?=(isset($q['carrier']['max_prepa'])) ? $q['carrier']['max_prepa'] : '';?>" placeholder="max" required>
							</div>
						</div>
						<div class="col-sm-2 left0" style="left:-4px;">
							<select name="delay_type" id="prepa_type" class="form-control" style="width: auto;">
			          <option value="0" selected=""><?=l("Jours", "quotation");?></option>
			          <option value="1" <?=(isset($q['carrier']['delay_type']) && $q['carrier']['delay_type']=="1") ? 'selected' : '';?>><?=l("Semaines", "quotation");?></option>
			        </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="weight_including_packing"><?=l("Poids total estimé emballage compris", "quotation");?></label>  
						<div class="col-sm-4">
							<div class="input-group">
								<input id="weight_including_packing" name="weight_including_packing" type="number" min="0" step="0.01" placeholder="0.00" class="form-control" required="" value="<?=(isset($q['carrier']['weight_including_packing'])) ? $q['carrier']['weight_including_packing'] : '0.00';?>">
								<span class="input-group-addon"><?=l("Kg", "quotation");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="number_packages"><?=l("Nombre de colis estimé", "quotation");?></label>  
						<div class="col-sm-4">
							<input id="number_packages" name="number_packages" type="number" min="0" step="1" placeholder="1" class="form-control" required="" value="<?=(isset($q['carrier']['number_packages'])) ? $q['carrier']['number_packages'] : '0';?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="more_info"><?=l("Informations complémentaires", "quotation");?></label>  
						<div class="col-sm-6">
							<textarea name="more_info" id="more_info" class="form-control summernote"><?=(isset($q['carrier']['more_info'])) ? $q['carrier']['more_info'] : '';?></textarea>
						</div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<a href="<?=$quotations_list;?>" class="btn btn-default"><?=l("Annuler", "quotation");?></a>
					<span class="pull-right">
						<input type="submit" name="" class="btn btn-success" value="<?=l("Sauvegarder et rester", "quotation");?>">
						<button class="btn btn-primary" onclick="next_tab('terms')"><?=l("Suivant", "quotation");?></button>
					</span>
				</div><!--/ .panel-footer -->
			</form>
			</div><!--/ .panel -->
		<?php else: ?>
		<div class="alert alert-info">
			<h4><?=l("Il y a 1 avertissement.", "quotation");?></h4>
			<?=l("Vous devez enregistrer ce devis avant de modifier le transporteur.", "quotation");?>
		</div>
		<?php endif; ?>
		</div><!--/ .tab-pane -->

		<div class="tab-pane" id="terms">
		<?php if(isset($id_quotation) && $id_quotation > 0) : ?>
			<div class="panel panel-default">
			<form class="form-horizontal" id="terms_form" method="post" action="<?=$ajax_url;?>form/terms.php">
			<input type="hidden" value="<?=$id_quotation;?>" name="id_quotation" id="id_quotation">
				<div class="panel-heading"><?=l("Conditions de vente", "quotation");?></div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label" for="total_letters"><?=l("Montant total du devis", "quotation");?></label>  
						<div class="col-md-4">
							<input id="total_letters" name="total_letters" type="text" class="form-control" required value="<?=(isset($q['quotation']['total_letters'])) ? $q['quotation']['total_letters'] : '';?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="total_letters"><?=l("Mode de règlement acceptés", "quotation");?></label>  
						<div class="col-md-4">
							<ul style="margin-bottom:0px;">
							<?php 
							$array = explode(",", $q['quotation']['payment_choice']);
							foreach ($payment_methodes as $key => $payment) : ?>
								<li><label><input <?=( in_array($payment['id'], $array) ) ? "checked" : "";?> id="<?=$payment['id'];?>" value="<?=$payment['id'];?>" type="checkbox" name="payment_choice[]"><?=$payment['value'];?></label></li>
			        <?php endforeach;?>
							</ul>							
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="id_payment_method"><?=l("Modalités de règlement", "quotation");?></label>  
						<div class="col-md-4">
							<select name="id_payment_method" class="form-control">
								<?php foreach ($payment_methodes as $key => $method) : ?>
		            	<option value="<?php echo $method['id'];?>" <?=( isset($q['quotation']['id_payment_method']) && $q['quotation']['id_payment_method'] == $method['id'] ) ? 'selected' : '';?>><?php echo $method['value'];?></option>
		            <?php endforeach;?>
		          </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="datepicker"><?=l("Devis fait le", "quotation");?></label>  
						<div class="col-sm-8">
							<div class="input-group col-sm-4">
							  <input type="text" value="<?=(isset($q['quotation']['cdate'])) ? $q['quotation']['cdate'] : '0000-00-00';?>" class="form-control" id="cdate" disabled>
							  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="datepicker"><?=l("Devis valable jusqu’au", "quotation");?></label>  
						<div class="col-sm-8">
							<div class="input-group col-sm-4">
							  <input type="text" value="<?=(isset($q['quotation']['expiration_date'])) ? $q['quotation']['expiration_date'] : '0000-00-00';?>" name="expiration_date" class="form-control datepicker" id="expiration_date">
							  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="can_be_ordered"><?=l("Ce devis peut être commandé", "quotation");?></label>  
						<div class="col-sm-6">
							<div class="input-group col-sm-4">
							  <input type="number" value="<?=(isset($q['quotation']['can_be_ordered']) && $q['quotation']['can_be_ordered'] != "0") ? $q['quotation']['can_be_ordered'] : '1';?>" min="1" name="can_be_ordered" placeholder="1" class="form-control" id="can_be_ordered">
							  <span class="input-group-addon"><?=l("fois", "quotation");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="more_info"><?=l("Informations complémentaires", "quotation");?></label>  
						<div class="col-md-7">
							<textarea id="more_info" rows="5" name="more_info" type="text" class="form-control summernote"><?=(isset($q['quotation']['more_info'])) ? $q['quotation']['more_info'] : '';?></textarea>
						</div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<a href="<?=$quotations_list;?>" class="btn btn-default"><?=l("Annuler", "quotation");?></a>
					<span class="pull-right">
						<input type="submit" name="" class="btn btn-success" value="<?=l("Sauvegarder et rester", "quotation");?>">
						<button class="btn btn-primary" onclick="next_tab('infos')"><?=l("Suivant", "quotation");?></button>
					</span>
				</div><!--/ .panel-footer -->
			</form>
			</div><!--/ .panel -->
		<?php else: ?>
		<div class="alert alert-info">
			<h4><?=l("Il y a 1 avertissement.", "quotation");?></h4>
			<?=l("Vous devez enregistrer ce devis avant de modifier les conditions de vente.", "quotation");?>
		</div>
		<?php endif; ?>
		</div><!--/ .tab-pane -->

		<div class="tab-pane" id="infos">
		<?php if(isset($id_quotation) && $id_quotation > 0) : ?>
			<form class="form-horizontal" id="informations_form" method="post" action="<?=$ajax_url;?>form/informations.php">
			<div class="panel panel-default">
				<div class="panel-heading"><?=l("Informations complémentaires", "quotation");?></div>
				<div class="panel-body">
					<input type="hidden" value="<?=$id_quotation;?>" name="id_quotation" id="id_quotation">
					<div class="form-group">
						<label class="col-md-2 control-label" for="informations"><?=l("Informations", "quotation");?></label>  
						<div class="col-sm-8">
							<textarea name="informations" id="informations" class="form-control summernote"><?=(isset($q['quotation']['informations'])) ? $q['quotation']['informations'] : '';?></textarea>
						</div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<a href="<?=$quotations_list;?>" class="btn btn-default"><?=l("Annuler", "quotation");?></a>
					<span class="pull-right">
						<input type="submit" name="" class="btn btn-success" value="<?=l("Sauvegarder et rester", "quotation");?>">
						<button class="btn btn-primary" onclick="next_tab('messages')"><?=l("Suivant", "quotation");?></button>
					</span>
				</div><!--/ .panel-footer -->
				</form>
			</div><!--/ .panel -->
		<?php else: ?>
		<div class="alert alert-info">
			<h4><?=l("Il y a 1 avertissement.", "quotation");?></h4>
			<?=l("Vous devez enregistrer ce devis avant de modifier les informations complémentaires.", "quotation");?>
		</div>
		<?php endif; ?>
		</div><!--/ .tab-pane -->

		<div class="tab-pane" id="messages">
		<?php if(isset($id_quotation) && $id_quotation > 0) : ?>
			<div class="panel panel-default">
			<form class="form-horizontal" id="messages_form" method="post" action="<?=$ajax_url;?>form/messages.php">
			<input type="hidden" value="<?=$id_quotation;?>" name="id_quotation" id="id_quotation">
			<input type="hidden" value="<?=$id_user;?>" name="id_sender" id="id_sender">
			<input type="hidden" value="<?=$id_customer;?>" name="id_receiver" id="id_receiver">

				<div class="panel-heading"><?=l("Statut et messages", "quotation");?></div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label" for="recipient_emails"><?=l("E-mail(s) de(s) destinataire(s)", "quotation");?></label>  
						<div class="col-sm-6">
							<input value="<?=(isset($q['customer']['email'])) ? $q['customer']['email']: '';?>" id="tags" name="recipient_emails" id="recipient_emails" type="text" class="form-control">
							<small><?=l("Séparer les mail avec la virgule ou cliquer sur entrer pour ajouter une autre.", "quotation");?></small>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="objet"><?=l("Sujet", "quotation");?></label>  
						<div class="col-sm-4">
							<input value="" name="objet" id="objet" type="text" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="message"><?=l("Message personnalisé", "quotation");?></label>  
						<div class="col-md-6">
							<textarea name="message" id="message" class="form-control summernote" placeholder="Saisissez votre message ici"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="attachement"><?=l("Joindre un fichier", "quotation");?></label>  
						<div class="col-md-3">
	            <input type="file" name="attachement" class="attachement" id="attachement">
	            <input value="" id="file_name" name="file_name" type="hidden" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
	            <button type="submit" class="btn btn-success" name="email" value="1"><i class="fa fa-envelope"></i> <?=l("Envoyer par mail", "quotation");?></button>
	            <button type="submit" class="btn btn-default" name="acount" value="1"><i class="fa fa-user"></i> <?=l("Envoyer sur le compte client", "quotation");?></button>
	            <button type="submit" class="btn btn-primary" name="both" value="1"><i class="fa fa-send-o"></i> <?=l("Envoyer par mail et sur le compte", "quotation");?></button>
						</div>
					</div>

					<div class="panel-subheading">
						<i class="fa fa-envelope"></i>
						<strong><?=l("Message entre l’administrateur et le client", "quotation");?></strong>
					</div>

					<table cellspacing="0" class="table table-striped table-bordered datatable" width="100%">
					  <thead>
					    <tr>
					      <th width="60"><?=l("N°", "quotation");?></th>
					      <th width="150"><?=l("Objet", "quotation");?></th>
					      <th width="200"><?=l("Destinataire(s)", "quotation");?></th>
					      <th><?=l("Message", "quotation");?></th>
					      <th width="45"><?=l("Fichier", "quotation");?></th>
					      <th width="45"><?=l("Action", "quotation");?></th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php if( !empty($messages) ) : ?>
								<?php foreach ($messages as $key => $msg) : ?>
						    <tr id="<?=$msg['id'];?>">
						    	<td>#<?=$msg['id'];?></td>
						    	<td><?=$msg['objet'];?></td>
						    	<td><?=$msg['recipient_emails'];?></td>
						    	<td><?=$msg['message'];?></td>
						    	<td class="text-center">
						    		<?php if( !empty($msg['attachement']) ) : ?>
											<a download="<?=$msg['attachement'];?>" target="_blank" title="<?=$msg['file_name'];?>" href="<?='../../files/quotatonattachments/'. $id_quotation .'/'. $msg['attachement'];?>" class="btn btn-primary"><i class="fa fa-download"></i></a>
				            <?php endif; ?>
				            <?//=$msg['attachement'];?></td>
						    	<td>
						    		<a href="javascript:;" class="btn btn-danger delete_msg" title="Supprimer ce message">
						      		<i class="fa fa-trash"></i>
						      	</a>
						      </td>
						    </tr>
								<?php endforeach; ?>
							<?php endif; ?>
					  </tbody>
					</table>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<a href="<?=$quotations_list;?>" class="btn btn-default"><?=l("Annuler", "quotation");?></a>
					<!--input type="submit" class="btn btn-success pull-right" value="Sauvegarder et rester"-->
				</div><!--/ .panel-footer -->
			</form>
			</div><!--/ .panel -->
		<?php else: ?>
		<div class="alert alert-info">
			<h4><?=l("Il y a 1 avertissement.", "quotation");?></h4>
			<?=l("Vous devez enregistrer ce devis avant d'envoyer des messages.", "quotation");?>
		</div>
		<?php endif; ?>
		</div><!--/ .tab-pane -->

		

	</div><!--/ .tab-content -->
</div><!--/ .col-sm-10 -->	



<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal">
      		<span aria-hidden="true">&times;</span>
      		<span class="sr-only"><?=l("Fermer", "quotation");?></span>
      	</button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){

	//Ajax URL
	var ajax_url = "../modules/os-quotations/ajax/";
	var ajaxurl = '../ajax/';
	//var id_quotation = $('#id_quotation').val();

	//carrier
	var id_carrier = $('#based_carrier option:selected').val();
	if( id_carrier === "0" ){
		$('#carrier_name').empty().closest('.form-group').removeClass('hidden');
	}

	//register_order
	var id_state = $('#id_state option:selected').val();
	show_register_order_btn(id_state);
	//change event
	$('#id_state').on('change', function(){
		var id_state = $(this).find('option:selected').val();
		show_register_order_btn(id_state);
	});
	//click event
	$('#register_order a').on('click', function(){
		$(this).prop( "disabled", true );
		var id_quote = $('#id_quotation').val();
		var id_customer = $('#id_customer').val();
		os_message_notif( "<?=l('En cours de Génération de la Commande.', 'quotation');?>" );
		$.ajax({
			type: "POST",
			url: '../modules/os-quotations/ajax/gen-order.php',
			data: {id_quote:id_quote},
			success: function(id_order){
				window.location.href="../pdf/order.php?id_order="+id_order+"&id_customer="+id_customer;
			}
		});
	});


	//based product
	$('#based_product').on('change', function(){
		var id_product = $(this).find('option:selected').val();
		$('#add-product input[type=number]').val('');
		$('#product_form #id_declinaisons').val('');
		if( id_product == "" ){
			$('#product_form #id_product').val('');
			$('#product_form #id_declinaisons').val('');
			$('#based_attributs option').not(':eq(0)').remove();
	    $('#based_attributs').prop('disabled', true);
			return false;
		} 
    $.ajax({
      type: "POST",
      data: {id_product:id_product},
      url: ajaxurl + 'products/load-product.php',
      success: function(data){
      	var data = $.parseJSON(data);
      	if (data.dec !== undefined){
      		$('#based_attributs option').not(':eq(0)').remove();
      		$('#based_attributs ').append( data['dec'] ).prop('disabled', false);;
      		//notif message
					$.bootstrapGrowl("<?=l('Sélectionnez une attribut.', 'quotation');?>" , {type: 'success',align: 'right'});
	      }else{
	      	$('#based_attributs option').not(':eq(0)').remove();
	      	$('#based_attributs').prop('disabled', true);
      		fill_product_inputs(data);
	      }
      },
      error: function(jqXHR, textStatus, errorThrown){
      	get_error_message(textStatus, errorThrown);
      }
    });
	});

	//based attributs
	$('#based_attributs').on('change', function(){
		var id_dec = $(this).find('option:selected').val();
		var attributs = $(this).find('option:selected').text();
		$('#add_product input[type=number]').val('');
		if( id_dec == "" ) return;
    $.ajax({
      type: "POST",
      data: {id_dec:id_dec},
      url: ajaxurl + 'products/load-attributs.php',
      success: function(data){
      	var data = $.parseJSON(data);
      	fill_product_inputs(data);
      	$('#product_form  #id_declinaisons').val(id_dec);
      	$('#product_form  #attributs').val(attributs);
      },
      error: function(jqXHR, textStatus, errorThrown){
      	get_error_message();
      }
    });
	});

	//delete product
	$('#products').on('click', '.delete', function(){
		var choice = confirm("<?=l('Cette action supprime définitivement le produit de la base de donné. Êtes-vous vraiment sûr ?', 'quotation');?>");
		if (choice == false) return;
		var id = $(this).closest('tr').attr('id');
		$.ajax({
      type: "POST",
      data: {id:id},
      url: '<?=$module_path;?>ajax/remove/product.php',
      success: function(data){
      	$('#products tbody tr#'+id).fadeOut(500, function() { 
      		$(this).remove(); 
      		refresh_products_table();
      		os_message_notif( "<?=l('Le produit a été supprimer avec success.', 'quotation');?>" );
      	});
      }
    });
	});

	//update product
	$('#products').on('click', '.update', function(){
		var id = $(this).closest('tr').attr('id');
		$.ajax({
      type: "POST",
      data: {id:id},
      url: '<?=$module_path;?>ajax/update/product.php',
      success: function(data){
      	//display tab
      	$('a[href="#add-product"]').tab('show');
      	$('#hidden_buyprice').removeClass('hidden');
      	var data = $.parseJSON(data);
      	var action = "edit";
      	//fill_product_inputs
      	fill_product_inputs(data, action);
      	//message de notif
      	os_message_notif( "<?=l('Vous êtes en mode d\'edition de produit.', 'quotation');?>" );
      }
    });
	});

	//load product infos
	$('#load_product_infos').on('click', function(){
		var id_product = $('#based_product').not(':disabled').find('option:selected').val();
		if( id_product != undefined ){
			//message de notif
    	os_message_notif( "<?=l('Produit chargé avec success.', 'quotation');?>" );
			return false;
		}else{
			$.bootstrapGrowl(
		    "<?=l('Veuillez sélectionnez un produit.', 'quotation');?>", 
		    {type: 'warning',delay: 6000,align: 'center'}
		  );
		}
	});

	//show products list
	$('a[data-toggle="pill"][href="#products"]').on('shown.bs.tab', function (e) {
	  refresh_products_table();
	});


	//hide buyprice
	$('a[data-toggle="pill"][href="#add-product"]').on('shown.bs.tab', function (e) {
		$('#hidden_buyprice').addClass('hidden');
	});


	//reset_product_infos
	$('#reset_product_infos').on('click', function(){
		//reset inputs
		reset_inputs("reset");
	});

	//calculate product total
	/*$('#add-product input[type=number]').on('change', function(){
		calculate_product_total();
	});*/

	//reset field for new product
	$('a[href="#add-product"]').on('click', function(){
		reset_inputs("add");
	});

	//refresh_qty
	$('#products').on('click', '.refresh_qty', function(){
		var tr = $(this).closest('tr');
		var id_detail = tr.attr('id');
		var quantity = tr.find('.product_qty').val();
		refresh_product_quantity(id_detail, quantity);
		refresh_products_table();
	});



	//product form
  $("form#product_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("product_form", function(data) {
    	if(data["success"]){
    		os_message_notif( data["success"] );
    		//display tab
      	$('a[href="#products"]').tab('show');
    	}else{
				error_message_notification();
    	}
    });
    return false;
  });

  //config form
  $("form#config_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("config_form", function(data) {
    	if( data["msg"] ) os_message_notif( data["msg"] );
    	if( data["id_quote"] ){
    		window.location.href = '?module=modules&slug=os-quotations&page=quote&id='+data["id_quote"]+'&id_customer='+data["id_customer"];
    	}
    });
    return false;
  });

  //promos form
  $("form#promos_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("promos_form", function(data) {
    	os_message_notif( data );
    });
    return false;
  });

  //carrier form
  $("form#carrier_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("carrier_form", function(data) {
    	os_message_notif( data );
    });
    return false;
  });

  //terms form
  $("form#terms_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("terms_form", function(data) {
    	os_message_notif( data );
    });
    return false;
  });

  //informations form
  $("form#informations_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("informations_form", function(data) {
    	os_message_notif( data );
    });
    return false;
  });


  //delete state
  $('#messages_form').on('click', '.delete_msg', function(){
  	var choice = confirm("<?=l('Cette action supprime définitivement le message de la base de donné. Êtes-vous vraiment sûr ?', 'quotation');?>");
		if (choice == false) return;
  	var id = $(this).closest('tr').attr('id');
  	$.ajax({
      type: "POST",
      data: {id:id},
      url: ajax_url + 'remove/message.php',
      success: function(data){
      	var message = $.parseJSON(data);
      	$('#messages_form table tbody tr#'+id).fadeOut(500, function() { 
      		$(this).remove(); 
      		os_message_notif(message);
      	});
      }
    });
  });

  //terms form
  $("form#messages_form").submit(function(event){
    event.preventDefault();
    //validate
    var emails = $('#tags').val();
    var message = $('#message').code();
    if( emails === ""){
    	os_message_notif("<?=l('Les e-mail(s) de(s) destinataire(s) sont obligatoire.', 'quotation');?>", "danger");return false;
    }else if( message === ""){
    	os_message_notif("<?=l('Le contenu de message est obligatoire.', 'quotation');?>", "danger");return false;
    }
    submit_ajax_form("messages_form", function(data) {
    	$('#messages_form table tbody td.dataTables_empty').closest('tr').remove();
    	if( data.row ) $( data.row ).prependTo("#messages_form table > tbody");
    	os_message_notif( data.msg );
    	$('#messages_form #objet').val('');
    	$('#messages_form #message').code('');
    	//$('#messages_form #attachement').filer('destroy');
    });
    return false;
  });




  //voucher_code
	$('#voucher_code').on('change', function(){
		var reduction = $(this).find('option:selected').data('red');
		$('#voucher_value').val(reduction);
		$('#voucher_type option[value="1"]').prop('selected', true);
	});

  //based_carrier
	$('#based_carrier').on('change', function(){
		if( $(this).val() === "0" ){
			$('#carrier_name').empty().closest('.form-group').removeClass('hidden');
			return false;
		}else{
			var option = $(this).find('option:selected');
			$('#carrier_form #carrier_name').val( $(option).text() );
			$('#carrier_form #carrier_name').closest('.form-group').addClass('hidden');
			$('#carrier_form #min_delay').val( $(option).data('min') );
			$('#carrier_form #max_delay').val( $(option).data('max') );
			$('#carrier_form #delay_type option[value=0]').prop('selected', true);
			//console.log($(option).text())
			/*var id_carrier = $(this).find('option:selected').val();
			$.ajax({
	      type: "POST",
	      data: {id_carrier:id_carrier},
	      url: '<?=$module_path;?>ajax/based-carrier.php',
	      success: function(data){
	      	var data = $.parseJSON(data);
	      }
	    });*/
		}
	});


  //loyalty_state
  var loyalty_points = $('#promos #loyalty_points').val();
  if(loyalty_points == "0"){
  	$('.loyalty_state option[value=1]').prop('selected', true);
  	$('.loyalty_state').css('border', '1px solid #F05050');
  	$('#loyalty_value').val('0');
  }else{
  	$('.loyalty_state').css('border', '1px solid #3E9E28');
  }
  $('.loyalty_state').on('change', function(){
  	if( $(this).val() === "1" ){
  		$('#promos #loyalty_points').val('0');
  		$('.loyalty_state').css('border', '1px solid #F05050');
  		$('#loyalty_value').val('0');
  	}else{
  		$('.loyalty_state').css('border', '1px solid #3E9E28');
  	}
  });

	//refresh_state
	$('.refresh_state').on('click', function() {
		if( $('#send_state_email').is(':checked') ){
			var args = {};
			args['state'] = $('#config #id_state option:selected').text();
			args['customer'] = $('#config #customer_name').val();
			args['email'] = $('#config #customer_email').val();
			args['quote_number'] = $('#config #quote_number').val(); 
			args['reference'] = $('#config #reference').val(); 
			$.ajax({
	      type: "POST",
	      data: {args:args},
	      url: '<?=$module_path;?>ajax/email/state.php',
	      success: function(data){
	      	//message de notif
	      	var response = $.parseJSON(data);
	      	os_message_notif( response );
	      	$('#config_form').submit();
	      }
	    });
		}else{
			//notif message
			$.bootstrapGrowl("<?=l('Vous devez cocher l\'option d\'envoi d\'email.', 'quotation');?>" , {type: 'warning',align: 'center'});
		}
	});

	//gen_name
	$('.gen_name').on('click', function() {
		var company = $('#config_form #company').val();
		if( company == "" ){
			os_message_notif("<?=l('Le champs [Société] doit être remplis.', 'quotation');?>", 'warning');return false;
		}
		$('#config_form #name').val('Devis_'+company);   
	});

	//image preview
	$('.pop').on('click', function() {
		var big_image = $(this).find('img').attr('src').replace("80x80", "360x360");
		$('.imagepreview').attr('src', big_image);
		$('#imagemodal').modal('show');   
	});



});


function fill_product_inputs(data, action="add"){
	//console.log(action)
	//edit mode
	if( action == "edit" ){
		//disable
		$('#based_product').prop('disabled', true);
		$('#based_attributs').prop('disabled', true);
		//select
		$("#based_product option[value='"+data['id_product']+"']").prop("selected", true);
	}
	//fill data
	if( !data['product_discount']) data['product_discount'] = "0.00";
	$('#product_form #id_product').val( data['id_product'] );
	$('#product_form #id_declinaisons').val( data['id_declinaisons'] );
	$('#product_form #id_detail').val( data['id'] );
	$('#product_form #attributs').val( data['attributs'] );
	$('#product_form #product_name').val( data['product_name'] );
	$('#product_form #product_reference').val( data['product_reference'] );
	$('#product_form #product_price').val( data['product_price'] );
	$('#product_form #product_buyprice').val( data['product_buyprice'] );
	$('#product_form #discount').val( (data['product_price'] - data['product_discount']).toFixed(2) );
	$('#product_form #product_discount').val( data['product_discount'] );
	//$('#product_form #product_discount').val( data['product_discount'] );
	$('#product_form #product_packing').val( data['product_packing'] );
	$('#product_form #product_quantity').val( data['product_quantity'] );
	$('#product_form #product_min_quantity').val( data['product_min_quantity'] );
	$('#product_form #product_stock').val( data['product_stock'] );
	$('#product_form #loyalty_points').val( data['loyalty_points'] );
	$('#product_form #product_weight').val( data['product_weight'] );
	$('#product_form #product_height').val( data['product_height'] );
	$('#product_form #product_width').val( data['product_width'] );
	$('#product_form #product_depth').val( data['product_depth'] );
	//product image
	if( data['product_image'] && data['product_image'] != ""){
		var thumbnail = data['product_image'];
		var ext = thumbnail.split('.').pop();
		var file_name = thumbnail.replace( '.'+ext, '-200x200.'+ext );
		var file_path = '../files/products/'+ data['id_product'] +'/'+ file_name;
		$.ajax({
	    url: file_path,
	    type:'HEAD',
	    success: function()
	    {
	      var image = $("<img class='img-thumbnail' src='"+file_path+"' width='180'>");
				$('#product_img').empty().append(image);
				$('#product_image').val(thumbnail);
	    }
		});
	}
	if( action == "add" ){
		//notif message
		os_message_notif( "<?=l('Le produit a été changé avec success.', 'quotation');?>" );
	}
}

//reset inputs
function reset_inputs(action=""){
	$('#add-product').find('input[type=text], input[type=hidden], input[type=number]').not("#id_quotation").val('');
	$('#add-product').find('select option:selected').prop("selected", false);
	$('#product_img').html('<img class="img-thumbnail" src="<?=$module_path;?>images/no-image360.png" width="180">');
	//enable
	$('#based_product').prop('disabled', false);
	$('#based_attributs').prop('disabled', false);
	if( action == "reset"){
		//notif message
		os_message_notif( "<?=l('Les champs ont été Réinialisé avec success.', 'quotation');?>" );
	}
}

//refresh_product_quantity
function refresh_product_quantity(id_detail, quantity){
	$.ajax({
    type: "POST",
    data: {id_detail:id_detail, quantity:quantity},
    url: '<?=$module_path;?>ajax/update/quantity.php',
    success: function(response){
    	var message = $.parseJSON(response);
    	os_message_notif(message);
    }
  });
}

//refresh_products_table
function refresh_products_table(){
	var id_quotation = $('#id_quotation').val();
	var id_customer = $('#id_customer').val();
	$.ajax({
    type: "POST",
    data: {id_quotation:id_quotation,id_customer:id_customer},
    url: '<?=$module_path;?>ajax/update/refresh.php',
    success: function(data){
    	var data = $.parseJSON(data);
    	//console.log(data.products);return;
    	$('table#quotation_products > tbody').empty().append( data.products );
    	$('table#quotation_total > tbody').empty().append( data.totals );
    	$('table#quotation_customer > tbody > tr > td.company').empty().text( ": "+data.company );
    	//os_message_notif("Produits actualisé.");
    }
  });
}

function show_register_order_btn(id_state){
	if( id_state == "5"){
		$('#register_order').removeClass('hidden');
	}
}

function next_tab(tab){
  $('.nav-pills a[href="#' + tab + '"]').tab('show');
};

</script>
<?php
}//END QUOTATION ADD/EDIT