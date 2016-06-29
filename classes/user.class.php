<?php
class user
{
	private $m_id;
	private $m_firstname;
	private $m_lastname;
	private $m_mail;
	private $m_pwd;
	private $sexe;
    private $day;
    private $month;
    private $year;
    private $birthday;
	
	private $logged_in = false;
								
	public function __construct()
	{
		//echo 11;
            //$DB = Database::getInstance();
	}


    public function getUsersGroup(){
        try {
        $DB = Database::getInstance();
        $sql = "SELECT * FROM `"._DB_PREFIX_."users_groups` WHERE `slug` not like '%admin%'";
        $res = $DB->query($sql);
        $res = $res->fetchAll(PDO::FETCH_ASSOC);
        return $res;
      } catch (Exception $e) {
        return false;
      }
    }
    public function addUserAdress($data){
        foreach ($data as $key => $value) {
            $data[$key] = addslashes($value);
        }
        $DB = Database::getInstance();
        try {
            $data["ip"] = get_client_ip_country();
            $sql = "INSERT INTO `"._DB_PREFIX_."addresses`(`name`, `addresse`, `id_user`, `firstname`, `lastname`, `id_country`, `city`, `codepostal`, `phone`, `mobile`,`ip`, `info`,company,`cdate` ) 
            VALUES ('".$data["adresse_name"]."','".$data["addresse"]."',".$data["id_user"].",'".$data["firstname"]."','".$data["lastname"]."',".$data["id_country"].",'".$data["city"]."','".$data["codepostal"]."','".$data["phone"]."','".$data["mobile"]."','".$data["ip"]."','".$data["info"]."','".$data["company"]."', now())";
            $DB->query($sql);
            return $DB->lastInsertId("id");
        } catch (Exception $e) {
            return false;
        }
    }
    public function getUserAdresse($uid,$aid = null){
        try {
        $DB = Database::getInstance();
        if ($aid != null) {
          $condition = ' AND a.id = '.$aid;
        }else{
            $condition =' ORDER BY id ASC';
        }
        $sql = "SELECT a.*,c.name as country FROM "._DB_PREFIX_."addresses a, "._DB_PREFIX_."countries c WHERE a.`id_country` =  c.`id` AND id_user = $uid $condition";
        $res = $DB->query($sql);
        if ($aid == null) {
            $res = $res->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $res = $res->fetch(PDO::FETCH_ASSOC);
        }
       
        return $res;
      } catch (Exception $e) {
        return false;
      }
    }
    // Function to get the client ip address
    function get_client_ip_env() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }
    public function addNewUser($data)
    {

        $DB = Database::getInstance();
        try {
            $ip = self::get_client_ip_env();
            $sql = "INSERT INTO `"._DB_PREFIX_."users`(`id_gender`, `email`, `password`, `first_name`, `last_name`, `phone`, `mobile`, `city`, `id_country`, `birthday`, `id_group`, `active`,`cdate`)  
                    VALUES (".$data["id_gender"].",'".$data["email"]."',MD5('".$data["password"]."'),'".$data["firstname"]."','".$data["lastname"]."','".$data["phone"]."','".$data["mobile"]."','".$data["city"]."',".$data["id_country"].",'".$data["birthday"]."',1,'actived', now())";
            $DB->query($sql);
            return $DB->lastInsertId("id");
        } catch (Exception $e) {
            echo $e;
            return false;
        }
        
    }
    public function addUserCompany($data){
        //$DB = Database::getInstance();
        try {
            $Common = new Common();
            $res = $Common->save('user_company',$data);
            if ($res) {
                return $$res;
            }
           /* $sql = "INSERT INTO `user_company`(`id_user`,`company`, `activite`, `siret_tva`, `website`, `attachement`, `date_activite`, `info`, `cdate`) 
                    VALUES (".$data["id_user"].", '".$data["company"]."','".$data["activite"]."','".$data["siret_tva"]."','".$data["website"]."','".$data["attachement"]."','".$data["date_activite"]."','".$data["info"]."',now())";
            $DB->query($sql);
            return $DB->lastInsertId("id");*/
        } catch (Exception $e) {
            return false;
        }
         return false;
    }
    public static function getAllCountry()
    {
      try {
        $DB = Database::getInstance();
        $sql = "SELECT name,id,iso_code FROM "._DB_PREFIX_."countries order by name asc";
        $res = $DB->query($sql);
        $res = $res->fetchAll(PDO::FETCH_ASSOC);
        return $res;
      } catch (Exception $e) {
        return false;
      }
        
    }
    public function getCurrentUser(){
       try {
        if (isset($_SESSION['user'])) {
          $DB = Database::getInstance();
          $sql = "SELECT u.`id` as uid ,u.`id_group`,u.`id_gender`,u.`email`,u.`first_name`,u.`last_name`,u.`active`,u.`birthday`,uc.*, a.`addresse` ,a.`id_country` ,a.`city`,a.`codepostal`,a.`phone`,a.`mobile`,a.`ip` FROM ("._DB_PREFIX_."users u LEFT JOIN "._DB_PREFIX_."user_company uc ON u.id = uc.id_user) LEFT JOIN  "._DB_PREFIX_."addresses a ON u.id = a.`id_user` where u.`id` = ".$_SESSION['user'];
          $res = $DB->query($sql);
          $res = $res->fetch(PDO::FETCH_ASSOC);
          return $res;
        }else 
          return false;
      } catch (Exception $e) {
        return false;
      }
    }
	
	public function __set($c,$v)
	{
		if($c == "m_mail" AND !user::userExist("user_mail = '".$v."'"))
			$this->{$c} = $v;
		else if($c == "m_pwd")
			$this->{$c} = md5($v);
		else if($c != "m_mail" and $c != "m_pwd")
			$this->{$c} = $v;
	}
        
	public static function delete(&$objet)
	{
		if($GLOBALS['DB']->exec("DELETE FROM "._DB_PREFIX_."user WHERE user_id = '".$objet->m_id ."' ;"))
		{
			$objet = null;
			return true;
		}
		else
			return false;
	}

	public static function getByID($user)
	{
            $DB = Database::getInstance();
            $query = "SELECT * FROM "._DB_PREFIX_."users WHERE id = $user";
            
            if($res = $DB->query($query))
            {
                if($res->rowCount() == 1)
                {
                    $row = $res->fetch();
                    //var_dump($row);
                    return array('Username'=>$row['username']);
                }
            }
	}
    public static function getEmailByID($user)
    {
            $DB = Database::getInstance();
            $query = "SELECT email FROM "._DB_PREFIX_."users WHERE id = $user";
            if($res = $DB->query($query))
            {
                if($res->rowCount() == 1)
                {
                    $row = $res->fetch();
                    return $row['email'];
                }
            }
    }    
	public static function getByEmail($email)
	{
        $DB = Database::getInstance();
        $query = "SELECT * FROM "._DB_PREFIX_."users WHERE email = '$email'";
        if($res = $DB->query($query))
        {
            if($res->rowCount() == 1)
            {
                return true;
            }else{
                return false;
            }
        }else{
                return false;
        }
	}
	public static function UList()
    {
       $DB = Database::getInstance();
        $query = "SELECT * FROM "._DB_PREFIX_."users";
        if($res = $DB->query($query))
        {
            $res->fetchAll();
            return;
        }
    }

    public function changeUserPassword($email,$password){
       try {
            $DB = Database::getInstance();
            $query = "UPDATE "._DB_PREFIX_."users set  password = '$password' WHERE email = '$email'";
            $DB->query($query);
            return true;
       } catch (Exception $e) {
            return false;
       }
    }

	public static function login($email,$password)
	{
            $email = addslashes($email);
            $password = addslashes($password);
            $DB = Database::getInstance();
            $password = md5($password);
            try
            {
                $query = "SELECT id FROM "._DB_PREFIX_."users WHERE email = '$email' AND password = '$password' and active = 'actived'";
                if($res = $DB->query($query))
                {
                    if($res->rowCount() > 0)
                    {
                        $row = $res->fetch();
                        return $row['id'];
                    }else{
                        return 'empty';
                    }

                }else {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                return false;
            }
	}
	
	public static function userExist($condition)
	{
		try
		{
			if($res = $GLOBALS['DB']->query("SELECT * FROM "._DB_PREFIX_."user WHERE ".$condition." ;"))
			{
				if($res->rowCount() >= 1)
				{
					$row = $res->fetchAll();
					return user::getByID($row[0]['id']);
				}
				else
					return false;
			}
			else
				return false;
		}
		catch(PDOException $e)
		{
			$e->getMessage();
			return false;
		}
	}

    public static function getCurrentUserName()
    {
        $CUser = self::getByID($_SESSION['user']);
        echo 'Hello '.$CUser['Username'];
    }
	
	public static function controlConnection($user,$ip_client)
	{
		if($user = user::userExist("user_mail = '".$user->m_mail ."' AND user_pwd = '".$user->m_pwd ."' AND user_ip = '".$ip_client."' AND type_user_id <> '0' "))
			return $user;
		else
			return false;
	}
	
	// My Custom method
    public function create($UType,$Username,$Email,$PWD) 
    {
            $DB = Database::getInstance();
            $Security = new Security();
//            die($_POST['email']);
                $this->UType = $UType;//$_POST['prenom'];
                $this->Username = $Username;//$_POST['nom'];
 
                $this->Email = $Email;//$_POST['email'];
                $this->PWD = md5($PWD/*$_POST['password']*/);

                
                $this->sexe = 0;//$_POST['sexe'];

                /*
                $this->day = $_POST['day'];
                $this->month = $_POST['month'];
                $this->year = $_POST['year'];
                if($Security->check_numbers($this->day) && $Security->check_numbers($this->month) && $Security->check_numbers($this->year))
                {
                    $this->birthday = $this->year.'-'.$this->month.'-'.$this->day;
                }else{
                    die('birthday error');
                }
                */
                /*
		if($this->sexe == 'Homme')
        {
            $this->sexe = 1;
        }elseif($this->sexe == 'Femme')
        {
            $this->sexe = 1;
        }else{
            die('sexe error');
        }
        */
        if($this->getByEmail($this->m_mail))
        {
            die('une compte existe li&eacute;  avec cet email existe d&eacute;j&agrave;');
        }

            
            $sql = "INSERT INTO "._DB_PREFIX_."users (username,type,email,password,cdate) VALUES(:type,:username,:email,:password,now())";
            //echo $sql;
            $sth = $DB->prepare($sql);
            
            $sth->bindParam(':type', $this->UType);
            $sth->bindParam(':username', $this->Username);
            $sth->bindParam(':email', $this->Email);
            $sth->bindParam(':password', $this->PWD);
            
            //note we can't add a user several times so we need to add try catch and see what the return because if user is duplicated its not inserting.
            if(!empty($this->Email))
            {
				try {
                    $sth->execute();
					if($DB->lastInsertId("id") > 0)
					{
                        $_SESSION['user'] = $DB->lastInsertId("id");
                        //if(true) you need to create session and just reload page to show information of user subscribed


                        /*
                        $headers  = "Reply-To: contact <contact@gridinc.fr>\r\n"; 
                        $headers .= "Return-Path: contact@gridinc.fr <contact@gridinc.fr>\r\n"; 
                        $headers .= "From: Grid <contact@".$_SERVER['HTTP_HOST'].">\r\n"; 


                        $headers .= "Content-type: text/html\r\n";
                        $headers .= "Organization: grid.cool\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

                        $subject = "Bienvenu ".$this->m_firstname;
                        
                        $Message = "<center>".$this->m_firstname.",<br><br>";

                        $Message .= 'Nous avons le plaisir de vous accueillir sur grid.<br>';
                        $Message .= 'Vous pouvez désormais vous connecter sur <a href="http://grid.cool" target="_blank">grid.cool</a>.<br>';
                        $Message .= 'Bienvenu dans le monde des personnes actives !<br>';
                        $Message .= '<br><br><br></center>';
                        $Message .= '<p style="text-align:left">email: '.$this->m_mail.'<br>mot de passe: '.$this->m_pwd.'</p><br>';
                        $Message .= 'Voici un petit récapitulatif pour mieux vous éclairer à propos de notre projet:<br><br>';
                        $Message .= 'Grid connecte les personnes à travers des échanges utiles à la réflexion et au développement de son activité.<br><br>';
                        $Message .= 'Comment ça marche ?<br><br>';

                        $Message .= 'Vous choisissez votre activité et le lieu où vous l’exercez.<br>';
                        $Message .= 'Vous pouvez ensuite commencer à écrire des articles très complets (un titre, un à propos, 10 images, 10 paragraphes) et composer l’ordre d’apparition de ces médias avec une dragtool.<br>';
                        $Message .= 'Une fois publié, l’article atterri dans un flux d’actualité où sont regroupés tous les articles des utilisateurs. Ce flux d’actualité va pouvoir ensuite se diviser en dizaines de milliers de flux plus ou moins précis grâce à un outil de filtre.<br>';
                        $Message .= 'L’utilisateur choisit de visiter le flux d\'articles qu’il souhaite.<br><br>';

                        $Message .= '<i>exemples:</i><br><br>';

                        $Message .= 'Professionnel -> Ingénieur -> Paris -> France<br>';
                        $Message .= 'S’afficheront les articles des ingénieurs de paris.<br>';
                        $Message .= 'Professionnel -> Ingénieur -> Tous -> Tous<br>';
                        $Message .= 'S’afficheront les articles des ingénieurs du monde entier.<br>';
                        $Message .= 'Ceci pour toutes les activités existantes et tous les lieux du globe.<br><br>';
                        $Message .= 'Amusez-vous bien et n’hésitez pas à nous contacter à propos de n’importe quel sujet !<br><br>';
                        $Message .= 'L’équipe<br><br>';
                        $Message .= '<hr><br>';
                        $Message .= '<a href="http://grid.cool" target="_blank">grid.cool</a> - be part of the active*<br><br>';


                        if(mail($this->Email, $subject, $Message, $headers))
                        {
                            return 'sent';
                        }else{
                            return 'not sent';
                        }
                        */




                        return true;	
					}else{
						return false;
					}

				} catch (Exception $e) {
		                    echo $e->getMessage();
		                    echo $e->getLine();
		                    return false;
				}

            }else{
                    //show this message (Erreur : nous pouvons pas cr&eacute;er votre compte! veuillez verifier les champs obligatoires)
                    return false;
            }
	}
	
	public static function contact($mail) {
		
		$to = $mail['to'];
		$subject = $mail['subject'];
		$message = $mail['message'];
		$headers = $mail['headers'];
		
		if ( mail($to, $subject, $message, $headers) ) {
			return true;
		} else {
			return 0;
		}
	}
	/*
	public static function connected() {
		
		if ( isset($_SESSION['user']) ) {
			return $_SESSION['user'];
		} else {
			return false;
		}
	}
    */
	
	public function full_name() {
		return strtoupper($this->m_firstname).' '.strtoupper($this->m_lastname);
	}
	
	public static function logout()
    {
        session_destroy();
        echo '<script>window.location.href = "Home";</script>';
        return true;
            
	}
        /*****************************/
        
        public static function getUserJob($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT jobs.name as name FROM users_jobs join jobs on (jobs.id = users_jobs.id_job) WHERE users_jobs.id_user=$user and users_jobs.deleted = 0;";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }
        public static function getUserJobId($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT jobs.id FROM "._DB_PREFIX_."users_jobs join jobs on (jobs.id = users_jobs.id_job) WHERE users_jobs.id_user=$user and users_jobs.deleted = 0;";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['id'] != null)
                {
                    return $result['id'];
                }else{
                    return '';
                }
            }
        }


        public static function getUserEducation($user)
        {
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "select id,name from educations where id =(SELECT id_education from users_educations where id_user=$user order by id desc limit 1)";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }

        public static function getUserEducationId($user)
        {
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "select id from educations where id =(SELECT id_education from users_educations where id_user=$user order by id desc limit 1)";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['id'] != null)
                {
                    return $result['id'];
                }else{
                    return '';
                }
            }
        }

        public static function getUserCity($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT cities.name as name FROM "._DB_PREFIX_."cities join "._DB_PREFIX_."users_cities on ("._DB_PREFIX_."cities.id = "._DB_PREFIX_."users_cities.id_city) WHERE "._DB_PREFIX_."users_cities.id_user=$user and "._DB_PREFIX_."users_cities.deleted=0 order by users_cities.id desc ";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }
        public static function getUserCityId($user){
            /*
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT cities.id FROM cities join users_cities on (cities.id = users_cities.id_city) WHERE users_cities.id_user=$user and users_cities.deleted=0 order by users_cities.id desc";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['id'] != null)
                {
                    return $result['id'];
                }else{
                    return '';
                }
            }
            */
        }


        public static function getUserCountry($user)
        {
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT countries.name as name,countries.id as id FROM "._DB_PREFIX_."countries join "._DB_PREFIX_."users_countries on ("._DB_PREFIX_."countries.id = "._DB_PREFIX_."users_countries.id_country) WHERE "._DB_PREFIX_."users_countries.id_user=$user  order by "._DB_PREFIX_."users_countries.id desc";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }
        public static function getUserCountryId($user)
        {
            /*
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT countries.id FROM countries join users_countries on (countries.id = users_countries.id_country) WHERE users_countries.id_user=$user  order by users_countries.id desc";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['id'] != null)
                {
                    return $result['id'];
                }else{
                    return '';
                }
            }
            */
        }

        public static function getUserSubscription($user){
            return '2013-20-21';
        }
        public static function getDefaultPicture($user){
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $DB = Database::getInstance();
                $sql = "select link from "._DB_PREFIX_."profile_pictures where id_user =$user and `default` = 1";
//                echo $sql;
                $query3=$DB->query($sql);
                $ImageRES=$query3->fetch(PDO::FETCH_ASSOC);
                if(file_exists($ImageRES['link']))
                {
                    return $ImageRES['link'];
                }else{
                    return 'images/avatar/default.png';
                }
            }
        }
        public static function getUserCityCountry($user){
            if(self::getUserCountry($user) != '')
            {
                return self::getUserCity($user).', '.self::getUserCountry($user);       
            }else{
                return self::getUserCity($user);  
            }
        }
        public static function getUserFirstLastName($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT first_name as fname,last_name as lname FROM "._DB_PREFIX_."users where id = $user";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['fname'] != null)
                {
                    return ucfirst($result['fname']).' '.ucfirst($result['lname']);
                }else{
                    return '';
                }
            }
        }
        public static function getUserFirstName($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT first_name as name FROM "._DB_PREFIX_."users where id = $user";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }
        public static function getUserLastName($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT username as name FROM "._DB_PREFIX_."users where id = $user";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }


        public static function getUserType($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT type FROM "._DB_PREFIX_."users where id = $user";
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['type'] != null)
                {
                    return $result['type'];
                }else{
                    return '';
                }
            }
        }

        public static function dateOfSubscription($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT cdate as date FROM "._DB_PREFIX_."users where id = $user";
                //echo $sql;
                $query = $DB->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['date'] != null)
                {
                    return $result['date'];
                }else{
                    return '';
                }
            }
        }
        // verify if the user is new
        public static function newUser($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT id FROM "._DB_PREFIX_."users where DATE(cdate) = DATE(NOW()) and id = $user";
                //echo $sql;
                if($res = $DB->query($sql))
                {
                    if($res->rowCount() == 1)
                    {
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
        }

}
?>