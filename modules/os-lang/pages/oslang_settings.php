<?php
/*============================================================*/
 //begin oslang_settings function
/*============================================================*/

function page_oslang_settings(){

?>

<div class="top-menu padding0">
	<div class="top-menu-title">
		<h3>
			<i class="fa fa-cog"></i> OsLang :<?= l('Page configuration','oslang'); ?>
		</h3>
	</div>
	<div class="top-menu-button">
  </div>
</div><br>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group col-md-4">
			<ul class="list-group">
			  <li class="list-group-item">
			  	<span class="badge">1</span>
			  	<a href="<?= WebSite;?>index.php?module=modules&slug=os-lang&page=oslang_product_translate"><?= l('Traduire une produit','oslang'); ?></a>
			  </li>
			  <li class="list-group-item">
			  	<span class="badge">2</span>
			  	<a href="<?= WebSite;?>index.php?module=modules&slug=os-lang&page=oslang_categories_translate"><?= l('Traduire une categorie','oslang'); ?></a>
			  </li>
			</ul>
		</div>
	</div>
</div>








<?php
/*============================================================*/
} //END 
/*============================================================*/