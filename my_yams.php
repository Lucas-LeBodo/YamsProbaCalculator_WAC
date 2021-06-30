<?php

$options = getopt('h', ['help']);

if(array_key_exists('h', $options) || array_key_exists('help', $options)){
	return Yams::manYams();
}

class Yams {

    public $args;
    public $params;
	public $groups = ['paire', 'brelan', 'suite', 'full', 'carre', 'yams'];
    public $group;

	public function __construct ($args) {
		$this->args = $args;
		$this->args_Check();
	}

	public static function manYams () {
		echo "\n\nUSAGE :\n php my_yams.php d1 d2 d3 d4 d5 c\n-----\nDESC :\n d1 at d5 -> dice value\n c -> desired combination\n combination list : paire / brelan / carre / full / suite / yams \n-----\nEXEMPLE :\n php my_yams.php 4 3 5 4 1 brelan_4\n\n\n";
	}
    
	public function args_Check () {
		if(count($this->args) !== 6)
			exit("/!\ : Please send 5 values ! \n-----\nuse :  php my_yams.php --help\n\n");

		if(count($this->dice = array_filter(array_slice($this->args, 0, 5), function($values){
			return in_array($values, range(1, 6));
		})) !== 5)
			exit("/!\ : Only correct Value : 1 / 2 / 3 / 4 / 5 / 6 ! \n-----\nuse :  php my_yams.php --help\n\n");

		$group = explode('_', end($this->args));
		if(!in_array($this->group = $group[0], $this->groups))
			exit("/!\ : Combination invalid \n-----\nuse :  php my_yams.php --help\n\n");
		$this->params = array_slice($group, 1);
	}
}

new Yams(array_slice($argv, 1));
