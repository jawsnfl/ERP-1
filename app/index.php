<?php

	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
		exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	}

	function autoload($class) {
		$paths = explode ( PATH_SEPARATOR, get_include_path () );
		$flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
		$file = strtolower ( str_replace ( "\\", DIRECTORY_SEPARATOR, trim ( $class, "\\" ) ) ) . ".php";
		foreach ( $paths as $path ) {
			$combined = $path . DIRECTORY_SEPARATOR . $file;
			if (file_exists ( $combined )) {
				include ($combined);
				return;
			}
		}
		throw new Exception ( "{$class} not found" );
	}
	class Autoloader {
		public static function autoload($class) {
			autoload ( $class );
		}
	}

	spl_autoload_register ( 'autoload' );
	spl_autoload_register ( array (
			'autoloader',
			'autoload' 
	) );

	require_once( 'bootstrap.php' );