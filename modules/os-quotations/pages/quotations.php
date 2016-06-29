<?php
// DISPLAY QUOTATIIONS LIST
function page_quotations(){
	$devis = new OS_Devis();
	$list  = $devis->get_quotations_list();


?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-pencil-square-o"></i> <?=l("Liste des Devis", "quotation");?></h3>
  </div>
  <div class="top-menu-button">
    <a href="?module=modules&slug=os-quotations&page=quote#config" type="button" class="btn btn-primary"><?=l("Créer un devis", "quotation");?></a>
  </div>
</div>
<br>
<table class="table bg-white table-bordered" id="datatable">
	<thead>
		<th><?=l("Numéro de devis", "quotation");?></th>
		<th><?=l("Date", "quotation");?></th>
		<th><?=l("Client", "quotation");?></th>
		<th><?=l("Pays", "quotation");?></th>
		<th><?=l("Statut du client", "quotation");?></th>
		<th><?=l("Méthode de paiement", "quotation");?></th>
		<th><?=l("Statut du devis", "quotation");?></th>
		<th width="180"><?=l("Actions", "quotation");?></th>
	</thead>
	<tbody>
		<?php if( !empty($list) ) : ?>
			<?php foreach ($list as $key => $quote) : ?>
			<?php 
			if( 
				$quote['state'] == "Devis en création" 
				|| $quote['state'] == l("Devis en étude", "quotation") )
			{
				$class = "label-primary";
			}elseif( 
				$quote['state'] == "Devis disponible" 
				|| $quote['state'] == l("En attente du règlement", "quotation") )
			{
				$class = "label-default";
			}elseif( $quote['state'] == l("Commande enregistrée", "quotation") )
			{
				$class = "label-success";
			}elseif( 
				$quote['state'] == "Devis rejeté" 
				|| $quote['state'] == l("Devis annulé", "quotation") )
			{
				$class = "label-warning";
			}elseif( $quote['state'] == l("Devis expiré", "quotation") )
			{
				$class = "label-danger";
			}

			//user state
			/*if( $quote['user_state'] == "actived" ){
				$user_state = '<span class="label label-success">Activé</span>';
			}elseif( $quote['user_state'] == "waiting" ){
				$user_state = '<span class="label label-warning">En attente</span>';
			}elseif( $quote['user_state'] == "suspended" ){
				$user_state = '<span class="label label-danger">Suspendu</span>';
			}*/
			?>
			<tr id="<?=$quote['id'];?>">
				<td><?php echo 'DEV'.sprintf("%06d", $quote['id']);?></td>
				<td><?php echo $quote['cdate']; ?></td>
				<td><?php echo $quote['first_name']. ' ' .$quote['last_name']; ?></td>
				<td><?php echo $quote['country']; ?></td>
				<td style="text-align:center;"><?=$quote['user_group'];?></td>
				<td><?=$quote['method'];?></td>
				<td><span class='label <?php echo $class;?>'><?php echo $quote['state']; ?></span>
				</td>
				
				<td>
					<!--a class="btn btn-success gen_order" data-id="<?php //echo $quote['id']; ?>" title="Générer la Commande"><i class="fa fa-credit-card"></i></a-->
					<a target="_blank" href="<?='../pdf/quotation.php?id_quotation='. $quote['id'] .'&id_customer='. $quote['id_customer'];?>" class="btn btn-primary" title="<?=l("Télécharger en PDF", "quotation");?>"><i class="fa fa-file-pdf-o"></i></a>
					<a href="?module=modules&slug=os-quotations&page=quote&id=<?=$quote['id'].'&id_customer='. $quote['id_customer'];?>" class="btn btn-default" title="Modifier ce devis"><i class="fa fa-edit"></i></a>
	      	<a data-id="<?=$quote['id']; ?>" class="btn btn-success clone_quote" title="<?=l("Dupliquer ce devis", "quotation");?>"><i class="fa fa-clone"></i></a>
	      	<a data-id="<?=$quote['id']; ?>" class="btn btn-danger delete_quote" title="<?=l("Supprimer ce devis", "quotation");?>"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>


<script>
$(document).ready(function(){

	//generate order
	$('.gen_order').on('click', function() {
		var id_quote = $(this).data('id');
		$.ajax({
			type: "POST",
			url: '../modules/os-quotations/ajax/gen-order.php',
			data: {id_quote:id_quote},
			success: function(data){
				window.location.href="?module=orders&action=edit&id="+data;
			}
		});
	});

	//clone quotation
	$('#datatable').on('click', '.clone_quote', function() {
		var id_quote = $(this).data('id');
		$.ajax({
			type: "POST",
			url: '../modules/os-quotations/ajax/clone-quote.php',
			data: {id_quote:id_quote},
			success: function(data){
				var data = $.parseJSON(data);
				//console.log(data['id_customer'])
      	os_message_notif( "<?=l('Le Devis a été Dupliquer avec success.', 'quotation');?>" );
      	setTimeout(function(){
			    window.location.href="?module=modules&slug=os-quotations&page=quote&id="+data['id_quote']+"&id_customer="+data['id_customer'];
			  }, 2000);
			}
		});
	});

	//delete quotation
	$('#datatable').on('click', '.delete_quote', function() {
		var choice = confirm('<?=l("Cette action supprime définitivement ce devis de la base de donné. Êtes-vous vraiment sûr ?", "quotation");?>');
		if (choice == false) return;
		var id_quote = $(this).data('id');
		$.ajax({
			type: "POST",
			url: '../modules/os-quotations/ajax/delete-quote.php',
			data: {id_quote:id_quote},
			success: function(data){
				$('#datatable tbody tr#'+id_quote).fadeOut(500, function() { 
      		$(this).remove(); 
      		success_message_notification( '<?=l("Le Devis a été supprimer avec success.", "quotation");?>' );
      	});
				//window.location.href="?module=modules&slug=os-quotations&page=quotations";
			}
		});
	});

});
</script>
<?php
/*============================================================*/
} //END 
/*============================================================*/