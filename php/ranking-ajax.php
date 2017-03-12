<?php
	include "class.DBManager.php";
	$db = new DBManager();
	$db->ChargeUserList();
?>
<caption id="community-score-caption"
	<?php
		if ($db->HasCommunityReachedTheTarget()){
			echo 'class="target-reached"';
			echo 'tooltip="Endgame reached. Gamemode B unlocked!"';
		}
		else
			echo'tooltip="This is the community score. When all of you reach the target together, gamemode B will unlock"';
	?>
flow="right" >
	<?php
		echo $db->GetCommunityCurrentScore();
		echo "/";
		echo $db->GetCommunityTarget();
	?>
</caption>
<thead>
	<tr>
		<th>Position</th>
		<th>Name</th>
		<th>Score</th>
	</tr>
</thead>
<tbody id="ranking-body">
	<?php
		for($i=1;$i<=sizeof($db->GetUserList()) && $i<=$db->GetSizeOfTheArmy();$i++){
			echo "<tr";
			if (!$db->GetUserList()[$i-1]->is_active)
				echo ' class="tr-inactive"';
			echo ">";
				echo "<td>";
					echo $i;
				echo "</td>";
				echo "<td>";
					echo $db->GetUserList()[$i-1]->name;
				echo "</td>";
				echo "<td>";
					echo $db->GetUserList()[$i-1]->score_A;
				echo "</td>";
			echo "</tr>";
		}
	?>
</tbody>