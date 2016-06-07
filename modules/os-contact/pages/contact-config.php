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
function page_contact_config()
{
	global $common;
	$allowed_tags = allowed_tags();

	// send message
	if( isset($_POST['msg_signature']) && !empty($_POST['signature'])){
		$signature = strip_tags($_POST['signature'], $allowed_tags);
		$save = $common->save_mete_value('msg_signature', $signature);
	}

	$msg_signature = $common->select_mete_value('msg_signature');
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-cog"></i> <?=l("Paramètres de Messagerie", "contact");?></h3>
  </div>
</div><br>


<div class="panel panel-default">
	<div class="panel-heading"><?=l("Signature des messages", "contact");?></div>
	<div class="panel-body">
    <form class="form-horizontal" method="post" action="">
			<div class="form-group">
				<div class="col-sm-12 left0">
					<textarea name="signature" class="form-control summernote" id="signature" placeholder="<?=l("Signature...", "contact");?>"><?php echo $msg_signature; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12 left0">
					<input type="submit" name="msg_signature" class="btn btn-primary btn-block" value="<?=l("Sauvegarder la signature", "contact");?>">
				</div>
			</div>
		</form>
	</div><!--/ .panel-body -->
</div>


<?php
}