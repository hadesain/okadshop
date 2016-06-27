<?php 
//http://OkadShop.okadshop.com/modules/os-analytics/index.php
//https://ga-dev-tools.appspot.com/embed-api/third-party-visualizations/
//https://github.com/googleanalytics/ga-dev-tools/issues/51
function page_analytics(){
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-bar-chart"></i> <?=l("Google Analytics", "analytics");?></h3>
    <span class="pull-right">
      <div id="embed-api-auth"></div>
    </span>
  </div>
</div><br>


<div class="row">

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading"><?=l("Cette semaine vs la semaine dernière - Par sessions.", "analytics");?></div>
      <div class="panel-body">
        <div id="week-chart"></div>
        <div id="week-legendr"></div>
      </div>
    </div>
  </div>
  <div class="col-md-6 omega">
    <div class="panel panel-default">
      <div class="panel-heading"><?=l("Cette année vs année dernière - par les utilisateurs.", "analytics");?></div>
      <div class="panel-body">
        <div id="year-chart"></div>
        <div id="year-legend"></div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading"><?=l("Le trafic du site - Sessions vs Utilisateurs - 30 derniers jours.", "analytics");?></div>
      <div class="panel-body">
        <div id="siteTraffic"></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading"><?=l("Top Navigateurs - Par page vue.", "analytics");?></div>
      <div class="panel-body">
        <div id="navigators-chart"></div>
        <div id="navigators-legend"></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading"><?=l("Principaux pays par Sessions - 30 derniers jours.", "analytics");?></div>
      <div class="panel-body">
        <div id="countries-chart"></div>
        <div id="countries-legend"></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading"><?=l("La plupart des Vues Popular page - 30 derniers jours.", "analytics");?></div>
      <div class="panel-body">
        <div id="pageViews"></div>
      </div>
    </div>
  </div>

</div>

<?php
}