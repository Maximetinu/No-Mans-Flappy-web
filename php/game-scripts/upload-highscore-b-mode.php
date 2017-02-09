<?php
	include "../class.DBManager.php";

	$game = new Game();
	$DBManager = new DBManager();

	$playerNameFiltered = preg_replace('/[^A-Za-z0-9]/', "", $_POST["playerName"]);

	$hashGame = $_POST["hash"];
	$hashServer = md5($_POST["game"].$_POST["playerName"].$_POST["score"].$game->hashKey);

	if ($hashGame === $hashServer)
		$DBManager->UploadHighscore_b($playerNameFiltered,$_POST["score"]);
	else
		exit ("Hashes no coinciden. Upload B.");
?>