<?php
	include "../class.DBManager.php";
	$dbManager = new DBManager();
	$dbManager->ChargeUserList();
	echo ($dbManager->HasCommunityReachedTheTarget());
?>