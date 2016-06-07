<?php
global $common;
$mf = $common->select('manufacturers');
?>
<ol class="breadcrumb">
	<li><a href="#" title="<?=l("Accueil", "tesla");?>"><?=l("Accueil", "tesla");?></a></li>
	<li class="active"><?=l("Nos fabricant", "tesla");?></li>
</ol>
<h1><?=l("Nos fabricant", "tesla");?></h1>
<p class="warning"><span><?=l("Il y a", "tesla");?>&nbsp;<?=count($mf);?>&nbsp;<?=l("marques.", "tesla");?></span></p>

<style>
#manufacturers_list li {
  -webkit-background-clip: padding-box;
  background-clip: padding-box;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  border: 1px solid #ebded2;
  border-bottom-color: #dbc3af;
  background: #ffffff;
  position: relative;
  text-align: right;
  margin-bottom: 10px;
  padding: 10px;
  overflow: hidden;
}
#manufacturers_list .left_side {
  float: left;
  width: 100%;
  text-align: left;
}
#manufacturers_list .logo {
  float: left;
  margin-right: 10px;
}
h3 {
  font-size: 18px
  line-height: 18px;
}

</style>

<ul id="manufacturers_list">
<?php if( !empty($mf) ) : ?>
	<?php foreach ($mf as $key => $m) : ?>
  <li class="first_item">
    <div class="left_side">
      <div class="logo">
        <img alt="Argapur" src="../files/m/<?=$m['logo'];?>" height="80" width="80">
      </div>
      <h3><?=$m['name'];?></h3>
      <p><?=strip_tags($m['short_description']);?></p>
    </div>
  </li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>