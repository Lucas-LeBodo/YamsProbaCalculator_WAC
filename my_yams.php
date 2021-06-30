<?php

$options = getopt('h', ['help']);

if(array_key_exists('h', $options) || array_key_exists('help', $options)){
	return Yams::manYams();
}

class Yams {

	public $args;
    public $params;
	public $groups = ['paire', 'brelan', 'suite', 'full', 'carre', 'yams'];
	public $dice = [];
    public $rolls = 0;
	public $perms = [];
    public $group;

	public function __construct ($args) {
		$this->args = $args;
		$this->args_Check();
		$this->result();
	}

	public function Loop ($numbers) {
        for($i = 1; $i < 7; $i ++){
            if($numbers === 1){ 
                $this->perms[] = [$i];
            }else{
                for($ii = 1; $ii < 7; $ii ++){
                    if($numbers === 2){
                        $this->perms[] = [$i, $ii];
                    }else{
                        for($iii = 1; $iii < 7; $iii ++){
                            if($numbers === 3){
                                $this->perms[] = [$i, $ii, $iii];
                            }else{
                                for($iiii = 1; $iiii < 7; $iiii ++){
                                    if($numbers === 4){
                                        $this->perms[] = [$i, $ii, $iii, $iiii];
                                    }else{
                                        for($iiiii = 1; $iiiii < 7; $iiiii ++){
                                            if($numbers === 5){
                                                $this->perms[] = [$i, $ii, $iii, $iiii, $iiiii];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function Loop_Check (Closure $filterFunc) {
		return count(array_filter($this->perms, $filterFunc)) / pow(6, $this->rolls) * 100;
	}

	public function result () {
		if(in_array($this->group, ['paire', 'brelan', 'carre', 'yams'])){
			$save = @array_count_values($this->dice)[$this->params[0]] ?: 0;
			$win_result =  ['paire' => 2, 'brelan' => 3, 'carre' => 4, 'yams' => 5][$this->group] - $save;
			
			if($win_result <= 0)
				return $this->displayResult(100);

			$filterFunc = function($value) use($win_result){
				return @array_count_values($value)[$this->params[0]] >= $win_result;
			};
		}
		$this->rolls = 5 - $save;
		$this->Loop($this->rolls);
		$this->displayResult($this->Loop_Check($filterFunc));
	}

	

	public function displayResult ($value) {	
		echo number_format($value, 2)."%\n";
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
