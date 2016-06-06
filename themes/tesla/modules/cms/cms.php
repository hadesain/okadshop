<?php 
	$cms = getCms($_GET['ID']);
	if (!$cms || empty($cms)) {
		goHome();
	}
?>

<!-- Main content start here -->
<ol class="breadcrumb">
  <li><a href="#" title="<?= l("Accueil", "artiza");?>"><?= l("Accueil", "artiza");?></a></li>
  <li class="active"><?= $cms['title']; ?></li>
</ol>

<h1><?= $cms['title']; ?></h1>
<div class="cms_content rte">
<?= htmlspecialchars_decode($cms['content']); ?>
</div>


