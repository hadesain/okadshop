<?php
function page_loyalty_points(){

global $DB;
$query = "SELECT u.clt_number, u.first_name, u.last_name, u.phone, u.mobile, 
					c.name as country, SUM(q.loyalty_points) as points
					FROM "._DB_PREFIX_."quotations q, "._DB_PREFIX_."users u, "._DB_PREFIX_."countries c
					WHERE q.id_customer=u.id GROUP BY id_customer";
$rows = $DB->query($query);
$points = $rows->fetchAll(PDO::FETCH_ASSOC);

/*echo "<pre>";
print_r($points);
echo "</pre>";*/
?>



<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-heart"></i> <?= l('Points de fidélité','osloyality'); ?> </h3>
  </div>
</div><br>

	<div class="panel panel-default tab-pane fade in active" id="Product">
	<form class="form-horizontal" method="post" action="">
		<div class="panel-heading"><?= l('Points de fidélité pour chaque Client','osloyality'); ?></div>
		<div class="panel-body">

			<table class="table bg-white table-bordered" id="datatable">
				<thead>
					<tr>
						<th><?= l('N° Client','osloyality'); ?></th>
						<th><?= l('Nom','osloyality'); ?></th>
						<th><?= l('Prénom','osloyality'); ?></th>
						<th><?= l('Téléphone fixe','osloyality'); ?></th>
						<th><?= l('Téléphone portable','osloyality'); ?></th>
						<th><?= l('Pays','osloyality'); ?></th>
						<th><?= l('Nombre de Points','osloyality'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if( !empty($points) ) : ?>
						<?php foreach ($points as $key => $point) : ?>
						<tr>
							<td><?=$point['clt_number'];?></td>
							<td><?=$point['last_name'];?></td>
							<td><?=$point['first_name'];?></td>
							<td><?=$point['phone'];?></td>
							<td><?=$point['mobile'];?></td>
							<td><?=$point['country'];?></td>
							<td><?=$point['points'];?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>

		</div><!--/ .panel-body -->
	</form>
	</div><!--/ .panel -->

<?php
}