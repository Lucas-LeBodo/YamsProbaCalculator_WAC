<?php

$options = getopt('h', ['help']);

if(array_key_exists('h', $options) || array_key_exists('help', $options)){
	return Yams::manYams();
}

class Yams {

	public static function manYams () {
		echo "\n\nUSAGE :\n php my_yams.php d1 d2 d3 d4 d5 c\n-----\nDESC :\n d1 at d5 -> dice value\n c -> desired combination\n combination list : paire / brelan / carre / full / suite / yams \n-----\nEXEMPLE :\n php my_yams.php 4 3 5 4 1 brelan_4\n\n\n";
	}
    

}

new Yams();
