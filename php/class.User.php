<?php
class User{
	public $name;
	public $score_A;
	public $score_B;
	public $is_active;

	public function __construct($n, $s, $sb=0, $is_a=true){
		$this->name = $n;
		$this->score_A = $s;
		$this->score_B = $sb;
		$this->is_active = $is_a;
	}
}
?>