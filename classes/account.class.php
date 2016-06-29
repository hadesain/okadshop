<?php  
/**
* account class
*/
class account
{
	
	/*logout function*/
	public function logout(){
		 //session_destroy();
		 unset($_SESSION['user']);
		 $_SESSION['user_logout_time'] = time();
		 goHome();
		 return true;
	}

	/*login functiopn*/
	public function login(){
		global $hooks;
		/*$panel_live =  $hooks->select_mete_value('panel_live') * 60;
		$tmp = (time() - $_SESSION['user_logout_time']);
		if (isset($_SESSION['user_logout_time']) &&  $tmp > $panel_live) {
			session_destroy();
		}*/
		$dataReturn = array();
		if (isset($_POST['submitlogin'])) {
			$user = new user();
			$Security = new Security();
			$errorSecurity = array();


			$data = $_POST;
			$error = array();
			if (!isset($data['email']) || empty($data['email'])) {
				$error[] = 'L\'email est un champ obligatoir';
			}
	

			if (!isset($data['password']) || empty($data['password'])) {
				$error[] = 'Le mot de passe est un champ obligatoir';
			}


			if (!empty($error)) {
				$dataReturn['error'] = $error;
			}else if (!empty($errorSecurity)){
				$dataReturn['errorSecurity'] = $errorSecurity;
			}else{

				$return = $user->login($data['email'],$data['password']);
				if ($return == 'empty') {
					$dataReturn['error'][] = "Mot de passe / identifiant incorrect. ";
				}
				else if ($return && $return != 'empty') {
					$dataReturn['login'] = $return;
					$_SESSION['user'] = $return;
				}
			}
		}
		return $dataReturn;
	}

