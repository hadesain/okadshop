	<?php  
		goConnected();
		$user_invoices = getInvoicesList($_SESSION['user']);
	?>
	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="<?= WebSite ?>" title="Accueil"><?= l("Accueil", "tesla");?></a></li>
	  <li><a href="<?= WebSite.'account' ?>" title="acount"><?= l("Mon compte", "tesla");?></a></li>
	  <li class="active"><?= l("Historique de vos factures.", "tesla");?></li>
	</ol>



	 <div class="block-center" id="block-history">
		<h1><?= l("Historique de vos factures", "tesla");?></h1>

	<?php  if ($user_invoices && !empty($user_invoices)): ?>
		<table>
			<thead>
				<tr>
					<th><?= l("Facture", "tesla");?></th>
					<th><?= l("Date", "tesla");?></th>
					<th><?= l("Prix total", "tesla");?></th>
					<th><?= l("Paiement", "tesla");?></th>
					<th><?= l("État", "tesla");?></th>
					<th><?= l("Commande", "tesla");?></th>
					<th><?= l("Télécharger", "tesla");?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($user_invoices as $key => $invoice): ?>
					<tr>
						<td><strong>N° <?= $invoice['id'] ?></strong></td>
						<td><strong><?= $invoice['cdate'] ?></strong></td>
						<?php 
							global $hooks; 
							$invoice_detail = $hooks->get_invoice($invoice['id'],$_SESSION['user']); 
						?>
						<td><?= $invoice_detail['total']['ttc'].' '.$invoice_detail['invoice']['currency_sign'] ?></td>
						<td><?= $invoice["payment_method"] ?></td>
						<td><strong><?= $invoice['current_state'] ?></strong></td>
						<td><strong>N° <?= $invoice['id_order'] ?></strong></td>
						<td><strong><a download="download" href="<?= WebSite.'pdf/invoice.php?id_invoice='.$invoice['id']; ?>"><i class="fa fa-download" aria-hidden="true"></i></a></strong></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	<?php else: ?>	
		<p class="warning"><?= l("Vous n'avez pas de facture", "tesla");?>.</p>
	<?php endif ?>	
	</div>
<!-- 
	<div class="order-detail" id="order-detail">
		<div class="panel panel-default">
		  <div class="">
		    <h3 class="order-detail-title"></h3>
		    <p>
		    	<strong>Méthode de paiement :</strong> <span class="payment-methode"></span>
		    </p>
		    <h4>Suivre votre commande pas à pas :</h4>
		    <table>
					<thead>
						<tr>
							<th>Date</th>
							<th>État</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><strong class="order-date"></strong></td>
							<td class="order-status"></td>
						</tr>
					</tbody>
				</table>
			 <div class="row">
	    	<div class="col-sm-6">
	    		<ul class="address item" id="address_fact">
		        <li class="address_title">Facturation</li>
		        <li class="address_firstname lastname"></li>
		        <li class="address_address1"></li>
		        <li class="address_postcode"></li>
		        <li class="address_Country"></li>
		        <li class="address_phone"></li>
		        <li class="address_mobile"></li>
	      </ul>
	    	</div>
	    	<div class="col-sm-6">
	    		<ul class="address item" id="address_liv">
		        <li class="address_title">Livraison</li>
		        <li class="address_firstname lastname"></li>
		        <li class="address_address1"></li>
		        <li class="address_postcode"></li>
		        <li class="address_Country:"></li>
		        <li class="address_phone"></li>
		        <li class="address_mobile"></li>
	      </ul>
	    	</div>
	    </div>
	    <table id="product-order-list">
					<thead>
						<tr>
							<th>Produit</th>
							<th>Qté</th>
							<th>Prix unitaire</th>
							<th>Prix total</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
					<tfoot>
						<tr class="totalprice item">
							<td colspan="4"> Total TTC : <span class="price"></span></td>
						</tr>
					</tfoot>
				</table>
		  </div>
		</div>
	</div> -->



	<ul class="footer_links">
		<li><a href="<?= WebSite;?>account/" title="Retour à votre compte"><?= l("Retour à votre compte", "tesla");?></a></li>
		<li><a href="<?= WebSite;?>" title="Accueil"><?= l("Accueil", "tesla");?></a></li>
	</ul>
