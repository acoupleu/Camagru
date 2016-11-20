<?php

class User
{
	private $user_login;
	private $user_password;
	private $user_email;
	private $user_key;
	private $actif;
	private $reini_key;
	private $reini_done;

	public function __construct($user_login = null, $user_password = null, $user_email = null, $user_key = null, $actif = null, $reini_key = null, $reini_done = null)
	{
		$this->user_login = $user_login;
		$this->user_password = $user_password;
		$this->user_email = $user_email;
		$this->user_key = $user_key;
		$this->actif = $actif;
		$this->reini_key = $reini_key;
		$this->reini_done = $reini_done;
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

	public function getUserKey()
	{
		return $this->user_key;
	}

	public function isUserActif()
	{
		return $this->actif;
	}

	public function getReiniKey()
	{
		return $this->reini_key;
	}

	public function isReiniDone()
	{
		return $this->reini_done;
	}

	public function sendMail()
	{
		$subject = 'Activation de votre compte Camagru';
		$message = 'Bienvenue sur Camagru,' . "\r\n" . 'Pour activer votre compte, veuillez cliquer sur le lien ci dessous ou copier/coller dans votre navigateur internet.'
 					. "\r\n" . "\r\n" . 'http://localhost:8080/Camagru/index.php?p=validation&log=' . urlencode($this->user_login) . '&key=' . urlencode($this->user_key) . "\r\n" . "\r\n"
					. '---------------' . "\r\n" . 'Ceci est un mail automatique, Merci de ne pas y répondre.';
		$message = wordwrap($message, 70, "\r\n");
 		$headers = 'From: acoupleu@student.42.fr' . "\r\n";
		mail($this->user_email, $subject, $message, $headers);
	}

	public function sendResetMail()
	{
		$subject = 'Réinitialisation de votre mot de passe pour votre compte Camagru';
		$message = '
		<html>
		<head>
		<title>Calendrier des anniversaires pour Août</title>
		</head>
		<body>
			<p>Bonjour ' . $this->user_login . ',</p>
			<br />
			<p>Quelqu’un a récemment demandé à réinitialiser votre mot de passe Camagru.</p>
			<a href="http://localhost:8080/Camagru/index.php?p=pwreini&log=' . urlencode($this->user_login) . '&key=' . urlencode($this->user_key) . '">Cliquez ici pour changer votre mot de passe.</a>
			<br />
			<p>---------------</p>
			<p>Ceci est un mail automatique, Merci de ne pas y répondre.</p>
		</body>
		</html>
		';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: acoupleu@student.42.fr' . "\r\n";
		mail($this->user_email, $subject, $message, $headers);
	}
}
?>
