<?php
	include "../class.DBManager.php";

	$playerNameFiltered = preg_replace('/[^A-Za-z0-9]/', "", $_POST["playerName"]);

	$game = new Game();
	$DBManager = new DBManager();

	$hashGame = $_POST["hash"];
	$hashServer = md5($_POST["game"].$_POST["playerName"].$_POST["score"].$game->hashKey);

	if ($hashGame === $hashServer)
		$DBManager->DisableUser($playerNameFiltered);
	else
		exit ("Hashes no coinciden. Desactivando usuario.");
?>