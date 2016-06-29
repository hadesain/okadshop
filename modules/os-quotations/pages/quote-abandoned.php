<?php
function page_quote_abandoned(){


global $common;
global $DB;
$errors = $success = array();

//send order email
if( isset($_POST['send_email']) ){
	
	$id_quote = intval($_POST['send_email']);

	$query = "SELECT q.id as id_quote, q.reference, qs.name as state, u.last_name, u.email
						FROM "._DB_PREFIX_."quotations q, "._DB_PREFIX_."quotation_status qs, "._DB_PREFIX_."users u 
						WHERE u.id=q.id_customer AND qs.id=q.id_state AND q.id=".$id_quote;
	if($row = $DB->query($query)){
	  $quote = $row->fetch(PDO::FETCH_ASSOC);
	  if( !empty($quote) ){
	  	//headers
	  	$headers  = "From: OkadShop < no-reply@okadshop.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$Sender 	= "no-reply@okadshop.com";
			$Subject 	= "OkadShop - Devis abandonné";
			//send email
			$Receiver = $quote['email'];
		  $Content  = 'Bonjour '. $quote['last_name'] .',<br><br>';
		  $Content .= 'Le devis N°'. $quote['id_quote'] .' avec le référence ['. $quote['reference'] .'] est abandonné.<br>';
		  $Content .= 'Le statut est : '. $quote['state'] .'<br><br>';
			$Content .= 'Cordialement.';
			$sentmail = mail($Receiver,$Subject,$Content,$headers);
			if( $sentmail ){
				//update send email count
				$query = "UPDATE quotations 
				SET count_emails = count_emails + 1
				WHERE id =".$id_quote;
				$DB->query($query);
				//success
				array_push($success, l('Une email a été envoyé au Client.', 'quotation') );
			}else{
				array_push($errors, l('Une erreur est survenu lors de l\'envoie de l\'email.', 'quotation') );
			}
	  }
	}

}


//get data
$query = "SELECT q.id as id_quote, q.reference, qs.name as current_state, pm.value as payment_method, 
					q.count_emails, q.loyalty_points, u.first_name, u.last_name, u.email
			 		FROM "._DB_PREFIX_."quotations q, "._DB_PREFIX_."users u, "._DB_PREFIX_."quotation_status qs, "._DB_PREFIX_."payment_methodes pm
			 		WHERE q.id_state NOT IN (5) 
			 		AND u.id=q.id_customer";
$rows = $DB->query($query);
$quotes = $rows->fetchAll(PDO::FETCH_ASSOC);

/*echo "<pre>";
print_r($quotes);
echo "</pre>";*/
?>



<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-power-off"></i> <?=l("Devis abandonnés", "quotation");?></h3>
  </div>
</div><br>

	<?php if(!empty($errors)) : ?>
		<div class="alert alert-warning">
			<h4><?=l("Une erreur est survenue !", "quotation");?></h4>
			<ul>
			<?php foreach ($errors as $key => $error) : ?>
				<li><?=$error;?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php elseif(!empty($success)) : ?>
		<div class="alert alert-success">
			<h4><?=l("Opération Effectué !", "quotation");?></h4>
			<ul>
			<?php foreach ($success as $key => $value) : ?>
				<li><?=$value;?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	
	<form class="form-horizontal" method="post" action="">
	<table id="quotations" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th><?=l("ID", "quotation");?></th>
				<th><?=l("Réference", "quotation");?></th>
				<th><?=l("Status actuel", "quotation");?></th>
				<th><?=l("Method de payment", "quotation");?></th>
				<th><?=l("Points de fidélité", "quotation");?></th>
				<th><?=l("Nom de Client", "quotation");?></th>
				<th><?=l("Prénom", "quotation");?></th>
				<th><?=l("Email", "quotation");?></th>
				<th><?=l("Email Envoyés", "quotation");?></th>
				<th><?=l("Actions", "quotation");?></th>
			</tr>
		</thead>
		<tbody>
			<?php if( !empty($quotes) ) : ?>
				<?php foreach ($quotes as $key => $quote) : ?>
				<tr>
					<td><?php echo '#'.sprintf("%06d", $quote['id_quote']);?></td>
					<td><?=$quote['reference'];?></td>
					<td><?=$quote['current_state'];?></td>
					<td><?=$quote['payment_method'];?></td>
					<td><?=$quote['loyalty_points'];?></td>
					<td><?=$quote['first_name'];?></td>
					<td><?=$quote['last_name'];?></td>
					<td><?=$quote['email'];?></td>
					<td style="text-align:center;"><span class="badge"><?=$quote['count_emails'];?></span></td>
					<td>
						<button type="submit" name="send_email" value="<?=$quote['id_quote'];?>" class="btn btn-default"><?=l("Renvoyer l'email", "quotation");?></button>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	</form>



<script>
$(document).ready(function() {
    $('#quotations').DataTable();
} );
</script>

<?php
}