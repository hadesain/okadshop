<?php
//require_once realpath(dirname(__FILE__) . '/..') .'/users/users.class.php';
class Mails
{
	
	public function getHeader($Sender)
	{
		$headers = "From: OkadShop <" . strip_tags($Sender) . ">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		return $headers;
	}

	public function getMessage($Sender,$Receiver,$Subject,$Text){
		$body = '<html>';
		$body .= '<head>';
		$body .= '<title>'.$Subject.'</title>';
		$body .= '<meta charset="UTF-8">';
		$body .= '</head>';
		$body .= '<body>';
		$body .= '<div>';
		$body .= $Text;
		$body .= '</div>';

		return $body;

	}


	public function SendFastMail($Sender,$Receiver,$Subject,$Content){
		//$Users = new user();		
		//$Sender = $Sender;
		//$Receiver = $Users->getEmailByID($Receiver);
		$headers = self::getHeader('no-reply@okadshop.com');
		$message = self::getMessage($Sender,$Receiver,$Subject,$Content);
		if(mail($Receiver,$Subject,$message,$headers))
		{
			return true;
		}else{
			return false;
		}
		
	}

	public function AccountCreated($firstname, $lastname, $email){



		//this::getMessage();
		
		$this->email = $email;
		$this->email_content = 'Bonjour,<br>';
		$this->email_content = 'Félicitation votre compte <a href="http://www.wach.ma">Wach.ma</a> est bien crée.</br>';
		$this->email_content = '-----------------------------------------------';
		$this->email_content .= self::getMailFooter();

	}


	public function getMailFooter()
	{
		$this->text = '<a href="http://www.wach.ma">, site d\'annonces gratuit 100% Marocaine.<br>'; 

		return $this->text;
	}

}
?>