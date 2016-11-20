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

	public function getPDO()
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

	public function query($statement, $class_name = null, $one = false)
	{
		$req = $this->getPDO()->query($statement);
		if (strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0
			|| strpos($statement, 'DELETE') === 0 || strpos($statement, 'CREATE') === 0)
		{
			return $req;
		}
		if ($class_name === null)
		{
			$req->setFetchMode(PDO::FETCH_OBJ);
		}
		else
		{
			$req->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class_name);
		}
		if ($one)
		{
			$datas = $req->fetch();
		}
		else
		{
			$datas = $req->fetchAll();
		}
		return $datas;
	}

	public function prepare($statement, $attributes, $class_name = null, $one = false)
	{
		$req = $this->getPDO()->prepare($statement);
		$res = $req->execute($attributes);
		if (strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0
			|| strpos($statement, 'DELETE') === 0 || strpos($statement, 'CREATE') === 0)
		{
			return $res;
		}
		if ($class_name === null)
		{
			$req->setFetchMode(PDO::FETCH_OBJ);
		}
		else
		{
			$req->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class_name);
		}
		if ($one)
		{
			$datas = $req->fetch();
		}
		else
		{
			$datas = $req->fetchAll();
		}
		return $datas;
	}
}

?>
