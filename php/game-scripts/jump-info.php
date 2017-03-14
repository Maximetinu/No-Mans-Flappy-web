<?php
	include "../class.Game.php";
	$game = new Game();
	$jump = $game->jump;
	$jumpRate = $game->jumpRate;
	echo $jump; echo ","; echo $jumpRate;
?>