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

//register module infos
global $hooks;
$analytics_data = array(
	"name" => l("Dashboard Manager", "dashboard"),
	"description" => l("Gestion de tableau de bord.", "dashboard"),
	"author" => "Soft High Tech",
	"website" => "http://softhightech.com",
	"category" => "administration",
	"version" => "1.0.0",
);
$hooks->register_module('os-dashboard', $analytics_data);


//orders_invoices_this_month
function orders_invoices_this_month(){
  $html = '<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> <?=l("Devis, Commandes et Factures pour ce mois.", "dashboard");?>
        <div class="pull-right">
          <div class="btn-group"></div>
        </div>
      </div>
      <div class="panel-body">
        <div id="data_month"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard', 'os-dashboard', 'orders_invoices_this_month', l("Devis, Commandes et Factures pour ce mois.", "dashboard") );


//orders_invoices_this_month
function total_orders_invoices(){
  $html = '<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i> <?=l("Total de Devis, Commandes et Factures pour ce mois.", "dashboard");?>
        <div class="pull-right">
          <div class="btn-group"></div>
        </div>
      </div>
      <div class="panel-body">
        <div id="totals"></div>
      </div>
    </div>
  </div>';
  return $html;
}
add_hook('sec_dashboard', 'os-dashboard', 'total_orders_invoices', l("Total de Devis, Commandes et Factures pour ce mois.", "dashboard") );