	/*register function*/
	public function register(){
		$dataReturn = array();
		if (isset($_POST['submitAccount'])) {
			$user = new user();
			$Security = new Security();
			$errorSecurity = array();

			$data = $_POST;
			
		
			$error = array();
			if (!isset($data['id_gender']) || empty($data['id_gender'])) {
				$data['id_gender'] = 1;
			}
			if(!$Security->check_numbers($data['id_gender'])){
					$errorSecurity[] = 'verifier le genre';
			}

			if (!isset($data['firstname']) || empty($data['firstname'])) {
				$error[] = 'Le Nom est un champ obligatoir';
			}

			if (!isset($data['lastname']) || empty($data['lastname'])) {
				$error[] = 'Le pronom est un champ obligatoir';
			}


			if (!isset($data['email']) || empty($data['email'])) {
				$error[] = 'L\'email est un champ obligatoir';
			}
			else if(!$Security->check_email($data['email'])){
					$errorSecurity[] = 'Le Format de l\'Adresse email est incorecte';
			}
			if(self::getByEmail($data['email']))
		     {
		         $error[] = 'E-mail déjà enregistré, connectez-vous !';
		    }


			if (!isset($data['password']) || empty($data['password'])) {
				$error[] = 'Le mot de passe est un champ obligatoir';
			}

			if (!isset($data['adresse_firstname']) || empty($data['adresse_firstname'])) {
				$error[] = 'Le Nom du propriétaire de l\'address est un champ obligatoir';
			}

			if (!isset($data['adresse_lastname']) || empty($data['adresse_lastname'])) {
				$error[] = 'Le pronom du propriétaire de l\'address est un champ obligatoir';
			}

			if (!isset($data['adress']) || empty($data['adress'])) {
				$error[] = 'L\'adress est un champ obligatoir';
			}

			if (!isset($data['zipcode']) || empty($data['zipcode'])) {
				$error[] = 'Le code postal est un champ obligatoir';
			}
			if (!isset($data['city']) || empty($data['city'])) {
				$error[] = 'La ville est un champ obligatoir';
			}

			if (!isset($data['id_country']) || empty($data['id_country'])) {
				$error[] = 'Le pays est un champ obligatoir';
			}
			else if(!$Security->check_numbers($data['id_country'])){
					$errorSecurity[] = 'verifier le pays';
			}

			


			if (!isset($data['adresse_name']) || empty($data['adresse_name'])) {
				$error[] = 'Le nom de l\'adress est un champ obligatoir';
			}


			if (!isset($data['mobile']) || empty($data['mobile'])) {
				$error[] = 'Le Téléphone portable est un champ obligatoir';
			}

			if (!isset($data['phone']) || empty($data['phone'])) {
				$data['phone'] = "";
			}

			if (!isset($data['info_sup']) || empty($data['info_sup'])) {
				$data['info_sup'] = "";
			}

			if (!isset($data['info_sup']) || empty($data['info_sup'])) {
				$data['info_sup'] = "";
			}

			//check birthday 
			$data['birthday'] ="0000-00-00";
			if (isset($data['birthday_day']) && !empty($data['birthday_day']) && isset($data['birthday_mounth']) && !empty($data['birthday_mounth']) && isset($data['birthday_year']) && !empty($data['birthday_year'])) {
				if(checkdate($data['birthday_mounth'], $data['birthday_day'], $data['birthday_year'])){
					$birthday =  $data['birthday_year'].'-'.$data['birthday_mounth'].'-'.$data['birthday_day'];
					$data['birthday'] = DateTime::createFromFormat('Y-m-d',$birthday)->format('Y-m-d');
				}
			}
			
			/*if (isset($data['statuts']) && !empty($data['statuts'])) {
				if ($data['statuts'] == "2") {
					//user societe verification
					if (!isset($data['company']) || empty($data['company'])) {
						$error[] = 'Le nom de Société  est un champ obligatoir';
					}
					if (!isset($data['activite']) || empty($data['activite'])) {
						$error[] = 'Le nom de Société  est un champ obligatoir';
					}
					if (!isset($data['siret_tva']) || empty($data['siret_tva'])) {
						$error[] = 'Le N° de siret / TVA  est un champ obligatoir';
					}
				}else if ($data['statuts'] == "3"){
					//user societe verification
					if (!isset($data['date_activite']) || empty($data['date_activite'])) {
						$error[] = 'la date de début de votre activité est un champ obligatoir';
					}
					if (!isset($data['info']) || empty($data['info'])) {
						$error[] = 'L\'info de votre projet est un champ obligatoir';
					}
				}
			}else{
				$error[] = 'votre Status est un champ obligatoir';
			}*/



			


			//activite siret_tva website attachement date_activite info

			if (!empty($error)) {
				$dataReturn['error'] = $error;
			}else if (!empty($errorSecurity)){
				$dataReturn['errorSecurity'] = $errorSecurity;
			}else{
				$data['ip'] = get_client_ip_country();
				$return = $user->addNewUser($data);
				$dataReturn['login'] = $return;
				if ($return) {
					$attachement = "";
					if (isset($_FILES['attachement']) && $_FILES['attachement']['size']>0) {
						$allowed =  array('gif','png' ,'jpg','pdf');
						$filename = $_FILES['attachement']['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						if(in_array($ext,$allowed) ) {
						  	$uploaddir = WEBROOT."files/users/$return/";
							if (!file_exists($uploaddir)) {
							    mkdir($uploaddir, 0777, true);
							}
							$uploadfile = $uploaddir . basename($_FILES['attachement']['name']);
							if (move_uploaded_file($_FILES['attachement']['tmp_name'], $uploadfile)) {
								$attachement = basename($_FILES['attachement']['name']);
							}
						}
					}
					/*if ($data['statuts'] == "2") {
						$Company = array(
							'company' => addslashes($data['company']),
							'activite' => addslashes($data['activite']),
							'siret_tva' => addslashes($data['siret_tva']),
							'website' => addslashes($data['website']),
							'attachement' => addslashes($attachement),
							'id_user' => $return,
						);
						$returnCompany = $user->addUserCompany($Company);
					}else if ($data['statuts'] == "3") {
						$date_activite = DateTime::createFromFormat('d/m/Y', $data['date_activite']);
						$Company = array(
							'company' => addslashes($data['company']),
							'activite' => addslashes($data['activite']),
							'siret_tva' => addslashes($data['siret_tva']),
							'website' => addslashes($data['website']),
							'attachement' => addslashes($attachement),
							'date_activite' => $date_activite->format('Y-m-d'),
							'info' => addslashes($data['info']),
							'id_user' => $return,
						);
						$returnCompany = $user->addUserCompany($Company);
					}*/
					/*
					$Company = array(
								'company' => addslashes($data['company']),
								'activite' => addslashes($data['activite']),
								'siret_tva' => addslashes($data['siret_tva']),
								'website' => addslashes($data['website']),
								'date_activite' => addslashes($data['date_activite']),
								'info' => addslashes($data['info']),
								'attachement' => addslashes($attachement),
								'id_user' => $return
							);*/
					
					//var_dump($returnCompany);
					//$_SESSION['user'] = $return;
					$data['id_user'] = $return;
					$returnadresse = $user->addUserAdress($data);
				}
			}
		}

		if ($dataReturn['login'] && $dataReturn['login']>0) {
			$user = new user();
			$return = $user->login($data['email'],$data['password']);
			if ($return && $return != 'empty') {
				$_SESSION['user'] = $return;
				goHome();
			}
		}
		return $dataReturn;
	}


