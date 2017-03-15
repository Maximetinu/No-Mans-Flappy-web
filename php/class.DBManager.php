<?php
include "class.Game.php";
include "class.User.php";
class DBManager{
	private $userList;
	private $game;
	private $mysqli;

	/* WWW CONFIG */
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "nomansflappy";

    // USERS TABLE User(username, highscore_a, highscore_b, is_active, IP)

	public function __construct(){
		$this->OpenConnection();
		$this->userList = null;
		$this->game = new Game();
	}

	public function __destruct(){
		$this->CloseConnection();
	}

	/* --- Connections Functions --- */

	private function OpenConnection(){
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->dbname);
		if ($this->mysqli->connect_errno) {
    		exit("Fallo al conectar a MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error);
		}
    }

    private function CloseConnection(){
    	$this->mysqli->close();
    }

    /* ---- ---- ---- ---- ---- ---- */

    /* --- UserList - Functions --- */

    public function GetUserList($a_mode = true){
    	$this->check_userList();
        if ($a_mode == false)
            return $this->OnlyBModeUserList();
        else
    	   return $this->userList;
    }

    // Llamada para mostrar el ranking
    public function GetUserListUntil($i, $a_mode = true){
        $this->check_userList();
        if ($a_mode == false)
            return $this->array_truncate($this->OnlyBModeUserList(),0,$i);
        else
            //return $this->array_truncate($this->userList,0,$i);
            return $this->userList; //////////////////////
    }

    private function OnlyBModeUserList(){
        $userListB = array();
        for ($i = 0; $i <= sizeof($this->userList); $i++)
            if($this->userList[$i]->score_B != 0)
                $userListB[sizeof($userListB)] = $this->userList[$i];
        return $userListB;
    }

    private function array_truncate(array $array, $left, $right) {
    	$array = array_slice($array, $left, count($array) - $left);
    	$array = array_slice($array, 0, count($array) - $right);
    	return $array;
	}

	private function check_userList(){
		if ($this->userList == null)
			exit("Fallo: lista de usuarios vacía"); // COMPORTAMIENTO PREDETERMINADO
	}

    // Llamada para inicializar el marco de trabajo con la lista de usuarios
    public function ChargeUserList($a_mode = true){
        $this->userList = array();
        $query = "SELECT username, highscore_a, highscore_b, is_active FROM Users ORDER BY is_active DESC, highscore_a DESC";
        if (!$a_mode)
            $query = "SELECT username, highscore_a, highscore_b, is_active FROM Users ORDER BY is_active DESC, highscore_b DESC";
        if ($result = $this->mysqli->query($query)) { 
           $cont = 1;
            while($fila = $result->fetch_row()){
                array_push($this->userList,new User($fila[0],$fila[1],$fila[2],$fila[3]));
                $cont++;
            }
        }

    }

    /* ---- ---- ---- ---- ---- ---- */

    /* --- Enable / Disable User --- */

    // public function EnableUser($name){
    // 	$user = $this->FindUserByName($name);
    //     $query = "MODIFICAR (is_enable) = true WHERE USER(name) == $name";
    //     if (!($this->mysqli->query($query))) { 
    //        exit("Fallo al activar usuario");
    //     }
    // }

    // Script: set-highscores-inactives.php
    public function DisableUser($name){
        $query = 'UPDATE Users SET is_active=false WHERE username="'.$name.'"';
        if (!($this->mysqli->query($query))) { 
           exit("Fallo al desactivar usuario");
        }
    }

    /* ---- ---- ---- ---- ---- ---- */

    /* --- UPDATE OR CREATE USER --- */

    // Script: upload-highscore.php
    public function UploadHighscore_a($n, $s){
        $this->UploadHighscore($n, $s);
    }

    public function UploadHighscore($n, $s){
    	if (!$this->CheckIfUserExists($n))
    		$this->AddUserToBD($n, $s);
    	else 
    		$this->UpdateUserScore($n, $s);
    }

    // Script: upload-highscore-b-mode.php
    public function UploadHighscore_b($n, $s){
    	$this->UpdateUserScore_B($n, $s);
    }

    private function CheckIfUserExists($n){
        $query = $this->mysqli->query("SELECT username FROM Users WHERE username='$n'");
        return (($query->num_rows) > 0);
    }

    private function AddUserToBD($n, $s){
        $u = new User($n,$s);
        $query = 'INSERT INTO Users VALUES ("'.$u->name.'",'.$u->score_A.','.$u->score_B.','.$u->is_active.')';
        if (!($this->mysqli->query($query))) { 
           exit("Fallo al añadir usuario");
        }
    }

    private function UpdateUserScore($n, $s){
        $query = 'UPDATE Users SET is_active=true, highscore_a='.$s.' WHERE username="'.$n.'" AND highscore_a<='.$s;
        if (!($this->mysqli->query($query))) { 
           exit("Fallo al subir el highscore");
        }
    }

    private function UpdateUserScore_B($n, $s){
        $query = 'UPDATE Users SET is_active=true, highscore_b='.$s.' WHERE username="'.$n.'" AND highscore_b<='.$s;
        if (!($this->mysqli->query($query))) { 
           exit("Fallo al subir el highscore (B)");
        }
    }

    /* ---- ---- ---- ---- ---- ---- */

    /* ----- COMMUNITY TARGET ----- */

    // Script: unlock-by-community.php
    public function HasCommunityReachedTheTarget(){
        return ($this->GetCommunityCurrentScore() >= $this->game->communityTarget);
    }

    // Llamada para contar la puntuación de la comunidad
    public function GetCommunityCurrentScore(){
        $this->check_userList();
        return $this->sum_highscore_a_of_army();
    }

    // Llamada para mostrar la puntuación objetivo
    public function GetCommunityTarget(){
        return $this->game->communityTarget;
    }

    // Llamada para saber hasta donde hay que mostrar el ránking
    public function GetSizeOfTheArmy(){
        return $this->game->sizeOfTheArmy;
    }

    private function get_user_active_list(){
        $active_users = array();

        for($i=0;$i<=sizeof($this->userList);$i++)
            if($this->userList[$i]->is_active)
                array_push($active_users,$this->userList[$i]);

        return $active_users;
    }

    private function sum_highscore_a_of_army(){
        $sum = 0;

        $users = $this->get_user_active_list();

        $limit = $this->game->sizeOfTheArmy;
        if ($limit > sizeof($users))
            $limit = sizeof($users);

        for ($i = 0; $i<$limit; $i++)
            $sum += $users[$i]->score_A;
        return $sum;
    }

    /* ------ UNIQUE COMPUTER ID -------- */
    // public function UniqueMachineID($salt = "") {
    // if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    //     $temp = sys_get_temp_dir().DIRECTORY_SEPARATOR."diskpartscript.txt";
    //     if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
    //     $output = shell_exec("diskpart /s ".$temp);
    //     $lines = explode("\n",$output);
    //     $result = array_filter($lines,function($line) {
    //         return stripos($line,"ID:")!==false;
    //     });
    //     if(count($result)>0) {
    //         $result = array_shift(array_values($result));
    //         $result = explode(":",$result);
    //         $result = trim(end($result));       
    //     } else $result = $output;       
    // } else {
    //     $result = shell_exec("blkid -o value -s UUID");  
    //     if(stripos($result,"blkid")!==false) {
    //         $result = $_SERVER['HTTP_HOST'];
    //     }
    // }   
    // return md5($salt.md5($result));
    // }
}
?>