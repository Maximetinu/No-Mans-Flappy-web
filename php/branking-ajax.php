<?php
	include_once "class.DBManager.php";
	$db = new DBManager();
	$db->ChargeUserList();
?>
<span class="b-ranking">Gamemode B Ranking</span>
<thead>
	<tr>
		<th>Position</th>
		<th>Name</th>
		<th>Score</th>
	</tr>
</thead>
<tbody id="ranking-body">
	<?php
		for($i=1;$i<=sizeof($db->GetUserList(false)) && $i<=$db->GetSizeOfTheArmy();$i++){
			echo "<tr";
			if (!$db->GetUserList(false)[$i-1]->is_active)
				echo ' class="tr-inactive"';
			echo ">";
				echo "<td>";
					echo $i;
				echo "</td>";
				echo "<td>";
					echo $db->GetUserList(false)[$i-1]->name;
				echo "</td>";
				echo "<td>";
					echo $db->GetUserList(false)[$i-1]->score_B;
				echo "</td>";
			echo "</tr>";
		}
	?>
</tbody>