	public function updateUserattachement($id,$attachement){
		$DB = Database::getInstance();
        try {
            $sql = "UPDATE `"._DB_PREFIX_."users` SET attachement = '$attachement' WHERE id = $id";
            $DB->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
	}
	public function getByEmail($email)
	{
    $DB = Database::getInstance();
    $query = "SELECT * FROM "._DB_PREFIX_."users WHERE email = '$email'";
    if($res = $DB->query($query))
    {
        if($res->rowCount() >= 1)
        {
            return true;
        }else{
            return false;
        }
    }else{
            return false;
    }
	}

	public function getOrderList($uid){/*$uid*/
		try {
			$DB = Database::getInstance();
			/*$query = "SELECT o.id,o.id_customer,DATE_FORMAT(o.cdate,'%d/%m/%Y') as cdate,o.total_paid,pm.value as 'methode', os.name as 'status'
								FROM orders o, payment_methodes pm,`order_states` os 
								where o.id_customer = $uid and os.id = o.`current_state` and o.`payment_method` = pm.id";*/
			$query = "SELECT * FROM "._DB_PREFIX_."orders WHERE id_customer = $uid";
			//echo $query;
			if($res = $DB->query($query))
	    {
	        if($res->rowCount() > 0)
	        {
	             return $res->fetchAll(PDO::FETCH_ASSOC);
	        }else{
	            return false;
	        }
	    }else{
	            return false;
	    }	
		} catch (Exception $e) {
			echo $e;
			return false;
		}
		
	}

	public function getOrderById($id,$condition){
		try {
				$DB = Database::getInstance();
				$query = "SELECT o.id,o.id_customer,o.cdate,o.total_paid as total,o.address_invoice,o.address_delivery,pm.value as 'methode', os.name as 'status' 
									FROM "._DB_PREFIX_."orders o, "._DB_PREFIX_."payment_methodes pm, "._DB_PREFIX_."order_states os 
									WHERE o.id = $id and os.id = o.`current_state`and o.`payment_method` = pm.id $condition";
				if($res = $DB->query($query)){
	        if($res->rowCount() > 0){
	          return $res->fetch(PDO::FETCH_ASSOC);
	        }else{
	          return false;
	        }
		    }else{
		      return false;
		    }	
				
		}catch (Exception $e) {
			var_dump($e);
			return false;
		}
	}

	public function getProductOrder($id){
		try {
			$DB = Database::getInstance();
			$query = "SELECT od.`product_name` , od.`product_quantity` ,od.`product_price`
								FROM `"._DB_PREFIX_."order_detail` od
								WHERE od.id_order = ".$id;	
			if($res = $DB->query($query)){
        if($res->rowCount() > 0){
          return $res->fetchAll(PDO::FETCH_ASSOC);
        }else{
          return false;
        }
	    }else{
	      return false;
	    }

		} catch (Exception $e) {
			return false;
		}
	}

	public function addUserAdress($data,$uid){
		$dataReturn = array();
		$errorSecurity = array();
		$error = array();
		global $hooks;
		$user = new user();
		$Security = new Security();

		if (!isset($data['firstname']) || empty($data['firstname'])) {
			$error[] = 'Le Nom du propriétaire de l\'address est un champ obligatoir';
		}

		if (!isset($data['lastname']) || empty($data['lastname'])) {
			$error[] = 'Le pronom du propriétaire de l\'address est un champ obligatoir';
		}

		if (!isset($data['addresse']) || empty($data['addresse'])) {
			$error[] = 'L\'adress est un champ obligatoir';
		}

		if (!isset($data['codepostal']) || empty($data['codepostal'])) {
			$error[] = 'Le code postal est un champ obligatoir';
		}

		if (!isset($data['city']) || empty($data['city'])) {
			$error[] = 'La ville est un champ obligatoir';
		}


		if (!isset($data['id_country']) || empty($data['id_country'])) {
			$error[] = 'Le pays est un champ obligatoir';
		}
		else if(!$Security->check_numbers($data['id_country'])){
				$errorSecurity[] = 'problem de pays';
		}
		if (!isset($data['adresse_name']) || empty($data['adresse_name'])) {
			$error[] = 'Le nom de l\'adress est un champ obligatoir';
		}else{
			$condition = " WHERE name = '".$data['adresse_name']."' AND id_user = ".$uid;
			if (isset($data['editAdresse'])) {
				$condition .= " AND id != ".$data['editAdresse'];
			}
			$addresse_name_exist = $hooks->select('addresses',array('*'),$condition);
			if ($addresse_name_exist) {
				$error[] = 'Le nom de l\'adress sont identiques';
			}
		}
		
		if (!isset($data['mobile']) || empty($data['mobile'])) {
				$error[] = 'Le Téléphone portable est un champ obligatoir';
		}

		if (!isset($data['phone']) || empty($data['phone'])) {
			$data['phone'] = "";
		}






		if (!empty($error)) {
			$dataReturn['error'] = $error;
		}else if (!empty($errorSecurity)){
			$dataReturn['errorSecurity'] = $errorSecurity;
		}else{
				$data['id_user'] = $uid;
				if (isset($data['editAdresse'])) {

					if (!$Security->check_numbers($data['editAdresse'])) {
						return false;
					}
					$common = new Common();
					$editdata = array(
						"name" => addslashes($data['adresse_name']),
						"addresse" => addslashes($data['addresse']),
						"firstname" => addslashes($data['firstname']),
						"lastname" => addslashes($data['lastname']),
						"id_country" => $data['id_country'],
						"city" => addslashes($data['city']),
						"codepostal" => addslashes($data['codepostal']),
						"phone" => addslashes($data['phone']),
						"mobile" => addslashes($data['mobile']),
						"info" => addslashes($data['info']),
						"company" => addslashes($data['company']),
					);
					$condition = " WHERE id = ". addslashes($data['editAdresse']);
					$dataReturn['addUserAdress'] = $common->update("addresses",$editdata,$condition);
				}else{
					$dataReturn['addUserAdress'] = $user->addUserAdress($data);
				}
		}
		return $dataReturn;
	}

	public function deleteUserAdress($aid,$uid){
		$common = new Common();
		$condition = " WHERE id = $aid AND id_user = $uid";
		return $common->deleteData("addresses",$condition);
	}

	
	public function editUserInfo($data,$uid){
			
			$dataReturn = array();
			$user = new user();
			$Security = new Security();
			$errorSecurity = array();
			$error = array();

			if (!isset($data['id_gender']) || empty($data['id_gender'])) {
				$error[] = 'Le champ genre est obligatoir';
			}else if(!$Security->check_numbers($data['id_gender'])){
					$errorSecurity[] = 'verifier votre genre';
			}
			if (!isset($data['firstname']) || empty($data['firstname'])) {
				$error[] = 'Le Nom est un champ obligatoir';
			}

			if (!isset($data['lastname']) || empty($data['lastname'])) {
				$error[] = 'Le pronom est un champ obligatoir';
			}


			if (!isset($data['email']) || empty($data['email'])) {
				$error[] = 'L\'email est un champ obligatoir';
			}
			else if(!$Security->check_email($data['email'])){
					$errorSecurity[] = 'Le Format de l\'Adresse email est incorecte';
			}


			if (!isset($data['old_passwd']) || empty($data['old_passwd'])) {
				$error[] = 'Le mot de passe actuell est un champ obligatoir';
			}

			if (isset($data['npassword']) && !empty($data['npassword']) && isset($data['confirmation']) && !empty($data['confirmation'])) {
				if ($data['npassword'] != $data['confirmation']) {
					$error[] = 'Le Nouveau mot de passe et la confirmation ne sont pas identique';
				}else{
					$new_pass = md5($data['npassword']);
				}
			}



			//check birthday 
			$data['birthday'] ="0000-00-00";
			if (isset($data['day']) && !empty($data['day']) && isset($data['month']) && !empty($data['month']) && isset($data['year']) && !empty($data['year'])) {
				if(checkdate($data['month'], $data['day'], $data['year'])){
					$birthday =  $data['year'].'-'.$data['month'].'-'.$data['day'];
					$data['birthday'] = DateTime::createFromFormat('Y-m-d',$birthday)->format('Y-m-d');
				}
			}
		

		if (!empty($error)) {
			$dataReturn['error'] = $error;
		}else if (!empty($errorSecurity)){
			$dataReturn['errorSecurity'] = $errorSecurity;
		}else{
				$data['id_user'] = $uid;
				$common = new Common();
				$editdata = array(
					"id_gender" => $data['id_gender'],
					"email" => $data['email'],
					"first_name" => addslashes($data['firstname']) ,
					"last_name" => addslashes($data['lastname']),
					"birthday" => addslashes($data['birthday'])
				);
				if (isset($new_pass)) {
					$editdata["password"] = addslashes($new_pass);
				}

				$condition = " WHERE id = ".$uid." AND password = md5('".addslashes($data['old_passwd'])."')";
				$dataReturn['editUserInfo'] = $common->update("users",$editdata,$condition);
		}

		return $dataReturn;


	}





}/* ./ account class*/

?>