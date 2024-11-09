<?php
//Const Color
if( PHP_OS_FAMILY == "Linux" ){
	define("n","\n");
	define("d","\033[0m");
	define("m","\033[1;31m");
	define("h","\033[1;32m");
	define("k","\033[1;33m");
	define("b","\033[1;34m");
	define("u","\033[1;35m");
	define("c","\033[1;36m");
	define("p","\033[1;37m");
	define("mp","\033[101m\033[1;37m");
	define("hp","\033[102m\033[1;30m");
	define("kp","\033[103m\033[1;37m");
	define("bp","\033[104m\033[1;37m");
	define("up","\033[105m\033[1;37m");
	define("cp","\033[106m\033[1;37m");
	define("pm","\033[107m\033[1;31m");
	define("ph","\033[107m\033[1;32m");
	define("pk","\033[107m\033[1;33m");
	define("pb","\033[107m\033[1;34m");
	define("pu","\033[107m\033[1;35m");
	define("pc","\033[107m\033[1;36m");
} else {
	define("n","\n");
	define("d","\033[0m");
	define("m","");
	define("h","");
	define("k","");
	define("b","");
	define("u","");
	define("c","");
	define("p","");
	define("mp","");
	define("hp","");
	define("kp","");
	define("bp","");
	define("up","");
	define("cp","");
	define("pm","");
	define("ph","");
	define("pk","");
	define("pb","");
	define("pu","");
	define("pc","");
}

spl_autoload_register(function($class){
	$dirs = [
		'Functions'
	];
	
	$class = explode('\\', $class);
	$class = end($class);
	foreach ($dirs as $dir) {
		if($dir == '.' || $dir == '..') continue;
		if(file_exists("App/$dir/$class.php")){
			require_once "App/$dir/$class.php";
			return;
		}
	}
});