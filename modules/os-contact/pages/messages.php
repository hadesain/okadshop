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
function page_messages(){

	//id_directory
	if( 
		isset($_GET['id_directory']) 
		&& is_numeric($_GET['id_directory']) 
		&& $_GET['id_directory'] > 0 
	){
		$id_directory = intval($_GET['id_directory']);
	}else{
		$id_directory = 1;
	}

	$contact  = new Contact_Form();
	$messages = $contact->get_contact_messages();
	//var_dump($messages);
?>

<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-envelope"></i> <?=l("Liste des Messages", "contact");?></h3>
  </div>
</div>
<br>
<table class="table bg-white table-bordered" id="datatable">
	<thead>
		<th width="20"><?=l("Numéro", "contact");?></th>
		<th><?=l("Date et heure", "contact");?></th>
		<th><?=l("Expéditeur", "contact");?></th> 
		<th><?=l("Société", "contact");?></th> 
		<th><?=l("Numéro d’entreprise", "contact");?></th>
		<th><?=l("E-mail", "contact");?></th>
		<th><?=l("Pays", "contact");?></th>
		<th width="340"><?=l("Actions", "contact");?></th> 
	</thead>
	<tbody>
		<?php if( !empty($messages) ) : ?>
			<?php foreach ($messages as $key => $msg) : ?>
			<tr <?php if( $msg['viewed'] == "0" && $msg['id_sender'] == $msg['from'] ){ echo "style='background-color: #ddd;'";} ?>>
				<td><?php echo '#'.sprintf("%05d", $msg['id']);?></td>
				<td><?php echo $msg['cdate']; ?></td>
				<td><?php echo $msg['firstname']. ' ' .$msg['lastname']; ?></td>
				<td><?php echo $msg['company']; ?></td>
				<td><?php echo $msg['siret_tva']; ?></td>
				<td><?php echo $msg['email']; ?></td>
				<td><?php echo $msg['country']; ?></td>
				<td>
					<div class="btn-group">
	          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true"><?=l("Actions", "contact");?>&nbsp;<span class="caret"></span></button>
	          <ul class="dropdown-menu">
	            <li><a href="?module=modules&slug=os-contact&page=view-message&from=<?=$msg['from'];?>&email=<?=$msg['email'];?>&id_dir=<?php echo $msg['id_directory']; ?>" class="view"><i class="fa fa-eye"></i>&nbsp; <?=l("Voir le message", "contact");?></a></li>
	            <!--li><a href="javascript:;" class="move"><i class="fa fa-clone"></i>&nbsp; Déplacer</a></li>
	            <li><a href="javascript:;" class="trash"><i class="fa fa-trash"></i>&nbsp; Supprimer</a></li>
	            <li><a href="javascript:;" class="spam"><i class="fa fa-minus"></i>&nbsp; Spam</a></li-->
	          </ul>
	        </div>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<?php
}