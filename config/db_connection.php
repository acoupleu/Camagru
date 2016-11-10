<?php

class Database
{
	private $DB_DSN;
	private $DB_USER;
	private $DB_PASSWORD;
	private $bdd;

	public function __construct($DB_DSN, $DB_USER, $DB_PASSWORD)
	{
		$this->DB_DSN = $DB_DSN;
		$this->DB_USER = $DB_USER;
		$this->DB_PASSWORD = $DB_PASSWORD;
	}

	private function getPDO()
	{
		if ($this->bdd == null)
		{
			try
			{
				$bdd = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASSWORD);
				$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->bdd = $bdd;
			}
			catch (Exception $error)
			{
				die('Erreur : ' . $error->getMessage());
			}
		}
		return $this->bdd;
	}

	public function query($statement, $class_name)
	{
		$datas = null;
		$req = $this->getPDO()->query($statement);
		if ($class_name !== null)
		{
			$datas = $req->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class_name);
		}
		return $datas;
	}
}

?>
