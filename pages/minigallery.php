<?php
session_start();
include '../config/db_connection.php';
include '../config/Article.php';
include '../config/database.php';

$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$table = $bdd->prepare("SELECT photo FROM photos WHERE user_login=? ORDER BY date_creation DESC LIMIT 10", array($_SESSION["username"]), Article);
$bdd = null;
$arraylen = count($table);
for($i = 0; $i < $arraylen; $i++)
{
	if (($i % 2) == 0)
	{
		$tableau .= '<tr>';
	}
	$tableau .= '<td class="minigal">' . $table[$i]->getImage() . '</td>';
	if (($i % 2) == 1 || $i == ($arraylen - 1))
	{
		$tableau .= '</tr>';
	}
}
echo $tableau;
?>
