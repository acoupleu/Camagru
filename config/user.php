<?php

class User
{
	public function __construct($user_login = 'null', $user_password = 'null', $user_email = 'null')
	{
		$this->user_login = $user_login;
		$this->user_password = $user_password;
		$this->user_email = $user_email;
	}

	public function getUserName()
	{
		return $this->user_login;
	}

	public function getUserPass()
	{
		return $this->user_password;
	}

	public function getUserMail()
	{
		return $this->user_email;
	}

	public function sendMail()
	{
		$subject = 'le sujet';
 		$message = "Tu peux me faire un virement de 500€ sur mon compte ? Par contre n'en parle pas a la famille.";
 		$headers = 'From: fabrebernard@icloud.com' . "\r\n";
		mail($this->user_email, $subject, $message, $headers);
	}
}
?>
