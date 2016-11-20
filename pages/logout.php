<?php
if (isset($_SESSION["connect"]) && isset($_SESSION["username"])) {
	unset($_SESSION["connect"]);
	unset($_SESSION["username"]);
}
header('Location: index.php');
?>
