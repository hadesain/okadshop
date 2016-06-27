<?php
function page_loyalty_settings(){
	$msg = "";
	$output = "";
	if (isset($_POST['validate_loyalty'])) {
		$loyalty_discount = $_POST['loyalty_discount'];
		$res = saveLoyaltyOptions('loyalty_discount',$loyalty_discount);
		if ($res) {
			$msg = '<div class="alert alert-info" role="alert">'.l('Bien Enregistré','osloyality').'</div>';
		}else{
			$msg = '<div class="alert alert-danger" role="alert">'.l('Non Enregistré','osloyality').'</div>';
		}
	}

	$loyalty_discount = getLoyaltyOptions('loyalty_discount');
	$output .= '<form method="POST" action=""  enctype="multipart/form-data">
		<div class="top-menu padding0">
		  <div class="top-menu-title">
		    <h3><i class="fa fa-config" style="color: #002F86;"></i> '.l('Point de fidelite','osloyality').' : '.l('Configuration','osloyality').'</h3>
		  </div>
		</div>
		<div class="panel panel-default" style="margin-top:10px;">
		  <div class="panel-heading">
		    <h3 class="panel-title">'.l('Point de fidelite Details','osloyality').'</h3>
		  </div>
		  <div class="panel-body">'.$msg .'
		  <div class="form-group">
				<label for="owner">'.l('la valeur de','osloyality').' <span style="color:#f00"><b>1</b></span> '.l('Point de fidélité:','osloyality').'</label>
				<p><input class="form-control" type="text" name="loyalty_discount" value="'.$loyalty_discount['value'].'"/></p>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" class="form-control" name="validate_loyalty" value="'.l('Enregistrer','osloyality').'"/>
			</div>
		</div>
		</form>';
	echo $output;
}