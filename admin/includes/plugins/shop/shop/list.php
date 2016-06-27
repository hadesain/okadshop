<br>
<fieldset>
	<form methode="POST" action="">
		<input type="hidden" name="module" value="<?= $_GET['module'];?>" />
		 <input type="hidden" name="slug" value="<?= $_GET['slug']; ?>" />
		 <input type="hidden" name="page" value="<?= $_GET['page']; ?>" />
		<div class="form-group">
			<label class="control-label" for="short_description"><i class="fa fa-shopping-basket"></i> <?=l("Gestion de Boutique", "admin");?></label>
		</div>
		<div class="form-group">
			<table>
				<tr>
					<td><strong><?=l('Afficher "Ajouter au Panier"', "admin");?></strong></td>
					<td>
						<div class="radio">
						  <label>
						    <input type="radio" name="cartvisible" id="optionsRadios1" value="optionyes" checked> <?=l("OUI", "admin");?>
						  </label>
						  <label>
						    <input type="radio" name="cartvisible" id="optionsRadios2" value="option1" > <?=l("NON", "admin");?>
						  </label>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<input type="submit" name="submit" class="btn btn-primary" />
	<form>
</fieldset>