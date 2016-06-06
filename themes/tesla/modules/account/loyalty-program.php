<?php  
	goConnected();
	$user_loyalty = getUserloyalty($_SESSION['user']);
?>
	<!-- Main content start here -->
	<ol class="breadcrumb">
	  <li><a href="#" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	  <li><a href="#" title="acount"><?= l("Mon compte", "artiza");?></a></li>
	  <li class="active"><?= l("Mes points de fidélité", "artiza");?></li>
	</ol>

	<h1><?= l("Mes points de fidélité", "artiza");?></h1>
	<div class="block-center" id="block-loyalty">
		<?php  if ($user_loyalty && !empty($user_loyalty)): ?>
			<?php $points = 0; ?>
			<table>
				<thead>
					<tr>
						<th><?= l("Devis", "artiza");?></th>
						<th><?= l("Date", "artiza");?></th>
						<th><?= l("Points", "artiza");?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($user_loyalty as $key => $loyalty): ?>
						<?php $points += $loyalty['points']; ?>
						<tr>
							<td><strong>N° <?= $loyalty['id'] ?></strong></td>
							<td><strong><?= $loyalty['cdate'] ?></strong></td>
							<td><?= $loyalty['points'] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" style="text-align: left;"><strong><?= l("Total de points disponibles", "artiza");?></strong></td>
						<td style="text-align: left;"><strong><?= $points; ?></strong></td>
					</tr>
				</tfoot>
			</table>
		<?php else: ?>	
			<p class="warning"><?= l("Aucun point de fidélité pour le moment.", "artiza");?></p>
		<?php endif ?>	
	</div>

		<ul class="footer_links">
		<li><a href="<?= WebSite;?>account/" title="Retour à votre compte"><?= l("Retour à votre compte", "artiza");?></a></li>
		<li><a href="<?= WebSite;?>" title="Accueil"><?= l("Accueil", "artiza");?></a></li>
	</ul>